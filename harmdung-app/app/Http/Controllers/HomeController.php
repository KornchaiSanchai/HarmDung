<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\View\View;

class HomeController extends Controller
{
    private const TOP_LIMIT = 5;
    private const GENRE_LIMIT = 6;
    private const MOVIES_PER_GENRE = 20;

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

    public function index(\Illuminate\Http\Request $request): View|\Illuminate\Http\JsonResponse
    {
        $search = trim((string) $request->input('search', $request->input('q', '')));

        // รองรับ AJAX สำหรับ Live Search Autocomplete
        if ($request->wantsJson() || $request->ajax()) {
            if ($search === '') {
                return response()->json(['movies' => []]);
            }

            $liveMovies = Movie::query()
                ->with(['genres', 'platforms'])
                ->withRatingStats()
                ->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('synopsis', 'like', "%{$search}%");
                })
                ->orWhereHas('genres', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orderByDesc('reviews_avg_rating')
                ->limit(8)
                ->get()
                ->map(fn ($m) => [
                    'id'           => $m->id,
                    'title'        => $m->title,
                    'release_year' => $m->release_year,
                    'poster_url'   => $m->poster_url,
                    'rating'       => $m->reviews_avg_rating ? number_format($m->reviews_avg_rating, 1) : null,
                    'genres'       => $m->genres->pluck('name')->take(2)->implode(' / '),
                    'url'          => route('movie-details', ['id' => $m->id]),
                ]);

            return response()->json(['movies' => $liveMovies]);
        }

        // กรณีค้นหาหนังผ่านแบบฟอร์ม
        $searchResults = null;
        if ($search !== '') {
            $searchResults = Movie::query()
                ->with(['genres', 'platforms'])
                ->withRatingStats()
                ->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('synopsis', 'like', "%{$search}%");
                })
                ->orWhereHas('genres', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orderByDesc('reviews_avg_rating')
                ->get();
        }

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

        // แนวหนังที่มีหนังมากที่สุด พร้อมหนังในแต่ละแนว (ดึงสูงสุด 20 เรื่องเพื่อให้เลื่อนดูได้)
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

        return view('welcome', compact('topMovies', 'genres', 'search', 'searchResults'));
    }
}
