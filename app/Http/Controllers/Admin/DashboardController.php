<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the administrator dashboard.
     */
    public function index(): View
    {
        $stats = [
            [
                'label' => 'Total Berita',
                'value' => (string) Berita::count(),
                'hint' => Berita::published()->count().' terbit',
            ],
            [
                'label' => 'Kegiatan',
                'value' => (string) Kegiatan::count(),
                'hint' => Kegiatan::active()->count().' aktif',
            ],
            [
                'label' => 'Foto Galeri',
                'value' => (string) Galeri::count(),
                'hint' => 'Dokumentasi tersimpan',
            ],
            [
                'label' => 'Pengguna',
                'value' => (string) User::count(),
                'hint' => User::where('is_admin', true)->count().' administrator',
            ],
        ];

        $latestBeritas = Berita::with('category')
            ->latest('id')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'latestBeritas' => $latestBeritas,
        ]);
    }
}
