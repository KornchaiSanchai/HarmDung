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

    /**
     * ดึงรายการคูปองสำหรับหน้า Checkout (จาก Database หรือ Fallback ตาม Seeder)
     */
    public static function getCheckoutCoupons(): array
    {
        try {
            if (Coupon::exists()) {
                return Coupon::all()->map(function (Coupon $coupon) {
                    $isExpired = $coupon->expiry_date ? $coupon->expiry_date->endOfDay()->isPast() : false;
                    $isExhausted = (int) $coupon->used_count >= (int) $coupon->usage_limit;

                    $minSpend = (float) ($coupon->min_spend ?? 0);
                    $desc = ($minSpend > 0)
                        ? 'ยอดสั่งซื้อขั้นต่ำ ' . number_format($minSpend) . ' บาท'
                        : 'ไม่มีขั้นต่ำ';

                    if ($isExpired) {
                        $desc .= ' (หมดอายุแล้ว)';
                    } elseif ($isExhausted) {
                        $desc .= ' (สิทธิ์เต็มแล้ว)';
                    }

                    return [
                        'code' => $coupon->code,
                        'name' => 'ส่วนลด ' . rtrim(rtrim(number_format((float) $coupon->discount_percent, 2, '.', ''), '0'), '.') . '%',
                        'type' => 'percent',
                        'value' => (float) $coupon->discount_percent,
                        'min_spend' => $minSpend,
                        'desc' => $desc,
                        'is_expired' => $isExpired,
                        'is_exhausted' => $isExhausted,
                    ];
                })->toArray();
            }
        } catch (\Throwable $e) {
            // กรณี query DB ไม่ได้ ให้ใช้ default จาก seeder
        }

        return self::defaultCheckoutCoupons();
    }

    /**
     * ข้อมูลคูปองเริ่มต้นตามที่กำหนดใน CouponSeeder
     */
    public static function defaultCheckoutCoupons(): array
    {
        return [
            [
                'code' => 'SAVE5',
                'name' => 'ส่วนลด 5%',
                'type' => 'percent',
                'value' => 5,
                'min_spend' => 0,
                'desc' => 'ไม่มีขั้นต่ำ (ลด 5% ทุกคำสั่งซื้อ)',
                'is_expired' => false,
                'is_exhausted' => false,
            ],
            [
                'code' => 'SPEND300',
                'name' => 'ส่วนลด 10%',
                'type' => 'percent',
                'value' => 10,
                'min_spend' => 300,
                'desc' => 'ยอดสั่งซื้อขั้นต่ำ 300 บาท',
                'is_expired' => false,
                'is_exhausted' => false,
            ],
            [
                'code' => 'SPEND1000',
                'name' => 'ส่วนลด 20%',
                'type' => 'percent',
                'value' => 20,
                'min_spend' => 1000,
                'desc' => 'ยอดสั่งซื้อขั้นต่ำ 1,000 บาท',
                'is_expired' => false,
                'is_exhausted' => false,
            ],
            [
                'code' => 'NETFLIX15',
                'name' => 'ส่วนลด 15%',
                'type' => 'percent',
                'value' => 15,
                'min_spend' => 200,
                'desc' => 'ยอดสั่งซื้อขั้นต่ำ 200 บาท (เฉพาะ Netflix)',
                'is_expired' => false,
                'is_exhausted' => false,
            ],
            [
                'code' => 'LONGPLAN25',
                'name' => 'ส่วนลด 25%',
                'type' => 'percent',
                'value' => 25,
                'min_spend' => 500,
                'desc' => 'ยอดสั่งซื้อขั้นต่ำ 500 บาท (แพ็กเกจ 90 วันขึ้นไป)',
                'is_expired' => false,
                'is_exhausted' => false,
            ],
            [
                'code' => 'EXPIRED30',
                'name' => 'ส่วนลด 30%',
                'type' => 'percent',
                'value' => 30,
                'min_spend' => 0,
                'desc' => 'ไม่มีขั้นต่ำ (หมดอายุแล้ว)',
                'is_expired' => true,
                'is_exhausted' => false,
            ],
            [
                'code' => 'SOLDOUT20',
                'name' => 'ส่วนลด 20%',
                'type' => 'percent',
                'value' => 20,
                'min_spend' => 0,
                'desc' => 'ไม่มีขั้นต่ำ (สิทธิ์เต็มแล้ว)',
                'is_expired' => false,
                'is_exhausted' => true,
            ],
            [
                'code' => 'NOPRODUCT5',
                'name' => 'ส่วนลด 5%',
                'type' => 'percent',
                'value' => 5,
                'min_spend' => 0,
                'desc' => 'ไม่มีขั้นต่ำ (ไม่มีสินค้าร่วมรายการ)',
                'is_expired' => false,
                'is_exhausted' => false,
            ],
        ];
    }
}