@extends('layouts.app') 
{{-- Menggunakan 'layouts.app' sesuai request user --}}

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
        {{-- BLOK KONTROL FILTER UTAMA --}}
        {{--------------------------------------------------}}
        <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Pilih Periode Laporan</h3>
            <form id="filterForm" action="{{ route('admin.sales.report') }}" method="GET" class="space-y-4">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between space-y-4 md:space-y-0 md:space-x-6">
                    
                    {{-- Filter Pilihan Cepat --}}
                    <div class="flex flex-col">
                        <label for="filter_select" class="font-medium text-gray-700 whitespace-nowrap mb-1">Filter Waktu:</label>
                        <select id="filter_select" name="filter" onchange="toggleCustomDates()"
                            class="p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:w-40 text-sm h-10">
                            <option value="monthly" {{ $filter === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            <option value="weekly" {{ $filter === 'weekly' ? 'selected' : '' }}>Mingguan</option>
                            <option value="today" {{ $filter === 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Semua Data</option>
                            <option value="custom" {{ $filter === 'custom' ? 'selected' : '' }}>Kustom</option>
                        </select>
                    </div>

                    {{-- Tombol Terapkan Filter --}}
                    <div class="w-full md:w-auto">
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 h-10 w-full md:w-auto">
                            Terapkan Filter
                        </button>
                    </div>
                </div>

                {{-- Input Tanggal Kustom (Akan muncul jika 'Kustom' dipilih) --}}
                <div id="customDateRange" class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 w-full pt-4 mt-4 border-t border-gray-100" 
                    style="display: {{ $filter === 'custom' ? 'flex' : 'none' }};">
                    <div class="w-full sm:w-auto">
                        <label for="start_date_custom" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal:</label>
                        {{-- Menggunakan $start_date atau $custom_start_date (yang berasal dari request) --}}
                        <input type="date" id="start_date_custom" name="start_date_custom" value="{{ $start_date ?? $custom_start_date ?? '' }}"
                            class="p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full">
                    </div>
                    <div class="w-full sm:w-auto">
                        <label for="end_date_custom" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal:</label>
                        {{-- Menggunakan $end_date atau $custom_end_date (yang berasal dari request) --}}
                        <input type="date" id="end_date_custom" name="end_date_custom" value="{{ $end_date ?? $custom_end_date ?? '' }}"
                            class="p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full">
                    </div>
                </div>
            </form>

            {{-- Label Rentang Waktu Aktif --}}
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-lg font-semibold text-gray-800">Periode Aktif: <span class="text-indigo-600">{{ $range_label }}</span></p>
            </div>
        </div>
        
        {{--------------------------------------------------}}
        {{-- BLOK STATISTIK RINGKAS (TAILWIND CARD FOCUS) --}}
        {{--------------------------------------------------}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            {{-- Total Pendapatan --}}
            <div class="bg-white p-6 rounded-xl shadow-lg border-b-4 border-green-500 transition duration-300 hover:shadow-xl">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">TOTAL PENDAPATAN</p>
                <div class="text-3xl font-extrabold text-green-600">{{ $total_revenue }}</div>
            </div>

            {{-- Total Pesanan --}}
            <div class="bg-white p-6 rounded-xl shadow-lg border-b-4 border-blue-500 transition duration-300 hover:shadow-xl">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">JUMLAH ORDER SELESAI</p>
                {{-- Menggunakan $total_orders dari controller --}}
                <div class="text-3xl font-extrabold text-blue-600">{{ number_format($total_orders, 0, ',', '.') }} Order</div>
            </div>

            {{-- Rata-rata Penjualan --}}
            <div class="bg-white p-6 rounded-xl shadow-lg border-b-4 border-yellow-500 transition duration-300 hover:shadow-xl">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">RATA-RATA PENJUALAN</p>
                {{-- Menggunakan $average_sale dari controller --}}
                <div class="text-3xl font-extrabold text-yellow-600">{{ $average_sale }}</div>
                <p class="text-xs text-gray-400 mt-1">Per Order Selesai</p>
            </div>
        </div>


        {{--------------------------------------------------}}
        {{-- BLOK TABEL DATA --}}
        {{--------------------------------------------------}}
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            
            {{-- Header Card --}}
            <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-2xl font-semibold text-gray-800">
                    <i class="fas fa-table mr-2 text-indigo-500"></i> Data Detail Transaksi
                </h3>
            </div>

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
                            {{-- Menggunakan $sale['total_formatted'] dari controller --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-lg font-bold text-gray-900">{{ $sale['total_formatted'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $sale['status'] }}
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
                                <span class="font-medium">Oops!</span> Tidak ada data transaksi ditemukan untuk periode **{{ $range_label }}**.
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
                        {{-- Export Excel: Meneruskan filter dan tanggal kustom --}}
                        <a href="{{ route('admin.sales.export.excel', ['filter' => $filter, 'start_date_custom' => $start_date, 'end_date_custom' => $end_date]) }}" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 shadow-md transition duration-150 h-10">
                            <i class="fas fa-file-excel mr-2"></i> Export Excel (CSV)
                        </a>
                        {{-- Export PDF: Meneruskan filter dan tanggal kustom --}}
                        <a href="{{ route('admin.sales.export.pdf', ['filter' => $filter, 'start_date_custom' => $start_date, 'end_date_custom' => $end_date]) }}" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 shadow-md transition duration-150 h-10">
                            <i class="fas fa-file-pdf mr-2"></i> Export PDF
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<script>
    function toggleCustomDates() {
        const filter = document.getElementById('filter_select').value;
        const customDateRange = document.getElementById('customDateRange');
        const startDateInput = document.getElementById('start_date_custom');
        const endDateInput = document.getElementById('end_date_custom');

        if (filter === 'custom') {
            customDateRange.style.display = 'flex';
            // Menambahkan required saat kustom dipilih
            startDateInput.setAttribute('required', 'required');
            endDateInput.setAttribute('required', 'required');
        } else {
            customDateRange.style.display = 'none';
            // Menghapus required saat filter lain dipilih
            startDateInput.removeAttribute('required');
            endDateInput.removeAttribute('required');
        }
    }

    // Panggil saat dokumen dimuat untuk mengatur tampilan awal yang benar (penting saat kembali dari export/page load)
    document.addEventListener('DOMContentLoaded', toggleCustomDates);
</script>

@endsection
