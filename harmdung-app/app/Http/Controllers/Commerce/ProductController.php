<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // หน้าเลือกแพลตฟอร์ม
    public function index()
    {
        $platforms = Platform::withCount('products')->get();

        return view('products', compact('platforms'));
    }

    // หน้าแพ็กเกจของแพลตฟอร์ม (รับ ?platform=id หรือชื่อ)
    public function show(Request $request)
    {
        $platform = Platform::where('id', $request->platform)
            ->orWhere('name', $request->platform)
            ->firstOrFail();

        $products = $platform->products()->orderBy('price')->get();

        return view('product-info', compact('platform', 'products'));
    }
}