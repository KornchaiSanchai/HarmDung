<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ตะกร้าสินค้า - HD Harmdung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#171717] text-white font-sans antialiased min-h-screen flex flex-col justify-between">

<div>
    <header>
        <nav class="flex items-center justify-between px-8 py-4 border-b border-gray-800 bg-[#121212] sticky top-0 z-50">
            <div class="flex items-center gap-8">
                <a href="/home">
                    <img src="/images/logo.png" alt="HD Harmdung" class="h-10 w-auto">
                </a>

                <div class="flex items-center gap-2">
                    <a href="/home" class="px-5 py-2 text-sm text-gray-300 rounded-full hover:bg-gray-800">หน้าแรก</a>
                    <a href="/products" class="px-5 py-2 text-sm text-gray-300 rounded-full hover:bg-gray-800">สินค้าทั้งหมด</a>
                    <a href="{{ route('cart.index') }}" class="px-5 py-2 bg-[#333] rounded-full text-sm">ตะกร้า</a>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="bg-gray-800 text-white px-4 py-2 rounded-full text-sm font-semibold">
                    ฿ {{ number_format(auth()->user()->balance ?? 100, 2) }}
                </div>
                <a href="/profile" class="w-10 h-10 bg-[#00fff2] rounded-full flex items-center justify-center text-black font-bold">
                    👤
                </a>
            </div>
        </nav>
    </header>

    <main class="max-w-[1000px] mx-auto px-6 mt-10 w-full">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold">สินค้าในตะกร้า</h1>
                <p class="text-xs text-gray-400 mt-1">ตรวจสอบสินค้าก่อนชำระเงิน</p>
            </div>
            <a href="/products" class="text-sm font-bold text-[#00fff2]">+ เลือกซื้อสินค้าเพิ่ม</a>
        </div>

        @if (session('success'))
            <div class="mb-5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        <!-- ฟอร์มสำหรับส่งไปหน้า Checkout แยกไว้ข้างนอก ไม่ครอบซ้อนกัน -->
        <form action="{{ route('checkout.index') }}" method="GET" id="checkout-form"></form>

        <div class="space-y-4">
            @forelse ($cartItems as $item)
                <div
                    class="bg-white text-black rounded-[24px] p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xl cart-item"
                    data-id="{{ $item->id }}"
                    data-price="{{ $item->price }}"
                    data-quantity="{{ $item->pivot->quantity }}"
                >
                    <div class="flex items-center gap-4">
                        <!-- ใช้ attribute form="checkout-form" เพื่อเชื่อมกับฟอร์มด้านนอก -->
                        <input
                            type="checkbox"
                            name="items[]"
                            value="{{ $item->id }}"
                            form="checkout-form"
                            checked
                            class="item-checkbox w-5 h-5 accent-[#00fff2] cursor-pointer"
                        >

                        <!-- กล่องแสดงชื่อแพลตฟอร์มที่ถูกต้อง -->
                        <div class="w-24 aspect-video rounded-xl bg-gradient-to-r from-[#0b1b3d] to-[#043360] flex items-center justify-center text-white font-bold text-xs text-center uppercase">
                            {{$item->platform->name ?? 'Harmdung' }}
                        </div>

                        <div>
                            <h3 class="font-extrabold text-lg">
                                {{ $item->plan_name }}
                            </h3>

                            <p class="text-gray-500 text-xs mt-1">
                                ราคาต่อหน่วย:
                                {{ number_format($item->price, 2) }} บาท
                            </p>

                           <div class="flex items-center gap-2 mt-2">
    <span class="text-gray-500 text-xs">จำนวน</span>
    <button type="button" class="qty-btn w-7 h-7 rounded-full bg-gray-200 hover:bg-gray-300 font-bold leading-none cursor-pointer" data-delta="-1">−</button>
    <span class="item-qty w-6 text-center font-bold text-sm">{{ $item->pivot->quantity }}</span>
    <button type="button" class="qty-btn w-7 h-7 rounded-full bg-gray-200 hover:bg-gray-300 font-bold leading-none cursor-pointer" data-delta="1">+</button>
    <span class="text-gray-500 text-xs">ชิ้น</span>
</div>
<p class="qty-error text-red-500 text-xs mt-1 hidden"></p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end gap-4 w-full sm:w-auto">
                        <div class="text-right">
                            <span class="item-subtotal text-lg font-black">
                                {{ number_format($item->price * $item->pivot->quantity, 2) }} บาท
                            </span>
                        </div>

                        <!-- ฟอร์มลบสินค้าแยกอิสระ ไม่ซ้อนกับฟอร์มอื่น -->
                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold cursor-pointer">
                                ลบ
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-gray-900 rounded-[24px] p-12 text-center border border-gray-800">
                    <p class="text-gray-400">ยังไม่มีสินค้าในตะกร้าของคุณ</p>
                    <a href="/products" class="inline-block mt-4 bg-[#00fff2] text-black font-bold px-6 py-2 rounded-full text-xs">
                        เลือกซื้อสินค้าเลย
                    </a>
                </div>
            @endforelse
        </div>

        @if ($cartItems->isNotEmpty())
            <div class="mt-8 bg-gray-900 rounded-[24px] p-6 border border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="text-center sm:text-left">
                    <div class="text-xs text-gray-400">สินค้าที่เลือกชำระเงิน</div>

                    <div class="text-xl font-black mt-1">
                        <span id="selected-count" class="text-[#00fff2]">0</span>
                        ชิ้น :
                        <span id="selected-total" class="text-2xl text-[#00fff2]">0.00</span>
                        บาท
                    </div>
                </div>

                <!-- ปุ่มกดส่งฟอร์มผูกกับ id checkout-form ด้านนอก -->
                <button
                    type="submit"
                    form="checkout-form"
                    id="checkout-button"
                    class="bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold px-8 py-3.5 rounded-full disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer"
                >
                    ไปที่หน้าชำระเงิน →
                </button>
            </div>
        @endif
    </main>
</div>

<footer class="text-center py-6 text-gray-500 text-xs border-t border-gray-800/50 mt-12">
    &copy; {{ date('Y') }} HD Harmdung. All rights reserved.
</footer>

<script>
    function updateCartTotal() {
        const items = document.querySelectorAll('.cart-item');
        let count = 0;
        let total = 0;

        items.forEach(item => {
            const checkbox = item.querySelector('.item-checkbox');

            if (checkbox.checked) {
                const price = Number(item.dataset.price);
                const quantity = Number(item.dataset.quantity);

                count += quantity;
                total += price * quantity;
            }
        });

        document.getElementById('selected-count').textContent = count;
        document.getElementById('selected-total').textContent =
            total.toLocaleString('th-TH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

        const button = document.getElementById('checkout-button');
        if (button) {
            button.disabled = count === 0;
        }
    }

    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateCartTotal);
    });
    document.querySelectorAll('.qty-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
        const item = btn.closest('.cart-item');
        const errorEl = item.querySelector('.qty-error');
        const oldQty = Number(item.dataset.quantity);
        const newQty = oldQty + Number(btn.dataset.delta);

        errorEl.classList.add('hidden');
        if (newQty < 1) return; // ลดต่ำกว่า 1 ให้ใช้ปุ่ม "ลบ"

        const res = await fetch(`/cart/update/${item.dataset.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ quantity: newQty }),
        });

        if (!res.ok) {
            const data = await res.json().catch(() => ({}));
            errorEl.textContent = data.errors?.quantity?.[0] ?? 'ไม่สามารถเปลี่ยนจำนวนได้';
            errorEl.classList.remove('hidden');
            return;
        }

        item.dataset.quantity = newQty;
        item.querySelector('.item-qty').textContent = newQty;
        item.querySelector('.item-subtotal').textContent =
            (Number(item.dataset.price) * newQty).toLocaleString('th-TH', {
                minimumFractionDigits: 2, maximumFractionDigits: 2
            }) + ' บาท';
        updateCartTotal();
    });
});

    updateCartTotal();
</script>

</body>
</html>