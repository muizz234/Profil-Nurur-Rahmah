<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Galeri;
use App\Models\SiteSetting;
use App\Support\ContentSupport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait BuildsSiteContent
{
    /**
     * Get the site settings merged with the configured defaults.
     *
     * @return array<string, mixed>
     */
    protected function siteSettings(): array
    {
        return array_merge(config('site.defaults'), SiteSetting::allAsArray());
    }

    /**
     * Build the main navigation items.
     *
     * @return array<int, array{label: string, href: string}>
     */
    protected function navItems(string $prefix = ''): array
    {
        return [
            ['label' => 'Beranda', 'href' => $prefix.'#beranda'],
            ['label' => 'Profil', 'href' => $prefix.'#profil'],
            ['label' => 'Kegiatan', 'href' => $prefix.'#kegiatan'],
            ['label' => 'Galeri', 'href' => $prefix.'#galeri'],
            ['label' => 'Berita', 'href' => $prefix.'#berita'],
            ['label' => 'Kontak', 'href' => $prefix.'#kontak'],
        ];
    }

    /**
     * Build the gallery list from the stored photos.
     *
     * @return array<int, array{image: string, alt: string, caption: string, category: string, aspect: string}>
     */
    protected function galleryItems(): array
    {
        $aspects = ['aspect-[4/5]', 'aspect-square', 'aspect-[3/4]', 'aspect-[4/3]'];
        $aspectCount = count($aspects);

        return Galeri::query()
            ->with('category')
            ->orderBy('id')
            ->get(['id', 'title', 'caption', 'category_id', 'image_path'])
            ->map(function (Galeri $item, int $index) use ($aspects, $aspectCount): array {
                $caption = filled($item->caption) ? $item->caption : $item->title;

                return [
                    'image' => $item->image_path,
                    'alt' => $caption,
                    'caption' => $caption,
                    'category' => $item->category?->name ?: 'Galeri',
                    'aspect' => $aspects[$index % $aspectCount],
                ];
            })
            ->all();
    }

    /**
     * Resolve a stored or public image path into a browser URL.
     */
    protected function imageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (file_exists(public_path($path))) {
            return asset($path);
        }

        if (config('filesystems.disks.public.driver') !== 'local') {
            return Storage::disk('public')->url($path);
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        return null;
    }

    /**
     * Validate a stored maps embed value for safe iframe rendering.
     *
     * Only https Google Maps URLs (google.com/maps…) are accepted;
     * anything else returns null so Blade shows a text fallback instead
     * of rendering an iframe.
     */
    protected function validatedMapEmbed(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $url = ContentSupport::extractGoogleMapsUrl((string) $value);

        if ($url === null) {
            return null;
        }

        $parts = parse_url($url);

        if (($parts['scheme'] ?? null) !== 'https') {
            return null;
        }

        return $url;
    }

    /**
     * Build the contact section content from the settings.
     *
     * @param  array<string, mixed>  $settings
     * @return array{address: string, whatsapp: string, whatsapp_link: string, email: string, hours: string, maps_url: string, map_embed: ?string, socials: array<int, array{label: string, href: string}>}
     */
    protected function contactContent(array $settings): array
    {
        $mapEmbed = $this->validatedMapEmbed($settings['maps_embed'] ?? null);

        return [
            'address' => (string) $settings['address'],
            'whatsapp' => (string) $settings['whatsapp'],
            'whatsapp_link' => $this->whatsappLink((string) $settings['whatsapp']),
            'email' => (string) $settings['email'],
            'hours' => (string) $settings['operational_hours'],
            'maps_url' => $mapEmbed ?? '',
            'map_embed' => $mapEmbed,
            'socials' => [
                ['label' => 'Instagram', 'href' => 'https://instagram.com/ppnururrahmah'],
                ['label' => 'Facebook', 'href' => 'https://facebook.com/ppnururrahmah'],
                ['label' => 'YouTube', 'href' => 'https://youtube.com/@ppnururrahmah'],
            ],
        ];
    }

    /**
     * Convert a display phone number into a WhatsApp link.
     */
    protected function whatsappLink(string $number): string
    {
        $digits = preg_replace('/\D+/', '', $number) ?? '';

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        return 'https://wa.me/'.$digits;
    }
}
