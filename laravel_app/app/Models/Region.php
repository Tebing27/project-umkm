<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'latitude', 'longitude', 'featured_shop_id', 'hero_order'];

    public function featuredShop()
    {
        return $this->belongsTo(Shop::class, 'featured_shop_id');
    }

    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class);
    }
}
