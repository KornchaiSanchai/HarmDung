<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * ลำดับต้องเรียงตาม FK: ตารางแม่ก่อนตารางลูก
     * seeder ของแต่ละโมดูลถูกเรียกก็ต่อเมื่อไฟล์นั้นมีอยู่แล้ว
     * (migrate:fresh --seed จะได้ไม่พังระหว่างที่เพื่อนยังเขียนไม่เสร็จ)
     */
    public function run(): void
    {

        $order = [
            UserSeeder::class,       // วุ้น
            PlatformSeeder::class,   // มะปิน
            GenreSeeder::class,      // มะปิน
            MovieSeeder::class,      // มะปิน (รวม movie_platform, movie_genre)
            ProductSeeder::class,    // อิ้ง
            AccountStockSeeder::class, // อิ้ง
            CouponSeeder::class,     // กร (รวม coupon_product)
            ReviewSeeder::class,     // กร (optional)
        ];

        
        foreach ($order as $seeder) {
            if (class_exists($seeder)) {
                $this->call($seeder);
            }
        }

        $this->call([
            CouponSeeder::class,
        ]);
    }
}
