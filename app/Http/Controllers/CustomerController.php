<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection; // Import Collection

class CustomerController extends Controller
{
    /**
     * Data produk dummy yang lebih lengkap dan berjumlah 19 item.
     * Harga disajikan sebagai integer untuk perhitungan yang akurat.
     */
    private function getProductData(): Collection
    {
        $products = [
            // Kategori: Aquarium (Aquarium) - 2 Produk
            ['id' => 1, 'name' => 'Aquarium Mini 10L', 'price' => 150000, 'category' => 'Aquarium', 'stock' => 15, 'description' => 'Aquarium kaca tebal, cocok untuk ikan hias kecil.', 'rating' => 4.5, 'reviews' => 12, 'image_url' => 'https://dennerle.com/cdn/shop/files/10L.png?v=1728150327'],
            ['id' => 5, 'name' => 'Aquarium Set 60cm', 'price' => 450000, 'category' => 'Aquarium', 'stock' => 5, 'description' => 'Satu set lengkap dengan tutup dan lampu LED. Ideal untuk pemula.', 'rating' => 4.8, 'reviews' => 20, 'image_url' => 'https://media.karousell.com/media/photos/products/2025/4/26/dijual_aquarium_boyu_lengkap_d_1745633969_5ee04560_thumbnail.jpg'],

            // Kategori: Filter (Filter) - 5 Produk
            ['id' => 2, 'name' => 'Filter Gantung External', 'price' => 55000, 'category' => 'Filter', 'stock' => 22, 'description' => 'Filter eksternal yang ringkas dan efisien untuk tank kecil.', 'rating' => 4.2, 'reviews' => 35, 'image_url' => 'https://image.made-in-china.com/202f0j00oZScKlEdSDqk/Low-Noise-Adjustable-Fish-Tank-Filter-External-Hang-on-Aquarium-Filter.webp'],
            ['id' => 6, 'name' => 'Canister Filter Pro 1200L/H', 'price' => 850000, 'category' => 'Filter', 'stock' => 8, 'description' => 'Filter eksternal bertenaga besar untuk tank di atas 100 liter.', 'rating' => 4.9, 'reviews' => 10, 'image_url' => 'https://www.finest-filters.co.uk/media/catalog/product/cache/58d33529443d8a6d4895ea8ee1cb76f6/h/i/hidom_external_filter_ex-1200.jpeg'],
            ['id' => 107, 'name' => 'Media Bio Ring Keramik (500gr)', 'price' => 60000, 'category' => 'Filter', 'stock' => 45, 'description' => 'Media rumah bakteri berkualitas tinggi untuk filter biologis.', 'rating' => 4.7, 'reviews' => 30, 'image_url' => 'https://img.lazcdn.com/g/p/1f3308226c8983c1a2afd199caa4e821.jpg_720x720q80.jpg'],
            ['id' => 106, 'name' => 'Internal Filter Power Head 800L/H', 'price' => 75000, 'category' => 'Filter', 'stock' => 18, 'description' => 'Filter celup bertenaga tinggi untuk akuarium ukuran sedang.', 'rating' => 4.4, 'reviews' => 15, 'image_url' => 'https://m.media-amazon.com/images/I/61OPtPgcXzL._UF894,1000_QL80_.jpg'],
            ['id' => 108, 'name' => 'Selang Aerator Set (5 meter)', 'price' => 15000, 'category' => 'Filter', 'stock' => 110, 'description' => 'Selang dan batu aerasi lengkap, sangat fleksibel.', 'rating' => 4.1, 'reviews' => 55, 'image_url' => 'https://bibitbunga.com/wp-content/uploads/2018/11/Selang-Aerator-Pompa-Udara-untuk-Aquarium-Aquascape-Hidroponik-1-meter.jpg'],

            // Kategori: Pakan (Pakan) - 3 Produk
            ['id' => 3, 'name' => 'Pakan Ikan Premium (100gr)', 'price' => 30000, 'category' => 'Pakan', 'stock' => 50, 'description' => 'Pelet apung yang kaya protein dan spirulina untuk meningkatkan warna.', 'rating' => 4.7, 'reviews' => 50, 'image_url' => 'https://makassarhobi.com/wp-content/uploads/2020/04/i1uxLPP74PhO1Fq6zF09n97J.jpg'],
            ['id' => 112, 'name' => 'Pakan Udang Hias (Pelet Tenggelam)', 'price' => 40000, 'category' => 'Pakan', 'stock' => 35, 'description' => 'Pakan khusus untuk udang hias. Diperkaya kalsium.', 'rating' => 4.8, 'reviews' => 15, 'image_url' => 'https://down-id.img.susercontent.com/file/0e01128deef79f6bc0544821504e2863'],
            ['id' => 111, 'name' => 'Obat Anti Jamur Ikan (60ml)', 'price' => 20000, 'category' => 'Pakan', 'stock' => 50, 'description' => 'Mengobati penyakit jamur dan kembung pada ikan hias.', 'rating' => 4.6, 'reviews' => 40, 'image_url' => 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//109/MTA-8609499/raid_all_raid_all_anti_ich_obat_pencegah_dan_mengobati_jamur_white_spot_aquarium_kolam_ikan_ad01704_full01_c9hlganf.jpg'],

            // Kategori: Aksesoris (Aksesoris) - 9 Produk (TOTAL 19 PRODUK)
            ['id' => 4, 'name' => 'Pompa Udara Silent', 'price' => 45000, 'category' => 'Aksesoris', 'stock' => 10, 'description' => 'Aerator tanpa suara, ideal untuk diletakkan di kamar tidur.', 'rating' => 4.6, 'reviews' => 25, 'image_url' => 'https://images.tokopedia.net/img/cache/700/aphluv/1997/1/1/3fd2c63376e144febe693e523b3f8500~.jpeg'],
            ['id' => 7, 'name' => 'Heater Otomatis 100W', 'price' => 65000, 'category' => 'Aksesoris', 'stock' => 18, 'description' => 'Pemanas air otomatis untuk menjaga suhu stabil di 25°C.', 'rating' => 4.5, 'reviews' => 18, 'image_url' => 'https://makassarhobi.com/wp-content/uploads/2020/04/Lb1RrON.jpg'],
            ['id' => 102, 'name' => 'Lampu LED Aquascape 40cm RGB', 'price' => 180000, 'category' => 'Aksesoris', 'stock' => 15, 'description' => 'Lampu full spectrum untuk pertumbuhan tanaman air.', 'rating' => 4.9, 'reviews' => 40, 'image_url' => 'https://makassarhobi.com/wp-content/uploads/2021/02/rug-1613015372566-0.jpeg.jpg'],
            ['id' => 109, 'name' => 'Lampu UV Sterilizer Celup 5W', 'price' => 95000, 'category' => 'Aksesoris', 'stock' => 12, 'description' => 'Membunuh alga dan patogen berbahaya di air akuarium.', 'rating' => 4.3, 'reviews' => 28, 'image_url' => 'https://laz-img-sg.alicdn.com/p/3230038a1d234f65bd5cea497c73dce1.jpg'],
            ['id' => 114, 'name' => 'Pasir Silika Putih (1 Kg)', 'price' => 25000, 'category' => 'Aksesoris', 'stock' => 85, 'description' => 'Substrat dasar yang aman dan estetis untuk aquascape.', 'rating' => 4.4, 'reviews' => 60, 'image_url' => 'https://makassarhobi.com/wp-content/uploads/2020/04/zITEzsLcvLWE2iS2sLMWFuGU.jpg'],
            ['id' => 115, 'name' => 'Batu Lava Rock Merah (1 Kg)', 'price' => 38000, 'category' => 'Aksesoris', 'stock' => 40, 'description' => 'Dekorasi alami dan rumah bakteri yang ideal.', 'rating' => 4.7, 'reviews' => 22, 'image_url' => 'https://makassarhobi.com/wp-content/uploads/2020/04/ZcNYaJxjqotYek7joliASxc5.jpg'],
            ['id' => 116, 'name' => 'Tanaman Air Anubias Nana Pot', 'price' => 70000, 'category' => 'Aksesoris', 'stock' => 20, 'description' => 'Tanaman aquascape low-light yang sangat mudah dirawat.', 'rating' => 4.8, 'reviews' => 35, 'image_url' => 'https://www.sikumis.com/media/frontend/products/ANUBIAS-NANA-GOLD.jpg'],
            ['id' => 117, 'name' => 'Siphon Pembersih Kotoran', 'price' => 65000, 'category' => 'Aksesoris', 'stock' => 28, 'description' => 'Alat untuk menyedot kotoran (gravel cleaner) dan mengganti air.', 'rating' => 4.3, 'reviews' => 20, 'image_url' => 'https://i5.walmartimages.com/asr/dbc51096-d830-4250-9193-c2ca6fe33671.8fd410d1f4ba29de5f6d50af59faf6ed.jpeg'],
            ['id' => 119, 'name' => 'Termometer Digital LCD', 'price' => 40000, 'category' => 'Aksesoris', 'stock' => 33, 'description' => 'Pengukur suhu akuarium dengan akurasi tinggi.', 'rating' => 4.5, 'reviews' => 19, 'image_url' => 'https://images-cdn.ubuy.com.sa/658e2ae2e0d0877cf7551629-luxshiny-water-temperature-measuring.jpg'],
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
        $product_data = $this->getProductData();

        $cart_items_raw = [
            // id: 1
            ['id' => 1, 'qty' => 1, 'price' => 150000],
            // id: 2
            ['id' => 2, 'qty' => 2, 'price' => 55000],
            // id: 102
            ['id' => 102, 'qty' => 1, 'price' => 180000],
        ];

        $cart_items = collect($cart_items_raw)->map(function ($item) use ($product_data) {
            $product = $product_data->firstWhere('id', $item['id']);
            $subtotal = $item['qty'] * $product['price'];

            return [
                'name' => $product['name'],
                'qty' => $item['qty'],
                'quantity' => $item['qty'], // Ditambahkan untuk konsistensi dengan view checkout
                'price' => $product['price'],
                'subtotal' => $subtotal,
                'price_formatted' => $this->formatRupiah($product['price']),
                'subtotal_formatted' => $this->formatRupiah($subtotal),
            ];
        });

        $total = $cart_items->sum('subtotal');
        $total_formatted = $this->formatRupiah($total);

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
        // Ambil data dari cart() untuk konsistensi
        $cart_data = $this->cart()->getData();
        $cart_items = $cart_data['cart_items']; // Ini sudah terformat
        $grand_total_formatted = $cart_data['total'];

        // Hitung grand_total integer dari item untuk perhitungan
        $grand_total = $cart_items->sum(function($item) {
            return $item['subtotal'];
        });

        // Data Alamat Dummy
        $shipping_data = [
            'name' => 'Nama Customer Dummy',
            'address' => 'Jl. Laragon No. 10, Bandung'
        ];

        // Data Ringkasan Pesanan
        $order_data = [
            'id' => 'ORD-' . rand(100, 999),
            'total_formatted' => $grand_total_formatted
        ];

        return view('customer.checkout', compact('cart_items', 'shipping_data', 'grand_total', 'order_data'));
    }

    /**
     * 4b. Instruksi Pembayaran & Upload Bukti
     */
    public function paymentInstruction()
    {
        // Menggunakan total dari cart/checkout (440000)
        $grand_total = 440000;

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
            // ID harus unik dan konsisten untuk detail order
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
        // Cari order total yang sesuai dengan ID dummy
        $orders_summary = $this->orders()->getData()['orders'];
        $order_total = $orders_summary->firstWhere('id', $id)['total'] ?? 260000; // Default jika ID tidak ditemukan

        // Data items dummy untuk ORD-001 (Total: 260000)
        if ($id === 'ORD-001') {
            $items_dummy = [
                ['product_name' => 'Aquarium Mini 10L', 'price' => 150000, 'quantity' => 1],
                ['product_name' => 'Pakan Udang Hias', 'price' => 40000, 'quantity' => 1],
                ['product_name' => 'Filter Gantung External', 'price' => 55000, 'quantity' => 1],
            ];
        }
        // Data items dummy untuk ORD-002 (Total: 440000 - Sesuai Cart)
        elseif ($id === 'ORD-002') {
            $items_dummy = [
                ['product_name' => 'Aquarium Mini 10L', 'price' => 150000, 'quantity' => 1],
                ['product_name' => 'Filter Gantung External', 'price' => 55000, 'quantity' => 2],
                ['product_name' => 'Lampu LED Aquascape 40cm RGB', 'price' => 180000, 'quantity' => 1],
            ];
        }
        // Default items
        else {
            $items_dummy = [
                ['product_name' => 'Produk Default', 'price' => 100000, 'quantity' => 1],
                ['product_name' => 'Produk Kedua', 'price' => 50000, 'quantity' => 1],
            ];
        }

        $items_formatted = collect($items_dummy)->map(function ($item) {
            $item['subtotal'] = $item['price'] * $item['quantity'];
            $item['price_formatted'] = $this->formatRupiah($item['price']);
            $item['subtotal_formatted'] = $this->formatRupiah($item['subtotal']);
            return (object)$item;
        });

        $total = $items_formatted->sum('subtotal');

        // Data Pesanan lengkap yang diperlukan view
        $order = (object)[
            'id' => $id,
            'status' => $id === 'ORD-002' ? 'Selesai' : 'Dikirim',
            'payment_method' => 'Transfer Bank',
            'total_amount' => $total,
            'total_formatted' => $this->formatRupiah($total),
            'shipping_address' => 'Jl. Laragon No. 10, Kota Bandung, Jawa Barat (Kode Pos: 40286)',
            'created_at' => Carbon::parse($id === 'ORD-002' ? '2025-10-05 09:15:00' : '2025-10-10 10:30:00'),
            'items' => $items_formatted,
            'payment_proof_url' => 'https://placehold.co/400x400/000000/FFFFFF/png?text=Bukti+Transfer'
        ];

        return view('customer.order_detail', compact('order'));
    }
}
