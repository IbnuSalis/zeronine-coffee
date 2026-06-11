<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class OrderRepository extends BaseRepository
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function getForKitchen(): \Illuminate\Database\Eloquent\Collection
    {
        return Order::with(['items.menu', 'table', 'user'])
            ->forKitchen()
            ->orderBy('created_at')
            ->get();
    }

    public function getForCashier(): \Illuminate\Database\Eloquent\Collection
    {
        return Order::with(['items.menu', 'user', 'table', 'promo'])
            ->whereIn('status', ['ready', 'completed'])
            ->orderByDesc('updated_at')
            ->get();
    }

    public function getUserOrders(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Order::with(['items.menu', 'table', 'promo'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function getPendingPayments(): \Illuminate\Database\Eloquent\Collection
    {
        return Order::where('payment_status', 'unpaid')
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subHours(24))
            ->get();
    }

    /**
     * Sales summary for manager dashboard.
     */
    public function getDailySales(int $days = 30): Collection
    {
        return Order::selectRaw('DATE(created_at) as date, COUNT(*) as total_orders, SUM(total_amount) as revenue')
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function getPeakHours(): Collection
    {
        return Order::selectRaw('HOUR(created_at) as hour, COUNT(*) as total_orders')
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
    }

    public function getTopMenus(int $limit = 10): Collection
    {
        return \App\Models\OrderItem::selectRaw('menu_id, menu_name, SUM(quantity) as total_sold, SUM(subtotal) as total_revenue')
            ->whereHas('order', fn ($q) => $q->where('payment_status', 'paid'))
            ->groupBy('menu_id', 'menu_name')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }
}
