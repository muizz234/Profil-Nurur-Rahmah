<section id="beranda" class="relative isolate overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $hero['background'] }}');" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/95 via-emerald-950/80 to-emerald-900/50" aria-hidden="true"></div>

    <div class="relative px-6 py-16 sm:px-10 lg:px-16 lg:py-24 xl:px-24 2xl:px-32">
        <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-12">
            <div class="max-w-2xl">
                <p data-hero-bismillah class="mb-4 text-center font-arabic text-3xl leading-loose text-amber-300 drop-shadow-[0_2px_10px_rgba(251,191,36,0.45)] lg:mb-6 lg:text-4xl lg:leading-loose" dir="rtl">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>

                <span class="mt-6 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-cream-50 backdrop-blur">
                    <span class="h-1.5 w-1.5 rounded-full bg-gold-500" aria-hidden="true"></span>
                    Sejak {{ $hero['year'] }} · Probolinggo
                </span>

                <h1 class="mt-6 text-4xl font-semibold leading-[1.08] tracking-tight text-cream-50 sm:text-5xl xl:text-6xl">
                    {{ $hero['title'] }}
                </h1>

                <p class="mt-6 max-w-xl text-base leading-relaxed text-cream-100/85 sm:text-lg">
                    {{ $hero['subtitle'] }}
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="#profil" class="inline-flex items-center justify-center rounded-full border border-white/30 bg-white/10 px-6 py-3 text-sm font-semibold text-cream-50 backdrop-blur transition duration-200 hover:border-white/50 hover:bg-white/20">
                        Kenali Kami
                    </a>
                </div>

                <div class="mt-8 flex items-center gap-4">
                    <div class="flex -space-x-2" aria-hidden="true">
                        @foreach (['AF', 'NA', 'RZ', 'SH'] as $initial)
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full border-2 border-cream-50 bg-emerald-800 text-[11px] font-semibold text-cream-50">
                                {{ $initial }}
                            </span>
                        @endforeach
                    </div>
                    <p class="text-sm text-cream-100/75">
                        Dipercaya <span class="font-semibold text-gold-300">{{ $hero['total_santri'] }}+ keluarga</span> menitipkan pendidikan terbaik.
                    </p>
                </div>
            </div>

            <div class="flex justify-center lg:justify-end">
                <div class="relative">
                    <div class="absolute -inset-6 rounded-full bg-gold-400/20 blur-3xl sm:-inset-8" aria-hidden="true"></div>

                    <div class="relative inline-flex items-center justify-center rounded-full border border-white/20 bg-white/10 p-4 shadow-2xl shadow-emerald-950/50 backdrop-blur sm:p-6">
                        <x-landing.logo
                            :src="$logo ?? null"
                            round
                            data-hero-logo
                            class="h-48 w-48 sm:h-60 sm:w-60 lg:h-64 lg:w-64 xl:h-80 xl:w-80"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="mx-auto mt-8 max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 gap-px overflow-hidden rounded-2xl border border-emerald-900/10 bg-emerald-900/10 shadow-sm md:grid-cols-4">
        @foreach ($stats as $stat)
            <div class="bg-cream-50/90 px-6 py-6 backdrop-blur">
                <p class="text-3xl font-semibold tracking-tight text-emerald-900">{{ $stat['value'] }}</p>
                <p class="mt-1 text-sm font-medium text-slate-700">{{ $stat['label'] }}</p>
                <p class="mt-0.5 text-xs text-slate-500">{{ $stat['hint'] }}</p>
            </div>
        @endforeach
    </div>
</div>
