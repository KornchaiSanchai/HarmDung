<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์ของคุณ - HD Harmdung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#171717] text-white font-sans antialiased min-h-screen pb-16 selection:bg-[#00fff2] selection:text-black">

    <x-navbar active="member"></x-navbar>

    <!-- Main Member Container -->
    <main class="max-w-[1300px] mx-auto px-6 mt-10">
        
        <!-- Header & Action Bar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight flex items-center gap-3">
                    โปรไฟล์ของคุณ
                </h1>
                <p class="text-gray-400 text-sm mt-1">จัดการข้อมูลส่วนตัว การตั้งค่า และดูประวัติการทำรายการของคุณ</p>
            </div>

            <!-- Logout Button matching Figma Group 13 (#ef4444) -->
            <a href="/login" class="bg-[#ef4444] hover:bg-red-600 text-white font-bold px-6 py-2.5 rounded-full transition shadow-lg shadow-red-500/20 flex items-center gap-2 text-sm active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                ออกจากระบบ
            </a>
        </div>

        <!-- 4 Tabs matching Figma Member Info 1-4 (#24:468, #29:41, #29:111, #29:239) -->
        <div class="flex items-center gap-3 mt-8 overflow-x-auto pb-3 border-b border-gray-800/80">
            <button onclick="switchTab('profile')" id="tab-btn-profile" 
                    class="tab-btn px-6 py-2.5 rounded-full text-sm font-bold transition flex items-center gap-2 bg-[#333333] text-white shadow-inner">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                ข้อมูลผู้ใช้
            </button>
            <button onclick="switchTab('settings')" id="tab-btn-settings" 
                    class="tab-btn px-6 py-2.5 rounded-full text-sm font-bold transition flex items-center gap-2 bg-transparent text-gray-400 hover:text-white hover:bg-gray-800/50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                การตั้งค่าผู้ใช้
            </button>
            <button onclick="switchTab('orders')" id="tab-btn-orders" 
                    class="tab-btn px-6 py-2.5 rounded-full text-sm font-bold transition flex items-center gap-2 bg-transparent text-gray-400 hover:text-white hover:bg-gray-800/50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                ประวัติการซื้อ
            </button>
            <button onclick="switchTab('coupons')" id="tab-btn-coupons" 
                    class="tab-btn px-6 py-2.5 rounded-full text-sm font-bold transition flex items-center gap-2 bg-transparent text-gray-400 hover:text-white hover:bg-gray-800/50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                ประวัติคูปอง
            </button>
        </div>

        <!-- =================== TAB 1: ข้อมูลผู้ใช้ (Profile) =================== -->
        <div id="tab-content-profile" class="tab-pane mt-8">
            <!-- User Overview Card -->
            <div class="flex flex-col md:flex-row items-center gap-8">
                <!-- Avatar circle matching Figma Group 11 (#24:468) -->
                <div class="flex items-center justify-center shrink-0">
                    <div class="w-full h-full bg-[#171717] rounded-full flex items-center justify-center overflow-hidden">
                        <img src="/images/avatar.png" alt="User Avatar" class="w-24 h-24 object-contain filter invert opacity-90">
                    </div>
                </div>

                <div class="space-y-3 text-center md:text-left flex-1">
                    <div class="flex flex-col md:flex-row md:items-center gap-3">
                        <h2 class="text-2xl md:text-3xl font-extrabold text-white">HarmDung User</h2>
                    </div>
                    <p class="text-gray-300 font-medium">xxxxxxxxx@gmail.com</p>
                </div>
            </div>

            <!-- Section: Recently Purchased matching Figma #24:468 -->
            <div class="mt-10">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#00fff2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    สินค้าที่ซื้อล่าสุด
                </h3>

                <div class="space-y-4">
                    <!-- Item 1 -->
                    <div class="bg-white text-black rounded-[24px] p-6 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6 hover:shadow-2xl transition">
                        <div class="flex items-center gap-5">
                            <div class="w-24 aspect-video rounded-xl bg-gradient-to-r from-[#5a1bb9] to-[#204ce4] flex items-center justify-center text-white font-extrabold text-sm shadow">
                                HIV min
                            </div>
                            <div>
                                <h4 class="text-lg font-extrabold leading-tight">HIV min</h4>
                                <p class="text-gray-500 text-xs mt-1">แพ็กเกจ # 30 วัน (ความคมชัดระดับ 4K UHD)</p>
                                <span class="inline-block mt-2 text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full">
                                    พร้อมใช้งาน (เหลือ 29 วัน)
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between md:justify-end gap-6 w-full md:w-auto border-t md:border-0 border-gray-100 pt-4 md:pt-0">
                            <div class="text-right">
                                <div class="text-xs text-gray-400">ราคา</div>
                                <div class="text-xl font-black text-gray-900">70 บาท</div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="bg-white text-black rounded-[24px] p-6 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6 hover:shadow-2xl transition">
                        <div class="flex items-center gap-5">
                            <div class="w-24 aspect-video rounded-xl bg-gradient-to-r from-[#0b1b3d] to-[#043360] flex items-center justify-center text-white font-extrabold text-sm shadow">
                                Thisney-
                            </div>
                            <div>
                                <h4 class="text-lg font-extrabold leading-tight">Thisney-</h4>
                                <p class="text-gray-500 text-xs mt-1">แพ็กเกจ # 7 วัน (รองรับทุกอุปกรณ์)</p>
                                <span class="inline-block mt-2 text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full">
                                    พร้อมใช้งาน (เหลือ 6 วัน)
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between md:justify-end gap-6 w-full md:w-auto border-t md:border-0 border-gray-100 pt-4 md:pt-0">
                            <div class="text-right">
                                <div class="text-xs text-gray-400">ราคา</div>
                                <div class="text-xl font-black text-gray-900">50 บาท</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- =================== TAB 2: การตั้งค่าผู้ใช้ (Settings) matching Figma #29:41 =================== -->
        <div id="tab-content-settings" class="tab-pane mt-8 hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Box 1: Profile Information -->
                <div class="rounded-[28px] p-8 border border-gray-800 shadow-xl space-y-6">
                    <div>
                        <h3 class="text-xl font-bold text-white">ข้อมูลส่วนตัว</h3>
                        <p class="text-xs text-gray-400 mt-1">Profile Information</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-300 mb-2">ชื่อผู้ใช้งาน / Username</label>
                            <input type="text" value="HarmDung User" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#00fff2]">
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-bold text-gray-300">อีเมล / Email</label>
                            </div>
                            <input type="email" value="xxxxxxxxx@gmail.com" disabled class="w-full bg-gray-800/50 border border-gray-700/50 rounded-xl px-4 py-3 text-sm text-gray-400 cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <!-- Box 2: Change Password matching Figma #29:41 -->
                <div class="rounded-[28px] p-8 border border-gray-800 shadow-xl space-y-6">
                    <div>
                        <h3 class="text-xl font-bold text-white">เปลี่ยนรหัสผ่าน</h3>
                        <p class="text-xs text-gray-400 mt-1">Change Password</p>
                    </div>

                    <form onsubmit="event.preventDefault(); alert('บันทึกรหัสผ่านใหม่สำเร็จ!');" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-300 mb-2">รหัสผ่านปัจจุบัน / Current Password</label>
                            <input type="password" placeholder="••••••••" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#00fff2]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-300 mb-2">รหัสผ่านใหม่ / New Password</label>
                            <input type="password" placeholder="••••••••" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#00fff2]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-300 mb-2">ยืนยันรหัสผ่านใหม่ / Confirm New Password</label>
                            <input type="password" placeholder="••••••••" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#00fff2]">
                        </div>

                        <!-- Save button matching Figma Group 14 (#09f3ee) -->
                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold px-8 py-3 rounded-full transition shadow-lg shadow-cyan-500/20 flex items-center gap-2 text-sm active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                บันทึก
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <!-- =================== TAB 3: ประวัติการซื้อ (Orders) matching Figma #29:111 =================== -->
        <div id="tab-content-orders" class="tab-pane mt-8 hidden">
            <!-- Search Bar matching Figma Rectangle 9 / text "ค้นหาคำสั่งซื้อ" -->
            <div class="relative max-w-md mb-6">
                <input type="text" placeholder="ค้นหาคำสั่งซื้อ..." 
                       class="w-full bg-white text-black pl-5 pr-12 py-3 rounded-full text-sm outline-none focus:ring-2 focus:ring-[#00fff2] placeholder-gray-400 shadow-md">
                <button class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>

            <!-- Orders Table Container -->
            <div class="bg-white text-black rounded-[28px] p-8 shadow-2xl overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="border-b border-gray-200 text-gray-500 text-xs font-bold uppercase tracking-wider">
                            <th class="py-4 px-4">สินค้าที่ซื้อล่าสุด / Recently Purchased</th>
                            <th class="py-4 px-4 text-center">วันที่สั่งซื้อ / Purchased At</th>
                            <th class="py-4 px-4 text-center">จำนวน</th>
                            <th class="py-4 px-4 text-right">ยอดรวม</th>
                            <th class="py-4 px-4 text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <!-- Order 1 -->
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-5 px-4 flex items-center gap-4">
                                <div class="w-16 aspect-video rounded-lg bg-gradient-to-r from-[#5a1bb9] to-[#204ce4] flex items-center justify-center text-white font-bold text-xs shrink-0">
                                    HIV min
                                </div>
                                <div>
                                    <div class="font-extrabold text-gray-900">HIV min (# 30 วัน)</div>
                                    <div class="text-xs text-gray-400">Order #HD-89021</div>
                                </div>
                            </td>
                            <td class="py-5 px-4 text-center text-gray-600 font-medium">2026-10-22 17:45</td>
                            <td class="py-5 px-4 text-center font-bold">1</td>
                            <td class="py-5 px-4 text-right font-black text-gray-900">70 บาท</td>
                            <td class="py-5 px-4 text-center">
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">
                                    สำเร็จ
                                </span>
                            </td>
                        </tr>

                        <!-- Order 2 -->
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-5 px-4 flex items-center gap-4">
                                <div class="w-16 aspect-video rounded-lg bg-gradient-to-r from-[#0b1b3d] to-[#043360] flex items-center justify-center text-white font-bold text-xs shrink-0">
                                    Thisney-
                                </div>
                                <div>
                                    <div class="font-extrabold text-gray-900">Thisney- (# 7 วัน)</div>
                                    <div class="text-xs text-gray-400">Order #HD-88914</div>
                                </div>
                            </td>
                            <td class="py-5 px-4 text-center text-gray-600 font-medium">2026-10-20 14:12</td>
                            <td class="py-5 px-4 text-center font-bold">2</td>
                            <td class="py-5 px-4 text-right font-black text-gray-900">50 บาท</td>
                            <td class="py-5 px-4 text-center">
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">
                                    สำเร็จ
                                </span>
                            </td>
                        </tr>

                        <!-- Order 3 -->
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-5 px-4 flex items-center gap-4">
                                <div class="w-16 aspect-video rounded-lg bg-gradient-to-r from-[#3e0808] to-[#1a0202] flex items-center justify-center text-white font-bold text-xs shrink-0">
                                    NETFLUX
                                </div>
                                <div>
                                    <div class="font-extrabold text-gray-900">NETFLUX (# 30 วัน)</div>
                                    <div class="text-xs text-gray-400">Order #HD-87652</div>
                                </div>
                            </td>
                            <td class="py-5 px-4 text-center text-gray-600 font-medium">2026-09-15 09:30</td>
                            <td class="py-5 px-4 text-center font-bold">1</td>
                            <td class="py-5 px-4 text-right font-black text-gray-900">99 บาท</td>
                            <td class="py-5 px-4 text-center">
                                <span class="bg-gray-200 text-gray-700 text-xs font-bold px-3 py-1 rounded-full">
                                    หมดอายุแล้ว
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- =================== TAB 4: ประวัติคูปอง (Coupons) matching Figma #29:239 =================== -->
        <div id="tab-content-coupons" class="tab-pane mt-8 hidden">
            <!-- Coupon Table Container -->
            <div class="bg-white text-black rounded-[28px] p-8 shadow-2xl overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="border-b border-gray-200 text-gray-500 text-xs font-bold uppercase tracking-wider">
                            <th class="py-4 px-4">คูปองที่ใช้ล่าสุด / Recently Used Coupon(s)</th>
                            <th class="py-4 px-4 text-center">วันที่ใช้งาน / Used At</th>
                            <th class="py-4 px-4 text-center">ส่วนลดที่ได้รับ</th>
                            <th class="py-4 px-4 text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <!-- Coupon 1 -->
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-5 px-4 flex items-center gap-3">
                                <span class="px-3 py-1.5 bg-cyan-100 text-cyan-800 font-black rounded-lg text-xs tracking-wider">
                                    DISCOUNT10
                                </span>
                                <div>
                                    <div class="font-extrabold text-gray-900">ส่วนลดคำสั่งซื้อ 10%</div>
                                    <div class="text-xs text-gray-400">ใช้ในคำสั่งซื้อ #HD-89021</div>
                                </div>
                            </td>
                            <td class="py-5 px-4 text-center text-gray-600 font-medium">2026-10-22 17:45</td>
                            <td class="py-5 px-4 text-center font-extrabold text-emerald-600">-12.00 บาท</td>
                            <td class="py-5 px-4 text-center">
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">
                                    ใช้งานแล้ว
                                </span>
                            </td>
                        </tr>

                        <!-- Coupon 2 -->
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-5 px-4 flex items-center gap-3">
                                <span class="px-3 py-1.5 bg-amber-100 text-amber-800 font-black rounded-lg text-xs tracking-wider">
                                    WELCOME50
                                </span>
                                <div>
                                    <div class="font-extrabold text-gray-900">ส่วนลดต้อนรับสมาชิกใหม่ 50 บาท</div>
                                    <div class="text-xs text-gray-400">ใช้ในคำสั่งซื้อ #HD-88914</div>
                                </div>
                            </td>
                            <td class="py-5 px-4 text-center text-gray-600 font-medium">2026-10-20 14:12</td>
                            <td class="py-5 px-4 text-center font-extrabold text-emerald-600">-50.00 บาท</td>
                            <td class="py-5 px-4 text-center">
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">
                                    ใช้งานแล้ว
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script>
        function switchTab(tabKey) {
            // Hide all tab panes
            document.querySelectorAll('.tab-pane').forEach(el => el.classList.add('hidden'));
            
            // Remove active styles from all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-[#333333]', 'text-white', 'shadow-inner');
                btn.classList.add('bg-transparent', 'text-gray-400');
            });

            // Show selected tab pane
            const targetPane = document.getElementById('tab-content-' + tabKey);
            if (targetPane) {
                targetPane.classList.remove('hidden');
            }

            // Highlight selected button
            const targetBtn = document.getElementById('tab-btn-' + tabKey);
            if (targetBtn) {
                targetBtn.classList.remove('bg-transparent', 'text-gray-400');
                targetBtn.classList.add('bg-[#333333]', 'text-white', 'shadow-inner');
            }
        }

        // Handle URL parameter tab
        const urlParams = new URLSearchParams(window.location.search);
        const initialTab = urlParams.get('tab');
        if (initialTab && ['profile', 'settings', 'orders', 'coupons'].includes(initialTab)) {
            switchTab(initialTab);
        }
    </script>

</body>
</html>
