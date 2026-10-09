<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HD Harmdung</title>
    
    <!-- นำเข้าฟอนต์ Noto Sans Thai -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- นำเข้า Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- สไตล์ปรับแต่ง Slide ให้ตรงกลางสว่าง และด้านข้างจาง/เล็กลง -->
    <style>
        /* 1. ปลดล็อกไม่ให้ Swiper ตัดขอบกล่องที่ขยายใหญ่ */
        .top5-swiper {
            overflow: visible !important; 
        }
        
        /* 2. จัดการกล่องรอบนอก (ตัวสไลด์) */
        .swiper-slide {
            transition: all 0.4s ease;
            opacity: 0.4;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .swiper-slide-active {
            opacity: 1;
            z-index: 10;
        }

        /* 3. จัดการกล่องด้านใน (ให้ย่อ/ขยาย และบังคับขอบโค้ง) */
        .swiper-slide > div {
            transition: all 0.4s ease;
            transform: scale(0.85); /* รูปด้านข้างย่อลง */
            border-radius: 1.5rem !important; /* บังคับให้ขอบโค้งเสมอ */
        }
        .swiper-slide-active > div {
            transform: scale(1.15); /* รูปตรงกลางขยายใหญ่ */
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7); 
        }

        /* 4. ปรับขนาดและสีลูกศร */
        .swiper-button-next::after, .swiper-button-prev::after {
            font-size: 2.5rem !important;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-brand-dark text-white font-sans antialiased min-h-screen pb-10">

    <!-- แถบนำทาง (Navbar) -->
    <nav class="flex items-center justify-between px-8 py-4 border-b border-gray-800">
        <div class="flex items-center gap-8">
            
            <!-- เปลี่ยนโลโก้เป็นรูปภาพ -->
            <a href="/" class="flex items-center shrink-0">
                <!-- เปลี่ยนชื่อไฟล์ logo.png เป็นชื่อไฟล์จริงของคุณได้เลย -->
                <img src="/images/logo.png" alt="HD Harmdung" class="h-10 w-auto object-contain scale-150 origin-left">
            </a>
            
            <!-- เมนู -->
            <div class="flex items-center gap-2">
                <a href="/" class="flex items-center gap-2 bg-gray-700/80 px-5 py-2 rounded-full text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    หน้าแรก
                </a>
                <a href="/products" class="flex items-center gap-2 px-5 py-2 text-sm text-gray-300 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    สินค้าทั้งหมด
                </a>
            </div>
        </div>

        <!-- ปุ่มเข้าสู่ระบบ / สมัครสมาชิก -->
        <div class="flex items-center gap-4 text-sm font-semibold">
            <a href="/login" class="bg-white text-black px-6 py-2 rounded-lg hover:bg-gray-200 transition">เข้าสู่ระบบ</a>
            <a href="/register" class="bg-brand-cyan text-black px-6 py-2 rounded-lg hover:bg-cyan-300 transition">สมัครสมาชิก</a>
        </div>
    </nav>

    <!-- ช่องค้นหา (Search Bar) -->
    <div class="mt-8 w-full max-w-2xl mx-auto px-4">
        <div class="relative">
            <input type="text" placeholder="ค้นหาหนัง หรือ แฟลตฟอร์ม" 
                   class="w-full bg-white text-black pl-6 pr-12 py-2.5 rounded-full outline-none focus:ring-2 focus:ring-brand-cyan placeholder-gray-400">
            <button class="absolute right-4 top-1/2 -translate-y-1/2 text-black">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </div>
    </div>

    <!-- ส่วนไฮไลท์ (Hero Carousel TOP 5) แบบใช้ Swiper -->
    <div class="mt-10 relative w-full max-w-[1200px] mx-auto px-12 group">
        <!-- ตัวบรรจุ Slider -->
        <div class="swiper top5-swiper py-10">
            <div class="swiper-wrapper">
                @for ($i = 1; $i <= 5; $i++)
                <div class="swiper-slide cursor-pointer">
                    <div class="w-full aspect-video bg-gray-300 rounded-xl flex items-center justify-center shadow-2xl">
                        <span class="text-3xl font-bold text-gray-500">หนังเรื่องที่ {{ $i }}</span>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- ปุ่มเลื่อนซ้าย/ขวา -->
        <div class="swiper-button-prev !text-white hover:!text-brand-cyan transition !left-0"></div>
        <div class="swiper-button-next !text-white hover:!text-brand-cyan transition !right-0"></div>
    </div>

    <!-- ส่วนหมวดหมู่ (Category / Genre) -->
    <div class="mt-16 px-12 max-w-[1400px] mx-auto">
        <h2 class="text-xl font-bold mb-6">หมวดหมู่ / Genre</h2>

        @php
            $genres = [
                'ดราม่า / Drama',
                'โรแมนติก / Romantic',
                'สยองขวัญ / Horror',
                'แอคชัน / Action'
            ];
        @endphp

        @foreach ($genres as $genre)
        <div class="mb-10">
            <h3 class="text-lg font-semibold text-gray-300 mb-4">{{ $genre }}</h3>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @for ($i = 1; $i <= 5; $i++)
                <div class="flex flex-col cursor-pointer hover:scale-105 transition duration-300">
                    <!-- ปรับกรอบให้สั้นลงโดยใช้ aspect-video (แนวนอน 16:9) หรือถ้าอยากให้จัตุรัสขึ้นให้ใช้ aspect-[4/3] -->
                    <div class="w-full aspect-video bg-gray-300 rounded-lg mb-2 shadow-md"></div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-gray-300 mt-1">
                        <span>รับชมได้ที่</span>
                        <div class="w-4 h-4 bg-[#1434A4] rounded text-[8px] flex items-center justify-center text-white">D</div>
                        <div class="w-4 h-4 bg-[#E50914] rounded text-[8px] flex items-center justify-center text-white">N</div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        @endforeach
    </div>

    <!-- 2. นำเข้า Swiper JS และเขียนสคริปต์สั่งงาน -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.top5-swiper', {
                slidesPerView: 2,       
                centeredSlides: true,   
                slideToClickedSlide: true, 
                spaceBetween: 20,        /* ปรับตรงนี้เพื่อไม่ให้รูปซ้อนกันมากไปตอนเด้ง */
                loop: true,             
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
</body>
</html>