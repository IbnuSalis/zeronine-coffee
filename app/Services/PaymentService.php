<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class PaymentService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = config('services.midtrans.is_sanitized', true);
        Config::$is3ds = config('services.midtrans.is_3ds', true);
    }

    /**
     * Generate a Midtrans Snap token for the given order.
     */
    public function createSnapToken(Order $order): string
    {
        $order->load(['user', 'items']);

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '',
            ],
            'item_details' => $this->buildItemDetails($order),
            'callbacks' => [
                'finish' => route('customer.orders.show', $order),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $order->update(['snap_token' => $snapToken]);

        return $snapToken;
    }

    /**
     * Handle Midtrans payment notification webhook.
     */
    public function handleNotification(array $notificationData): Order
    {
        $notification = new \Midtrans\Notification();
        $orderId = $notification->order_id; // This is our order_number
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status ?? 'accept';
        $paymentType = $notification->payment_type ?? null;

        $order = Order::where('order_number', $orderId)->firstOrFail();

        $paymentStatus = match (true) {
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => 'paid',
            $transactionStatus === 'settlement' => 'paid',
            in_array($transactionStatus, ['cancel', 'deny', 'expire']) => match ($transactionStatus) {
                'expire' => 'expired',
                default => 'failed',
            },
            $transactionStatus === 'pending' => 'unpaid',
            default => $order->payment_status,
        };

        $order->update([
            'payment_status' => $paymentStatus,
            'payment_method' => $paymentType,
            'payment_token' => $notification->transaction_id ?? null,
            'paid_at' => $paymentStatus === 'paid' ? now() : $order->paid_at,
            'status' => $paymentStatus === 'paid' ? 'confirmed' : $order->status,
        ]);

        // Broadcast payment update
        broadcast(new \App\Events\OrderStatusUpdated($order->fresh()))->toOthers();

        return $order->fresh();
    }

    /**
     * Build the item_details array for Midtrans payload.
     */
    private function buildItemDetails(Order $order): array
    {
        $items = $order->items->map(fn ($item) => [
            'id' => 'MENU-' . $item->menu_id,
            'price' => (int) $item->menu_price,
            'quantity' => $item->quantity,
            'name' => substr($item->menu_name, 0, 50),
        ])->toArray();

        // Add tax line item
        if ($order->tax_amount > 0) {
            $items[] = [
                'id' => 'TAX',
                'price' => (int) $order->tax_amount,
                'quantity' => 1,
                'name' => 'Pajak (PPN 10%)',
            ];
        }

        // Add service charge
        if ($order->service_charge > 0) {
            $items[] = [
                'id' => 'SERVICE',
                'price' => (int) $order->service_charge,
                'quantity' => 1,
                'name' => 'Biaya Layanan (5%)',
            ];
        }

        // Subtract discount
        if ($order->discount_amount > 0) {
            $items[] = [
                'id' => 'DISCOUNT',
                'price' => -(int) $order->discount_amount,
                'quantity' => 1,
                'name' => 'Diskon Promo',
            ];
        }

        return $items;
    }
}
