<?php

namespace Database\Seeders;

use App\Models\Platform;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = Platform::orderBy('id')->get();

        if ($platforms->isEmpty()) {
            $this->command?->warn('ไม่พบ platforms: ต้องรัน PlatformSeeder ก่อน ProductSeeder');
            return;
        }

        // [ชื่อแพ็กเกจ, จำนวนวัน, ราคา] 
        $plans = [
            ['1 Day',  1,  15],
            ['7 Day',  7,  25],
            ['30 Day', 30, 75],
            ['60 Day', 60, 140],
        ];

        foreach ($platforms as $platform) {
            foreach ($plans as [$planName, $days, $price]) {
                Product::updateOrCreate(
                    [
                        'platform_id' => $platform->id,
                        'plan_name'   => $planName,
                    ],
                    [
                        'duration_days' => $days,
                        'price'         => $price,
                        'stock'         => 0, // เดี๋ยว AccountStockSeeder จะมาอัปเดตตัวเลขจริงให้
                    ]
                );
            }
        }
    }
}