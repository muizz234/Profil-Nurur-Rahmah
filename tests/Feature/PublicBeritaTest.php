<?php

namespace Tests\Feature;

use App\Models\Berita;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicBeritaTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_published_article_is_visible_to_the_public(): void
    {
        $berita = Berita::factory()->create([
            'title' => 'Pengumuman Penting',
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get(route('berita.show', $berita));

        $response->assertOk();
        $response->assertSee('Pengumuman Penting');
    }

    public function test_an_unpublished_article_returns_not_found(): void
    {
        $berita = Berita::factory()->unpublished()->create();

        $this->get(route('berita.show', $berita))->assertNotFound();
    }

    public function test_an_article_scheduled_in_the_future_is_not_visible(): void
    {
        $berita = Berita::factory()->create([
            'is_published' => true,
            'published_at' => now()->addDay(),
        ]);

        $this->get(route('berita.show', $berita))->assertNotFound();
    }
}
