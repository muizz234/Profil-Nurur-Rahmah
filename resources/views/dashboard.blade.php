@extends('layouts.portal')

@section('title', 'Dashboard Santri — Pondok Pesantren Nurur Rahmah')

@section('content')
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="min-w-0">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-700">Portal Santri / Wali</p>
                <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">
                    Assalamu'alaikum, {{ auth()->user()->name }}
                </h1>
                <p class="mt-1 truncate text-sm text-slate-500">{{ auth()->user()->email }}</p>
            </div>

            <span class="shrink-0 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                Santri / Wali
            </span>
        </div>

        <div class="mt-6 rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 text-sm leading-relaxed text-emerald-900">
            Anda masuk sebagai pengguna dengan akses <strong>baca-saja</strong>. Anda dapat melihat profil,
            status, berita, dan informasi kegiatan pesantren tanpa akses mengubah atau menghapus data.
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <a
                href="{{ route('home') }}"
                class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
            >
                Kembali ke Beranda
            </a>

            @if (auth()->user()->isAdmin())
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center justify-center rounded-full border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-emerald-600 hover:text-emerald-600"
                >
                    Buka Admin Panel
                </a>
            @endif
        </div>
    </div>
@endsection
