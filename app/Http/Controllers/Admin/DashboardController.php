<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Menu;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'total_orders' => Order::count(),
            'active_orders' => Order::whereIn('status', ['pending', 'processing', 'ready'])->count(),
            'today_bookings' => Booking::whereDate('booking_date', today())->count(),
            'total_customers' => User::role('customer')->count(),
            'out_of_stock_menus' => Menu::where('stock', '<=', 0)->count(),
        ];

        $recentOrders = Order::with(['user', 'table'])
            ->latest()
            ->limit(5)
            ->get();

        $topMenus = \App\Models\OrderItem::selectRaw('menu_id, menu_name, SUM(quantity) as total_sold, SUM(subtotal) as total_revenue')
            ->whereHas('order', fn ($q) => $q->where('payment_status', 'paid'))
            ->groupBy('menu_id', 'menu_name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topMenus'));
    }
}
