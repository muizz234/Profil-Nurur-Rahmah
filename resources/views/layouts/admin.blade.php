@php
    $adminNavigation = [
        [
            'label' => 'Dashboard',
            'route' => 'admin.dashboard',
            'active' => 'admin.dashboard',
            'icon' => 'M3 8.5 10 3l7 5.5V16a1 1 0 0 1-1 1h-4v-4H8v4H4a1 1 0 0 1-1-1V8.5Z',
        ],
        [
            'label' => 'Profil Pesantren',
            'route' => 'admin.profil.index',
            'active' => 'admin.profil.*',
            'icon' => 'M10 10a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-6 7a6 6 0 0 1 12 0',
        ],
        [
            'label' => 'Kegiatan',
            'route' => 'admin.kegiatan.index',
            'active' => 'admin.kegiatan.*',
            'icon' => 'M10 2.5 12 7l4.5.5-3.3 3 1 4.5-4.2-2.3-4.2 2.3 1-4.5-3.3-3L8 7l2-4.5Z',
        ],
        [
            'label' => 'Galeri',
            'route' => 'admin.galeri.index',
            'active' => 'admin.galeri.*',
            'icon' => 'M3 5.5A1.5 1.5 0 0 1 4.5 4h11A1.5 1.5 0 0 1 17 5.5v9A1.5 1.5 0 0 1 15.5 16h-11A1.5 1.5 0 0 1 3 14.5v-9Zm2 8 3-3 2.5 2.5L14 9l3 3.5',
        ],
        [
            'label' => 'Berita',
            'route' => 'admin.berita.index',
            'active' => 'admin.berita.*',
            'icon' => 'M5 3h7l3 3v11a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm6 1v3h3M7 10h6M7 13h6',
        ],
        [
            'label' => 'Kontak & Lokasi',
            'route' => 'admin.kontak.index',
            'active' => 'admin.kontak.*',
            'icon' => 'M12 21s7-5.2 7-11a7 7 0 1 0-14 0c0 5.8 7 11 7 11Zm0-8.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z',
        ],
    ];

    $user = auth()->user();
    $initials = $user
        ? collect(preg_split('/\s+/', trim($user->name)))
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('')
        : '';

    $currentNav = collect($adminNavigation)->first(
        fn (array $item): bool => request()->routeIs($item['active']),
    );
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel — Pondok Pesantren Nurur Rahmah')</title>
    <meta name="robots" content="noindex, nofollow">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="min-h-screen bg-slate-100/70 font-sans text-ink antialiased"
    x-data="{ sidebarOpen: false, isDesktop: window.matchMedia('(min-width: 1024px)').matches }"
    x-effect="document.body.classList.toggle('overflow-hidden', sidebarOpen && !isDesktop)"
    @resize.window="isDesktop = window.matchMedia('(min-width: 1024px)').matches; if (isDesktop) { sidebarOpen = false }"
>
    <div
        x-show="sidebarOpen"
        x-cloak
        x-transition.opacity
        class="fixed inset-0 z-30 bg-slate-900/50 backdrop-blur-sm lg:hidden"
        @click="sidebarOpen = false"
        aria-hidden="true"
    ></div>

    <aside
        id="admin-sidebar"
        class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-emerald-950 text-cream-50 transition-transform duration-300 sm:w-72 lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        :aria-hidden="!sidebarOpen && !isDesktop"
        :inert="!sidebarOpen && !isDesktop"
        aria-label="Navigasi admin"
    >
        <div class="pattern-islamic pointer-events-none absolute inset-0 opacity-30" aria-hidden="true"></div>

        <div class="relative flex items-center gap-3 px-6 py-6">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-800">
                <svg viewBox="0 0 40 40" class="h-7 w-7" fill="none" aria-hidden="true">
                    <path d="M20 8c-4.4 0-8 3.6-8 8v14h16V16c0-4.4-3.6-8-8-8Z" stroke="#fdfbf7" stroke-width="1.8"/>
                    <path d="M20 13c-2.2 0-4 1.8-4 4v9h8v-9c0-2.2-1.8-4-4-4Z" fill="#fdfbf7"/>
                    <circle cx="20" cy="20" r="1.4" fill="#d97706"/>
                </svg>
            </span>

            <div class="min-w-0">
                <p class="truncate text-sm font-bold tracking-tight text-cream-50">Nurur Rahmah</p>
                <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-gold-400">Admin Panel</p>
            </div>
        </div>

        <nav class="relative min-h-0 flex-1 space-y-1 overflow-y-auto px-4 py-2">
            @foreach ($adminNavigation as $item)
                @php($isActive = request()->routeIs($item['active']))

                <a
                    href="{{ route($item['route']) }}"
                    @click="sidebarOpen = false"
                    @class([
                        'flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition',
                        'bg-emerald-800 text-cream-50 shadow-sm' => $isActive,
                        'text-cream-100/70 hover:bg-emerald-900/60 hover:text-cream-50' => ! $isActive,
                    ])
                    @if ($isActive) aria-current="page" @endif
                >
                    <svg viewBox="0 0 20 20" class="h-5 w-5 shrink-0" fill="none" aria-hidden="true">
                        <path d="{{ $item['icon'] }}" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="relative border-t border-cream-50/10 p-4">
            <div class="flex items-center gap-3 rounded-xl bg-emerald-900/60 px-3 py-2.5">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gold-500 text-xs font-bold text-emerald-950">
                    {{ $initials }}
                </span>

                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-cream-50">{{ $user?->name }}</p>
                    <p class="truncate text-[11px] text-cream-100/60">{{ $user?->email }}</p>
                </div>
            </div>

            <div class="mt-3 grid gap-2">
                <a
                    href="{{ route('home') }}"
                    @click="sidebarOpen = false"
                    class="flex items-center justify-center gap-2 rounded-full border border-cream-50/20 px-4 py-2 text-xs font-semibold text-cream-100/80 transition hover:border-cream-50/40 hover:text-cream-50"
                >
                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                        <path d="M12 5H6a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h6m1-8 3 3-3 3m3-3H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Lihat Situs
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-full bg-red-500/10 px-4 py-2 text-xs font-semibold text-red-300 transition hover:bg-red-500/20 hover:text-red-200"
                    >
                        <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                            <path d="M8 3H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3M13 7l3 3-3 3M16 10H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="lg:pl-72">
        <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/80 backdrop-blur-md">
            <div class="flex items-center justify-between gap-3 px-4 py-3 sm:px-6 lg:px-10">
                <div class="flex min-w-0 items-center gap-3">
                    <button
                        type="button"
                        @click="sidebarOpen = true"
                        :aria-expanded="sidebarOpen"
                        aria-controls="admin-sidebar"
                        class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700 lg:hidden"
                        aria-label="Buka menu admin"
                    >
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" aria-hidden="true">
                            <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="hidden text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400 sm:block">Admin Panel</p>
                        <p class="truncate text-sm font-bold tracking-tight text-slate-800">
                            {{ $currentNav['label'] ?? 'Dashboard' }}
                        </p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="relative shrink-0">
                    <button
                        type="button"
                        @click="open = !open"
                        class="flex items-center gap-3 rounded-full border border-slate-200 bg-white py-1.5 pl-1.5 pr-3 text-left transition hover:border-slate-300 hover:shadow-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-900/30"
                        :aria-expanded="open"
                        aria-haspopup="true"
                    >
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-900 text-[11px] font-bold text-cream-50">
                            {{ $initials }}
                        </span>

                        <span class="hidden min-w-0 sm:block">
                            <span class="block max-w-[12rem] truncate text-sm font-semibold text-slate-800">{{ $user?->name }}</span>
                            <span class="mt-0.5 inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-[0.08em] text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                                Administrator
                            </span>
                        </span>

                        <svg viewBox="0 0 20 20" class="h-4 w-4 shrink-0 text-slate-400 transition" :class="open ? 'rotate-180' : ''" fill="none" aria-hidden="true">
                            <path d="m6 8 4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        x-cloak
                        x-transition.origin.top.right
                        @click.outside="open = false"
                        @keydown.escape.window="open = false"
                        class="absolute right-0 mt-2 w-64 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-lg"
                        role="menu"
                    >
                        <div class="border-b border-slate-100 px-4 py-3">
                            <p class="truncate text-sm font-semibold text-slate-800">{{ $user?->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ $user?->email }}</p>
                            <span class="mt-2 inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-[0.08em] text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                                Administrator
                            </span>
                        </div>

                        <div class="p-2">
                            <a
                                href="{{ route('home') }}"
                                class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                                role="menuitem"
                            >
                                <svg viewBox="0 0 20 20" class="h-4 w-4 text-slate-400" fill="none" aria-hidden="true">
                                    <path d="M12 5H6a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h6m1-8 3 3-3 3m3-3H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Lihat Situs
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50"
                                    role="menuitem"
                                >
                                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                                        <path d="M8 3H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3M13 7l3 3-3 3M16 10H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-10 lg:py-10">
            <x-admin.flash />

            @yield('content')
        </main>
    </div>
</body>
</html>
