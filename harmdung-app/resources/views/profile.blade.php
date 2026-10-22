<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์ของคุณ - HD Harmdung</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-dark text-white font-sans antialiased min-h-screen pb-10">

    @php
        // ตอนนี้ยังไม่มีระบบล็อกอิน $user จึงเป็น null และใช้ค่าตัวอย่างตามดีไซน์แทน
        // เมื่อทำล็อกอินแล้ว ให้ใส่ middleware 'auth' กลับใน routes/web.php
        $user = auth()->user();
        $username = $user->username ?? 'Name';                  // ชื่อที่ตั้งตอนสมัคร (แก้ได้ที่หน้า "การตั้งค่าผู้ใช้")
        $email = $user->email ?? 'xxxxxxxxx@gmail.com';         // อีเมลที่ใช้ล็อกอิน
        $balance = number_format($user->balance ?? 100, 2);
        $activeTab = request('tab', 'info');

        $tabs = [
            'info'     => 'ข้อมูลผู้ใช้',
            'settings' => 'การตั้งค่าผู้ใช้',
            'orders'   => 'ประวัติการซื้อ',
            'coupons'  => 'ประวัติคูปอง',
        ];

        // รายการสั่งซื้อล่าสุดของผู้ใช้ ส่งมาจาก controller ผ่าน $recentOrders
        // ถ้ายังไม่เคยซื้อ ให้ส่ง collection ว่างหรือไม่ส่งมาเลย
        $recentOrders = collect($recentOrders ?? []);
    @endphp

    <!-- แถบนำทาง (Navbar) หลังล็อกอิน -->
    <nav class="flex items-center justify-between px-8 py-4 bg-black border-b border-gray-800">
        <div class="flex items-center gap-8">

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
            </div>
        </div>

        <!-- ยอดเหรียญ + รูปโปรไฟล์ -->
        <div class="flex items-center gap-4 text-sm">
            <div class="flex items-center gap-2 bg-[#2d2f2f] rounded-full pl-2 pr-6 py-1.5">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"></circle><path stroke-linecap="round" stroke-linejoin="round" d="M9.5 7.5h3.2a2 2 0 010 4H9.5m0 0h3.7a2 2 0 010 4H9.5m0-8v8m2-9.5v1.5m0 8v1.5"></path></svg>
                <span>{{ $balance }}</span>
            </div>
            <a href="{{ url('/profile') }}" class="block">
                <svg class="w-10 h-10" viewBox="0 0 40 40">
                    <circle cx="20" cy="20" r="20" fill="#00FFF2"></circle>
                    <circle cx="20" cy="15" r="6.5" fill="#101111"></circle>
                    <path d="M7.5 32c1.5-6 6.5-9 12.5-9s11 3 12.5 9a20 20 0 01-25 0z" fill="#101111"></path>
                </svg>
            </a>
        </div>
    </nav>

    <!-- คอนเทนต์ -->
    <div class="max-w-[1200px] mx-auto px-8 mt-8">

        <h1 class="text-xl font-extrabold">โปรไฟล์ของคุณ</h1>

        <!-- แท็บเมนู -->
        <div class="flex flex-wrap items-center gap-3 mt-4" role="tablist">
            @foreach ($tabs as $key => $label)
                <a href="{{ request()->url() }}?tab={{ $key }}"
                   role="tab"
                   aria-selected="{{ $activeTab === $key ? 'true' : 'false' }}"
                   class="px-6 py-2.5 rounded-full text-sm font-semibold text-white transition
                          {{ $activeTab === $key ? 'bg-[#6f7272]' : 'bg-[#2d2f2f] hover:bg-[#4d504f]' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- ข้อมูลโปรไฟล์ + ปุ่มออกจากระบบ -->
        <div class="flex items-start justify-between mt-8 px-4">
            <div class="flex items-center gap-4">
                <svg class="w-[86px] h-[86px] shrink-0" viewBox="0 0 86 86">
                    <circle cx="43" cy="43" r="43" fill="#00FFF2"></circle>
                    <circle cx="43" cy="33" r="14" fill="#101111"></circle>
                    <path d="M14 74c3-13 14-20 29-20s26 7 29 20a43 43 0 01-58 0z" fill="#101111"></path>
                </svg>
                <div>
                    <p class="text-lg font-extrabold leading-tight">{{ $username }}</p>
                    <p class="text-lg font-semibold leading-tight">{{ $email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 bg-red-500 text-black px-5 py-2.5 rounded-xl text-base hover:bg-red-400 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H9m4 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    ออกจากระบบ
                </button>
            </form>
        </div>

        <!-- สินค้าที่ซื้อล่าสุด -->
        <div class="mt-6 px-4">
            <h2 class="text-lg">สินค้าที่ซื้อล่าสุด</h2>

            @if ($recentOrders->isEmpty())
                <!-- ยังไม่เคยซื้อสินค้า -->
                <p class="mt-3 text-white">ยังไม่มีสินค้าล่าสุดที่สั่งซื้อ</p>
            @else
                <div class="flex flex-col gap-4 mt-3">
                    @foreach ($recentOrders as $order)
                        <div class="bg-white rounded-2xl min-h-[100px] px-6 py-4 flex items-center justify-between text-black">
                            {{-- TODO: ปรับชื่อ field ให้ตรงกับตารางคำสั่งซื้อของคุณ และจัดหน้าตาการ์ดตามดีไซน์ --}}
                            <div>
                                <p class="font-bold text-lg">{{ $order->product_name }}</p>
                                <p class="text-gray-500 text-sm">{{ $order->option_name ?? '' }}</p>
                            </div>
                            <p class="text-gray-500 text-sm">{{ optional($order->created_at)->format('Y-m-d H:i') }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</body>
</html>