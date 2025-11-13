<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UniversalTrashController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MethodConfigurationController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SalesReportController;


Route::get('/', [ShopController::class, 'index'])->name('shop.home');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // GROUP SHOP: Rute yang terkait dengan frontend shop
    Route::group(['prefix' => 'shop'], function () {
        Route::get('/', [ShopController::class, 'index'])->name('shop.index');
        Route::get('/cart', [ShopController::class, 'viewCart'])->name('shop.viewCart');
        Route::post('/cart/add', [ShopController::class, 'addToCart'])->name('shop.addToCart');
        Route::post('/cart/update', [ShopController::class, 'updateCart'])->name('shop.updateCart');
        Route::post('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout'); 
        Route::get('/order/{order}/thank-you', [ShopController::class, 'thankYou'])->name('shop.thankYou');
        
        // Rute Order untuk pengguna (mungkin menggunakan OrderController)
        Route::get('/orders', [OrderController::class, 'index'])->name('shop.orders');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('shop.orderDetail');


        Route::get('/my-orders', [ShopController::class, 'myOrders'])->name('shop.myOrders');
        Route::get('/my-orders/{id}', [ShopController::class, 'myOrderDetail'])->name('shop.myOrderDetail');
        Route::delete('/my-orders/{id}/cancel', [ShopController::class, 'cancelMyOrder'])->name('shop.cancelMyOrder');

    });

    // ROUTE KONFIRMASI PEMBAYARAN DIPINDAHKAN DI SINI, TEPAT DI DALAM MIDDLEWARE 'auth'
    Route::post('/order/confirm-payment', [ShopController::class, 'confirmPayment'])
        ->name('order.confirm_payment');

});

// RUTE ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
    Route::resource('orders', OrderController::class)->only(['index', 'show']);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');
    Route::resource('users', UserController::class)->except(['show']);


    Route::get('/sales-report', [SalesReportController::class, 'index'])->name('sales.report');
    Route::get('/sales-report/export/pdf', [SalesReportController::class, 'exportPdf'])->name('sales.export.pdf');
    Route::get('/sales-report/export/excel', [SalesReportController::class, 'exportExcel'])->name('sales.export.excel');

    // BLOK KONFIGURASI
    Route::prefix('configuration')->name('config.')->group(function () {
        Route::get('/', [MethodConfigurationController::class, 'index'])->name('index');

        Route::post('payment-methods', [MethodConfigurationController::class, 'storePaymentMethod'])->name('storePaymentMethod');
        Route::get('payment-methods/{paymentMethod}/edit', [MethodConfigurationController::class, 'editPaymentMethod'])->name('editPaymentMethod'); 
        Route::put('payment-methods/{paymentMethod}', [MethodConfigurationController::class, 'updatePaymentMethod'])->name('updatePaymentMethod');
        Route::delete('payment-methods/{paymentMethod}', [MethodConfigurationController::class, 'destroyPaymentMethod'])->name('destroyPaymentMethod');
        
        Route::post('shipping-services', [MethodConfigurationController::class, 'storeShippingService'])->name('storeShippingService');
        Route::get('shipping-services/{shippingService}/edit', [MethodConfigurationController::class, 'editShippingService'])->name('editShippingService'); 
        Route::put('shipping-services/{shippingService}', [MethodConfigurationController::class, 'updateShippingService'])->name('updateShippingService');
        Route::delete('shipping-services/{shippingService}', [MethodConfigurationController::class, 'destroyShippingService'])->name('destroyShippingService');
    });

    // BLOK TEMPAT SAMPAH
    Route::prefix('universal-trash')->name('universal-trash.')->group(function () {
        Route::get('/', [UniversalTrashController::class, 'index'])->name('index'); 
        Route::post('/{modelType}/{id}/restore', [UniversalTrashController::class, 'restore'])->name('restore'); 
        Route::delete('/{modelType}/{id}/force-delete', [UniversalTrashController::class, 'forceDelete'])->name('forceDelete'); 
    });

});

require __DIR__.'/auth.php';
