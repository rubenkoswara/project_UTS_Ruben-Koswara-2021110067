@extends('layouts.app') 

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Detail Pesanan Renesca Aquatic') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
                <p class="font-bold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
                <p class="font-bold">Gagal Update Status</p>
                <ul class="list-disc list-inside mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-2xl rounded-xl p-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b border-gray-200 pb-4">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2 sm:mb-0">Pesanan #{{ $order->id }}</h1>
                <a href="{{ route('admin.orders.index') }}" class="text-base font-medium text-indigo-600 hover:text-indigo-800 transition duration-150 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H14a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10 p-4 rounded-lg bg-gray-50 border border-gray-200">
                <div class="col-span-2 md:col-span-1">
                    <h3 class="text-sm font-medium text-gray-500 uppercase mb-1">Customer</h3>
                    <p class="text-gray-900 font-semibold">{{ $order->user->name ?? 'Pengguna Tamu' }}</p>
                    <p class="text-xs text-gray-600 truncate">{{ $order->user->email ?? 'Tidak Ada Email' }}</p>
                </div>
                <div> 
                    <h3 class="text-sm font-medium text-gray-500 uppercase mb-1">Nomor Kontak</h3>
                    @php
                        $phone = $order->user->phone_number ?? '-';
                        $cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
                    @endphp
                    @if ($phone !== '-')
                        <a href="tel:{{ $cleanPhone }}" class="text-indigo-600 font-semibold text-sm hover:underline flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 3.318a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l3.318.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-7A9 9 0 013 9V3z" />
                            </svg>
                            {{ $phone }}
                        </a>
                    @else
                        <p class="text-gray-900 font-semibold text-sm">{{ $phone }}</p>
                    @endif
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase mb-1">Dipesan Pada</h3>
                    <p class="text-gray-900 text-sm">{{ $order->created_at->format('d M Y') }}</p>
                    <p class="text-gray-600 text-xs">{{ $order->created_at->format('H:i') }} WIB</p>
                </div>
                <div class="text-right">
                    <h3 class="text-sm font-medium text-gray-500 uppercase mb-1">Total Biaya Pesanan</h3>
                    <p class="text-red-600 font-extrabold text-3xl">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b pb-2">Status & Pengiriman</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="md:col-span-2 bg-indigo-50 p-5 rounded-xl border border-indigo-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-indigo-800 mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 0L10 9.05l-4.95-4.95zM10 12a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        Alamat Pengiriman
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $order->shipping_address }}</p>
                </div>

                <div class="p-5 rounded-xl border border-gray-300 shadow-sm bg-white">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Status Pesanan</h3>
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 mb-1">Status Saat Ini:</p>
                        <span class="inline-block px-4 py-1.5 text-base font-extrabold rounded-full {{ $statuses[$order->status] ?? 'bg-gray-200 text-gray-700' }} shadow-md">
                            {{ $order->status }}
                        </span>
                    </div>

                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex flex-col gap-3">
                        @csrf
                        @method('PATCH')
                        
                        <label for="status" class="text-sm font-medium text-gray-700">Perbarui Status ke:</label>
                        <select name="status" id="status" 
                                class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            @foreach ($statuses as $statusKey => $statusClass)
                                <option value="{{ $statusKey }}" {{ $order->status === $statusKey ? 'selected' : '' }}>
                                    {{ $statusKey }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full mt-2 px-4 py-2 text-base font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition duration-200 shadow-lg transform hover:scale-[1.01]">
                            Perbarui Status
                        </button>
                    </form>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b pb-2">Item Pesanan</h2>
            <div class="overflow-x-auto mb-10 border border-gray-200 rounded-xl shadow-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Harga Satuan</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-indigo-700 uppercase tracking-wider">Kuantitas</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-indigo-700 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($order->items as $item)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->product_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-right text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-indigo-100">
                            <td colspan="3" class="px-6 py-4 text-right text-lg font-bold text-indigo-800 border-t border-gray-300">Total Keseluruhan:</td>
                            <td class="px-6 py-4 text-right text-2xl font-extrabold text-red-600 border-t border-gray-300">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if(isset($order->payment_proof_url) && $order->payment_proof_url)
            <div class="mt-10 pt-6 border-t border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Bukti Transfer</h2>
                
                <div class="border border-indigo-400 rounded-xl p-8 bg-indigo-50 text-center shadow-lg">
                    
                    <p class="text-sm text-indigo-700 mb-6 font-medium">Harap **verifikasi** bukti pembayaran berikut sebelum mengubah status pesanan menjadi **Processed**.</p>

                    <a href="{{ $order->payment_proof_url }}" target="_blank" title="Klik untuk melihat gambar penuh" class="inline-block transition duration-300 ease-in-out transform hover:scale-[1.02] hover:shadow-2xl">
                        <img 
                            src="{{ $order->payment_proof_url }}" 
                            alt="Bukti Transfer Pesanan #{{ $order->id }}" 
                            onerror="this.onerror=null; this.src='https://placehold.co/400x450/374151/D1D5DB?text=BUKTI+TIDAK+TERSEDIA';"
                            class="block max-w-full h-auto mx-auto rounded-lg shadow-xl border-4 border-white ring-4 ring-indigo-500/50"
                            style="max-width: 400px; max-height: 450px; object-fit: cover;"
                        />
                    </a>

                    <div class="mt-8">
                        <a href="{{ $order->payment_proof_url }}" target="_blank" class="inline-flex items-center px-8 py-3 text-base font-semibold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 shadow-xl transition duration-150 transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                            Lihat Gambar Penuh
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="mt-10 pt-6 border-t border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Bukti Transfer</h2>
                <div class="border border-gray-300 rounded-xl p-6 bg-gray-100 text-center shadow-md">
                    <p class="text-gray-600 italic font-medium">Customer belum mengunggah bukti pembayaran untuk pesanan ini.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
