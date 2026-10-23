<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HD Harmdung</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <style>
        .top5-swiper {
            overflow: visible !important; 
        }
        .swiper-slide {
            transition: all 0.4s ease;
            opacity: 0.45;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .swiper-slide-active {
            opacity: 1;
            z-index: 10;
        }
        .swiper-slide > a, .swiper-slide > div {
            transition: all 0.4s ease;
            transform: scale(0.88);
            border-radius: 1.5rem !important;
        }
        .swiper-slide-active > a, .swiper-slide-active > div {
            transform: scale(1.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8), 0 0 30px rgba(0, 255, 242, 0.15); 
        }
        .swiper-button-next::after, .swiper-button-prev::after {
            font-size: 2rem !important;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-[#171717] text-white font-sans antialiased min-h-screen pb-16 selection:bg-[#00fff2] selection:text-black">

    <x-navbar active="home"></x-navbar>

    <!-- ช่องค้นหา (Search Bar) matching Figma #5:2 Group 1 -->
    <div class="mt-8 w-full max-w-2xl mx-auto px-4">
        <div class="relative">
            <input type="text" placeholder="ค้นหาหนัง หรือ แฟลตฟอร์ม" 
                   class="w-full bg-white text-black pl-6 pr-12 py-3 rounded-full outline-none focus:ring-2 focus:ring-[#00fff2] placeholder-gray-400 shadow-lg text-sm">
            <button class="absolute right-4 top-1/2 -translate-y-1/2 text-black">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </div>
    </div>

    <!-- ส่วนไฮไลท์ (Hero Carousel TOP 5) matching Figma #5:2 -->
    <div class="mt-8 max-w-[1300px] mx-auto px-6">
        <div class="flex items-center gap-3 px-6 mb-2">
            <span class="text-2xl font-black text-white tracking-wide">TOP 5</span>
            <span class="text-xs font-bold text-[#00fff2] bg-cyan-950/80 px-3 py-1 rounded-full border border-cyan-800">ยอดนิยมประจำสัปดาห์</span>
        </div>

        <div class="relative w-full group">
            <div class="swiper top5-swiper py-8">
                <div class="swiper-wrapper">
                    @php
                        $topMovies = [
                            ['title' => 'Inception (จิตพิฆาตโลก)', 'tag' => 'Sci-Fi / Action', 'rating' => '4.9', 'gradient' => 'from-indigo-900 via-slate-900 to-black', 'platforms' => ['D', 'N']],
                            ['title' => 'Interstellar (ทะยานดาวกู้โลก)', 'tag' => 'Sci-Fi / Drama', 'rating' => '4.9', 'gradient' => 'from-blue-950 via-gray-900 to-black', 'platforms' => ['N', 'P']],
                            ['title' => 'Oppenheimer (ออปเพนไฮเมอร์)', 'tag' => 'Biography / History', 'rating' => '4.8', 'gradient' => 'from-amber-950 via-zinc-900 to-black', 'platforms' => ['H', 'N']],
                            ['title' => 'Avatar: The Way of Water', 'tag' => 'Adventure / Fantasy', 'rating' => '4.7', 'gradient' => 'from-cyan-950 via-teal-950 to-black', 'platforms' => ['D']],
                            ['title' => 'The Dark Knight (อัศวินรัตติกาล)', 'tag' => 'Action / Crime', 'rating' => '4.9', 'gradient' => 'from-slate-900 via-neutral-900 to-black', 'platforms' => ['H', 'N']],
                        ];
                    @endphp

                    @foreach ($topMovies as $i => $movie)
                    <div class="swiper-slide cursor-pointer">
                        <a href="/movie-details" class="w-full aspect-[21/9] bg-gradient-to-r {{ $movie['gradient'] }} rounded-2xl flex flex-col justify-end p-6 md:p-8 shadow-2xl relative overflow-hidden group border border-white/10 block">
                            <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition"></div>
                            
                            <div class="relative z-10 flex items-end justify-between">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="w-7 h-7 bg-[#00fff2] text-black font-black rounded-lg text-sm flex items-center justify-center shadow">
                                            #{{ $i + 1 }}
                                        </span>
                                        <span class="text-xs font-semibold text-gray-300">{{ $movie['tag'] }}</span>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-black text-white drop-shadow-md">{{ $movie['title'] }}</h3>
                                </div>
                                <div class="bg-black/60 backdrop-blur-md px-3.5 py-1.5 rounded-xl border border-white/10 text-yellow-400 font-bold text-sm flex items-center gap-1">
                                    ★ {{ $movie['rating'] }}
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- ปุ่มเลื่อนซ้าย/ขวา -->
            <div class="swiper-button-prev !text-white hover:!text-[#00fff2] transition !left-0"></div>
            <div class="swiper-button-next !text-white hover:!text-[#00fff2] transition !right-0"></div>
        </div>
    </div>

    <!-- ส่วนหมวดหมู่ (Category / Genre) matching Figma #5:2 -->
    <div class="mt-14 px-8 max-w-[1300px] mx-auto">
        <h2 class="text-2xl font-black mb-8 text-white flex items-center gap-3">
            <span>หมวดหมู่ / Genre</span>
        </h2>

        @php
            $genres = [
                ['name' => 'ดราม่า / Drama', 'movies' => ['The Shawshank Redemption', 'Forrest Gump', 'Parasite', 'Fight Club', 'Whiplash']],
                ['name' => 'โรแมนติก / Romantic', 'movies' => ['La La Land', 'About Time', 'Titanic', 'Pride & Prejudice', 'Before Sunrise']],
                ['name' => 'สยองขวัญ / Horror', 'movies' => ['The Conjuring', 'Hereditary', 'A Quiet Place', 'IT', 'Insidious']],
                ['name' => 'แอคชัน / Action', 'movies' => ['John Wick: Chapter 4', 'Top Gun: Maverick', 'Mad Max: Fury Road', 'The Matrix', 'Gladiator']]
            ];
        @endphp

        @foreach ($genres as $genre)
        <div class="mb-12">
            <h3 class="text-lg font-bold text-gray-200 mb-4 flex items-center justify-between">
                <span>{{ $genre['name'] }}</span>
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5">
                @foreach ($genre['movies'] as $mTitle)
                <a href="/movie-details" class="flex flex-col cursor-pointer group hover:scale-[1.03] transition duration-300">
                    <div class="w-full aspect-[16/10] bg-gradient-to-tr from-gray-900 to-gray-800 rounded-2xl mb-2.5 shadow-lg overflow-hidden relative border border-gray-800 group-hover:border-[#00fff2]/50 transition flex items-center justify-center p-4">
                        <div class="text-center">
                            <span class="text-xs font-bold text-gray-200 line-clamp-1">{{ $mTitle }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-gray-400">
                        <span class="text-[11px]">รับชมได้ที่</span>
                        <div class="w-4 h-4 bg-[#1434A4] rounded text-[9px] flex items-center justify-center text-white font-bold" title="Disney+">D</div>
                        <div class="w-4 h-4 bg-[#E50914] rounded text-[9px] flex items-center justify-center text-white font-bold" title="Netflix">N</div>
                        <div class="w-4 h-4 bg-[#5a1bb9] rounded text-[9px] flex items-center justify-center text-white font-bold" title="HIV min">H</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <!-- นำเข้า Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.top5-swiper', {
                slidesPerView: 2,       
                centeredSlides: true,   
                slideToClickedSlide: true, 
                spaceBetween: 24,
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