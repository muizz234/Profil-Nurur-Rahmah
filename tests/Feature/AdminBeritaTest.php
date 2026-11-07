<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminBeritaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_published_article_with_an_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.berita.store'), [
            'title' => 'Kabar Terbaru Pesantren',
            'category_id' => $category->id,
            'content' => 'Isi berita terbaru.',
            'is_published' => '1',
            'image' => UploadedFile::fake()->image('berita.jpg'),
        ]);

        $response->assertRedirect(route('admin.berita.index'));

        $berita = Berita::firstOrFail();

        $this->assertSame('Kabar Terbaru Pesantren', $berita->title);
        $this->assertSame('kabar-terbaru-pesantren', $berita->slug);
        $this->assertTrue($berita->is_published);
        $this->assertNotNull($berita->published_at);
        $this->assertSame($admin->id, $berita->user_id);
        Storage::disk('public')->assertExists($berita->image);
    }

    public function test_creating_an_article_requires_the_essential_fields(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.berita.store'), []);

        $response->assertSessionHasErrors(['title', 'category_id', 'content']);
        $this->assertSame(0, Berita::count());
    }

    public function test_duplicate_titles_receive_unique_slugs(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $payload = [
            'title' => 'Judul Sama',
            'category_id' => $category->id,
            'content' => 'Isi.',
        ];

        $this->actingAs($admin)->post(route('admin.berita.store'), $payload);
        $this->actingAs($admin)->post(route('admin.berita.store'), $payload);

        $slugs = Berita::orderBy('id')->pluck('slug')->all();

        $this->assertSame(['judul-sama', 'judul-sama-2'], $slugs);
    }

    public function test_updating_an_article_replaces_the_old_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $berita = Berita::factory()->create(['image' => 'berita/lama.jpg']);
        Storage::disk('public')->put('berita/lama.jpg', 'old');

        $response = $this->actingAs($admin)->put(route('admin.berita.update', $berita), [
            'title' => 'Judul Diperbarui',
            'category_id' => $berita->category_id,
            'content' => 'Isi diperbarui.',
            'image' => UploadedFile::fake()->image('baru.jpg'),
        ]);

        $response->assertRedirect(route('admin.berita.index'));

        $berita->refresh();

        $this->assertSame('Judul Diperbarui', $berita->title);
        $this->assertSame('judul-diperbarui', $berita->slug);
        Storage::disk('public')->assertMissing('berita/lama.jpg');
        Storage::disk('public')->assertExists($berita->image);
    }

    public function test_deleting_an_article_removes_it_and_its_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $berita = Berita::factory()->create(['image' => 'berita/hapus.jpg']);
        Storage::disk('public')->put('berita/hapus.jpg', 'file');

        $response = $this->actingAs($admin)->delete(route('admin.berita.destroy', $berita));

        $response->assertRedirect(route('admin.berita.index'));
        $this->assertModelMissing($berita);
        Storage::disk('public')->assertMissing('berita/hapus.jpg');
    }
}
