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
        <x-navbar active="cart"></x-navbar>

        <!-- Main Cart Content matching Figma Group 9 & 10 -->
        <main class="max-w-[1000px] mx-auto px-6 mt-10">
            <div class="flex items-center justify-between mb-8 border-b border-gray-800/80 pb-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-white tracking-tight">สินค้าในตะกร้า</h1>
                    <p class="text-xs text-gray-400 mt-1">ตรวจสอบรายการแพ็กเกจที่คุณเลือกก่อนเข้าสู่ขั้นตอนชำระเงิน</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="/products" class="text-xs font-bold text-[#00fff2] hover:underline flex items-center gap-1">
                        + เลือกซื้อสินค้าเพิ่ม
                    </a>
                </div>
            </div>

            <!-- Empty State (แสดงเมื่อไม่มีสินค้าในตะกร้า โดยค่าเริ่มต้น) -->
            <div id="cart-empty-state" class="text-center py-24 space-y-4">
                <svg class="w-16 h-16 text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <p class="text-gray-400 text-lg font-semibold">ตะกร้าของคุณว่างเปล่า</p>
                <div class="pt-2">
                    <a href="/products" class="inline-block bg-[#00fff2] text-black font-extrabold px-8 py-3 rounded-full text-sm hover:bg-cyan-300 transition shadow-lg shadow-cyan-500/20 active:scale-95">
                        เลือกซื้อสินค้า
                    </a>
                </div>
            </div>

            <!-- Form ไปหน้า Checkout (จะแสดงเมื่อมีสินค้าในตะกร้า) -->
            <form id="cart-form" onsubmit="handleCheckout(event)" class="hidden">
                <div class="space-y-4" id="cart-items-container">
                    <!-- รายการสินค้าจะถูกเรนเดอร์จาก JavaScript -->
                </div>

                <!-- สรุปยอดและปุ่มไปชำระเงิน -->
                <div class="mt-8 p-6 flex flex-col sm:flex-row items-center justify-between gap-6 border-t border-gray-800/80">
                    <div class="text-center sm:text-left">
                        <div class="text-xs text-gray-400">คำสั่งซื้อที่เลือก</div>
                        <div class="text-xl font-black text-white mt-0.5">
                            ทั้งหมด <span id="cart-selected-count" class="text-[#00fff2]">0</span> ชิ้น : 
                            <span id="cart-total-price" class="text-2xl font-black text-[#00fff2] ml-1">0 บาท</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold px-10 py-3.5 rounded-full transition shadow-lg shadow-cyan-500/25 text-base flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                            <span>ชำระเงิน</span>
                        </button>
                    </div>
                </div>
            </form>

    <!-- Modal ป๊อปอัปยืนยันการลบสินค้า -->
    <div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-sm hidden opacity-0 transition-opacity duration-200">
        <div id="delete-modal-box" class="bg-[#1e1e1e] text-white border border-gray-800 rounded-3xl max-w-sm w-full p-6 shadow-2xl transform scale-95 transition-transform duration-200">
            <div class="w-14 h-14 rounded-full bg-red-500/10 text-red-500 flex items-center justify-center mx-auto mb-4 border border-red-500/20">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-center text-white">ลบสินค้าออกจากตะกร้า?</h3>
            <p class="text-sm text-gray-400 text-center mt-2" id="delete-modal-msg">คุณต้องการลบสินค้านี้ออกจากตะกร้าใช่หรือไม่?</p>
            
            <div class="flex items-center gap-3 mt-6">
                <button type="button" onclick="closeDeleteModal()" class="w-1/2 py-2.5 px-4 rounded-full border border-gray-700 hover:bg-gray-800 text-gray-300 font-semibold text-sm transition cursor-pointer">
                    ยกเลิก
                </button>
                <button type="button" onclick="confirmDeleteItem()" class="w-1/2 py-2.5 px-4 rounded-full bg-red-500 hover:bg-red-600 text-white font-bold text-sm transition shadow-lg shadow-red-500/25 cursor-pointer">
                    ยืนยันลบ
                </button>
            </div>
        </div>
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

        let targetRowToDelete = null;

        // แถวตัวเลือกถูกเลือกหรือไม่ = ดูจาก checkbox ของกลุ่ม
        function isRowChecked(row) {
            const cb = row.closest('.cart-group')?.querySelector('.group-checkbox');
            return cb ? cb.checked : true;

        // ลบกลุ่มทิ้งด้วยเมื่อไม่เหลือตัวเลือก
        function confirmDeleteItem() {
            if (targetRowToDelete) {
                const group = targetRowToDelete.closest('.cart-group');
                targetRowToDelete.remove();
                if (group && group.querySelectorAll('.cart-item').length === 0) group.remove();
                targetRowToDelete = null;
                updateCartTotal(true);
            }
            closeDeleteModal();
            }
}

        // ฟังก์ชันปรับจำนวนสินค้า (+/-)
        function adjustQty(btn, change) {
            const row = btn.closest('.cart-item');
            const span = row.querySelector('.item-qty-val');
            let val = parseInt(span.textContent) + change;
            
            // ถ้าเหลือ 1 แล้วกดลด (-1) -> ให้เรียกป๊อปอัปถามยืนยันการลบ
            if (val < 1) {
                askDeleteItem(btn);
                return;
            }
            
            span.textContent = val;
            
            // คำนวณราคาย่อยของแถวนี้
            const unitPrice = parseFloat(row.getAttribute('data-price'));
            row.querySelector('.item-subtotal').textContent = (unitPrice * val) + ' บาท';
            
            updateCartTotal(true);
        }

        // ฟังก์ชันเปิดป๊อปอัปยืนยันการลบ
        function askDeleteItem(btn) {
            targetRowToDelete = btn.closest('.cart-item');
            const itemName = targetRowToDelete.getAttribute('data-name') || 'สินค้านี้';
            const itemOption = targetRowToDelete.getAttribute('data-option') || '';
            document.getElementById('delete-modal-msg').innerHTML = `คุณต้องการลบ <span class="text-white font-semibold">"${itemName} (${itemOption})"</span> ออกจากตะกร้าใช่หรือไม่?`;
            
            const modal = document.getElementById('delete-modal');
            const box = document.getElementById('delete-modal-box');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                box.classList.remove('scale-95');
            }, 10);
        }

        // ฟังก์ชันปิดป๊อปอัป
        function closeDeleteModal() {
            const modal = document.getElementById('delete-modal');
            const box = document.getElementById('delete-modal-box');
            modal.classList.add('opacity-0');
            box.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                targetRowToDelete = null;
            }, 200);
        }

        // ยืนยันการลบสินค้า
        function confirmDeleteItem() {
            if (targetRowToDelete) {
                const group = targetRowToDelete.closest('.cart-group');
                targetRowToDelete.remove();
                if (group && group.querySelectorAll('.cart-item').length === 0) group.remove();
                targetRowToDelete = null;
                updateCartTotal(true);
            }
            closeDeleteModal();
        }

        // คำนวณยอดรวมในตะกร้า
        function updateCartTotal(save = true) {
            document.querySelectorAll('.cart-group').forEach(g => {
                if (!g.querySelector('.cart-item')) g.remove();
            });

            const rows = document.querySelectorAll('.cart-item');
            const form = document.getElementById('cart-form');
            const emptyState = document.getElementById('cart-empty-state');

            if (rows.length === 0) {
                if (form) form.classList.add('hidden');
                if (emptyState) emptyState.classList.remove('hidden');
                if (save) saveCartToStorage();
                return;
            } else {
                if (form) form.classList.remove('hidden');
                if (emptyState) emptyState.classList.add('hidden');
            }

            let totalCount = 0;
            let totalPrice = 0;

            rows.forEach(row => {
                if (isRowChecked(row)) {
                    const qty = parseInt(row.querySelector('.item-qty-val').textContent) || 0;
                    const unitPrice = parseFloat(row.getAttribute('data-price')) || 0;
                    totalCount += qty;
                    totalPrice += (qty * unitPrice);
                }
                });

            const countEl = document.getElementById('cart-selected-count');
            const priceEl = document.getElementById('cart-total-price');
            if (countEl) countEl.textContent = totalCount;
            if (priceEl) priceEl.textContent = totalPrice + ' บาท';

            if (save) {
                saveCartToStorage();
            }
        }

        // บันทึกสถานะตะกร้าลง localStorage
        function saveCartToStorage() {
            const rows = document.querySelectorAll('.cart-item');
            const items = [];
            rows.forEach(row => {
                items.push({
                    id: row.getAttribute('data-id'),
                    name: row.getAttribute('data-name'),
                    option: row.getAttribute('data-option'),
                    price: parseFloat(row.getAttribute('data-price')),
                    qty: parseInt(row.querySelector('.item-qty-val').textContent),
                    gradient: row.getAttribute('data-gradient'),
                    checked: isRowChecked(row)
                });
            });
            localStorage.setItem('harmdung_cart_items', JSON.stringify(items));
        }

        // โหลดข้อมูลจาก localStorage มาแสดง
        function loadCartFromStorage() {
            const container = document.getElementById('cart-items-container');
            const form = document.getElementById('cart-form');
            const emptyState = document.getElementById('cart-empty-state');

            if (!container || !form || !emptyState) return;

            let items = [];
            const raw = localStorage.getItem('harmdung_cart_items');
            if (raw) {
                try {
                    items = JSON.parse(raw);
                    if (!Array.isArray(items)) items = [];
                } catch (e) {
                    items = [];
                }
            }

            container.innerHTML = '';

            if (items.length === 0) {
                form.classList.add('hidden');
                emptyState.classList.remove('hidden');
                return;
            }

            form.classList.remove('hidden');
            emptyState.classList.add('hidden');

            // จัดกลุ่มตามชื่อแพลตฟอร์ม (คงลำดับที่เพิ่มเข้ามา)
            const groups = new Map();
            items.forEach(item => {
                if (!groups.has(item.name)) groups.set(item.name, []);
                groups.get(item.name).push(item);
            });

            groups.forEach((groupItems, name) => {
                const gradient = groupItems[0].gradient || 'from-[#0b1b3d] to-[#043360]';
                const checked = groupItems.some(i => i.checked !== false);

                const rowsHtml = groupItems.map(item => `
                    <div class="cart-item flex flex-col sm:flex-row sm:items-center justify-between gap-3 py-3"
                        data-id="${item.id}" data-price="${item.price}" data-name="${item.name}"
                        data-option="${item.option}" data-gradient="${gradient}">
                        <div>
                            <p class="text-gray-500 text-xs">ตัวเลือกสินค้า <span class="item-option font-bold text-gray-700">${item.option}</span></p>
                            <span class="text-xs text-gray-400">ราคาต่อหน่วย: ${item.price} บาท</span>
                        </div>
                        <div class="flex items-center justify-between sm:justify-end gap-6">
                            <span class="item-subtotal text-lg font-black text-gray-900">${item.price * item.qty} บาท</span>
                            <div class="flex items-center gap-2">
                                <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden bg-gray-50 shadow-inner">
                                    <button type="button" onclick="adjustQty(this, -1)" class="px-3.5 py-1.5 text-gray-700 hover:bg-gray-200 font-bold transition cursor-pointer select-none" title="ลดจำนวน">-</button>
                                    <span class="px-3 py-1.5 text-sm font-bold min-w-[36px] text-center item-qty-val">${item.qty}</span>
                                    <button type="button" onclick="adjustQty(this, 1)" class="px-3.5 py-1.5 text-gray-700 hover:bg-gray-200 font-bold transition cursor-pointer select-none" title="เพิ่มจำนวน">+</button>
                                </div>
                                <button type="button" onclick="askDeleteItem(this)" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition cursor-pointer" title="ลบสินค้า">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');

                const groupEl = document.createElement('div');
                groupEl.className = 'cart-group bg-white text-black rounded-[24px] p-5 flex items-start gap-4 shadow-xl border border-gray-100 hover:shadow-2xl transition';
                groupEl.innerHTML = `
                    <input type="checkbox" ${checked ? 'checked' : ''} onchange="updateCartTotal(true)" class="group-checkbox w-5 h-5 accent-[#00fff2] rounded cursor-pointer mt-6 shrink-0">
                    <div class="w-28 aspect-video rounded-xl overflow-hidden shadow bg-gradient-to-r ${gradient} flex items-center justify-center text-white font-extrabold text-sm shrink-0">
                        ${platformBanner(name)}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-extrabold text-lg leading-tight text-gray-900">${name}</h3>
                        <div class="divide-y divide-gray-100 mt-1">${rowsHtml}</div>
                    </div>
                `;
                container.appendChild(groupEl);
            });

            updateCartTotal(false);
        }

        // จัดการเมื่อกดปุ่มชำระเงิน
        function handleCheckout(e) {
            e.preventDefault();
            const rows = document.querySelectorAll('.cart-item');
            const selectedItems = [];

            rows.forEach(row => {
                if (isRowChecked(row)) {
                    selectedItems.push({
                        id: row.getAttribute('data-id'),
                        name: row.getAttribute('data-name'),
                        option: row.getAttribute('data-option'),
                        price: parseFloat(row.getAttribute('data-price')),
                        qty: parseInt(row.querySelector('.item-qty-val').textContent),
                        gradient: row.getAttribute('data-gradient')
                    });
                }
                });

            if (selectedItems.length === 0) {
                alert('กรุณาเลือกสินค้าอย่างน้อย 1 รายการเพื่อดำเนินการชำระเงิน');
                return;
            }

            // บันทึกเฉพาะสินค้าที่ถูกเลือกไปให้หน้า Checkout
            localStorage.setItem('harmdung_checkout_items', JSON.stringify(selectedItems));
            window.location.href = '/checkout';
        }

        // เรียกทำงานทันทีที่สคริปต์โหลด และผูก Event ครบถ้วน
        loadCartFromStorage();
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', loadCartFromStorage);
        }
        window.addEventListener('pageshow', loadCartFromStorage);
    </script>
</body>
</html>