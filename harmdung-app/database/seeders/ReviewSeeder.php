<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Database\Seeders\Concerns\TmdbClient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Imports TMDB reviews for the movies already in the database.
 *
 * - matches each movie on TMDB by title + release_year (concurrent search)
 * - fetches each match's reviews (concurrent)
 * - creates one dummy user per TMDB author (password: "password")
 * - upserts into reviews (composite PK user_id + movie_id)
 */
class ReviewSeeder extends Seeder
{
    use TmdbClient;

    private const MAX_PER_MOVIE = 8;
    private const BATCH = 10; // concurrent requests

    public function run(): void
    {
        if (! $this->tmdbReady()) {
            return;
        }

        $movies = Movie::all();
        if ($movies->isEmpty()) {
            $this->command?->warn('No movies found, run MovieSeeder first.');

            return;
        }

        // 1) match movies on TMDB: local movie id => ['tmdb' => id, 'vote' => avg]
        $matches = [];
        foreach ($movies->chunk(self::BATCH) as $chunk) {
            $reqs = [];
            foreach ($chunk as $m) {
                $reqs[$m->id] = ['search/movie', array_filter([
                    'query' => $m->title,
                    'year' => $m->release_year,
                ])];
            }

            foreach ($this->tmdbMany($reqs) as $movieId => $res) {
                if ($hit = $res['results'][0] ?? null) {
                    $matches[(int) $movieId] = ['tmdb' => $hit['id'], 'vote' => (float) ($hit['vote_average'] ?? 6)];
                }
            }
        }

        $this->command?->info(count($matches).' of '.$movies->count().' movies matched on TMDB');

        // 2) reviews + 3) write
        $hash = Hash::make('password'); // hash once, not once per user
        $users = [];                    // email => id
        $total = 0;

        foreach (array_chunk(array_keys($matches), self::BATCH) as $chunk) {
            $reqs = [];
            foreach ($chunk as $movieId) {
                $reqs[$movieId] = ["movie/{$matches[$movieId]['tmdb']}/reviews", []];
            }

            foreach ($this->tmdbMany($reqs) as $movieId => $res) {
                $movieId = (int) $movieId;
                $rows = [];

                foreach (array_slice($res['results'] ?? [], 0, self::MAX_PER_MOVIE) as $r) {
                    $author = $r['author_details']['username'] ?? $r['author'] ?? 'anonymous';
                    $email = (Str::limit(Str::slug($author), 60, '') ?: md5($author)).'@tmdb.test';

                    $userId = $users[$email] ??= User::firstOrCreate(
                        ['email' => $email],
                        ['name' => Str::limit($r['author'] ?: $author, 100, ''), 'password' => $hash]
                    )->id;

                    // TMDB: 0-10 and nullable. Table: 1-5, NOT NULL.
                    $raw = $r['author_details']['rating'] ?? $matches[$movieId]['vote'];
                    $at = Carbon::parse($r['created_at'] ?? now());

                    $rows[$userId] = [ // keyed by user: one review per user per movie
                        'user_id' => $userId,
                        'movie_id' => $movieId,
                        'rating' => max(1, min(5, (int) round($raw / 2))),
                        'comment' => $r['content'],
                        'created_at' => $at,
                        'updated_at' => $at,
                    ];
                }

                if ($rows) {
                    Review::upsert(array_values($rows), ['user_id', 'movie_id'], ['rating', 'comment', 'updated_at']);
                    $total += count($rows);
                }
            }
        }

        $this->command?->info("Seeded {$total} reviews from ".count($users).' TMDB authors.');
    }
}