<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Data Produk Dummy yang Sesuai dengan ProductController.
     */
    private function getDummyProducts()
    {
        // Data Produk yang diambil dari ProductController Anda
        return collect([
            (object)['id' => 101, 'name' => 'Filter Gantung External', 'price' => 55000, 'stock' => 22, 'description' => 'Filter akuarium kaca tebal...'],
            (object)['id' => 102, 'name' => 'Lampu LED Aquascape 40cm', 'price' => 180000, 'stock' => 15, 'description' => 'Lampu full spectrum...'],
            (object)['id' => 103, 'name' => 'Pompa Udara (Aerator) Silent', 'price' => 45000, 'stock' => 30, 'description' => 'Pompa oksigen tanpa suara...'],
            (object)['id' => 104, 'name' => 'Pakan Ikan Premium (100gr)', 'price' => 35000, 'stock' => 60, 'description' => 'Pelet apung...'],
            (object)['id' => 105, 'name' => 'Akuarium Mini 20 Liter', 'price' => 150000, 'stock' => 10, 'description' => 'Akuarium kaca bening...'],
        ]);
    }

    private function getDummyOrders()
    {
        $products = $this->getDummyProducts();
        
        // Link Bukti Transfer yang Disediakan oleh Pengguna
        $valid_proof_link = 'https://cdn.yellowmessenger.com/LtvBQZyaHFbW1742278837046.jpeg';

        return collect([
            // Pesanan 1001: Ferry Customer
            (object)[
                // Total amount disesuaikan dengan screenshot daftar pesanan
                'id' => 1001, 
                'total_amount' => 125000, 
                'status' => 'Pending', 
                'created_at' => Carbon::now()->subDays(5),
                'user' => (object)['name' => 'Ferry Customer', 'email' => 'ferry@example.com'],
                'shipping_address' => 'Jl. Merdeka No. 12, Jakarta',
                'payment_proof_url' => $valid_proof_link, 
                'items' => collect([
                    (object)['product_name' => $products->get(0)->name, 'price' => $products->get(0)->price, 'quantity' => 2],
                    (object)['product_name' => $products->get(3)->name, 'price' => $products->get(3)->price, 'quantity' => 1],
                ])
            ],
            // Pesanan 1002: Siska Pembeli
            (object)[
                // Total amount disesuaikan dengan screenshot daftar pesanan
                'id' => 1002, 
                'total_amount' => 350000, 
                'status' => 'Shipped', 
                'created_at' => Carbon::now()->subDays(3),
                'user' => (object)['name' => 'Siska Pembeli', 'email' => 'siska@example.com'],
                'shipping_address' => 'Jl. Kenanga 1A, Bandung',
                'payment_proof_url' => $valid_proof_link, 
                'items' => collect([
                    (object)['product_name' => $products->get(1)->name, 'price' => $products->get(1)->price, 'quantity' => 1],
                    (object)['product_name' => $products->get(2)->name, 'price' => $products->get(2)->price, 'quantity' => 2],
                ])
            ],
            // Pesanan 1003: Bambang Sukses (Tidak ada di screenshot, pakai data lama)
            (object)[
                'id' => 1003, 
                'total_amount' => 150000, 
                'status' => 'Completed', 
                'created_at' => Carbon::now()->subDays(10),
                'user' => (object)['name' => 'Bambang Sukses', 'email' => 'bambang@example.com'],
                'shipping_address' => 'Jl. Raya No. 1, Surabaya',
                'payment_proof_url' => $valid_proof_link,
                'items' => collect([
                    (object)['product_name' => $products->get(4)->name, 'price' => $products->get(4)->price, 'quantity' => 1],
                ])
            ],
            // Pesanan 1004: Admin Test
            (object)[
                // Total amount disesuaikan dengan screenshot daftar pesanan
                'id' => 1004, 
                'total_amount' => 75000, 
                'status' => 'Cancelled', 
                'created_at' => Carbon::now()->subDays(1),
                'user' => (object)['name' => 'Admin Test', 'email' => 'admin@example.com'],
                'shipping_address' => 'Jl. Sudirman 5, Bogor',
                'payment_proof_url' => $valid_proof_link, 
                'items' => collect([
                    (object)['product_name' => $products->get(3)->name, 'price' => $products->get(3)->price, 'quantity' => 2],
                ])
            ],
            // Pesanan 1005: Rini Baru
            (object)[
                // Total amount disesuaikan dengan screenshot daftar pesanan
                'id' => 1005, 
                'total_amount' => 200000, 
                'status' => 'Pending', 
                'created_at' => Carbon::now()->subDays(2),
                'user' => (object)['name' => 'Rini Baru', 'email' => 'rini@example.com'],
                'shipping_address' => 'Griya Asri 4B, Bekasi',
                'payment_proof_url' => $valid_proof_link, 
                'items' => collect([
                    (object)['product_name' => $products->get(1)->name, 'price' => $products->get(1)->price, 'quantity' => 1],
                ])
            ],
            // Pesanan 1006: Joko Selesai (Tidak ada di screenshot, pakai data lama)
            (object)[
                'id' => 1006, 
                'total_amount' => 55000, 
                'status' => 'Completed', 
                'created_at' => Carbon::now()->subDays(7),
                'user' => (object)['name' => 'Joko Selesai', 'email' => 'joko@example.com'],
                'shipping_address' => 'Jl. Pelita No. 3, Jakarta',
                'payment_proof_url' => $valid_proof_link, 
                'items' => collect([
                    (object)['product_name' => $products->get(0)->name, 'price' => $products->get(0)->price, 'quantity' => 1],
                ])
            ],
            // Pesanan 1007: Tini Tunda (Tidak ada di screenshot, pakai data lama)
            (object)[
                'id' => 1007, 
                'total_amount' => 90000, 
                'status' => 'Pending', 
                'created_at' => Carbon::now()->subDays(6),
                'user' => (object)['name' => 'Tini Tunda', 'email' => 'tini@example.com'],
                'shipping_address' => 'Komplek Harapan Indah Blok C, Depok',
                'payment_proof_url' => $valid_proof_link, 
                'items' => collect([
                    (object)['product_name' => $products->get(2)->name, 'price' => $products->get(2)->price, 'quantity' => 2],
                ])
            ],
            // Pesanan 1008: Agus Kirim
            (object)[
                // Total amount disesuaikan dengan screenshot daftar pesanan
                'id' => 1008, 
                'total_amount' => 180000, 
                'status' => 'Shipped', 
                'created_at' => Carbon::now()->subDays(4),
                'user' => (object)['name' => 'Agus Kirim', 'email' => 'agus@example.com'],
                'shipping_address' => 'Perumahan Damai Sentosa, Tangerang',
                'payment_proof_url' => $valid_proof_link, 
                'items' => collect([
                    (object)['product_name' => $products->get(4)->name, 'price' => $products->get(4)->price, 'quantity' => 1],
                    (object)['product_name' => $products->get(3)->name, 'price' => $products->get(3)->price, 'quantity' => 1],
                ])
            ],
        ]);
    }
    
    /**
     * Mengambil detail satu pesanan dari data dummy.
     */
    private function getDummyOrderDetails($id)
    {
        return $this->getDummyOrders()->firstWhere('id', (int)$id);
    }

    /**
     * Menampilkan daftar pesanan Admin dengan dukungan filter status dan paginasi dummy.
     */
    public function index(Request $request): View
    {
        // 1. Ambil semua data dummy dan pastikan diurutkan dari terbaru
        $ordersCollection = $this->getDummyOrders()->sortByDesc('created_at'); 
        
        // 2. Terapkan Filter Status jika ada di URL (contoh: ?status=Pending)
        $status = $request->input('status');

        if ($status && $status !== 'All') {
            $ordersCollection = $ordersCollection->filter(function ($order) use ($status) {
                return $order->status === $status;
            });
        }

        // 3. Paginasi Manual untuk Collection (simulasi paginate(5))
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $ordersCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->values();
        
        // Buat Paginator
        $orders = new LengthAwarePaginator($currentItems, $ordersCollection->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan berdasarkan ID.
     */
    public function show($id)
    {
        // Menggunakan fungsi dummy untuk mengambil detail
        $order = $this->getDummyOrderDetails($id);

        if (!$order) {
            // Mensimulasikan FindOrFail (error 404 jika tidak ditemukan)
            abort(404, "Order #{$id} not found.");
        }
        
        return view('admin.orders.show', compact('order'));
    }
}