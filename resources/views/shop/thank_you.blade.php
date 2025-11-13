@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto bg-white border rounded-3xl p-10 shadow-3xl">
        
        <div class="text-center mb-8">
            <svg class="w-24 h-24 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h1 class="text-4xl font-extrabold text-gray-800">Order Berhasil Dibuat!</h1>
            <p class="text-lg text-gray-600 mt-3">Order Anda dengan nomor **#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}** telah kami terima dan menunggu pembayaran.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mb-10">
            {{-- RINGKASAN BIAYA --}}
            <div class="p-6 bg-gray-50 rounded-xl border">
                <h2 class="text-2xl font-bold mb-4 text-teal-700 border-b pb-2">Ringkasan Biaya</h2>
                <div class="space-y-3">
                    <div class="flex justify-between text-lg text-gray-700">
                        <span>Total Produk</span>
                        <span class="font-semibold">{{ $order->formatted_total_amount }}</span>
                    </div>
                    <div class="flex justify-between text-lg text-gray-700">
                        <span>Biaya Kirim</span>
                        <span class="font-semibold">{{ $order->formatted_shipping_cost }}</span>
                    </div>
                    <div class="border-t pt-4 flex justify-between text-3xl font-extrabold text-red-600">
                        <span>TOTAL AKHIR</span>
                        <span>{{ $order->formatted_grand_total }}</span>
                    </div>
                </div>
            </div>

            {{-- DETAIL PENGIRIMAN & PEMBAYARAN --}}
            <div class="p-6 bg-gray-50 rounded-xl border">
                <h2 class="text-2xl font-bold mb-4 text-teal-700 border-b pb-2">Info Pengiriman</h2>
                <div class="space-y-3">
                    <p class="font-semibold text-gray-800">Status: <span class="text-orange-500">{{ ucwords(str_replace('_', ' ', $order->status)) }}</span></p>
                    <p>Layanan: <strong class="text-gray-700">{{ $order->shipping_service }}</strong></p>
                    <p>Alamat: <span class="italic text-sm block mt-1 p-2 bg-white rounded border">{{ $order->shipping_address }}</span></p>
                    <p>Pembayaran: <strong class="text-gray-700">{{ $order->payment_method == 'transfer_bank' ? 'Transfer Bank' : 'Bayar di Tempat (COD)' }}</strong></p>
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-4 text-gray-800 border-b pb-2">Item Pesanan ({{ $order->items->count() }} Produk)</h2>
        <div class="space-y-3">
            @foreach ($order->items as $item)
            <div class="flex justify-between items-center border p-4 rounded-xl bg-gray-100 shadow-sm">
                <span class="font-medium text-lg text-gray-800">{{ $item->product_name }}</span>
                <span class="text-sm text-gray-600">
                    <span class="text-base font-semibold">{{ $item->quantity }}</span> x {{ $item->formatted_price }} = <strong class="text-teal-600">{{ $item->formatted_subtotal }}</strong>
                </span>
            </div>
            @endforeach
        </div>

        <div class="mt-10 pt-6 border-t border-dashed text-center">
            @if ($order->payment_method == 'transfer_bank')
                <p class="text-xl font-extrabold text-red-500 mb-4">Langkah Selanjutnya: Lakukan Pembayaran!</p>
                <p class="text-gray-700 text-lg">Transfer tepat **{{ $order->formatted_grand_total }}** ke:</p>
                <div class="inline-block bg-teal-100 p-4 rounded-lg mt-3">
                    <p class="font-mono text-2xl font-bold text-teal-800">BCA: 1234567890</p>
                    <p class="text-base text-gray-600">A/N Renesca Aquatic Official</p>
                </div>
                <p class="text-sm text-gray-500 mt-3">Segera konfirmasi pembayaran Anda agar pesanan diproses.</p>
            @endif
            <a href="{{ route('shop.index') }}" class="mt-8 inline-block bg-blue-600 text-white py-3 px-8 rounded-xl text-lg font-bold hover:bg-blue-700 transition transform hover:scale-[1.05] shadow-lg">
                Kembali ke Katalog
            </a>
        </div>
    </div>
</div>
@endsection
