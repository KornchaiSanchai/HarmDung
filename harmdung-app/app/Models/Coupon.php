<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = ['code', 'discount_percent', 'min_spend', 'expiry_date', 'usage_limit', 'used_count'];

    protected function casts(): array
    {
        return [
            'discount_percent' => 'decimal:2',
            'min_spend' => 'decimal:2',
            'expiry_date' => 'date',
        ];
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'coupon_product');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}