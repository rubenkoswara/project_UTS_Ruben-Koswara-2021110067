@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-10">
    {{-- Hapus dark:bg-gray-800 dari card utama --}}
    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden">
        
        <div class="md:flex">
            {{-- KOLOM KIRI: GAMBAR PRODUK --}}
            <div class="md:flex-shrink-0">
                <img class="h-96 w-full object-cover md:w-96" 
                     src="{{ $product['image_url'] ?? 'https://picsum.photos/800/600?random=' . $product['id'] }}" 
                     alt="{{ $product['name'] }}">
            </div>
            
            {{-- KOLOM KANAN: DETAIL PRODUK --}}
            <div class="p-8">
                {{-- Hapus dark:text-indigo-400 --}}
                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">
                    {{ $product['category'] ?? 'Kategori Umum' }}
                </div>
                
                {{-- Hapus dark:text-white --}}
                <h1 class="block mt-1 text-4xl leading-tight font-extrabold text-gray-900">
                    {{ $product['name'] }}
                </h1>
                
                {{-- HARGA --}}
                {{-- Hapus dark:text-red-400 --}}
                <p class="mt-2 text-4xl font-black text-red-600">
                    {{ $product['price'] }}
                </p>

                {{-- RATING & REVIEW DUMMY --}}
                <div class="mt-4 flex items-center">
                    <span class="text-yellow-500 text-lg">
                        {{ str_repeat('⭐', floor($product['rating'] ?? 4)) }}
                    </span>
                    {{-- Hapus dark:text-gray-400 --}}
                    <span class="ml-2 text-gray-600">
                        ({{ $product['reviews'] ?? 12 }} Ulasan)
                    </span>
                </div>
                
                {{-- STOK --}}
                <div class="mt-4 text-sm font-semibold">
                    Stok Tersedia: 
                    {{-- Hapus dark:text-green-400 --}}
                    <span class="text-green-600">{{ $product['stock'] ?? 15 }} Unit</span>
                </div>
                
                {{-- DESKRIPSI --}}
                {{-- Hapus dark:text-white --}}
                <h2 class="mt-6 text-xl font-bold text-gray-900 border-t pt-4">Deskripsi Produk</h2>
                {{-- Hapus dark:text-gray-400 --}}
                <p class="mt-2 text-gray-500 leading-relaxed">
                    {{ $product['description'] ?? 'Ini adalah deskripsi produk dummy. Aquarium kaca tebal, cocok untuk ikan hias kecil dan perlengkapan aquascape.' }}
                </p>
                
                {{-- TOMBOL BELI (LINK KE KERANJANG) --}}
                <div class="mt-8">
                    <a href="{{ route('customer.cart') }}" 
                       class="inline-block w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                        + Tambahkan ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection