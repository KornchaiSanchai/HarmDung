<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <a href="/member" class="w-10 h-10 bg-[#00fff2] rounded-full flex items-center justify-center text-black font-bold shadow-md hover:scale-105 transition" title="ข้อมูลสมาชิก">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </a>
            </div>
        </nav>

        <!-- Checkout Main Content -->
        <main class="max-w-[1100px] mx-auto px-6 mt-10">
            <h1 class="text-3xl font-extrabold text-center mb-8 tracking-tight">ชำระเงิน</h1>

            <div class="bg-white text-black rounded-[28px] p-8 md:p-12 shadow-2xl border border-gray-100">
                
                <!-- หัวตาราง -->
                <div class="grid grid-cols-12 text-gray-600 font-bold text-sm sm:text-base pb-4 border-b border-gray-200">
                    <div class="col-span-6">สินค้าที่สั่งซื้อแล้ว</div>
                    <div class="col-span-2 text-center">ราคาต่อหน่วย</div>
                    <div class="col-span-2 text-center">จำนวน</div>
                    <div class="col-span-2 text-right">รายการย่อย</div>
                </div>

                <!-- รายการสินค้า 1 -->
                <div class="grid grid-cols-12 items-center py-6 border-b border-gray-100 gap-4 checkout-row" data-price="25">
                    <div class="col-span-6 flex items-center gap-5">
                        <div class="w-36 sm:w-44 aspect-video rounded-2xl overflow-hidden shadow-md bg-gradient-to-r from-[#0b1b3d] to-[#043360] flex items-center justify-center text-white font-extrabold text-base sm:text-lg tracking-wide shrink-0 border border-slate-700/30">
                            Thisney-
                        </div>
                        <div>
                            <h3 class="font-extrabold text-xl sm:text-2xl text-gray-900 leading-tight">Thisney-</h3>
                            <p class="text-gray-500 text-sm sm:text-base mt-1.5 font-medium">ตัวเลือกสินค้า <span class="text-gray-700 font-semibold bg-gray-100 px-2.5 py-0.5 rounded-lg"># 7 วัน</span></p>
                        </div>
                    </div>
                    <div class="col-span-2 text-center font-semibold text-base sm:text-lg text-gray-800">25 บาท</div>
                    <div class="col-span-2 text-center">
                        <span class="font-bold text-base sm:text-lg text-gray-900 item-qty bg-gray-100 px-3 py-1 rounded-xl">2</span>
                    </div>
                    <div class="col-span-2 text-right font-extrabold text-lg sm:text-xl text-gray-900 item-subtotal">50 บาท</div>
                </div>

                <!-- รายการสินค้า 2 -->
                <div class="grid grid-cols-12 items-center py-6 border-b border-gray-200 gap-4 checkout-row" data-price="70">
                    <div class="col-span-6 flex items-center gap-5">
                        <div class="w-36 sm:w-44 aspect-video rounded-2xl overflow-hidden shadow-md bg-gradient-to-r from-[#5a1bb9] to-[#204ce4] flex items-center justify-center text-white font-extrabold text-base sm:text-lg tracking-wide shrink-0 border border-purple-700/30">
                            HIV min
                        </div>
                        <div>
                            <h3 class="font-extrabold text-xl sm:text-2xl text-gray-900 leading-tight">HIV min</h3>
                            <p class="text-gray-500 text-sm sm:text-base mt-1.5 font-medium">ตัวเลือกสินค้า <span class="text-gray-700 font-semibold bg-gray-100 px-2.5 py-0.5 rounded-lg"># 30 วัน</span></p>
                        </div>
                    </div>
                    <div class="col-span-2 text-center font-semibold text-base sm:text-lg text-gray-800">70 บาท</div>
                    <div class="col-span-2 text-center">
                        <span class="font-bold text-base sm:text-lg text-gray-900 item-qty bg-gray-100 px-3 py-1 rounded-xl">1</span>
                    </div>
                    <div class="col-span-2 text-right font-extrabold text-lg sm:text-xl text-gray-900 item-subtotal">70 บาท</div>
                </div>

                <!-- ส่วนเลือกคูปองส่วนลด -->
                <div class="py-6 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-700 flex items-center justify-center shrink-0 border border-cyan-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </div>
                            <div>
                                <h2 class="font-bold text-gray-900 text-base">ส่วนลดคำสั่งซื้อ (คูปอง)</h2>
                                <p class="text-xs text-gray-500">เลือกใช้ส่วนลดจากคูปองที่มีอยู่ หรือกรอกโค้ดส่วนลดพิเศษ</p>
                            </div>
                        </div>

                        <!-- ตัวเลือกวิธีใช้ส่วนลด (เลือกคูปองที่มีอยู่ หรือ กรอกโค้ด) -->
                        <div class="inline-flex p-1 bg-gray-100 rounded-xl self-start md:self-auto border border-gray-200" role="tablist">
                            <button type="button" id="tab-btn-existing" onclick="switchDiscountMode('existing')" class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all bg-white text-gray-900 shadow-sm flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-3.5 h-3.5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <span>เลือกคูปองที่มีอยู่</span>
                            </button>
                            <button type="button" id="tab-btn-code" onclick="switchDiscountMode('code')" class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all text-gray-500 hover:text-gray-900 flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                <span>กรอก Code Coupon</span>
                            </button>
                        </div>
                    </div>

                    <!-- Mode 1: เลือกคูปองที่มีอยู่แล้ว -->
                    <div id="mode-existing" class="space-y-3">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                            <div class="relative flex-1">
                                <select id="coupon-select" onchange="handleSelectCouponChange()" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm sm:text-base font-semibold bg-white outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition cursor-pointer text-gray-800 shadow-sm">
                                    <option value="">-- กรุณาเลือกคูปองส่วนลด --</option>
                                    <option value="none">🚫 ไม่ใช้คูปองส่วนลด</option>
                                </select>
                            </div>
                            <button type="button" onclick="applySelectedCoupon()" class="px-6 py-3 bg-gray-900 hover:bg-black text-white text-sm sm:text-base font-bold rounded-xl transition shadow-sm active:scale-95 cursor-pointer shrink-0">
                                ใช้คูปองนี้
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 flex items-center gap-1.5">
                            <span class="inline-block w-2 h-2 rounded-full bg-cyan-500"></span>
                            <span>คูปองจะสามารถใช้งานได้เมื่อยอดสั่งซื้อถึงเงื่อนไขราคาขั้นต่ำที่กำหนด</span>
                        </p>
                    </div>

                    <!-- Mode 2: กรอก Code Coupon -->
                    <div id="mode-code" class="space-y-3 hidden">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                            <div class="relative flex-1">
                                <input type="text" id="coupon-code-input" placeholder="พิมพ์โค้ดส่วนลด..." onkeydown="if(event.key === 'Enter') applyCodeCoupon()" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm sm:text-base uppercase font-semibold outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 bg-gray-50 transition placeholder:normal-case placeholder:font-normal text-gray-900 shadow-sm">
                            </div>
                            <button type="button" onclick="applyCodeCoupon()" class="px-7 py-3 bg-gray-900 hover:bg-black text-white text-sm sm:text-base font-bold rounded-xl transition shadow-sm active:scale-95 cursor-pointer flex items-center justify-center gap-2 shrink-0">
                                <span>ใช้โค้ด</span>
                            </button>
                        </div>
                    </div>

                    <!-- แจ้งเตือนข้อผิดพลาด / ความสำเร็จ -->
                    <div id="discount-feedback" class="mt-3 hidden p-3 rounded-xl text-sm font-medium transition-all"></div>

                    <!-- แถบแสดงคูปองที่กำลังใช้งาน -->
                    <div id="active-coupon-card" class="mt-4 p-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border border-cyan-200 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 hidden">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-cyan-500 text-white flex items-center justify-center font-bold text-sm shadow-sm shrink-0">
                                🎟️
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold uppercase tracking-wider text-cyan-900 bg-cyan-200/70 px-2.5 py-0.5 rounded-full" id="active-coupon-code"></span>
                                    <span class="text-xs font-semibold text-emerald-700 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        เข้าเงื่อนไขราคาแล้ว
                                    </span>
                                </div>
                                <p id="active-coupon-desc" class="text-xs font-medium text-gray-700 mt-1"></p>
                            </div>
                        </div>
                        <button type="button" onclick="removeCoupon()" class="text-xs text-rose-600 hover:text-rose-700 font-bold px-3 py-1.5 hover:bg-rose-50 rounded-lg transition border border-rose-200 self-end sm:self-auto cursor-pointer">
                            ✕ ยกเลิกคูปอง
                        </button>
                    </div>
                </div>

                <!-- สรุปรายละเอียดราคา -->
                <div class="py-5 border-b border-gray-200 space-y-2.5 text-sm sm:text-base">
                    <div class="flex justify-between text-gray-600 font-medium">
                        <span>ยอดรวมสินค้า (Subtotal)</span>
                        <span id="summary-subtotal" class="font-bold text-gray-900">0 บาท</span>
                    </div>
                    <div id="summary-discount-row" class="flex justify-between text-emerald-600 font-medium hidden">
                        <span class="flex items-center gap-1.5">
                            <span>ส่วนลดคูปอง</span>
                            <span id="summary-discount-badge" class="text-xs bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full font-bold"></span>
                        </span>
                        <span id="summary-discount-amount" class="font-bold text-emerald-600">-0 บาท</span>
                    </div>
                </div>

                <!-- สรุปราคาและปุ่มยืนยันชำระเงิน (กรอบช่องชำระเงินขนาดใหญ่ขึ้น) -->
                <div class="mt-8 bg-gray-50/90 -mx-8 -mb-8 md:-mx-12 md:-mb-12 p-6 md:p-8 rounded-b-[28px] border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div>
                        <div class="text-xs text-gray-500 font-semibold mb-1">ยอดรวมที่ต้องชำระทั้งหมด</div>
                        <div class="text-xl sm:text-2xl font-bold text-gray-900">
                            คำสั่งซื้อทั้งหมด <span id="total-qty" class="text-cyan-600 font-black">3</span> ชิ้น : 
                            <span id="grand-total" class="text-3xl sm:text-2xl font-black text-black ml-1.5 tracking-tight">120 บาท</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <a href="/cart" class="w-full sm:w-auto text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold px-7 py-3.5 rounded-xl transition text-sm sm:text-base">
                            ย้อนกลับ
                        </a>
                        <a href="/payment-success" class="w-full sm:w-auto text-center bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold px-10 py-3.5 rounded-xl transition shadow-lg shadow-cyan-500/25 text-base active:scale-95 flex items-center justify-center gap-2">
                            <span>สั่งซื้อสินค้า</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        // รายการคูปองและผลสรุปราคาที่ประเมินจาก CouponController & CouponService ฝั่ง Backend
        const COUPONS = @json($coupons ?? []);
        const INITIAL_SUMMARY = @json($summary ?? null);

        let activeCoupon = (INITIAL_SUMMARY && INITIAL_SUMMARY.coupon) ? {
            code: INITIAL_SUMMARY.code,
            name: INITIAL_SUMMARY.name,
            desc: INITIAL_SUMMARY.desc,
            discount: INITIAL_SUMMARY.discount
        } : null;

        // เริ่มต้นโหลดหน้า
        window.onload = function() {
            const rows = document.querySelectorAll('.checkout-row');
            let totalQty = 0;
            rows.forEach(r => totalQty += (parseInt(r.querySelector('.item-qty')?.textContent) || 0));
            document.getElementById('total-qty').textContent = totalQty;

            const initialData = INITIAL_SUMMARY || {
                subtotal: 120,
                discount: 0,
                total: 120
            };
            updateCheckoutUI(initialData);
        };

        // สลับโหมดส่วนลด (เลือกคูปองที่มีอยู่ / กรอกโค้ด)
        function switchDiscountMode(mode) {
            const btnExisting = document.getElementById('tab-btn-existing');
            const btnCode = document.getElementById('tab-btn-code');
            const modeExisting = document.getElementById('mode-existing');
            const modeCode = document.getElementById('mode-code');

            if (mode === 'existing') {
                btnExisting.className = 'px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all bg-white text-gray-900 shadow-sm flex items-center gap-1.5 cursor-pointer';
                btnCode.className = 'px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all text-gray-500 hover:text-gray-900 flex items-center gap-1.5 cursor-pointer';
                modeExisting.classList.remove('hidden');
                modeCode.classList.add('hidden');
            } else {
                btnCode.className = 'px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all bg-white text-gray-900 shadow-sm flex items-center gap-1.5 cursor-pointer';
                btnExisting.className = 'px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all text-gray-500 hover:text-gray-900 flex items-center gap-1.5 cursor-pointer';
                modeCode.classList.remove('hidden');
                modeExisting.classList.add('hidden');
            }
            clearFeedback();
        }

        // ดึงรายการสินค้าในหน้า Checkout เพื่อส่งไปคำนวณที่ Backend
        function getCartItemsData() {
            const rows = document.querySelectorAll('.checkout-row');
            const items = [];
            rows.forEach((row, index) => {
                const qty = parseInt(row.querySelector('.item-qty')?.textContent) || 1;
                const unitPrice = parseFloat(row.getAttribute('data-price')) || 0;
                items.push({
                    product_id: index + 1,
                    price: unitPrice,
                    quantity: qty,
                    plan_name: row.querySelector('h3')?.textContent || 'สินค้า'
                });
            });
            return items;
        }

        // แสดงตัวเลือกใน Dropdown พร้อมสถานะเงื่อนไขที่คำนวณจาก Backend
        function renderCouponSelectOptions(subtotal) {
            const select = document.getElementById('coupon-select');
            const currentSelectedValue = select.value;

            select.innerHTML = `
                <option value="">-- กรุณาเลือกคูปองส่วนลด --</option>
                <option value="none">🚫 ไม่ใช้คูปองส่วนลด</option>
            `;

            COUPONS.forEach(c => {
                const option = document.createElement('option');
                option.value = c.code;

                let statusTag = '✅ ใช้ได้';
                let isUsable = true;

                if (c.is_expired) {
                    statusTag = '⚠️ หมดอายุแล้ว';
                    isUsable = false;
                } else if (c.is_exhausted) {
                    statusTag = '⚠️ สิทธิ์เต็มแล้ว';
                    isUsable = false;
                } else if (subtotal < c.min_spend) {
                    statusTag = `⚠️ ไม่เข้าเงื่อนไข (ขั้นต่ำ ฿${c.min_spend})`;
                    isUsable = false;
                }

                option.textContent = `${statusTag} : ${c.name} (${c.code}) - ${c.desc}`;
                if (!isUsable) {
                    option.style.color = '#9ca3af';
                }
                select.appendChild(option);
            });

            if (activeCoupon) {
                select.value = activeCoupon.code;
            } else if (currentSelectedValue) {
                select.value = currentSelectedValue;
            }
        }

        // เมื่อเปลี่ยนค่าใน Dropdown
        function handleSelectCouponChange() {
            clearFeedback();
            const select = document.getElementById('coupon-select');
            if (select.value === 'none') {
                removeCouponOnBackend();
            }
        }

        // กดปุ่มใช้คูปองจาก Dropdown (เรียกไปที่ Backend)
        function applySelectedCoupon() {
            const select = document.getElementById('coupon-select');
            const code = select.value;

            if (!code) {
                showFeedback('error', 'กรุณาเลือกคูปองส่วนลดที่ต้องการใช้');
                return;
            }

            applyCouponOnBackend(code);
        }

        // กดปุ่มใช้โค้ดส่วนลดจากการกรอก (เรียกไปที่ Backend)
        function applyCodeCoupon() {
            const input = document.getElementById('coupon-code-input');
            const code = input.value.trim().toUpperCase();

            if (!code) {
                showFeedback('error', 'กรุณากรอกโค้ดส่วนลด');
                return;
            }

            applyCouponOnBackend(code);
        }

        // เรียก CouponController::select เพื่อตรวจสอบและคำนวณส่วนลดจากฝั่ง Backend
        async function applyCouponOnBackend(code) {
            clearFeedback();

            if (code === 'none') {
                removeCouponOnBackend();
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const items = getCartItemsData();

            try {
                const response = await fetch('{{ route('coupon.apply') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ code: code, items: items })
                });

                const data = await response.json();

                if (response.ok && data.valid) {
                    activeCoupon = {
                        code: data.code,
                        name: data.name,
                        desc: data.desc,
                        discount: data.discount
                    };
                    updateCheckoutUI(data);
                    showFeedback('success', data.message);

                    const select = document.getElementById('coupon-select');
                    if (select && select.querySelector(`option[value="${data.code}"]`)) {
                        select.value = data.code;
                    }
                } else {
                    showFeedback('error', data.message || 'ไม่สามารถใช้งานคูปองนี้ได้');
                }
            } catch (err) {
                showFeedback('error', 'เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์');
            }
        }

        // เรียก CouponController::remove เพื่อยกเลิกคูปองจากฝั่ง Backend
        async function removeCouponOnBackend() {
            clearFeedback();
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const items = getCartItemsData();

            try {
                const response = await fetch('{{ route('coupon.remove') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ items: items })
                });

                const data = await response.json();
                activeCoupon = null;
                document.getElementById('coupon-select').value = 'none';
                document.getElementById('coupon-code-input').value = '';
                updateCheckoutUI(data);
                showFeedback('info', data.message || 'เลือกไม่ใช้คูปองส่วนลด');
            } catch (err) {
                showFeedback('error', 'เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์');
            }
        }

        // ยกเลิกคูปอง
        function removeCoupon() {
            removeCouponOnBackend();
        }

        // อัปเดต UI ยอดรวมตามผลลัพธ์ที่ส่งกลับมาจาก Backend
        function updateCheckoutUI(data) {
            const subtotal = Number(data.subtotal) || 0;
            const discount = Number(data.discount) || 0;
            const total = Number(data.total) || subtotal;

            document.getElementById('summary-subtotal').textContent = subtotal.toFixed(2) + ' บาท';
            document.getElementById('grand-total').textContent = Math.round(total) + ' บาท';

            // แสดง/ซ่อน แถวส่วนลดในสรุปราคา
            const discountRow = document.getElementById('summary-discount-row');
            const discountBadge = document.getElementById('summary-discount-badge');
            const discountAmountEl = document.getElementById('summary-discount-amount');

            if (discount > 0 && activeCoupon) {
                discountRow.classList.remove('hidden');
                discountBadge.textContent = activeCoupon.code;
                discountAmountEl.textContent = `-${discount.toFixed(2)} บาท`;
            } else {
                discountRow.classList.add('hidden');
            }

            // แสดง/ซ่อน แถบ Active Coupon Card
            const activeCard = document.getElementById('active-coupon-card');
            if (activeCoupon && discount > 0) {
                activeCard.classList.remove('hidden');
                document.getElementById('active-coupon-code').textContent = activeCoupon.code;
                document.getElementById('active-coupon-desc').textContent = `${activeCoupon.name || activeCoupon.code} | ${activeCoupon.desc || ''} (ประหยัด ฿${discount.toFixed(2)})`;
            } else {
                activeCard.classList.add('hidden');
            }

            // อัปเดต Dropdown ตามยอดรวมปัจจุบัน
            renderCouponSelectOptions(subtotal);
        }

        // แจ้งเตือน UI
        function showFeedback(type, message) {
            const box = document.getElementById('discount-feedback');
            box.classList.remove('hidden', 'bg-rose-50', 'text-rose-700', 'border-rose-200', 'bg-emerald-50', 'text-emerald-700', 'border-emerald-200', 'bg-cyan-50', 'text-cyan-800', 'border-cyan-200');
            box.classList.add('border');

            if (type === 'error') {
                box.classList.add('bg-rose-50', 'text-rose-700', 'border-rose-200');
            } else if (type === 'success') {
                box.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-200');
            } else {
                box.classList.add('bg-cyan-50', 'text-cyan-800', 'border-cyan-200');
            }

            box.innerHTML = message;
        }

        function clearFeedback() {
            const box = document.getElementById('discount-feedback');
            box.classList.add('hidden');
            box.innerHTML = '';
        }
    </script>
</body>
</html>