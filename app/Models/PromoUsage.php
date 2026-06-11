<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromoUsage extends Model
{
    protected $fillable = ['promo_id', 'user_id', 'order_id', 'discount_amount'];

    protected $casts = [
        'discount_amount' => 'decimal:2',
    ];

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
