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
        .genre-arrow-prev, .genre-arrow-next {
            position: absolute;
            top: 45%;
            transform: translateY(-50%);
            z-index: 20;
            width: 32px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            cursor: pointer;
            transition: color 0.25s ease, opacity 0.25s ease, transform 0.25s ease;
            border: none;
            background: #000000ff;
            padding: 0;
        }
        .genre-arrow-prev {
            left: 0;
        }
        .genre-arrow-next {
            right: 0;
        }
        .genre-arrow-prev:hover, .genre-arrow-next:hover {
            color: #00fff2;
            transform: translateY(-50%) scale(1.18);
        }
        .genre-arrow-prev::after {
            content: 'prev';
            font-family: swiper-icons;
            font-size: 1.35rem;
            font-weight: bold;
        }
        .genre-arrow-next::after {
            content: 'next';
            font-family: swiper-icons;
            font-size: 1.35rem;
            font-weight: bold;
        }
        .genre-arrow-prev:disabled, .genre-arrow-next:disabled {
            opacity: 0 !important;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-[#171717] text-white font-sans antialiased min-h-screen pb-16 selection:bg-[#00fff2] selection:text-black">

    <x-navbar active="home"></x-navbar>

    <!-- ช่องค้นหา (Search Bar) matching Figma #5:2 Group 1 -->
    <div class="mt-8 w-full max-w-2xl mx-auto px-4 relative z-40">
        <form action="{{ route('home') }}" method="GET" id="searchForm" class="relative">
            <input type="text" name="search" id="searchInput" value="{{ $search ?? '' }}" placeholder="ค้นหาชื่อหนัง, เรื่องย่อ, แนวหนัง..." autocomplete="off"
                   class="w-full bg-white text-black pl-6 pr-20 py-3.5 rounded-full outline-none focus:ring-2 focus:ring-[#00fff2] placeholder-gray-500 shadow-xl text-sm font-medium transition">
            
            <div class="absolute right-3.5 top-1/2 -translate-y-1/2 flex items-center gap-1">
                @if(!empty($search))
                    <a href="{{ route('home') }}" class="text-gray-400 hover:text-black p-1 transition" title="ล้างการค้นหา">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
                <button type="submit" class="text-black hover:text-[#00c8be] p-1.5 transition cursor-pointer" title="ค้นหา">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
        </form>

        <!-- Live Search Dropdown Suggestions -->
        <div id="searchDropdown" class="absolute left-4 right-4 top-full mt-2 bg-[#1c1c1c]/95 border border-gray-700/80 rounded-2xl shadow-2xl overflow-hidden backdrop-blur-md hidden divide-y divide-gray-800/80 max-h-96 overflow-y-auto z-50"></div>
    </div>

    <!-- ส่วนแสดงผลการค้นหา (Search Results) -->
    @if ($searchResults !== null)
    <div class="mt-10 max-w-[1300px] mx-auto px-6" id="search-results">
        <div class="bg-gray-900/60 border border-gray-800 rounded-3xl p-6 sm:p-8 shadow-2xl backdrop-blur-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-800">
                <div>
                    <h2 class="text-2xl font-black text-white flex items-center gap-2 flex-wrap">
                        <span>ผลการค้นหาหนัง:</span>
                        <span class="text-[#00fff2]">"{{ $search }}"</span>
                    </h2>
                    <p class="text-xs text-gray-400 mt-1">พบทั้งหมด {{ $searchResults->count() }} เรื่อง</p>
                </div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-300 hover:text-white bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-full border border-gray-700 transition shrink-0 self-start sm:self-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span>ล้างการค้นหา</span>
                </a>
            </div>

            @if ($searchResults->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                    @foreach ($searchResults as $movie)
                    <a href="{{ route('movie-details', ['id' => $movie->id]) }}" class="flex flex-col cursor-pointer group hover:scale-[1.03] transition duration-300">
                        <div class="w-full aspect-[2/3] bg-gradient-to-tr from-gray-900 to-gray-800 rounded-2xl mb-2.5 shadow-lg overflow-hidden relative border border-gray-800 group-hover:border-[#00fff2]/50 transition flex items-center justify-center">
                            @if ($movie->poster_url)
                                <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" loading="lazy" class="absolute inset-0 w-full h-full object-cover">
                            @else
                                <span class="text-xs font-bold text-gray-200 line-clamp-2 text-center p-4">{{ $movie->title }}</span>
                            @endif
                            @if ($movie->reviews_count)
                                <span class="absolute top-2 right-2 bg-black/75 backdrop-blur px-2 py-0.5 rounded-lg text-[11px] font-bold text-yellow-400 border border-white/10">
                                    ★ {{ number_format($movie->reviews_avg_rating, 1) }}
                                </span>
                            @endif
                        </div>
                        <span class="text-sm font-bold text-gray-200 line-clamp-1 mb-1 group-hover:text-[#00fff2] transition" title="{{ $movie->title }}">{{ $movie->title }}</span>
                        @if ($movie->platforms->isNotEmpty())
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 flex-wrap">
                                <span class="text-[11px]">รับชมได้ที่</span>
                                @foreach ($movie->platforms as $platform)
                                    @include('partials.platform-badge', ['platform' => $platform, 'size' => 'w-5 h-5'])
                                @endforeach
                            </div>
                        @endif
                    </a>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center text-gray-400">
                    <p class="text-base font-bold text-gray-200">ไม่พบหนังที่ตรงกับ "{{ $search }}"</p>
                    <p class="text-xs text-gray-500 mt-1">ลองค้นหาด้วยชื่อภาษาอังกฤษ หรือค้นหาตามแนวหนัง เช่น Action, Disney, Avatar</p>
                    <a href="{{ route('home') }}" class="inline-block mt-4 bg-[#00fff2] text-black font-extrabold text-xs px-6 py-2.5 rounded-full hover:bg-cyan-300 transition shadow-lg shadow-cyan-500/20">
                        ดูหนังทั้งหมด
                    </a>
                </div>
            @endif
        </div>
    </div>
    @endif

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

    <!-- ส่วนหมวดหมู่ (Category / Genre) พร้อมลูกศรเลื่อนดูหนังอื่นๆ ในหมวดหมู่ -->
    <div class="mt-14 px-8 max-w-[1300px] mx-auto">
        <h2 class="text-2xl font-black mb-8 text-white flex items-center gap-3">
            <span>หมวดหมู่ / Genre</span>
        </h2>

        @forelse ($genres as $genre)
        <div class="mb-14 genre-row group/genre relative">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg md:text-xl font-bold text-gray-200 flex items-center gap-2.5">
                    <span class="w-2 h-5 bg-[#00fff2] rounded-full inline-block"></span>
                    <span>{{ $genre->label }}</span>
                </h3>
            </div>

            <!-- แถบเลื่อนแสดงหนัง -->
            <div class="relative group/genre-slider">
                <!-- ปุ่มเลื่อนซ้าย สไตล์เดียวกับ Top 5 ครอบซ้ายสุดของหนังเรื่องแรก -->
                <button type="button" class="genre-arrow-prev" title="ดูหนังก่อนหน้า"></button>

                <!-- Track หนังเลื่อนแนวนอน -->
                <div class="genre-slider flex gap-5 overflow-x-auto scroll-smooth py-3 px-1 scrollbar-none" style="scrollbar-width: none; -ms-overflow-style: none;">
                    @foreach ($genre->movies as $movie)
                    <div class="w-[165px] sm:w-[190px] md:w-[210px] shrink-0">
                        <a href="{{ route('movie-details', ['id' => $movie->id]) }}" class="flex flex-col cursor-pointer group/card hover:scale-[1.04] transition duration-300 h-full">
                            <div class="w-full aspect-[2/3] bg-gradient-to-tr from-gray-900 to-gray-800 rounded-2xl mb-2.5 shadow-lg overflow-hidden relative border border-gray-800 group-hover/card:border-[#00fff2]/50 group-hover/card:shadow-cyan-500/10 transition flex items-center justify-center">
                                @if ($movie->poster_url)
                                    <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" loading="lazy" class="absolute inset-0 w-full h-full object-cover">
                                @else
                                    <span class="text-xs font-bold text-gray-200 line-clamp-2 text-center p-4">{{ $movie->title }}</span>
                                @endif
                                @if ($movie->reviews_count)
                                    <span class="absolute top-2 right-2 bg-black/75 backdrop-blur px-2 py-0.5 rounded-lg text-[11px] font-bold text-yellow-400 border border-white/10">
                                        ★ {{ number_format($movie->reviews_avg_rating, 1) }}
                                    </span>
                                @endif
                            </div>
                            <span class="text-sm font-bold text-gray-200 line-clamp-1 mb-1 group-hover/card:text-[#00fff2] transition" title="{{ $movie->title }}">{{ $movie->title }}</span>
                            @if ($movie->platforms->isNotEmpty())
                                <div class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 flex-wrap mt-auto">
                                    <span class="text-[11px]">รับชมได้ที่</span>
                                    @foreach ($movie->platforms as $platform)
                                        @include('partials.platform-badge', ['platform' => $platform, 'size' => 'w-5 h-5'])
                                    @endforeach
                                </div>
                            @endif
                        </a>
                    </div>
                    @endforeach
                </div>

                <!-- ปุ่มเลื่อนขวา สไตล์เดียวกับ Top 5 ครอบขวาสุดของหนังเรื่องสุดท้าย -->
                <button type="button" class="genre-arrow-next" title="ดูหนังถัดไปในหมวดนี้"></button>
            </div>
        </div>
        @empty
        <p class="text-gray-400">ยังไม่มีข้อมูลหมวดหมู่</p>
        @endforelse
    </div>
    <x-footer></x-footer>

    <!-- นำเข้า Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Swiper TOP 5
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

            // 2. Genre Row Carousel Arrows
            document.querySelectorAll('.genre-row').forEach(row => {
                const slider = row.querySelector('.genre-slider');
                if (!slider) return;

                const prevBtns = row.querySelectorAll('.genre-arrow-prev');
                const nextBtns = row.querySelectorAll('.genre-arrow-next');

                const updateArrowState = () => {
                    const canPrev = slider.scrollLeft > 15;
                    const canNext = slider.scrollLeft < (slider.scrollWidth - slider.clientWidth - 15);
                    prevBtns.forEach(btn => {
                        btn.disabled = !canPrev;
                        btn.classList.toggle('opacity-0', !canPrev);
                        btn.classList.toggle('pointer-events-none', !canPrev);
                    });
                    nextBtns.forEach(btn => {
                        btn.disabled = !canNext;
                        btn.classList.toggle('opacity-0', !canNext);
                        btn.classList.toggle('pointer-events-none', !canNext);
                    });
                };

                prevBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const scrollAmount = Math.max(slider.clientWidth * 0.75, 280);
                        slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                    });
                });

                nextBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const scrollAmount = Math.max(slider.clientWidth * 0.75, 280);
                        slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                    });
                });

                slider.addEventListener('scroll', updateArrowState, { passive: true });
                updateArrowState();
                window.addEventListener('resize', updateArrowState);
            });

            // 3. Live Search Autocomplete
            const searchInput = document.getElementById('searchInput');
            const searchDropdown = document.getElementById('searchDropdown');
            let debounceTimer = null;

            if (searchInput && searchDropdown) {
                searchInput.addEventListener('input', function () {
                    const query = this.value.trim();
                    clearTimeout(debounceTimer);

                    if (query.length < 2) {
                        searchDropdown.classList.add('hidden');
                        searchDropdown.innerHTML = '';
                        return;
                    }

                    debounceTimer = setTimeout(async () => {
                        try {
                            const res = await fetch(`/home?search=${encodeURIComponent(query)}`, {
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });
                            if (!res.ok) return;
                            const data = await res.json();
                            const movies = data.movies || [];

                            if (movies.length === 0) {
                                searchDropdown.innerHTML = `
                                    <div class="p-4 text-center text-xs text-gray-400">
                                        ไม่พบหนังที่ตรงกับ "${query}"
                                    </div>
                                `;
                                searchDropdown.classList.remove('hidden');
                                return;
                            }

                            searchDropdown.innerHTML = movies.map(m => `
                                <a href="${m.url}" class="flex items-center gap-3 p-3 hover:bg-gray-800/90 transition text-left group">
                                    <div class="w-10 h-14 bg-gray-800 rounded-lg overflow-hidden shrink-0 flex items-center justify-center">
                                        ${m.poster_url 
                                            ? `<img src="${m.poster_url}" alt="" class="w-full h-full object-cover">` 
                                            : `<span class="text-[9px] text-gray-400 text-center px-1">HD</span>`}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-bold text-white group-hover:text-[#00fff2] transition truncate">${m.title}</h4>
                                        <p class="text-xs text-gray-400 truncate mt-0.5">
                                            ${m.genres ? m.genres : 'หนัง'} ${m.release_year ? '· ' + m.release_year : ''}
                                        </p>
                                    </div>
                                    ${m.rating ? `<span class="text-xs font-bold text-yellow-400 shrink-0">★ ${m.rating}</span>` : ''}
                                </a>
                            `).join('') + `
                                <div class="p-2.5 bg-gray-900/90 text-center">
                                    <button type="submit" form="searchForm" class="text-xs font-bold text-[#00fff2] hover:underline">
                                        ดูผลการค้นหาทั้งหมดสำหรับ "${query}" →
                                    </button>
                                </div>
                            `;
                            searchDropdown.classList.remove('hidden');
                        } catch (e) {
                            console.error('Search error', e);
                        }
                    }, 250);
                });

                // ปิด dropdown เมื่อคลิกที่อื่น
                document.addEventListener('click', function (e) {
                    if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                        searchDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>