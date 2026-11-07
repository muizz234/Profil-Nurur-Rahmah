@extends('layouts.admin')

@section('title', 'Galeri — Admin Nurur Rahmah')

@section('content')
    <x-admin.page-header
        eyebrow="Galeri"
        title="Kelola Galeri"
        description="Dokumentasi foto kegiatan pesantren yang tampil di halaman publik."
    >
        <x-slot:actions>
            <a href="{{ route('admin.galeri.create') }}" class="btn-primary">
                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                    <path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
                Unggah Foto
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    @if ($galeris->isEmpty())
        <div class="mt-6 rounded-2xl border border-slate-100 bg-white px-5 py-12 text-center shadow-sm">
            <p class="text-sm text-slate-500">Belum ada foto galeri. Silakan unggah foto pertama Anda.</p>
        </div>
    @else
        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($galeris as $galeri)
                <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                    <div class="relative">
                        <x-landing.smart-image
                            src="{{ $galeri->image_path }}"
                            alt="{{ $galeri->title }}"
                            label="{{ $galeri->title }}"
                            class="aspect-[4/3] w-full"
                        />

                        @if ($galeri->category)
                            <span class="absolute left-3 top-3 rounded-full bg-emerald-900/90 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-cream-50 backdrop-blur">
                                {{ $galeri->category }}
                            </span>
                        @endif
                    </div>

                    <div class="p-4">
                        <p class="truncate text-sm font-semibold text-slate-800">{{ $galeri->title }}</p>
                        <p class="mt-1 line-clamp-2 text-xs leading-relaxed text-slate-500">{{ $galeri->caption ?: 'Tanpa keterangan.' }}</p>

                        <div class="mt-3 flex items-center justify-end gap-2">
                            <a
                                href="{{ route('admin.galeri.edit', $galeri) }}"
                                class="inline-flex items-center justify-center rounded-full border border-slate-200 px-3.5 py-2 text-xs font-semibold text-slate-700 transition hover:border-emerald-300 hover:text-emerald-700"
                            >
                                Edit
                            </a>

                            <x-admin.delete-button
                                :action="route('admin.galeri.destroy', $galeri)"
                                :message="'Hapus foto \''.$galeri->title.'\'? Tindakan ini tidak dapat dibatalkan.'"
                            />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $galeris->links() }}
        </div>
    @endif
@endsection
