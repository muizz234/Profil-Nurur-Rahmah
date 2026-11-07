@extends('layouts.admin')

@section('title', 'Dashboard — Admin Nurur Rahmah')

@section('content')
    <x-admin.page-header
        eyebrow="Admin Panel"
        title="Dashboard"
        description="Ringkasan konten dan aktivitas website Pondok Pesantren Nurur Rahmah."
    >
        <x-slot:actions>
            <a href="{{ route('admin.berita.create') }}" class="btn-primary">
                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                    <path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
                Tulis Berita
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <x-admin.stat-card :label="$stat['label']" :value="$stat['value']" :hint="$stat['hint']" />
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
                <h2 class="text-sm font-bold uppercase tracking-[0.15em] text-slate-500">Berita Terbaru</h2>
                <a href="{{ route('admin.berita.index') }}" class="text-xs font-semibold text-emerald-700 transition hover:text-emerald-900">
                    Lihat semua
                </a>
            </div>

            @if ($latestBeritas->isEmpty())
                <p class="px-5 py-10 text-center text-sm text-slate-500">Belum ada berita yang ditambahkan.</p>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($latestBeritas as $berita)
                        <li class="flex items-start justify-between gap-4 px-5 py-4">
                            <div class="min-w-0">
                                <a href="{{ route('admin.berita.show', $berita) }}" class="line-clamp-1 text-sm font-semibold text-slate-800 transition hover:text-emerald-700">
                                    {{ $berita->title }}
                                </a>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $berita->category?->name ?? 'Tanpa kategori' }}
                                    &middot;
                                    {{ $berita->published_at?->translatedFormat('j M Y') ?? 'Belum terbit' }}
                                </p>
                            </div>

                            @if ($berita->is_published)
                                <span class="shrink-0 rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.1em] text-emerald-700">Terbit</span>
                            @else
                                <span class="shrink-0 rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.1em] text-slate-500">Draf</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-bold uppercase tracking-[0.15em] text-slate-500">Aksi Cepat</h2>

            <div class="mt-4 grid gap-2">
                @php
                    $quickActions = [
                        ['label' => 'Tambah Kegiatan', 'route' => 'admin.kegiatan.create'],
                        ['label' => 'Unggah Foto Galeri', 'route' => 'admin.galeri.create'],
                        ['label' => 'Perbarui Profil', 'route' => 'admin.profil.index'],
                        ['label' => 'Perbarui Kontak', 'route' => 'admin.kontak.index'],
                    ];
                @endphp

                @foreach ($quickActions as $action)
                    <a
                        href="{{ route($action['route']) }}"
                        class="flex items-center justify-between gap-3 rounded-xl border border-slate-100 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-emerald-200 hover:bg-emerald-50/60 hover:text-emerald-800"
                    >
                        {{ $action['label'] }}
                        <svg viewBox="0 0 20 20" class="h-4 w-4 text-slate-300" fill="none" aria-hidden="true">
                            <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
