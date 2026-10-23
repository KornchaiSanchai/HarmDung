<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Platform;
use Database\Seeders\Concerns\TmdbClient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeds popular movies that stream (flatrate) on our platforms, with
 * movie_genre and movie_platform.
 *
 * 1. discover/movie once per platform (concurrent) -> we know exactly which
 *    platform each movie is on, so movie_platform does not depend on
 *    per-movie provider details.
 * 2. take the most popular TARGET movies overall
 * 3. fetch their details (runtime, genres) concurrently in batches
 */
class MovieSeeder extends Seeder
{
    use TmdbClient;

    private const TARGET = 50;             // movies to seed
    private const FEATURED = 6;
    private const PAGES_PER_PLATFORM = 2;  // 20 results per page
    private const BATCH = 10;              // concurrent detail requests

    public function run(): void
    {
        if (! $this->tmdbReady()) {
            return;
        }

        $platforms = Platform::pluck('id', 'name'); // name => local id
        if ($platforms->isEmpty()) {
            $this->command?->warn('No platforms found, run PlatformSeeder first.');

            return;
        }

        // TMDB provider id => local platform id
        $providers = collect($this->tmdb('watch/providers/movie', ['watch_region' => self::REGION])['results'] ?? [])
            ->filter(fn ($p) => $platforms->has($p['provider_name']))
            ->mapWithKeys(fn ($p) => [$p['provider_id'] => $platforms[$p['provider_name']]]);

        if ($providers->isEmpty()) {
            $this->command?->warn('No TMDB provider ids matched platform names: '.$platforms->keys()->implode(', '));

            return;
        }

        // 1) one concurrent batch of discover calls
        $requests = [];
        foreach ($providers as $providerId => $platformId) {
            for ($page = 1; $page <= self::PAGES_PER_PLATFORM; $page++) {
                $requests["{$platformId}:{$page}"] = ['discover/movie', [
                    'watch_region' => self::REGION,
                    'with_watch_providers' => $providerId,
                    'with_watch_monetization_types' => 'flatrate',
                    'sort_by' => 'popularity.desc',
                    'page' => $page,
                ]];
            }
        }

        $found = []; // tmdb movie id => ['popularity' => x, 'platforms' => [localId => true]]
        foreach ($this->tmdbMany($requests) as $key => $res) {
            $platformId = (int) explode(':', (string) $key)[0];
            foreach ($res['results'] ?? [] as $m) {
                $found[$m['id']]['popularity'] = $m['popularity'] ?? 0;
                $found[$m['id']]['platforms'][$platformId] = true;
            }
        }

        // 2) most popular overall
        uasort($found, fn ($a, $b) => $b['popularity'] <=> $a['popularity']);
        $top = array_slice($found, 0, self::TARGET, true);
        $rank = array_flip(array_keys($top));

        $this->command?->info(count($found).' candidates, seeding '.count($top));

        // 3) details in concurrent batches
        $count = 0;
        foreach (array_chunk(array_keys($top), self::BATCH) as $chunk) {
            $reqs = [];
            foreach ($chunk as $id) {
                $reqs[$id] = ["movie/{$id}", ['append_to_response' => 'watch/providers']];
            }

            foreach ($this->tmdbMany($reqs) as $id => $d) {
                $id = (int) $id;
                if (empty($d['title'])) {
                    continue;
                }

                // platforms from discover, plus any extra from the movie's own provider list
                $platformIds = collect(array_keys($top[$id]['platforms']))
                    ->merge(
                        collect($d['watch/providers']['results'][self::REGION]['flatrate'] ?? [])
                            ->pluck('provider_name')
                            ->map(fn ($n) => $platforms[$n] ?? null)
                    )
                    ->filter()->unique()->values()->all();

                $this->store($d, $platformIds, $rank[$id] < self::FEATURED);
                $count++;
            }
        }

        $this->command?->info("Seeded {$count} movies, ".DB::table('movie_platform')->count().' movie_platform rows.');
    }

    private function store(array $d, array $platformIds, bool $featured): void
    {
        DB::transaction(function () use ($d, $platformIds, $featured) {
            $year = ! empty($d['release_date']) ? (int) substr($d['release_date'], 0, 4) : null;

            $movie = Movie::updateOrCreate(
                ['title' => $d['title'], 'release_year' => $year],
                [
                    'synopsis' => $d['overview'] ?: null,
                    'duration_min' => $d['runtime'] ?: null,
                    'poster_url' => $d['poster_path'] ? self::TMDB_IMG.'w500'.$d['poster_path'] : null,
                    'is_featured' => $featured,
                ]
            );

            $movie->genres()->sync(
                collect($d['genres'] ?? [])->map(fn ($g) => Genre::firstOrCreate(['name' => $g['name']])->id)->all()
            );
            $movie->platforms()->sync($platformIds);
        });
    }
}