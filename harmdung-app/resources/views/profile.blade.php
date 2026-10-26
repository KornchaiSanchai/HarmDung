<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์ของคุณ - HD Harmdung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#171717] text-white font-sans antialiased min-h-screen pb-16 selection:bg-[#00fff2] selection:text-black">
    @php
    $user = auth()->user();
    $balance = number_format($user->balance, 2);
    $orders = collect($orders ?? []);
    $recentOrders = collect($recentOrders ?? []);
    $couponOrders = collect($couponOrders ?? []);
@endphp
    <!-- Navbar -->
    <header>
        <nav class="flex items-center justify-between px-8 py-4 border-b border-gray-800/80 bg-[#121212]/80 backdrop-blur-md sticky top-0 z-50">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="/home" class="flex items-center shrink-0 group">
                    <img src="/images/logo.png" alt="HD Harmdung" class="h-10 w-auto object-contain scale-125 origin-left transition-transform group-hover:scale-130">
                </a>
                
                <!-- Nav Links -->
                <div class="flex items-center gap-2">
                    <a href="/home" class="flex items-center gap-2 px-5 py-2 text-sm text-gray-300 hover:text-white transition rounded-full hover:bg-gray-800/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        หน้าแรก
                    </a>
                    <a href="/products" class="flex items-center gap-2 px-5 py-2 text-sm text-gray-300 hover:text-white transition rounded-full hover:bg-gray-800/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        สินค้าทั้งหมด
                    </a>
                    <a href="/cart" class="flex items-center gap-2 px-5 py-2 rounded-full text-sm text-gray-300 hover:text-white transition hover:bg-gray-800/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        ตะกร้า
                    </a>
                </div>
            </div>

            <!-- Profile & Balance -->
            <div class="flex items-center gap-4">
                <div class="bg-gray-800/90 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2 border border-gray-700/80 shadow">
                    <span class="w-5 h-5 bg-gradient-to-tr from-yellow-500 to-amber-300 rounded-full flex items-center justify-center text-black font-extrabold text-xs shadow-sm">฿</span>
                    <span class="font-bold text-gray-100">{{ $balance }}</span>
                </div>
                <div class="w-10 h-10 bg-[#00fff2] rounded-full flex items-center justify-center text-black font-bold shadow-md ring-2 ring-[#00fff2]/50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Member Container -->
    <main class="max-w-[1300px] mx-auto px-6 mt-10">
        @if (session('status'))
    <p class="mt-4 rounded-xl bg-emerald-500/20 px-4 py-3 text-emerald-300 text-sm">{{ session('status') }}</p>
@endif
        <!-- Header & Action Bar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight flex items-center gap-3">โปรไฟล์ของคุณ</h1>
                <p class="text-gray-400 text-sm mt-1">จัดการข้อมูลส่วนตัว การตั้งค่า และดูประวัติการทำรายการของคุณ</p>
            </div>

            <!-- Logout Button matching Figma Group 13 (#ef4444) -->
            <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="bg-[#ef4444] hover:bg-red-600 text-white font-bold px-6 py-2.5 rounded-full transition shadow-lg shadow-red-500/20 flex items-center gap-2 text-sm active:scale-95">
        ออกจากระบบ
    </button>
</form>
</div>

        <!-- 4 Tabs matching Figma Member Info 1-4 (#24:468, #29:41, #29:111, #29:239) -->
        <div class="flex items-center gap-3 mt-8 overflow-x-auto pb-3 border-b border-gray-800/80">
            <button onclick="switchTab('profile')" id="tab-btn-profile" 
                    class="tab-btn px-6 py-2.5 rounded-full text-sm font-bold transition flex items-center gap-2 bg-[#333333] text-white shadow-inner">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                ข้อมูลผู้ใช้
            </button>
            <button onclick="switchTab('settings')" id="tab-btn-settings" 
                    class="tab-btn px-6 py-2.5 rounded-full text-sm font-bold transition flex items-center gap-2 bg-transparent text-gray-400 hover:text-white hover:bg-gray-800/50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                การตั้งค่าผู้ใช้
            </button>
            <button onclick="switchTab('orders')" id="tab-btn-orders" 
                    class="tab-btn px-6 py-2.5 rounded-full text-sm font-bold transition flex items-center gap-2 bg-transparent text-gray-400 hover:text-white hover:bg-gray-800/50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                ประวัติการซื้อ
            </button>
            <button onclick="switchTab('coupons')" id="tab-btn-coupons" 
                    class="tab-btn px-6 py-2.5 rounded-full text-sm font-bold transition flex items-center gap-2 bg-transparent text-gray-400 hover:text-white hover:bg-gray-800/50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                ประวัติคูปอง
            </button>
        </div>

        <!-- =================== TAB 1: ข้อมูลผู้ใช้ (Profile) =================== -->
        <div id="tab-content-profile" class="tab-pane mt-8">
            <!-- User Overview Card -->
            <div class="bg-gradient-to-r from-gray-900 to-[#1f2937] rounded-[28px] p-8 border border-gray-800 shadow-xl flex flex-col md:flex-row items-center gap-8">
                <!-- Avatar circle — ใช้ style เดียวกับ navbar icon ขวาบน -->
                <div class="w-24 h-24 bg-[#00fff2] rounded-full flex items-center justify-center text-black shadow-lg ring-4 ring-[#00fff2]/30 shrink-0">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>

                <div class="space-y-3 text-center md:text-left flex-1">
                    <div class="flex flex-col md:flex-row md:items-center gap-3">
                        <h2 class="text-2xl md:text-3xl font-extrabold text-white">{{ $user->name }}</h2>
                    </div>
                    <p class="text-gray-300 font-medium">{{ $user->email }}</p>
                    
                    <div class="pt-2 flex flex-wrap items-center justify-center md:justify-start gap-4">
                        <div class="bg-black/40 px-5 py-2.5 rounded-2xl border border-gray-800 flex items-center gap-3">
                            <span class="text-xs text-gray-400">ยอดเงินคงเหลือ:</span>
                            <span class="text-lg font-black text-[#00fff2]">฿ {{ $balance }}</span>
                        </div>
                        <div class="bg-black/40 px-5 py-2.5 rounded-2xl border border-gray-800 flex items-center gap-3">
                            <span class="text-xs text-gray-400">คำสั่งซื้อทั้งหมด:</span>
                            <span class="text-lg font-black text-white">{{ $orders->count() }} รายการ</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Recently Purchased matching Figma #24:468 -->
            <div class="mt-10">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#00fff2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    สินค้าที่ซื้อล่าสุด
                </h3>

                <div class="space-y-4">
                    <!-- Item 1 -->
                    @php $recentItems = $recentOrders->flatMap(fn ($o) => $o->products->map(fn ($p) => [$o, $p])); @endphp
@forelse ($recentItems as [$order, $product])
    @php
        $expires = $order->created_at->copy()->addDays($product->duration_days);
        $daysLeft = (int) now()->diffInDays($expires, false);
    @endphp
    <div class="bg-white text-black rounded-[24px] p-6 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-24 aspect-video rounded-xl bg-gradient-to-r from-[#5a1bb9] to-[#204ce4] flex items-center justify-center text-white font-extrabold text-sm shadow">
                {{ $product->platform->name }}
            </div>
            <div>
                <h4 class="text-lg font-extrabold leading-tight">{{ $product->platform->name }}</h4>
                <p class="text-gray-500 text-xs mt-1">แพ็กเกจ # {{ $product->plan_name }} ({{ $product->duration_days }} วัน)</p>
                @if ($daysLeft > 0)
                    <span class="inline-block mt-2 text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full">พร้อมใช้งาน (เหลือ {{ $daysLeft }} วัน)</span>
                @else
                    <span class="inline-block mt-2 text-xs font-bold text-gray-600 bg-gray-100 px-2.5 py-0.5 rounded-full">หมดอายุแล้ว</span>
                @endif
            </div>
        </div>
        <div class="text-right">
            <div class="text-xs text-gray-400">ราคา</div>
            <div class="text-xl font-black text-gray-900">{{ number_format($product->pivot->unit_price) }} บาท</div>
        </div>
    </div>
                @empty
                <p class="text-gray-400">ยังไม่มีสินค้าล่าสุดที่สั่งซื้อ</p>
                @endforelse

                </div>
            </div>
        </div>

        <!-- =================== TAB 2: การตั้งค่าผู้ใช้ (Settings) matching Figma #29:41 =================== -->
       <div id="tab-content-settings" class="tab-pane mt-8 hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
         <form method="POST" action="{{ route('member.profile.update') }}" class="bg-gray-900 rounded-[28px] p-8 border border-gray-800 shadow-xl space-y-4">
        @csrf @method('PATCH')
        <h3 class="text-xl font-bold text-white">ข้อมูลส่วนตัว</h3>

        <label class="block text-xs font-bold text-gray-300">ชื่อผู้ใช้งาน / Username</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}"
               class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#00fff2]">
        @error('name') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror

        <label class="block text-xs font-bold text-gray-300">อีเมล / Email <span class="text-red-400">(เปลี่ยนไม่ได้)</span></label>
        <input type="email" value="{{ $user->email }}" disabled
               class="w-full bg-gray-800/50 border border-gray-700/50 rounded-xl px-4 py-3 text-sm text-gray-400 cursor-not-allowed">

        <div class="pt-2 flex justify-end">
            <button type="submit" class="bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold px-8 py-3 rounded-full text-sm">บันทึก</button>
        </div>
    </form>

    <form method="POST" action="{{ route('member.password.update') }}" class="bg-gray-900 rounded-[28px] p-8 border border-gray-800 shadow-xl space-y-4">
        @csrf @method('PUT')
        <h3 class="text-xl font-bold text-white">เปลี่ยนรหัสผ่าน</h3>

        <input type="password" name="current_password" placeholder="รหัสผ่านปัจจุบัน"
               class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#00fff2]">
        @error('current_password') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror

        <input type="password" name="password" placeholder="รหัสผ่านใหม่"
               class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#00fff2]">
        @error('password') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror

        <input type="password" name="password_confirmation" placeholder="ยืนยันรหัสผ่านใหม่"
               class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#00fff2]">

        <div class="pt-2 flex justify-end">
            <button type="submit" class="bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold px-8 py-3 rounded-full text-sm">บันทึก</button>
        </div>
    </form>
</div>
</div>

        <!-- =================== TAB 3: ประวัติการซื้อ (Orders) matching Figma #29:111 =================== -->
        <div id="tab-content-orders" class="tab-pane mt-8 hidden">
            <!-- Search Bar matching Figma Rectangle 9 / text "ค้นหาคำสั่งซื้อ" -->
            <div class="relative max-w-md mb-6">
                <input type="text" placeholder="ค้นหาคำสั่งซื้อ..." 
                       class="w-full bg-white text-black pl-5 pr-12 py-3 rounded-full text-sm outline-none focus:ring-2 focus:ring-[#00fff2] placeholder-gray-400 shadow-md">
                <button class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>

            <!-- Orders Table Container -->
            <div class="bg-white text-black rounded-[28px] p-8 shadow-2xl overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="border-b border-gray-200 text-gray-500 text-xs font-bold uppercase tracking-wider">
                            <th class="py-4 px-4">สินค้าที่ซื้อล่าสุด / Recently Purchased</th>
                            <th class="py-4 px-4 text-center">วันที่สั่งซื้อ / Purchased At</th>
                            <th class="py-4 px-4 text-center">จำนวน</th>
                            <th class="py-4 px-4 text-right">ยอดรวม</th>
                            <th class="py-4 px-4 text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <!-- Order 1 -->
                        @forelse ($orders as $order)
    @foreach ($order->products as $product)
        @php $expired = $order->created_at->copy()->addDays($product->duration_days)->isPast(); @endphp
        <tr class="hover:bg-gray-50/80 transition">
            <td class="py-5 px-4">
                <div class="font-extrabold text-gray-900">{{ $product->platform->name }} (# {{ $product->plan_name }})</div>
                <div class="text-xs text-gray-400">Order #HD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
            </td>
            <td class="py-5 px-4 text-center text-gray-600 font-medium">{{ $order->created_at->format('Y-m-d H:i') }}</td>
            <td class="py-5 px-4 text-center font-bold">{{ $product->pivot->quantity }}</td>
            <td class="py-5 px-4 text-right font-black text-gray-900">{{ number_format($product->pivot->unit_price * $product->pivot->quantity) }} บาท</td>
            <td class="py-5 px-4 text-center">
                <span class="{{ $expired ? 'bg-gray-200 text-gray-700' : 'bg-emerald-100 text-emerald-800' }} text-xs font-bold px-3 py-1 rounded-full">
                    {{ $expired ? 'หมดอายุแล้ว' : 'สำเร็จ' }}
                </span>
            </td>
        </tr>
    @endforeach
@empty
    <tr><td colspan="5" class="py-8 text-center text-gray-400">ยังไม่มีประวัติการซื้อ</td></tr>
@endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- =================== TAB 4: ประวัติคูปอง (Coupons) matching Figma #29:239 =================== -->
        <div id="tab-content-coupons" class="tab-pane mt-8 hidden">
            <!-- Coupon Table Container -->
            <div class="bg-white text-black rounded-[28px] p-8 shadow-2xl overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="border-b border-gray-200 text-gray-500 text-xs font-bold uppercase tracking-wider">
                            <th class="py-4 px-4">คูปองที่ใช้ล่าสุด / Recently Used Coupon(s)</th>
                            <th class="py-4 px-4 text-center">วันที่ใช้งาน / Used At</th>
                            <th class="py-4 px-4 text-center">ส่วนลดที่ได้รับ</th>
                            <th class="py-4 px-4 text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <!-- Coupon 1 -->
                       @forelse ($couponOrders as $order)
    <tr class="hover:bg-gray-50/80 transition">
        <td class="py-5 px-4">
            <span class="px-3 py-1.5 bg-cyan-100 text-cyan-800 font-black rounded-lg text-xs tracking-wider">{{ $order->coupon->code }}</span>
            <div class="text-xs text-gray-400 mt-1">ใช้ในคำสั่งซื้อ #HD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
        </td>
        <td class="py-5 px-4 text-center text-gray-600 font-medium">{{ $order->created_at->format('Y-m-d H:i') }}</td>
        <td class="py-5 px-4 text-center font-extrabold text-emerald-600">-{{ number_format($order->discount_amount, 2) }} บาท</td>
        <td class="py-5 px-4 text-center">
            <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">ใช้งานแล้ว</span>
        </td>
    </tr>
@empty
    <tr><td colspan="4" class="py-8 text-center text-gray-400">ยังไม่เคยใช้คูปอง</td></tr>
@endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script>
        function switchTab(tabKey) {
            // Hide all tab panes
            document.querySelectorAll('.tab-pane').forEach(el => el.classList.add('hidden'));
            
            // Remove active styles from all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-[#333333]', 'text-white', 'shadow-inner');
                btn.classList.add('bg-transparent', 'text-gray-400');
            });

            // Show selected tab pane
            const targetPane = document.getElementById('tab-content-' + tabKey);
            if (targetPane) {
                targetPane.classList.remove('hidden');
            }

            // Highlight selected button
            const targetBtn = document.getElementById('tab-btn-' + tabKey);
            if (targetBtn) {
                targetBtn.classList.remove('bg-transparent', 'text-gray-400');
                targetBtn.classList.add('bg-[#333333]', 'text-white', 'shadow-inner');
            }
        }

        // Handle URL parameter tab
        const urlParams = new URLSearchParams(window.location.search);
        const initialTab = urlParams.get('tab');
        if (initialTab && ['profile', 'settings', 'orders', 'coupons'].includes(initialTab)) {
            switchTab(initialTab);
        }
    </script>
</body>
</html>