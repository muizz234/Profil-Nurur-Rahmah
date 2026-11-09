<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HeroBackgroundTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_a_hero_background(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.profil.update'), $this->profilePayload([
            'hero_background_image' => UploadedFile::fake()->image('hero-background.jpg', 1600, 900),
        ]));

        $response->assertRedirect(route('admin.profil.index'));

        $background = SiteSetting::get('hero_background_image');
        $this->assertNotNull($background);
        $this->assertStringStartsWith('hero/', $background);
        Storage::disk('public')->assertExists($background);
    }

    public function test_replacing_the_hero_background_deletes_the_old_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('hero/old-background.jpg', 'old');
        SiteSetting::set('hero_background_image', 'hero/old-background.jpg');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.profil.update'), $this->profilePayload([
            'hero_background_image' => UploadedFile::fake()->image('new-background.jpg', 1600, 900),
        ]))->assertRedirect(route('admin.profil.index'));

        Storage::disk('public')->assertMissing('hero/old-background.jpg');
        Storage::disk('public')->assertExists(SiteSetting::get('hero_background_image'));
    }

    public function test_hero_background_must_be_a_supported_image_type(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.profil.update'), $this->profilePayload([
            'hero_background_image' => UploadedFile::fake()->create('background.pdf', 100, 'application/pdf'),
        ]))->assertSessionHasErrors('hero_background_image');

        $this->assertNull(SiteSetting::get('hero_background_image'));
    }

    public function test_hero_background_must_not_exceed_three_megabytes(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.profil.update'), $this->profilePayload([
            'hero_background_image' => UploadedFile::fake()->image('large-background.jpg')->size(3500),
        ]))->assertSessionHasErrors('hero_background_image');
    }

    public function test_admin_profile_page_shows_the_hero_background_upload_and_current_preview(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('hero/current-background.jpg', 'background');
        SiteSetting::set('hero_background_image', 'hero/current-background.jpg');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('admin.profil.index'))
            ->assertOk()
            ->assertSee('Background Hero')
            ->assertSee('name="hero_background_image"', false)
            ->assertSee('storage/hero/current-background.jpg', false);
    }

    public function test_frontend_hero_displays_the_uploaded_background(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('hero/site-background.jpg', 'background');
        SiteSetting::set('hero_background_image', 'hero/site-background.jpg');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('storage/hero/site-background.jpg', false);
    }

    public function test_frontend_hero_uses_the_default_background_when_none_is_uploaded(): void
    {
        $this->assertFileExists(public_path('images/hero-default.svg'));

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('images/hero-default.svg', false);
    }

    public function test_frontend_hero_uses_the_two_column_layout_without_ppdb_or_photo_card(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Kenali Kami')
            ->assertSee('lg:grid-cols-2', false)
            ->assertSee('data-hero-logo', false)
            ->assertDontSee('Daftar PPDB')
            ->assertDontSee('Juz target')
            ->assertDontSee('Adab sebelum ilmu')
            ->assertDontSee('images/hero.jpg');
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function profilePayload(array $overrides = []): array
    {
        return array_merge([
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
        ], $overrides);
    }
}
