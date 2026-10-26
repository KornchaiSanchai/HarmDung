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
                    @forelse ($topMovies as $i => $movie)
                    <div class="swiper-slide cursor-pointer">
                        <a href="{{ route('movie-details', ['id' => $movie->id]) }}" class="w-full aspect-[21/9] bg-gradient-to-r from-slate-900 via-neutral-900 to-black rounded-2xl flex items-end p-6 md:p-8 shadow-2xl relative overflow-hidden group border border-white/10 block">
                            @if ($movie->poster_url)
                                {{-- พื้นหลังเบลอจากโปสเตอร์ --}}
                                <img src="{{ $movie->poster_url }}" alt="" aria-hidden="true" loading="lazy"
                                     class="absolute inset-0 w-full h-full object-cover scale-110 blur-md opacity-60">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/50 to-black/20 group-hover:from-black/80 transition"></div>

                            <div class="relative z-10 flex items-end gap-5 w-full">
                                @if ($movie->poster_url)
                                    <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" loading="lazy"
                                         class="hidden sm:block h-40 md:h-48 aspect-[2/3] object-cover rounded-xl shadow-2xl border border-white/10">
                                @endif

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="w-7 h-7 bg-[#00fff2] text-black font-black rounded-lg text-sm flex items-center justify-center shadow">
                                            #{{ $i + 1 }}
                                        </span>
                                        <span class="text-xs font-semibold text-gray-300 truncate">
                                            {{ $movie->genres->pluck('name')->take(2)->implode(' / ') }}
                                            @if ($movie->release_year) · {{ $movie->release_year }} @endif
                                        </span>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-black text-white drop-shadow-md line-clamp-1">{{ $movie->title }}</h3>
                                    @if ($movie->platforms->isNotEmpty())
                                        <div class="flex items-center gap-1.5 mt-3">
                                            @foreach ($movie->platforms as $platform)
                                                @include('partials.platform-badge', ['platform' => $platform, 'size' => 'w-6 h-6'])
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="bg-black/60 backdrop-blur-md px-3.5 py-1.5 rounded-xl border border-white/10 text-yellow-400 font-bold text-sm flex items-center gap-1 shrink-0">
                                    ★ {{ $movie->reviews_count ? number_format($movie->reviews_avg_rating, 1) : '-' }}
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="swiper-slide">
                        <div class="w-full aspect-[21/9] rounded-2xl flex items-center justify-center bg-neutral-900 border border-white/10 text-gray-400">
                            ยังไม่มีข้อมูลหนัง — รัน <code class="mx-1 text-[#00fff2]">php artisan db:seed</code> ก่อน
                        </div>
                    </div>
                    @endforelse
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

        @forelse ($genres as $genre)
        <div class="mb-12">
            <h3 class="text-lg font-bold text-gray-200 mb-4 flex items-center justify-between">
                <span>{{ $genre->label }}</span>
                <span class="text-xs font-semibold text-gray-500">{{ $genre->movies_count }} เรื่อง</span>
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5">
                @foreach ($genre->movies as $movie)
                <a href="{{ route('movie-details', ['id' => $movie->id]) }}" class="flex flex-col cursor-pointer group hover:scale-[1.03] transition duration-300">
                    <div class="w-full aspect-[2/3] bg-gradient-to-tr from-gray-900 to-gray-800 rounded-2xl mb-2.5 shadow-lg overflow-hidden relative border border-gray-800 group-hover:border-[#00fff2]/50 transition flex items-center justify-center">
                        @if ($movie->poster_url)
                            <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" loading="lazy" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <span class="text-xs font-bold text-gray-200 line-clamp-2 text-center p-4">{{ $movie->title }}</span>
                        @endif
                        @if ($movie->reviews_count)
                            <span class="absolute top-2 right-2 bg-black/70 backdrop-blur px-2 py-0.5 rounded-lg text-[11px] font-bold text-yellow-400">
                                ★ {{ number_format($movie->reviews_avg_rating, 1) }}
                            </span>
                        @endif
                    </div>
                    <span class="text-sm font-bold text-gray-200 line-clamp-1 mb-1" title="{{ $movie->title }}">{{ $movie->title }}</span>
                    @if ($movie->platforms->isNotEmpty())
                        <div class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 flex-wrap">
                            <span class="text-[11px]">รับชมได้ที่</span>
                            @foreach ($movie->platforms as $platform)
                                @include('partials.platform-badge', ['platform' => $platform, 'size' => 'w-4 h-4'])
                            @endforeach
                        </div>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
        @empty
        <p class="text-gray-400">ยังไม่มีข้อมูลหมวดหมู่</p>
        @endforelse
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