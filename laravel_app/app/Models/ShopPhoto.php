<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['shop_id', 'path', 'order'];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
