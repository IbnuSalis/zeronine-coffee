<?php

/**
 * CATATAN: Migration ini sengaja dikosongkan (no-op).
 *
 * Kolom `payment_method` sudah tersedia di migration awal
 * (2026_01_01_000006_create_orders_table.php) sebagai `string nullable`.
 *
 * Mengubahnya menjadi ENUM terbatas tidak kompatibel dengan
 * nilai-nilai metode Tripay (QRIS, GOPAY, OVO, DANA, BCAVA, dll).
 *
 * Kolom dibiarkan sebagai string flexible sesuai kebutuhan multi-gateway.
 */

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // No-op: payment_method column already exists as nullable string
        // in 2026_01_01_000006_create_orders_table.php
    }

    public function down(): void
    {
        // No-op
    }
};