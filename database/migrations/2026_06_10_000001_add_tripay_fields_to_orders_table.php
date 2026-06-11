<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom Tripay ke tabel orders:
     * - payment_url  : URL halaman pembayaran Tripay (redirect customer)
     * - tripay_reference : kode referensi transaksi dari Tripay (misal: DEV-T00001)
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // URL checkout page Tripay, digunakan untuk redirect customer ke halaman bayar
            $table->string('payment_url')->nullable()->after('payment_token');

            // Reference code dari Tripay (berbeda dengan payment_token Midtrans)
            $table->string('tripay_reference')->nullable()->after('payment_url');

            // Waktu kadaluarsa transaksi Tripay
            $table->timestamp('payment_expired_at')->nullable()->after('tripay_reference');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_url', 'tripay_reference', 'payment_expired_at']);
        });
    }
};
