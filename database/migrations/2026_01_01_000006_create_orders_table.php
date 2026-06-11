<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // ZN-2026-0001
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('table_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('promo_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('order_type', ['dine_in', 'takeaway', 'delivery'])->default('dine_in');
            $table->enum('status', [
                'pending',
                'confirmed',
                'processing',
                'ready',
                'completed',
                'cancelled',
            ])->default('pending');
            $table->enum('payment_status', [
                'unpaid',
                'paid',
                'expired',
                'failed',
                'refunded',
            ])->default('unpaid');
            $table->string('payment_method')->nullable(); // gopay, bank_transfer, credit_card, etc.
            $table->string('snap_token')->nullable();
            $table->string('payment_token')->nullable(); // midtrans transaction id
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('service_charge', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->unsignedInteger('loyalty_points_earned')->default(0);
            $table->unsignedInteger('loyalty_points_used')->default(0);
            $table->text('special_notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'payment_status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
