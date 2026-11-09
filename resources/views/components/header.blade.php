@props(['brandHref' => '#beranda', 'navPrefix' => '', 'logo' => null])

@php
    $navigation = [
        ['label' => 'Beranda', 'href' => $navPrefix.'#beranda'],
        ['label' => 'Profil', 'href' => $navPrefix.'#profil'],
        ['label' => 'Kegiatan', 'href' => $navPrefix.'#kegiatan'],
        ['label' => 'Galeri', 'href' => $navPrefix.'#galeri'],
        ['label' => 'Berita', 'href' => $navPrefix.'#berita'],
        ['label' => 'Kontak', 'href' => $navPrefix.'#kontak'],
    ];

    $user = auth()->user();
    $isAdmin = $user ? (bool) ($user->is_admin ?? false) : false;
    $initials = $user
        ? collect(preg_split('/\s+/', trim($user->name)))
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('')
        : '';
    $avatarUrl = $user?->profile_photo_url ?? $user?->avatar ?? null;

    $loginUrl = Route::has('login') ? route('login') : '#';
    $registerUrl = Route::has('register') ? route('register') : '#';
    $dashboardUrl = Route::has('dashboard') ? route('dashboard') : '#';
    $adminDashboardUrl = Route::has('admin.dashboard')
        ? route('admin.dashboard')
        : (Route::has('admin') ? route('admin') : '#');
    $logoutUrl = Route::has('logout') ? route('logout') : '#';
@endphp

<header
    x-data="{ mobileMenuOpen: false, scrolled: false }"
    x-init="scrolled = window.pageYOffset > 20"
    @scroll.window="scrolled = (window.pageYOffset > 20)"
    @keydown.escape.window="mobileMenuOpen = false; userMenuOpen = false"
    :class="scrolled ? 'border-b border-slate-100 bg-white/90 shadow-sm backdrop-blur-md' : 'border-b border-transparent bg-transparent'"
    class="sticky top-0 z-50 transition-all duration-300"
>
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8" aria-label="Navigasi utama">
        <a data-header-brand href="{{ $brandHref }}" @click="mobileMenuOpen = false" class="flex min-w-0 items-center gap-2.5 py-0.5 leading-tight sm:gap-3" aria-label="Pondok Pesantren Nurur Rahmah — Beranda">
            <x-landing.logo :src="$logo" round class="h-11 w-11 shrink-0 self-center sm:h-12 sm:w-12 xl:h-14 xl:w-14" />

            <span data-header-brand-text class="flex min-w-0 flex-col justify-center text-center">
                <span data-header-brand-arabic dir="rtl" class="hidden w-full font-arabic text-center text-sm leading-tight text-emerald-700 sm:block xl:text-base">
                    معهد نور الرحمة الإسلامي
                </span>
                <span class="block w-full text-center text-xs font-bold leading-tight tracking-wide text-slate-800 sm:text-sm xl:text-base">
                    PONDOK PESANTREN NURUR RAHMAH
                </span>
                <span class="mx-auto mt-1 hidden w-full max-w-sm text-center text-[11px] leading-snug text-slate-500 xl:block">
                    Sekretariat: Jl. KH. Zainul Mu'in, PP. Nurur Rahmah, Sambirampak Lor, Kotaanyar, Probolinggo.
                </span>
            </span>
        </a>

        <div class="hidden items-center gap-5 lg:flex xl:gap-6">
            @foreach ($navigation as $item)
                <a
                    href="{{ $item['href'] }}"
                    data-nav-link
                    class="text-sm font-medium text-slate-600 transition hover:text-emerald-600"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>

        <div class="hidden items-center gap-3 lg:flex">
            @guest
                <a
                    href="{{ $loginUrl }}"
                    class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition duration-200 hover:border-emerald-600 hover:text-emerald-600"
                >
                    Masuk
                </a>

                <a
                    href="{{ $registerUrl }}"
                    class="rounded-full bg-emerald-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-emerald-700 hover:shadow"
                >
                    Daftar
                </a>
            @endguest

            @auth
                <div
                    x-data="{ userMenuOpen: false }"
                    @keydown.escape.window="userMenuOpen = false"
                    class="relative"
                >
                    <button
                        type="button"
                        @click="userMenuOpen = !userMenuOpen"
                        :aria-expanded="userMenuOpen ? 'true' : 'false'"
                        aria-haspopup="menu"
                        class="flex items-center gap-2.5 rounded-full border border-slate-200 bg-white/80 py-1.5 pl-1.5 pr-3 transition duration-200 hover:border-emerald-600 hover:shadow-sm"
                    >
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-emerald-600 text-xs font-bold text-white">
                            @if ($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                            @else
                                {{ $initials }}
                            @endif
                        </span>

                        <span class="max-w-[9rem] truncate text-sm font-semibold text-slate-700">{{ $user->name }}</span>

                        @if ($isAdmin)
                            <span class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-800">Admin</span>
                        @endif

                        <svg
                            viewBox="0 0 20 20"
                            class="h-4 w-4 shrink-0 text-slate-400 transition duration-200"
                            :class="userMenuOpen ? 'rotate-180' : ''"
                            fill="none"
                            aria-hidden="true"
                        >
                            <path d="m5 7.5 5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <div
                        x-show="userMenuOpen"
                        x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-1 scale-95"
                        @click.outside="userMenuOpen = false"
                        class="absolute right-0 mt-2 w-64 origin-top-right rounded-2xl border border-slate-100 bg-white p-2 shadow-lg ring-1 ring-slate-900/5"
                        role="menu"
                    >
                        <div class="px-3 py-2">
                            <p class="truncate text-sm font-semibold text-slate-800">{{ $user->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>

                            @if ($isAdmin)
                                <span class="mt-2 inline-flex rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-800">Administrator</span>
                            @else
                                <span class="mt-2 inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-800">Santri / Wali</span>
                            @endif
                        </div>

                        <div class="my-1 border-t border-slate-100"></div>

                        @if ($isAdmin)
                            <a
                                href="{{ $adminDashboardUrl }}"
                                class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-700"
                                role="menuitem"
                            >
                                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                                    <path d="M3 8.5 10 3l7 5.5V16a1 1 0 0 1-1 1h-4v-4H8v4H4a1 1 0 0 1-1-1V8.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                                </svg>
                                Admin Panel / Dashboard Admin
                            </a>
                        @else
                            <a
                                href="{{ $dashboardUrl }}"
                                class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-700"
                                role="menuitem"
                            >
                                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                                    <path d="M3 8.5 10 3l7 5.5V16a1 1 0 0 1-1 1h-4v-4H8v4H4a1 1 0 0 1-1-1V8.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                                </svg>
                                Dashboard Saya / Portal Santri
                            </a>
                        @endif

                        <div class="my-1 border-t border-slate-100"></div>

                        <form method="POST" action="{{ $logoutUrl }}">
                            @csrf

                            <button
                                type="submit"
                                class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                                role="menuitem"
                            >
                                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                                    <path d="M8 3H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3M13 7l3 3-3 3M16 10H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Keluar / Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>

        <button
            type="button"
            @click="mobileMenuOpen = !mobileMenuOpen"
            :aria-expanded="mobileMenuOpen ? 'true' : 'false'"
            :aria-label="mobileMenuOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi'"
            aria-controls="header-mobile-menu"
            class="inline-flex h-11 w-11 shrink-0 items-center justify-center self-center rounded-full border border-slate-200 bg-white/80 text-slate-700 transition hover:bg-white hover:text-emerald-600 lg:hidden"
        >
            <svg x-show="!mobileMenuOpen" viewBox="0 0 24 24" class="h-5 w-5" fill="none" aria-hidden="true">
                <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>

            <svg x-show="mobileMenuOpen" x-cloak viewBox="0 0 24 24" class="h-5 w-5" fill="none" aria-hidden="true">
                <path d="m6 6 12 12M18 6 6 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </button>
    </nav>

    <div
        id="header-mobile-menu"
        x-show="mobileMenuOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="max-h-[calc(100dvh-5.5rem)] overflow-y-auto overscroll-y-contain lg:hidden"
    >
        <div class="mx-auto max-w-7xl px-4 pb-5 pt-1 sm:px-6">
            <div class="rounded-2xl border border-slate-100 bg-white/95 p-3 shadow-sm backdrop-blur-md">
                <nav class="flex flex-col" aria-label="Navigasi seluler">
                    @foreach ($navigation as $item)
                        <a
                            href="{{ $item['href'] }}"
                            @click="mobileMenuOpen = false"
                            class="rounded-xl px-4 py-3 text-sm font-medium text-slate-600 transition hover:bg-emerald-50 hover:text-emerald-700"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                @guest
                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <a
                            href="{{ $loginUrl }}"
                            @click="mobileMenuOpen = false"
                            class="flex w-full items-center justify-center rounded-full border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition duration-200 hover:border-emerald-600 hover:text-emerald-600"
                        >
                            Masuk
                        </a>

                        <a
                            href="{{ $registerUrl }}"
                            @click="mobileMenuOpen = false"
                            class="flex w-full items-center justify-center rounded-full bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-emerald-700 hover:shadow"
                        >
                            Daftar
                        </a>
                    </div>
                @endguest

                @auth
                    <div class="mt-4 rounded-xl border border-slate-100 bg-slate-50/70 p-3">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-emerald-600 text-sm font-bold text-white">
                                @if ($avatarUrl)
                                    <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                                @else
                                    {{ $initials }}
                                @endif
                            </span>

                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold text-slate-800">{{ $user->name }}</p>
                                <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                            </div>

                            @if ($isAdmin)
                                <span class="shrink-0 rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-800">Admin</span>
                            @else
                                <span class="shrink-0 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-800">Santri</span>
                            @endif
                        </div>

                        <div class="mt-3 grid gap-2">
                            @if ($isAdmin)
                                <a
                                    href="{{ $adminDashboardUrl }}"
                                    @click="mobileMenuOpen = false"
                                    class="flex w-full items-center justify-center rounded-full bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-emerald-700"
                                >
                                    Admin Panel / Dashboard Admin
                                </a>
                            @else
                                <a
                                    href="{{ $dashboardUrl }}"
                                    @click="mobileMenuOpen = false"
                                    class="flex w-full items-center justify-center rounded-full bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-emerald-700"
                                >
                                    Dashboard Saya / Portal Santri
                                </a>
                            @endif

                            <form method="POST" action="{{ $logoutUrl }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="flex w-full items-center justify-center rounded-full px-4 py-2.5 text-sm font-semibold text-red-600 transition duration-200 hover:bg-red-50"
                                >
                                    Keluar / Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div class="border-b-2 border-double border-emerald-900/10" aria-hidden="true"></div>
</header>
