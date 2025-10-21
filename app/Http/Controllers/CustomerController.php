<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection; // Import Collection

class CustomerController extends Controller
{
    /**
     * Data produk dummy yang lebih lengkap.
     * Harga disajikan sebagai integer untuk perhitungan yang akurat.
     */
    private function getProductData(): Collection
    {
        $products = [
            // Kategori: Aquarium (Aquarium)
            ['id' => 1, 'name' => 'Aquarium Mini 10L', 'price' => 150000, 'category' => 'Aquarium', 'stock' => 15, 'description' => 'Aquarium kaca tebal, cocok untuk ikan hias kecil.', 'rating' => 4.5, 'reviews' => 12, 'image_url' => 'https://picsum.photos/400/300?random=1'],
            ['id' => 5, 'name' => 'Aquarium Set 60cm', 'price' => 450000, 'category' => 'Aquarium', 'stock' => 5, 'description' => 'Satu set lengkap dengan tutup dan lampu LED. Ideal untuk pemula.', 'rating' => 4.8, 'reviews' => 20, 'image_url' => 'https://picsum.photos/400/300?random=5'],
            
            // Kategori: Filter (Filter)
            ['id' => 2, 'name' => 'Filter Gantung External', 'price' => 55000, 'category' => 'Filter', 'stock' => 22, 'description' => 'Filter eksternal yang ringkas dan efisien untuk tank kecil.', 'rating' => 4.2, 'reviews' => 35, 'image_url' => 'https://picsum.photos/400/300?random=2'],
            ['id' => 6, 'name' => 'Canister Filter Pro 1200L/H', 'price' => 850000, 'category' => 'Filter', 'stock' => 8, 'description' => 'Filter eksternal bertenaga besar untuk tank di atas 100 liter.', 'rating' => 4.9, 'reviews' => 10, 'image_url' => 'https://picsum.photos/400/300?random=6'],
            ['id' => 107, 'name' => 'Media Bio Ring Keramik (500gr)', 'price' => 60000, 'category' => 'Filter', 'stock' => 45, 'description' => 'Media rumah bakteri berkualitas tinggi untuk filter biologis.', 'rating' => 4.7, 'reviews' => 30, 'image_url' => 'https://picsum.photos/400/300?random=107'],

            // Kategori: Pakan (Pakan)
            ['id' => 3, 'name' => 'Pakan Ikan Premium (100gr)', 'price' => 30000, 'category' => 'Pakan', 'stock' => 50, 'description' => 'Pelet apung yang kaya protein dan spirulina untuk meningkatkan warna.', 'rating' => 4.7, 'reviews' => 50, 'image_url' => 'https://picsum.photos/400/300?random=3'],
            ['id' => 112, 'name' => 'Pakan Udang Hias (Pelet Tenggelam)', 'price' => 40000, 'category' => 'Pakan', 'stock' => 35, 'description' => 'Pakan khusus untuk udang hias. Diperkaya kalsium.', 'rating' => 4.8, 'reviews' => 15, 'image_url' => 'https://picsum.photos/400/300?random=112'],

            // Kategori: Aksesoris (Aksesoris)
            ['id' => 4, 'name' => 'Pompa Udara Silent', 'price' => 45000, 'category' => 'Aksesoris', 'stock' => 10, 'description' => 'Aerator tanpa suara, ideal untuk diletakkan di kamar tidur.', 'rating' => 4.6, 'reviews' => 25, 'image_url' => 'https://picsum.photos/400/300?random=4'],
            ['id' => 7, 'name' => 'Heater Otomatis 100W', 'price' => 65000, 'category' => 'Aksesoris', 'stock' => 18, 'description' => 'Pemanas air otomatis untuk menjaga suhu stabil di 25°C.', 'rating' => 4.5, 'reviews' => 18, 'image_url' => 'https://picsum.photos/400/300?random=7'],
            ['id' => 102, 'name' => 'Lampu LED Aquascape 40cm RGB', 'price' => 180000, 'category' => 'Aksesoris', 'stock' => 15, 'description' => 'Lampu full spectrum untuk pertumbuhan tanaman air.', 'rating' => 4.9, 'reviews' => 40, 'image_url' => 'https://picsum.photos/400/300?random=102'],
            ['id' => 114, 'name' => 'Pasir Silika Putih (1 Kg)', 'price' => 25000, 'category' => 'Aksesoris', 'stock' => 85, 'description' => 'Substrat dasar yang aman dan estetis untuk aquascape.', 'rating' => 4.4, 'reviews' => 60, 'image_url' => 'https://picsum.photos/400/300?random=114'],
            ['id' => 116, 'name' => 'Tanaman Air Anubias Nana Pot', 'price' => 70000, 'category' => 'Aksesoris', 'stock' => 20, 'description' => 'Tanaman aquascape low-light yang sangat mudah dirawat.', 'rating' => 4.8, 'reviews' => 35, 'image_url' => 'https://picsum.photos/400/300?random=116'],
            ['id' => 117, 'name' => 'Siphon Pembersih Kotoran', 'price' => 65000, 'category' => 'Aksesoris', 'stock' => 28, 'description' => 'Alat untuk menyedot kotoran (gravel cleaner) dan mengganti air.', 'rating' => 4.3, 'reviews' => 20, 'image_url' => 'https://picsum.photos/400/300?random=117'],
        ];

        return collect($products);
    }

    /**
     * Helper untuk memformat angka menjadi mata uang Rupiah.
     */
    private function formatRupiah(int $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    // -----------------------------------------------------------------------------

    /**
     * 1. Home / Katalog Produk (dengan Filter Kategori)
     */
    public function index(Request $request)
    {
        $all_products = $this->getProductData();
        
        // Ambil kategori dari data produk dan pastikan unik
        $categories = $all_products->pluck('category')->unique()->values()->all();
        array_unshift($categories, 'Semua'); // Tambahkan 'Semua' di awal

        $filter_category = $request->get('category');
        $products = $all_products;

        // Logika filtering menggunakan Collection
        if ($filter_category && strtolower($filter_category) !== 'semua') {
            $products = $all_products->filter(function($product) use ($filter_category) {
                return strtolower($product['category']) === strtolower($filter_category);
            });
        }
        
        // Format harga produk untuk ditampilkan di view
        $products = $products->map(function ($product) {
            $product['price_formatted'] = $this->formatRupiah($product['price']);
            return $product;
        });

        return view('customer.home', [
            'products' => $products,
            'categories' => $categories,
            'filter_category' => $filter_category
        ]);
    }

    /**
     * 2. Detail Produk
     */
    public function productDetail($id)
    {
        $product = $this->getProductData()->firstWhere('id', (int)$id);
        
        if (!$product) {
            abort(404, 'Produk tidak ditemukan.');
        }

        // Format harga di detail produk
        $product['price_formatted'] = $this->formatRupiah($product['price']);
        
        return view('customer.product_detail', compact('product'));
    }

    /**
     * 3. Keranjang Belanja
     */
    public function cart()
    {
        // Data keranjang dummy (menggunakan produk dari daftar lengkap)
        $cart_items_data = [
            ['name' => 'Aquarium Mini 10L', 'qty' => 1, 'price' => 150000, 'subtotal' => 150000],
            ['name' => 'Filter Gantung External', 'qty' => 2, 'price' => 55000, 'subtotal' => 110000],
            ['name' => 'Lampu LED Aquascape 40cm RGB', 'qty' => 1, 'price' => 180000, 'subtotal' => 180000],
        ];
        
        $total = collect($cart_items_data)->sum('subtotal'); // Total: 440000
        $total_formatted = $this->formatRupiah($total);

        // Format harga item untuk view
        $cart_items = collect($cart_items_data)->map(function ($item) {
            $item['price_formatted'] = $this->formatRupiah($item['price']);
            $item['subtotal_formatted'] = $this->formatRupiah($item['subtotal']);
            return $item;
        });
        
        return view('customer.cart', [
            'cart_items' => $cart_items, 
            'total' => $total_formatted
        ]);
    }

    /**
     * 4. Checkout (Menampilkan ringkasan pesanan sebelum pembayaran)
     */
    public function checkout()
    {
        // Data Keranjang/Produk Dummy (diambil dari Cart)
        $cart_items_data = [
            ['name' => 'Aquarium Mini 10L', 'price' => 150000, 'quantity' => 1, 'subtotal' => 150000],
            ['name' => 'Filter Gantung External', 'price' => 55000, 'quantity' => 2, 'subtotal' => 110000],
            ['name' => 'Lampu LED Aquascape 40cm RGB', 'price' => 180000, 'quantity' => 1, 'subtotal' => 180000],
        ];

        $grand_total = collect($cart_items_data)->sum('subtotal'); // Total: 440000
        
        // Format harga item untuk view checkout
        $cart_items = collect($cart_items_data)->map(function ($item) {
            $item['price_formatted'] = $this->formatRupiah($item['price']);
            $item['subtotal_formatted'] = $this->formatRupiah($item['subtotal']);
            return $item;
        });
        
        // Data Alamat Dummy
        $shipping_data = [
            'name' => 'Nama Customer Dummy',
            'address' => 'Jl. Laragon No. 10, Bandung'
        ];
        
        // Data Ringkasan Pesanan
        $order_data = ['id' => 'ORD-' . rand(100, 999), 'total_formatted' => $this->formatRupiah($grand_total)];

        return view('customer.checkout', compact('cart_items', 'shipping_data', 'grand_total', 'order_data'));
    }

    /**
     * 4b. Instruksi Pembayaran & Upload Bukti
     */
    public function paymentInstruction()
    {
        $grand_total = 440000; // Total dari checkout sebelumnya
        
        // Data yang dikirim ke halaman instruksi
        $order_data = [
            'id' => 'ORD-003',
            'total' => $grand_total, 
            'total_formatted' => $this->formatRupiah($grand_total),
            'due_date' => Carbon::now()->addHours(24)->format('Y-m-d H:i'),
            'payment_methods' => [
                'BCA' => [
                    'name' => 'Bank Central Asia',
                    'account_name' => 'PT Renesca Aquatic',
                    'account_number' => '123-456-7890 (Kode Bank: 014)',
                    'notes' => 'Transfer dari bank manapun (ada biaya admin).',
                ],
                'GOPAY' => [
                    'name' => 'GoPay (Virtual Account)',
                    'account_name' => 'Ruben Koswara (Customer Service)',
                    'account_number' => '0812-3456-7890',
                    'notes' => 'Tujuan pembayaran adalah nomor ini. Pastikan nama penerima cocok.',
                ],
                'DANA' => [
                    'name' => 'DANA (Virtual Account)',
                    'account_name' => 'Ruben Koswara (Customer Service)',
                    'account_number' => '0878-9012-3456',
                    'notes' => 'Pembayaran via DANA akan diverifikasi otomatis setelah sukses.',
                ],
            ]
        ];
        return view('customer.payment_instruction', compact('order_data'));
    }

    /**
     * 5. Daftar Pesanan Customer
     */
    public function orders()
    {
        $orders = collect([
            ['id' => 'ORD-001', 'date' => '2025-10-10', 'total' => 260000, 'status' => 'Dikirim'],
            ['id' => 'ORD-002', 'date' => '2025-10-05', 'total' => 440000, 'status' => 'Selesai'],
        ])->map(function ($order) {
            $order['total_formatted'] = $this->formatRupiah($order['total']);
            return $order;
        });

        return view('customer.orders', compact('orders'));
    }

    /**
     * 6. Detail Pesanan Customer
     */
    public function orderDetail($id)
    {
        // Data items dummy
        $items_dummy = [
            ['product_name' => 'Aquarium Mini 10L', 'price' => 150000, 'quantity' => 1, 'subtotal' => 150000],
            ['product_name' => 'Filter Gantung External', 'price' => 55000, 'quantity' => 2, 'subtotal' => 110000],
        ];

        $total = collect($items_dummy)->sum('subtotal');
        
        // Format item harga
        $items_formatted = collect($items_dummy)->map(function ($item) {
            $item['price_formatted'] = $this->formatRupiah($item['price']);
            $item['subtotal_formatted'] = $this->formatRupiah($item['subtotal']);
            return (object)$item; // Kembalikan sebagai object
        });
        
        // Data Pesanan lengkap yang diperlukan view
        $order = (object)[
            'id' => $id, 
            'status' => 'Dikirim', 
            'payment_method' => 'Transfer Bank', 
            'total_amount' => $total,
            'total_formatted' => $this->formatRupiah($total),
            'shipping_address' => 'Jl. Laragon No. 10, Kota Bandung, Jawa Barat (Kode Pos: 40286)',
            'created_at' => Carbon::parse('2025-10-20 10:30:00'),
            'items' => $items_formatted,
            'payment_proof_url' => 'https://placehold.co/400x400/000000/FFFFFF/png?text=Bukti+Transfer' 
        ];

        return view('customer.order_detail', compact('order'));
    }
}