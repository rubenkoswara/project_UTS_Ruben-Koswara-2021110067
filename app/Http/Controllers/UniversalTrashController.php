<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
                $query = $modelClass::onlyTrashed();
                if ($type === 'Order') {
                    $query->with('user');
                }
                
                $items = $query->get();

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
            case 'Product':
                return $item->name ?? 'Produk ID: ' . $item->id;
            case 'User':
                return $item->name ?? 'User: ' . ($item->email ?? $item->id);
            case 'Category':
                return $item->name ?? 'Kategori ID: ' . $item->id;
            case 'Order':
                $userName = $item->user->name ?? 'User Tidak Dikenal';
                return 'Order ID: ' . $item->id . ' oleh ' . $userName . ' (Tanggal: ' . $item->created_at?->toDateString() . ')';
            case 'PaymentMethod':
                return $item->name ?? 'Metode Pembayaran ID: ' . $item->id;
            case 'ShippingService':
                return $item->name ?? 'Layanan Pengiriman ID: ' . $item->id;
            case 'OrderItem':
                return 'Item Pesanan ID: ' . $item->id . ' (Order: ' . $item->order_id . ')';
            default:
                return $item->name ?? $item->title ?? $modelType . ' ID: ' . $item->id;
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
            try {
                DB::beginTransaction();

                $item->restore();
                DB::commit();

                return back()->with('success', "Item " . Str::title($modelType) . " berhasil dikembalikan.");

            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', "Gagal mengembalikan item " . Str::title($modelType) . ": " . $e->getMessage());
            }
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
            $readableName = $this->getReadableName($item, $modelType);

            try {
                if ($modelType === 'Product') {
                    if (!empty($item->image)) { 
                        Storage::disk('public')->delete($item->image);
                    }
                }
                
                $item->forceDelete();

                return back()->with('success', "Item '" . $readableName . "' berhasil dihapus PERMANEN.");
            } catch (\Exception $e) {
                return back()->with('error', "Gagal menghapus item " . Str::title($modelType) . " secara permanen.");
            }
        }

        return back()->with('error', "Item " . Str::title($modelType) . " tidak ditemukan di tempat sampah.");
    }
}
