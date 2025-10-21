@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Produk Renesca Aquatic') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Area Pesan Sukses (Jika diperlukan, meski CRUD dinonaktifkan) --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p class="font-bold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2">Daftar Produk</h1>
            
            {{-- ======================================================= --}}
            {{-- BLOK PENCARIAN & FILTER KATEGORI --}}
            {{-- ======================================================= --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                
                {{-- Form Pencarian --}}
                <form action="{{ route('admin.products.index') }}" method="GET" class="w-full md:w-1/3">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Cari nama produk..." 
                               class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                               value="{{ request('search') }}">
                        <button type="submit" class="absolute right-0 top-0 mt-3 mr-4 text-gray-400 hover:text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </div>
                </form>

                {{-- Filter Kategori (Dropdown Sederhana) --}}
                <form action="{{ route('admin.products.index') }}" method="GET" class="w-full md:w-auto">
                    {{-- Input tersembunyi untuk mempertahankan nilai pencarian saat memfilter kategori --}}
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <select name="category" onchange="this.form.submit()"
                            class="block w-full md:w-48 py-2 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        
                        <option value="all" @if (!request('category') || request('category') == 'all') selected @endif>Semua Kategori</option>
                        
                        @foreach ($categories as $category)
                            <option value="{{ $category['slug'] }}" 
                                    @if (request('category') == $category['slug']) selected @endif>
                                {{ $category['name'] }}
                            </option>
                        @endforeach
                    </select>
                </form>

            </div>
            {{-- ======================================================= --}}

            <div class="overflow-x-auto mt-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                            {{-- KOLOM KATEGORI BARU --}}
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th> 
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                            
                            {{-- TAMPILAN KATEGORI --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    // Pilihan warna badge sederhana berdasarkan kategori slug
                                    $categoryClass = '';
                                    switch ($product->slug) {
                                        case 'filtrasi-aerasi': $categoryClass = 'bg-blue-100 text-blue-800'; break;
                                        case 'pencahayaan-pemanas': $categoryClass = 'bg-yellow-100 text-yellow-800'; break;
                                        case 'pakan-obat': $categoryClass = 'bg-green-100 text-green-800'; break;
                                        case 'akuarium-dekorasi': $categoryClass = 'bg-indigo-100 text-indigo-800'; break;
                                        default: $categoryClass = 'bg-gray-100 text-gray-800'; break;
                                    }
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $categoryClass }}">
                                    {{ $product->category }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-semibold">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $stockClass = 'bg-green-100 text-green-800';
                                    if ($product->stock <= 5) {
                                        $stockClass = 'bg-red-100 text-red-800'; // Stok kritis
                                    } elseif ($product->stock <= 20) {
                                        $stockClass = 'bg-yellow-100 text-yellow-800'; // Stok rendah
                                    }
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $stockClass }}">
                                    {{ $product->stock }} Unit
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-sm overflow-hidden truncate">
                                {{ $product->description }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Data dummy produk Renesca Aquatic tidak ditemukan. Coba hapus filter kategori atau pencarian.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <p class="mt-8 text-sm text-gray-500 italic">Catatan: Tampilan ini menggunakan data dummy sesuai persyaratan tugas UTS.</p>
        </div>
    </div>
</div>
@endsection
