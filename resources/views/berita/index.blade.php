@extends('layouts.app')

@section('title', 'Berita & Artikel — Pondok Pesantren Nurur Rahmah')
@section('description', 'Kabar terbaru dari Nurur Rahmah: prestasi santri, agenda pesantren, dan artikel pilihan.')

@section('content')
    <header class="relative overflow-hidden bg-emerald-950 py-16 text-cream-50 sm:py-20">
        <div class="pattern-islamic absolute inset-0 opacity-40" aria-hidden="true"></div>
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute -right-24 top-10 h-72 w-72 rounded-full bg-gold-400/10 blur-3xl"></div>
            <div class="absolute -left-32 bottom-0 h-80 w-80 rounded-full bg-emerald-800/50 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <a
                href="{{ route('home') }}#berita"
                class="inline-flex items-center gap-2 text-sm font-semibold text-cream-100/80 transition hover:text-gold-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gold-400/60 focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-950"
            >
                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                    <path d="M16 10H4m0 0 4-4m-4 4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Kembali ke beranda
            </a>

            <div class="mt-8 flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
                <x-landing.section-heading
                    eyebrow="Berita & Artikel"
                    title="Kabar terbaru dari Nurur Rahmah."
                    description="Cerita tentang prestasi santri, agenda pesantren, dan pemikiran yang kami bagikan untuk umat."
                    tone="light"
                    tag="h1"
                />

                <p class="inline-flex w-fit items-center gap-2 rounded-full border border-cream-50/15 bg-cream-50/5 px-4 py-2 text-xs font-semibold text-cream-100/80">
                    <span class="h-1.5 w-1.5 rounded-full bg-gold-400" aria-hidden="true"></span>
                    {{ $beritas->total() ?? count($beritas ?? []) }} berita
                </p>
            </div>
        </div>
    </header>

    <section class="relative overflow-hidden bg-emerald-950 pb-20 text-cream-50 sm:pb-24">
        <div class="pattern-islamic absolute inset-0 opacity-25" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="h-px w-full bg-cream-50/10" aria-hidden="true"></div>

            @if ($errors->any())
                <div role="alert" class="mt-10 rounded-2xl border border-red-400/30 bg-red-500/10 px-4 py-3 text-sm text-red-100">
                    <p class="font-semibold">Terjadi kesalahan:</p>
                    <ul class="mt-1 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($beritas as $berita)
                    <article class="group flex flex-col overflow-hidden rounded-2xl border border-cream-50/10 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-md">
                        <div class="relative overflow-hidden">
                            @if ($berita->image)
                                <x-landing.smart-image
                                    src="{{ $berita->image }}"
                                    alt="{{ $berita->title }}"
                                    label="{{ $berita->category?->name ?? 'Berita' }}"
                                    class="aspect-[4/3] w-full transition duration-500 group-hover:scale-[1.03]"
                                />
                            @else
                                <div class="flex aspect-[4/3] w-full items-center justify-center bg-emerald-900/10 text-emerald-900/40">
                                    <svg viewBox="0 0 24 24" class="h-10 w-10" fill="none" aria-hidden="true">
                                        <path d="M4 8.5A2.5 2.5 0 0 1 6.5 6h1.2a1 1 0 0 0 .8-.4l.9-1.2a1 1 0 0 1 .8-.4h3.6a1 1 0 0 1 .8.4l.9 1.2a1 1 0 0 0 .8.4h1.2A2.5 2.5 0 0 1 20 8.5v8a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 16.5v-8Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                                        <circle cx="12" cy="12.5" r="3" stroke="currentColor" stroke-width="1.5"/>
                                    </svg>
                                </div>
                            @endif

                            <span class="absolute left-4 top-4 rounded-full bg-emerald-900/90 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.15em] text-cream-50 backdrop-blur">
                                {{ $berita->category?->name ?? 'Berita' }}
                            </span>
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <p class="text-xs font-medium uppercase tracking-[0.15em] text-slate-500">
                                {{ $berita->published_at?->translatedFormat('j F Y') }}
                            </p>
                            <h2 class="mt-3 text-lg font-semibold leading-snug text-emerald-950">
                                <a href="{{ route('berita.show', $berita) }}" class="transition group-hover:text-emerald-800">{{ $berita->title }}</a>
                            </h2>
                            <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($berita->content), 140) }}</p>

                            <a href="{{ route('berita.show', $berita) }}" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-emerald-900 transition hover:text-emerald-700">
                                Baca selengkapnya
                                <svg viewBox="0 0 20 20" class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" aria-hidden="true">
                                    <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-cream-50/20 bg-cream-50/5 px-6 py-16 text-center md:col-span-2 lg:col-span-3">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full border border-cream-50/15 bg-emerald-900/60 text-gold-400">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" aria-hidden="true">
                                <path d="M4 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5Z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M8 9h8M8 13h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <p class="mt-5 text-base font-semibold text-cream-50">Belum ada berita.</p>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-cream-100/60">
                            Kabar terbaru dari Nurur Rahmah akan tampil di sini setelah diterbitkan oleh redaksi pondok.
                        </p>
                    </div>
                @endforelse
            </div>

            @if ($beritas->hasPages())
                <div class="mt-12 [&_.pagination]:flex [&_.pagination]:flex-wrap [&_.pagination]:justify-center [&_.pagination]:gap-2 [&_.page-item]:list-none [&_.page-link]:rounded-full [&_.page-link]:border [&_.page-link]:border-cream-50/15 [&_.page-link]:bg-cream-50/5 [&_.page-link]:px-4 [&_.page-link]:py-2 [&_.page-link]:text-sm [&_.page-link]:font-semibold [&_.page-link]:text-cream-100/80 [&_.page-link]:transition [&_.page-link:hover]:border-gold-400/40 [&_.page-link:hover]:text-gold-400 [&_.page-item.active_.page-link]:bg-gold-400 [&_.page-item.active_.page-link]:text-emerald-950 [&_.page-item.disabled_.page-link]:opacity-40">
                    {{ $beritas->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
