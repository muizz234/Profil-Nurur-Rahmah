@extends('layouts.app')

@section('title', 'Galeri Kegiatan — Pondok Pesantren Nurur Rahmah')
@section('description', 'Dokumentasi kegiatan Pondok Pesantren Nurur Rahmah: halaqah tahfidz, kajian kitab kuning, aktivitas akademik, dan keseharian santri di asrama.')

@section('content')
    <header class="relative overflow-hidden bg-emerald-950 py-16 text-cream-50 sm:py-20">
        <div class="pattern-islamic absolute inset-0 opacity-40" aria-hidden="true"></div>
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute -right-24 top-10 h-72 w-72 rounded-full bg-gold-400/10 blur-3xl"></div>
            <div class="absolute -left-32 bottom-0 h-80 w-80 rounded-full bg-emerald-800/50 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <a
                href="{{ route('home') }}#galeri"
                class="inline-flex items-center gap-2 text-sm font-semibold text-cream-100/80 transition hover:text-gold-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gold-400/60 focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-950"
            >
                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                    <path d="M16 10H4m0 0 4-4m-4 4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Kembali ke beranda
            </a>

            <div class="mt-8 flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
                <x-landing.section-heading
                    eyebrow="Galeri"
                    title="Setiap sudut pondok punya cerita."
                    description="Kumpulan dokumentasi halaqah, kajian, aktivitas akademik, dan keseharian santri yang tumbuh bersama di Nurur Rahmah."
                    tone="light"
                    tag="h1"
                />

                <p class="inline-flex w-fit items-center gap-2 rounded-full border border-cream-50/15 bg-cream-50/5 px-4 py-2 text-xs font-semibold text-cream-100/80">
                    <span class="h-1.5 w-1.5 rounded-full bg-gold-400" aria-hidden="true"></span>
                    {{ count($gallery) }} foto kegiatan
                </p>
            </div>
        </div>
    </header>

    <section class="relative overflow-hidden bg-emerald-950 pb-20 text-cream-50 sm:pb-24">
        <div class="pattern-islamic absolute inset-0 opacity-25" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="h-px w-full bg-cream-50/10" aria-hidden="true"></div>

            @forelse ($gallery as $item)
                @if ($loop->first)
                    <div class="mt-10 columns-1 gap-4 sm:columns-2 md:columns-3 lg:gap-5">
                @endif

                <figure class="group mb-4 break-inside-avoid overflow-hidden rounded-2xl border border-cream-50/10 bg-cream-50/5 transition duration-300 hover:border-gold-400/30 hover:bg-cream-50/10 lg:mb-5">
                    <x-landing.smart-image
                        src="{{ $item['image'] }}"
                        alt="{{ $item['alt'] }}"
                        label="{{ $item['caption'] }}"
                        class="{{ $item['aspect'] }} w-full transition duration-500 group-hover:scale-105"
                    />

                    <figcaption class="flex items-center justify-between gap-3 px-4 py-3">
                        <span class="min-w-0 truncate text-[11px] font-medium text-cream-100/90 sm:text-xs">{{ $item['caption'] }}</span>
                        <span class="shrink-0 text-[10px] font-semibold uppercase tracking-[0.15em] text-gold-400/80">{{ $item['category'] }}</span>
                    </figcaption>
                </figure>

                @if ($loop->last)
                    </div>
                @endif
            @empty
                <div class="mt-10 rounded-2xl border border-dashed border-cream-50/20 bg-cream-50/5 px-6 py-16 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full border border-cream-50/15 bg-emerald-900/60 text-gold-400">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" aria-hidden="true">
                            <path d="M4 8.5A2.5 2.5 0 0 1 6.5 6h1.2a1 1 0 0 0 .8-.4l.9-1.2a1 1 0 0 1 .8-.4h3.6a1 1 0 0 1 .8.4l.9 1.2a1 1 0 0 0 .8.4h1.2A2.5 2.5 0 0 1 20 8.5v8a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 16.5v-8Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                            <circle cx="12" cy="12.5" r="3" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </div>

                    <p class="mt-5 text-base font-semibold text-cream-50">Belum ada foto galeri.</p>
                    <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-cream-100/60">
                        Dokumentasi kegiatan santri akan tampil di sini setelah foto diunggah oleh pengelola pondok.
                    </p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
