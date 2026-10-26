<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการสั่งซื้อ - HD Harmdung</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#171717] text-white font-sans antialiased min-h-screen pb-16">

    <x-navbar active="orders"></x-navbar>

    <main class="max-w-[900px] mx-auto px-6 mt-10">
        <h1 class="text-2xl font-bold mb-8">ประวัติการสั่งซื้อ</h1>

        @if (session('success'))
            <div class="mb-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-sm px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-5">
            @forelse ($orders as $order)
                <div class="bg-white text-black rounded-[24px] p-6 shadow-xl">
                    <div class="flex items-center justify-between border-b border-gray-200 pb-3 mb-3">
                        <div>
                            <div class="font-extrabold">คำสั่งซื้อ #{{ $order->id }}</div>
                            <div class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full">
                            {{ $order->status === 'paid' ? 'ชำระแล้ว' : $order->status }}
                        </span>
                    </div>

                    @foreach ($order->products as $product)
                        <div class="flex items-center justify-between py-2 text-sm">
                            <div>
                                <span class="font-bold">{{ $product->platform->name ?? '-' }}</span>
                                <span class="text-gray-500">· {{ $product->plan_name }}</span>
                            </div>
                            <div class="text-gray-600">
                                {{ $product->pivot->quantity }} × {{ number_format($product->pivot->unit_price, 2) }}
                                = <span class="font-bold text-black">{{ number_format($product->pivot->quantity * $product->pivot->unit_price, 2) }} บาท</span>
                            </div>
                        </div>
                    @endforeach

                    <div class="border-t border-gray-200 mt-3 pt-3 text-sm text-right space-y-1">
                        <div class="text-gray-500">ส่วนลด: -{{ number_format($order->discount_amount, 2) }} บาท</div>
                        <div class="text-lg font-extrabold">รวม {{ number_format($order->total, 2) }} บาท</div>
                    </div>
                </div>
            @empty
                <div class="bg-gray-900/50 rounded-[24px] p-12 text-center border border-gray-800">
                    <p class="text-gray-400 text-sm">ยังไม่มีประวัติการสั่งซื้อ</p>
                    <a href="{{ route('products') }}" class="inline-block mt-4 bg-[#00fff2] text-black font-bold px-6 py-2 rounded-full text-xs">เลือกซื้อสินค้า</a>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>