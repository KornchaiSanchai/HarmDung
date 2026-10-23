<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตะกร้าสินค้า - HD Harmdung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#171717] text-white font-sans antialiased min-h-screen pb-16 flex flex-col justify-between selection:bg-[#00fff2] selection:text-black">

    <div>
        <!-- Navbar matching Figma #23:57 & #25:44 -->
        <header>
            <nav class="flex items-center justify-between px-8 py-4 border-b border-gray-800/80 bg-[#121212]/80 backdrop-blur-md sticky top-0 z-50">
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
                        <a href="/cart" class="flex items-center gap-2 bg-[#333333] px-5 py-2 rounded-full text-sm text-white shadow-inner">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            ตะกร้า
                        </a>
                    </div>
                </div>

                <!-- Profile & Balance -->
                <div class="flex items-center gap-4">
                    <div class="bg-gray-800/90 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2 border border-gray-700/80 shadow">
                        <span class="w-5 h-5 bg-gradient-to-tr from-yellow-500 to-amber-300 rounded-full flex items-center justify-center text-black font-extrabold text-xs shadow-sm">฿</span>
                        <span class="font-bold text-gray-100">100.00</span>
                    </div>
                    <a href="/profile" class="w-10 h-10 bg-[#00fff2] rounded-full flex items-center justify-center text-black font-bold shadow-md hover:scale-105 transition" title="ข้อมูลสมาชิก">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </a>
                </div>
            </nav>
        </header>

        <!-- Main Cart Content matching Figma Group 9 & 10 -->
        <main class="max-w-[1000px] mx-auto px-6 mt-10">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-white tracking-tight">สินค้าในตะกร้า</h1>
                    <p class="text-xs text-gray-400 mt-1">ตรวจสอบรายการแพ็กเกจที่คุณเลือกก่อนเข้าสู่ขั้นตอนชำระเงิน</p>
                </div>
                <a href="/products" class="text-xs font-bold text-[#00fff2] hover:underline flex items-center gap-1">
                    + เลือกซื้อสินค้าเพิ่ม
                </a>
            </div>

            <!-- Form ไปหน้า Checkout -->
            <form action="/checkout" method="GET">
                <div class="space-y-4">
                    
                    <!-- สินค้าชิ้นที่ 1: Thisney- (# 7 วัน) -->
                    <div class="bg-white text-black rounded-[24px] p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xl border border-gray-100 hover:shadow-2xl transition cart-item" data-price="25">
                        <div class="flex items-center gap-4">
                            <input type="checkbox" name="items[]" value="thisney_7days" checked onchange="updateCartTotal()" class="item-checkbox w-5 h-5 accent-[#00fff2] rounded cursor-pointer">
                            <div class="w-28 aspect-video rounded-xl overflow-hidden shadow bg-gradient-to-r from-[#0b1b3d] to-[#043360] flex items-center justify-center text-white font-extrabold text-sm shrink-0">
                                Thisney-
                            </div>
                            <div>
                                <h3 class="font-extrabold text-lg leading-tight text-gray-900">Thisney-</h3>
                                <p class="text-gray-500 text-xs mt-1">ตัวเลือกสินค้า <span class="font-bold text-gray-700"># 7 วัน</span></p>
                                <span class="text-xs text-gray-400">ราคาต่อหน่วย: 25 บาท</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto border-t sm:border-0 border-gray-100 pt-3 sm:pt-0">
                            <div class="text-right">
                                <span class="item-subtotal text-lg font-black text-gray-900">50 บาท</span>
                            </div>
                            <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden bg-gray-50 shadow-inner">
                                <button type="button" onclick="adjustQty(this, -1)" class="px-3.5 py-1.5 text-gray-700 hover:bg-gray-200 font-bold transition">-</button>
                                <span class="px-3 py-1.5 text-sm font-bold min-w-[36px] text-center item-qty-val">2</span>
                                <button type="button" onclick="adjustQty(this, 1)" class="px-3.5 py-1.5 text-gray-700 hover:bg-gray-200 font-bold transition">+</button>
                            </div>
                        </div>
                    </div>

                    <!-- สินค้าชิ้นที่ 2: HIV min (# 30 วัน) -->
                    <div class="bg-white text-black rounded-[24px] p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xl border border-gray-100 hover:shadow-2xl transition cart-item" data-price="70">
                        <div class="flex items-center gap-4">
                            <input type="checkbox" name="items[]" value="hiv_30days" checked onchange="updateCartTotal()" class="item-checkbox w-5 h-5 accent-[#00fff2] rounded cursor-pointer">
                            <div class="w-28 aspect-video rounded-xl overflow-hidden shadow bg-gradient-to-r from-[#5a1bb9] to-[#204ce4] flex items-center justify-center text-white font-extrabold text-sm shrink-0">
                                HIV min
                            </div>
                            <div>
                                <h3 class="font-extrabold text-lg leading-tight text-gray-900">HIV min</h3>
                                <p class="text-gray-500 text-xs mt-1">ตัวเลือกสินค้า <span class="font-bold text-gray-700"># 30 วัน</span></p>
                                <span class="text-xs text-gray-400">ราคาต่อหน่วย: 70 บาท</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto border-t sm:border-0 border-gray-100 pt-3 sm:pt-0">
                            <div class="text-right">
                                <span class="item-subtotal text-lg font-black text-gray-900">70 บาท</span>
                            </div>
                            <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden bg-gray-50 shadow-inner">
                                <button type="button" onclick="adjustQty(this, -1)" class="px-3.5 py-1.5 text-gray-700 hover:bg-gray-200 font-bold transition">-</button>
                                <span class="px-3 py-1.5 text-sm font-bold min-w-[36px] text-center item-qty-val">1</span>
                                <button type="button" onclick="adjustQty(this, 1)" class="px-3.5 py-1.5 text-gray-700 hover:bg-gray-200 font-bold transition">+</button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- สรุปยอดและปุ่มไปชำระเงิน matching Figma #25:44 -->
                <div class="mt-8 bg-gray-900/90 rounded-[24px] p-6 border border-gray-800 shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="text-center sm:text-left">
                        <div class="text-xs text-gray-400">คำสั่งซื้อที่เลือก</div>
                        <div class="text-xl font-black text-white mt-0.5">
                            ทั้งหมด <span id="cart-selected-count" class="text-[#00fff2]">3</span> ชิ้น : 
                            <span id="cart-total-price" class="text-2xl font-black text-[#00fff2] ml-1">120 บาท</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold px-10 py-3.5 rounded-full transition shadow-lg shadow-cyan-500/25 text-base flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                            <span>ไปที่หน้าชำระเงิน</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <!-- Footer -->
    <footer class="text-center py-6 text-gray-500 text-xs border-t border-gray-800/50 mt-12">
        &copy; {{ date('Y') }} HD Harmdung. All rights reserved.
    </footer>

    <script>
        function adjustQty(btn, change) {
            const container = btn.parentElement;
            const span = container.querySelector('.item-qty-val');
            let val = parseInt(span.textContent) + change;
            if (val < 1) val = 1;
            span.textContent = val;
            
            // Recalculate item subtotal
            const row = btn.closest('.cart-item');
            const unitPrice = parseFloat(row.getAttribute('data-price'));
            row.querySelector('.item-subtotal').textContent = (unitPrice * val) + ' บาท';
            
            updateCartTotal();
        }

        function updateCartTotal() {
            const rows = document.querySelectorAll('.cart-item');
            let totalCount = 0;
            let totalPrice = 0;

            rows.forEach(row => {
                const checkbox = row.querySelector('.item-checkbox');
                if (checkbox.checked) {
                    const qty = parseInt(row.querySelector('.item-qty-val').textContent);
                    const unitPrice = parseFloat(row.getAttribute('data-price'));
                    totalCount += qty;
                    totalPrice += (qty * unitPrice);
                }
            });

            document.getElementById('cart-selected-count').textContent = totalCount;
            document.getElementById('cart-total-price').textContent = totalPrice + ' บาท';
        }
    </script>
</body>
</html>