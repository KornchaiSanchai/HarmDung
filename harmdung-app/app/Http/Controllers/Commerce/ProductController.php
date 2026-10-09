<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Services\ProductService;

/**
 * วางที่ app/Http/Controllers/Commerce/ProductController.php
 *
 * Data contract ของหน้า commerce.products.index (ส่งให้หมวย):
 *   $platform  Platform  แพลตฟอร์มที่เลือก (name, logo_url, ...)
 *   $products  Collection<Product>  plan_name, duration_days, price, stock
 *              stock = 0 ให้แสดงป้าย "หมด" และปิดปุ่มเพิ่มตะกร้า
 */
class ProductController extends Controller
{
    public function byPlatform(int $platform)
    {
        // findOrFail ข้างใน -> 404 ถ้าไม่มีแพลตฟอร์ม
        $data = ProductService::platformWithProducts($platform);

        return view('commerce.products.index', $data);
    }
}