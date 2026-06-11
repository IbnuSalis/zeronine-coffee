<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'table', 'items']);

        if ($request->search) {
            $query->where('id', $request->search)
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,ready,completed,cancelled']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status pesanan diperbarui!');
    }
}
