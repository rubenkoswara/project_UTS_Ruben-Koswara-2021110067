@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8">
<h2 class="text-3xl font-bold mb-8 border-b pb-3 text-gray-800">Keranjang Belanja</h2>

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

@if (!empty($cart['items']))
    <div class="lg:flex lg:space-x-10">
        
        <div class="lg:w-2/3 space-y-5">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Daftar Produk ({{ count($cart['items']) }} item)</h3>
            @foreach ($cart['items'] as $item)
                <div class="flex items-center border rounded-xl p-5 shadow-lg bg-white">
                    <img src="{{ $item['product']->image_url ?? (asset('storage/' . $item['product']->image) ?? 'https://placehold.co/100x100/CCCCCC/333333/png?text=Item') }}" 
                        alt="{{ $item['product']->name }}" 
                        class="w-24 h-24 object-cover rounded-xl mr-5 flex-shrink-0">
                    
                    <div class="flex-grow min-w-0 pr-4">
                        <h3 class="font-bold text-lg truncate text-gray-800">{{ $item['product']->name }}</h3>
                        <p class="text-gray-500">Harga Satuan: Rp {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                        <p class="text-teal-600 font-extrabold text-xl mt-1">Subtotal: Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4 ml-auto">
                        <form action="{{ route('shop.updateCart') }}" method="POST" class="flex items-center space-x-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock }}"
                                    class="w-16 p-2 border border-gray-300 rounded-lg text-center font-medium focus:ring-teal-500 focus:border-teal-500" required>
                            <button type="submit" class="text-sm bg-teal-500 text-white p-2 rounded-lg hover:bg-teal-600 transition shadow-md">Update</button>
                        </form>

                        <form action="{{ route('shop.updateCart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                            <input type="hidden" name="remove" value="1">
                            <button type="submit" class="text-red-500 p-2 rounded-full hover:bg-red-100 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
            
            <a href="{{ route('shop.index') }}" class="mt-4 inline-flex items-center text-teal-600 hover:text-teal-800 font-semibold transition">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Lanjut Belanja
            </a>
        </div>

        <div class="lg:w-1/3 mt-8 lg:mt-0">
            <form action="{{ route('shop.checkout') }}" method="POST" class="sticky top-8 bg-white border rounded-2xl p-6 shadow-2xl space-y-4">
                @csrf
                <h3 class="text-2xl font-bold mb-4 border-b pb-2 text-teal-700">Ringkasan & Checkout</h3>

                {{-- Blok ringkasan diubah: Biaya pengiriman dihilangkan --}}
                <div class="space-y-3 pb-3 border-b">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal Produk</span>
                        <span class="font-semibold text-xl">Rp {{ number_format($cart['subtotal'], 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between text-2xl font-extrabold text-teal-800 pt-2">
                        <span>Total Tagihan</span>
                        <span>Rp {{ number_format($cart['subtotal'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="space-y-2">
                        <label for="shipping_service_code" class="block text-sm font-medium text-gray-700">Layanan Pengiriman</label>
                        <select name="shipping_service_code" id="shipping_service_code" required class="w-full p-3 border border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500">
                            <option value="" disabled selected>Pilih Layanan Pengiriman</option>
                            @forelse ($shippingServices as $service)
                                <option value="{{ $service->code }}">
                                    {{ $service->name }} (Est. {{ $service->estimation }})
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada layanan pengiriman aktif</option>
                            @endforelse
                        </select>
                        @error('shipping_service_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="space-y-2">
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                        <textarea name="shipping_address" id="shipping_address" rows="3" required placeholder="Masukkan alamat lengkap Anda..." 
                                class="w-full p-3 border border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500">{{ Auth::user()->address ?? '' }}</textarea>
                        @error('shipping_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                        <div class="space-y-2">
                            @forelse ($paymentMethods as $method)
                            <label class="flex items-center p-3 border rounded-xl hover:bg-gray-50 cursor-pointer transition">
                                {{-- Mengubah name dari payment_method_code menjadi payment_method --}}
                                <input type="radio" name="payment_method" value="{{ $method->code }}" required class="form-radio text-teal-600">
                                <span class="ml-3 font-medium">{{ $method->name }}</span>
                            </label>
                            @empty
                            <p class="text-red-500 text-sm">Tidak ada metode pembayaran aktif.</p>
                            @endforelse

                            @error('payment_method') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-teal-600 text-white py-3 rounded-xl text-xl font-bold shadow-lg shadow-teal-500/50 hover:bg-teal-700 transition transform hover:scale-[1.01]">
                        SELESAIKAN ORDER
                    </button>
                    <p class="text-sm text-center text-gray-500 mt-2">Anda harus login untuk melanjutkan.</p>
                </div>
            </form>
        </div>
    </div>
@else
    <div class="text-center py-20 bg-gray-50 rounded-2xl border border-dashed border-gray-300 shadow-inner">
        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <p class="text-2xl font-semibold text-gray-600 mt-4">Keranjang belanja Anda kosong.</p>
        <a href="{{ route('shop.index') }}" class="mt-6 inline-block bg-teal-600 text-white py-3 px-6 rounded-lg text-lg hover:bg-teal-700 transition shadow-md">
            Mulai Belanja Sekarang
        </a>
    </div>
@endif


</div>
@endsection