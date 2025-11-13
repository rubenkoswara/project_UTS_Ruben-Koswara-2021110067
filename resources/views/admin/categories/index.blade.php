@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Kategori Produk') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg" role="alert">
                <p class="font-bold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2">Daftar Kategori</h1>

            <!-- Form Tambah Kategori (CREATE SECTION) -->
            <div class="mb-8 border p-4 rounded-lg bg-gray-50">
                <h2 class="text-xl font-semibold mb-3 text-gray-800">Tambah Kategori Baru</h2>
                <form action="{{ route('admin.categories.store') }}" method="POST" class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3">
                    @csrf
                    
                    <div class="flex-grow">
                        <input type="text" name="name" placeholder="Nama Kategori (mis: Filtrasi & Aerasi)" 
                               value="{{ old('name') }}" required
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <input type="text" name="slug" placeholder="Slug (Opsional)" 
                               value="{{ old('slug') }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('slug') border-red-500 @enderror">
                        @error('slug')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150">
                        Simpan
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Kategori (READ & EDIT SECTION) -->
            <div class="overflow-x-auto shadow-lg rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-1/12">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-4/12">Nama Kategori</th> 
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-4/12">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-3/12">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Data Kategori akan dilewatkan dari CategoryController@index --}}
                        @forelse ($categories as $category)
                        {{-- Alpine.js for Inline Editing --}}
                        <tr x-data="{ editing: false, newName: '{{ $category->name }}', newSlug: '{{ $category->slug }}' }">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->id }}</td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <span x-show="!editing">{{ $category->name }}</span>
                                <input x-show="editing" type="text" x-model="newName" 
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <span x-show="!editing">{{ $category->slug }}</span>
                                <input x-show="editing" type="text" x-model="newSlug" 
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                {{-- Tombol Edit/Simpan --}}
                                <button x-show="!editing" @click="editing = true" class="text-indigo-600 hover:text-indigo-900 mr-3 transition duration-150">Edit</button>

                                <span x-show="editing" class="flex space-x-2">
                                    {{-- Form Update (EDIT) --}}
                                    <form :action="'{{ route('admin.categories.update', $category) }}'" method="POST" x-ref="updateForm" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="name" :value="newName">
                                        <input type="hidden" name="slug" :value="newSlug">
                                        <button type="submit" class="text-green-600 hover:text-green-900 transition duration-150">Simpan</button>
                                    </form>
                                    <button @click="editing = false" class="text-gray-600 hover:text-gray-900 transition duration-150">Batal</button>
                                </span>
                                
                                {{-- Tombol Hapus (DELETE) --}}
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline ml-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}?')" class="text-red-600 hover:text-red-900 transition duration-150">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada kategori yang dibuat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Asumsi Pagination ada --}}
            {{-- <div class="mt-4">
                {{ $categories->links() }}
            </div> --}}
            
            <div class="mt-8">
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    &larr; Kembali ke Manajemen Produk
                </a>
            </div>

        </div>
    </div>
</div>
@endsection