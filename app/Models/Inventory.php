<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'item_name',
        'sku',
        'category',
        'stock',
        'unit',
        'min_stock',
        'purchase_price',
        'supplier',
        'expiry_date',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'stock' => 'decimal:2',
        'min_stock' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(InventoryLog::class);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'min_stock')->where('is_active', true);
    }

    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock;
    }
}
