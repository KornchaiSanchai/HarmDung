<?php

namespace Database\Seeders;

use App\Models\Genre;
use Database\Seeders\Concerns\TmdbClient;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    use TmdbClient;

    public function run(): void
    {
        if (! $this->tmdbReady()) {
            return;
        }

        foreach ($this->tmdb('genre/movie/list')['genres'] ?? [] as $g) {
            Genre::firstOrCreate(['name' => $g['name']]);
        }
    }
}