@props([
    'src' => null,
    'alt' => '',
    'label' => 'Nurur Rahmah',
    'loading' => 'lazy',
])

@php
    $hasImage = false;
    $imageUrl = null;

    if (filled($src)) {
        if (\Illuminate\Support\Str::startsWith($src, ['http://', 'https://'])) {
            $hasImage = true;
            $imageUrl = $src;
        } elseif (file_exists(public_path($src))) {
            $hasImage = true;
            $imageUrl = asset($src);
        } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($src)) {
            $hasImage = true;
            $imageUrl = asset('storage/'.$src);
        }
    }
@endphp

@if ($hasImage)
    <img
        src="{{ $imageUrl }}"
        alt="{{ $alt }}"
        loading="{{ $loading }}"
        decoding="async"
        {{ $attributes->merge(['class' => 'h-full w-full object-cover']) }}
    >
@else
    <div
        role="img"
        aria-label="{{ $alt !== '' ? $alt : $label }}"
        {{ $attributes->merge(['class' => 'relative flex h-full w-full items-center justify-center overflow-hidden bg-gradient-to-br from-emerald-800 via-emerald-900 to-emerald-950']) }}
    >
        <div class="pattern-islamic absolute inset-0 opacity-80"></div>
        <div class="relative z-10 flex flex-col items-center gap-2 px-6 text-center">
            <svg viewBox="0 0 32 32" class="h-6 w-6 text-gold-400" fill="none" aria-hidden="true">
                <path d="M16 2 30 16 16 30 2 16 16 2Z" stroke="currentColor" stroke-width="1.5"/>
                <path d="M16 8 24 16 16 24 8 16 16 8Z" stroke="currentColor" stroke-width="1" opacity=".6"/>
            </svg>
            <span class="font-arabic text-base text-cream-100/90">{{ $label }}</span>
        </div>
    </div>
@endif
