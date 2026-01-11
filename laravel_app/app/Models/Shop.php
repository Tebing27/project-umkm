<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'region_id', // Add region_id
        'logo',
    ];

    protected $casts = [
        'licenses' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ShopPhoto::class);
    }

    public static function getBusinessTypes()
    {
        $customTypes = \App\Models\Content::where('group', 'business_types')->pluck('value')->toArray();
        
        if (!empty($customTypes)) {
            return $customTypes;
        }

        return [
            'Kuliner',
            'Pakaian & Aksesoris',
            'Kelontong',
            'Agribisnis',
            'Jasa',
            'Kerajinan Tangan',
        ];
    }

    public function getLogoUrlAttribute()
    {
        // 1. Return custom shop logo if exists
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }

        // 2. Try dynamic logo from database (admin-managed fallback)
        $dynamicLogo = $this->getDynamicFallbackLogo();
        if ($dynamicLogo) {
            return asset('storage/' . $dynamicLogo);
        }

        // 3. Hardcoded fallback based on business type
        return $this->getHardcodedFallbackLogo();
    }

    /**
     * Get dynamic fallback logo from database based on business type.
     */
    protected function getDynamicFallbackLogo(): ?string
    {
        $businessType = strtolower($this->business_type ?? 'kuliner');
        
        // Find the business type content record
        $content = Content::where('group', 'business_types')
            ->whereRaw('LOWER(value) = ?', [$businessType])
            ->first();
        
        if (!$content) {
            return null;
        }
        
        // Find the associated logo fallback
        $logoContent = Content::where('key', 'logo_fallback_for_' . $content->id)->first();
        
        return $logoContent?->value;
    }

    /**
     * Get hardcoded default logo based on business type.
     */
    protected function getHardcodedFallbackLogo(): string
    {
        $businessType = strtolower($this->business_type ?? 'kuliner');
        
        $map = [
            'kuliner' => 'kuliner.svg',
            'pakaian & aksesoris' => 'pakaian.svg',
            'pakaian & fashion' => 'pakaian.svg',
            'kerajinan tangan' => 'kerajinan.svg',
            'kelontong' => 'kelontong.svg',
            'jasa' => 'jasa.svg',
            'agribisnis' => 'agribisnis.svg',
        ];

        $image = $map[$businessType] ?? 'kuliner.svg';

        return asset('images/' . $image);
    }

    public function getInstagramUsernameAttribute()
    {
        if (!$this->social_instagram) return null;
        return str_replace(
            ['https://www.instagram.com/', 'https://instagram.com/', '@', '/'],
            '',
            $this->social_instagram
        );
    }

    public function getTiktokUsernameAttribute()
    {
        if (!$this->social_tiktok) return null;
        return str_replace(
            ['https://www.tiktok.com/', 'https://tiktok.com/', '@', '/'],
            '',
            $this->social_tiktok
        );
    }

    public function getFacebookUsernameAttribute()
    {
        if (!$this->social_facebook) return null;
        return str_replace(
            ['https://www.facebook.com/', 'https://facebook.com/', '/'],
            '',
            $this->social_facebook
        );
    }

    public function getWebsiteUrlAttribute()
    {
        if (!$this->social_website) return null;
        return \Illuminate\Support\Str::startsWith($this->social_website, ['http://', 'https://']) 
            ? $this->social_website 
            : 'https://' . $this->social_website;
    }

    /**
     * Check if the shop has all required fields filled to be approved.
     */
    public function isComplete(): bool
    {
        return empty($this->getMissingFields());
    }

    /**
     * Get list of missing fields/requirements.
     * 
     * @return array
     */
    public function getMissingFields(): array
    {
        $missing = [];

        if (empty($this->name)) $missing[] = 'Nama Usaha';
        if (empty($this->description)) $missing[] = 'Deskripsi';
        if (empty($this->address)) $missing[] = 'Alamat Lengkap';
        if (empty($this->latitude) || empty($this->longitude)) $missing[] = 'Lokasi Peta (Pinpoint)';
        if (empty($this->region_id)) $missing[] = 'Wilayah / Kelurahan';
        if (empty($this->business_type)) $missing[] = 'Jenis Usaha';
        if (empty($this->omset_min)) $missing[] = 'Omset Penjualan';
        if (!$this->products()->exists()) $missing[] = 'Minimal 1 Produk';
        if (!$this->photos()->exists()) $missing[] = 'Visualisasi Toko / Foto';

        return $missing;
    }
    /**
     * Get licenses as array, handling both string (JSON) and array source.
     */
    public function getLicensesArrayAttribute()
    {
        $licenses = $this->licenses;
        if (is_string($licenses)) {
            $decoded = json_decode($licenses, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($licenses) ? $licenses : [];
    }
    public function getHasSocialsAttribute(): bool
    {
        return $this->social_instagram || $this->social_tiktok || $this->social_facebook || $this->social_website;
    }
}
