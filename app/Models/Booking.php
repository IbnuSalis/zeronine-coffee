<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'table_id',
        'booking_date',
        'start_time',
        'end_time',
        'guest_count',
        'status',
        'occasion',
        'special_requests',
        'contact_name',
        'contact_phone',
        'cancellation_reason',
        'confirmed_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'guest_count' => 'integer',
        'confirmed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', today())
            ->whereIn('status', ['pending', 'confirmed']);
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'checked_in' => 'green',
            'completed' => 'emerald',
            'cancelled' => 'red',
            'no_show' => 'gray',
            default => 'gray',
        };
    }

    public static function generateBookingCode(): string
    {
        $prefix = 'BK-' . date('Y') . '-';
        $last = static::where('booking_code', 'LIKE', $prefix . '%')
            ->orderByDesc('id')
            ->first();
        $nextNumber = $last ? (int) substr($last->booking_code, strlen($prefix)) + 1 : 1;
        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
