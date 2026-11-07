@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'align' => 'left',
    'tone' => 'dark',
    'titleClass' => 'text-3xl font-semibold tracking-tight sm:text-4xl',
])

@php
    $alignment = $align === 'center' ? 'mx-auto items-center text-center' : 'items-start text-left';
    $eyebrowColor = $tone === 'light' ? 'text-gold-400' : 'text-gold-600';
    $titleColor = $tone === 'light' ? 'text-cream-50' : 'text-emerald-950';
    $descriptionColor = $tone === 'light' ? 'text-cream-100/70' : 'text-slate-600';
@endphp

<div {{ $attributes->merge(['class' => "flex max-w-2xl flex-col gap-4 $alignment"]) }}>
    @if ($eyebrow)
        <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] {{ $eyebrowColor }}">
            <span class="h-px w-8 bg-current" aria-hidden="true"></span>
            {{ $eyebrow }}
        </span>
    @endif

    <h2 class="{{ $titleClass }} {{ $titleColor }}">
        {{ $title }}
    </h2>

    @if ($description)
        <p class="text-base leading-relaxed {{ $descriptionColor }}">
            {{ $description }}
        </p>
    @endif
</div>
