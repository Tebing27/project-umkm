<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    // --- Section: Relationships ---

    /**
     * Get the user that owns the shop.
     */
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

    // --- Section: Business Logic: Types & Logos ---

    /**
     * Get available business types.
     * Uses dynamic content from DB, falls back to hardcoded list.
     *
     * @return array
     */
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

    /**
     * Get the URL for the shop's logo.
     * Prioritizes custom logo -> dynamic fallback -> hardcoded fallback.
     *
     * @return string
     */
    public function getLogoUrlAttribute()
    {
        // 1. Return custom shop logo if exists
        if ($this->logo) {
            return storage_url($this->logo);
        }
    
        // 2. Try dynamic logo from database (admin-managed fallback)
        // Penjelasan: Admin bisa mengubah icon default per jenis usaha di database tanpa deploy code
        $dynamicLogo = $this->getDynamicFallbackLogo();
        if ($dynamicLogo) {
            return storage_url($dynamicLogo);
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
    /**
     * Get hardcoded default logo based on business type.
     */
    protected function getHardcodedFallbackLogo(): string
    {
        return asset('images/' . self::getFallbackLogoForType($this->business_type ?? 'kuliner'));
    }

    /**
     * Get hardcoded fallback logo filename based on business type.
     */
    public static function getFallbackLogoForType(string $type): string
    {
        $val = strtolower($type);
        
        $map = [
            'kuliner' => 'kuliner.svg',
            'pakaian & aksesoris' => 'pakaian.svg',
            'pakaian & fashion' => 'pakaian.svg',
            'kerajinan tangan' => 'kerajinan.svg',
            'kelontong' => 'kelontong.svg',
            'jasa' => 'jasa.svg',
            'agribisnis' => 'agribisnis.svg',
        ];

        // Try exact match
        if (isset($map[$val])) {
            return $map[$val];
        }
        
        // Try loose match
        foreach ($map as $key => $logo) {
            if (str_contains($val, $key)) {
                return $logo;
            }
        }

        return 'kuliner.svg';
    }

    /**
     * Get fallback marker icon name based on business type value.
     */
    public static function getFallbackMarkerIconForType(string $type): string
    {
        $val = strtolower($type);
        if (str_contains($val, 'kuliner') || str_contains($val, 'makan') || str_contains($val, 'food')) {
            return 'map-pin-food';
        } elseif (str_contains($val, 'fashion') || str_contains($val, 'baju') || str_contains($val, 'pakaian') || str_contains($val, 'aksesoris')) {
            return 'map-pin-fashion';
        } elseif (str_contains($val, 'jasa') || str_contains($val, 'service') || str_contains($val, 'work')) {
            return 'map-pin-work';
        } elseif (str_contains($val, 'kelontong') || str_contains($val, 'toko')) {
            return 'map-pin-shop';
        } elseif (str_contains($val, 'agribisnis') || str_contains($val, 'tani') || str_contains($val, 'pertanian')) {
            return 'map-pin-plants';
        } elseif (str_contains($val, 'kerajinan') || str_contains($val, 'craft')) {
            return 'map-pin-craft';
        }
        return 'map-pin';
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

    // --- Section: Verification Logic ---

    /**
     * Check if the shop has all required fields filled to be approved.
     *
     * @return bool
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

    /**
     * Check and update verification status if incomplete.
     *
     * @return void
     */
    public function updateVerificationStatus()
    {
        // Aturan Bisnis:
        // Jika data toko tidak lengkap (misal user menghapus foto/lokasi), 
        // status verifikasi otomatis dicabut demi menjaga kualitas konten Verified Shop.
        if ($this->is_verified && !$this->isComplete()) {
            $this->is_verified = false;
            $this->save();

            // Notify Admin and User
            \App\Events\ShopUpdated::dispatch($this->id);
            \App\Events\UserUpdated::dispatch($this->user_id, 'refresh');
        }
    }
}
