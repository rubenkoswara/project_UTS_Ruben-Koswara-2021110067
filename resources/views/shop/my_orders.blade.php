@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h2 class="fw-bold mb-4 text-center text-primary">
        <i class="bi bi-bag-check-fill me-2"></i>Riwayat Pesanan Saya
    </h2>

    @if($orders->isEmpty())
        <div class="alert alert-info text-center shadow-sm py-4 rounded-3">
            <i class="bi bi-info-circle-fill me-2"></i>
            Anda belum memiliki pesanan.
        </div>
    @else
        <div class="row g-4">
            @foreach($orders as $order)
                <div class="col-lg-6 col-md-12">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0 text-dark">#{{ $order->id }}</h5>
                                @php
                                    $statusColors = [
                                        'pending_payment' => 'warning',
                                        'processing' => 'info',
                                        'completed' => 'success',
                                        'cancelled' => 'danger',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }} px-3 py-2">
                                    {{ str_replace('_', ' ', ucfirst($order->status)) }}
                                </span>
                            </div>

                            <p class="text-muted mb-1"><i class="bi bi-calendar3 me-1"></i> 
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                            <p class="text-muted mb-2"><i class="bi bi-credit-card me-1"></i> 
                                {{ $order->payment_method }}
                            </p>

                            <div class="border-top pt-3">
                                <h6 class="fw-semibold mb-2">Total Pembayaran:</h6>
                                <h4 class="text-primary fw-bold">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</h4>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('shop.myOrderDetail', $order->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>

                                @if(in_array($order->status, ['pending_payment', 'processing']))
                                    <form action="{{ route('shop.cancelOrder', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm rounded-pill px-4">
                                            <i class="bi bi-x-circle me-1"></i> Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
