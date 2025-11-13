<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('total_amount')->comment('Total harga semua produk (tidak termasuk ongkir)');
            $table->unsignedBigInteger('shipping_cost')->default(0)->comment('Biaya ongkos kirim');
            $table->unsignedBigInteger('grand_total')->comment('Total akhir (total produk + ongkir)');
            $table->string('status')->default('Pending')->comment('Status: Pending, Processing, Shipped, Completed, Cancelled');
            $table->text('shipping_address');           
            $table->string('payment_method')->comment('Metode pembayaran yang dipilih (misal: Transfer Bank BCA, Gopay)');
            $table->string('shipping_service')->comment('Jasa pengiriman yang dipilih (misal: JNE Reguler, GoSend)');
            $table->string('payment_proof_url')->nullable();         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
