<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityRegressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_svg_upload_to_leader_photo_is_rejected_with_422(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.profil.update'), [
            'hero_title' => 'Judul',
            'hero_subtitle' => 'Subjudul',
            'hero_year' => '2001',
            'target_juz' => '30',
            'total_santri' => '500',
            'total_pengajar' => '40',
            'history' => 'Sejarah',
            'vision' => 'Visi',
            'missions' => "Misi satu\nMisi dua",
            'leader_name' => 'KH. Baru',
            'leader_title' => 'Pengasuh',
            'leader_quote' => 'Kutipan',
            'leader_since' => 'Mengasuh sejak 2001',
            'leader_photo' => UploadedFile::fake()->create('evil.svg', 10, 'image/svg+xml'),
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('leader_photo');
    }

    public function test_non_google_maps_embed_is_rejected(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.kontak.update'), [
            'address' => 'Alamat',
            'whatsapp' => '0812',
            'email' => 'halo@nururrahmah.sch.id',
            'operational_hours' => 'Jam kerja',
            'maps_embed' => 'https://evil.example.com/embed',
        ])->assertSessionHasErrors('maps_embed');
    }

    public function test_non_admin_user_cannot_access_admin_route(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_duplicate_berita_title_does_not_return_500(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $payload = [
            'title' => 'Judul Sama',
            'category_id' => $category->id,
            'content' => 'Isi.',
        ];

        $this->actingAs($admin)->post(route('admin.berita.store'), $payload)
            ->assertRedirect(route('admin.berita.index'));

        $second = $this->actingAs($admin)->post(route('admin.berita.store'), $payload);

        $second->assertRedirect(route('admin.berita.index'));
        $this->assertNotSame(500, $second->getStatusCode());
        $this->assertSame(['judul-sama', 'judul-sama-2'], Berita::orderBy('id')->pluck('slug')->all());
    }
}
