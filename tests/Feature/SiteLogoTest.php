<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SiteLogoTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_a_site_logo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.profil.update'), $this->profilePayload([
            'site_logo' => UploadedFile::fake()->image('logo.png', 512, 512),
        ]));

        $response->assertRedirect(route('admin.profil.index'));

        $logo = SiteSetting::get('site_logo');
        $this->assertNotNull($logo);
        $this->assertStringStartsWith('logos/', $logo);
        Storage::disk('public')->assertExists($logo);
    }

    public function test_replacing_the_site_logo_deletes_the_old_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('logos/old-logo.png', 'old');
        SiteSetting::set('site_logo', 'logos/old-logo.png');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.profil.update'), $this->profilePayload([
            'site_logo' => UploadedFile::fake()->image('new-logo.png', 512, 512),
        ]))->assertRedirect(route('admin.profil.index'));

        Storage::disk('public')->assertMissing('logos/old-logo.png');
        Storage::disk('public')->assertExists(SiteSetting::get('site_logo'));
    }

    public function test_site_logo_must_be_a_supported_image_type(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.profil.update'), $this->profilePayload([
            'site_logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
        ]))->assertSessionHasErrors('site_logo');

        $this->assertNull(SiteSetting::get('site_logo'));
    }

    public function test_site_logo_must_not_exceed_two_megabytes(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.profil.update'), $this->profilePayload([
            'site_logo' => UploadedFile::fake()->image('large-logo.png')->size(3000),
        ]))->assertSessionHasErrors('site_logo');
    }

    public function test_admin_profile_page_shows_the_logo_upload_and_current_preview(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('logos/current-logo.png', 'logo');
        SiteSetting::set('site_logo', 'logos/current-logo.png');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('admin.profil.index'))
            ->assertOk()
            ->assertSee('Identitas Website')
            ->assertSee('name="site_logo"', false)
            ->assertSee('storage/logos/current-logo.png', false);
    }

    public function test_frontend_header_displays_the_uploaded_site_logo(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('logos/site-logo.png', 'logo');
        SiteSetting::set('site_logo', 'logos/site-logo.png');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('storage/logos/site-logo.png', false)
            ->assertSee('Logo Pondok Pesantren Nurur Rahmah');
    }

    public function test_frontend_header_uses_the_default_logo_when_none_is_uploaded(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('data-logo-fallback', false);
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
