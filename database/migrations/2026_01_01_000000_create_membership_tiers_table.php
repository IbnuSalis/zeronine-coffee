<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Bronze, Silver, Gold, Platinum
            $table->string('slug')->unique();
            $table->unsignedInteger('min_points')->default(0);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('cashback_percent', 5, 2)->default(0);
            $table->string('badge_color')->default('#CD7F32'); // Bronze default
            $table->string('badge_icon')->nullable();
            $table->text('benefits')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_tiers');
    }
};
