<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'menu_id',
        'menu_name',
        'menu_price',
        'quantity',
        'subtotal',
        'notes',
        'customizations',
    ];

    protected $casts = [
        'menu_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'quantity' => 'integer',
        'customizations' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
