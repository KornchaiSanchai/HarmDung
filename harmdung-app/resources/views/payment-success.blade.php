<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชำระเงินสำเร็จ - HD Harmdung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#171717] text-white font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-[#00fff2] selection:text-black">

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
                    <a href="/cart" class="flex items-center gap-2 bg-[#333333] px-5 py-2 rounded-full text-sm text-white shadow-inner">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        ตะกร้า
                    </a>
                </div>
            </div>

            <!-- Balance & Member Profile -->
            <div class="flex items-center gap-4">
                <div class="bg-gray-800/90 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2 border border-gray-700/80 shadow">
                    <span class="w-5 h-5 bg-gradient-to-tr from-yellow-500 to-amber-300 rounded-full flex items-center justify-center text-black font-extrabold text-xs shadow-sm">฿</span>
                    <span class="font-bold text-gray-100">100.00</span>
                </div>
                <a href="/member" class="w-10 h-10 bg-[#00fff2] rounded-full flex items-center justify-center text-black font-bold shadow-md hover:scale-105 transition" title="ข้อมูลสมาชิก">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-center px-4 py-12 text-center">
        <div class="max-w-2xl mx-auto flex flex-col items-center">
            
            <!-- Success Illustration matching Figma image 60 -->
            <div class="relative mb-8 group">
                <div class="absolute inset-0 bg-[#00fff2]/20 rounded-full blur-3xl transform group-hover:scale-110 transition duration-500"></div>
                <img src="/images/payment-success.png" alt="ชำระเงินสำเร็จ" class="relative w-64 h-64 md:w-80 md:h-80 object-contain drop-shadow-[0_20px_35px_rgba(0,255,242,0.25)] animate-bounce-short">
            </div>

            <!-- Big Heading from Figma (#40:40) -->
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight drop-shadow-md mb-4">
                ชำระเงินสำเร็จ
            </h1>
            
            <p class="text-gray-400 text-base md:text-lg max-w-md mx-auto mb-10 leading-relaxed">
                ระบบได้ดำเนินการคำสั่งซื้อของคุณเรียบร้อยแล้ว รายการแพ็กเกจของคุณพร้อมใช้งานได้ทันที
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
                <a href="/member?tab=orders" class="w-full sm:w-auto bg-[#00fff2] text-black font-bold px-8 py-3.5 rounded-full hover:bg-cyan-300 transition shadow-lg shadow-cyan-500/25 text-center flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    ดูประวัติการซื้อ
                </a>
                <a href="/home" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 text-white font-semibold px-8 py-3.5 rounded-full transition border border-gray-700 text-center flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    กลับสู่หน้าแรก
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-6 text-gray-500 text-xs border-t border-gray-800/50">
        &copy; {{ date('Y') }} HD Harmdung. All rights reserved.
    </footer>

</body>
</html>
