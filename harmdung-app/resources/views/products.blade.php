<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สินค้าทั้งหมด - HD Harmdung</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                <a href="/home" class="flex items-center gap-2 px-5 py-2 text-sm text-gray-300 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    หน้าแรก
                </a>
                <a href="/products" class="flex items-center gap-2 bg-gray-700/80 px-5 py-2 rounded-full text-sm text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    สินค้าทั้งหมด
                </a>
                <a href="/cart" class="flex items-center gap-2 px-5 py-2 rounded-full text-sm text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        ตะกร้า
                    </a>
            </div>
        </div>

        <!-- ข้อมูลโปรไฟล์ / ยอดเงิน / เข้าสู่ระบบ -->
        <div class="flex items-center gap-4 text-sm font-semibold">
            <div class="bg-gray-800/90 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2 border border-gray-700/80 shadow">
                <span class="w-5 h-5 bg-gradient-to-tr from-yellow-500 to-amber-300 rounded-full flex items-center justify-center text-black font-extrabold text-xs shadow-sm">฿</span>
                <span class="font-bold text-gray-100">100.00</span>
            </div>
            <a href="/member" class="w-10 h-10 bg-[#00fff2] rounded-full flex items-center justify-center text-black font-bold shadow-md hover:scale-105 transition" title="ข้อมูลสมาชิก">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </a>
            <a href="/login" class="bg-white text-black px-5 py-2 rounded-full hover:bg-gray-200 transition font-bold text-xs hidden sm:block">เข้าสู่ระบบ</a>
        </div>
    </nav>

    <!-- คอนเทนต์: Grid สินค้า -->
    <div class="max-w-[1200px] mx-auto px-8 mt-12">
        <!-- จัดเรียงแบบ 2 คอลัมน์สำหรับจอคอม -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            @php
                $platforms = [
                    ['key' => 'thisney', 'name' => 'Thisney-', 'count' => 4, 'bg_class' => 'bg-gradient-to-r from-[#0b1b3d] to-[#043360]', 'image' => '/images/thisney.png'],
                    ['key' => 'hiv', 'name' => 'HIV min', 'count' => 4, 'bg_class' => 'bg-gradient-to-r from-[#5a1bb9] to-[#204ce4]', 'image' => '/images/hiv.png'],
                    ['key' => 'netflux', 'name' => 'NETFLUX', 'count' => 4, 'bg_class' => 'bg-gradient-to-r from-[#3e0808] to-[#1a0202]', 'image' => '/images/netflux.png'],
                    ['key' => 'hindu', 'name' => 'Prime Hindu Video', 'count' => 4, 'bg_class' => 'bg-gradient-to-r from-[#0d213b] to-[#123e6f]', 'image' => '/images/hindu.png'],
                ];
            @endphp

            @foreach ($platforms as $platform)
            <!-- การ์ดกรอบสีขาว -->
            <a href="/product-info?platform={{ $platform['key'] }}" class="bg-white rounded-[24px] p-3 flex flex-col gap-3 shadow-lg hover:scale-[1.02] transition-transform duration-300 block">
                
                <!-- ส่วนแบนเนอร์ -->
                <div class="{{ $platform['bg_class'] }} w-full aspect-[21/9] rounded-[20px] flex items-center justify-center overflow-hidden relative">
                    <!-- ดึงรูปภาพมาแสดงผล -->
                    <img src="{{ $platform['image'] }}" alt="{{ $platform['name'] }}" class="w-full h-full object-cover">
                </div>

                <!-- ส่วนรายละเอียดและปุ่ม -->
                <div class="flex items-center justify-between px-3 pb-2 pt-1">
                    <div>
                        <h3 class="text-black text-xl font-bold leading-none">{{ $platform['name'] }}</h3>
                        <p class="text-gray-500 text-sm mt-1">มีสินค้า {{ $platform['count'] }} รายการ</p>
                    </div>
                    <span class="bg-[#00fff2] text-black font-bold px-5 py-2.5 rounded-full text-sm hover:bg-cyan-300 transition shadow-sm">
                        สินค้าทั้งหมด
                    </span>
                </div>
            </a>
            @endforeach

        </div>
    </div>

</body>
</html>