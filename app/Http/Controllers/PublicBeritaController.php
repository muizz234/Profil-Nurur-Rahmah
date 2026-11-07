<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\BuildsSiteContent;
use App\Models\Berita;
use App\Models\Kegiatan;
use Illuminate\View\View;

class PublicBeritaController extends Controller
{
    use BuildsSiteContent;

    /**
     * Display the public detail page for a news article.
     */
    public function show(Berita $berita): View
    {
        abort_unless(
            $berita->is_published
                && $berita->published_at !== null
                && $berita->published_at->isPast(),
            404
        );

        $berita->load(['category', 'user']);

        $settings = $this->siteSettings();
        $home = route('home');

        $programs = Kegiatan::active()
            ->orderBy('id')
            ->get()
            ->map(fn (Kegiatan $kegiatan): array => ['title' => $kegiatan->title])
            ->all();

        return view('berita.show', [
            'berita' => $berita,
            'navItems' => $this->navItems($home),
            'logo' => $settings['site_logo'] ?? null,
            'programs' => $programs,
            'contact' => $this->contactContent($settings),
            'navPrefix' => $home,
            'brandHref' => $home,
        ]);
    }
}
