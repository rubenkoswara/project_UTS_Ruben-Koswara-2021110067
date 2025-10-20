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
        // Pastikan kolom-kolom ditambahkan ke tabel 'users'
        Schema::table('users', function (Blueprint $table) {
            // phone_number: nullable, string, max:15
            $table->string('phone_number', 15)->nullable()->after('email');
            
            // date_of_birth: nullable, date
            $table->date('date_of_birth')->nullable()->after('phone_number');

            // address: nullable, string, max:500
            $table->string('address', 500)->nullable()->after('date_of_birth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Logika untuk membatalkan (rollback) migrasi
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'date_of_birth', 'address']);
        });
    }
};
