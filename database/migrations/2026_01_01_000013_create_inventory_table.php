<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('sku')->unique()->nullable();
            $table->string('category')->nullable(); // Coffee Beans, Dairy, Syrups, Cups, etc.
            $table->decimal('stock', 10, 2)->default(0);
            $table->string('unit', 20); // kg, liter, pcs, pack
            $table->decimal('min_stock', 10, 2)->default(0); // alert threshold
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->string('supplier')->nullable();
            $table->date('expiry_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['stock', 'min_stock']); // for low stock queries
        });

        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventory')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['in', 'out', 'adjustment', 'loss']);
            $table->decimal('quantity', 10, 2);
            $table->decimal('stock_before', 10, 2);
            $table->decimal('stock_after', 10, 2);
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->string('reference')->nullable(); // order number, supplier invoice, etc.
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
        Schema::dropIfExists('inventory');
    }
};
