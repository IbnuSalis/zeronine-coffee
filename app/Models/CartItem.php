<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'menu_id', 'quantity', 'notes', 'customizations'];

    protected $casts = [
        'quantity' => 'integer',
        'customizations' => 'array',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->menu->price * $this->quantity;
    }
}
