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

            {{-- Grid Navigasi Cepat (Dengan Ikon & Statistik) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Card 1: Manajemen Produk (Indigo) --}}
                <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-extrabold text-indigo-800">Kelola Produk</h2>
                        {{-- Ikon Box --}}
                        <div class="text-indigo-600 bg-indigo-200 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10h4m2-3h.01M20 7v10h-4m-2-3h.01m-6.99-3h.01M10 10h4m-2-3h.01m-2.99 0h.01M16 14h-4m2 3h.01" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex-grow">
                        <p class="text-sm text-gray-600 mb-4">Lihat, tambahkan, edit, dan hapus semua produk Renesca Aquatic.</p> {{-- Deskripsi --}}

                        {{-- Dummy Statistik --}}
                        <p class="text-4xl font-bold text-indigo-900 mb-1">14</p>
                        <p class="text-sm text-gray-600 mb-4">Total Jenis Produk</p>
                    </div>

                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('admin.products.index') }}" class="w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150">
                            Lihat Inventaris &rarr;
                        </a>
                    </div>
                </div>

                {{-- Card 2: Kelola Pesanan (Yellow) --}}
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-extrabold text-yellow-800">Lihat Pesanan</h2>
                        {{-- Ikon Box --}}
                        <div class="text-yellow-600 bg-yellow-200 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex-grow">
                        <p class="text-sm text-gray-600 mb-4">Lacak pesanan yang masuk dan perbarui status pengiriman pelanggan.</p> {{-- Deskripsi --}}
                        
                        {{-- Dummy Statistik --}}
                        <p class="text-4xl font-bold text-yellow-900 mb-1">2</p>
                        <p class="text-sm text-gray-600 mb-4">Pesanan Belum Diproses</p>
                    </div>
                    
                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('admin.orders.index') }}" class="w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 transition duration-150">
                            Akses Daftar Pesanan &rarr;
                        </a>
                    </div>
                </div>

                {{-- Card 3: Manajemen Pengguna (Green) --}}
                <div class="bg-green-50 border border-green-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-extrabold text-green-800">Atur Pengguna</h2>
                        {{-- Ikon Box --}}
                        <div class="text-green-600 bg-green-200 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2c0-.656-.126-1.283-.356-1.857M9 20H4v-2a3 3 0 015-2.236M9 20v-2a3 3 0 00-2.236-2.812l-1.396-.5M15 11a3 3 0 10-6 0 3 3 0 006 0zm-6 0h.01" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex-grow">
                        <p class="text-sm text-gray-600 mb-4">Kelola daftar akun Customer dan Administrator.</p> {{-- Deskripsi --}}
                        
                        {{-- Dummy Statistik --}}
                        <p class="text-4xl font-bold text-green-900 mb-1">2</p>
                        <p class="text-sm text-gray-600 mb-4">Total Pengguna Terdaftar</p>
                    </div>
                    
                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('admin.users.index') }}" class="w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 transition duration-150">
                            Lihat Daftar Pengguna &rarr;
                        </a>
                    </div>
                </div>

                {{-- Card 4: Laporan Penjualan (Red) --}}
                <div class="bg-red-50 border border-red-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-extrabold text-red-800">Laporan Penjualan</h2>
                        {{-- Ikon Box --}}
                        <div class="text-red-600 bg-red-200 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6m0 0h14m-12 0h-2m2 0v-4m-3-1a2 2 0 012-2h4a2 2 0 012 2v5m0 0h2a2 2 0 002-2v-4m-7-3h6l2-6H7l2 6z" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex-grow">
                        <p class="text-sm text-gray-600 mb-4">Lihat statistik, ringkasan pendapatan, dan ekspor data ke Excel/PDF.</p> {{-- Deskripsi --}}

                        {{-- Dummy Statistik --}}
                        <p class="text-4xl font-bold text-red-900 mb-1">Rp 4,3 Jt</p>
                        <p class="text-sm text-gray-600 mb-4">Pendapatan Bulan Ini</p>
                    </div>
                    
                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('admin.sales.report') }}" class="w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 transition duration-150">
                            Lihat Laporan &rarr;
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
