<x-layouts::auth :title="__('เข้าสู่ระบบ / Login')">
    <div class="flex flex-col gap-6">
        
        <!-- Header matching Figma #23:2 text "เข้าสู่ระบบ / Login" -->
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-black text-white tracking-tight">เข้าสู่ระบบ / Login</h1>
            <p class="text-xs text-gray-400">กรุณากรอกอีเมลและรหัสผ่านเพื่อเข้าใช้งาน</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Email Address matching Figma "อีเมลผู้ใช้งาน / Email" -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-200">อีเมลผู้ใช้งาน / Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                       placeholder="email@example.com"
                       class="w-full bg-gray-800/90 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#00fff2] focus:ring-1 focus:ring-[#00fff2] transition">
                @error('email')
                    <span class="text-red-400 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password matching Figma "รหัสผ่าน / Password" -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-gray-200">รหัสผ่าน / Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-[#00fff2] hover:underline" wire:navigate>
                            ลืมรหัสผ่าน?
                        </a>
                    @endif
                </div>
                <input type="password" name="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full bg-gray-800/90 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#00fff2] focus:ring-1 focus:ring-[#00fff2] transition">
                @error('password')
                    <span class="text-red-400 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 accent-[#00fff2] rounded cursor-pointer">
                <label for="remember" class="text-xs text-gray-300 cursor-pointer">จดจำการเข้าสู่ระบบ</label>
            </div>

            <!-- Submit Button matching Figma white button "เข้าสู่ระบบ" -->
            <div class="pt-2">
                <button type="submit" class="w-full bg-white hover:bg-gray-200 text-black font-extrabold py-3.5 rounded-full transition shadow-lg text-sm flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                    เข้าสู่ระบบ
                </button>
            </div>
        </form>

        <div class="text-center text-xs text-gray-400 pt-2 border-t border-gray-800">
            <span>ยังไม่มีบัญชีผู้ใช้งาน?</span>
            <a href="{{ route('register') }}" class="text-[#00fff2] hover:underline font-bold ml-1" wire:navigate>
                สมัครสมาชิกที่นี่
            </a>
        </div>
    </div>
</x-layouts::auth>
