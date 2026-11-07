<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_the_profile_settings(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.profil.update'), [
            'hero_title' => 'Judul Baru',
            'hero_subtitle' => 'Subjudul baru.',
            'hero_year' => '2001',
            'target_juz' => '30',
            'total_santri' => '500',
            'total_pengajar' => '40',
            'history' => 'Sejarah baru.',
            'vision' => 'Visi baru.',
            'missions' => "  Misi satu  \r\n\r\n  Misi dua  ",
            'leader_name' => 'KH. Baru',
            'leader_title' => 'Pengasuh',
            'leader_quote' => 'Kutipan baru.',
            'leader_since' => 'Mengasuh sejak 2001',
            'leader_photo' => UploadedFile::fake()->image('pengasuh.jpg'),
        ]);

        $response->assertRedirect(route('admin.profil.index'));

        $this->assertSame('Judul Baru', SiteSetting::get('hero_title'));
        $this->assertSame('500', SiteSetting::get('total_santri'));
        $this->assertSame("Misi satu\nMisi dua", SiteSetting::get('missions'));

        $photo = SiteSetting::get('leader_photo');
        $this->assertNotNull($photo);
        Storage::disk('public')->assertExists($photo);
    }

    public function test_profile_update_validates_required_fields(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.profil.update'), [])
            ->assertSessionHasErrors([
                'hero_title',
                'hero_subtitle',
                'history',
                'vision',
                'missions',
                'leader_name',
            ]);
    }

    public function test_admin_can_update_contact_settings_and_extract_the_maps_url(): void
    {
        $admin = User::factory()->admin()->create();

        $iframe = '<iframe src="https://maps.example.com/embed?q=probolinggo" width="600"></iframe>';

        $response = $this->actingAs($admin)->post(route('admin.kontak.update'), [
            'address' => 'Alamat baru',
            'whatsapp' => '+62 812 0000 0000',
            'email' => 'halo@nururrahmah.sch.id',
            'operational_hours' => 'Senin - Jumat, 08.00 - 15.00',
            'maps_embed' => $iframe,
        ]);

        $response->assertRedirect(route('admin.kontak.index'));

        $this->assertSame('Alamat baru', SiteSetting::get('address'));
        $this->assertSame('halo@nururrahmah.sch.id', SiteSetting::get('email'));
        $this->assertSame(
            'https://maps.example.com/embed?q=probolinggo',
            SiteSetting::get('maps_embed'),
        );
    }

    public function test_contact_update_validates_the_email(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.kontak.update'), [
            'address' => 'Alamat',
            'whatsapp' => '0812',
            'email' => 'bukan-email',
            'operational_hours' => 'Jam kerja',
            'maps_embed' => 'https://maps.example.com/embed',
        ])->assertSessionHasErrors('email');
    }
}
