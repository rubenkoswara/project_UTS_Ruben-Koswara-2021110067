@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Proses Checkout</h2>
    
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- BAGIAN 1: DAFTAR BARANG YANG DIBELI --}}
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <h3 class="text-xl font-bold mb-4 border-b pb-2">Pesanan Anda</h3>
            
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="text-gray-500 uppercase text-sm font-semibold tracking-wider">
                        <th class="py-2 text-left">Produk</th>
                        <th class="py-2 text-center w-20">Qty</th>
                        <th class="py-2 text-right w-32">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($cart_items as $item)
                    <tr>
                        <td class="py-3 text-gray-800">{{ $item['name'] }}</td>
                        <td class="py-3 text-center">{{ $item['quantity'] }}</td>
                        <td class="py-3 text-right">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- BAGIAN 2: ALAMAT & KONFIRMASI --}}
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <h3 class="text-xl font-bold mb-4 border-b pb-2">1. Alamat & Pengiriman</h3>
            <p class="text-gray-700">Nama: {{ $shipping_data['name'] }}</p>
            <p class="text-gray-700">Alamat: {{ $shipping_data['address'] }}</p>
            
            <h3 class="text-xl font-bold mt-6 mb-4 border-b pb-2">2. Metode Pembayaran</h3>
            {{-- Dropdown Metode Pembayaran Mockup --}}
            <select class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option>Transfer Bank (BCA/Mandiri)</option>
                <option>E-Wallet (GoPay/DANA)</option>
            </select>
            
            <div class="flex justify-between border-t border-dashed pt-4 mt-6">
                <span class="text-2xl font-bold text-gray-800">Total Akhir:</span>
                <span class="text-2xl font-bold text-red-600">Rp {{ number_format($grand_total, 0, ',', '.') }}</span>
            </div>
            
            {{-- LINK BERJALAN: Konfirmasi Pesanan (Simulasi ke Instruksi Pembayaran) --}}
            <a href="{{ route('customer.payment_instruction') }}" class="w-full block text-center mt-6 bg-red-600 text-white font-bold py-3 rounded-lg hover:bg-red-700 transition duration-300">
                Konfirmasi Pesanan & Bayar
            </a>
        </div>
        
    </div>
</div>
@endsection