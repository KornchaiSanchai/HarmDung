<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * วางที่ database/seeders/ProductSeeder.php
 *
 * ต้องรันหลัง PlatformSeeder (DatabaseSeeder ของวุ้นเรียกตามลำดับให้)
 * ไม่ผูกกับชื่อแพลตฟอร์ม: วนทุกแพลตฟอร์มที่มีในตาราง จึงไม่พังถ้ามะปินเปลี่ยนชื่อ
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = Platform::orderBy('id')->get();

        if ($platforms->isEmpty()) {
            $this->command?->warn('ไม่พบ platforms: ต้องรัน PlatformSeeder ก่อน ProductSeeder');
            return;
        }

        // [ชื่อแพ็กเกจ, จำนวนวัน, ตัวคูณราคา, stock]
        $plans = [
            ['Package 7 day',  7,  1.0, 20],
            ['Package 14 day',  14,  2.7, 15],
            ['Package 30 days', 30, 9.5, 8],
        ];

        $now = now();
        $rows = [];

        foreach ($platforms as $i => $platform) {
            // ราคาฐานต่อเดือน เพิ่มตามลำดับแพลตฟอร์ม (99, 119, 139, ...)
            $basePrice = 99 + ($i * 20);

            foreach ($plans as [$planName, $days, $multiplier, $stock]) {
                $rows[] = [
                    'platform_id'   => $platform->id,
                    'plan_name'     => $planName,
                    'duration_days' => $days,
                    'price'         => round($basePrice * $multiplier, 2),
                    'stock'         => $stock,
                    'created_at'    => $now,
                ];
            }
        }

        // สินค้าสต็อก 0 ไว้สาธิต "สต็อกหมด" / rollback ตอน demo
        $rows[] = [
            'platform_id'   => $platforms->first()->id,
            'plan_name'     => 'Trial 7 วัน (หมดสต็อก)',
            'duration_days' => 7,
            'price'         => 29,
            'stock'         => 0,
            'created_at'    => $now,
        ];

        DB::table('products')->insert($rows);
    }
}