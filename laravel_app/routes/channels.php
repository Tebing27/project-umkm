<?php

/**
 * Note: Broadcasting channels are disabled as the app uses Firebase Realtime Database
 * for real-time updates instead of Laravel Broadcasting.
 * 
 * Firebase handles real-time updates through:
 * - /shops/{id} - Shop data and verification status
 * - /users/{id} - User profile data  
 * - /content - CMS content updates
 * - /products/{id} - Product modifications
 */

// Uncomment if you need to re-enable Laravel Broadcasting:
/*
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('shops', function () {
    return true;
});

Broadcast::channel('private-user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('public-content', function () {
    return true;
});

Broadcast::channel('admin-global', function () {
    return true;
});
*/
