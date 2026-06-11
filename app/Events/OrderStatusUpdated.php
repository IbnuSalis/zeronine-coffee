<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly Order $order) {}

    public function broadcastOn(): array
    {
        return [
            // Customer-specific channel for their order
            new PrivateChannel('orders.' . $this->order->user_id),
            // Staff channels for kitchen and cashier
            new Channel('kitchen'),
            new Channel('cashier'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'order.status.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'status' => $this->order->status,
            'payment_status' => $this->order->payment_status,
            'status_badge_color' => $this->order->status_badge_color,
            'table_number' => $this->order->table?->number,
            'total_amount' => $this->order->total_amount,
            'items_count' => $this->order->items()->count(),
            'updated_at' => $this->order->updated_at->toISOString(),
        ];
    }
}
