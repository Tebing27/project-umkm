<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShopUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $shopId;

    /**
     * Create a new event instance.
     *
     * @param int|null $shopId
     */
    public function __construct($shopId = null)
    {
        $this->shopId = $shopId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('shops'),
            new Channel('admin-global'),
        ];
    }

    /**
     * SECURITY: Only broadcast a 'refresh' signal, NOT sensitive data.
     * The frontend will fetch updated data via authenticated API.
     */
    public function broadcastWith(): array
    {
        return [
            'action' => 'refresh',
            'shop_id' => $this->shopId,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
