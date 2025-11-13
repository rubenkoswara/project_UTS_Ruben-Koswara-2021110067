@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Produk') }}
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
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2">Daftar Produk</h1>
            
            <!-- Tombol Tambah Produk & Kelola Kategori -->
            <div class="mb-4 flex space-x-4">
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Produk Baru
                </a>
                
                {{-- Tombol Kelola Kategori --}}
                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h4a2 2 0 012 2v2a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2zm10 0h4a2 2 0 012 2v2a2 2 0 01-2 2h-4a2 2 0 01-2-2V5a2 2 0 012-2zM7 13h4a2 2 0 012 2v2a2 2 0 01-2 2H7a2 2 0 01-2-2v-2a2 2 0 012-2zm10 0h4a2 2 0 012 2v2a2 2 0 01-2 2h-4a2 2 0 01-2-2v-2a2 2 0 012-2z"></path></svg>
                    Kelola Kategori
                </a>
            </div>

            <!-- Form Filter dan Search -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0 md:space-x-4">
                
                <!-- Search Bar -->
                <form action="{{ route('admin.products.index') }}" method="GET" class="w-full md:w-1/3 order-2 md:order-1">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Cari nama produk..." 
                                class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                value="{{ request('search') }}">
                        <button type="submit" class="absolute right-0 top-0 mt-3 mr-4 text-gray-400 hover:text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </div>
                </form>

                <!-- Filter Kategori -->
                <form action="{{ route('admin.products.index') }}" method="GET" class="w-full md:w-auto order-1 md:order-2 flex items-center space-x-2">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <label for="category_filter" class="text-sm font-medium text-gray-700 whitespace-nowrap">Filter Kategori:</label>
                    <select name="category" id="category_filter" onchange="this.form.submit()"
                            class="block w-full md:w-48 py-2 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        
                        <option value="all" @if (!request('category') || request('category') == 'all') selected @endif>Semua Kategori</option>
                        
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" 
                                        @if (request('category') == $category->slug) selected @endif>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @if(request()->has('search') || request()->has('category') && request('category') !== 'all')
                        <a href="{{ route('admin.products.index') }}" class="text-sm text-red-600 hover:text-red-800 whitespace-nowrap">Reset</a>
                    @endif
                </form>

            </div>

            <!-- Tabel Data Produk -->
            <div class="overflow-x-auto mt-4 shadow-lg rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Gambar</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Kategori</th> 
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($product->image)
                                    <!-- PERUBAHAN: Menggunakan \Illuminate\Support\Facades\Storage::url() -->
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" 
                                        alt="{{ $product->name }}" 
                                        class="h-12 w-12 object-cover rounded-md shadow-sm cursor-pointer zoomable-image"
                                        data-full-src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}"
                                        data-title="{{ $product->name }}"
                                        {{-- Fallback jika Storage::url gagal (misalnya symlink rusak), mencoba asset() --}}
                                        onerror="this.onerror=null; this.src='{{ asset('storage/' . $product->image) }}'; this.dataset.fullSrc='{{ asset('storage/' . $product->image) }}'; if (this.src.includes('404')) { this.src='https://placehold.co/48x48/CCCCCC/333333?text=404' }"
                                        >
                                @else
                                    <div class="h-12 w-12 bg-gray-200 rounded-md flex items-center justify-center text-xs text-gray-500 font-medium border border-dashed">No Image</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    // Logic for category badge styling
                                    $categorySlug = $product->category->slug ?? 'default';
                                    $categoryClass = '';
                                    switch ($categorySlug) {
                                        case 'filtrasi-aerasi': $categoryClass = 'bg-blue-100 text-blue-800'; break;
                                        case 'pencahayaan-pemanas': $categoryClass = 'bg-yellow-100 text-yellow-800'; break;
                                        case 'pakan-obat': $categoryClass = 'bg-green-100 text-green-800'; break;
                                        case 'akuarium-dekorasi': $categoryClass = 'bg-indigo-100 text-indigo-800'; break;
                                        default: $categoryClass = 'bg-gray-100 text-gray-800'; break;
                                    }
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $categoryClass }}">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-semibold">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    // Logic for stock badge styling
                                    $stockClass = 'bg-green-100 text-green-800';
                                    if ($product->stock <= 5) {
                                        $stockClass = 'bg-red-100 text-red-800';
                                    } elseif ($product->stock <= 20) {
                                        $stockClass = 'bg-yellow-100 text-yellow-800';
                                    }
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $stockClass }}">
                                    {{ $product->stock }} Unit
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs overflow-hidden truncate">
                                {{ $product->description }}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-3 transition duration-150">Edit</a>
                                
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                     
                                    <button type="button" 
                                            onclick="showDeleteModal('{{ $product->name }}', '{{ route('admin.products.destroy', $product) }}')" 
                                            class="text-red-600 hover:text-red-900 transition duration-150">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data produk yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>
            
        </div>
    </div>
</div>

<!-- ================= MODAL IMAGE ZOOM ================= -->
<div id="imageZoomModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50 p-4" onclick="closeImageZoomModal()">
    <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full p-6" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-900">Judul Gambar</h3>
            <button onclick="closeImageZoomModal()" class="text-gray-500 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <img id="zoomedImage" src="" alt="Gambar Produk Diperbesar" class="w-full h-auto object-contain max-h-[80vh] rounded-lg">
    </div>
</div>

<!-- ================= MODAL DELETE CONFIRMATION ================= -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full p-6" onclick="event.stopPropagation()">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Konfirmasi Hapus</h3>
        <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus produk <span id="productName" class="font-semibold"></span>?</p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

{{-- Pindahkan skrip dari @section('scripts') ke sini agar selalu ter-load --}}
<script>
    // --- Image Zoom Logic ---
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('imageZoomModal');
        const zoomedImage = document.getElementById('zoomedImage');
        const modalTitle = document.getElementById('modalTitle');
        const zoomableImages = document.querySelectorAll('.zoomable-image');

        if (!modal) {
            console.error('Image Zoom Modal element not found.');
            return;
        }

        zoomableImages.forEach(img => {
            img.addEventListener('click', function() {
                const fullSrc = this.getAttribute('data-full-src');
                const title = this.getAttribute('data-title');
                
                if (fullSrc) {
                    zoomedImage.src = fullSrc;
                    modalTitle.textContent = title;
                    // Tampilkan modal
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }
            });
        });
    });

    function closeImageZoomModal() {
        const modal = document.getElementById('imageZoomModal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }

    // --- Delete Modal Logic (Mengganti window.confirm) ---
    function showDeleteModal(productName, deleteRoute) {
        const modal = document.getElementById('deleteModal');
        const nameSpan = document.getElementById('productName');
        const deleteForm = document.getElementById('deleteForm');

        if (modal) {
            nameSpan.textContent = productName;
            deleteForm.action = deleteRoute;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }
</script>
