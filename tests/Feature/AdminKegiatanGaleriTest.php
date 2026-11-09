<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Galeri;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminKegiatanGaleriTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_and_update_an_activity(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.kegiatan.store'), [
            'title' => 'Tahfidz Intensif',
            'description' => 'Program tahfidz harian.',
            'category' => 'tahfidz',
            'is_active' => '1',
        ])->assertRedirect(route('admin.kegiatan.index'));

        $kegiatan = Kegiatan::firstOrFail();

        $this->assertSame('tahfidz-intensif', $kegiatan->slug);
        $this->assertTrue($kegiatan->is_active);

        $this->actingAs($admin)->put(route('admin.kegiatan.update', $kegiatan), [
            'title' => 'Tahfidz Intensif Baru',
            'description' => 'Program tahfidz harian diperbarui.',
            'category' => 'formal',
        ])->assertRedirect(route('admin.kegiatan.index'));

        $kegiatan->refresh();

        $this->assertSame('Tahfidz Intensif Baru', $kegiatan->title);
        $this->assertSame('tahfidz-intensif-baru', $kegiatan->slug);
        $this->assertSame('formal', $kegiatan->category);
        $this->assertFalse($kegiatan->is_active);
    }

    public function test_activity_category_must_be_valid(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.kegiatan.store'), [
            'title' => 'Kegiatan Salah',
            'description' => 'Deskripsi.',
            'category' => 'tidak-ada',
        ]);

        $response->assertSessionHasErrors('category');
        $this->assertSame(0, Kegiatan::count());
    }

    public function test_deleting_an_activity_removes_its_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $kegiatan = Kegiatan::factory()->create(['icon_or_image' => 'kegiatan/foto.jpg']);
        Storage::disk('public')->put('kegiatan/foto.jpg', 'file');

        $this->actingAs($admin)
            ->delete(route('admin.kegiatan.destroy', $kegiatan))
            ->assertRedirect(route('admin.kegiatan.index'));

        $this->assertModelMissing($kegiatan);
        Storage::disk('public')->assertMissing('kegiatan/foto.jpg');
    }

    public function test_admin_can_create_a_gallery_item_with_an_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create(['name' => 'Kegiatan']);

        $this->actingAs($admin)->post(route('admin.galeri.store'), [
            'title' => 'Kegiatan Santri',
            'caption' => 'Suasana kegiatan.',
            'category_id' => $category->id,
            'image' => UploadedFile::fake()->image('galeri.jpg'),
        ])->assertRedirect(route('admin.galeri.index'));

        $galeri = Galeri::firstOrFail();

        $this->assertSame('Kegiatan Santri', $galeri->title);
        Storage::disk('public')->assertExists($galeri->image_path);
    }

    public function test_gallery_image_is_required_when_creating(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.galeri.store'), ['title' => 'Tanpa Foto'])
            ->assertSessionHasErrors('image');

        $this->assertSame(0, Galeri::count());
    }

    public function test_updating_a_gallery_item_replaces_the_old_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $galeri = Galeri::factory()->create(['image_path' => 'galeri/lama.jpg']);
        Storage::disk('public')->put('galeri/lama.jpg', 'old');

        $this->actingAs($admin)->put(route('admin.galeri.update', $galeri), [
            'title' => 'Judul Baru',
            'image' => UploadedFile::fake()->image('baru.jpg'),
        ])->assertRedirect(route('admin.galeri.index'));

        $galeri->refresh();

        $this->assertSame('Judul Baru', $galeri->title);
        Storage::disk('public')->assertMissing('galeri/lama.jpg');
        Storage::disk('public')->assertExists($galeri->image_path);
    }

    public function test_deleting_a_gallery_item_removes_its_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $galeri = Galeri::factory()->create(['image_path' => 'galeri/hapus.jpg']);
        Storage::disk('public')->put('galeri/hapus.jpg', 'file');

        $this->actingAs($admin)
            ->delete(route('admin.galeri.destroy', $galeri))
            ->assertRedirect(route('admin.galeri.index'));

        $this->assertModelMissing($galeri);
        Storage::disk('public')->assertMissing('galeri/hapus.jpg');
    }
}
