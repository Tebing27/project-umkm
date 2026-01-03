<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
    ];

    /**
     * Get content by key.
     */
    public static function get(string $key, $default = null)
    {
        $content = self::where('key', $key)->first();
        return $content ? $content->value : $default;
    }

    // --- Accessors for Clean View ---

    public function getIsHeroImageAttribute(): bool
    {
        return $this->group === 'home_hero' && $this->type === 'image';
    }

    public function getIsUmkmImageAttribute(): bool
    {
        return $this->group === 'umkm_index' && $this->type === 'image';
    }

    public function getColSpanClassAttribute(): string
    {
        if ($this->is_hero_image) {
            return 'md:col-span-1 lg:row-span-3';
        }
        if ($this->is_umkm_image) {
            return 'md:col-span-1 lg:row-span-3';
        }
        return 'xl:col-span-1 lg:row-span-2';
    }

    public function getImageDimensionsLabelAttribute(): string
    {
        if ($this->is_hero_image) {
            return 'Portrait Hero';
        }
        if ($this->is_umkm_image) {
            return 'Portrait Banner';
        }
        return 'Landscape (1920x1080)';
    }
}
