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
        'region_id', // Add region_id
        'logo',
        'views',
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

    public const BUSINESS_TYPES = [
        'Kuliner',
        'Pakaian & Aksesoris',
        'Kelontong',
        'Agribisnis',
        'Jasa',
        'Kerajinan Tangan',
    ];

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }

        $businessType = strtolower($this->business_type);
        
        $map = [
            'kuliner' => 'kuliner.svg',
            'pakaian & aksesoris' => 'pakaian.svg', // Updated key
            'pakaian & fashion' => 'pakaian.svg', // Fallback for old data
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
