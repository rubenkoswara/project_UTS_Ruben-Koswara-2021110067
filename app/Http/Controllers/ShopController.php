<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingService;
use App\Models\PaymentMethod;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $filter_category_slug = $request->query('category');

        $query = Product::with('category');

        if ($filter_category_slug && $filter_category_slug !== 'semua') {
            $query->whereHas('category', function ($q) use ($filter_category_slug) {
                $q->where('slug', $filter_category_slug);
            });
        }

        $products = $query->where('stock', '>', 0)
                            ->orderBy('name')
                            ->get()
                            ->map(function ($product) {
                                $product->formatted_price = 'Rp ' . number_format($product->price, 0, ',', '.');
                                return $product;
                            });

        $categories = Category::select('name', 'slug')->orderBy('name')->get();

        return view('shop.index', [
            'products' => $products,
            'categories' => $categories,
            'filter_category_slug' => $filter_category_slug,
        ]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        try {
            $this->cartService->add($product, $request->quantity);
            return redirect()->back()->with('success', $product->name . ' berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function viewCart()
    {
        $cart = $this->cartService->get();
        
        $shippingServices = ShippingService::where('is_active', true)->get();
        
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('shop.cart', compact('cart', 'shippingServices', 'paymentMethods'));
    }

    public function updateCart(Request $request)
    {
        if ($request->has('remove')) {
            $product = Product::findOrFail($request->product_id);
            $this->cartService->remove($product->id);
            return redirect()->route('shop.viewCart')->with('success', $product->name . ' berhasil dihapus dari keranjang.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $this->cartService->updateQuantity($request->product_id, $request->quantity);
            return redirect()->route('shop.viewCart')->with('success', 'Kuantitas berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('shop.viewCart')->with('error', $e->getMessage());
        }
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melakukan checkout.');
        }

        $cartData = $this->cartService->get();

        if (empty($cartData['items'])) {
            return redirect()->route('shop.viewCart')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $validPaymentMethods = PaymentMethod::where('is_active', true)->pluck('code')->toArray();
        $paymentMethodRule = 'required|string|in:' . implode(',', $validPaymentMethods);

        $request->validate([
            'shipping_service_code' => 'required|exists:shipping_services,code',
            'payment_method' => $paymentMethodRule,
            'shipping_address' => 'required|string|min:10',
        ]);
        
        $shippingService = ShippingService::where('code', $request->shipping_service_code)->first();
        $paymentMethodData = PaymentMethod::where('code', $request->payment_method)->first();


        $shippingCost = 25000; 

        DB::beginTransaction();

        try {
            $user = Auth::user();
            
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $cartData['subtotal'],
                'shipping_cost' => $shippingCost,
                'grand_total' => $cartData['subtotal'] + $shippingCost,
                'status' => 'pending_payment',
                'shipping_address' => $request->shipping_address,
                'payment_method' => $paymentMethodData->name,
                'shipping_service' => $shippingService->name,
                'payment_proof_url' => null,
                'payment_method_id' => $paymentMethodData->id ?? null,
            ]);

            foreach ($cartData['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'price' => $item['product']->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
                
                $product = Product::find($item['product']->id);
                $product->stock -= $item['quantity'];
                $product->save();
            }

            $this->cartService->clear();

            DB::commit();

            return redirect()->route('shop.thankYou', $order->id)->with('success', 'Order berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('shop.viewCart')->with('error', 'Gagal memproses order. Silakan coba lagi. Error: ' . $e->getMessage());
        }
    }

    public function thankYou(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $order->load('items.product'); 
        return view('shop.thank_you', compact('order'));
    }

    public function myOrders()
    {
        // FIX: Menambahkan Eager Loading untuk mencegah error "Call to a member function first() on null" di view history
        $orders = auth()->user()->orders()->with(['items.product'])->latest()->get(); 
        return view('shop.orders.history', compact('orders'));
    }

    public function myOrderDetail($id)
    {
        // Eager Loading sudah benar
        $order = auth()->user()->orders()->with('items.product')->findOrFail($id); 
        return view('shop.orders.detail', compact('order'));
    }


    public function cancelMyOrder($id)
    {
        // FIX: Implementasi fungsi ini mengatasi "Call to undefined method ShopController::cancelOrder()"
        $order = auth()->user()->orders()->with('items')->findOrFail($id);

        if ($order->status === 'pending_payment' || $order->status === 'processing') {
            
            DB::beginTransaction();

            try {

                $order->update(['status' => 'cancelled']);

                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->stock += $item->quantity;
                        $product->save();
                    }
                }
                
                DB::commit();
                return redirect()->route('shop.myOrders')->with('success', 'Pesanan berhasil dibatalkan dan stok produk telah dikembalikan.');

            } catch (\Exception $e) {
                DB::rollBack();

                Log::error("Order Cancellation Failed: " . $e->getMessage(), ['order_id' => $id, 'user_id' => Auth::id()]);
                
                return redirect()->back()->with('error', 'Gagal membatalkan pesanan. Terjadi kesalahan sistem. Silakan coba lagi.');
            }
        }

        return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan karena statusnya sudah `' . $order->status . '`.');
    }
}