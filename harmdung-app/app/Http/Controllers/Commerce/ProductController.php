<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $platformMeta = [
            1 => ['key' => 'netflux', 'image' => '/images/netflux.png', 'bg_class' => 'bg-gradient-to-r from-[#3e0808] to-[#1a0202]'],
            2 => ['key' => 'hiv', 'image' => '/images/hiv.png', 'bg_class' => 'bg-gradient-to-r from-[#5a1bb9] to-[#204ce4]'],
            3 => ['key' => 'hindu', 'image' => '/images/hindu.png', 'bg_class' => 'bg-gradient-to-r from-[#0d213b] to-[#123e6f]'],
            4 => ['key' => 'thisney', 'image' => '/images/thisney.png', 'bg_class' => 'bg-gradient-to-r from-[#0b1b3d] to-[#043360]'],
        ];

        $platforms = Platform::withCount('products')->get()->map(function ($platform) use ($platformMeta) {
            $meta = $platformMeta[$platform->id] ?? [
                'key' => (string) $platform->id,
                'image' => $platform->logo_url ?? '/images/thisney.png',
                'bg_class' => 'bg-gradient-to-r from-gray-800 to-gray-900',
            ];

            $platform->slug_key = $meta['key'];
            $platform->image_url = $meta['image'];
            $platform->bg_class = $meta['bg_class'];
            $platform->items_count_label = 'มีสินค้า ' . $platform->products_count . ' รายการ';

            return $platform;
        });

        return view('products', compact('platforms'));
    }

    public function show(Request $request)
    {
        $platforms = Platform::all();

        // รองรับ key เก่าจาก mockup ของหมวย
        $aliases = [
            'netflux' => 1,
            'hiv'     => 2,
            'hindu'   => 3,
            'thisney' => 4,
        ];

        $key = $request->input('platform');
        $id  = $aliases[$key] ?? $key;

        $platform = $platforms->firstWhere('id', (int) $id)
            ?? $platforms->first(fn ($p) => strcasecmp($p->name, (string) $key) === 0);

        if (! $platform) {
            return redirect()->route('products');
        }

        $products = $platform->products()
            ->withCount(['accountStocks as available_stock' => fn ($q) => $q->where('status', 'available')])
            ->orderBy('price')
            ->get();

        // คำนวณสถานะสต็อกและราคาจาก Backend Controller ทั้งหมด
        $products->each(function ($p) {
            $p->is_in_stock = $p->available_stock > 0;
            $p->formatted_price = number_format($p->price, 0);
            $p->stock_label = $p->available_stock > 0
                ? 'คงเหลือ ' . $p->available_stock . ' ชิ้น'
                : 'สินค้าหมด';
        });

        return view('product-info', compact('platform', 'platforms', 'products'));
    }
}