<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สินค้าทั้งหมด - HD Harmdung</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-dark text-white font-sans antialiased min-h-screen pb-10">

    <x-navbar active="products"></x-navbar>

    <!-- คอนเทนต์: Grid สินค้า -->
    <div class="max-w-[1200px] mx-auto px-8 mt-12">
        <!-- จัดเรียงแบบ 2 คอลัมน์สำหรับจอคอม -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            @foreach ($platforms as $platform)
            <!-- การ์ด -->
            <a href="{{ route('product-info', ['platform' => $platform->slug_key]) }}" class="group p-3 flex flex-col gap-3 border-b border-gray-800/80 hover:scale-[1.02] transition-transform duration-300 block">
                
                <!-- ส่วนแบนเนอร์ -->
                <div class="{{ $platform->bg_class }} w-full aspect-[21/9] rounded-[20px] flex items-center justify-center overflow-hidden relative border border-[#00fff2]/30 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.8),0_0_30px_rgba(0,255,242,0.18)] group-hover:border-[#00fff2] group-hover:shadow-[0_25px_50px_-12px_rgba(0,0,0,0.9),0_0_40px_rgba(0,255,242,0.35)] transition-all duration-300">
                    <!-- ดึงรูปภาพมาแสดงผล -->
                    <img src="{{ $platform->image_url }}" alt="{{ $platform->name }}" class="w-full h-full object-cover">
                </div>

                <!-- ส่วนรายละเอียดและปุ่ม -->
                <div class="flex items-center justify-between px-3 pb-2 pt-1">
                    <div>
                        <h3 class="text-white text-xl font-bold leading-none">{{ $platform->name }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ $platform->items_count_label }}</p>
                    </div>
                    <span class="bg-[#00fff2] text-black font-bold px-5 py-2.5 rounded-full text-sm group-hover:bg-cyan-300 group-hover:shadow-[0_0_15px_rgba(0,255,242,0.4)] transition shadow-sm">
                        สินค้าทั้งหมด
                    </span>
                </div>
            </a>
            @endforeach

        </div>
    </div>

    <x-footer></x-footer>
</body>
</html>