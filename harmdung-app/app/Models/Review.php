<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ตาราง reviews ใช้ composite PK (user_id, movie_id) ไม่มีคอลัมน์ id
 *
 * ห้ามใช้: $review->save() / $review->update() / $review->delete() กับแถวเดิม
 * ใช้แทน:
 *   เพิ่มหรือแก้ : Review::upsert([[...]], ['user_id','movie_id'], ['rating','comment'])
 *   ลบ          : Review::where('user_id', $u)->where('movie_id', $m)->delete()
 */
class Review extends Model
{
    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = ['user_id', 'movie_id', 'rating', 'comment'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}