<?php

namespace App\Services;

use App\Models\Platform;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;


class ProductService
{
    /**
     * สินค้าทั้งหมดของแพลตฟอร์ม เรียงตามระยะเวลา (สั้น -> ยาว)
     * รวมสินค้าที่ stock = 0 ด้วย เพื่อให้ UI แสดงป้าย "หมด" และปิดปุ่มเพิ่มตะกร้า
     */
    public static function forPlatform(int $platformId): Collection
    {
        return Product::query()
            ->with('platform')
            ->where('platform_id', $platformId)
            ->orderBy('duration_days')
            ->orderBy('price')
            ->get();
    }

    /** ใช้ใน controller: ได้ทั้งแพลตฟอร์มและสินค้าในครั้งเดียว (404 ถ้าไม่มีแพลตฟอร์ม) */
    public static function platformWithProducts(int $platformId): array
    {
        $platform = Platform::findOrFail($platformId);

        return [
            'platform' => $platform,
            'products' => self::forPlatform($platformId),
        ];
    }

    /** เช็กก่อนใส่ตะกร้า: stock พอสำหรับจำนวนที่ขอหรือไม่ */
    public static function hasStock(Product $product, int $quantity = 1): bool
    {
        return $product->stock >= $quantity;
    }
}