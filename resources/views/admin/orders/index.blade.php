@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Pesanan Renesca Aquatic') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg" role="alert">
                <p class="font-bold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2 border-gray-200">Daftar Pesanan Customer</h1>
            
            <form action="{{ route('admin.orders.index') }}" method="GET" class="mb-6 flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
                {{-- Pencarian --}}
                <div class="flex-grow w-full sm:w-auto">
                    <label for="search" class="sr-only">Cari Pesanan</label>
                    <input type="search" name="search" id="search" placeholder="Cari ID Pesanan atau Nama Customer..." 
                           value="{{ request('search') }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                
                {{-- Filter Status (Select Dropdown - Lebih Rapi) --}}
                <div class="w-full sm:w-auto">
                    <label for="status_filter" class="sr-only">Filter Status</label>
                    <select name="status" id="status_filter" onchange="this.form.submit()"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @php
                            $statuses = ['All', 'Pending', 'Processed', 'Shipped', 'Completed', 'Cancelled']; 
                            $currentStatus = request('status', 'All');
                        @endphp
                        @foreach ($statuses as $statusOption)
                            <option value="{{ $statusOption }}" {{ $currentStatus === $statusOption ? 'selected' : '' }}>
                                {{ $statusOption }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol Reset --}}
                <a href="{{ route('admin.orders.index') }}" class="w-full sm:w-auto px-4 py-2 text-sm font-medium rounded-lg text-gray-700 bg-gray-200 hover:bg-gray-300 text-center">
                    Reset
                </a>
            </form>

            <div class="overflow-x-auto mt-4 border border-gray-200 rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
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
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orders as $order)
                        <tr class="hover:bg-indigo-50/50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600">
                                #{{ $order->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $order->user->name ?? 'Pengguna Tamu' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-700">
                                {{ $order->formatted_grand_total }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $orderStatus = $order->status;
                                    
                                    $statusColor = match ($orderStatus) {
                                        'Completed' => 'bg-green-100 text-green-800',
                                        'Shipped'   => 'bg-indigo-100 text-indigo-800', 
                                        'Processed' => 'bg-blue-100 text-blue-800',
                                        'Cancelled' => 'bg-red-100 text-red-800',
                                        default     => 'bg-yellow-100 text-yellow-800',
                                    };
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                    {{ $orderStatus }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-800 font-bold transition duration-150">
                                    Detail &rarr;
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 bg-gray-50">Tidak ada pesanan yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginasi --}}
            <div class="mt-6">
                @if(isset($orders) && method_exists($orders, 'links'))
                    {{ $orders->appends(request()->query())->links() }}
                @endif
            </div>
            
        </div>
    </div>
</div>
@endsection
