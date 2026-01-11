<?php
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Public Channel for 'Signal & Fetch' strategy
Broadcast::channel('shops', function () {
    return true;
});

Broadcast::channel('private-user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('public-content', function () {
    return true;
});

// Admin Global Channel for generic admin updates (User list, Dashboard stats, Settings)
// Note: This is a public channel to simplify "signal" broadcasting. 
// Sensitive data should NOT be sent payload.
Broadcast::channel('admin-global', function () {
    return true;
});
