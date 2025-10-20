@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Pesanan Renesca Aquatic') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Area Pesan Sukses (Opsional) --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg" role="alert">
                <p class="font-bold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- KONTEN UTAMA: bg-white untuk Light Mode --}}
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2 border-gray-200">Daftar Pesanan Customer</h1>

            {{-- Filter Status --}}
            @php
                $currentStatus = request('status');
                $statuses = ['All', 'Pending', 'Shipped', 'Completed', 'Cancelled']; 
            @endphp

            <div class="mb-6 flex space-x-3 overflow-x-auto pb-2">
                @foreach ($statuses as $status)
                    <a href="{{ route('admin.orders.index', ['status' => $status == 'All' ? null : $status]) }}" 
                        class="flex-shrink-0 px-4 py-2 text-sm font-medium rounded-lg transition duration-150 
                        {{ $currentStatus === $status || ($currentStatus === null && $status === 'All') 
                            ? 'bg-indigo-600 text-white shadow-lg' 
                            : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ $status }}
                    </a>
                @endforeach
            </div>

            <div class="overflow-x-auto mt-4 border border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    {{-- HEADER TABEL --}}
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    {{-- BODY TABEL --}}
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orders as $order)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            {{-- ID Pesanan --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600">
                                #{{ $order->id }}
                            </td>

                            {{-- Nama Customer --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $order->user->name ?? 'Pengguna Tamu' }}
                            </td>

                            {{-- Tanggal Pesan --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d M Y') }}
                            </td>

                            {{-- Total Biaya --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>

                            {{-- Status Pesanan --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $orderStatus = $order->status;
                                    
                                    $statusColor = match ($orderStatus) {
                                        'Completed' => 'bg-green-100 text-green-800',
                                        'Shipped'   => 'bg-blue-100 text-blue-800', 
                                        'Cancelled' => 'bg-red-100 text-red-800',
                                        default     => 'bg-yellow-100 text-yellow-800', // Pending/Default
                                    };
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                    {{ $orderStatus }}
                                </span>
                            </td>

                            {{-- Aksi (Lihat Detail) --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900 hover:underline transition duration-150">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data pesanan yang tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginasi --}}
            @if(isset($orders) && method_exists($orders, 'links'))
                {{-- Menggunakan class tambahan untuk memastikan tombol paginasi menjadi light mode --}}
                <div class="mt-4">
                    {{-- Tombol paginasi Laravel akan menggunakan styling Light Mode default Tailwind --}}
                    <div class="text-gray-700"> 
                         {{ $orders->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                {{-- SIMULASI PAGINASI (Jika menggunakan HTML manual seperti pada gambar) --}}
                <div class="mt-4 flex justify-between items-center text-sm">
                    <p class="text-gray-500">Showing 1 to 5 of 8 results</p>
                    <div class="flex items-center space-x-1">
                        {{-- Tombol Previous --}}
                        <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-100 disabled:opacity-50">
                            <
                        </button>
                        
                        {{-- Tombol Halaman Aktif (Biru/Aktif) --}}
                        <button class="px-3 py-1 border border-indigo-600 rounded-lg text-white bg-indigo-600 font-semibold">
                            1
                        </button>
                        
                        {{-- Tombol Halaman Lain (Putih/Normal) --}}
                        <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-100">
                            2
                        </button>
                        
                        {{-- Tombol Next --}}
                        <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-100">
                            >
                        </button>
                    </div>
                </div>
            @endif
            
            {{-- Catatan --}}
            <p class="mt-8 text-sm text-gray-500 italic">Catatan: Tampilan ini menggunakan data dummy dan paginasi manual untuk simulasi.</p>
        </div>
    </div>
</div>
@endsection