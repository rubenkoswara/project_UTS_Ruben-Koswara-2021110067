<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-teal-300 leading-tight">
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-xl sm:rounded-lg p-6 lg:p-8">

                {{-- Cek apakah ada pesanan --}}
                @if ($orders->isEmpty())
                    <div class="text-center py-10">
                        <svg class="mx-auto h-12 w-12 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <h3 class="mt-2 text-xl font-semibold text-white">Belum Ada Pesanan</h3>
                        <p class="mt-1 text-sm text-gray-400">Anda belum melakukan pembelian apa pun. Yuk, jelajahi katalog kami!</p>
                        <div class="mt-6">
                            <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-gray-900 bg-teal-500 hover:bg-teal-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition duration-150">
                                Lihat Produk
                            </a>
                        </div>
                    </div>
                @else
                    {{-- Daftar Pesanan --}}
                    <div class="space-y-6">
                        @foreach ($orders as $order)
                            <div class="bg-gray-700 overflow-hidden shadow-lg sm:rounded-lg p-5 border-l-4 border-teal-500 hover:bg-gray-700/80 transition duration-200">
                                <div class="flex flex-wrap justify-between items-center">
                                    
                                    {{-- ID Pesanan & Tanggal --}}
                                    <div class="w-full md:w-1/3 mb-4 md:mb-0">
                                        <p class="text-xs font-bold uppercase text-teal-400">ID Pesanan</p>
                                        <p class="text-lg font-extrabold text-white tracking-wider">{{ $order->id }}</p>
                                        <p class="text-sm text-gray-400 mt-1">Tanggal: {{ $order->created_at->format('d M Y') }}</p>
                                    </div>

                                    {{-- Total & Status --}}
                                    <div class="w-1/2 md:w-1/3 mb-4 md:mb-0">
                                        <p class="text-xs font-bold uppercase text-teal-400">Total Pembayaran</p>
                                        <p class="text-xl font-bold text-yellow-300">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                                        <span class="mt-1 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium 
                                            @if ($order->status == 'Pending') bg-yellow-600 text-yellow-100
                                            @elseif ($order->status == 'Shipped') bg-blue-600 text-blue-100
                                            @elseif ($order->status == 'Completed') bg-green-600 text-green-100
                                            @elseif ($order->status == 'Cancelled') bg-red-600 text-red-100
                                            @endif">
                                            {{ $order->status }}
                                        </span>
                                    </div>
                                    
                                    {{-- Tombol Detail --}}
                                    <div class="w-1/2 md:w-1/3 text-right">
                                        {{-- PASTIKAN route shop.orderDetail ADA di routes/web.php --}}
                                        <a href="{{ route('shop.orderDetail', $order->id) }}" class="inline-flex items-center px-4 py-2 border border-teal-500 text-sm font-medium rounded-full text-teal-400 hover:bg-teal-500 hover:text-gray-900 transition duration-300">
                                            Lihat Detail
                                            <svg class="ml-2 -mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Pagination (jika menggunakan paginate) --}}
                    <div class="mt-8 text-white">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
