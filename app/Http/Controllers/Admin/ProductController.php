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
    public function index()
    {
        // --- DATA PRODUK AQUATIC YANG LEBIH LENGKAP ---
        $products = [
            // Kategori: Filtrasi & Aerasi
            (object)['id' => 101, 'name' => 'Filter Gantung External', 'price' => 55000, 'stock' => 22, 'description' => 'Filter akuarium kaca tebal, cocok untuk ikan hias kecil dan perlengkapan aquascape.'],
            (object)['id' => 103, 'name' => 'Pompa Udara (Aerator) Silent', 'price' => 45000, 'stock' => 30, 'description' => 'Pompa oksigen tanpa suara, cocok untuk kamar.'],
            (object)['id' => 106, 'name' => 'Internal Filter Power Head 800L/H', 'price' => 75000, 'stock' => 18, 'description' => 'Filter celup bertenaga tinggi untuk akuarium ukuran sedang.'],
            (object)['id' => 107, 'name' => 'Media Filter Bio Ring Keramik (500gr)', 'price' => 60000, 'stock' => 45, 'description' => 'Media rumah bakteri berkualitas tinggi untuk filter biologis.'],
            (object)['id' => 108, 'name' => 'Selang Aerator Set (5 meter)', 'price' => 15000, 'stock' => 110, 'description' => 'Selang dan batu aerasi lengkap.'],
            
            // Kategori: Pencahayaan & Pemanas
            (object)['id' => 102, 'name' => 'Lampu LED Aquascape 40cm RGB', 'price' => 180000, 'stock' => 15, 'description' => 'Lampu full spectrum untuk pertumbuhan tanaman air.'],
            (object)['id' => 109, 'name' => 'Lampu UV Sterilizer Celup 5W', 'price' => 95000, 'stock' => 12, 'description' => 'Membunuh alga dan patogen berbahaya di air.'],
            (object)['id' => 110, 'name' => 'Heater Otomatis 100 Watt', 'price' => 50000, 'stock' => 25, 'description' => 'Pemanas air otomatis untuk menjaga suhu stabil.'],

            // Kategori: Pakan & Obat-obatan
            (object)['id' => 104, 'name' => 'Pakan Ikan Premium (100gr)', 'price' => 35000, 'stock' => 60, 'description' => 'Pelet apung, meningkatkan warna dan kesehatan.'],
            (object)['id' => 111, 'name' => 'Obat Anti Jamur Ikan (60ml)', 'price' => 20000, 'stock' => 50, 'description' => 'Mengobati penyakit jamur dan kembung pada ikan.'],
            (object)['id' => 112, 'name' => 'Pakan Udang Hias (Pelet Tenggelam)', 'price' => 40000, 'stock' => 35, 'description' => 'Pakan khusus untuk udang hias seperti Red Cherry dan Sulawasi.'],

            // Kategori: Akuarium & Dekorasi
            (object)['id' => 105, 'name' => 'Akuarium Mini 20 Liter Kaca Bening', 'price' => 150000, 'stock' => 10, 'description' => 'Akuarium kaca bening ideal untuk pemula.'],
            (object)['id' => 113, 'name' => 'Karbon Aktif (250gr)', 'price' => 30000, 'stock' => 70, 'description' => 'Penjernih air, menghilangkan bau dan warna.'],
            (object)['id' => 114, 'name' => 'Pasir Silika Putih (1 Kg)', 'price' => 25000, 'stock' => 85, 'description' => 'Substrat dasar yang aman dan estetis untuk aquascape.'],
            (object)['id' => 115, 'name' => 'Batu Lava Rock Merah (1 Kg)', 'price' => 38000, 'stock' => 40, 'description' => 'Dekorasi alami dan rumah bakteri.'],
            (object)['id' => 116, 'name' => 'Tanaman Air Anubias Nana Pot', 'price' => 70000, 'stock' => 20, 'description' => 'Tanaman aquascape yang mudah dirawat.'],

            // Kategori: Peralatan
            (object)['id' => 117, 'name' => 'Siphon Pembersih Kotoran Otomatis', 'price' => 65000, 'stock' => 28, 'description' => 'Alat untuk menyedot kotoran dan mengganti air.'],
            (object)['id' => 118, 'name' => 'Jaring Ikan Halus Ukuran M', 'price' => 12000, 'stock' => 90, 'description' => 'Jaring serbaguna untuk memindahkan ikan.'],
            (object)['id' => 119, 'name' => 'Termometer Digital LCD', 'price' => 40000, 'stock' => 33, 'description' => 'Pengukur suhu akuarium dengan akurasi tinggi.'],
        ];
        // ------------------------------------
        
        // Return view index dengan data dummy
        return view('admin.products.index', compact('products'));
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