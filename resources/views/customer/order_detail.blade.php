@extends('layouts.app') 

{{-- Pastikan Anda punya file resources/views/layouts/app.blade.php --}}

@section('content')
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    {{-- Container utama: Light Mode (putih) --}}
    <div class="bg-white shadow-xl rounded-lg p-6">
        
        <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
            {{-- PERBAIKAN: Menggunakan ->id --}}
            <h1 class="text-2xl font-bold text-gray-900">Detail Pesanan Anda #{{ $order->id }}</h1>
            {{-- Menggunakan rute dummy untuk kembali ke daftar pesanan customer (Ganti /orders dengan rute aktual Anda) --}}
            <a href="{{ url('/orders') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                &larr; Kembali ke Daftar Pesanan
            </a>
        </div>
        
        <!-- Status dan Info Singkat -->
        <div class="mb-6">
            {{-- PERBAIKAN: Menggunakan ->status --}}
            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                @if($order->status === 'Selesai') bg-green-100 text-green-800 
                @elseif($order->status === 'Dikirim') bg-blue-100 text-blue-800 
                @elseif($order->status === 'Pending') bg-yellow-100 text-yellow-800 
                @else bg-red-100 text-red-800 
                @endif">
                Status: {{ $order->status }}
            </span>
            {{-- PERBAIKAN: Menggunakan ->created_at --}}
            <p class="mt-2 text-sm text-gray-500">Dipesan pada: {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        
        <!-- Detail Pembayaran dan Pengiriman -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 border-b border-gray-200 pb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Metode Pembayaran</h3>
                {{-- PERBAIKAN: Menggunakan ->payment_method --}}
                <p class="text-gray-700">{{ $order->payment_method ?? 'Belum terdefinisi' }}</p>
            </div>
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Alamat Pengiriman</h3>
                {{-- PERBAIKAN: Menggunakan ->shipping_address --}}
                <p class="text-gray-700">{{ $order->shipping_address }}</p>
            </div>
        </div>

        <!-- Daftar Item Pesanan -->
        <h2 class="text-xl font-bold text-gray-900 mb-4">Item Pesanan</h2>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kuantitas</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- PERBAIKAN: Looping menggunakan $order->items --}}
                    @foreach($order->items as $item)
                    <tr>
                        {{-- PERBAIKAN: Menggunakan ->product_name, ->price, ->quantity --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->product_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right text-base font-semibold text-gray-900">Total Keseluruhan:</td>
                        {{-- PERBAIKAN: Menggunakan ->total_amount --}}
                        <td class="px-6 py-4 text-right text-base font-bold text-indigo-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Bukti Transfer (Dibatasi ukurannya) -->
        <div class="mt-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Bukti Transfer</h2>
            
            @if(isset($order->payment_proof_url))
            <div class="border border-gray-300 rounded-lg p-4 bg-gray-100 text-center">
                
                <p class="text-sm text-gray-600 mb-4">Bukti pembayaran telah diunggah:</p>

                <a href="{{ $order->payment_proof_url }}" target="_blank" title="Klik untuk melihat gambar penuh">
                    <img 
                        src="{{ $order->payment_proof_url }}" 
                        alt="Bukti Transfer Pesanan #{{ $order->id }}" 
                        class="block max-w-full h-auto mx-auto rounded-lg shadow-lg border border-gray-400 transition duration-300 ease-in-out transform hover:scale-[1.02]"
                        style="max-width: 450px; max-height: 500px; object-fit: contain;"
                    />
                </a>

                <div class="mt-4">
                    <a href="{{ $order->payment_proof_url }}" target="_blank" class="inline-block px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md">
                        Lihat Gambar Penuh
                    </a>
                </div>
            </div>
            @else
                <p class="text-gray-600 bg-yellow-50 p-3 rounded-lg border border-yellow-200">Bukti pembayaran belum diunggah.</p>
            @endif
        </div>
        
    </div>
</div>
@endsection
