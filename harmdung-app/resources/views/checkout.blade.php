<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ชำระเงิน - HD Harmdung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#121212] text-white font-sans antialiased min-h-screen pb-12 flex flex-col justify-between">

    <div>
        <!-- Navbar -->
        <header>
            <nav class="flex items-center justify-between px-8 py-4 border-b border-gray-800/80 bg-[#121212]/80 backdrop-blur-md sticky top-0 z-50">
                <div class="flex items-center gap-8">
                    <a href="/home" class="flex items-center shrink-0 group">
                        <img src="/images/logo.png" alt="HD Harmdung" class="h-10 w-auto object-contain scale-125 origin-left transition-transform group-hover:scale-130">
                    </a>
                    <div class="flex items-center gap-2">
                        <a href="/home" class="flex items-center gap-2 px-5 py-2 text-sm text-gray-300 hover:text-white transition rounded-full hover:bg-gray-800/50">
                            หน้าแรก
                        </a>
                        <a href="/products" class="flex items-center gap-2 px-5 py-2 text-sm text-gray-300 hover:text-white transition rounded-full hover:bg-gray-800/50">
                            สินค้าทั้งหมด
                        </a>
                        <a href="/cart" class="flex items-center gap-2 px-5 py-2 text-sm text-gray-300 hover:text-white transition rounded-full hover:bg-gray-800/50">
                            ตะกร้า
                        </a>
                    </div>
                </div>

                <!-- Profile & Balance -->
                <div class="flex items-center gap-4">
                    <div class="bg-gray-800/90 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2 border border-gray-700/80 shadow">
                        <span class="w-5 h-5 bg-gradient-to-tr from-yellow-500 to-amber-300 rounded-full flex items-center justify-center text-black font-extrabold text-xs">฿</span>
                        <span class="font-bold text-gray-100">{{ number_format(auth()->user()->balance ?? 100.00, 2) }}</span>
                    </div>
                    <a href="/profile" class="w-10 h-10 bg-[#00fff2] rounded-full flex items-center justify-center text-black font-bold shadow-md hover:scale-105 transition" title="ข้อมูลสมาชิก">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </a>
                </div>
            </nav>
        </header>

        <!-- Checkout Main Content -->
        <main class="max-w-[900px] mx-auto px-6 mt-10 bg-gray-900/80 p-8 rounded-[24px] border border-gray-800 shadow-2xl">
            <h1 class="text-3xl font-extrabold text-center mb-8 text-white">ชำระเงิน</h1>

            @if (session('error'))
                <div class="mb-6 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-sm px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            <!-- หัวตาราง -->
            <div class="grid grid-cols-12 text-gray-400 font-semibold text-sm pb-4 border-b border-gray-800">
                <div class="col-span-6">สินค้าที่สั่งซื้อ</div>
                <div class="col-span-2 text-center">ราคาต่อหน่วย</div>
                <div class="col-span-2 text-center">จำนวน</div>
                <div class="col-span-2 text-right">รายการย่อย</div>
            </div>

            <!-- รายการสินค้าจาก Backend -->
            <div class="divide-y divide-gray-800 mb-6">
                @forelse($cartItems as $item)
                    <div class="grid grid-cols-12 items-center py-4 gap-4">
                        <div class="col-span-6 flex items-center gap-4">
                            <div class="w-20 aspect-video rounded-xl overflow-hidden shadow bg-gradient-to-r from-[#0b1b3d] to-[#043360] flex items-center justify-center text-white font-bold text-xs shrink-0">
                                {{ $item->platform->name ?? 'Harmdung' }}
                            </div>
                            <div>
                                <h3 class="font-bold text-base text-white">{{ $item->plan_name }}</h3>
                            </div>
                        </div>
                        <div class="col-span-2 text-center text-gray-300 text-sm">{{ number_format($item->price, 2) }} บาท</div>
                        <div class="col-span-2 text-center text-gray-300 text-sm font-semibold">{{ $item->pivot->quantity }}</div>
                        <div class="col-span-2 text-right text-[#00fff2] font-bold text-sm">
                            {{ number_format($item->price * $item->pivot->quantity, 2) }} บาท
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-500">
                        <p class="text-base font-semibold">ไม่มีรายการสินค้าที่เลือกชำระเงิน</p>
                        <a href="{{ route('cart.index') }}" class="inline-block mt-3 text-sm font-bold text-[#00fff2] hover:underline">← กลับไปที่ตะกร้าสินค้า</a>
                    </div>
                @endforelse
            </div>

            <!-- ส่วนกรอกคูปองส่วนลด -->
            <!-- ส่วนลดคำสั่งซื้อ (คูปอง) แบบเลือก Dropdown หรือพิมพ์เอง -->
<div class="bg-[#202020] p-5 rounded-2xl border border-gray-800 space-y-4">
    <div class="flex items-center gap-2 text-cyan-300 font-bold text-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
        <span>ส่วนลดคำสั่งซื้อ (คูปอง)</span>
    </div>

    <form action="{{ route('checkout.index') }}" method="GET" class="space-y-3">
        <!-- 1. แบบเลือกจาก Dropdown -->
        <div class="flex gap-2">
            <select name="selected_coupon" class="w-full bg-[#171717] border border-gray-700 text-white text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#00fff2]" onchange="this.form.submit()">
                <option value="">-- เลือกคูปองส่วนลดที่มี --</option>
                @isset($availableCoupons)
                    @foreach($availableCoupons as $c)
                        <option value="{{ $c->code }}" {{ ($couponCode ?? '') == $c->code ? 'selected' : '' }}>
                            {{ $c->code }} ({{ $c->discount_text ?? 'ส่วนลด' }})
                        </option>
                    @endforeach
                @endisset
            </select>
        </div>

        <div class="text-xs text-center text-gray-500">- หรือ -</div>

        <!-- 2. แบบพิมพ์โค้ดเอง -->
        <div class="flex gap-2">
            <input type="text" name="coupon_code" value="{{ $couponCode ?? '' }}" placeholder="กรอกโค้ดส่วนลด..." 
                   class="w-full bg-[#171717] border border-gray-700 text-white text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#00fff2]">
            <button type="submit" class="bg-[#00fff2] text-black font-bold text-sm px-6 py-2.5 rounded-xl hover:bg-cyan-300 transition shrink-0">
                ใช้โค้ด
            </button>
        </div>
    </form>

    @if(!empty($couponError))
        <p class="text-xs text-red-400 mt-1">⚠️ {{ $couponError }}</p>
    @endif
</div>
            

            @if (!empty($couponError))
                <p class="text-red-400 text-xs mt-2">{{ $couponError }}</p>
            @endif

            <!-- สรุปยอดเงิน -->
            <div class="pt-4 text-sm text-gray-300 space-y-1 text-right">
                <div>ยอดรวมสินค้า: {{ number_format($subtotal ?? 0, 2) }} บาท</div>
                <div>ส่วนลด: -{{ number_format($discountAmount ?? 0, 2) }} บาท</div>
            </div>

            <!-- ฟอร์มยืนยันสั่งซื้อ (POST ไป checkout.process) -->
            <form method="POST" action="{{ route('checkout.process') }}" class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-gray-800 mt-4">
                @csrf
                <input type="hidden" name="coupon_code" value="{{ $couponCode ?? '' }}">
                
                <div class="text-xl font-bold">
                    คำสั่งซื้อทั้งหมด <span class="text-[#00fff2]">{{ isset($cartItems) ? $cartItems->sum(fn ($i) => $i->pivot->quantity) : 0 }}</span> ชิ้น :
                    <span class="text-2xl font-extrabold text-[#00fff2] ml-1">{{ number_format($total ?? 0, 2) }} บาท</span>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('cart.index') }}" class="w-full sm:w-auto text-center bg-gray-800 hover:bg-gray-700 text-white font-bold px-6 py-3 rounded-xl transition">ย้อนกลับ</a>
                    <button type="submit" class="w-full sm:w-auto bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold px-8 py-3 rounded-xl transition shadow-lg shadow-cyan-500/25 cursor-pointer">
                        สั่งซื้อสินค้า
                    </button>
                </div>
            </form>
        </main>
    </div>

    <!-- Footer -->
    <footer class="text-center py-6 text-gray-500 text-xs border-t border-gray-800/50 mt-12">
        &copy; {{ date('Y') }} HD Harmdung. All rights reserved.
    </footer>
</body>
</html>