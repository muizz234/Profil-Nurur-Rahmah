@extends('layouts.app')

@section('title', $berita->title.' — Pondok Pesantren Nurur Rahmah')
@section('description', \Illuminate\Support\Str::limit(strip_tags($berita->content), 155))

@section('content')
    <article class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute -right-24 top-10 h-72 w-72 rounded-full bg-gold-400/10 blur-3xl"></div>
            <div class="absolute -left-32 bottom-0 h-80 w-80 rounded-full bg-emerald-900/10 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:py-16">
            <a href="{{ route('home') }}#berita" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-800 transition hover:text-emerald-600">
                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                    <path d="M16 10H4m0 0 4-4m-4 4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Kembali ke beranda
            </a>

            <div class="mt-6 flex flex-wrap items-center gap-2 text-xs">
                <span class="rounded-full bg-emerald-900 px-3 py-1 font-semibold uppercase tracking-[0.15em] text-cream-50">
                    {{ $berita->category?->name ?? 'Berita' }}
                </span>

                <span class="text-slate-500">
                    {{ $berita->published_at?->translatedFormat('j F Y') }}
                </span>

                <span class="text-slate-400">&middot;</span>

                <span class="text-slate-500">{{ $berita->user?->name ?? 'Redaksi Nurur Rahmah' }}</span>
            </div>

            <h1 class="mt-4 text-3xl font-semibold leading-tight tracking-tight text-emerald-950 sm:text-4xl">
                {{ $berita->title }}
            </h1>

            @if ($berita->image)
                <div class="mt-8 overflow-hidden rounded-2xl border border-emerald-900/10 shadow-sm">
                    <x-landing.smart-image
                        src="{{ $berita->image }}"
                        alt="{{ $berita->title }}"
                        label="{{ $berita->category?->name ?? 'Berita' }}"
                        class="aspect-[16/9] w-full"
                    />
                </div>
            @endif

            <div class="mt-8 break-words [overflow-wrap:anywhere] text-base leading-relaxed text-slate-700">
                {!! nl2br(e($berita->content)) !!}
            </div>

            <div class="mt-10 border-t border-emerald-900/10 pt-6">
                <a href="{{ route('home') }}#berita" class="btn-outline">
                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                        <path d="M16 10H4m0 0 4-4m-4 4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Lihat berita lainnya
                </a>
            </div>
        </div>
    </article>
@endsection
