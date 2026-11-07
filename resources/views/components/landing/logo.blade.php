@props(['class' => 'h-11 w-11', 'src' => null])

@php
    $logoUrl = null;

    if (filled($src)) {
        if (\Illuminate\Support\Str::startsWith($src, ['http://', 'https://'])) {
            $logoUrl = $src;
        } elseif (file_exists(public_path($src))) {
            $logoUrl = asset($src);
        } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($src)) {
            $logoUrl = asset('storage/'.$src);
        }
    }

    if (! $logoUrl) {
        $legacyPath = collect(['images/logo.svg', 'images/logo.png', 'images/logo.webp'])
            ->first(fn (string $path): bool => file_exists(public_path($path)));

        $logoUrl = $legacyPath ? asset($legacyPath) : null;
    }
@endphp

@if ($logoUrl)
    <img
        src="{{ $logoUrl }}"
        alt="Logo Pondok Pesantren Nurur Rahmah"
        {{ $attributes->merge(['class' => trim($class.' object-contain')]) }}
    >
@else
    <span
        {{ $attributes->merge(['class' => trim($class.' inline-flex items-center justify-center'), 'data-logo-fallback' => 'true']) }}
        aria-hidden="true"
    >
        <svg viewBox="0 0 48 48" class="h-full w-full" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M24 2C15 2 8 9 8 18v22a6 6 0 0 0 6 6h20a6 6 0 0 0 6-6V18c0-9-7-16-16-16Z" fill="#064e3b"/>
            <path d="M24 8c-6.6 0-12 5.4-12 12v18h24V20c0-6.6-5.4-12-12-12Z" stroke="#d97706" stroke-width="1.5" opacity=".85"/>
            <text x="24" y="34" text-anchor="middle" font-family="Amiri, serif" font-size="17" fill="#fdfbf7">NR</text>
        </svg>
    </span>
@endif
