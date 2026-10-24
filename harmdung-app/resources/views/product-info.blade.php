<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $platform->name }} - HD Harmdung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#171717] text-white font-sans antialiased min-h-screen pb-16 selection:bg-[#00fff2] selection:text-black">

    <x-navbar active="product-info"></x-navbar>

    <!-- Platform Selector Bar -->
    <div class="max-w-[1240px] mx-auto px-6 mt-8">
        <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none">
            <a href="{{ route('products') }}" class="text-sm font-semibold text-gray-400 hover:text-white transition flex items-center gap-1.5 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                ย้อนกลับ
            </a>
            <span class="text-gray-600">|</span>
            @foreach ($platforms as $p)
                <a href="{{ route('product-info', ['platform' => $p->id]) }}"
                   class="px-5 py-2 rounded-full text-sm font-bold transition shrink-0 {{ $platform->id === $p->id ? 'bg-[#00fff2] text-black shadow-lg shadow-cyan-500/25' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                    {{ $p->name }}
                </a>
            @endforeach
        </div>
    </div>

    <main class="max-w-[1240px] mx-auto px-6 mt-6">

        @if (session('success'))
            <div class="mb-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-sm px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Hero -->
        <div class="bg-gradient-to-r from-[#0b1b3d] to-[#043360] rounded-[28px] p-8 md:p-10 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8 border border-white/10">
            <div class="space-y-4 max-w-xl z-10 text-center md:text-left">
                <div class="inline-flex items-center gap-2 bg-black/40 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-bold text-cyan-300 border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-[#00fff2] animate-pulse"></span>
                    พร้อมจัดส่งอัตโนมัติ 24 ชม.
                </div>
                <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight">{{ $platform->name }}</h1>
            </div>

            @if ($platform->logo_url)
                <div class="w-44 h-44 md:w-56 md:h-56 shrink-0 flex items-center justify-center">
                    <div class="w-36 h-36 md:w-44 md:h-44 rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl flex items-center justify-center overflow-hidden">
                        <img src="{{ $platform->logo_url }}" alt="{{ $platform->name }}" class="w-full h-full object-cover">
                    </div>
                </div>
            @endif
        </div>

        <!-- Packages -->
        <div class="mt-12">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white">เลือกแพ็กเกจการใช้งาน</h2>
                <p class="text-sm text-gray-400 mt-1">เลือกแพ็กเกจที่ต้องการ สั่งซื้อง่าย รับสิทธิ์ดูได้ทันที</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    <div class="bg-white text-black rounded-[24px] p-6 flex flex-col justify-between shadow-xl hover:shadow-2xl hover:scale-[1.02] transition duration-300 relative border border-gray-100">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-black text-gray-900">{{ $product->plan_name }}</span>
                                <span class="text-xs font-semibold px-2.5 py-1 bg-gray-100 rounded-full text-gray-600">VIP</span>
                            </div>

                            <div class="mb-2">
                                <span class="text-4xl font-black text-gray-900">{{ number_format($product->price, 0) }}</span>
                                <span class="text-base font-bold text-gray-600">บาท</span>
                            </div>
                            <p class="text-xs mb-6 {{ $product->available_stock > 0 ? 'text-gray-400' : 'text-red-500 font-bold' }}">
                               {{ $product->available_stock > 0 ? 'คงเหลือ '.$product->available_stock.' ชิ้น' : 'สินค้าหมด' }}
                            </p>

                            <ul class="space-y-2.5 text-xs text-gray-600 mb-8 border-t border-gray-100 pt-4">
                                @foreach (['ดูได้ไม่มีโฆษณาคั่น', 'ความละเอียดสูงสุด 4K UHD', 'รับประกันตลอดอายุแพ็กเกจ'] as $feature)
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" @disabled($product->available_stock <= 0)
                                class="w-full bg-[#00fff2] hover:bg-cyan-300 disabled:bg-gray-300 disabled:cursor-not-allowed text-black font-extrabold py-3.5 rounded-full transition shadow-md shadow-cyan-500/20 flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                เพิ่มลงตะกร้า
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-400 col-span-4 text-center">แพลตฟอร์มนี้ยังไม่มีสินค้า</p>
                @endforelse
            </div>
        </div>

        <!-- Detail App -->
        <div class="mt-14 bg-[#202020] rounded-[24px] p-8 md:p-10 border border-gray-800 shadow-xl">
            <h3 class="text-xl font-bold text-white mb-6">รายละเอียดและวิธีการใช้งานแอปพลิเคชัน</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-300">
                <div class="bg-[#171717] p-5 rounded-2xl border border-gray-800/80">
                    <h4 class="font-bold text-white mb-2">1. โหลดได้ที่ไหน?</h4>
                    <p class="text-gray-400 text-xs leading-relaxed">ดาวน์โหลดจาก Google Play Store, Apple App Store หรือ Smart TV App Store ค้นหาตามชื่อแอปพลิเคชัน</p>
                </div>
                <div class="bg-[#171717] p-5 rounded-2xl border border-gray-800/80">
                    <h4 class="font-bold text-white mb-2">2. วิธีรับรหัสเข้าสู่ระบบ</h4>
                    <p class="text-gray-400 text-xs leading-relaxed">เมื่อชำระเงินสำเร็จ ดูบัญชีและรหัสผ่านได้ที่หน้า "ประวัติการสั่งซื้อ"</p>
                </div>
                <div class="bg-[#171717] p-5 rounded-2xl border border-gray-800/80">
                    <h4 class="font-bold text-white mb-2">3. การรับประกัน & ซัพพอร์ต</h4>
                    <p class="text-gray-400 text-xs leading-relaxed">รับประกันเปลี่ยนแอคเคาท์ใหม่หากพบปัญหาตลอดระยะเวลาการใช้งาน</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>