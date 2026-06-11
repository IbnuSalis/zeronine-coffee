<?php

namespace App\Services;

use App\Events\OrderStatusUpdated;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PromoUsage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly LoyaltyService $loyaltyService,
    ) {}

    public function createFromCart(
        User $user,
        string $orderType = 'dine_in',
        ?string $notes = null,
        string $paymentMethod = 'midtrans',
    ): Order {
        return DB::transaction(function () use ($user, $orderType, $notes, $paymentMethod) {
            $summary = $this->cartService->getSummary($user);
            $cart    = $summary['cart'];

            if ($cart->items->isEmpty()) {
                throw \Illuminate\Validation\ValidationException::withMessages(['cart' => 'Keranjang kamu kosong.']);
            }

            foreach ($cart->items as $item) {
                if ($item->menu->stock < $item->quantity) {
                    throw \Illuminate\Validation\ValidationException::withMessages(['cart' => "Stok {$item->menu->name} tidak mencukupi."]);
                }
            }

            $pointsEarned = (int) floor($summary['total'] / 1000);

            $order = Order::create([
                'order_number'          => Order::generateOrderNumber(),
                'user_id'               => $user->id,
                'table_id'              => $cart->table_id,
                'promo_id'              => $cart->promo_id,
                'order_type'            => $orderType,
                'status'                => 'pending',
                'payment_status'        => 'unpaid',
                'payment_method'        => $paymentMethod,
                'subtotal'              => $summary['subtotal'],
                'discount_amount'       => $summary['discount'],
                'tax_amount'            => $summary['tax'],
                'service_charge'        => $summary['service'],
                'total_amount'          => $summary['total'],
                'loyalty_points_earned' => $pointsEarned,
                'special_notes'         => $notes,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'       => $order->id,
                    'menu_id'        => $item->menu_id,
                    'menu_name'      => $item->menu->name,
                    'menu_price'     => $item->menu->price,
                    'quantity'       => $item->quantity,
                    'subtotal'       => $item->menu->price * $item->quantity,
                    'notes'          => $item->notes,
                    'customizations' => $item->customizations,
                ]);

                $item->menu->decrement('stock', $item->quantity);
            }

            if ($cart->promo_id) {
                PromoUsage::create([
                    'promo_id'        => $cart->promo_id,
                    'user_id'         => $user->id,
                    'order_id'        => $order->id,
                    'discount_amount' => $summary['discount'],
                ]);
                $cart->promo->increment('used_count');
            }

            $this->cartService->clear($user);

            return $order;
        });
    }

    public function updateStatus(Order $order, string $newStatus, ?string $reason = null): Order
    {
        $order->update([
            'status'               => $newStatus,
            'cancellation_reason'  => $newStatus === 'cancelled' ? $reason : $order->cancellation_reason,
            'completed_at'         => $newStatus === 'completed' ? now() : $order->completed_at,
        ]);

        if ($newStatus === 'completed' && $order->isPaid() && $order->loyalty_points_earned > 0) {
            $this->loyaltyService->awardPoints(
                $order->user,
                $order->loyalty_points_earned,
                $order,
                "Poin dari pesanan #{$order->order_number}"
            );
        }

        broadcast(new OrderStatusUpdated($order))->toOthers();

        return $order->fresh();
    }

    public function cancel(Order $order, string $reason): Order
    {
        abort_if(! $order->canBeCancelled(), 422, 'Pesanan ini tidak dapat dibatalkan.');

        return DB::transaction(function () use ($order, $reason) {
            foreach ($order->items as $item) {
                $item->menu->increment('stock', $item->quantity);
            }

            return $this->updateStatus($order, 'cancelled', $reason);
        });
    }
}