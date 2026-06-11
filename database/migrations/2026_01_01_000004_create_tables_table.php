<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('number', 10)->unique(); // e.g. A1, B2
            $table->string('name')->nullable(); // e.g. "Window Table"
            $table->unsignedTinyInteger('capacity')->default(2);
            $table->enum('status', ['available', 'reserved', 'occupied'])->default('available');
            $table->string('location')->nullable(); // Indoor, Outdoor, VIP Room
            $table->string('qr_code')->nullable()->unique();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
