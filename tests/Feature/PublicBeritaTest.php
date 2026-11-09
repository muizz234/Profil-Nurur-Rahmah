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

    public function test_news_index_shows_only_published_articles(): void
    {
        Berita::factory()->create(['title' => 'Berita Terbit', 'is_published' => true, 'published_at' => now()->subDay()]);
        Berita::factory()->unpublished()->create(['title' => 'Berita Draf']);
        Berita::factory()->create(['title' => 'Berita Terjadwal', 'is_published' => true, 'published_at' => now()->addDay()]);

        $response = $this->get(route('news.index'));

        $response->assertOk();
        $response->assertSee('Berita Terbit');
        $response->assertDontSee('Berita Draf');
        $response->assertDontSee('Berita Terjadwal');
    }

    public function test_news_index_paginates_published_articles(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Berita::factory()->create([
                'title' => "Berita Nomor {$i}",
                'is_published' => true,
                'published_at' => now()->subDays($i),
            ]);
        }

        $this->get(route('news.index'))->assertOk()->assertSee('Berita Nomor 1')->assertDontSee('Berita Nomor 10');
        $this->get(route('news.index', ['page' => 2]))->assertOk()->assertSee('Berita Nomor 10');
    }
}
