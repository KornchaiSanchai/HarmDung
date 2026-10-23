<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดแพ็กเกจ - HD Harmdung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#171717] text-white font-sans antialiased min-h-screen pb-16 selection:bg-[#00fff2] selection:text-black">

    @php
        $platformKey = request('platform', 'hiv');
        $platformsData = [
            'hiv' => [
                'name' => 'HIV min',
                'badge' => 'HIV',
                'color_gradient' => 'from-[#5a1bb9] to-[#204ce4]',
                'accent' => '#7c3aed',
                'description' => 'บริการสตรีมมิ่งความคมชัดระดับ 4K UHD รองรับการรับชมพร้อมกันได้สูงสุด 4 หน้าจอ พร้อมระบบเสียง Dolby Atmos',
                'image' => '/images/hiv.png',
                'packages' => [
                    ['days' => '1 Day', 'price' => 15, 'original' => 20, 'popular' => false],
                    ['days' => '14 Day', 'price' => 40, 'original' => 55, 'popular' => false],
                    ['days' => '30 Day', 'price' => 70, 'original' => 99, 'popular' => true],
                    ['days' => '60 Day', 'price' => 130, 'original' => 180, 'popular' => false],
                ]
            ],
            'thisney' => [
                'name' => 'Thisney-',
                'badge' => 'Disney',
                'color_gradient' => 'from-[#0b1b3d] to-[#043360]',
                'accent' => '#0284c7',
                'description' => 'เพลิดเพลินกับภาพยนตร์และซีรีส์สุดเอ็กซ์คลูซีฟจากดิสนีย์ พิกซาร์ มาร์เวล สตาร์ วอร์ส และเนชั่นแนล จีโอกราฟฟิก',
                'image' => '/images/thisney.png',
                'packages' => [
                    ['days' => '1 Day', 'price' => 15, 'original' => 25, 'popular' => false],
                    ['days' => '7 Day', 'price' => 25, 'original' => 35, 'popular' => false],
                    ['days' => '30 Day', 'price' => 75, 'original' => 109, 'popular' => true],
                    ['days' => '60 Day', 'price' => 140, 'original' => 200, 'popular' => false],
                ]
            ],
            'netflux' => [
                'name' => 'NETFLUX',
                'badge' => 'Netflix',
                'color_gradient' => 'from-[#3e0808] to-[#1a0202]',
                'accent' => '#dc2626',
                'description' => 'รับชมภาพยนตร์ ซีรีส์ อนิเมะ สารคดี และอีกมากมายได้ไม่อั้น คมชัดระดับ Ultra HD พรีเมียมไร้โฆษณาคั่น',
                'image' => '/images/netflux.png',
                'packages' => [
                    ['days' => '1 Day', 'price' => 19, 'original' => 29, 'popular' => false],
                    ['days' => '14 Day', 'price' => 59, 'original' => 79, 'popular' => false],
                    ['days' => '30 Day', 'price' => 99, 'original' => 149, 'popular' => true],
                    ['days' => '60 Day', 'price' => 189, 'original' => 270, 'popular' => false],
                ]
            ],
            'hindu' => [
                'name' => 'Prime Hindu Video',
                'badge' => 'Prime',
                'color_gradient' => 'from-[#0d213b] to-[#123e6f]',
                'accent' => '#0284c7',
                'description' => 'สัมผัสประสบการณ์ความบันเทิงระดับโลก ซีรีส์ Original ยอดฮิต สตรีมได้ทุกที่ทุกเวลาบนทุกอุปกรณ์',
                'image' => '/images/hindu.png',
                'packages' => [
                    ['days' => '1 Day', 'price' => 15, 'original' => 20, 'popular' => false],
                    ['days' => '14 Day', 'price' => 40, 'original' => 55, 'popular' => false],
                    ['days' => '30 Day', 'price' => 70, 'original' => 99, 'popular' => true],
                    ['days' => '60 Day', 'price' => 130, 'original' => 180, 'popular' => false],
                ]
            ]
        ];

        $currentPlatform = $platformsData[$platformKey] ?? $platformsData['hiv'];
    @endphp

<<<<<<< HEAD
    <x-navbar active="product-info"></x-navbar>
=======
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
                    <a href="/products" class="flex items-center gap-2 bg-[#333333] px-5 py-2 rounded-full text-sm text-white shadow-inner">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        สินค้าทั้งหมด
                    </a>
                    <a href="/cart" class="flex items-center gap-2 px-5 py-2 rounded-full text-sm text-gray-300 hover:text-white transition hover:bg-gray-800/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        ตะกร้า
                    </a>
                </div>
            </div>

            <!-- Profile / Actions -->
            <div class="flex items-center gap-4">
                <div class="bg-gray-800/90 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2 border border-gray-700/80 shadow">
                    <span class="w-5 h-5 bg-gradient-to-tr from-yellow-500 to-amber-300 rounded-full flex items-center justify-center text-black font-extrabold text-xs shadow-sm">฿</span>
                    <span class="font-bold text-gray-100">100.00</span>
                </div>
                <a href="/profile" class="w-10 h-10 bg-[#00fff2] rounded-full flex items-center justify-center text-black font-bold shadow-md hover:scale-105 transition" title="โปรไฟล์">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </a>
            </div>
        </nav>
    </header>
>>>>>>> origin/Woonsen

    <!-- Platform Selector Bar -->
    <div class="max-w-[1240px] mx-auto px-6 mt-8">
        <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none">
            <a href="/products" class="text-sm font-semibold text-gray-400 hover:text-white transition flex items-center gap-1.5 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                ย้อนกลับ
            </a>
            <span class="text-gray-600">|</span>
            @foreach ($platformsData as $k => $p)
                <a href="/product-info?platform={{ $k }}" 
                   class="px-5 py-2 rounded-full text-sm font-bold transition shrink-0 {{ $platformKey === $k ? 'bg-[#00fff2] text-black shadow-lg shadow-cyan-500/25' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                    {{ $p['name'] }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Platform Hero Section -->
    <main class="max-w-[1240px] mx-auto px-6 mt-6">
        
        <!-- Platform Header Card -->
        <div class="bg-gradient-to-r {{ $currentPlatform['color_gradient'] }} rounded-[28px] p-8 md:p-10 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8 border border-white/10">
            <div class="space-y-4 max-w-xl z-10 text-center md:text-left">
                <div class="inline-flex items-center gap-2 bg-black/40 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-bold text-cyan-300 border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-[#00fff2] animate-pulse"></span>
                    พร้อมจัดส่งอัตโนมัติ 24 ชม.
                </div>
                <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight">
                    {{ $currentPlatform['name'] }}
                </h1>
                <p class="text-gray-200 text-sm md:text-base leading-relaxed opacity-90">
                    {{ $currentPlatform['description'] }}
                </p>
            </div>
            
            <div class="w-44 h-44 md:w-56 md:h-56 shrink-0 relative flex items-center justify-center">
                <div class="w-36 h-36 md:w-44 md:h-44 rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl flex items-center justify-center overflow-hidden">
                    <img src="{{ $currentPlatform['image'] }}" alt="{{ $currentPlatform['name'] }}" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <!-- Section: Package Options matching Figma #11:128 -->
        <div class="mt-12">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-white">เลือกแพ็กเกจการใช้งาน</h2>
                    <p class="text-sm text-gray-400 mt-1">เลือกจำนวนวันที่ต้องการ สั่งซื้อง่าย รับสิทธิ์ดูได้ทันที</p>
                </div>
            </div>

            <!-- Cards Grid: 1 Day, 14 Day, 30 Day, 60 Day -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($currentPlatform['packages'] as $pkg)
                <div class="bg-white text-black rounded-[24px] p-6 flex flex-col justify-between shadow-xl hover:shadow-2xl hover:scale-[1.02] transition duration-300 relative border border-gray-100">
                    
                    @if ($pkg['popular'])
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[#00fff2] text-black font-extrabold text-xs px-4 py-1 rounded-full shadow-md uppercase tracking-wider">
                        ยอดนิยม 🔥
                    </div>
                    @endif

                    <div>
                        <!-- Header / Days -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-black text-gray-900">{{ $pkg['days'] }}</span>
                            <span class="text-xs font-semibold px-2.5 py-1 bg-gray-100 rounded-full text-gray-600">VIP</span>
                        </div>

                        <!-- Price -->
                        <div class="mb-6">
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-black text-gray-900">{{ $pkg['price'] }}</span>
                                <span class="text-base font-bold text-gray-600">บาท</span>
                            </div>
                            <span class="text-xs text-gray-400 line-through">ปกติ {{ $pkg['original'] }} บาท</span>
                        </div>

                        <!-- Features List -->
                        <ul class="space-y-2.5 text-xs text-gray-600 mb-8 border-t border-gray-100 pt-4">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                ดูได้ไม่มีโฆษณาคั่น
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                ความละเอียดสูงสุด 4K UHD
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                รับประกันตลอดอายุแพ็กเกจ
                            </li>
                        </ul>
                    </div>

                    <!-- Add to Cart Button matching Figma Cyan Rectangle (#11:128) -->
                    <button onclick="addToCart('{{ $currentPlatform['name'] }}', '{{ $pkg['days'] }}', {{ $pkg['price'] }})" 
                            class="w-full bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold py-3.5 rounded-full transition shadow-md shadow-cyan-500/20 flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        เพิ่มลงตะกร้า
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Section: App Details & How to Install matching Figma #11:128 Rectangle 76 -->
        <div class="mt-14 bg-[#202020] rounded-[24px] p-8 md:p-10 border border-gray-800 shadow-xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-[#00fff2]/10 border border-[#00fff2]/30 flex items-center justify-center text-[#00fff2]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">รายละเอียดและวิธีการใช้งานแอปพลิเคชัน (Detail App)</h3>
                    <p class="text-xs text-gray-400">คำแนะนำการดาวน์โหลด การเข้าสู่ระบบ และการรับประกัน</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-300">
                <div class="bg-[#171717] p-5 rounded-2xl border border-gray-800/80">
                    <h4 class="font-bold text-white flex items-center gap-2 mb-2">
                        <span class="w-6 h-6 rounded-full bg-cyan-900/50 text-[#00fff2] flex items-center justify-center text-xs font-bold">1</span>
                        โหลดได้ที่ไหน?
                    </h4>
                    <p class="text-gray-400 text-xs leading-relaxed">
                        สามารถดาวน์โหลดแอปพลิเคชันได้จาก Google Play Store, Apple App Store, หรือ Smart TV App Store ค้นหาตามชื่อแอปพลิเคชันได้โดยตรง
                    </p>
                </div>

                <div class="bg-[#171717] p-5 rounded-2xl border border-gray-800/80">
                    <h4 class="font-bold text-white flex items-center gap-2 mb-2">
                        <span class="w-6 h-6 rounded-full bg-cyan-900/50 text-[#00fff2] flex items-center justify-center text-xs font-bold">2</span>
                        วิธีรับรหัสเข้าสู่ระบบ
                    </h4>
                    <p class="text-gray-400 text-xs leading-relaxed">
                        เมื่อชำระเงินสำเร็จ สามารถดูบัญชีและรหัสผ่านได้ทันทีที่หน้า "ประวัติการซื้อ" และระบบจะส่งข้อมูลไปยังอีเมลของคุณโดยอัตโนมัติ
                    </p>
                </div>

                <div class="bg-[#171717] p-5 rounded-2xl border border-gray-800/80">
                    <h4 class="font-bold text-white flex items-center gap-2 mb-2">
                        <span class="w-6 h-6 rounded-full bg-cyan-900/50 text-[#00fff2] flex items-center justify-center text-xs font-bold">3</span>
                        การรับประกัน & ซัพพอร์ต
                    </h4>
                    <p class="text-gray-400 text-xs leading-relaxed">
                        รับประกันเปลี่ยนแอคเคาท์ใหม่ทันทีหากพบปัญหาตลอดระยะเวลาการใช้งาน ทีมงานพร้อมให้บริการทุกวัน เวลา 09:00 - 24:00 น.
                    </p>
                </div>
            </div>
        </div>

    </main>

    <!-- Toast Notification for Add to Cart -->
    <div id="cart-toast" class="fixed bottom-6 right-6 z-50 transform translate-y-32 opacity-0 transition-all duration-300 flex items-center gap-4 bg-gray-900 text-white px-6 py-4 rounded-2xl shadow-2xl border border-[#00fff2]/50">
        <div class="w-8 h-8 rounded-full bg-[#00fff2] text-black flex items-center justify-center font-bold">✓</div>
        <div>
            <div class="font-bold text-sm text-white" id="toast-title">เพิ่มลงตะกร้าสำเร็จ!</div>
            <div class="text-xs text-gray-400" id="toast-subtitle">คุณสามารถตรวจสอบสินค้าได้ที่ตะกร้า</div>
        </div>
        <a href="/cart" class="bg-[#00fff2] text-black text-xs font-bold px-4 py-2 rounded-xl hover:bg-cyan-300 transition">
            ไปที่ตะกร้า
        </a>
    </div>

    <script>
        function addToCart(platform, days, price) {
            const toast = document.getElementById('cart-toast');
            document.getElementById('toast-title').textContent = `เพิ่ม ${platform} (${days}) แล้ว!`;
            document.getElementById('toast-subtitle').textContent = `ราคา ${price} บาท ถูกเพิ่มไปยังตะกร้าสินค้า`;
            
            toast.classList.remove('translate-y-32', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
            
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-32', 'opacity-0');
            }, 4000);
        }
    </script>
</body>
</html>
