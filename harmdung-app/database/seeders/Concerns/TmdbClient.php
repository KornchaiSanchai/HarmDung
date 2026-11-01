<?php

namespace Database\Seeders\Concerns;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait TmdbClient
{
    protected const TMDB_API = 'https://api.themoviedb.org/3/';
    protected const TMDB_IMG = 'https://image.tmdb.org/t/p/';
    protected const REGION = 'TH'; // streaming availability region

    protected function tmdbReady(): bool
    {
        if (config('services.tmdb.token')) {
            return true;
        }

        $this->command?->warn('TMDB_TOKEN not set, skipping '.static::class);

        return false;
    }

    protected function tmdb(string $path, array $query = []): array
    {
        return Http::withToken(config('services.tmdb.token'))
            ->timeout(15)
            ->retry(2, 300)
            ->get(self::TMDB_API.$path, $query)
            ->throw()
            ->json() ?? [];
    }

    /**
     * Run many requests concurrently.
     *
     * @param  array<string|int, array{0: string, 1: array}>  $requests  key => [path, query]
     * @return array<string|int, array>  key => decoded json (failed keys are omitted)
     */
    protected function tmdbMany(array $requests, int $attempts = 2): array
    {
        $out = [];
        $pending = $requests;

        for ($i = 0; $i < $attempts && $pending; $i++) {
            $responses = Http::pool(function (Pool $pool) use ($pending) {
                foreach ($pending as $key => [$path, $query]) {
                    $pool->as((string) $key)
                        ->withToken(config('services.tmdb.token'))
                        ->timeout(15)
                        ->get(self::TMDB_API.$path, $query);
                }
            });

            foreach ($responses as $key => $res) {
                if ($res instanceof Response && $res->successful()) {
                    $out[$key] = $res->json() ?? [];
                    unset($pending[$key]);
                }
            }
        }

        if ($pending) {
            $this->command?->warn(count($pending).' TMDB request(s) failed: '.implode(', ', array_keys($pending)));
        }

        return $out;
    }
}