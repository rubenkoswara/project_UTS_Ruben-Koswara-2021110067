@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
{{ __('Dashboard Administrator Renesca Aquatic') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2">
                Selamat Datang, Administrator!
            </h1>
            <p class="text-gray-600 mb-8">
                Panel ini adalah pusat kendali untuk mengelola inventaris, pesanan, dan pengguna Renesca Aquatic.
            </p>

            {{-- Grid Kontrol Utama --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Card: Kelola Produk --}}
                <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-extrabold text-indigo-800">Kelola Produk</h2>
                        <div class="text-indigo-600 bg-indigo-200 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10h4m2-3h.01M20 7v10h-4m-2-3h.01m-6.99-3h.01M10 10h4m-2-3h.01m-2.99 0h.01M16 14h-4m2 3h.01" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex-grow">
                        <p class="text-sm text-gray-600 mb-4">Lihat, tambahkan, edit, dan hapus semua produk Renesca Aquatic.</p> 
                    </div>

                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('admin.products.index') }}" class="w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150">
                            Lihat Inventaris &rarr;
                        </a>
                    </div>
                </div>

                {{-- Card: Lihat Pesanan --}}
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-extrabold text-yellow-800">Lihat Pesanan</h2>
                        <div class="text-yellow-600 bg-yellow-200 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex-grow">
                        <p class="text-sm text-gray-600 mb-4">Lacak pesanan yang masuk dan perbarui status pengiriman pelanggan.</p> 
                    </div>
                    
                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('admin.orders.index') }}" class="w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 transition duration-150">
                            Akses Daftar Pesanan &rarr;
                        </a>
                    </div>
                </div>

                {{-- Card: Atur Pengguna --}}
                <div class="bg-green-50 border border-green-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-extrabold text-green-800">Atur Pengguna</h2>
                        <div class="text-green-600 bg-green-200 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2c0-.656-.126-1.283-.356-1.857M9 20H4v-2a3 3 0 015-2.236M9 20v-2a3 3 0 00-2.236-2.812l-1.396-.5M15 11a3 3 0 10-6 0 3 3 0 006 0zm-6 0h.01" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex-grow">
                        <p class="text-sm text-gray-600 mb-4">Kelola daftar akun Customer dan Administrator.</p> 
                    </div>
                    
                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('admin.users.index') }}" class="w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 transition duration-150">
                            Lihat Daftar Pengguna &rarr;
                        </a>
                    </div>
                </div>

                {{-- Card: Laporan Penjualan --}}
                <div class="bg-red-50 border border-red-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-extrabold text-red-800">Laporan Penjualan</h2>
                        <div class="text-red-600 bg-red-200 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6m0 0h14m-12 0h-2m2 0v-4m-3-1a2 2 0 012-2h4a2 2 0 012 2v5m0 0h2a2 2 0 002-2v-4m-7-3h6l2-6H7l2 6z" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex-grow">
                        <p class="text-sm text-gray-600 mb-4">Lihat statistik, ringkasan pendapatan, dan ekspor data ke Excel/PDF.</p> 
                    </div>
                    
                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('admin.sales.report') }}" class="w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 transition duration-150">
                            Lihat Laporan &rarr;
                        </a>
                    </div>
                </div>
            </div>

            {{-- Grid Kontrol Tambahan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">

                {{-- Card: Kelola Kategori --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-extrabold text-blue-800">Kelola Kategori</h2>
                        <div class="text-blue-600 bg-blue-200 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex-grow">
                        <p class="text-sm text-gray-600 mb-4">Atur kategori untuk mengelompokkan produk di toko.</p> 
                    </div>

                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('admin.categories.index') }}" class="w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition duration-150">
                            Atur Kategori &rarr;
                        </a>
                    </div>
                </div>

                {{-- Card: Konfigurasi Pembayaran/Pengiriman --}}
                <div class="bg-teal-50 border border-teal-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-extrabold text-teal-800">Konfigurasi Metode</h2>
                        <div class="text-teal-600 bg-teal-200 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4c2.632 0 4 2.106 4 4s-1.368 4-4 4m0 0c-2.632 0-4-2.106-4-4s1.368-4 4-4m0 0v-2m0 2H8m4 0h4m-4 0v-4" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex-grow">
                        <p class="text-sm text-gray-600 mb-4">Atur metode pembayaran dan layanan pengiriman yang tersedia di toko.</p> 
                    </div>

                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('admin.config.index') }}" class="w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 transition duration-150">
                            Atur Konfigurasi &rarr;
                        </a>
                    </div>
                </div>

                {{-- Card: TEMPAT SAMPAH UNIVERSAL (BARU) --}}
                <div class="bg-purple-50 border border-purple-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-extrabold text-purple-800">Tempat Sampah</h2>
                        <div class="text-purple-600 bg-purple-200 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex-grow">
                        <p class="text-sm text-gray-600 mb-4">Lihat dan pulihkan item yang telah dihapus (soft-deleted).</p> 
                        {{-- Anggap 3 item sedang di dalam tempat sampah --}}
                    </div>

                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('admin.universal-trash.index') }}" class="w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 transition duration-150">
                            Akses Tempat Sampah &rarr;
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
