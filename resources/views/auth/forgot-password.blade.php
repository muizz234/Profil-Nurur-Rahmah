@extends('layouts.auth')

@section('title', 'Lupa Password — Pondok Pesantren Nurur Rahmah')
@section('description', 'Minta tautan reset password untuk akun portal Pondok Pesantren Nurur Rahmah.')

@section('heading', 'Lupa Password?')
@section('subheading', 'Masukkan email Anda, kami akan mengirimkan tautan untuk menyetel ulang kata sandi.')

@section('form')
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">
                Email
            </label>

            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" aria-hidden="true">
                        <path d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="nama@email.com"
                    aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                    class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 @error('email') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                >
            </div>

            @error('email')
                <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="group flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 py-3 text-sm font-semibold text-white shadow-md transition duration-200 hover:bg-emerald-700 hover:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2"
        >
            Kirim Link Reset Password
            <svg viewBox="0 0 20 20" class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" aria-hidden="true">
                <path d="M4 10h12m0 0-4.5-4.5M16 10l-4.5 4.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </form>
@endsection

@section('footer')
    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition hover:text-emerald-600">
        <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
            <path d="M16 10H4m0 0 4.5-4.5M4 10l4.5 4.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Kembali ke Halaman Login
    </a>
@endsection
