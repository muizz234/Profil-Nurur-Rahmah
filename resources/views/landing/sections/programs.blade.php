<section id="kegiatan" class="relative w-full overflow-x-clip bg-cream-100/60 py-12 sm:py-16 lg:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6 sm:gap-8 lg:flex-row lg:items-end lg:justify-between">
            <x-landing.section-heading
                eyebrow="Kegiatan & Program"
                title="Ruang tumbuh yang terarah, dari halaqah hingga kelas."
                description="Setiap program dirancang untuk menyeimbangkan iman, ilmu, dan keterampilan hidup — dengan pendampingan yang konsisten setiap hari."
            />

            <a href="#kegiatan" class="btn-outline w-full shrink-0 justify-center sm:w-auto">
                Lihat Semua Program
                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                    <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>

        <div class="mt-8 grid min-w-0 gap-6 sm:mt-10 lg:mt-12 lg:grid-cols-12 lg:gap-8">
            <div class="min-w-0 lg:col-span-4">
                <div class="-mx-4 flex snap-x snap-mandatory scroll-px-4 gap-3 overflow-x-auto overscroll-x-contain px-4 pb-2 sm:mx-0 sm:px-0 lg:flex-col lg:overflow-visible lg:pb-0" role="tablist" aria-label="Program unggulan" data-program-tablist>
                    @foreach ($programs as $index => $program)
                        <button
                            type="button"
                            role="tab"
                            id="tab-{{ $program['id'] }}"
                            aria-controls="panel-{{ $program['id'] }}"
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                            data-program-tab="{{ $program['id'] }}"
                            class="group flex min-w-[200px] shrink-0 snap-start items-center gap-4 rounded-2xl border border-emerald-900/15 bg-white px-4 py-4 text-left shadow-sm transition-all duration-300 ease-in-out hover:-translate-y-0.5 hover:translate-x-1 hover:border-emerald-900 hover:bg-emerald-950 hover:shadow-md hover:shadow-emerald-950/20 sm:min-w-[220px] lg:min-w-0 lg:shrink [&[aria-selected=true]]:border-emerald-900 [&[aria-selected=true]]:bg-emerald-900 [&[aria-selected=true]]:hover:bg-emerald-900 [&[aria-selected=true]]:shadow-md [&[aria-selected=true]]:shadow-emerald-950/20"
                        >
                            <span class="font-arabic text-lg text-gray-500 transition-colors duration-300 group-hover:text-white group-[[aria-selected=true]]:text-white">0{{ $index + 1 }}</span>
                            <span class="flex-1">
                                <span class="block text-sm font-semibold text-gray-900 transition-colors duration-300 group-hover:text-white group-[[aria-selected=true]]:text-white">{{ $program['title'] }}</span>
                                <span class="mt-0.5 block text-xs text-gray-600 transition-colors duration-300 group-hover:text-gray-200 group-[[aria-selected=true]]:text-gray-200">{{ $program['tag'] }}</span>
                            </span>
                            <svg viewBox="0 0 20 20" class="h-4 w-4 shrink-0 text-emerald-900 transition-all duration-300 group-hover:translate-x-1 group-hover:text-white group-[[aria-selected=true]]:text-white" fill="none" aria-hidden="true">
                                <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="min-w-0 lg:col-span-8">
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
                                    class="block aspect-[16/9] w-full"
                                />

                                <span class="absolute left-4 top-4 max-w-[calc(100%_-_2rem)] truncate rounded-full bg-cream-50/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.15em] text-emerald-900 backdrop-blur">
                                    {{ $program['tag'] }}
                                </span>
                            </div>

                            <div class="p-5 sm:p-8">
                                <h3 class="break-words text-2xl font-semibold tracking-tight text-emerald-950">{{ $program['title'] }}</h3>
                                <p class="mt-3 break-words text-base leading-relaxed text-slate-600">{{ $program['description'] }}</p>

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
