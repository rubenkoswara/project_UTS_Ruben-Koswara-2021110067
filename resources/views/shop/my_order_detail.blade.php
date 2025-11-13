@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="container py-5">

    {{-- Tombol Kembali --}}
    <a href="{{ route('shop.myOrders') }}" class="btn btn-outline-primary rounded-pill mb-4 shadow-sm">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
    </a>

    {{-- Kartu Utama --}}
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

        {{-- Header --}}
        <div class="card-header bg-gradient bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-receipt-cutoff me-2"></i> Pesanan #{{ $order->id }}
            </h5>

            @php
                $statusColors = [
                    'pending_payment' => 'warning',
                    'processing' => 'info',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                ];
            @endphp

            <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }} text-capitalize fs-6 px-3 py-2 shadow-sm">
                {{ str_replace('_', ' ', $order->status) }}
            </span>
        </div>

        {{-- Body --}}
        <div class="card-body p-4">
            <div class="row gy-4">

                {{-- Kolom kiri: informasi pengiriman --}}
                <div class="col-md-6">
                    <h6 class="fw-bold text-primary mb-3">
                        <i class="bi bi-truck me-2"></i>Informasi Pengiriman
                    </h6>
                    <div class="bg-light p-3 rounded-3 border">
                        <p class="mb-2"><strong>Layanan:</strong> {{ $order->shipping_service }}</p>
                        <p class="mb-2"><strong>Alamat:</strong><br> {{ $order->shipping_address }}</p>
                        <p class="mb-0"><strong>Ongkos Kirim:</strong> Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                    </div>
                </div>

                {{-- Kolom kanan: informasi pembayaran --}}
                <div class="col-md-6">
                    <h6 class="fw-bold text-primary mb-3">
                        <i class="bi bi-credit-card me-2"></i>Informasi Pembayaran
                    </h6>
                    <div class="bg-light p-3 rounded-3 border">
                        <p class="mb-2"><strong>Metode:</strong> {{ $order->payment_method }}</p>
                        <p class="mb-2"><strong>Total Produk:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <p class="fw-bold fs-5 text-primary mb-0">
                            Total Bayar: Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            {{-- Item Pesanan --}}
            <h6 class="fw-bold text-primary mb-3">
                <i class="bi bi-box-seam me-2"></i>Item Pesanan
            </h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle border">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>Produk</th>
                            <th>Harga Satuan</th>
                            <th>Kuantitas</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="text-start fw-semibold">{{ $item->product_name }}</td>
                                <td class="text-center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-center fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total Produk:</td>
                            <td class="fw-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Ongkos Kirim:</td>
                            <td class="fw-bold text-primary">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end fw-bold fs-5">Total Bayar:</td>
                            <td class="fw-bold fs-5 text-success">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Tombol Batalkan Pesanan --}}
            @if(in_array($order->status, ['pending_payment', 'processing']))
                <div class="text-center mt-4">
                    <form action="{{ route('shop.cancelMyOrder', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                        @csrf
                        <button type="submit" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-x-circle me-2"></i>Batalkan Pesanan
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
