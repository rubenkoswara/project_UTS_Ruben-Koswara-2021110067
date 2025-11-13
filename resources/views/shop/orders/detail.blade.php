@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Tombol Kembali --}}
        <a href="{{ route('shop.myOrders') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-6 transition duration-150 ease-in-out">
            <i class="bi bi-arrow-left mr-2"></i> Kembali ke Riwayat Pesanan
        </a>

        {{-- KARTU DETAIL PESANAN --}}
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-200">
            
            {{-- HEADER: ID Pesanan & Status --}}
            @php
                // Definisikan status dengan nilai string huruf kecil (sesuai database)
                $statusColors = [
                    'completed' => ['bg' => 'green', 'text' => 'Telah Selesai'],
                    'cancelled' => ['bg' => 'red', 'text' => 'Dibatalkan'],
                    'pending_payment' => ['bg' => 'yellow', 'text' => 'Menunggu Pembayaran'],
                    'processing' => ['bg' => 'blue', 'text' => 'Diproses'],
                    'shipped' => ['bg' => 'indigo', 'text' => 'Dikirim'],
                ];
                
                // Gunakan strtolower() untuk memastikan status dari database adalah huruf kecil saat dibandingkan
                $orderStatusKey = strtolower($order->status);
                $statusInfo = $statusColors[$orderStatusKey] ?? ['bg' => 'gray', 'text' => 'Status Lain'];
            @endphp
            
            <div class="px-6 py-4 bg-indigo-600 text-white flex justify-between items-center rounded-t-xl">
                <h5 class="text-xl font-bold flex items-center">
                    <i class="bi bi-receipt mr-3"></i> Detail Pesanan #{{ $order->id }}
                </h5>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-{{ $statusInfo['bg'] }}-500 text-white uppercase tracking-wider shadow-md">
                    {{-- Teks status diambil dari $statusInfo['text'] --}}
                    {{ $statusInfo['text'] }}
                </span>
            </div>

            <div class="p-6 space-y-6">
                
                {{-- INFORMASI PENGIRIMAN --}}
                <div class="border-b pb-4">
                    <h6 class="font-bold text-indigo-600 mb-3 text-lg flex items-center">
                        <i class="bi bi-truck mr-2"></i> Informasi Pengiriman
                    </h6>
                    <div class="space-y-1 text-gray-700">
                        <p>
                            <strong class="font-semibold text-gray-900">Alamat:</strong> 
                            {{ $order->shipping_address }}
                        </p>
                        <p>
                            <strong class="font-semibold text-gray-900">Layanan:</strong> 
                            {{ $order->shipping_service }}
                        </p>
                    </div>
                </div>

                {{-- DAFTAR PRODUK --}}
                <div class="pt-4">
                    <h6 class="font-bold text-indigo-600 mb-4 text-lg flex items-center">
                        <i class="bi bi-box mr-2"></i> Daftar Produk
                    </h6>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Produk</th>
                                    <th class="py-3 px-6 text-right">Harga</th>
                                    <th class="py-3 px-6 text-center">Qty</th>
                                    <th class="py-3 px-6 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 text-gray-600 text-sm font-light">
                                {{-- Mengganti $order->orderItems menjadi $order->items (sesuai model) dan menambahkan ?? [] --}}
                                @foreach($order->items ?? [] as $item)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            <div class="flex items-center">
                                                <img src="https://placehold.co/40x40/f3f4f6/374151?text=P" 
                                                     alt="Produk" 
                                                     class="w-10 h-10 rounded object-cover mr-3 border border-gray-100">
                                                {{-- Tambahkan pengecekan null untuk $item->product --}}
                                                <span class="font-medium text-gray-900">{{ $item->product->name ?? 'Produk Tidak Tersedia' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-right">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="py-3 px-6 text-right font-semibold text-gray-800">
                                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- TOTAL --}}
                    <div class="flex justify-end mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        {{-- Menggunakan flex-col-reverse untuk memastikan "Total" di atas angka pada layar kecil --}}
                        <div class="flex flex-col-reverse sm:flex-row justify-between w-full sm:w-1/2 items-end">
                             <h5 class="text-xl font-bold text-gray-900 mt-2 sm:mt-0">Total:</h5> 
                             {{-- Menggunakan accessor formatted_total_amount --}}
                             <h5 class="text-2xl font-extrabold text-indigo-600">
                                {{ $order->formatted_total_amount }}
                            </h5>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection