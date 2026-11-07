<section id="galeri" class="relative overflow-hidden bg-emerald-950 py-20 text-cream-50 sm:py-24">
    <div class="pattern-islamic absolute inset-0 opacity-40" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col justify-between gap-8 lg:flex-row lg:items-end">
            <x-landing.section-heading
                eyebrow="Galeri"
                title="Potret keseharian, dari halaqah sampai asrama."
                description="Dokumentasi sederhana tentang bagaimana santri belajar, beribadah, dan bertumbuh bersama."
                tone="light"
            />

            <a href="#kontak" class="btn-gold shrink-0">
                Kunjungi pesantren
                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                    <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>

        <div class="mt-12 columns-2 gap-4 md:columns-3 lg:gap-5">
            @foreach ($gallery as $item)
                <figure class="mb-4 break-inside-avoid overflow-hidden rounded-2xl border border-cream-50/10 bg-cream-50/5 lg:mb-5">
                    <x-landing.smart-image
                        src="{{ $item['image'] }}"
                        alt="{{ $item['alt'] }}"
                        label="{{ $item['caption'] }}"
                        class="{{ $item['aspect'] }} w-full"
                    />

                    <figcaption class="flex items-center justify-between gap-3 px-4 py-3">
                        <span class="text-xs font-medium text-cream-100/90">{{ $item['caption'] }}</span>
                        <span class="text-[10px] font-semibold uppercase tracking-[0.15em] text-gold-400/80">{{ $item['category'] }}</span>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
