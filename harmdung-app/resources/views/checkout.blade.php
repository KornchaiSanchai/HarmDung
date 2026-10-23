<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชำระเงิน - HD Harmdung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#121212] text-white font-sans antialiased min-h-screen pb-12 flex flex-col justify-between">

    <div>
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
                <a href="/profile" class="w-10 h-10 bg-[#00fff2] rounded-full flex items-center justify-center text-black font-bold shadow-md hover:scale-105 transition" title="ข้อมูลสมาชิก">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </a>
            </div>
        </nav>

        <!-- Checkout Main Content -->
        <main class="max-w-[900px] mx-auto px-6 mt-10">
            <h1 class="text-2xl font-bold text-center mb-8">ชำระเงิน</h1>

            <div class="bg-white text-black rounded-[24px] p-8 shadow-2xl">
                
                <!-- หัวตาราง -->
                <div class="grid grid-cols-12 text-gray-500 font-semibold text-sm pb-4 border-b border-gray-200">
                    <div class="col-span-6">สินค้าที่สั่งซื้อแล้ว</div>
                    <div class="col-span-2 text-center">ราคาต่อหน่วย</div>
                    <div class="col-span-2 text-center">จำนวน</div>
                    <div class="col-span-2 text-right">รายการย่อย</div>
                </div>

                <!-- รายการสินค้า 1 -->
                <div class="grid grid-cols-12 items-center py-4 border-b border-gray-100 gap-4 checkout-row" data-price="25">
                    <div class="col-span-6 flex items-center gap-4">
                        <div class="w-28 aspect-video rounded-xl overflow-hidden shadow bg-gradient-to-r from-[#0b1b3d] to-[#043360] flex items-center justify-center text-white font-bold text-sm">
                            Thisney-
                        </div>
                        <div>
                            <h3 class="font-bold text-lg leading-tight">Thisney-</h3>
                            <p class="text-gray-400 text-xs mt-0.5">ตัวเลือกสินค้า # 7 วัน</p>
                        </div>
                    </div>
                    <div class="col-span-2 text-center font-medium">25 บาท</div>
                    <div class="col-span-2 text-center font-medium item-qty">2</div>
                    <div class="col-span-2 text-right font-bold item-subtotal">50 บาท</div>
                </div>

                <!-- รายการสินค้า 2 -->
                <div class="grid grid-cols-12 items-center py-4 border-b border-gray-200 gap-4 checkout-row" data-price="70">
                    <div class="col-span-6 flex items-center gap-4">
                        <div class="w-28 aspect-video rounded-xl overflow-hidden shadow bg-gradient-to-r from-[#5a1bb9] to-[#204ce4] flex items-center justify-center text-white font-bold text-sm">
                            HIV min
                        </div>
                        <div>
                            <h3 class="font-bold text-lg leading-tight">HIV min</h3>
                            <p class="text-gray-400 text-xs mt-0.5">ตัวเลือกสินค้า # 30 วัน</p>
                        </div>
                    </div>
                    <div class="col-span-2 text-center font-medium">70 บาท</div>
                    <div class="col-span-2 text-center font-medium item-qty">1</div>
                    <div class="col-span-2 text-right font-bold item-subtotal">70 บาท</div>
                </div>

                <!-- ส่วนเลือกคูปองส่วนลด -->
                <div class="py-5 border-b border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <svg class="w-6 h-6 text-gray-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        <span class="font-bold text-gray-800">ส่วนลดคำสั่งซื้อ (คูปอง)</span>
                    </div>

                    <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                        <input type="text" placeholder="ค้นหาโค้ดส่วนลด..." class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm outline-none focus:border-cyan-500 bg-gray-50">
                        
                        <select id="discount-select" onchange="calculateGrandTotal()" class="border border-gray-300 rounded-lg px-4 py-1.5 text-sm font-semibold bg-white outline-none focus:border-cyan-500 cursor-pointer">
                            <option value="0" data-type="none">-- เลือกส่วนลด --</option>
                            <option value="10" data-type="percent" selected>ส่วนลด -10%</option>
                            <option value="20" data-type="percent">ส่วนลด -20%</option>
                            <option value="50" data-type="fixed">ส่วนลด 50 บาท</option>
                        </select>
                    </div>
                </div>

                <!-- สรุปราคาและปุ่มยืนยัน -->
                <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xl font-bold">
                        คำสั่งซื้อทั้งหมด <span id="total-qty" class="text-cyan-600">3</span> ชิ้น : <span id="grand-total" class="text-2xl font-extrabold text-black">108 บาท</span>
                    </div>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <a href="/cart" class="w-full sm:w-auto text-center bg-gray-200 text-black font-bold px-6 py-3 rounded-xl hover:bg-gray-300 transition">
                            ย้อนกลับ
                        </a>
                        <a href="/payment-success" class="w-full sm:w-auto text-center bg-[#00fff2] text-black font-bold px-8 py-3 rounded-xl hover:bg-cyan-300 transition shadow-md shadow-cyan-500/20">
                            สั่งซื้อสินค้า
                        </a>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        // คำนวณราคาอัตโนมัติเมื่อโหลดหน้า
        window.onload = function() {
            calculateGrandTotal();
        };

        function calculateGrandTotal() {
            const rows = document.querySelectorAll('.checkout-row');
            let totalQty = 0;
            let rawTotal = 0;

            rows.forEach(row => {
                const qty = parseInt(row.querySelector('.item-qty').textContent);
                const unitPrice = parseFloat(row.getAttribute('data-price'));
                totalQty += qty;
                rawTotal += (qty * unitPrice);
            });

            const discountSelect = document.getElementById('discount-select');
            const selectedOption = discountSelect.options[discountSelect.selectedIndex];
            const discountValue = parseFloat(selectedOption.value) || 0;
            const discountType = selectedOption.getAttribute('data-type');

            let finalTotal = rawTotal;
            if (discountType === 'percent') {
                finalTotal = rawTotal * (1 - discountValue / 100);
            } else if (discountType === 'fixed') {
                finalTotal = rawTotal - discountValue;
            }

            if (finalTotal < 0) finalTotal = 0;

            document.getElementById('total-qty').textContent = totalQty;
            document.getElementById('grand-total').textContent = Math.round(finalTotal) + ' บาท';
        }
    </script>
</body>
</html>