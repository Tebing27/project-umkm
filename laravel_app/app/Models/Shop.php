<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shop extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'product_type',
        'business_type',
        'omset_min',
        'omset_max',
        'is_verified',
        'address',
        'rt',
        'rw',
        'latitude',
        'longitude',
        'licenses',
        'social_instagram',
        'social_tiktok',
        'social_facebook',
        'social_website',
        'rejection_reason',
    ];

    protected $casts = [
        'licenses' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
