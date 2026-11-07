<section id="kontak" class="relative scroll-mt-24 overflow-hidden bg-slate-50 py-8 md:py-16 lg:py-24">
    @php
        $cardBase = 'group flex h-full flex-col rounded-2xl border border-slate-100/80 bg-white p-6 shadow-sm transition-all duration-200';
        $cardAction = 'hover:-translate-y-1 hover:border-emerald-500/30 hover:shadow-md active:scale-[0.98] active:bg-slate-50';
        $iconClass = 'inline-flex shrink-0 rounded-xl bg-emerald-50 p-2.5 text-emerald-600';
        $labelClass = 'text-xs font-semibold uppercase tracking-[0.2em] text-slate-500';
        $valueClass = 'mt-3 text-sm font-medium leading-relaxed text-slate-700';
        $arrowClass = 'ml-auto h-4 w-4 shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-emerald-500';
    @endphp

    <div class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8">
        <x-landing.section-heading
            eyebrow="Kontak & Lokasi"
            title="Mari bertemu, berdiskusi, dan bertumbuh bersama."
            description="Silakan hubungi kami untuk informasi PPDB, kunjungan pesantren, atau kerja sama pendidikan."
            titleClass="text-2xl font-semibold tracking-tight sm:text-3xl lg:text-4xl"
        />

        <div class="mt-8 grid grid-cols-1 gap-6 md:gap-8 lg:grid-cols-12 lg:items-stretch">
            <div class="grid grid-cols-1 gap-3.5 md:grid-cols-2 lg:col-span-5 lg:grid-cols-1 xl:grid-cols-2">
                <a
                    href="{{ $contact['maps_url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Lihat alamat Pondok Pesantren Nurur Rahmah di Google Maps"
                    class="{{ $cardBase }} {{ $cardAction }}"
                >
                    <div class="flex items-center gap-3">
                        <span class="{{ $iconClass }}">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" aria-hidden="true">
                                <path d="M12 21s7-5.2 7-11a7 7 0 1 0-14 0c0 5.8 7 11 7 11Z" stroke="currentColor" stroke-width="1.5"/>
                                <circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </span>
                        <h3 class="{{ $labelClass }}">Alamat</h3>
                        <svg viewBox="0 0 20 20" class="{{ $arrowClass }}" fill="none" aria-hidden="true">
                            <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="{{ $valueClass }}">{{ $contact['address'] }}</p>
                </a>

                <a
                    href="{{ $contact['whatsapp_link'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Hubungi Pondok Pesantren Nurur Rahmah via WhatsApp"
                    class="{{ $cardBase }} {{ $cardAction }}"
                >
                    <div class="flex items-center gap-3">
                        <span class="{{ $iconClass }}">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" aria-hidden="true">
                                <path d="M5 4h4l1.8 4.2-2.3 1.6a12 12 0 0 0 5.7 5.7l1.6-2.3L20 15v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <h3 class="{{ $labelClass }}">WhatsApp</h3>
                        <svg viewBox="0 0 20 20" class="{{ $arrowClass }}" fill="none" aria-hidden="true">
                            <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="{{ $valueClass }}">{{ $contact['whatsapp'] }}</p>
                </a>

                <a
                    href="mailto:{{ $contact['email'] }}"
                    aria-label="Kirim email ke Pondok Pesantren Nurur Rahmah"
                    class="{{ $cardBase }} {{ $cardAction }}"
                >
                    <div class="flex items-center gap-3">
                        <span class="{{ $iconClass }}">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" aria-hidden="true">
                                <rect x="3" y="5" width="18" height="14" rx="2.5" stroke="currentColor" stroke-width="1.5"/>
                                <path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <h3 class="{{ $labelClass }}">Email</h3>
                        <svg viewBox="0 0 20 20" class="{{ $arrowClass }}" fill="none" aria-hidden="true">
                            <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="{{ $valueClass }} break-words">{{ $contact['email'] }}</p>
                </a>

                <div class="{{ $cardBase }}">
                    <div class="flex items-center gap-3">
                        <span class="{{ $iconClass }}">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" aria-hidden="true">
                                <circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M12 7.5V12l3 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <h3 class="{{ $labelClass }}">Jam Operasional</h3>
                    </div>
                    <p class="{{ $valueClass }}">{{ $contact['hours'] }}</p>
                </div>
            </div>

            <div class="relative h-60 overflow-hidden rounded-xl border border-slate-100/80 bg-white shadow-sm md:h-80 md:rounded-2xl lg:col-span-7 lg:h-auto lg:min-h-[420px] lg:self-stretch">
                <iframe
                    src="{{ $contact['map_embed'] }}"
                    title="Peta lokasi Pondok Pesantren Nurur Rahmah"
                    class="absolute inset-0 h-full w-full"
                    style="border:0;"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>

                <a
                    href="{{ $contact['maps_url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="absolute bottom-3 right-3 inline-flex items-center gap-2 rounded-full bg-white/95 px-3.5 py-2 text-[11px] font-semibold text-emerald-700 shadow-sm backdrop-blur transition hover:bg-white active:scale-[0.98] sm:bottom-4 sm:right-4 sm:px-4 sm:text-xs"
                >
                    Buka di Google Maps
                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                        <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
