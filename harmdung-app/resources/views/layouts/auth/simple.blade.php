<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    </head>
    <body class="min-h-screen bg-[#171717] text-white font-sans antialiased selection:bg-[#00fff2] selection:text-black flex flex-col justify-between">
        
        <!-- HarmDung Header Navbar matching Figma #23:2 & #22:13 -->
        <header>
            <nav class="flex items-center justify-between px-8 py-4 border-b border-gray-800/80 bg-[#121212]/90 backdrop-blur-md sticky top-0 z-50">
                <div class="flex items-center gap-8">
                    <!-- Logo -->
                    <a href="/home" class="flex items-center shrink-0 group">
                        <img src="/images/logo.png" alt="HD Harmdung" class="h-10 w-auto object-contain scale-125 origin-left transition-transform group-hover:scale-130">
                    </a>
                    
                    <!-- Nav items -->
                    <div class="flex items-center gap-2">
                        <a href="/home" class="flex items-center gap-2 px-5 py-2 text-sm text-gray-300 hover:text-white transition rounded-full hover:bg-gray-800/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            หน้าแรก
                        </a>
                        <a href="/products" class="flex items-center gap-2 px-5 py-2 text-sm text-gray-300 hover:text-white transition rounded-full hover:bg-gray-800/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            สินค้าทั้งหมด
                        </a>
                    </div>
                </div>

                <!-- Auth Switch Buttons matching Figma -->
                <div class="flex items-center gap-3 text-sm font-bold">
                    <a href="{{ route('login') }}" class="px-6 py-2 rounded-full transition {{ request()->routeIs('login') ? 'bg-white text-black shadow' : 'bg-transparent text-gray-300 hover:text-white hover:bg-gray-800' }}">
                        เข้าสู่ระบบ
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2 rounded-full transition {{ request()->routeIs('register') ? 'bg-[#00fff2] text-black shadow-lg shadow-cyan-500/20' : 'bg-[#00fff2]/80 text-black hover:bg-[#00fff2]' }}">
                        สมัครสมาชิก
                    </a>
                </div>
            </nav>
        </header>

        <!-- Auth Card Container -->
        <main class="flex-1 flex flex-col items-center justify-center p-6 md:p-12">
            <div class="w-full max-w-md bg-gray-900/90 border border-gray-800 rounded-[28px] p-8 md:p-10 shadow-2xl backdrop-blur-xl">
                {{ $slot }}
            </div>
        </main>
        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
