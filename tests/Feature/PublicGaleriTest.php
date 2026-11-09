<?php

namespace Tests\Feature;

use App\Models\Galeri;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicGaleriTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_public_gallery_page_lists_the_stored_photos(): void
    {
        Galeri::factory()->create([
            'title' => 'Halaqah Tahfidz Subuh',
            'caption' => 'Santri menghafal Al-Qur\'an selepas subuh.',
        ]);

        Galeri::factory()->create([
            'title' => 'Kajian Kitab Kuning',
            'caption' => 'Kajian kitab kuning bersama para asatidz.',
        ]);

        $response = $this->get(route('galeri.index'));

        $response->assertOk();
        $response->assertSee('Galeri Kegiatan — Pondok Pesantren Nurur Rahmah');
        $response->assertSee('2 foto kegiatan');
        $response->assertSee('Santri menghafal Al-Qur\'an selepas subuh.');
        $response->assertSee('Kajian kitab kuning bersama para asatidz.');
    }

    public function test_the_public_gallery_page_shows_an_empty_state_without_photos(): void
    {
        $this->assertDatabaseCount('galeri', 0);

        $response = $this->get(route('galeri.index'));

        $response->assertOk();
        $response->assertSee('Belum ada foto galeri.');
        $response->assertSee('0 foto kegiatan');
    }

    public function test_the_landing_page_links_to_the_public_gallery_page(): void
    {
        $this->seed();

        Galeri::factory()->count(3)->create();

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Lihat Semua Galeri');
        $response->assertSee(route('galeri.index'), false);
        $response->assertSee('hover:scale-105', false);
        $response->assertSee('hover:shadow-lg', false);
    }
}
