<footer class="relative overflow-hidden bg-emerald-950 text-cream-50">
    <div class="pattern-islamic absolute inset-0 opacity-40" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
            <div>
                <a href="{{ route('home') }}#beranda" class="flex items-center gap-3" aria-label="Pondok Pesantren Nurur Rahmah — Beranda">
                    <x-landing.logo :src="$logo ?? null" round class="h-12 w-12 shrink-0" />
                    <span class="leading-tight">
                        <span class="block font-arabic text-xl">Nurur Rahmah</span>
                        <span class="block text-[10px] font-semibold uppercase tracking-[0.25em] text-cream-100/60">Pondok Pesantren</span>
                    </span>
                </a>

                <p class="mt-5 max-w-xs text-sm leading-relaxed text-cream-100/70">
                    Membentuk generasi Qur'ani, berakhlak mulia, dan mandiri melalui pendidikan yang berakar pada adab dan ilmu.
                </p>

                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach ($contact['socials'] as $social)
                        <a
                            href="{{ $social['href'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="rounded-full border border-cream-50/15 px-3 py-1.5 text-xs font-medium text-cream-100/80 transition hover:border-gold-400/50 hover:text-cream-50"
                        >
                            {{ $social['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-400">Navigasi</h3>
                <ul class="mt-5 space-y-3 text-sm text-cream-100/70">
                    @foreach ($navItems as $item)
                        <li>
                            <a href="{{ $item['href'] }}" class="transition hover:text-cream-50">{{ $item['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-400">Program</h3>
                <ul class="mt-5 space-y-3 text-sm text-cream-100/70">
                    @foreach ($programs as $program)
                        <li>
                            <a href="{{ route('home') }}#kegiatan" class="transition hover:text-cream-50">{{ $program['title'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-400">Kontak</h3>
                <ul class="mt-5 space-y-3 text-sm text-cream-100/70">
                    <li class="leading-relaxed">{{ $contact['address'] }}</li>
                    <li>
                        <a href="{{ $contact['whatsapp_link'] }}" target="_blank" rel="noopener noreferrer" class="transition hover:text-cream-50">
                            {{ $contact['whatsapp'] }}
                        </a>
                    </li>
                    <li>
                        <a href="mailto:{{ $contact['email'] }}" class="transition hover:text-cream-50">{{ $contact['email'] }}</a>
                    </li>
                    <li>{{ $contact['hours'] }}</li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-cream-50/10 pt-6 text-xs text-cream-100/50 sm:flex-row">
            <p>&copy; {{ date('Y') }} Pondok Pesantren Nurur Rahmah. Semua hak dilindungi.</p>
            <p class="font-arabic text-sm text-gold-400/80" dir="rtl">وَاللَّهُ يُحِبُّ الْمُحْسِنِينَ</p>
        </div>
    </div>
</footer>
