{{-- โลโก้แพลตฟอร์ม: ตัดภาพตรงกลางเป็น 1:1 จากโลโก้จริงบนเว็บ --}}
@php
    $size ??= 'w-5 h-5';

    // ดึงโลโก้จริงจาก Platform model accessor หรือ map ตามชื่อ/id
    $logoSrc = $platform->app_logo_url ?? null;
    if (! $logoSrc) {
        $pName = strtolower($platform->name ?? '');
        $pId = $platform->id ?? 0;
        if (str_contains($pName, 'netf') || $pId === 1) {
            $logoSrc = asset('images/netflux.png');
        } elseif (str_contains($pName, 'hiv') || str_contains($pName, 'hbo') || $pId === 2) {
            $logoSrc = asset('images/hiv.png');
        } elseif (str_contains($pName, 'hindu') || str_contains($pName, 'prime') || str_contains($pName, 'amazon') || $pId === 3) {
            $logoSrc = asset('images/hindu.png');
        } elseif (str_contains($pName, 'thisney') || str_contains($pName, 'disney') || $pId === 4) {
            $logoSrc = asset('images/thisney.png');
        } else {
            $logoSrc = $platform->logo_url ?? asset('images/logo.png');
        }
    }
@endphp

<img src="{{ $logoSrc }}" 
     alt="{{ $platform->name }}" 
     title="{{ $platform->name }}" 
     loading="lazy"
     class="{{ $size }} aspect-square object-cover object-center rounded-md shrink-0 ring-1 ring-white/15 bg-black/40 shadow-sm">

