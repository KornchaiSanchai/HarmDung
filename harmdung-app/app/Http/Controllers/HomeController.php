<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\View\View;

class HomeController extends Controller
{
    private const TOP_LIMIT = 5;
    private const GENRE_LIMIT = 4;
    private const MOVIES_PER_GENRE = 5;

    /** ชื่อแนวหนังภาษาไทย (ชื่อจาก TMDB เป็นภาษาอังกฤษ) */
    private const GENRE_TH = [
        'Action' => 'แอคชัน',
        'Adventure' => 'ผจญภัย',
        'Animation' => 'แอนิเมชัน',
        'Comedy' => 'คอมเมดี้',
        'Crime' => 'อาชญากรรม',
        'Documentary' => 'สารคดี',
        'Drama' => 'ดราม่า',
        'Family' => 'ครอบครัว',
        'Fantasy' => 'แฟนตาซี',
        'History' => 'ประวัติศาสตร์',
        'Horror' => 'สยองขวัญ',
        'Music' => 'ดนตรี',
        'Mystery' => 'ลึกลับ',
        'Romance' => 'โรแมนติก',
        'Science Fiction' => 'ไซไฟ',
        'TV Movie' => 'ภาพยนตร์โทรทัศน์',
        'Thriller' => 'ระทึกขวัญ',
        'War' => 'สงคราม',
        'Western' => 'คาวบอย',
    ];

    public function index(): View
    {
        // TOP 5: หนังแนะนำ (is_featured จาก MovieSeeder) ก่อน แล้วเรียงตามคะแนนรีวิว
        $topMovies = Movie::query()
            ->with(['genres', 'platforms'])
            ->withRatingStats()
            ->whereHas('platforms')
            ->orderByDesc('is_featured')
            ->orderByDesc('reviews_avg_rating')
            ->orderByDesc('reviews_count')
            ->limit(self::TOP_LIMIT)
            ->get();

        // แนวหนังที่มีหนังมากที่สุด พร้อมหนังในแต่ละแนว
        $genres = Genre::query()
            ->whereHas('movies')
            ->withCount('movies')
            ->orderByDesc('movies_count')
            ->limit(self::GENRE_LIMIT)
            ->get()
            ->each(function (Genre $genre) {
                $genre->label = isset(self::GENRE_TH[$genre->name])
                    ? self::GENRE_TH[$genre->name].' / '.$genre->name
                    : $genre->name;

                $genre->setRelation('movies', $genre->movies()
                    ->with('platforms')
                    ->withRatingStats()
                    ->orderByDesc('is_featured')
                    ->orderByDesc('release_year')
                    ->limit(self::MOVIES_PER_GENRE)
                    ->get());
            });

        return view('welcome', compact('topMovies', 'genres'));
    }
}
