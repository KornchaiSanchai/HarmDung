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
        <x-navbar active="cart"></x-navbar>

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
            <!-- ส่วนลดคำสั่งซื้อ (คูปอง) -->
            <div class="bg-[#202020] p-6 rounded-2xl border border-gray-800 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-cyan-300 font-bold text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        <span>ส่วนลดคำสั่งซื้อ (คูปอง)</span>
                    </div>

                    @if(!empty($couponCode))
                        <span class="text-xs bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-3 py-1 rounded-full font-bold">
                            กำลังใช้คูปอง: {{ $couponCode }}
                        </span>
                    @endif
                </div>

                <!-- ป้ายแสดงคูปองที่กำลังใช้งานอยู่ พร้อมปุ่มยกเลิก -->
                @if(!empty($couponCode))
                    <div class="flex items-center justify-between bg-emerald-500/10 border border-emerald-500/30 rounded-xl px-4 py-3 text-sm">
                        <div class="flex items-center gap-2 text-emerald-300">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <div>
                                <span class="font-extrabold text-white">{{ $couponCode }}</span>
                                <span class="text-xs text-emerald-400 ml-1">
                                    ({{ $appliedCoupon['name'] ?? 'ส่วนลด' }} — ลด {{ number_format($discountAmount, 2) }} บาท)
                                </span>
                            </div>
                        </div>
                        <button type="button" id="removeCouponBtn" class="text-xs text-rose-400 hover:text-rose-300 font-bold underline cursor-pointer ml-3 shrink-0">
                            ✕ ยกเลิกคูปอง
                        </button>
                    </div>
                @endif

                @if(!empty($couponError))
                    <div class="bg-rose-500/10 border border-rose-500/30 text-rose-300 rounded-xl px-4 py-2.5 text-xs flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>{{ $couponError }}</span>
                    </div>
                @endif

                <form action="{{ route('checkout.index') }}" method="GET" id="couponForm" class="space-y-4">
                    @foreach($selectedIds as $id)
                        <input type="hidden" name="items[]" value="{{ $id }}">
                    @endforeach
                    <input type="hidden" name="coupon_code" id="hiddenCouponCode" value="{{ $couponCode ?? '' }}">

                    <!-- 1. แบบเลือกจาก Dropdown -->
                    <div>
                        <label for="couponSelect" class="block text-xs text-gray-400 mb-1.5 font-medium">
                            เลือกคูปองส่วนลดที่มี (สามารถเปลี่ยนได้ตลอดเวลา):
                        </label>
                        <select id="couponSelect" class="w-full bg-[#171717] border border-gray-700 text-white text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#00fff2] cursor-pointer">
                            <option value="" class="bg-[#171717] text-gray-400">-- ไม่ใช้คูปองส่วนลด / ยกเลิกคูปอง --</option>
                            @isset($availableCoupons)
                                @foreach($availableCoupons as $c)
                                    @if($c['usable'])
                                        <option value="{{ $c['code'] }}" {{ ($couponCode ?? '') === $c['code'] ? 'selected' : '' }} class="bg-[#171717] text-white py-1">
                                            {{ $c['code'] }} ({{ $c['name'] }}) — {{ $c['desc'] }} @if(($c['discount'] ?? 0) > 0)(ประหยัด ฿{{ number_format($c['discount'], 2) }})@endif
                                        </option>
                                    @else
                                        {{-- คูปองที่ใช้ไม่ได้: ตัวหนังสือสีจาง (text-gray-500 opacity-50) และเขียนคำอธิบายเหตุผลต่อท้าย --}}
                                        <option value="{{ $c['code'] }}" disabled class="bg-[#191919] text-gray-500 opacity-50 py-1">
                                            {{ $c['code'] }} ({{ $c['name'] }}) — ไม่สามารถใช้ได้: {{ $c['reason'] }}
                                        </option>
                                    @endif
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="text-xs text-center text-gray-500 font-semibold">- หรือพิมพ์โค้ดส่วนลด -</div>

                    <!-- 2. แบบพิมพ์โค้ดเอง -->
                    <div>
                        <div class="flex gap-2">
                            <input type="text" id="customCouponInput" value="{{ $couponCode ?? '' }}" placeholder="กรอกโค้ดส่วนลด เช่น SAVE5..." 
                                   class="w-full bg-[#171717] border border-gray-700 text-white text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#00fff2] uppercase tracking-wider">
                            <button type="button" id="applyCustomCouponBtn" class="bg-[#00fff2] hover:bg-cyan-300 text-black font-bold text-sm px-6 py-2.5 rounded-xl transition shrink-0 cursor-pointer shadow-md">
                                ใช้โค้ด
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- สรุปยอดเงิน -->
            <div class="pt-6 text-sm text-gray-300 space-y-1.5 text-right border-t border-gray-800 mt-6">
                <div>ยอดรวมสินค้า: <span class="font-semibold">{{ number_format($subtotal ?? 0, 2) }}</span> บาท</div>
                @if(($discountAmount ?? 0) > 0)
                    <div class="text-emerald-400 font-bold">
                        ส่วนลด ({{ $couponCode }}): -{{ number_format($discountAmount, 2) }} บาท
                    </div>
                @else
                    <div class="text-gray-500">ส่วนลด: -0.00 บาท</div>
                @endif
            </div>

            <!-- ฟอร์มยืนยันสั่งซื้อ (POST ไป checkout.process) -->
            <form method="POST" action="{{ route('checkout.process') }}" class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-gray-800 mt-4">
                @csrf
                <input type="hidden" name="coupon_code" value="{{ $couponCode ?? '' }}">
                @foreach($selectedIds as $id)
                    <input type="hidden" name="items[]" value="{{ $id }}">
                @endforeach
                
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

    <!-- JavaScript สำหรับการเลือก/เปลี่ยนคูปองและล้างคูปอง -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const couponForm = document.getElementById('couponForm');
            const hiddenCouponCode = document.getElementById('hiddenCouponCode');
            const couponSelect = document.getElementById('couponSelect');
            const customCouponInput = document.getElementById('customCouponInput');
            const applyCustomCouponBtn = document.getElementById('applyCustomCouponBtn');
            const removeCouponBtn = document.getElementById('removeCouponBtn');

            // 1) เมื่อเลือกจาก Dropdown -> เปลี่ยนคูปองทันที (หรือถ้าเลือกค่าว่างจะเป็นการยกเลิกคูปอง)
            if (couponSelect) {
                couponSelect.addEventListener('change', function () {
                    hiddenCouponCode.value = this.value;
                    couponForm.submit();
                });
            }

            // 2) เมื่อพิมพ์โค้ดเองแล้วกดปุ่ม "ใช้โค้ด"
            if (applyCustomCouponBtn && customCouponInput) {
                applyCustomCouponBtn.addEventListener('click', function () {
                    hiddenCouponCode.value = (customCouponInput.value || '').trim();
                    couponForm.submit();
                });

                customCouponInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        hiddenCouponCode.value = (this.value || '').trim();
                        couponForm.submit();
                    }
                });
            }

            // 3) เมื่อกดยกเลิกคูปอง
            if (removeCouponBtn) {
                removeCouponBtn.addEventListener('click', function () {
                    hiddenCouponCode.value = '';
                    couponForm.submit();
                });
            }
        });
    </script>

    <!-- Footer -->
    <footer class="text-center py-6 text-gray-500 text-xs border-t border-gray-800/50 mt-12">
        &copy; {{ date('Y') }} HD Harmdung. All rights reserved.
    </footer>
</body>
</html>