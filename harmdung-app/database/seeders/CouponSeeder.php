<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Platform;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $all = Product::pluck('id');

        if ($all->isEmpty()) {
            $this->command?->warn('ยังไม่มีสินค้า: สร้างคูปองโดยยังไม่ผูกสินค้า (รัน seeder นี้ซ้ำหลังมีสินค้าแล้ว)');
        }

        $coupons = [
            // ใช้ได้กับทุกสินค้า แบ่งตามยอดขั้นต่ำ
            ['code' => 'SAVE5',      'discount_percent' => 5,  'min_spend' => 0,    'expiry_date' => now()->addMonths(6), 'usage_limit' => 500, 'used_count' => 0, 'products' => fn () => $all],
            ['code' => 'SPEND300',   'discount_percent' => 10, 'min_spend' => 300,  'expiry_date' => now()->addMonths(6), 'usage_limit' => 200, 'used_count' => 0, 'products' => fn () => $all],
            ['code' => 'SPEND1000',  'discount_percent' => 20, 'min_spend' => 1000, 'expiry_date' => now()->addMonths(3), 'usage_limit' => 50,  'used_count' => 0, 'products' => fn () => $all],

            // ใช้ได้เฉพาะบางสินค้า
            ['code' => 'NETFLIX15',  'discount_percent' => 15, 'min_spend' => 200,  'expiry_date' => now()->addMonths(3), 'usage_limit' => 50,  'used_count' => 0, 'products' => fn () => $this->productsOfPlatform('Netflix')],
            ['code' => 'LONGPLAN25', 'discount_percent' => 25, 'min_spend' => 500,  'expiry_date' => now()->addMonths(4), 'usage_limit' => 20,  'used_count' => 0, 'products' => fn () => Product::where('duration_days', '>=', 90)->pluck('id')],

            // ใช้ทดสอบตอน demo
            ['code' => 'EXPIRED30',  'discount_percent' => 30, 'min_spend' => 0,    'expiry_date' => now()->subDay(),     'usage_limit' => 10,  'used_count' => 0, 'products' => fn () => $all],      // หมดอายุแล้ว
            ['code' => 'SOLDOUT20',  'discount_percent' => 20, 'min_spend' => 0,    'expiry_date' => now()->addMonth(),   'usage_limit' => 3,   'used_count' => 3, 'products' => fn () => $all],      // ใช้ครบแล้ว
            ['code' => 'NOPRODUCT5', 'discount_percent' => 5,  'min_spend' => 0,    'expiry_date' => now()->addMonth(),   'usage_limit' => 10,  'used_count' => 0, 'products' => fn () => collect()], // ไม่มีสินค้าร่วมรายการ
        ];

        foreach ($coupons as $row) {
            $products = $row['products'];
            unset($row['products']);
            $row['expiry_date'] = $row['expiry_date']->toDateString();

            $coupon = Coupon::updateOrCreate(['code' => $row['code']], $row);
            $coupon->products()->sync($products());
        }

        $this->command?->info('สร้างคูปองแล้ว '.count($coupons).' รายการ');
    }

    private function productsOfPlatform(string $name): Collection
    {
        $platformIds = Platform::where('name', 'like', "%{$name}%")->pluck('id');

        return Product::whereIn('platform_id', $platformIds)->pluck('id');
    }
}