@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 pb-3 border-b border-gray-200 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3 text-indigo-600" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="m7.5 19.73 9-5.15"/><path d="M3.3 14.53V9.47L12 4.4l8.7 5.07v5.06L12 19.6l-8.7-5.07Z"/><path d="m12 19.6 4.5-2.6"/><path d="m12 4.4-4.5 2.6"/><path d="m5.2 12 6.8 4 6.8-4"/></svg>
            Riwayat Pesanan
        </h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4 shadow-sm" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline ml-2">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4 shadow-sm" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline ml-2">{{ session('error') }}</span>
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10 text-center border-2 border-dashed border-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-400 mx-auto mb-4" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="m7.5 19.73 9-5.15"/><path d="M3.3 14.53V9.47L12 4.4l8.7 5.07v5.06L12 19.6l-8.7-5.07Z"/><path d="m12 19.6 4.5-2.6"/><path d="m12 4.4-4.5 2.6"/><path d="m5.2 12 6.8 4 6.8-4"/></svg>
                <h3 class="text-xl font-light text-gray-600 mb-3">Riwayat Pesanan Kosong</h3>
                <p class="text-gray-500 mb-6">Tidak ada transaksi yang tercatat. Mari mulai belanja!</p>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 12.59a2 2 0 0 0 2 1.41h9.72a2 2 0 0 0 2-1.41L23 6H6"></path>
                        <path d="M9 13a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H9"></path>
                    </svg>
                    Jelajahi Produk
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    @php
                        $statusColors = [
                            'completed' => ['bg' => 'green', 'text' => 'Selesai', 'icon_path' => 'M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z M8 12L11 15L16 9'], 
                            'cancelled' => ['bg' => 'red', 'text' => 'Dibatalkan', 'icon_path' => 'M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z M15 9L9 15 M9 9L15 15'], 
                            'pending_payment' => ['bg' => 'yellow', 'text' => 'Menunggu Pembayaran', 'icon_path' => 'M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z M12 6V12L16 14'], 
                            'processed' => ['bg' => 'blue', 'text' => 'Diproses', 'icon_path' => 'M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12H20C20 7.58 16.42 4 12 4C7.58 4 4 7.58 4 12'], 
                            'shipped' => ['bg' => 'indigo', 'text' => 'Dikirim', 'icon_path' => 'M7.3 11.2a2.3 2.3 0 0 0 2.45 2.4l.65-.24a2 2 0 0 1 2.2-.3l4.6 2.3a2 2 0 0 0 2.2-.3l1.85-.92a2 2 0 0 0 0-3.64l-1.85-.92a2 2 0 0 0-2.2-.3l-4.6 2.3a2 2 0 0 1-2.2-.3l-.65-.24a2.3 2.3 0 0 0-2.45 2.4V2H17v2H7v11.5z M1 20h22M7 20v2M17 20v2'], 
                        ];
                        $statusKey = strtolower($order->status);
                        $statusInfo = $statusColors[$statusKey] ?? ['bg' => 'gray', 'text' => 'Status Lain', 'icon_path' => 'M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z M12 16V12 M12 8H12.01'];
                        
                        $orderItems = $order->items ?? collect();
                        $firstItem = $orderItems->first();
                        $itemCount = $orderItems->count();
                    @endphp
                    
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 transition duration-300 hover:shadow-xl">
                        
                        <div class="px-6 py-3 bg-gray-50 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center">
                            <div class="flex items-center space-x-4 mb-2 md:mb-0">
                                <span class="text-lg font-bold text-gray-900">
                                    Pesanan #{{ $order->id }}
                                </span>
                                <span class="text-sm text-gray-500 hidden sm:inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-1 -mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    {{ $order->created_at->format('d M Y') }}
                                </span>
                            </div>
                            
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-{{ $statusInfo['bg'] }}-100 text-{{ $statusInfo['bg'] }}-800 uppercase tracking-wider shadow-inner">
                                <svg class="w-3 h-3 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    @if($statusKey === 'processing')
                                        <style>@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }</style>
                                        <path d="{{ $statusInfo['icon_path'] }}" style="transform-origin: center; animation: spin 1s linear infinite;"/>
                                    @else
                                        <path d="{{ $statusInfo['icon_path'] }}"/>
                                    @endif
                                </svg>
                                {{ $statusInfo['text'] }}
                            </span>
                        </div>

                        <div class="p-6">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                                
                                <div class="flex items-start mb-4 md:mb-0 w-full md:w-3/5">
                                    @if($firstItem && $firstItem->product)
                                        <div class="flex items-center space-x-4">
                                            
                                            {{-- START PERBAIKAN PATH GAMBAR --}}
                                            @php
                                                $imagePath = $firstItem->product->image;
                                                $basePath = 'storage/';
                                                $directory = 'products/';
                                                $fullAssetPath = null;

                                                if ($imagePath) {
                                                    // Cek apakah $imagePath sudah mengandung prefix folder `products/`
                                                    if (str_starts_with($imagePath, $directory)) {
                                                        // Jika sudah ada (misal: products/gambar.jpg), kita hanya perlu prefix `storage/`
                                                        $fullAssetPath = $basePath . $imagePath;
                                                    } else {
                                                        // Jika hanya nama file (misal: gambar.jpg), kita tambahkan `storage/products/`
                                                        $fullAssetPath = $basePath . $directory . $imagePath;
                                                    }
                                                }
                                                
                                                // Gunakan path yang sudah dikonstruksi atau placeholder
                                                $imageUrl = $fullAssetPath ? asset($fullAssetPath) : 'https://placehold.co/60x60/d1d5db/374151?text=No+Img';
                                            @endphp
                                            {{-- END PERBAIKAN PATH GAMBAR --}}
                                            
                                            <img src="{{ $imageUrl }}" 
                                                alt="{{ $firstItem->product->name }}" 
                                                onerror="this.onerror=null; this.src='https://placehold.co/60x60/d1d5db/374151?text=No+Img';"
                                                class="w-16 h-16 rounded-lg object-cover border border-gray-200 shadow-sm">
                                            
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900 leading-tight line-clamp-1">{{ $firstItem->product->name }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5">{{ $firstItem->quantity }}x @ {{ $firstItem->product->formatted_price ?? 'Harga tidak tersedia' }}</p>
                                                
                                                @if($itemCount > 1)
                                                    <p class="text-xs text-indigo-600 font-medium mt-1">
                                                        + {{ $itemCount - 1 }} item lainnya
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 italic">Detail produk tidak tersedia.</p>
                                    @endif
                                </div>

                                <div class="w-full md:w-2/5 flex flex-col sm:flex-row justify-between items-start sm:items-center border-t md:border-t-0 pt-4 md:pt-0 border-gray-100">
                                    
                                    <div class="mb-3 sm:mb-0">
                                        <span class="text-sm text-gray-500 block">Total Tagihan:</span>
                                        <p class="text-xl font-extrabold text-red-600">{{ $order->formatted_total_amount }}</p>
                                    </div>

                                    <div class="flex space-x-2">
                                        <a href="{{ route('shop.myOrderDetail', $order->id) }}" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out shadow-md">
                                            Detail
                                        </a>
                                        
                                        @if(in_array($order->status, ['pending_payment', 'processing']))
                                            <form action="{{ route('shop.cancelMyOrder', $order->id) }}" method="POST" class="inline-block" onsubmit="return false;">
                                                @csrf
                                                @method('DELETE') 
                                                <button type="button" 
                                                    class="cancel-button inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-red-600 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out shadow-sm"
                                                    data-order-id="{{ $order->id }}">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div id="cancelConfirmModalOverlay" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-300 bg-gray-900 bg-opacity-75" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">

        <div id="cancelConfirmModal" class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 duration-300">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Konfirmasi Pembatalan Pesanan
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Anda yakin ingin membatalkan pesanan <strong class="font-semibold text-gray-800" id="orderIdText">#00000</strong>? Tindakan ini tidak dapat diurungkan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirmCancelButton" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition ease-in-out duration-150">
                    Ya, Batalkan
                </button>
                <button type="button" class="modal-close mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition ease-in-out duration-150">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let formToSubmit = null;

    document.addEventListener('DOMContentLoaded', function () {
        const modalOverlay = document.getElementById('cancelConfirmModalOverlay');
        const modalContainer = document.getElementById('cancelConfirmModal');
        const confirmCancelButton = document.getElementById('confirmCancelButton');
        const closeButtons = document.querySelectorAll('.modal-close'); 
        
        const showModal = (orderId) => {
            document.getElementById('orderIdText').textContent = `#${orderId}`;
            modalOverlay.classList.remove('hidden');
            setTimeout(() => {
                modalOverlay.classList.remove('opacity-0');
                modalContainer.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
                modalContainer.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            }, 10);
        };

        const hideModal = () => {
            modalContainer.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            modalContainer.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
            setTimeout(() => {
                modalOverlay.classList.add('hidden');
                modalOverlay.classList.add('opacity-0');
            }, 300);
            formToSubmit = null;
        };
        
        document.querySelectorAll('.cancel-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                formToSubmit = this.closest('form'); 
                const orderId = this.getAttribute('data-order-id');
                showModal(orderId);
            });
        });

        confirmCancelButton.addEventListener('click', function() {
            if (formToSubmit) {
                // Periksa apakah formToSubmit masih valid sebelum submit
                if (formToSubmit.tagName === 'FORM') {
                    formToSubmit.submit();
                } else {
                    console.error("Form pembatalan tidak valid.");
                }
                hideModal();
            } else {
                console.error("Form pembatalan tidak ditemukan.");
                hideModal();
            }
        });

        // Event listener untuk tombol 'Batal' dan klik di luar modal
        [...closeButtons, modalOverlay].forEach(el => {
            if (el.id === 'cancelConfirmModalOverlay') {
                el.addEventListener('click', function(e) {
                    if (e.target.id === 'cancelConfirmModalOverlay') {
                        hideModal();
                    }
                });
            } else {
                el.addEventListener('click', hideModal);
            }
        });
        
        // Menutup modal dengan tombol ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modalOverlay.classList.contains('hidden')) {
                hideModal();
            }
        });
    });
</script>
@endsection