<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PushToFirebase
{
    // use InteractsWithQueue; // Optional if we remove ShouldQueue

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $firebaseUrl = env('FIREBASE_DATABASE_URL');

        if (!$firebaseUrl) {
            Log::warning('Firebase Database URL not configured.');
            return;
        }

        // 1. Get Payload
        $payload = [];
        if (method_exists($event, 'broadcastWith')) {
            $payload = $event->broadcastWith();
        } else {
            // Fallback for events without broadcastWith
            $payload = [
                'timestamp' => now()->timestamp,
                'event' => class_basename($event),
            ];
            // Try to extract ID if available
            if (isset($event->shopId)) $payload['shop_id'] = $event->shopId;
            if (isset($event->userId)) $payload['user_id'] = $event->userId;
        }

        // 2. Get Channels
        $channels = [];
        if (method_exists($event, 'broadcastOn')) {
            foreach ($event->broadcastOn() as $channel) {
                $name = null;
                if (is_object($channel) && method_exists($channel, '__toString')) {
                    $name = (string) $channel;
                } elseif (property_exists($channel, 'name')) {
                    $name = $channel->name;
                } elseif (is_string($channel)) {
                    $name = $channel;
                }

                if ($name) {
                    // Refine Channel Paths for Firebase
                    // The generic 'shops' channel should target the specific shop node for existing frontend compatibility
                    if ($name === 'shops' && isset($event->shopId)) {
                        $channels[] = 'shops/' . $event->shopId;
                    } 
                    // Same for products
                    elseif ($name === 'products' && isset($event->productId)) {
                        $channels[] = 'products/' . $event->productId;
                    } 
                    else {
                        $channels[] = $name;
                    }
                    
                    // Note: 'admin-global' passes through as is.
                }
            }
        }
        
        // Fallback for events without broadcastOn (Legacy support)
        if (empty($channels)) {
             $class = get_class($event);
             if (str_contains($class, 'ShopUpdated') && isset($event->shopId)) {
                $channels[] = 'shops/' . $event->shopId;
                $channels[] = 'admin-global';
             } elseif (str_contains($class, 'ProductUpdated') && isset($event->productId)) {
                $channels[] = 'products/' . $event->productId;
             } elseif (str_contains($class, 'ContentUpdated')) {
                $channels[] = 'public-content';
             }
        }

        // 3. Push to Firebase
        foreach ($channels as $channelName) {
            try {
                // Ensure no leading slash
                $channelName = ltrim($channelName, '/');
                
                // We overwrite the node. 
                $response = Http::put("{$firebaseUrl}/channels/{$channelName}.json", $payload);
                
                if (!$response->successful()) {
                    Log::error("Firebase Push Failed [{$channelName}]: " . $response->body());
                } else {
                    Log::info("Firebase Push Success [{$channelName}]", $payload);
                }
            } catch (\Exception $e) {
                Log::error("Firebase Push Error [{$channelName}]: " . $e->getMessage());
            }
        }
    }
}
