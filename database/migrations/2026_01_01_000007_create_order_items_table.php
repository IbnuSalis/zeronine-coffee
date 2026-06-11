<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('menu_id')->constrained()->restrictOnDelete();
            $table->string('menu_name'); // snapshot at time of order
            $table->decimal('menu_price', 10, 2); // snapshot at time of order
            $table->unsignedSmallInteger('quantity');
            $table->decimal('subtotal', 12, 2);
            $table->text('notes')->nullable(); // e.g. "less sugar, extra ice"
            $table->json('customizations')->nullable(); // size, temperature, sugar level
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
