@extends('layouts.app') 

@section('title', 'Laporan Penjualan')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Laporan Penjualan & Analisis Transaksi') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- Pesan Sukses/Error --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif
        
        {{--------------------------------------------------}}
        {{-- BLOK STATISTIK RINGKAS (TAILWIND CARD FOCUS) --}}
        {{--------------------------------------------------}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            {{-- Total Pendapatan --}}
            <div class="bg-white p-6 rounded-xl shadow-lg border-b-4 border-green-500 transition duration-300 hover:shadow-xl">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">TOTAL PENDAPATAN ({{ ucfirst($filter) }})</p>
                <div class="text-3xl font-extrabold text-green-600">{{ $total_revenue }}</div>
            </div>

            {{-- Total Pesanan --}}
            <div class="bg-white p-6 rounded-xl shadow-lg border-b-4 border-blue-500 transition duration-300 hover:shadow-xl">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">JUMLAH ORDER SELESAI ({{ ucfirst($filter) }})</p>
                <div class="text-3xl font-extrabold text-blue-600">{{ $total_orders }} Order</div>
            </div>

            {{-- Rata-rata Penjualan --}}
            <div class="bg-white p-6 rounded-xl shadow-lg border-b-4 border-yellow-500 transition duration-300 hover:shadow-xl">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">RATA-RATA PENJUALAN</p>
                <div class="text-3xl font-extrabold text-yellow-600">Rp 450.000</div>
                <p class="text-xs text-gray-400 mt-1">Per Order Selesai</p>
            </div>
        </div>


        {{--------------------------------------------------}}
        {{-- BLOK KONTROL FILTER & TABEL DATA (STRUKTUR FINAL) --}}
        {{--------------------------------------------------}}
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            
            {{-- Header Card --}}
            <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-2xl font-semibold text-gray-800">
                    <i class="fas fa-table mr-2 text-indigo-500"></i> Data Detail Transaksi
                </h3>
            </div>

            {{-- Kontrol Filter (DITEMPATKAN DI ATAS TABEL) --}}
            <div class="p-6 border-b border-gray-200">
                
                {{-- Hanya Container Filter Periode --}}
                <div class="flex flex-col">
                    <label for="filter_select_top" class="text-sm font-medium text-gray-700 mb-2">Filter Periode</label>
                    <form action="{{ route('admin.sales.report') }}" method="GET" class="flex items-end space-x-3">
                        <select name="filter" id="filter_select_top" class="form-select block w-40 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm h-10">
                            <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="weekly" {{ $filter == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                            <option value="monthly" {{ $filter == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua Data</option>
                        </select>
                        <button type="submit" class="inline-flex items-center px-4 py-2 h-10 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            Terapkan Filter
                        </button>
                    </form>
                </div>

            </div>
            {{-- Akhir Kontrol Filter --}}

            {{-- TABEL DATA --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50"> 
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Order</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Transaksi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Penjualan</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($sales as $index => $sale)
                        <tr class="hover:bg-gray-50 transition duration-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                <a href="#">{{ $sale['id'] }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $sale['date_formatted'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $sale['customer'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-lg font-bold text-gray-900">{{ $sale['total_formatted'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Selesai
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 transition duration-150" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500 bg-gray-50">
                                <i class="far fa-frown text-5xl text-gray-300 mb-3 block"></i>
                                <span class="font-medium">Oops!</span> Tidak ada data transaksi ditemukan untuk periode **{{ ucfirst($filter) }}**.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- OPSI EXPORT (DITEMPATKAN DI BAWAH TABEL) --}}
            <div class="p-6 pt-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                <div class="flex flex-col items-start">
                    <span class="block text-sm font-semibold text-gray-700 mb-2">Opsi Export Data</span>
                    <div class="flex space-x-4"> 
                        <a href="{{ route('admin.sales.export.excel', ['filter' => $filter]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 shadow-md transition duration-150 h-10">
                            <i class="fas fa-file-excel mr-2"></i> Export Excel
                        </a>
                        <a href="{{ route('admin.sales.export.pdf', ['filter' => $filter]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 shadow-md transition duration-150 h-10">
                            <i class="fas fa-file-pdf mr-2"></i> Export PDF
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
