<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\BuildsSiteContent;
use App\Models\Berita;
use App\Models\Galeri;
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
        $gallery = $this->gallery();
        $news = $this->news();

        return view('landing.index', [
            'navItems' => $this->navItems(),
            'logo' => $settings['site_logo'] ?? null,
            'hero' => [
                'title' => (string) $settings['hero_title'],
                'subtitle' => (string) $settings['hero_subtitle'],
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
                'image' => (string) $settings['leader_photo'],
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
     * Build the gallery list from the stored photos.
     *
     * @return array<int, array{image: string, alt: string, caption: string, category: string, aspect: string}>
     */
    private function gallery(): array
    {
        $aspects = ['aspect-[4/5]', 'aspect-square', 'aspect-[3/4]', 'aspect-[4/3]'];

        return Galeri::query()
            ->orderBy('id')
            ->get()
            ->values()
            ->map(function (Galeri $item, int $index) use ($aspects): array {
                $caption = $item->caption ?: $item->title;

                return [
                    'image' => $item->image_path,
                    'alt' => $caption,
                    'caption' => $caption,
                    'category' => $item->category ?: 'Galeri',
                    'aspect' => $aspects[$index % count($aspects)],
                ];
            })
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
