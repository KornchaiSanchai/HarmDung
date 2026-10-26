{{-- โลโก้แพลตฟอร์ม: ใช้ logo_url จาก TMDB ถ้ามี ไม่งั้นแสดงตัวอักษรแรก --}}
@php($size ??= 'w-4 h-4')
@if ($platform->logo_url)
    <img src="{{ $platform->logo_url }}" alt="{{ $platform->name }}" title="{{ $platform->name }}" loading="lazy"
         class="{{ $size }} rounded object-cover ring-1 ring-white/10">
@else
    <span title="{{ $platform->name }}"
          class="{{ $size }} rounded bg-neutral-700 text-[9px] flex items-center justify-center text-white font-bold">
        {{ mb_substr($platform->name, 0, 1) }}
    </span>
@endif
