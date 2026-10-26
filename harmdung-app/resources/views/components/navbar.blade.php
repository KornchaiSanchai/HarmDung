@props(['active' => null])

@php
    $base = 'flex items-center gap-2 px-5 py-2 rounded-full text-sm transition';
    $on   = 'bg-[#333333] text-white shadow-inner';
    $off  = 'text-gray-300 hover:text-white hover:bg-gray-800/50';
@endphp

<header>
    <nav class="flex items-center justify-between px-8 py-4 border-b border-gray-800/80 bg-[#121212]/80 backdrop-blur-md sticky top-0 z-50">
        <div class="flex items-center gap-8">
            <a href="/home" class="flex items-center shrink-0 group">
                <img src="/images/logo.png" alt="HD Harmdung" class="h-10 w-auto object-contain scale-125 origin-left transition-transform group-hover:scale-130">
            </a>

            <div class="flex items-center gap-2">
                <a href="/home" class="{{ $base }} {{ $active === 'home' ? $on : $off }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    หน้าแรก
                </a>
                <a href="/products" class="{{ $base }} {{ $active === 'products' ? $on : $off }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    สินค้าทั้งหมด
                </a>
                @auth
                <a href="/cart" class="{{ $base }} {{ $active === 'cart' ? $on : $off }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    ตะกร้า
                </a>
                @endauth
            </div>
        </div>

        {{-- ช่องว่างกลาง: หน้า movie-details ใส่ search bar ตรงนี้ --}}
        {{ $slot }}

        <div class="flex items-center gap-4 text-sm font-semibold">
            @auth
                <div class="bg-gray-800/90 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2 border border-gray-700/80 shadow">
                    <span class="w-5 h-5 bg-gradient-to-tr from-yellow-500 to-amber-300 rounded-full flex items-center justify-center text-black font-extrabold text-xs shadow-sm">฿</span>
                    <span class="font-bold text-gray-100">{{ number_format(auth()->user()->balance, 2) }}</span>
                </div>
                <a href="/profile" class="w-10 h-10 bg-[#00fff2] rounded-full flex items-center justify-center text-black font-bold shadow-md ring-2 ring-[#00fff2]/50 hover:scale-105 transition" title="ข้อมูลสมาชิก">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </a>
            @endauth

            @guest
                <a href="/login" class="bg-white text-black px-5 py-2 rounded-full hover:bg-gray-200 transition font-bold text-xs">เข้าสู่ระบบ</a>
                <a href="/register" class="bg-[#00fff2] text-black px-5 py-2 rounded-full hover:bg-cyan-300 transition font-bold text-xs">สมัครสมาชิก</a>
            @endguest
        </div>
    </nav>
</header>