<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = ['user_id', 'coupon_id', 'subtotal', 'discount_amount', 'total', 'status'];

public function products()
{
    return $this->belongsToMany(Product::class, 'order_items')
        ->withPivot('quantity', 'unit_price');
}
    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, 'coupon_product');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'unit_price');
    }
}