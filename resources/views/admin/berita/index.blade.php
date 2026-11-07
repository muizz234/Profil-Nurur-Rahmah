@extends('layouts.admin')

@section('title', 'Berita — Admin Nurur Rahmah')

@section('content')
    <x-admin.page-header
        eyebrow="Berita & Artikel"
        title="Kelola Berita"
        description="Semua berita dan artikel yang tersimpan di website pesantren."
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

    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        @if ($beritas->isEmpty())
            <p class="px-5 py-12 text-center text-sm text-slate-500">Belum ada berita. Silakan tulis berita pertama Anda.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead class="bg-slate-50/80 text-left text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-500">
                        <tr>
                            <th scope="col" class="px-5 py-3">Berita</th>
                            <th scope="col" class="px-5 py-3">Kategori</th>
                            <th scope="col" class="px-5 py-3">Status</th>
                            <th scope="col" class="px-5 py-3">Terbit</th>
                            <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($beritas as $berita)
                            <tr class="align-middle">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="h-12 w-16 shrink-0 overflow-hidden rounded-lg bg-slate-100">
                                            <x-landing.smart-image
                                                src="{{ $berita->image }}"
                                                alt="{{ $berita->title }}"
                                                label="{{ $berita->category?->name ?? 'Berita' }}"
                                                class="h-full w-full"
                                            />
                                        </div>

                                        <div class="min-w-0">
                                            <a href="{{ route('admin.berita.show', $berita) }}" class="line-clamp-1 font-semibold text-slate-800 transition hover:text-emerald-700">
                                                {{ $berita->title }}
                                            </a>
                                            <p class="truncate text-xs text-slate-500">{{ $berita->user?->name ?? 'Tanpa penulis' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-slate-600">{{ $berita->category?->name ?? '-' }}</td>
                                <td class="px-5 py-3">
                                    @if ($berita->is_published)
                                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.1em] text-emerald-700">Terbit</span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.1em] text-slate-500">Draf</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-xs text-slate-500">
                                    {{ $berita->published_at?->translatedFormat('j M Y') ?? '-' }}
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="{{ route('admin.berita.show', $berita) }}"
                                            class="inline-flex items-center justify-center rounded-full border border-slate-200 px-3.5 py-2 text-xs font-semibold text-slate-700 transition hover:border-emerald-300 hover:text-emerald-700"
                                        >
                                            Lihat
                                        </a>

                                        <a
                                            href="{{ route('admin.berita.edit', $berita) }}"
                                            class="inline-flex items-center justify-center rounded-full border border-slate-200 px-3.5 py-2 text-xs font-semibold text-slate-700 transition hover:border-emerald-300 hover:text-emerald-700"
                                        >
                                            Edit
                                        </a>

                                        <x-admin.delete-button
                                            :action="route('admin.berita.destroy', $berita)"
                                            :message="'Hapus berita \''.$berita->title.'\'? Tindakan ini tidak dapat dibatalkan.'"
                                        />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-100 px-5 py-4">
                {{ $beritas->links() }}
            </div>
        @endif
    </div>
@endsection
