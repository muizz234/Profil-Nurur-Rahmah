@extends('layouts.auth')

@section('title', 'Verifikasi Email — Pondok Pesantren Nurur Rahmah')
@section('description', 'Verifikasi alamat email akun portal Pondok Pesantren Nurur Rahmah.')

@section('heading', 'Verifikasi Email Anda')
@section('subheading', 'Terima kasih telah mendaftar! Silakan periksa inbox email Anda dan klik tautan verifikasi yang kami kirimkan sebelum melanjutkan.')

@section('form')
    <div class="flex items-start gap-3 rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-white">
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" aria-hidden="true">
                <path d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>

        <div class="min-w-0">
            <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-emerald-700">Email Terdaftar</p>
            <p class="mt-1 truncate text-sm font-semibold text-slate-800">{{ auth()->user()?->email }}</p>
        </div>
    </div>

    <p class="mt-5 text-center text-sm leading-relaxed text-slate-500">
        Belum menerima email verifikasi? Tekan tombol di bawah untuk mengirim ulang tautan verifikasi.
    </p>

    <form method="POST" action="{{ route('verification.send') }}" class="mt-5">
        @csrf

        <button
            type="submit"
            class="group flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 py-3 text-sm font-semibold text-white shadow-md transition duration-200 hover:bg-emerald-700 hover:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2"
        >
            <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                <path d="M16 10a6 6 0 1 1-1.76-4.24M16 4v4h-4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kirim Ulang Email Verifikasi
        </button>
    </form>

    <p class="mt-4 text-center text-xs leading-relaxed text-slate-400">
        Jika email tidak muncul di inbox, silakan periksa folder spam atau promosi.
    </p>
@endsection

@section('footer')
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button
            type="submit"
            class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition hover:text-red-600"
        >
            <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                <path d="M8 3H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3M13 7l3 3-3 3M16 10H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Keluar / Logout
        </button>
    </form>
@endsection
