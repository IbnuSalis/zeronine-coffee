<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'thumbnail',
        'preparation_time',
        'calories',
        'ingredients',
        'allergens',
        'is_available',
        'is_featured',
        'is_new',
        'is_best_seller',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'calories' => 'decimal:2',
        'ingredients' => 'array',
        'allergens' => 'array',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'is_best_seller' => 'boolean',
        'stock' => 'integer',
        'preparation_time' => 'integer',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $menu) {
            if (empty($menu->slug)) {
                $menu->slug = Str::slug($menu->name);
            }
        });
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBestSeller($query)
    {
        return $query->where('is_best_seller', true);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhere('description', 'LIKE', "%{$term}%");
        });
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/menu-placeholder.webp');
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->where('is_approved', true)->avg('rating') ?? 0.0;
    }

    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->where('is_approved', true)->count();
    }
}
