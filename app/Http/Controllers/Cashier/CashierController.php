<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        $pendingOrders = Order::with(['user', 'table', 'items'])
            ->whereIn('status', ['pending', 'processing', 'ready'])
            ->latest()
            ->get();

        $completedToday = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->count();

        $revenueToday = Order::whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        return view('cashier.index', compact('pendingOrders', 'completedToday', 'revenueToday'));
    }

    public function verifyPayment(Request $request, Order $order)
    {
        $order->update([
            'payment_status' => 'paid',
            'payment_method' => $request->payment_method ?? 'cash',
            'paid_at'        => now(),
            'status'         => 'completed',
        ]);

        return back()->with('success', "Pembayaran pesanan #{$order->id} berhasil diverifikasi!");
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,ready,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', "Status pesanan #{$order->id} berhasil diperbarui menjadi {$request->status}.");
    }

    public function receipt(Order $order)
    {
        $order->load(['user', 'table', 'items', 'promo']);
        return view('cashier.receipt', compact('order'));
    }
}
