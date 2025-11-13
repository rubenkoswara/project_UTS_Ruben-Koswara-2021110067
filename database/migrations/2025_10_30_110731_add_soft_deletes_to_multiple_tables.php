<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\ShippingService;
use App\Models\OrderItem;
use App\Models\Order;

class UniversalTrashController extends Controller
{
    protected $softDeleteModels = [
        'User' => User::class,
        'Product' => Product::class,
        'Category' => Category::class,
        'PaymentMethod' => PaymentMethod::class,
        'ShippingService' => ShippingService::class,
        'OrderItem' => OrderItem::class,
        'Order' => Order::class,
    ];

    public function index()
    {
        $trashedItems = collect();

        foreach ($this->softDeleteModels as $type => $modelClass) {
            if (class_exists($modelClass)) {
                $items = $modelClass::onlyTrashed()->get();

                $items->each(function ($item) use ($type, &$trashedItems) {
                    if (empty($item->id)) {
                        return;
                    }
                    
                    $item->modelType = $type;
                    $item->readableName = $this->getReadableName($item, $type);

                    $trashedItems->push($item);
                });
            }
        }
        
        $trashedItems = $trashedItems->sortByDesc('deleted_at');

        return view('admin.universal_trash', [
            'trashedItems' => $trashedItems,
        ]);
    }

    protected function getReadableName($item, $modelType)
    {
        switch ($modelType) {
            case 'User':
                return $item->name ?? $item->email ?? 'User ID: ' . $item->id;
            
            case 'Product':
                return $item->name ?? 'Produk ID: ' . $item->id;
                
            case 'Category':
                return $item->name ?? 'Kategori ID: ' . $item->id;
                
            case 'Order':
                return 'Order ID: ' . $item->id . ' (Dibuat: ' . $item->created_at?->toDateString() . ')';
                
            case 'PaymentMethod':
                return $item->name ?? 'Metode Pembayaran ID: ' . $item->id;
            
            case 'ShippingService':
                return $item->name ?? 'Layanan Pengiriman ID: ' . $item->id;

            case 'OrderItem':
                return 'Item Order ID: ' . $item->id . ' (Order: ' . ($item->order_id ?? 'N/A') . ')';

            default:
                return $item->name ?? $item->title ?? 'Item ' . $modelType . ' ID: ' . $item->id;
        }
    }


    public function restore($modelType, $id)
    {
        $modelClass = $this->softDeleteModels[$modelType] ?? null;

        if (!$modelClass) {
            return back()->with('error', 'Jenis model tidak valid: ' . Str::title($modelType));
        }
        
        $item = $modelClass::withTrashed()->find($id);

        if ($item && $item->trashed()) {
            $item->restore();
            return back()->with('success', "Item " . Str::title($modelType) . " berhasil dikembalikan.");
        }

        return back()->with('error', "Item " . Str::title($modelType) . " tidak ditemukan atau belum dihapus.");
    }
    
    public function forceDelete($modelType, $id)
    {
        $modelClass = $this->softDeleteModels[$modelType] ?? null;

        if (!$modelClass) {
            return back()->with('error', 'Jenis model tidak valid: ' . Str::title($modelType));
        }
        
        $item = $modelClass::onlyTrashed()->find($id);

        if ($item) {
            $item->forceDelete();
            return back()->with('success', "Item " . Str::title($modelType) . " berhasil dihapus PERMANEN.");
        }

        return back()->with('error', "Item " . Str::title($modelType) . " tidak ditemukan di tempat sampah.");
    }
}
