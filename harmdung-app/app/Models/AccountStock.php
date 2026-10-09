<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'order_id',
        'email',       // หรือ field ข้อมูลบัญชี/คีย์ตามที่วาง Schema ไว้
        'password',
        'status',      // 'available', 'sold'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}