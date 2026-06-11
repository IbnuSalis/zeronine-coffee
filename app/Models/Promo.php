<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_spend',
        'max_discount',
        'usage_limit',
        'used_count',
        'per_user_limit',
        'start_date',
        'end_date',
        'is_active',
        'image',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_spend' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'per_user_limit' => 'integer',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function usages(): HasMany
    {
        return $this->hasMany(PromoUsage::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')->orWhereColumn('used_count', '<', 'usage_limit');
            });
    }

    /**
     * Calculate discount amount for a given subtotal.
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal < $this->min_spend) {
            return 0;
        }

        $discount = $this->type === 'percentage'
            ? $subtotal * ($this->value / 100)
            : $this->value;

        if ($this->max_discount) {
            $discount = min($discount, $this->max_discount);
        }

        return round($discount, 2);
    }

    public function getFormattedValueAttribute(): string
    {
        return $this->type === 'percentage'
            ? $this->value . '%'
            : 'Rp ' . number_format($this->value, 0, ',', '.');
    }
}
