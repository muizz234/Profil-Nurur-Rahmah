<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_admin_area(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_regular_user_is_forbidden_from_admin_area(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.berita.index'))->assertForbidden();
    }

    public function test_admin_can_access_the_dashboard_and_management_pages(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($admin)->get(route('admin.profil.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.kontak.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.berita.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.kegiatan.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.galeri.index'))->assertOk();
    }
}
