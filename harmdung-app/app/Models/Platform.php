<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Platform extends Model
{
    protected $fillable = ['name', 'logo_url', 'website_url'];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'movie_platform');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * ดึงโลโก้ภาพจริงบนเว็บ (ไฟล์ใน public/images)
     */
    public function getAppLogoUrlAttribute(): string
    {
        $name = strtolower($this->name ?? '');

        if (str_contains($name, 'netf') || $this->id === 1) {
            return asset('images/netflux.png');
        }
        if (str_contains($name, 'hiv') || str_contains($name, 'hbo') || $this->id === 2) {
            return asset('images/hiv.png');
        }
        if (str_contains($name, 'hindu') || str_contains($name, 'prime') || str_contains($name, 'amazon') || $this->id === 3) {
            return asset('images/hindu.png');
        }
        if (str_contains($name, 'thisney') || str_contains($name, 'disney') || $this->id === 4) {
            return asset('images/thisney.png');
        }

        return $this->logo_url ?? asset('images/logo.png');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->app_logo_url;
    }

    public function getBgClassAttribute(): string
    {
        $name = strtolower($this->name ?? '');

        if (str_contains($name, 'netf') || $this->id === 1) {
            return 'bg-gradient-to-r from-[#3e0808] to-[#1a0202]';
        }
        if (str_contains($name, 'hiv') || str_contains($name, 'hbo') || $this->id === 2) {
            return 'bg-gradient-to-r from-[#5a1bb9] to-[#204ce4]';
        }
        if (str_contains($name, 'hindu') || str_contains($name, 'prime') || str_contains($name, 'amazon') || $this->id === 3) {
            return 'bg-gradient-to-r from-[#0d213b] to-[#123e6f]';
        }
        if (str_contains($name, 'thisney') || str_contains($name, 'disney') || $this->id === 4) {
            return 'bg-gradient-to-r from-[#0b1b3d] to-[#043360]';
        }

        return 'bg-gradient-to-r from-gray-800 to-gray-900';
    }
}