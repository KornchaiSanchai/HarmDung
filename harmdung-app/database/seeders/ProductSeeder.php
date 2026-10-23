<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = Platform::orderBy('id')->get();

        if ($platforms->isEmpty()) {
            $this->command?->warn('ไม่พบ platforms: ต้องรัน PlatformSeeder ก่อน ProductSeeder');
            return;
        }

        // [ชื่อแพ็กเกจ, จำนวนวัน, ราคา, stock] 
        $plans = [
            ['1 Day',  1,  15,  20],
            ['7 Day',  7,  25,  20],
            ['30 Day', 30, 75,  15],
            ['60 Day', 60, 140, 10],
        ];

        $now = now();
        $rows = [];

        foreach ($platforms as $platform) {
            foreach ($plans as [$planName, $days, $price, $stock]) {
                $rows[] = [
                    'platform_id'   => $platform->id,
                    'plan_name'     => $planName,
                    'duration_days' => $days,
                    'price'         => $price,
                    'stock'         => $stock,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ];
            }
        }

        // สินค้าสต็อก 0 ไว้สาธิต "สต็อกหมด"
        $rows[] = [
            'platform_id'   => $platforms->first()->id,
            'plan_name'     => '30 Day (หมดสต็อก)',
            'duration_days' => 30,
            'price'         => 75,
            'stock'         => 0,
            'created_at'    => $now,
            'updated_at'    => $now,
        ];

        DB::table('products')->insert($rows);
    }
}