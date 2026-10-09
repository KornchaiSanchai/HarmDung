<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตะกร้าสินค้า - HD Harmdung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#121212] text-white font-sans antialiased min-h-screen pb-12 flex flex-col justify-between">

    <div>
        <!-- Navbar -->
        <nav class="flex items-center justify-between px-8 py-4 border-b border-gray-800">
            <div class="flex items-center gap-8">
                <!-- โลโก้ -->
                <a href="/" class="flex items-center shrink-0">
                    <img src="/images/logo.png" alt="HD Harmdung" class="h-10 w-auto object-contain scale-150 origin-left">
                </a>
                <!-- เมนู -->
                <div class="flex items-center gap-2">
                    <a href="/home" class="flex items-center gap-2 px-5 py-2 text-sm text-gray-300 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        หน้าแรก
                    </a>
                    <a href="/products" class="flex items-center gap-2 px-5 py-2 text-sm text-gray-300 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        สินค้าทั้งหมด
                    </a>
                    <a href="/cart" class="flex items-center gap-2 bg-gray-700/80 px-5 py-2 rounded-full text-sm text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        ตะกร้า
                    </a>
                </div>
            </div>

            <!-- ยอดเงิน / โปรไฟล์ -->
            <div class="flex items-center gap-4">
                <div class="bg-gray-800 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2 border border-gray-700">
                    <span class="w-5 h-5 bg-yellow-500 rounded-full flex items-center justify-center text-black font-bold text-xs">฿</span>
                    100.00
                </div>
                <div class="w-10 h-10 bg-[#00E5FF] rounded-full flex items-center justify-center text-black font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
        </nav>

        <!-- Main Cart Content -->
        <main class="max-w-[900px] mx-auto px-6 mt-10">
            <h1 class="text-2xl font-bold text-center mb-8">สินค้าในตะกร้า</h1>

            <!-- Form ส่งข้อมูลไปยังหน้า Checkout -->
            <form action="/checkout" method="GET">
                <div class="space-y-4">
                    <!-- สินค้าชิ้นที่ 1 -->
                    <div class="bg-white text-black rounded-[20px] p-4 flex items-center justify-between shadow-lg">
                        <div class="flex items-center gap-4">
                            <input type="checkbox" name="items[]" value="thisney_7days" checked class="w-5 h-5 accent-cyan-500 cursor-pointer">
                            <div class="w-28 aspect-video rounded-xl overflow-hidden shadow bg-gradient-to-r from-[#0b1b3d] to-[#043360] flex items-center justify-center text-white font-bold text-sm">
                                Thisney-
                            </div>
                            <div>
                                <h3 class="font-bold text-lg leading-tight">Thisney-</h3>
                                <p class="text-gray-400 text-xs mt-0.5">ตัวเลือกสินค้า # 7 วัน</p>
                            </div>
                        </div>
                        <div class="text-red-600 font-bold text-lg">50 บาท</div>
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden bg-gray-50">
                            <button type="button" onclick="adjustQty(this, -1)" class="px-3 py-1 text-gray-600 hover:bg-gray-200 font-bold">-</button>
                            <span class="px-3 py-1 text-sm font-semibold min-w-[32px] text-center">2</span>
                            <button type="button" onclick="adjustQty(this, 1)" class="px-3 py-1 text-gray-600 hover:bg-gray-200 font-bold">+</button>
                        </div>
                    </div>

                    <!-- สินค้าชิ้นที่ 2 -->
                    <div class="bg-white text-black rounded-[20px] p-4 flex items-center justify-between shadow-lg">
                        <div class="flex items-center gap-4">
                            <input type="checkbox" name="items[]" value="hiv_30days" checked class="w-5 h-5 accent-cyan-500 cursor-pointer">
                            <div class="w-28 aspect-video rounded-xl overflow-hidden shadow bg-gradient-to-r from-[#5a1bb9] to-[#204ce4] flex items-center justify-center text-white font-bold text-sm">
                                HIV min
                            </div>
                            <div>
                                <h3 class="font-bold text-lg leading-tight">HIV min</h3>
                                <p class="text-gray-400 text-xs mt-0.5">ตัวเลือกสินค้า # 30 วัน</p>
                            </div>
                        </div>
                        <div class="text-red-600 font-bold text-lg">70 บาท</div>
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden bg-gray-50">
                            <button type="button" onclick="adjustQty(this, -1)" class="px-3 py-1 text-gray-600 hover:bg-gray-200 font-bold">-</button>
                            <span class="px-3 py-1 text-sm font-semibold min-w-[32px] text-center">1</span>
                            <button type="button" onclick="adjustQty(this, 1)" class="px-3 py-1 text-gray-600 hover:bg-gray-200 font-bold">+</button>
                        </div>
                    </div>
                </div>

                <!-- ปุ่มไปหน้าชำระเงิน -->
                <div class="mt-8 text-center">
                    <button type="submit" class="bg-[#00E5FF] text-black font-bold px-12 py-3 rounded-xl hover:bg-cyan-300 transition shadow-lg text-lg">
                        ชำระเงิน
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
        function adjustQty(btn, change) {
            const container = btn.parentElement;
            const span = container.querySelector('span');
            let val = parseInt(span.textContent) + change;
            if (val < 1) val = 1;
            span.textContent = val;
        }
    </script>
</body>
</html>