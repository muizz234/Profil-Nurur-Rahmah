<?php

namespace App\Http\Controllers\Concerns;

use App\Models\SiteSetting;

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
     * Build the contact section content from the settings.
     *
     * @param  array<string, mixed>  $settings
     * @return array{address: string, whatsapp: string, whatsapp_link: string, email: string, hours: string, maps_url: string, map_embed: string, socials: array<int, array{label: string, href: string}>}
     */
    protected function contactContent(array $settings): array
    {
        return [
            'address' => (string) $settings['address'],
            'whatsapp' => (string) $settings['whatsapp'],
            'whatsapp_link' => $this->whatsappLink((string) $settings['whatsapp']),
            'email' => (string) $settings['email'],
            'hours' => (string) $settings['operational_hours'],
            'maps_url' => (string) $settings['maps_embed'],
            'map_embed' => (string) $settings['maps_embed'],
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
