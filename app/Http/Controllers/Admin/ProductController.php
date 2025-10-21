<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ------------------------------------
        // DEFINISI DATA KATEGORI (DUMMY)
        // ------------------------------------
        $categories = [
            ['id' => 1, 'name' => 'Filtrasi & Aerasi', 'slug' => 'filtrasi-aerasi'],
            ['id' => 2, 'name' => 'Pencahayaan & Pemanas', 'slug' => 'pencahayaan-pemanas'],
            ['id' => 3, 'name' => 'Pakan & Obat-obatan', 'slug' => 'pakan-obat'],
            ['id' => 4, 'name' => 'Akuarium & Dekorasi', 'slug' => 'akuarium-dekorasi'],
            ['id' => 5, 'name' => 'Peralatan Lain', 'slug' => 'peralatan-lain'],
        ];

        // ------------------------------------
        // DATA PRODUK AQUATIC DENGAN KATEGORI DAN DESKRIPSI (FIXED)
        // ------------------------------------
        $allProducts = [
            // Kategori: Filtrasi & Aerasi
            (object)['id' => 101, 'name' => 'Filter Gantung External', 'price' => 55000, 'stock' => 22, 'description' => 'Filter akuarium kaca tebal, cocok untuk ikan hias kecil dan perlengkapan aquascape.', 'category' => 'Filtrasi & Aerasi', 'slug' => 'filtrasi-aerasi'],
            (object)['id' => 103, 'name' => 'Pompa Udara (Aerator) Silent', 'price' => 45000, 'stock' => 30, 'description' => 'Pompa oksigen tanpa suara, cocok untuk kamar.', 'category' => 'Filtrasi & Aerasi', 'slug' => 'filtrasi-aerasi'],
            (object)['id' => 106, 'name' => 'Internal Filter Power Head 800L/H', 'price' => 75000, 'stock' => 18, 'description' => 'Filter celup bertenaga tinggi untuk akuarium ukuran sedang.', 'category' => 'Filtrasi & Aerasi', 'slug' => 'filtrasi-aerasi'],
            (object)['id' => 107, 'name' => 'Media Filter Bio Ring Keramik (500gr)', 'price' => 60000, 'stock' => 45, 'description' => 'Media rumah bakteri berkualitas tinggi untuk filter biologis.', 'category' => 'Filtrasi & Aerasi', 'slug' => 'filtrasi-aerasi'],
            (object)['id' => 108, 'name' => 'Selang Aerator Set (5 meter)', 'price' => 15000, 'stock' => 110, 'description' => 'Selang dan batu aerasi lengkap.', 'category' => 'Filtrasi & Aerasi', 'slug' => 'filtrasi-aerasi'],
            
            // Kategori: Pencahayaan & Pemanas
            (object)['id' => 102, 'name' => 'Lampu LED Aquascape 40cm RGB', 'price' => 180000, 'stock' => 15, 'description' => 'Lampu full spectrum untuk pertumbuhan tanaman air.', 'category' => 'Pencahayaan & Pemanas', 'slug' => 'pencahayaan-pemanas'],
            (object)['id' => 109, 'name' => 'Lampu UV Sterilizer Celup 5W', 'price' => 95000, 'stock' => 12, 'description' => 'Membunuh alga dan patogen berbahaya di air.', 'category' => 'Pencahayaan & Pemanas', 'slug' => 'pencahayaan-pemanas'],
            (object)['id' => 110, 'name' => 'Heater Otomatis 100 Watt', 'price' => 50000, 'stock' => 25, 'description' => 'Pemanas air otomatis untuk menjaga suhu stabil.', 'category' => 'Pencahayaan & Pemanas', 'slug' => 'pencahayaan-pemanas'],

            // Kategori: Pakan & Obat-obatan
            (object)['id' => 104, 'name' => 'Pakan Ikan Premium (100gr)', 'price' => 35000, 'stock' => 60, 'description' => 'Pelet apung, meningkatkan warna dan kesehatan.', 'category' => 'Pakan & Obat-obatan', 'slug' => 'pakan-obat'],
            (object)['id' => 111, 'name' => 'Obat Anti Jamur Ikan (60ml)', 'price' => 20000, 'stock' => 50, 'description' => 'Mengobati penyakit jamur dan kembung pada ikan.', 'category' => 'Pakan & Obat-obatan', 'slug' => 'pakan-obat'],
            (object)['id' => 112, 'name' => 'Pakan Udang Hias (Pelet Tenggelam)', 'price' => 40000, 'stock' => 35, 'description' => 'Pakan khusus untuk udang hias seperti Red Cherry dan Sulawasi.', 'category' => 'Pakan & Obat-obatan', 'slug' => 'pakan-obat'],

            // Kategori: Akuarium & Dekorasi
            (object)['id' => 105, 'name' => 'Akuarium Mini 20 Liter Kaca Bening', 'price' => 150000, 'stock' => 10, 'description' => 'Akuarium kaca bening ideal untuk pemula.', 'category' => 'Akuarium & Dekorasi', 'slug' => 'akuarium-dekorasi'],
            (object)['id' => 113, 'name' => 'Karbon Aktif (250gr)', 'price' => 30000, 'stock' => 70, 'description' => 'Penjernih air, menghilangkan bau dan warna.', 'category' => 'Akuarium & Dekorasi', 'slug' => 'akuarium-dekorasi'],
            (object)['id' => 114, 'name' => 'Pasir Silika Putih (1 Kg)', 'price' => 25000, 'stock' => 85, 'description' => 'Substrat dasar yang aman dan estetis untuk aquascape.', 'category' => 'Akuarium & Dekorasi', 'slug' => 'akuarium-dekorasi'],
            (object)['id' => 115, 'name' => 'Batu Lava Rock Merah (1 Kg)', 'price' => 38000, 'stock' => 40, 'description' => 'Dekorasi alami dan rumah bakteri.', 'category' => 'Akuarium & Dekorasi', 'slug' => 'akuarium-dekorasi'],
            (object)['id' => 116, 'name' => 'Tanaman Air Anubias Nana Pot', 'price' => 70000, 'stock' => 20, 'description' => 'Tanaman aquascape yang mudah dirawat.', 'category' => 'Akuarium & Dekorasi', 'slug' => 'akuarium-dekorasi'],

            // Kategori: Peralatan Lain
            (object)['id' => 117, 'name' => 'Siphon Pembersih Kotoran Otomatis', 'price' => 65000, 'stock' => 28, 'description' => 'Alat untuk menyedot kotoran dan mengganti air.', 'category' => 'Peralatan Lain', 'slug' => 'peralatan-lain'],
            (object)['id' => 118, 'name' => 'Jaring Ikan Halus Ukuran M', 'price' => 12000, 'stock' => 90, 'description' => 'Jaring serbaguna untuk memindahkan ikan.', 'category' => 'Peralatan Lain', 'slug' => 'peralatan-lain'],
            (object)['id' => 119, 'name' => 'Termometer Digital LCD', 'price' => 40000, 'stock' => 33, 'description' => 'Pengukur suhu akuarium dengan akurasi tinggi.', 'category' => 'Peralatan Lain', 'slug' => 'peralatan-lain'],
        ];
        // ------------------------------------

        // LOGIKA FILTER
        $products = collect($allProducts);
        $search = $request->get('search');
        $categorySlug = $request->get('category');

        // 1. Filter berdasarkan Kategori
        if ($categorySlug && $categorySlug !== 'all') {
            $products = $products->filter(function ($product) use ($categorySlug) {
                // Mencocokkan product slug dengan category slug dari request
                return $product->slug === $categorySlug;
            });
        }
        
        // 2. Filter berdasarkan Pencarian (Nama Produk)
        if ($search) {
            $products = $products->filter(function ($product) use ($search) {
                // Mencari nama produk atau deskripsi (opsional)
                return str_contains(strtolower($product->name), strtolower($search)) ||
                       str_contains(strtolower($product->description), strtolower($search));
            });
        }

        // Kembalikan view index dengan data yang sudah difilter dan kategori
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
