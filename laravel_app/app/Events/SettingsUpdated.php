<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SettingsUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type;
    public $action;

    /**
     * Create a new event instance.
     * 
     * @param string $type The type of setting updated (e.g., 'profile', 'password', 'general')
     */
    public function __construct($type = 'general', $action = 'refresh')
    {
        $this->type = $type;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('admin-global'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'type' => $this->type,
            'action' => $this->action,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
