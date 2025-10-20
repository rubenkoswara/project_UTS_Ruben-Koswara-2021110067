<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController; 

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController; 
use App\Http\Controllers\Admin\SalesReportController;

// ===================================
// === ROUTE SISI CUSTOMER (PUBLIK) ===
// ===================================

// Home/Katalog & Filter Kategori (Link utama)
Route::get('/', [CustomerController::class, 'index'])->name('customer.home');

// Detail Produk
Route::get('/product/{id}', [CustomerController::class, 'productDetail'])->name('customer.product_detail');

// Keranjang Belanja
Route::get('/cart', [CustomerController::class, 'cart'])->name('customer.cart');

// Checkout (Proses utama, umumnya diakses oleh tamu atau user yang login)
Route::get('/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout');


// ==============================================
// === ROUTE SISI CUSTOMER (MEMBUTUHKAN LOGIN) ===
// ==============================================

// Route yang dilindungi oleh middleware 'auth'
Route::middleware('auth')->group(function () {
    
    // Profil Pengguna (Dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); 
    
    // Daftar Pesanan Customer
    Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');
    
    // Detail Pesanan Customer
    // Menggunakan ID Pesanan (contoh: /orders/CRD-001)
    Route::get('/orders/{id}', [CustomerController::class, 'orderDetail'])->name('customer.order_detail');
    
    // Instruksi Pembayaran (Lanjutan dari Checkout - DIPINDAH AGAR MEMERLUKAN LOGIN)
    Route::get('/payment-instruction', [CustomerController::class, 'paymentInstruction'])->name('customer.payment_instruction');

});

// ========================================
// === ROUTE SISI ADMIN (MEMBUTUHKAN LOGIN & ROLE ADMIN) ===
// ========================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Produk
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    
    // Manajemen Pesanan
    Route::resource('orders', OrderController::class)->only(['index', 'show']);
    
    // Manajemen User (Resource)
    Route::resource('users', UserController::class)->except(['show']);

    // LAPORAN PENJUALAN (ROUTE YANG SUDAH DIPERBAIKI)
    Route::get('/sales-report', [SalesReportController::class, 'index'])->name('sales.report');
    
    // Export PDF
    Route::get('/sales-report/export/pdf', [SalesReportController::class, 'exportPdf'])->name('sales.export.pdf');
    
    // Export Excel
    Route::get('/sales-report/export/excel', [SalesReportController::class, 'exportExcel'])->name('sales.export.excel');
    
});


require __DIR__.'/auth.php'; // Route default Breeze untuk Login/Register
