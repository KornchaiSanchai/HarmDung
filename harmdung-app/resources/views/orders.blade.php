<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการสั่งซื้อ - HD Harmdung</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#171717] text-white font-sans antialiased min-h-screen pb-16">

    <x-navbar active="orders"></x-navbar>

    <main class="max-w-[900px] mx-auto px-6 mt-10">
        <h1 class="text-2xl font-bold mb-8">ประวัติการสั่งซื้อ</h1>

        @if (session('success'))
            <div class="mb-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-sm px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-5">
            @forelse ($orders as $order)
                <div class="bg-white text-black rounded-[24px] p-6 shadow-xl">
                    <div class="flex items-center justify-between border-b border-gray-200 pb-3 mb-3">
                        <div>
                            <div class="font-extrabold">คำสั่งซื้อ #{{ $order->id }}</div>
                            <div class="text-xs text-gray-500">{{ $order->formatted_date }}</div>
                        </div>
                        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full">
                            {{ $order->status_label }}
                        </span>
                    </div>

                    @foreach ($order->products as $product)
                        <div class="flex items-center justify-between py-2 text-sm border-b border-gray-100 last:border-b-0">
                            <div>
                                <span class="font-bold">{{ $product->platform->name ?? '-' }}</span>
                                <span class="text-gray-500">· {{ $product->plan_name }}</span>
                                @if ($product->has_accounts)
                                    <div class="mt-1">
                                        <button type="button" 
                                                onclick="openAccountModal('{{ addslashes($product->platform->name) }}', '{{ addslashes($product->plan_name) }}', '{{ $order->id }}', {{ json_encode($product->order_accounts) }})"
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-cyan-50 hover:bg-[#00fff2]/20 text-[#0891b2] hover:text-black font-extrabold text-xs transition border border-[#00fff2]/40 shadow-sm active:scale-95 group">
                                            <svg class="w-3.5 h-3.5 text-cyan-600 group-hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                            <span>ดูไอดีหนัง ({{ $product->order_accounts->count() }})</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="text-gray-600">
                                {{ $product->pivot->quantity }} × {{ $product->formatted_unit_price }}
                                = <span class="font-bold text-black">{{ $product->formatted_subtotal }} บาท</span>
                            </div>
                        </div>
                    @endforeach

                    <div class="border-t border-gray-200 mt-3 pt-3 text-sm text-right space-y-1">
                        <div class="text-gray-500">ส่วนลด: -{{ $order->formatted_discount }} บาท</div>
                        <div class="text-lg font-extrabold">รวม {{ $order->formatted_total }} บาท</div>
                    </div>
                </div>
            @empty
                <div class="bg-gray-900/50 rounded-[24px] p-12 text-center border border-gray-800">
                    <p class="text-gray-400 text-sm">ยังไม่มีประวัติการสั่งซื้อ</p>
                    <a href="{{ route('products') }}" class="inline-block mt-4 bg-[#00fff2] text-black font-bold px-6 py-2 rounded-full text-xs">เลือกซื้อสินค้า</a>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Modal ดูข้อมูลไอดีหนัง (Movie Account Modal) -->
    <div id="accountModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm transition-opacity duration-200">
        <div class="bg-[#1a1a1a] text-white border border-gray-800 rounded-[28px] max-w-lg w-full p-6 sm:p-8 shadow-2xl relative max-h-[90vh] flex flex-col transform transition-all duration-200 scale-95 opacity-0" id="accountModalBox">
            
            <!-- Header -->
            <div class="flex items-start justify-between pb-4 border-b border-gray-800">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-[#00fff2]/10 border border-[#00fff2]/30 flex items-center justify-center text-[#00fff2] shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-white" id="modalPlatformTitle">ข้อมูลไอดีหนัง</h3>
                        <p class="text-xs text-gray-400 mt-0.5" id="modalOrderSubtitle">Order #HD-00000</p>
                    </div>
                </div>
                <button type="button" onclick="closeAccountModal()" class="w-9 h-9 rounded-full bg-gray-800/80 hover:bg-gray-700 text-gray-400 hover:text-white flex items-center justify-center transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Scrollable Accounts List -->
            <div class="overflow-y-auto py-4 space-y-4 flex-1 pr-1" id="modalAccountsList">
                <!-- Dynamically generated account cards -->
            </div>

            <!-- Footer -->
            <div class="pt-4 border-t border-gray-800 flex items-center justify-between gap-3">
                <button type="button" onclick="copyAllAccounts()" id="copyAllBtn" class="px-4 py-2.5 rounded-full text-xs font-bold bg-gray-800 hover:bg-gray-700 text-gray-200 border border-gray-700 transition flex items-center gap-1.5 active:scale-95">
                    <svg class="w-4 h-4 text-[#00fff2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    <span>คัดลอกทั้งหมด</span>
                </button>
                <button type="button" onclick="closeAccountModal()" class="px-6 py-2.5 rounded-full text-xs font-extrabold bg-[#00fff2] hover:bg-cyan-300 text-black transition active:scale-95 shadow-md shadow-cyan-500/20">
                    ปิดหน้าต่าง
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentAccountsData = [];

        function openAccountModal(platform, plan, orderId, accounts) {
            currentAccountsData = accounts || [];
            document.getElementById('modalPlatformTitle').textContent = platform + ' (' + plan + ')';
            document.getElementById('modalOrderSubtitle').textContent = 'คำสั่งซื้อ #' + orderId + ' · ทั้งหมด ' + currentAccountsData.length + ' บัญชี';

            const container = document.getElementById('modalAccountsList');
            container.innerHTML = '';

            if (!currentAccountsData || currentAccountsData.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-400">
                        <p class="text-sm">ไม่พบข้อมูลไอดีหนังสำหรับสินค้านี้ในระบบ</p>
                    </div>
                `;
            } else {
                currentAccountsData.forEach((acc, index) => {
                    const card = document.createElement('div');
                    card.className = 'bg-gray-900/90 border border-gray-800 rounded-2xl p-4 space-y-3';
                    card.innerHTML = `
                        <div class="flex items-center justify-between border-b border-gray-800/80 pb-2">
                            <span class="text-xs font-extrabold text-[#00fff2] flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#00fff2] animate-pulse"></span>
                                บัญชีที่ ${index + 1}
                            </span>
                            <span class="text-[11px] font-mono text-gray-400 bg-black/50 border border-gray-800 px-2 py-0.5 rounded">ID: #${acc.id}</span>
                        </div>
                        
                        <!-- Email / Username -->
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 mb-1">ไอดี / อีเมล (Email):</label>
                            <div class="flex items-center gap-2 bg-black/60 border border-gray-700/80 rounded-xl px-3 py-2">
                                <input type="text" readonly value="${acc.email}" id="acc-email-${index}" class="bg-transparent text-sm text-cyan-300 font-mono w-full outline-none">
                                <button type="button" onclick="copyText('${acc.email}', this)" class="shrink-0 text-xs px-2.5 py-1 bg-gray-800 hover:bg-gray-700 text-gray-200 rounded-lg transition flex items-center gap-1 font-semibold active:scale-95">
                                    <svg class="w-3.5 h-3.5 text-[#00fff2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    <span>คัดลอก</span>
                                </button>
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 mb-1">รหัสผ่าน (Password):</label>
                            <div class="flex items-center gap-2 bg-black/60 border border-gray-700/80 rounded-xl px-3 py-2">
                                <input type="password" readonly value="${acc.password}" id="acc-pass-${index}" class="bg-transparent text-sm text-gray-100 font-mono w-full outline-none">
                                <button type="button" onclick="togglePassVisibility('acc-pass-${index}', this)" class="shrink-0 p-1 text-gray-400 hover:text-white transition" title="แสดง/ซ่อนรหัสผ่าน">
                                    <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button type="button" onclick="copyText('${acc.password}', this)" class="shrink-0 text-xs px-2.5 py-1 bg-gray-800 hover:bg-gray-700 text-gray-200 rounded-lg transition flex items-center gap-1 font-semibold active:scale-95">
                                    <svg class="w-3.5 h-3.5 text-[#00fff2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    <span>คัดลอก</span>
                                </button>
                            </div>
                        </div>
                    `;
                    container.appendChild(card);
                });
            }

            const modal = document.getElementById('accountModal');
            const box = document.getElementById('accountModalBox');
            modal.classList.remove('hidden');
            setTimeout(() => {
                box.classList.remove('scale-95', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeAccountModal() {
            const modal = document.getElementById('accountModal');
            const box = document.getElementById('accountModalBox');
            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 150);
        }

        document.getElementById('accountModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeAccountModal();
        });

        function copyText(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = `<span class="text-emerald-400 font-bold">คัดลอกแล้ว! ✓</span>`;
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                }, 1500);
            }).catch(err => {
                console.error('Copy failed:', err);
            });
        }

        function togglePassVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = `<svg class="w-4 h-4 text-[#00fff2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>`;
            } else {
                input.type = 'password';
                btn.innerHTML = `<svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>`;
            }
        }

        function copyAllAccounts() {
            if (!currentAccountsData || currentAccountsData.length === 0) return;
            const text = currentAccountsData.map((acc, i) => `[บัญชีที่ ${i + 1}] ID: #${acc.id}\nอีเมล: ${acc.email}\nรหัสผ่าน: ${acc.password}`).join('\n\n');
            copyText(text, document.getElementById('copyAllBtn'));
        }
    </script>
</body>
</html>