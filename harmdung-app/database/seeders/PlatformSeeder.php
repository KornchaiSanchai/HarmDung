<?php

namespace Database\Seeders;

<<<<<<< Updated upstream
use App\Models\Platform;
use Database\Seeders\Concerns\TmdbClient;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    use TmdbClient;

    private const LIMIT = 8; // top N providers in the region

    public function run(): void
    {
        if (! $this->tmdbReady()) {
            return;
        }

        $providers = $this->tmdb('watch/providers/movie', ['watch_region' => self::REGION])['results'] ?? [];

        $top = collect($providers)
            // drop ad-tier / channel variants so each service appears once
            ->reject(fn ($p) => preg_match('/ads|channel/i', $p['provider_name']))
            ->sortBy(fn ($p) => $p['display_priorities'][self::REGION] ?? 999)
            ->take(self::LIMIT);

        foreach ($top as $p) {
            Platform::firstOrCreate(
                ['name' => $p['provider_name']],
                ['logo_url' => $p['logo_path'] ? self::TMDB_IMG.'w92'.$p['logo_path'] : null]
            );
=======
use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            ['name' => 'Netfux'],
            ['name' => 'Hiv min'],
            ['name' => 'Prime hindu video'],
            ['name' => 'Thisney-'],
        ];

        foreach ($platforms as $platform) {
            Platform::firstOrCreate($platform);
>>>>>>> Stashed changes
        }
    }
}