@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Konfigurasi
    </h2>
@endsection

@section('content')

<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <div class="flex justify-between items-center mb-6 border-b pb-4 border-gray-200">
        <h1 class="text-3xl font-bold text-gray-900">Konfigurasi Metode & Jasa</h1>
    </div>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
            <p class="font-bold">Berhasil</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Notifikasi Error Validasi --}}
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
            <p class="font-bold">Gagal!</p>
            <ul class="mt-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Penggunaan Alpine.js untuk Tab --}}
    <div x-data="{ activeTab: 'payment' }" class="space-y-8">
        {{-- Tombol Tab Navigation --}}
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="activeTab = 'payment'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'payment', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'payment' }" 
                        class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-lg transition duration-150 ease-in-out focus:outline-none">
                    Metode Pembayaran
                </button>
                <button @click="activeTab = 'shipping'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'shipping', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'shipping' }" 
                        class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-lg transition duration-150 ease-in-out focus:outline-none">
                    Jasa Kirim
                </button>
            </nav>
        </div>

        {{-- ################################################## --}}
        {{-- TAB: METODE PEMBAYARAN --}}
        {{-- ################################################## --}}
        <div x-show="activeTab === 'payment'" class="space-y-8">

            {{-- Formulir Tambah Metode Pembayaran --}}
            <div class="bg-white shadow-lg rounded-xl p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">Tambah Metode Pembayaran Baru</h2>
                {{-- FORMULIR TAMBAH DENGAN KOLOM BARU --}}
                <form action="{{ route('admin.config.storePaymentMethod') }}" method="POST" class="grid grid-cols-1 md:grid-cols-7 gap-4 items-end">
                    @csrf
                    <div class="col-span-2">
                        <label for="name_payment" class="block text-sm font-medium text-gray-700">Nama Metode</label>
                        <input type="text" id="name_payment" name="name" value="{{ old('name') }}" required 
                               class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="code_payment" class="block text-sm font-medium text-gray-700">Kode</label>
                        <input type="text" id="code_payment" name="code" value="{{ old('code') }}" required 
                               class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 uppercase">
                    </div>
                    <div class="col-span-2">
                        <label for="account_number" class="block text-sm font-medium text-gray-700">Nomor Akun/Rekening</label>
                        <input type="text" id="account_number" name="account_number" value="{{ old('account_number') }}" 
                               class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="col-span-1">
                        <label for="account_holder_name" class="block text-sm font-medium text-gray-700">Nama Pemilik Akun</label>
                        <input type="text" id="account_holder_name" name="account_holder_name" value="{{ old('account_holder_name') }}" 
                               class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex items-center space-x-4 h-full col-span-1">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" checked 
                                   class="rounded text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600">Aktif</span>
                        </label>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150 ease-in-out">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tabel Daftar Metode Pembayaran (DETAIL LENGKAP) --}}
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama & Kode</th>
                                {{-- KOLOM DETAIL BARU --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Akun</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik Akun</th>
                                {{-- END KOLOM DETAIL BARU --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($paymentMethods as $method)
                            <tr>
                                {{-- Nama & Kode --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $method->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $method->code }}</div>
                                </td>
                                
                                {{-- Nomor Akun (Detail) --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $method->account_number ?? '-' }}
                                </td>
                                
                                {{-- Pemilik Akun (Detail) --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $method->account_holder_name ?? '-' }}
                                </td>
                                
                                {{-- Status --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full transition duration-150 ease-in-out 
                                        {{ $method->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $method->is_active ? 'Aktif' : 'Non-aktif' }}
                                    </span>
                                </td>
                                
                                {{-- Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-2">
                                    <a href="{{ route('admin.config.editPaymentMethod', $method->id) }}" class="text-indigo-600 hover:text-indigo-900 transition duration-150">Edit</a>
                                    
                                    <form action="{{ route('admin.config.destroyPaymentMethod', $method->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus metode pembayaran {{ $method->name }}?')" class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition duration-150">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500 bg-gray-50">Belum ada Metode Pembayaran yang dikonfigurasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ################################################## --}}
        {{-- TAB: JASA KIRIM (TIDAK BERUBAH) --}}
        {{-- ################################################## --}}
        <div x-show="activeTab === 'shipping'" class="space-y-8">

            {{-- Formulir Tambah Jasa Kirim --}}
            <div class="bg-white shadow-lg rounded-xl p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">Tambah Jasa Kirim Baru</h2>
                <form action="{{ route('admin.config.storeShippingService') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    @csrf
                    <div class="col-span-2">
                        <label for="name_shipping" class="block text-sm font-medium text-gray-700">Nama Jasa Kirim</label>
                        <input type="text" id="name_shipping" name="name" value="{{ old('name') }}" required 
                               class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="code_shipping" class="block text-sm font-medium text-gray-700">Kode (Contoh: JNE)</label>
                        <input type="text" id="code_shipping" name="code" value="{{ old('code') }}" required 
                               class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 uppercase">
                    </div>
                    <div>
                        <label for="estimation_shipping" class="block text-sm font-medium text-gray-700">Estimasi (Contoh: 2-3 Hari)</label>
                        <input type="text" id="estimation_shipping" name="estimation" value="{{ old('estimation') }}" 
                               class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex items-center space-x-4 h-full">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" checked 
                                   class="rounded text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600">Aktif</span>
                        </label>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150 ease-in-out">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tabel Daftar Jasa Kirim --}}
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- PENTING: Variabel $shippingServices harus tersedia dari Controller --}}
                            @forelse ($shippingServices as $service)
                            <tr>
                                {{-- Mode Tampil --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $service->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $service->code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $service->estimation }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full transition duration-150 ease-in-out 
                                        {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $service->is_active ? 'Aktif' : 'Non-aktif' }}
                                    </span>
                                </td>
                                
                                {{-- Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-2">
                                    {{-- Mengubah tombol Edit menjadi link/button yang akan mengarahkan ke halaman Edit terpisah --}}
                                    <a href="{{ route('admin.config.editShippingService', $service->id) }}" class="text-indigo-600 hover:text-indigo-900 transition duration-150">Edit</a>
                                    
                                    <form action="{{ route('admin.config.destroyShippingService', $service->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jasa kirim {{ $service->name }}?')" class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition duration-150">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500 bg-gray-50">Belum ada Jasa Kirim yang dikonfigurasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>

{{-- Memperbaiki tautan Alpine.js yang rusak --}}
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>

@endsection
