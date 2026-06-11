<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'phone',
        'address',
        'birth_date',
        'gender',
        'membership_tier_id',
        'loyalty_points',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'google_id',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'loyalty_points' => 'integer',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function membershipTier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class);
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function loyaltyTransactions(): HasMany
    {
        return $this->hasMany(LoyaltyTransaction::class);
    }

    public function promoUsages(): HasMany
    {
        return $this->hasMany(PromoUsage::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return str_starts_with($this->avatar, 'http')
                ? $this->avatar
                : asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=3E2723&color=FFF8F0';
    }

    public function hasUsedPromo(Promo $promo): bool
    {
        return $this->promoUsages()
            ->where('promo_id', $promo->id)
            ->count() >= $promo->per_user_limit;
    }
}
