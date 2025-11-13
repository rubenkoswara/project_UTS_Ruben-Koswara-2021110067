<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->input('status');
        $search = $request->input('search');

        $query = Order::with('user');

        if ($status && $status !== 'All') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                if (is_numeric($search)) {
                    $q->orWhere('id', $search);
                }
                $q->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%');
                });
            });
        }
        
        $orders = $query->latest()->paginate(10);

        return view('admin.orders.index', compact('orders', 'status', 'search'));
    }

    public function show($id): View
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        
        $statuses = [
            'Pending' => 'bg-yellow-100 text-yellow-800', 
            'Processed' => 'bg-blue-100 text-blue-800',
            'Shipped' => 'bg-indigo-100 text-indigo-800',
            'Completed' => 'bg-green-100 text-green-800',
            'Cancelled' => 'bg-red-100 text-red-800'
        ];

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processed,Shipped,Completed,Cancelled',
        ]);

        $newStatus = $request->input('status');
        $oldStatus = $order->status;
        
        $shouldRestoreStock = ($newStatus === 'Cancelled' && $oldStatus !== 'Cancelled');
        $isRestoringFromCancellation = ($oldStatus === 'Cancelled' && $newStatus !== 'Cancelled');

        if ($isRestoringFromCancellation) {
            return redirect()->route('admin.orders.show', $order->id)
                             ->with('error', 'Tidak dapat mengubah pesanan dari status "Cancelled" ke status lain.');
        }

        try {
            DB::beginTransaction();

            $order->status = $newStatus;
            $order->save();

            if ($shouldRestoreStock) {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $product = $item->product;
                        $product->stock += $item->quantity;
                        $product->save();
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.orders.show', $order->id)
                             ->with('success', 'Status pesanan berhasil diperbarui' . ($shouldRestoreStock ? ' dan stok produk telah dikembalikan.' : '.'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.orders.show', $order->id)
                             ->with('error', 'Gagal memperbarui status dan mengelola stok. Silakan coba lagi.');
        }
    }
}
