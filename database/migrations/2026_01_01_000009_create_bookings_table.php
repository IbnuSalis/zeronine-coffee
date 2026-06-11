<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique(); // BK-2026-0001
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('table_id')->constrained()->restrictOnDelete();
            $table->dateTime('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedTinyInteger('guest_count')->default(2);
            $table->enum('status', [
                'pending',
                'confirmed',
                'checked_in',
                'completed',
                'cancelled',
                'no_show',
            ])->default('pending');
            $table->string('occasion')->nullable(); // Birthday, Anniversary, Business Meeting
            $table->text('special_requests')->nullable();
            $table->string('contact_name');
            $table->string('contact_phone', 20);
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->index(['table_id', 'booking_date']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
