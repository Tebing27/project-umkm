<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $action;
    public $productId;
    public $productData;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $action = 'refresh', $productId = null, $productData = [])
    {
        $this->userId = $userId;
        $this->action = $action;
        $this->productId = $productId;
        $this->productData = $productData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('private-user.' . $this->userId),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'productId' => $this->productId,
            'data' => $this->productData,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
