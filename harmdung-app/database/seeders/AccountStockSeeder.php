<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\AccountStock;

class AccountStockSeeder extends Seeder
{
    public function run(): void
    {
        // ชุดข้อมูลอีเมลจำลองแยกตามแอปและแพ็กเกจ
        $stocksData = [
            [
                'app_name' => 'Netfux',// 
                'packages' => [
                    1  => ['netflix_1d_01@example.com'],
                    7  => ['netflix_7d_01@example.com', 'netflix_7d_02@example.com'],
                    30 => ['netflix_30d_01@example.com', 'netflix_30d_02@example.com'],
                    60 => ['netflix_60d_01@example.com'],
                ]
            ],
            [
                'app_name' => 'Hiv min', 
                'packages' => [
                    1  => ['hbo_1d_01@example.com'],
                    7  => ['hbo_7d_01@example.com'],
                    30 => ['hbo_30d_01@example.com', 'hbo_30d_02@example.com'],
                    60 => ['hbo_60d_01@example.com', 'hbo_60d_02@example.com'],
                ]
            ],
            [
                'app_name' => 'Prime hindu video', 
                'packages' => [
                    1  => ['prime_1d_01@example.com'],
                    7  => ['prime_7d_01@example.com', 'prime_7d_02@example.com'],
                    30 => ['prime_30d_01@example.com', 'prime_30d_02@example.com'],
                    60 => ['prime_60d_01@example.com', 'prime_60d_02@example.com'],
                ]
            ],
            [
                'app_name' => 'Thisney-', 
                'packages' => [
                    1  => ['disney_1d_01@example.com'],
                    7  => ['disney_7d_01@example.com', 'disney_7d_02@example.com'],
                    30 => ['disney_30d_01@example.com', 'disney_30d_02@example.com'],
                    60 => ['disney_60d_01@example.com', 'disney_60d_02@example.com'],
                ]
            ],
        ];

        foreach ($stocksData as $item) {
            foreach ($item['packages'] as $days => $emails) {
                // ค้นหา Product ที่เชื่อมโยงกับแพลตฟอร์มและตรงกับจำนวนวัน
                $products = Product::whereHas('platform', function ($query) use ($item) {
                        $query->where('name', 'like', '%' . $item['app_name'] . '%');
                    })
                    ->where('duration_days', $days)
                    ->where('stock', '>', 0)
                    ->get();

                foreach ($products as $product) {
                    foreach ($emails as $email) {
                        AccountStock::firstOrCreate([
                            'product_id' => $product->id,
                            'email' => $email,
                        ], [
                            'password' => 'secret1234', // รหัสผ่านจำลอง
                            'status' => 'available',    // สถานะพร้อมขาย
                        ]);
                    }
                }
            }
        }
    }
}