@extends('layouts.admin')

@section('title', $berita->title.' — Admin Nurur Rahmah')

@section('content')
    <x-admin.page-header
        eyebrow="Berita & Artikel"
        title="Detail Berita"
        description="Pratinjau berita seperti yang akan tampil di halaman publik."
    >
        <x-slot:actions>
            @if ($berita->is_published)
                <a href="{{ route('berita.show', $berita->slug) }}" target="_blank" rel="noopener noreferrer" class="btn-outline">
                    Lihat di Situs
                </a>
            @endif

            <a href="{{ route('admin.berita.edit', $berita) }}" class="btn-primary">Edit Berita</a>
        </x-slot:actions>
    </x-admin.page-header>

    <article class="mt-6 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        @if ($berita->image)
            <x-landing.smart-image
                src="{{ $berita->image }}"
                alt="{{ $berita->title }}"
                label="{{ $berita->category?->name ?? 'Berita' }}"
                class="aspect-[21/9] w-full"
            />
        @endif

        <div class="p-5 sm:p-8">
            <div class="flex flex-wrap items-center gap-2 text-xs">
                <span class="rounded-full bg-emerald-100 px-2.5 py-1 font-bold uppercase tracking-[0.1em] text-emerald-700">
                    {{ $berita->category?->name ?? 'Tanpa kategori' }}
                </span>

                @if ($berita->is_published)
                    <span class="rounded-full bg-emerald-600 px-2.5 py-1 font-bold uppercase tracking-[0.1em] text-white">Terbit</span>
                @else
                    <span class="rounded-full bg-slate-100 px-2.5 py-1 font-bold uppercase tracking-[0.1em] text-slate-500">Draf</span>
                @endif

                <span class="text-slate-500">
                    {{ $berita->published_at?->translatedFormat('j F Y H:i') ?? 'Belum dijadwalkan' }}
                </span>

                <span class="text-slate-400">&middot;</span>

                <span class="text-slate-500">{{ $berita->user?->name ?? 'Tanpa penulis' }}</span>
            </div>

            <h1 class="mt-4 text-2xl font-bold leading-tight tracking-tight text-slate-900 sm:text-3xl">
                {{ $berita->title }}
            </h1>

            <div class="mt-6 border-t border-slate-100 pt-6 text-base leading-relaxed text-slate-700">
                {!! nl2br(e($berita->content)) !!}
            </div>

            <div class="mt-8 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-5">
                <a href="{{ route('admin.berita.index') }}" class="text-sm font-semibold text-slate-600 transition hover:text-emerald-700">
                    &larr; Kembali ke daftar berita
                </a>

                <x-admin.delete-button
                    :action="route('admin.berita.destroy', $berita)"
                    label="Hapus Berita"
                    :message="'Hapus berita \''.$berita->title.'\'? Tindakan ini tidak dapat dibatalkan.'"
                />
            </div>
        </div>
    </article>
@endsection
