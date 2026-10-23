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
       <x-navbar active="checkout"></x-navbar>

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

                <!-- รายการสินค้าที่สั่งซื้อ (จะโหลดจากสินค้าที่เลือกในตะกร้า) -->
                <div id="checkout-items-list">
                    <!-- รายการสินค้าจะถูกเรนเดอร์จากสินค้าที่ผู้ใช้เลือกในตะกร้าจริงผ่าน JavaScript -->
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
                        <a href="/cart" class="w-full sm:w-auto bg-gray-200 text-black font-bold px-6 py-3.5 rounded-full transition shadow-md shadow-gray-500/20 text-base flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                            ย้อนกลับ
                        </a>
                        <a href="/payment-success" class="w-full sm:w-auto bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold px-10 py-3.5 rounded-full transition shadow-lg shadow-cyan-500/25 text-base flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                            สั่งซื้อสินค้า
                        </a>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        const PLATFORM_IMAGES = {
            'Thisney-': '/images/thisney.png',
            'HIV min': '/images/hiv.png',
            'NETFLUX': '/images/netflux.png',
            'Prime Hindu Video': '/images/hindu.png',
        };

        function platformBanner(name) {
            const img = PLATFORM_IMAGES[name];
            return img
                ? `<img src="${img}" alt="${name}" class="w-full h-full object-cover">`
                : name; // ไม่มีรูป: แสดงชื่อเป็นข้อความเหมือนเดิม
        }

        // เมื่อโหลดหน้า: โหลดสินค้าจริงจากที่เลือกในตะกร้า แล้วคำนวณราคาทันที
        window.onload = function() {
            loadCheckoutItems();
            calculateGrandTotal();
        };

        function loadCheckoutItems() {
            const raw = localStorage.getItem('harmdung_checkout_items');
            let items = [];
            if (raw) {
                try {
                    items = JSON.parse(raw);
                    if (!Array.isArray(items)) items = [];
                } catch (e) {
                    items = [];
                }
            }

            const container = document.getElementById('checkout-items-list');
            container.innerHTML = '';

            if (items.length === 0) {
                container.innerHTML = `
                    <div class="py-12 text-center text-gray-500">
                        <p class="text-base font-semibold">ไม่มีรายการสินค้าที่เลือกชำระเงิน</p>
                        <a href="/cart" class="inline-block mt-3 text-sm font-bold text-cyan-600 hover:underline">← กลับไปที่ตะกร้าสินค้า</a>
                    </div>
                `;
                return;
            }

            // จัดกลุ่มตามชื่อแพลตฟอร์ม (คงลำดับเดิม)
            const groups = new Map();
            items.forEach(item => {
                if (!groups.has(item.name)) groups.set(item.name, []);
                groups.get(item.name).push(item);
            });

            groups.forEach((groupItems, name) => {
                const gradient = groupItems[0].gradient || 'from-[#0b1b3d] to-[#043360]';

                const rowsHtml = groupItems.map(item => `
                    <div class="checkout-row grid grid-cols-12 items-center py-3 gap-4" data-price="${item.price}">
                        <div class="col-span-6 pl-32">
                            <p class="text-gray-400 text-xs">ตัวเลือกสินค้า <span class="text-gray-700 font-medium">${item.option}</span></p>
                        </div>
                        <div class="col-span-2 text-center font-medium">${item.price} บาท</div>
                        <div class="col-span-2 text-center font-medium item-qty">${item.qty}</div>
                        <div class="col-span-2 text-right font-bold item-subtotal">${item.price * item.qty} บาท</div>
                    </div>
                `).join('');

                const group = document.createElement('div');
                group.className = 'relative py-4 border-b border-gray-200';
                group.innerHTML = `
                    <div class="absolute left-0 top-4 w-28 aspect-video rounded-xl overflow-hidden shadow bg-gradient-to-r ${gradient} flex items-center justify-center text-white font-bold text-sm">
                        ${platformBanner(name)}
                    </div>
                    <h3 class="font-bold text-lg leading-tight pl-32">${name}</h3>
                    <div class="mt-1">${rowsHtml}</div>
                `;
                container.appendChild(group);
            });
        }

        function calculateGrandTotal() {
            const rows = document.querySelectorAll('.checkout-row');
            let totalQty = 0;
            let rawTotal = 0;

            rows.forEach(row => {
                const qty = parseInt(row.querySelector('.item-qty').textContent) || 0;
                const unitPrice = parseFloat(row.getAttribute('data-price')) || 0;
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