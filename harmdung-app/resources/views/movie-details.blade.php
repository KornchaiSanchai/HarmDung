<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดภาพยนตร์ - HD Harmdung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#171717] text-white font-sans antialiased min-h-screen pb-16 selection:bg-[#00fff2] selection:text-black">

    <!-- Navbar matching Figma #13:179 -->
    <header>
        <nav class="flex items-center justify-between px-8 py-4 border-b border-gray-800/80 bg-[#121212]/80 backdrop-blur-md sticky top-0 z-50">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="/home" class="flex items-center shrink-0 group">
                    <img src="/images/logo.png" alt="HD Harmdung" class="h-10 w-auto object-contain scale-125 origin-left transition-transform group-hover:scale-130">
                </a>
                
                <!-- Nav Links -->
                <div class="flex items-center gap-2">
                    <a href="/home" class="flex items-center gap-2 bg-[#333333] px-5 py-2 rounded-full text-sm text-white shadow-inner">
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

            <!-- Search Bar in Navbar matching Figma Group 1 -->
            <div class="hidden lg:block relative w-80">
                <input type="text" placeholder="ค้นหาหนัง หรือ แฟลตฟอร์ม" 
                       class="w-full bg-white text-black pl-5 pr-10 py-2 rounded-full text-xs outline-none focus:ring-2 focus:ring-[#00fff2] placeholder-gray-400">
                <button class="absolute right-3.5 top-1/2 -translate-y-1/2 text-black">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>

            <!-- Profile / Balance -->
            <div class="flex items-center gap-4">
                <div class="bg-gray-800/90 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2 border border-gray-700/80 shadow">
                    <span class="w-5 h-5 bg-gradient-to-tr from-yellow-500 to-amber-300 rounded-full flex items-center justify-center text-black font-extrabold text-xs shadow-sm">฿</span>
                    <span class="font-bold text-gray-100">100.00</span>
                </div>
                <a href="/profile" class="w-10 h-10 bg-[#00fff2] rounded-full flex items-center justify-center text-black font-bold shadow-md hover:scale-105 transition" title="ข้อมูลสมาชิก">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Container matching Figma Rectangle 57 (#13:179) -->
    <main class="max-w-[1100px] mx-auto px-6 mt-8">
        
        <div class="mb-4">
            <a href="/home" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                กลับหน้าแรก
            </a>
        </div>

        <div class="bg-[#1f1f1f] rounded-[28px] overflow-hidden border border-gray-800 shadow-2xl">
            
            <!-- Movie Hero Poster matching Figma Rectangle 17 (#13:179) -->
            <div class="relative w-full aspect-[21/9] bg-gradient-to-tr from-gray-950 via-gray-900 to-slate-800 overflow-hidden flex items-end p-8 md:p-12">
                <div class="absolute inset-0 bg-cover bg-center opacity-40 mix-blend-overlay" style="background-image: radial-gradient(circle, rgba(0,255,242,0.3) 0%, rgba(0,0,0,0.8) 100%);"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6 w-full">
                    <div>
                        <!-- Platform Badges -->
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-xs font-semibold text-gray-300">รับชมได้ที่</span>
                            <div class="flex items-center gap-2">
                                <a href="/product-info?platform=thisney" class="px-3 py-1 bg-gradient-to-r from-[#0b1b3d] to-[#043360] rounded-lg text-xs font-bold text-white border border-white/20 hover:scale-105 transition">
                                    Thisney-
                                </a>
                                <a href="/product-info?platform=netflux" class="px-3 py-1 bg-gradient-to-r from-[#3e0808] to-[#1a0202] rounded-lg text-xs font-bold text-red-500 border border-red-500/30 hover:scale-105 transition">
                                    NETFLUX
                                </a>
                                <a href="/product-info?platform=hiv" class="px-3 py-1 bg-gradient-to-r from-[#5a1bb9] to-[#204ce4] rounded-lg text-xs font-bold text-white border border-white/20 hover:scale-105 transition">
                                    HIV min
                                </a>
                            </div>
                        </div>

                        <!-- Movie Title -->
                        <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight drop-shadow-lg">
                            Inception (จิตพิฆาตโลก)
                        </h1>
                    </div>

                    <!-- Rating badge matching Figma Group 6 (#13:179) -->
                    <div class="bg-black/60 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/10 flex items-center gap-3">
                        <span class="text-yellow-400 text-2xl font-black">★</span>
                        <div>
                            <div class="text-2xl font-black text-white leading-none">4.9</div>
                            <div class="text-[10px] text-gray-400 font-semibold uppercase mt-0.5">Rating (1.2k)</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area: Synopsis & Reviews -->
            <div class="p-8 md:p-12 space-y-10">
                
                <!-- Synopsis matching Figma multi-paragraph texts (#13:179) -->
                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-white">เรื่องย่อภาพยนตร์</h2>
                    <div class="space-y-3 text-sm text-gray-300 leading-relaxed">
                        <p>
                            ดอม คอบบ์ (รับบทโดย ลีโอนาร์โด ดิแคพรีโอ) คือหัวขโมยฝีมือฉกาจที่สุดในการฉกข้อมูลลับล้ำค่าจากจิตใต้สำนึกอันลึกซึ้งของเป้าหมายในห้วงความฝัน ความสามารถของคอบบ์ทำให้เขาเป็นที่ต้องการตัวในโลกจารกรรม แต่มันก็ทำให้เขาสูญเสียทุกสิ่งที่เขารักไป
                        </p>
                        <p>
                            โอกาสสุดท้ายในการไถ่บาปและกลับบ้านเกิดขึ้นเมื่อเขาได้รับภารกิจใหม่ที่แทบเป็นไปไม่ได้ แทนที่จะเป็นการขโมยความคิด เขาและทีมงานผู้เชี่ยวชาญต้องทำการ "ปลูกฝังความคิด" (Inception) ลงไปในจิตใจของทายาทมหาเศรษฐี หากทำสำเร็จ มันจะเป็นอาชญากรรมที่สมบูรณ์แบบที่สุด
                        </p>
                    </div>

                    <div class="pt-4 flex items-center gap-4">
                        <a href="/products" class="bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold px-6 py-2.5 rounded-full transition shadow-lg shadow-cyan-500/20 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            เลือกซื้อแพ็กเกจเพื่อรับชม
                        </a>
                    </div>
                </div>

                <!-- Review Section matching Figma #13:179 Review list -->
                <div class="border-t border-gray-800 pt-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <span>รีวิวจากผู้ชม</span>
                            <span class="text-xs font-normal text-gray-400">Review</span>
                        </h3>
                    </div>

                    <div class="space-y-4">
                        <!-- Review 1: userxxx -->
                        <div class="bg-gray-900/80 rounded-2xl p-5 border border-gray-800">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-cyan-900/60 text-[#00fff2] font-bold text-xs flex items-center justify-center">
                                        X
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm text-white">userxxx</div>
                                        <div class="text-[10px] text-gray-500">2024-10-21 17:37</div>
                                    </div>
                                </div>
                                <div class="text-yellow-400 text-xs font-bold flex items-center gap-1">
                                    ★★★★★ <span>4.9</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-300 leading-relaxed pl-11">
                                ภาพยนตร์สุดยอดคลาสสิกที่ต้องดูสักครั้งในชีวิต ดนตรีประกอบของ Hans Zimmer ทรงพลังมาก พล็อตเรื่องซับซ้อนแต่ชวนติดตามตลอด 2 ชั่วโมงครึ่ง
                            </p>
                        </div>

                        <!-- Review 2: userxyz -->
                        <div class="bg-gray-900/80 rounded-2xl p-5 border border-gray-800">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-purple-900/60 text-purple-300 font-bold text-xs flex items-center justify-center">
                                        Y
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm text-white">userxyz</div>
                                        <div class="text-[10px] text-gray-500">2025-01-11 12:34</div>
                                    </div>
                                </div>
                                <div class="text-yellow-400 text-xs font-bold flex items-center gap-1">
                                    ★★★★★ <span>4.8</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-300 leading-relaxed pl-11">
                                แนะนำให้ซื้อแพ็กเกจดูแบบ 4K ครับ ภาพสวยอลังการมาก ซื้อผ่าน HarmDung ใช้งานได้ทันทีไม่สะดุดเลย คุ้มค่ามากครับ
                            </p>
                        </div>

                        <!-- Review 3: userabc -->
                        <div class="bg-gray-900/80 rounded-2xl p-5 border border-gray-800">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-emerald-900/60 text-emerald-300 font-bold text-xs flex items-center justify-center">
                                        A
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm text-white">userabc</div>
                                        <div class="text-[10px] text-gray-500">2026-04-30 10:47</div>
                                    </div>
                                </div>
                                <div class="text-yellow-400 text-xs font-bold flex items-center gap-1">
                                    ★★★★★ <span>4.9</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-300 leading-relaxed pl-11">
                                หนึ่งในผลงานชิ้นเอกของ Christopher Nolan การแสดงของนักแสดงทุกคนยอดเยี่ยมไร้ที่ติ ดูซ้ำกี่รอบก็ยังประทับใจ
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-8 text-gray-500 text-xs border-t border-gray-800/50 mt-12">
        &copy; {{ date('Y') }} HD Harmdung. All rights reserved.
    </footer>

</body>
</html>
