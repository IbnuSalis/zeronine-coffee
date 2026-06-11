<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly OrderService $orderService,
    ) {}

    public function index()
    {
        $orders = $this->orderRepository->getUserOrders(auth()->id());
        return view('customer.orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = Order::with(['items.menu', 'table', 'promo'])->findOrFail($id);
        abort_if($order->user_id !== auth()->id(), 403, 'Akses ditolak.');

        return view('customer.orders.show', compact('order'));
    }

    public function cancel(Request $request, int $id)
    {
        $order = Order::findOrFail($id);
        abort_if($order->user_id !== auth()->id(), 403, 'Akses ditolak.');

        $request->validate(['reason' => 'required|string|max:255']);

        try {
            $this->orderService->cancel($order, $request->reason);
            return back()->with('success', 'Pesanan Anda berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function review(Request $request, int $id)
    {
        $order = Order::findOrFail($id);
        abort_if($order->user_id !== auth()->id(), 403, 'Akses ditolak.');
        abort_if($order->status !== 'completed', 422, 'Hanya pesanan selesai yang dapat diulas.');

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        foreach ($order->items as $item) {
            \App\Models\Review::create([
                'user_id'     => auth()->id(),
                'menu_id'     => $item->menu_id,
                'rating'      => $request->rating,
                'comment'     => $request->comment,
                'is_approved' => true,
            ]);
        }

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    public function confirmPayment(Request $request, int $id)
    {
        $order = Order::findOrFail($id);
        abort_if($order->user_id !== auth()->id(), 403, 'Akses ditolak.');

        if ($order->payment_status === 'unpaid' && $order->status !== 'cancelled') {
            $order->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
                'status' => 'processing',
            ]);

            // Kirim notifikasi ke user (muncul di navbar)
            auth()->user()->notify(new \App\Notifications\OrderPaidNotification($order));

            // Award loyalty points (setiap Rp 10.000 = 10 poin)
            $points = (int) floor($order->total_amount / 1000);
            if ($points > 0) {
                $loyaltyService = app(\App\Services\LoyaltyService::class);
                $loyaltyService->awardPoints(
                    auth()->user(),
                    $points,
                    $order,
                    "Belanja pesanan #{$order->order_number} (+{$points} poin)"
                );
            }

            return back()->with('success', 'Pesanan berhasil dilakukan. Anda mendapatkan ' . $points . ' loyalty points!');
        }

        return back()->with('error', 'Status pesanan tidak dapat diubah.');
    }
}