<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipTier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'min_points',
        'discount_percent',
        'cashback_percent',
        'badge_color',
        'badge_icon',
        'benefits',
        'is_active',
    ];

    protected $casts = [
        'discount_percent' => 'decimal:2',
        'cashback_percent' => 'decimal:2',
        'min_points' => 'integer',
        'is_active' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
