@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-md" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 shadow-md" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Katalog Produk Renesca Aquatic</h2>
        <a href="{{ route('shop.viewCart') }}" class="flex items-center bg-teal-600 text-white py-2 px-4 rounded-full shadow-lg hover:bg-teal-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Keranjang
        </a>
    </div>
    
    {{-- FILTER KATEGORI --}}
    <div class="mb-8 p-4 bg-gray-100 rounded-xl flex flex-wrap gap-3 shadow-inner">
        <span class="font-semibold text-lg py-2 text-gray-700">Filter Kategori:</span>
        
        {{-- Tombol 'Semua' --}}
        <a href="{{ route('shop.index') }}" 
           class="py-2 px-4 rounded-lg transition font-medium {{ !$filter_category_slug ? 'bg-teal-600 text-white shadow-md' : 'bg-white hover:bg-gray-200 border' }}">
            Semua
        </a>
        
        {{-- Looping Kategori --}}
        @foreach ($categories as $category)
            <a href="{{ route('shop.index', ['category' => $category->slug]) }}" 
               class="py-2 px-4 rounded-lg transition font-medium {{ $filter_category_slug == $category->slug ? 'bg-teal-600 text-white shadow-md' : 'bg-white hover:bg-gray-200 border' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>
    
    <h3 class="text-xl font-bold mb-4 border-b pb-2 text-gray-700">
        Menampilkan: {{ ucwords(str_replace('-', ' ', $filter_category_slug ?? 'Semua Produk')) }}
    </h3>

    {{-- Daftar Produk --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse ($products as $product)
            <div class="border rounded-2xl shadow-xl overflow-hidden transform transition duration-300 hover:shadow-2xl hover:scale-[1.03] bg-white">
                
                {{-- GAMBAR PRODUK --}}
                @php
                    $imagePath = $product->image;
                    $basePath = 'storage/';
                    $directory = 'products/';
                    $fullAssetPath = null;

                    if ($imagePath) {
                        // Cek apakah $imagePath sudah mengandung prefix folder `products/`
                        if (str_starts_with($imagePath, $directory)) {
                            // Jika sudah ada (misal: products/gambar.jpg), kita hanya perlu prefix `storage/`
                            $fullAssetPath = $basePath . $imagePath;
                        } else {
                            // Jika hanya nama file (misal: gambar.jpg), kita tambahkan `storage/products/`
                            $fullAssetPath = $basePath . $directory . $imagePath;
                        }
                    }
                    
                    // Gunakan path yang sudah dikonstruksi atau placeholder
                    $imageUrl = $fullAssetPath ? asset($fullAssetPath) : 'https://placehold.co/400x300/CCCCCC/333333/png?text=Renesca';
                @endphp
                <img src="{{ $imageUrl }}" 
                     alt="{{ $product->name }}" 
                     onerror="this.onerror=null;this.src='https://placehold.co/400x300/CCCCCC/333333/png?text=Renesca';"
                     class="w-full h-56 object-cover">
                
                <div class="p-5">
                    {{-- Kategori --}}
                    <span class="text-xs text-gray-500 font-medium uppercase tracking-wider block mb-1">{{ $product->category->name }}</span>
                    
                    {{-- Nama Produk --}}
                    <h3 class="font-extrabold text-xl truncate text-gray-800">{{ $product->name }}</h3>
                    
                    {{-- Stok & Harga --}}
                    <p class="text-sm text-gray-500 mt-1">Stok: <span class="font-semibold text-green-600">{{ $product->stock }}</span></p>
                    <p class="text-3xl font-extrabold text-teal-600 mt-3">{{ $product->formatted_price }}</p>

                    {{-- Form Tambah ke Keranjang --}}
                    <form action="{{ route('shop.addToCart') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center space-x-3">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                   class="w-1/3 p-3 border border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 text-center text-lg font-medium"
                                   required>
                            <button type="submit" 
                                    class="w-2/3 flex-shrink-0 bg-teal-600 text-white py-3 px-4 rounded-xl shadow-lg shadow-teal-500/50 hover:bg-teal-700 transition font-bold text-lg disabled:bg-gray-400"
                                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                {{ $product->stock > 0 ? 'Masukkan Keranjang' : 'Stok Habis' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500 py-12 bg-gray-50 rounded-xl border border-dashed">Produk tidak ditemukan dalam kategori ini.</p>
        @endforelse
    </div>
</div>
@endsection