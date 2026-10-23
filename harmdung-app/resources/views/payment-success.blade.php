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

    <x-navbar active="payment-success"></x-navbar>

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
