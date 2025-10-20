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

            {{-- Grid Navigasi Cepat --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Card 1: Manajemen Produk --}}
                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-5 shadow-md hover:shadow-lg transition duration-200">
                    <h2 class="text-xl font-bold text-indigo-800 mb-2">Kelola Produk</h2>
                    <p class="text-gray-600 mb-4">Lihat, tambahkan, edit, dan hapus semua produk Renesca Aquatic.</p>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                            Daftar Produk &rarr;
                        </a>
                    </div>
                </div>

                {{-- Card 2: Kelola Pesanan --}}
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-5 shadow-md hover:shadow-lg transition duration-200">
                    <h2 class="text-xl font-bold text-yellow-800 mb-2">Lihat Pesanan</h2>
                    <p class="text-gray-600 mb-4">Lacak pesanan yang masuk dan perbarui status pengiriman pelanggan.</p>
                    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700">
                        Akses Daftar Pesanan &rarr;
                    </a>
                </div>

                {{-- Card 3: Manajemen Pengguna --}}
                <div class="bg-green-50 border border-green-200 rounded-lg p-5 shadow-md hover:shadow-lg transition duration-200">
                    <h2 class="text-xl font-bold text-green-800 mb-2">Atur Pengguna</h2>
                    <p class="text-gray-600 mb-4">Kelola daftar akun Customer dan Administrator.</p>
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                        Lihat Daftar Pengguna &rarr;
                    </a>
                </div>

                {{-- Card 4: Laporan Penjualan (BARU) --}}
                <div class="bg-red-50 border border-red-200 rounded-lg p-5 shadow-md hover:shadow-lg transition duration-200">
                    <h2 class="text-xl font-bold text-red-800 mb-2">Laporan Penjualan</h2>
                    <p class="text-gray-600 mb-4">Lihat statistik, ringkasan pendapatan, dan ekspor data ke Excel/PDF.</p>
                    <a href="{{ route('admin.sales.report') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                        Lihat Laporan &rarr;
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

