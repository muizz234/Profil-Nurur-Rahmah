<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Portal — Pondok Pesantren Nurur Rahmah')</title>
    <meta name="description" content="@yield('description', 'Portal Pondok Pesantren Nurur Rahmah untuk administrator, santri, dan wali santri.')">
    <meta name="robots" content="noindex, nofollow">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#fdfbf7] font-sans text-ink antialiased">
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6">
        <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
            <div class="absolute -left-24 -top-24 h-72 w-72 rounded-full bg-emerald-200/40 blur-3xl"></div>
            <div class="absolute -bottom-32 -right-24 h-80 w-80 rounded-full bg-amber-200/40 blur-3xl"></div>
            <div class="absolute left-1/2 top-1/3 h-64 w-64 -translate-x-1/2 rounded-full bg-emerald-100/50 blur-3xl"></div>
        </div>

        <div class="relative w-full max-w-md">
            <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-xl sm:p-8">
                <div class="flex flex-col items-center text-center">
                    <a href="{{ route('home') }}" class="transition hover:opacity-90" aria-label="Kembali ke beranda Pondok Pesantren Nurur Rahmah">
                        <x-landing.logo class="h-14 w-14" />
                    </a>

                    <p class="mt-4 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-700">
                        Pondok Pesantren Nurur Rahmah
                    </p>

                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">
                        @yield('heading')
                    </h1>

                    <p class="mt-1.5 max-w-xs text-sm leading-relaxed text-slate-500">
                        @yield('subheading')
                    </p>
                </div>

                @if (session('status'))
                    <div class="mt-6 flex items-start gap-2.5 rounded-xl bg-emerald-50 p-4 text-sm text-emerald-700" role="status">
                        <svg viewBox="0 0 20 20" class="mt-0.5 h-5 w-5 shrink-0" fill="none" aria-hidden="true">
                            <path d="m6.5 10.5 2.5 2.5 4.5-5M17.5 10a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        <p>{{ session('status') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-6 flex items-start gap-2.5 rounded-xl bg-red-50 p-4 text-sm text-red-600" role="alert">
                        <svg viewBox="0 0 20 20" class="mt-0.5 h-5 w-5 shrink-0" fill="none" aria-hidden="true">
                            <path d="M10 7v4m0 3h.01M17.5 10a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>

                        <div class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-6">
                    @yield('form')
                </div>

                <div class="mt-6 border-t border-slate-100 pt-5 text-center">
                    @yield('footer')
                </div>
            </div>

            <p class="mt-6 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} Pondok Pesantren Nurur Rahmah. Seluruh hak cipta dilindungi.
            </p>
        </div>
    </div>
</body>
</html>
