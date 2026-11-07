<section id="beranda" class="relative overflow-hidden">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -right-24 top-10 h-72 w-72 rounded-full bg-gold-400/10 blur-3xl"></div>
        <div class="absolute -left-32 bottom-0 h-80 w-80 rounded-full bg-emerald-900/10 blur-3xl"></div>
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-emerald-900/10 to-transparent"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-12 sm:px-6 lg:px-8 lg:pb-24 lg:pt-20">
        <div class="grid items-center gap-14 lg:grid-cols-12 lg:gap-10">
            <div class="lg:col-span-6">
                <p class="font-arabic text-xl text-emerald-800/80" dir="rtl">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>

                <span class="mt-6 inline-flex items-center gap-2 rounded-full border border-emerald-900/10 bg-white/70 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-gold-500" aria-hidden="true"></span>
                    Sejak {{ $hero['year'] }} · Probolinggo
                </span>

                <h1 class="mt-6 text-4xl font-semibold leading-[1.08] tracking-tight text-emerald-950 sm:text-5xl xl:text-6xl">
                    {{ $hero['title'] }}
                </h1>

                <p class="mt-6 max-w-xl text-base leading-relaxed text-slate-600 sm:text-lg">
                    {{ $hero['subtitle'] }}
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="#kontak" class="btn-primary">
                        Daftar PPDB
                        <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                            <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <a href="#profil" class="btn-outline">Kenali Kami</a>
                </div>

                <div class="mt-8 flex items-center gap-4">
                    <div class="flex -space-x-2" aria-hidden="true">
                        @foreach (['AF', 'NA', 'RZ', 'SH'] as $initial)
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full border-2 border-cream-50 bg-emerald-800 text-[11px] font-semibold text-cream-50">
                                {{ $initial }}
                            </span>
                        @endforeach
                    </div>
                    <p class="text-sm text-slate-500">
                        Dipercaya <span class="font-semibold text-emerald-900">{{ $hero['total_santri'] }}+ keluarga</span> menitipkan pendidikan terbaik.
                    </p>
                </div>
            </div>

            <div class="lg:col-span-6">
                <div class="relative mx-auto max-w-md lg:ml-auto lg:mr-0">
                    <div class="absolute -inset-3 rounded-t-[14rem] rounded-b-[2.5rem] border border-gold-500/30" aria-hidden="true"></div>

                    <div class="relative overflow-hidden rounded-t-[14rem] rounded-b-[2.5rem] bg-emerald-950 shadow-xl shadow-emerald-900/20">
                        <x-landing.smart-image
                            src="images/hero.jpg"
                            alt="Santri Pondok Pesantren Nurur Rahmah"
                            label="Santri Nurur Rahmah"
                            class="aspect-[4/5] w-full"
                        />
                    </div>

                    <div class="absolute -bottom-6 -left-4 w-56 rounded-2xl border border-white/60 bg-cream-50/95 p-4 shadow-lg shadow-emerald-900/10 backdrop-blur sm:-left-8">
                        <p class="font-arabic text-lg leading-relaxed text-emerald-900" dir="rtl">وَاتَّقُوا اللَّهَ وَيُعَلِّمُكُمُ اللَّهُ</p>
                        <p class="mt-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">Adab sebelum ilmu</p>
                    </div>

                    <div class="absolute -right-3 top-8 rounded-2xl border border-emerald-900/10 bg-white/90 px-4 py-3 text-center shadow-lg shadow-emerald-900/10 backdrop-blur sm:-right-6">
                        <p class="text-2xl font-semibold text-emerald-900">{{ $hero['target_juz'] }}</p>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-slate-500">Juz target</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-16 grid grid-cols-2 gap-px overflow-hidden rounded-2xl border border-emerald-900/10 bg-emerald-900/10 shadow-sm sm:mt-20 md:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="bg-cream-50/90 px-6 py-6 backdrop-blur">
                    <p class="text-3xl font-semibold tracking-tight text-emerald-900">{{ $stat['value'] }}</p>
                    <p class="mt-1 text-sm font-medium text-slate-700">{{ $stat['label'] }}</p>
                    <p class="mt-0.5 text-xs text-slate-500">{{ $stat['hint'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
