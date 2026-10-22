<x-layouts::auth :title="__('สมัครสมาชิก / Register')">
    <div class="flex flex-col gap-6">
        
        <!-- Header matching Figma #22:13 text "สมัครสมาชิก / Register" -->
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-black text-white tracking-tight">สมัครสมาชิก / Register</h1>
            <p class="text-xs text-gray-400">สร้างบัญชีผู้ใช้งานใหม่เพื่อเริ่มสตรีมภาพยนตร์</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Username matching Figma Group 1 "ชื่อผู้ใช้งาน / Username" -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-200">ชื่อผู้ใช้งาน / Username</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="username"
                       placeholder="ชื่อของคุณ"
                       class="w-full bg-gray-800/90 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#00fff2] focus:ring-1 focus:ring-[#00fff2] transition">
                @error('name')
                    <span class="text-red-400 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email matching Figma Group 4 "อีเมลผู้ใช้งาน / Email" -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-200">อีเมลผู้ใช้งาน / Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                       placeholder="email@example.com"
                       class="w-full bg-gray-800/90 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#00fff2] focus:ring-1 focus:ring-[#00fff2] transition">
                @error('email')
                    <span class="text-red-400 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password matching Figma Group 2 "รหัสผ่าน / Password" -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-200">รหัสผ่าน / Password</label>
                <input type="password" name="password" required autocomplete="new-password"
                       placeholder="••••••••"
                       class="w-full bg-gray-800/90 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#00fff2] focus:ring-1 focus:ring-[#00fff2] transition">
                @error('password')
                    <span class="text-red-400 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password matching Figma Group 3 "ยืนยันรหัสผ่าน / Confirm Password" -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-200">ยืนยันรหัสผ่าน / Confirm Password</label>
                <input type="password" name="password_confirmation" required autocomplete="new-password"
                       placeholder="••••••••"
                       class="w-full bg-gray-800/90 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#00fff2] focus:ring-1 focus:ring-[#00fff2] transition">
            </div>

            <!-- Submit Button matching Figma Cyan Rectangle (#22:13) "สมัครสมาชิก" -->
            <div class="pt-3">
                <button type="submit" class="w-full bg-[#00fff2] hover:bg-cyan-300 text-black font-extrabold py-3.5 rounded-full transition shadow-lg shadow-cyan-500/20 text-sm flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                    สมัครสมาชิก
                </button>
            </div>
        </form>

        <div class="text-center text-xs text-gray-400 pt-2 border-t border-gray-800">
            <span>มีบัญชีผู้ใช้งานอยู่แล้ว?</span>
            <a href="{{ route('login') }}" class="text-[#00fff2] hover:underline font-bold ml-1" wire:navigate>
                เข้าสู่ระบบ
            </a>
        </div>
    </div>
</x-layouts::auth>
