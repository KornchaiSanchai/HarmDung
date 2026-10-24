<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $platforms = Platform::withCount('products')->get();

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

    return view('product-info', compact('platform', 'platforms', 'products'));
}
}