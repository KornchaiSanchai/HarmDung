<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $fillable = [
        'title', 'synopsis', 'release_year', 'duration_min', 'poster_url', 'is_featured',
    ];

    protected function casts(): array
    {
        return ['is_featured' => 'boolean'];
    }

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class, 'movie_platform');
    }

    public function genres(): BelongsToMany
    {
        // ต้องระบุชื่อตารางกลาง เพราะค่าที่ Laravel เดาคือ genre_movie
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /** คะแนนเฉลี่ยและจำนวนรีวิว: reviews_avg_rating, reviews_count */
    public function scopeWithRatingStats(Builder $query): Builder
    {
        return $query->withAvg('reviews', 'rating')->withCount('reviews');
    }
}