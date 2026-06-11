<?php

namespace App\Repositories;

use App\Models\Menu;
use Illuminate\Pagination\LengthAwarePaginator;

class MenuRepository extends BaseRepository
{
    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }

    /**
     * Paginated menu list with optional search, category filter, and availability filter.
     */
    public function filter(
        ?string $search = null,
        ?int $categoryId = null,
        bool $onlyAvailable = true,
        int $perPage = 12
    ): LengthAwarePaginator {
        return Menu::query()
            ->with('category')
            ->when($onlyAvailable, fn ($q) => $q->available())
            ->when($search, fn ($q) => $q->search($search))
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->orderBy('sort_order')
            ->orderByDesc('is_featured')
            ->paginate($perPage);
    }

    public function getFeatured(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        return Menu::with('category')->featured()->available()->limit($limit)->get();
    }

    public function getBestSellers(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        return Menu::with('category')->bestSeller()->available()->limit($limit)->get();
    }

    public function findBySlug(string $slug): ?Menu
    {
        return Menu::with(['category', 'reviews' => fn ($q) => $q->approved()->with('user')])->where('slug', $slug)->first();
    }

    public function decrementStock(int $menuId, int $quantity): void
    {
        Menu::where('id', $menuId)->decrement('stock', $quantity);
    }
}
