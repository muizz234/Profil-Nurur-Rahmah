<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\BuildsSiteContent;
use App\Models\Kegiatan;
use Illuminate\View\View;

class PublicGaleriController extends Controller
{
    use BuildsSiteContent;

    /**
     * Display the public gallery page.
     */
    public function index(): View
    {
        $settings = $this->siteSettings();
        $home = route('home');
        $gallery = $this->galleryItems();

        $programs = Kegiatan::active()
            ->orderBy('id')
            ->get()
            ->map(fn (Kegiatan $kegiatan): array => ['title' => $kegiatan->title])
            ->all();

        return view('galeri.index', [
            'gallery' => $gallery,
            'navItems' => $this->navItems($home),
            'logo' => $settings['site_logo'] ?? null,
            'programs' => $programs,
            'contact' => $this->contactContent($settings),
            'navPrefix' => $home,
            'brandHref' => $home,
        ]);
    }
}
