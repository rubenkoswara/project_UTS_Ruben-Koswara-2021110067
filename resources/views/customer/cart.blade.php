@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6">Keranjang Belanja Anda</h2>
    
    @foreach ($cart_items as $item)
    <div class="flex justify-between items-center border-b py-4">
        <div class="flex-1">
            <h3 class="font-semibold text-lg">{{ $item['name'] }}</h3>
            <p class="text-gray-600">{{ $item['price'] }} x {{ $item['qty'] }}</p>
        </div>
        <p class="font-bold text-lg text-red-600">{{ $item['subtotal'] }}</p>
        <button class="ml-6 text-red-500">Hapus</button>
    </div>
    @endforeach

    <div class="text-right mt-6">
        <span class="text-2xl font-bold">Total:</span>
        <span class="text-2xl font-bold text-red-600">{{ $total }}</span>
    </div>
    
    {{-- LINK BERJALAN: ke Checkout --}}
    <a href="{{ route('customer.checkout') }}" class="float-right mt-4 block text-center bg-green-600 text-white font-bold py-3 px-8 rounded-lg">
        Lanjut ke Checkout
    </a>
</div>
@endsection