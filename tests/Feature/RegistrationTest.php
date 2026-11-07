<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_is_displayed(): void
    {
        $response = $this->get(route('register'));

        $response->assertOk();
        $response->assertSee('Daftar Akun Baru');
        $response->assertSee('Konfirmasi Password');
    }

    public function test_new_user_is_registered_as_a_regular_user_and_authenticated(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Santri Baru',
            'email' => 'santri@example.com',
            'password' => 'password-baru-123',
            'password_confirmation' => 'password-baru-123',
        ]);

        $response->assertRedirect(route('dashboard'));

        $user = User::where('email', 'santri@example.com')->first();

        $this->assertNotNull($user);
        $this->assertFalse($user->is_admin);
        $this->assertAuthenticatedAs($user);
    }

    public function test_registration_cannot_assign_the_admin_role(): void
    {
        $this->post(route('register'), [
            'name' => 'Penyusup',
            'email' => 'penyusup@example.com',
            'password' => 'password-baru-123',
            'password_confirmation' => 'password-baru-123',
            'is_admin' => true,
        ]);

        $user = User::where('email', 'penyusup@example.com')->first();

        $this->assertNotNull($user);
        $this->assertFalse($user->is_admin);
    }

    public function test_registration_requires_a_unique_email(): void
    {
        User::factory()->create(['email' => 'sudah-dipakai@example.com']);

        $response = $this->from(route('register'))->post(route('register'), [
            'name' => 'Santri Baru',
            'email' => 'sudah-dipakai@example.com',
            'password' => 'password-baru-123',
            'password_confirmation' => 'password-baru-123',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_registration_requires_a_confirmed_password(): void
    {
        $response = $this->from(route('register'))->post(route('register'), [
            'name' => 'Santri Baru',
            'email' => 'santri@example.com',
            'password' => 'password-baru-123',
            'password_confirmation' => 'password-berbeda',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }
}
