<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CheckoutRequest;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaymentService;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly OrderService $orderService,
    ) {}

    public function index()
    {
        $summary = $this->cartService->getSummary(auth()->user());

        if ($summary['cart']->items->isEmpty()) {
            return redirect()->route('menu.index')
                ->with('error', 'Keranjang kamu kosong. Yuk pilih menu dulu!');
        }

        return view('customer.checkout.index', compact('summary'));
    }

    public function store(CheckoutRequest $request)
    {
        $order = $this->orderService->createFromCart(
            auth()->user(),
            $request->order_type,
            $request->special_notes,
            $request->payment_method,
        );

        // Pembayaran gateway eksternal dihilangkan, 
        // pesanan langsung dibuat dengan status unpaid.

        return redirect()
            ->route('customer.orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran.');
    }

    public function success(\App\Models\Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        return view('customer.checkout.success', compact('order'));
    }
}