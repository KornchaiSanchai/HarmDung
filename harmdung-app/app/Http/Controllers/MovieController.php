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
        $movie = Movie::query()
            ->with([
                'genres',
                'platforms',
                'reviews' => fn ($q) => $q->with('user:id,name')->latest(),
            ])
            ->withRatingStats()
            ->findOrFail($request->integer('id'));

        return view('movie-details', compact('movie'));
    }
}
