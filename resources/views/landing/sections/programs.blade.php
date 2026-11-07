<section id="kegiatan" class="relative bg-cream-100/60 py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col justify-between gap-8 lg:flex-row lg:items-end">
            <x-landing.section-heading
                eyebrow="Kegiatan & Program"
                title="Ruang tumbuh yang terarah, dari halaqah hingga kelas."
                description="Setiap program dirancang untuk menyeimbangkan iman, ilmu, dan keterampilan hidup — dengan pendampingan yang konsisten setiap hari."
            />

            <a href="#kontak" class="btn-outline shrink-0">
                Jadwalkan kunjungan
                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                    <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>

        <div class="mt-12 grid gap-8 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <div class="flex gap-3 overflow-x-auto pb-2 lg:flex-col lg:overflow-visible lg:pb-0" role="tablist" aria-label="Program unggulan">
                    @foreach ($programs as $index => $program)
                        <button
                            type="button"
                            role="tab"
                            id="tab-{{ $program['id'] }}"
                            aria-controls="panel-{{ $program['id'] }}"
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                            data-program-tab="{{ $program['id'] }}"
                            class="group flex min-w-[220px] items-center gap-4 rounded-2xl border px-4 py-4 text-left transition lg:min-w-0 {{ $index === 0 ? 'border-emerald-900 bg-emerald-900 text-cream-50 shadow-md' : 'border-emerald-900/10 bg-white/70 text-emerald-950 hover:border-emerald-900/30 hover:bg-white' }}"
                        >
                            <span class="font-arabic text-lg opacity-60">0{{ $index + 1 }}</span>
                            <span class="flex-1">
                                <span class="block text-sm font-semibold">{{ $program['title'] }}</span>
                                <span class="mt-0.5 block text-xs opacity-70">{{ $program['tag'] }}</span>
                            </span>
                            <svg viewBox="0 0 20 20" class="h-4 w-4 shrink-0 opacity-60" fill="none" aria-hidden="true">
                                <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-8">
                @foreach ($programs as $index => $program)
                    <div
                        id="panel-{{ $program['id'] }}"
                        role="tabpanel"
                        aria-labelledby="tab-{{ $program['id'] }}"
                        data-program-panel="{{ $program['id'] }}"
                        class="{{ $index === 0 ? '' : 'hidden' }}"
                    >
                        <div class="overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-sm">
                            <div class="relative">
                                <x-landing.smart-image
                                    src="{{ $program['image'] }}"
                                    alt="{{ $program['title'] }} di Pondok Pesantren Nurur Rahmah"
                                    label="{{ $program['title'] }}"
                                    class="aspect-[16/9] w-full"
                                />

                                <span class="absolute left-4 top-4 rounded-full bg-cream-50/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.15em] text-emerald-900 backdrop-blur">
                                    {{ $program['tag'] }}
                                </span>
                            </div>

                            <div class="p-6 sm:p-8">
                                <h3 class="text-2xl font-semibold tracking-tight text-emerald-950">{{ $program['title'] }}</h3>
                                <p class="mt-3 text-base leading-relaxed text-slate-600">{{ $program['description'] }}</p>

                                @if (! empty($program['highlights']))
                                    <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                                        @foreach ($program['highlights'] as $highlight)
                                            <li class="flex items-start gap-2 text-sm text-slate-700">
                                                <span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-gold-500/15 text-gold-600">
                                                    <svg viewBox="0 0 16 16" class="h-3 w-3" fill="none" aria-hidden="true">
                                                        <path d="m3.5 8.5 3 3 6-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </span>
                                                {{ $highlight }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
