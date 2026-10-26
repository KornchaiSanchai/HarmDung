<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->title }} - HD Harmdung</title>
    <meta name="description" content="{{ \Illuminate\Support\Str::limit($movie->synopsis, 155) }}">
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
                    @auth
                    <a href="/cart" class="flex items-center gap-2 px-5 py-2 rounded-full text-sm text-gray-300 hover:text-white transition hover:bg-gray-800/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        ตะกร้า
                    </a>
                    @endauth
                </div>
            </div>

            <!-- Search Bar in Navbar matching Figma Group 1 -->
            <div class="hidden lg:block relative w-80">
                <button class="absolute right-3.5 top-1/2 -translate-y-1/2 text-black">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>

            <!-- Profile / Balance -->
            <div class="flex items-center gap-4 text-sm font-semibold">
                @auth
                    <div class="bg-gray-800/90 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2 border border-gray-700/80 shadow">
                        <span class="w-5 h-5 bg-gradient-to-tr from-yellow-500 to-amber-300 rounded-full flex items-center justify-center text-black font-extrabold text-xs shadow-sm">฿</span>
                        <span class="font-bold text-gray-100">{{ number_format(auth()->user()->balance, 2) }}</span>
                    </div>
                    <a href="/profile" class="w-10 h-10 bg-[#00fff2] rounded-full flex items-center justify-center text-black font-bold shadow-md hover:scale-105 transition" title="ข้อมูลสมาชิก">
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
                @if ($movie->poster_url)
                    <img src="{{ $movie->poster_url }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover scale-110 blur-sm opacity-50">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                @endif
                <div class="absolute inset-0 bg-cover bg-center opacity-40 mix-blend-overlay" style="background-image: radial-gradient(circle, rgba(0,255,242,0.3) 0%, rgba(0,0,0,0.8) 100%);"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6 w-full">
                    <div>
                        <!-- Platform Badges -->
                        @if ($movie->platforms->isNotEmpty())
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-xs font-semibold text-gray-300">รับชมได้ที่</span>
                            <div class="flex items-center gap-2 flex-wrap">
                                @foreach ($movie->platforms as $platform)
                                <a href="/product-info?platform={{ $platform->id }}" class="px-3 py-1 bg-gradient-to-r from-[#0b1b3d] to-[#043360] rounded-lg text-xs font-bold text-white border border-white/20 hover:scale-105 transition flex items-center gap-1.5">
                                    @include('partials.platform-badge', ['platform' => $platform, 'size' => 'w-4 h-4'])
                                    {{ $platform->name }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Movie Title -->
                        <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight drop-shadow-lg">
                            {{ $movie->title }}
                        </h1>
                        <div class="mt-2 text-xs font-semibold text-gray-300 flex flex-wrap items-center gap-x-2">
                            @if ($movie->release_year)<span>{{ $movie->release_year }}</span>@endif
                            @if ($movie->duration_min)<span>· {{ intdiv($movie->duration_min, 60) }} ชม. {{ $movie->duration_min % 60 }} นาที</span>@endif
                            @if ($movie->genres->isNotEmpty())<span>· {{ $movie->genres->pluck('name')->implode(' / ') }}</span>@endif
                        </div>
                    </div>

                    <!-- Rating badge matching Figma Group 6 (#13:179) -->
                    <div class="bg-black/60 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/10 flex items-center gap-3">
                        <span class="text-yellow-400 text-2xl font-black">★</span>
                        <div>
                            <div class="text-2xl font-black text-white leading-none">{{ $movie->reviews_count ? number_format($movie->reviews_avg_rating, 1) : '-' }}</div>
                            <div class="text-[10px] text-gray-400 font-semibold uppercase mt-0.5">Rating ({{ $movie->reviews_count }})</div>
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
                        <p class="whitespace-pre-line">{{ $movie->synopsis ?: 'ยังไม่มีเรื่องย่อ' }}</p>
                    </div>

                    <div class="pt-4 flex items-center gap-4">
                        <a href="/products" class="bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold px-6 py-2.5 rounded-full transition shadow-lg shadow-cyan-500/20 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            เลือกซื้อแพ็กเกจเพื่อรับชม
                        </a>
                    </div>
                </div>

                <!-- Review Section matching Figma #13:179 Review list -->
                <div id="reviews" class="border-t border-gray-800 pt-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <span>รีวิวจากผู้ชม</span>
                            <span class="text-xs font-normal text-gray-400">Review ({{ $movie->reviews_count }})</span>
                        </h3>
                    </div>

                    @if (session('status'))
                        <div class="mb-4 rounded-xl border border-emerald-700/60 bg-emerald-950/50 px-4 py-2 text-sm text-emerald-300">{{ session('status') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 rounded-xl border border-red-700/60 bg-red-950/50 px-4 py-2 text-sm text-red-300">{{ $errors->first() }}</div>
                    @endif

                    @auth
                    <form method="POST" action="{{ route('reviews.store', $movie) }}" class="bg-gray-900/80 rounded-2xl p-5 border border-gray-800 mb-6 space-y-3">
                        @csrf
                        <div class="flex flex-row-reverse justify-end gap-1 text-3xl">
                            @for ($s = 5; $s >= 1; $s--)
                                <input type="radio" name="rating" id="star{{ $s }}" value="{{ $s }}" class="peer sr-only" required>
                                <label for="star{{ $s }}" class="cursor-pointer text-gray-600 peer-checked:text-yellow-400">★</label>
                            @endfor
                        </div>
                        <textarea name="comment" rows="3" required placeholder="เขียนรีวิวของคุณ..."
                                class="w-full bg-[#171717] border border-gray-700 rounded-xl p-3 text-sm text-white outline-none focus:ring-2 focus:ring-[#00fff2]"></textarea>
                        <button type="submit" class="bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold px-6 py-2 rounded-full text-sm transition">ส่งรีวิว</button>
                    </form>
                    @endauth

                    @guest
                    <div class="bg-gray-900/80 rounded-2xl p-5 border border-gray-800 mb-6 flex items-center justify-between gap-4">
                        <p class="text-sm text-gray-400">เข้าสู่ระบบเพื่อเขียนรีวิวและให้ดาว</p>
                        <a href="/login" class="bg-[#00fff2] hover:bg-cyan-300 text-black font-bold px-5 py-2 rounded-full text-xs transition shrink-0">เข้าสู่ระบบ</a>
                    </div>
                    @endguest

                    <div class="space-y-4">
                        @php($avatarColors = ['bg-cyan-900/60 text-[#00fff2]', 'bg-purple-900/60 text-purple-300', 'bg-emerald-900/60 text-emerald-300'])
                        @forelse ($movie->reviews as $review)
                        <div class="bg-gray-900/80 rounded-2xl p-5 border border-gray-800">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full {{ $avatarColors[$loop->index % 3] }} font-bold text-xs flex items-center justify-center">
                                        {{ mb_strtoupper(mb_substr($review->user?->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm text-white">{{ $review->user?->name ?? 'ผู้ใช้ที่ถูกลบ' }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $review->created_at?->format('Y-m-d H:i') }}</div>
                                    </div>
                                </div>
                                <div class="text-yellow-400 text-xs font-bold flex items-center gap-1">
                                    {{ str_repeat('★', $review->rating) }}<span class="text-gray-600">{{ str_repeat('★', 5 - $review->rating) }}</span> <span>{{ $review->rating }}.0</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-300 leading-relaxed pl-11 whitespace-pre-line">{{ \Illuminate\Support\Str::limit($review->comment, 800) }}</p>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">ยังไม่มีรีวิวสำหรับหนังเรื่องนี้</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </main>
</body>
</html>
