<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected $sessionKey = 'shopping_cart';

    public function get(): array
    {
        $items = Session::get($this->sessionKey, []);
        $subtotal = 0;

        foreach ($items as $item) {
            $subtotal += $item['subtotal'];
        }

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'formatted_subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
            'total_items' => count($items),
        ];
    }

    public function add(Product $product, int $quantity): void
    {
        $items = Session::get($this->sessionKey, []);
        
        $itemKey = $product->id;
        
        if ($quantity > $product->stock) {
             throw new \Exception("Kuantitas melebihi stok yang tersedia ({$product->stock}).");
        }

        if (isset($items[$itemKey])) {
            $items[$itemKey]['quantity'] += $quantity;
            if ($items[$itemKey]['quantity'] > $product->stock) {
                 $items[$itemKey]['quantity'] -= $quantity;
                 throw new \Exception("Penambahan kuantitas melebihi stok maksimal ({$product->stock}).");
            }
        } else {
            $items[$itemKey] = [
                'product' => $product,
                'quantity' => $quantity,
            ];
        }

        $items[$itemKey]['subtotal'] = $items[$itemKey]['quantity'] * $product->price;
        $items[$itemKey]['formatted_price'] = 'Rp ' . number_format($product->price, 0, ',', '.');
        $items[$itemKey]['formatted_subtotal'] = 'Rp ' . number_format($items[$itemKey]['subtotal'], 0, ',', '.');

        Session::put($this->sessionKey, $items);
    }
    
    public function updateQuantity(int $productId, int $quantity): void
    {
        $items = Session::get($this->sessionKey, []);
        
        if (isset($items[$productId])) {
            $product = $items[$productId]['product'];

            if ($quantity > $product->stock) {
                 throw new \Exception("Kuantitas melebihi stok yang tersedia ({$product->stock}).");
            }

            $items[$productId]['quantity'] = $quantity;
            $items[$productId]['subtotal'] = $quantity * $product->price;
            $items[$productId]['formatted_subtotal'] = 'Rp ' . number_format($items[$productId]['subtotal'], 0, ',', '.');
            
            Session::put($this->sessionKey, $items);
        }
    }

    public function remove(int $productId): void
    {
        $items = Session::get($this->sessionKey, []);
        if (isset($items[$productId])) {
            unset($items[$productId]);
            Session::put($this->sessionKey, $items);
        }
    }

    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }
}
