<?php

namespace App\Events;

use App\Models\Inventory;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LowStockAlert implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly Inventory $inventory) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('admin-alerts'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'inventory.low-stock';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->inventory->id,
            'item_name' => $this->inventory->item_name,
            'stock' => $this->inventory->stock,
            'min_stock' => $this->inventory->min_stock,
            'unit' => $this->inventory->unit,
        ];
    }
}
