@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Hapus dark:bg-gray-800 dari card utama --}}
    <div class="max-w-3xl mx-auto bg-white p-8 shadow-xl rounded-lg">
        
        <h2 class="text-3xl font-extrabold text-red-600 mb-6 border-b pb-4">Instruksi Pembayaran</h2>
        
        {{-- Pesan Peringatan (Diperjelas untuk Light Mode) --}}
        {{-- Hapus dark:bg-yellow-900, dark:text-yellow-200 --}}
        <div class="mb-8 p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded text-yellow-800">
            <p class="font-bold">Pesanan Anda ({{ $order_data['id'] }}) telah berhasil dibuat.</p>
            <p class="mt-1">Mohon segera lakukan pembayaran sebesar: <span class="text-2xl font-black">{{ $order_data['total'] }}</span> sebelum **{{ $order_data['due_date'] }}**.</p>
        </div>

        {{-- DETAIL TRANSFER BANK & E-WALLET --}}
        <h3 class="text-xl font-bold mb-4 text-gray-800">1. Lakukan Transfer ke Salah Satu Akun Berikut:</h3>
        
        @foreach ($order_data['payment_methods'] as $key => $method)
        {{-- Hapus dark:bg-gray-700 --}}
        <div class="p-4 border rounded-lg bg-gray-50 space-y-2 mb-6">
            <p class="text-lg font-extrabold text-teal-600">{{ $key }} ({{ $method['name'] }})</p>
            
            {{-- Hapus dark:text-red-400 --}}
            <p><strong>Nomor Akun:</strong> <span class="text-xl font-bold text-red-700">{{ $method['account_number'] }}</span></p>
            <p><strong>Atas Nama:</strong> {{ $method['account_name'] }}</p>
            {{-- Hapus dark:text-gray-400 --}}
            <p class="text-sm text-gray-500 mt-2 italic">Catatan: {{ $method['notes'] }}</p>
        </div>
        @endforeach

        {{-- FORM UPLOAD BUKTI PEMBAYARAN --}}
        <h3 class="text-xl font-bold mb-4 border-t pt-4 mt-8 text-gray-800">2. Konfirmasi & Bukti Pembayaran</h3>
        <form action="{{ route('customer.orders') }}" method="GET" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                {{-- Hapus dark:text-gray-300 --}}
                <label for="proof" class="block text-sm font-medium text-gray-700">
                    Upload Bukti Transfer (JPG/PNG)
                </label>
                {{-- Input file tidak perlu diubah, karena warna dark mode tidak memengaruhi di sini, tapi pastikan tidak ada class gelap tambahan --}}
                <input type="file" id="proof" name="proof" required class="mt-1 block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700
                    hover:file:bg-indigo-100"
                >
            </div>
            
            <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition duration-300">
                Kirim Bukti & Selesaikan Pembayaran
            </button>
        </form>
    </div>
</div>
@endsection