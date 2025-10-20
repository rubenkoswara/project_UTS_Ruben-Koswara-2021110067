@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6">Katalog Produk Renesca Aquatic</h2>
    
    {{-- FILTER KATEGORI (LINK BERJALAN) --}}
    <div class="mb-8 p-4 bg-gray-100 rounded-lg flex space-x-3">
        <span class="font-semibold text-lg py-2">Filter Kategori:</span>
        
        {{-- Tombol 'Semua' --}}
        <a href="{{ route('customer.home') }}" 
           class="py-2 px-4 rounded transition {{ !$filter_category ? 'bg-teal-600 text-white' : 'bg-white hover:bg-gray-200 border' }}">
            Semua
        </a>
        
        {{-- Looping Kategori Dummy (Link Berjalan) --}}
        @foreach ($categories as $category)
            <a href="{{ route('customer.home', ['category' => strtolower($category)]) }}" 
               class="py-2 px-4 rounded transition {{ $filter_category == strtolower($category) ? 'bg-teal-600 text-white' : 'bg-white hover:bg-gray-200 border' }}">
                {{ $category }}
            </a>
        @endforeach
    </div>
    
    <h3 class="text-xl font-bold mb-4">Menampilkan: {{ ucwords($filter_category ?? 'Semua Produk') }}</h3>

    {{-- Daftar Produk Dummy --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @forelse ($products as $product)
            <div class="border rounded-lg shadow-md overflow-hidden">
                {{-- PERBAIKAN: Menggunakan 'image_url' dari Controller --}}
                <img src="{{ $product['image_url'] ?? 'https://picsum.photos/400/300' }}" 
                     alt="{{ $product['name'] }}" 
                     class="w-full h-48 object-cover">
                     
                <div class="p-4">
                    <span class="text-sm text-gray-500">{{ $product['category'] }}</span>
                    <h3 class="font-semibold text-lg truncate mt-1">{{ $product['name'] }}</h3>
                    <p class="text-xl font-bold text-teal-600 mt-1">{{ $product['price'] }}</p>
                    
                    {{-- LINK BERJALAN: ke Detail Produk --}}
                    <a href="{{ route('customer.product_detail', $product['id']) }}" class="block text-center mt-3 bg-teal-500 text-white py-2 rounded">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @empty
            <p class="col-span-4 text-center text-gray-500">Produk tidak ditemukan.</p>
        @endforelse
    </div>
</div>
@endsection