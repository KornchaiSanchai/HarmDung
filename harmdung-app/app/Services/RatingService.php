<?php

namespace App\Services;

use App\Models\Review;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class RatingService
{
    /** เพิ่มคอลัมน์ reviews_avg_rating และ reviews_count ให้ query ของ Movie */
    public function withRating(Builder $query): Builder
    {
        if (empty($query->getQuery()->columns)) {
            $query->select('movies.*');
        }

        return $query->addSelect([
            'reviews_avg_rating' => Review::selectRaw('ROUND(AVG(rating), 2)')
                ->whereColumn('reviews.movie_id', 'movies.id'),
            'reviews_count' => Review::selectRaw('COUNT(*)')
                ->whereColumn('reviews.movie_id', 'movies.id'),
        ]);
    }

    /** หนังคะแนนสูงสุด (ต้องมีรีวิวอย่างน้อย $minReviews รีวิว) */
    public function topRated(Builder $query, int $minReviews = 1): Builder
    {
        return $this->withRating($query)
            ->whereRaw('(SELECT COUNT(*) FROM reviews WHERE reviews.movie_id = movies.id) >= ?', [$minReviews])
            ->orderByDesc('reviews_avg_rating')
            ->orderByDesc('reviews_count');
    }

    /** คะแนนเฉลี่ยและจำนวนรีวิวของหนัง 1 เรื่อง */
    public function summaryFor(int $movieId): array
    {
        $row = Review::where('movie_id', $movieId)
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as review_count')
            ->first();

        return [
            'avg'   => round((float) ($row->avg_rating ?? 0), 1),
            'count' => (int) ($row->review_count ?? 0),
        ];
    }

    /** รายการรีวิวของหนัง พร้อมชื่อผู้เขียน */
    public function reviewsFor(int $movieId, int $perPage = 10): LengthAwarePaginator
    {
        return Review::query()
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->where('reviews.movie_id', $movieId)
            ->select('reviews.*', 'users.name as user_name')
            ->orderByDesc('reviews.created_at')
            ->paginate($perPage)
            ->fragment('reviews');
    }

    /** รีวิวของผู้ใช้ที่ล็อกอินอยู่ (ถ้ามี) */
    public function myReview(int $movieId, ?int $userId): ?Review
    {
        if (! $userId) {
            return null;
        }

        return Review::where('movie_id', $movieId)->where('user_id', $userId)->first();
    }
}