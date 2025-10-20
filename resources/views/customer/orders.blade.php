@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6">Daftar Pesanan Saya</h2>
    
    @foreach ($orders as $order)
    <div class="p-4 border rounded-lg shadow-md mb-4 flex justify-between items-center">
        <div>
            <p class="font-semibold">Pesanan #{{ $order['id'] }}</p>
            <p class="text-sm text-gray-500">Tanggal: {{ $order['date'] }}</p>
            <p class="text-lg font-bold">{{ $order['total'] }}</p>
        </div>
        <div class="text-right">
            <span class="font-bold p-2 rounded-full text-green-700 bg-green-100">{{ $order['status'] }}</span>
            {{-- LINK BERJALAN: ke Detail Pesanan --}}
            <a href="{{ route('customer.order_detail', $order['id']) }}" class="block mt-2 text-blue-600 hover:text-blue-800">Lihat Detail</a>
        </div>
    </div>
    @endforeach
</div>
@endsection