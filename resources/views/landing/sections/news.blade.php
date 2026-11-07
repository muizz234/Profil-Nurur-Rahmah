<section id="berita" class="relative py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col justify-between gap-8 lg:flex-row lg:items-end">
            <x-landing.section-heading
                eyebrow="Berita & Artikel"
                title="Kabar terbaru dari Nurur Rahmah."
                description="Cerita tentang prestasi santri, agenda pesantren, dan pemikiran yang kami bagikan untuk umat."
            />

            <a href="#berita" class="btn-outline shrink-0">
                Semua berita
                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                    <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($news as $article)
                <article class="group flex flex-col overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="relative overflow-hidden">
                        <x-landing.smart-image
                            src="{{ $article['image'] }}"
                            alt="{{ $article['title'] }}"
                            label="{{ $article['category'] }}"
                            class="aspect-[4/3] w-full transition duration-500 group-hover:scale-[1.03]"
                        />

                        <span class="absolute left-4 top-4 rounded-full bg-emerald-900/90 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.15em] text-cream-50 backdrop-blur">
                            {{ $article['category'] }}
                        </span>
                    </div>

                    <div class="flex flex-1 flex-col p-6">
                        <p class="text-xs font-medium uppercase tracking-[0.15em] text-slate-500">{{ $article['date'] }}</p>
                        <h3 class="mt-3 text-lg font-semibold leading-snug text-emerald-950">
                            <a href="{{ $article['href'] }}" class="transition group-hover:text-emerald-800">{{ $article['title'] }}</a>
                        </h3>
                        <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">{{ $article['excerpt'] }}</p>

                        <a href="{{ $article['href'] }}" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-emerald-900 transition hover:text-emerald-700">
                            Baca selengkapnya
                            <svg viewBox="0 0 20 20" class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" aria-hidden="true">
                                <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
