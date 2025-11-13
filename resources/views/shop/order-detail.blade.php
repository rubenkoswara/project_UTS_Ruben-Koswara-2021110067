<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-teal-300 leading-tight">
            {{ __('Detail Pesanan #') . $order->id }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Bagian Kiri: Produk dan Status --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Status Pesanan --}}
                    <div class="bg-gray-800 shadow-xl rounded-lg p-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-2xl font-extrabold text-white">Status Pesanan</h3>
                            <span class="px-4 py-1 rounded-full text-lg font-bold
                                @if ($order->status == 'Pending') bg-yellow-600 text-yellow-100
                                @elseif ($order->status == 'Shipped') bg-blue-600 text-blue-100
                                @elseif ($order->status == 'Completed') bg-green-600 text-green-100
                                @elseif ($order->status == 'Cancelled') bg-red-600 text-red-100
                                @endif">
                                {{ $order->status }}
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-gray-400">Pesanan dibuat pada: {{ $order->created_at->format('d M Y, H:i') }}</p>
                        @if ($order->tracking_number)
                            <p class="mt-2 text-md text-gray-300">Nomor Resi: <span class="font-semibold text-teal-400">{{ $order->tracking_number }}</span></p>
                        @endif
                    </div>
                    
                    {{-- Daftar Produk --}}
                    <div class="bg-gray-800 shadow-xl rounded-lg p-6">
                        <h3 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-3">Produk dalam Pesanan</h3>
                        <ul class="divide-y divide-gray-700">
                            {{-- $order->items diasumsikan sebagai collection atau array dari item pesanan --}}
                            @foreach ($order->items as $item)
                                <li class="py-4 flex justify-between items-center">
                                    <div class="flex items-center">
                                        {{-- Menggunakan placeholder image --}}
                                        <img class="h-16 w-16 object-cover rounded-md mr-4 border border-teal-500" 
                                             src="https://placehold.co/64x64/0f172a/99f6e4?text=Produk" 
                                             alt="{{ $item->product_name ?? 'Produk' }}">
                                        <div>
                                            <p class="text-lg font-semibold text-white">{{ $item->product_name ?? 'Nama Produk' }}</p>
                                            <p class="text-sm text-gray-400">Qty: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <p class="text-lg font-bold text-yellow-300">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Bagian Kanan: Ringkasan dan Alamat --}}
                <div class="lg:col-span-1 space-y-6">
                    
                    {{-- Alamat Pengiriman --}}
                    <div class="bg-gray-800 shadow-xl rounded-lg p-6">
                        <h3 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-3">Alamat Pengiriman</h3>
                        <p class="text-md font-semibold text-teal-300">{{ $order->shipping_address['recipient'] ?? 'Nama Penerima' }}</p>
                        <p class="text-gray-300 mt-1">{{ $order->shipping_address['street'] ?? 'Jalan XXX No. 123' }}</p>
                        <p class="text-gray-300">{{ $order->shipping_address['city'] ?? 'Kota' }}, {{ $order->shipping_address['postal_code'] ?? '12345' }}</p>
                        <p class="text-gray-300 mt-3 font-semibold">Telepon: {{ $order->shipping_address['phone'] ?? '0812xxxxxx' }}</p>
                    </div>

                    {{-- Ringkasan Pembayaran --}}
                    <div class="bg-gray-800 shadow-xl rounded-lg p-6">
                        <h3 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-3">Ringkasan Pembayaran</h3>
                        
                        <div class="space-y-2 text-gray-300">
                            <div class="flex justify-between">
                                <span>Subtotal:</span>
                                <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-700 flex justify-between items-center">
                            <span class="text-xl font-extrabold text-white">Total Akhir:</span>
                            <span class="text-2xl font-extrabold text-teal-400">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Tombol Kembali --}}
            <div class="mt-8 text-center">
                <a href="{{ route('shop.orders') }}" class="inline-flex items-center px-6 py-3 border border-gray-700 text-base font-medium rounded-full text-gray-300 bg-gray-800 hover:bg-gray-700 transition duration-150">
                    &larr; Kembali ke Daftar Pesanan
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
