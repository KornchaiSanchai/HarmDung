<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieController extends Controller
{
    /** หน้า /movie-details?id={movie_id} */
    public function show(Request $request): View
    {
        $user = $request->user();
        $movie = Movie::query()
            ->with([
                'genres',
                'platforms',
                'reviews' => fn ($q) => $q->with('user:id,name')->latest(),
            ])
            ->withRatingStats()
            ->findOrFail($request->integer('id'));

        // ประเมินสถานะรีวิวและคะแนนจาก Controller โดยตรง
        $userReview = $user ? $movie->reviews->firstWhere('user_id', $user->id) : null;
        $hasReviewed = $userReview !== null;
        $ratingFormatted = $movie->reviews_count ? number_format($movie->reviews_avg_rating, 1) : '-';
        $genresText = $movie->genres->pluck('name')->implode(' / ');

        return view('movie-details', compact('movie', 'userReview', 'hasReviewed', 'ratingFormatted', 'genresText'));
    }
}
