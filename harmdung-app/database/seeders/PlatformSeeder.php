<?php

namespace Database\Seeders;

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
        }
    }
}