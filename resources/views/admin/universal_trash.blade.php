@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Tempat Sampah Universal') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-3 flex items-center">
                <svg class="w-7 h-7 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Daftar Item Dihapus
            </h1>
            
            <!-- Pesan Status (Success/Error) -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if ($trashedItems->isEmpty())
                <div class="text-center p-10 bg-gray-50 rounded-lg border border-dashed text-gray-500">
                    <p class="text-lg font-semibold">Tempat Sampah Kosong</p>
                    <p>Tidak ada item yang dihapus secara lunak (soft-deleted).</p>
                </div>
            @else
                <!-- Tabel Daftar Item yang Dihapus -->
                <div class="overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Item / ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Model</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dihapus Pada</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($trashedItems as $item)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $item->readableName }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ ucfirst($item->modelType) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->deleted_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                                        
                                        <!-- Aksi Restore (Menggunakan Nama Rute Lengkap: admin.universal-trash.restore) -->
                                        <form action="{{ route('admin.universal-trash.restore', ['modelType' => $item->modelType, 'id' => $item->id]) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Anda yakin ingin memulihkan item {{ $item->readableName }}?');">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 font-semibold transition duration-150 text-xs">
                                                Pulihkan
                                            </button>
                                        </form>

                                        <!-- Aksi Delete Permanen (Menggunakan Nama Rute Lengkap: admin.universal-trash.forceDelete) -->
                                        <form action="{{ route('admin.universal-trash.forceDelete', ['modelType' => $item->modelType, 'id' => $item->id]) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('PERINGATAN: Penghapusan item {{ $item->readableName }} ini permanen dan tidak dapat dibatalkan. Anda yakin?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold transition duration-150 text-xs">
                                                Hapus Permanen
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
