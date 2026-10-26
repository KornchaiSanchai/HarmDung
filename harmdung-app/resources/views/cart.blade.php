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
    <x-navbar active="cart"></x-navbar>

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
                    data-stock="{{ $item->available_stock }}"
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
                                {{ $item->formatted_price }}
                            </p>

                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-gray-500 text-xs">จำนวน</span>
                                <button type="button" class="qty-btn w-7 h-7 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold leading-none cursor-pointer flex items-center justify-center" data-delta="-1">−</button>
                                <span class="item-qty w-6 text-center font-bold text-sm">{{ $item->pivot->quantity }}</span>
                                <button type="button" class="qty-btn w-7 h-7 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold leading-none cursor-pointer flex items-center justify-center" data-delta="1">+</button>
                                <span class="text-gray-500 text-xs">ชิ้น</span>
                            </div>
                            <p class="qty-error text-rose-500 font-bold text-xs mt-1.5 hidden"></p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end gap-4 w-full sm:w-auto">
                        <div class="text-right">
                            <span class="item-subtotal text-lg font-black">
                                {{ $item->formatted_subtotal }}
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
                        <span id="selected-count" class="text-[#00fff2]">{{ $totalCount }}</span>
                        ชิ้น :
                        <span id="selected-total" class="text-2xl text-[#00fff2]">{{ $formattedTotal }}</span>
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
    // ส่งรายการที่เลือกไปให้ CartController คำนวณยอดเงินและจำนวนจาก Backend โดยตรง
    async function updateCartTotal() {
        const checkedBoxes = Array.from(document.querySelectorAll('.item-checkbox:checked'));
        const selectedIds = checkedBoxes.map(cb => cb.value);

        try {
            const res = await fetch('{{ route('cart.calculate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ items: selectedIds }),
            });

            if (!res.ok) return;
            const data = await res.json();

            document.getElementById('selected-count').textContent = data.count;
            document.getElementById('selected-total').textContent = data.total_formatted;

            const button = document.getElementById('checkout-button');
            if (button) {
                button.disabled = !data.can_checkout;
            }
        } catch (e) {
            console.error('Calculate error', e);
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
            const delta = Number(btn.dataset.delta);
            const newQty = oldQty + delta;

            errorEl.classList.add('hidden');
            if (newQty < 1) return; // ลดต่ำกว่า 1 ให้ใช้ปุ่ม "ลบ"

            btn.disabled = true;
            try {
                // ส่งคำขอไปให้ CartController@update ตรวจสต็อกและคำนวณราคาใหม่จาก Database
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
                    if (data.available !== undefined) {
                        item.dataset.stock = data.available;
                    }
                    errorEl.textContent = data.errors?.quantity?.[0] ?? data.message ?? 'จำนวนสินค้าใน stock ไม่เพียงพอ';
                    errorEl.classList.remove('hidden');
                    return;
                }

                const data = await res.json();
                item.dataset.quantity = data.quantity;
                item.querySelector('.item-qty').textContent = data.quantity;
                // รับยอดรวมย่อยที่คำนวณจาก Controller โดยตรง
                item.querySelector('.item-subtotal').textContent = data.item_subtotal_text;

                // อัปเดตยอดรวมคำสั่งซื้อผ่าน Controller
                await updateCartTotal();
            } catch (err) {
                errorEl.textContent = 'เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่อีกครั้ง';
                errorEl.classList.remove('hidden');
            } finally {
                btn.disabled = false;
            }
        });
    });

    updateCartTotal();
</script>

</body>
</html>