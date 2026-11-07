<section id="profil" class="relative py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-12 lg:gap-10">
            <div class="lg:col-span-5">
                <x-landing.section-heading
                    eyebrow="Profil Pesantren"
                    title="Berakar pada tradisi, tumbuh untuk masa depan."
                />

                <p class="mt-6 text-base leading-relaxed text-slate-600">
                    {{ $history }}
                </p>

                <div class="mt-10 space-y-8">
                    <div class="rounded-2xl border border-emerald-900/10 bg-white/70 p-6 shadow-sm">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Visi</h3>
                        <p class="mt-3 text-base leading-relaxed text-emerald-950">{{ $vision }}</p>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Misi</h3>
                        <ul class="mt-4 space-y-3">
                            @foreach ($missions as $mission)
                                <li class="flex items-start gap-3 text-sm leading-relaxed text-slate-700">
                                    <span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-900/10 text-emerald-900">
                                        <svg viewBox="0 0 16 16" class="h-3 w-3" fill="none" aria-hidden="true">
                                            <path d="m3.5 8.5 3 3 6-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                    {{ $mission }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div class="relative overflow-hidden rounded-2xl bg-emerald-900 text-cream-50 shadow-md">
                    <div class="pattern-islamic absolute inset-0 opacity-60" aria-hidden="true"></div>

                    <div class="relative grid gap-0 sm:grid-cols-2">
                        <x-landing.smart-image
                            src="{{ $leader['image'] }}"
                            alt="{{ $leader['name'] }}, {{ $leader['title'] }}"
                            label="Pengasuh Pesantren"
                            class="h-full min-h-64 w-full"
                        />

                        <div class="flex flex-col justify-between p-6 sm:p-8">
                            <div>
                                <svg viewBox="0 0 32 32" class="h-8 w-8 text-gold-400/80" fill="currentColor" aria-hidden="true">
                                    <path d="M12.5 7C7.8 9.4 5 13.4 5 18.2 5 22.5 7.6 25 10.8 25c2.8 0 4.9-2 4.9-4.7 0-2.6-1.9-4.5-4.4-4.5-.5 0-1 .1-1.4.2.6-2.4 2.4-4.4 4.9-5.8L12.5 7Zm13 0c-4.7 2.4-7.5 6.4-7.5 11.2 0 4.3 2.6 6.8 5.8 6.8 2.8 0 4.9-2 4.9-4.7 0-2.6-1.9-4.5-4.4-4.5-.5 0-1 .1-1.4.2.6-2.4 2.4-4.4 4.9-5.8L25.5 7Z"/>
                                </svg>

                                <blockquote class="mt-5 font-arabic text-2xl leading-relaxed text-cream-50 sm:text-[1.7rem]">
                                    {{ $leader['quote'] }}
                                </blockquote>

                                <div class="mt-6">
                                    <p class="text-sm font-semibold text-cream-50">{{ $leader['name'] }}</p>
                                    <p class="mt-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-cream-100/60">{{ $leader['title'] }}</p>
                                </div>
                            </div>

                            <p class="mt-8 inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.2em] text-gold-400">
                                <span class="h-px w-6 bg-current" aria-hidden="true"></span>
                                {{ $leader['since'] }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    @foreach ([
                        ['title' => 'Iman & Adab', 'text' => 'Keteladanan dan pembiasaan adab dalam keseharian.'],
                        ['title' => 'Ilmu & Amal', 'text' => 'Belajar untuk memahami, lalu mengamalkan dengan benar.'],
                        ['title' => 'Mandiri & Berguna', 'text' => 'Menumbuhkan kemandirian yang bermanfaat bagi umat.'],
                    ] as $pillar)
                        <div class="rounded-2xl border border-emerald-900/10 bg-white/70 p-5 shadow-sm">
                            <h4 class="text-sm font-semibold text-emerald-950">{{ $pillar['title'] }}</h4>
                            <p class="mt-2 text-xs leading-relaxed text-slate-600">{{ $pillar['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
