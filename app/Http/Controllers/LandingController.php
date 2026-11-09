<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\BuildsSiteContent;
use App\Models\Berita;
use App\Models\Kegiatan;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LandingController extends Controller
{
    use BuildsSiteContent;

    /**
     * Display the public landing page.
     */
    public function index(): View
    {
        $settings = $this->siteSettings();

        $programs = $this->programs();
        $gallery = $this->galleryItems();
        $news = $this->news();

        return view('landing.index', [
            'navItems' => $this->navItems(),
            'logo' => $settings['site_logo'] ?? null,
            'hero' => [
                'title' => (string) $settings['hero_title'],
                'subtitle' => (string) $settings['hero_subtitle'],
                'background' => $this->imageUrl($settings['hero_background_image'] ?? null) ?? asset('images/hero-default.svg'),
                'year' => (string) $settings['hero_year'],
                'target_juz' => (string) $settings['target_juz'],
                'total_santri' => (string) $settings['total_santri'],
            ],
            'stats' => [
                [
                    'value' => $settings['total_santri'].'+',
                    'label' => 'Santri aktif',
                    'hint' => 'Putra & putri',
                ],
                [
                    'value' => (string) $settings['total_pengajar'],
                    'label' => 'Pengajar & musyrif',
                    'hint' => 'Bersertifikat',
                ],
                [
                    'value' => (string) count($programs),
                    'label' => 'Program unggulan',
                    'hint' => 'Terintegrasi',
                ],
                [
                    'value' => (string) $settings['hero_year'],
                    'label' => 'Tahun berdiri',
                    'hint' => 'Mengabdi untuk umat',
                ],
            ],
            'history' => (string) $settings['history'],
            'vision' => (string) $settings['vision'],
            'missions' => $this->missions($settings['missions'] ?? null),
            'leader' => [
                'name' => (string) $settings['leader_name'],
                'title' => (string) $settings['leader_title'],
                'image' => $this->imageUrl($settings['leader_photo'] ?? null),
                'since' => (string) $settings['leader_since'],
                'quote' => (string) $settings['leader_quote'],
            ],
            'programs' => $programs,
            'gallery' => $gallery,
            'news' => $news,
            'contact' => $this->contactContent($settings),
        ]);
    }

    /**
     * Build the programs list from the active activities.
     *
     * @return array<int, array{id: string, title: string, tag: string, description: string, image: string|null, highlights: array<int, string>}>
     */
    private function programs(): array
    {
        $labels = [
            'tahfidz' => 'Tahfidz',
            'kitab_kuning' => 'Diniyah',
            'formal' => 'Akademik',
            'ekstrakurikuler' => 'Pengembangan Diri',
        ];

        return Kegiatan::active()
            ->orderBy('id')
            ->get()
            ->map(fn (Kegiatan $kegiatan): array => [
                'id' => $kegiatan->slug,
                'title' => $kegiatan->title,
                'tag' => $labels[$kegiatan->category] ?? Str::headline($kegiatan->category),
                'description' => $kegiatan->description,
                'image' => $kegiatan->icon_or_image,
                'highlights' => [],
            ])
            ->values()
            ->all();
    }

    /**
     * Build the latest published news list.
     *
     * @return array<int, array{title: string, excerpt: string, date: string, category: string, image: string|null, href: string}>
     */
    private function news(): array
    {
        return Berita::published()
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(fn (Berita $berita): array => [
                'title' => $berita->title,
                'excerpt' => Str::limit(strip_tags($berita->content), 140),
                'date' => $berita->published_at?->translatedFormat('j F Y') ?? '',
                'category' => $berita->category?->name ?? 'Berita',
                'image' => $berita->image,
                'href' => route('berita.show', $berita->slug),
            ])
            ->all();
    }

    /**
     * Normalise the missions setting into a list.
     *
     * @return array<int, string>
     */
    private function missions(mixed $missions): array
    {
        if (is_array($missions)) {
            return array_values(array_filter($missions, fn (mixed $mission): bool => filled($mission)));
        }

        if (is_string($missions) && trim($missions) !== '') {
            return collect(preg_split('/\r\n|\r|\n/', $missions))
                ->map(fn (string $mission): string => trim($mission))
                ->filter()
                ->values()
                ->all();
        }

        return [];
    }
}
