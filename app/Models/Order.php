<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'table_id',
        'promo_id',
        'order_type',
        'status',
        'payment_status',
        'payment_method',
        'snap_token',
        'payment_token',
        'payment_url',          // URL checkout page Tripay
        'tripay_reference',     // Kode referensi transaksi Tripay (misal: DEV-T00001)
        'payment_expired_at',   // Waktu kadaluarsa transaksi Tripay
        'subtotal',
        'discount_amount',
        'tax_amount',
        'service_charge',
        'total_amount',
        'loyalty_points_earned',
        'loyalty_points_used',
        'special_notes',
        'cancellation_reason',
        'paid_at',
        'completed_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'service_charge' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'loyalty_points_earned' => 'integer',
        'loyalty_points_used' => 'integer',
        'paid_at' => 'datetime',
        'completed_at' => 'datetime',
        'payment_expired_at' => 'datetime',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function loyaltyTransactions(): HasMany
    {
        return $this->hasMany(LoyaltyTransaction::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed', 'processing', 'ready']);
    }

    public function scopeForKitchen($query)
    {
        return $query->whereIn('status', ['confirmed', 'processing'])
            ->where('payment_status', 'paid');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'processing' => 'orange',
            'ready' => 'green',
            'completed' => 'emerald',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    public function getPaymentStatusBadgeColorAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => 'green',
            'unpaid' => 'yellow',
            'expired' => 'red',
            'failed' => 'red',
            'refunded' => 'purple',
            default => 'gray',
        };
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'])
            && $this->payment_status !== 'paid';
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'ZN-' . date('Y') . '-';
        $lastOrder = static::where('order_number', 'LIKE', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $nextNumber = $lastOrder
            ? (int) substr($lastOrder->order_number, strlen($prefix)) + 1
            : 1;

        return $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
