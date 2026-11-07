<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_page_is_displayed(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertOk();
        $response->assertSee('Lupa Password?');
        $response->assertSee('Kirim Link Reset Password');
    }

    public function test_reset_link_is_sent_to_a_registered_email(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('status');
        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    public function test_reset_link_is_not_sent_to_an_unknown_email(): void
    {
        Notification::fake();

        $response = $this->from(route('password.request'))->post(route('password.email'), [
            'email' => 'tidak-terdaftar@example.com',
        ]);

        $response->assertRedirect(route('password.request'));
        $response->assertSessionHasErrors('email');
    }

    public function test_reset_password_page_is_displayed(): void
    {
        $response = $this->get(route('password.reset', [
            'token' => 'contoh-token',
            'email' => 'santri@example.com',
        ]));

        $response->assertOk();
        $response->assertSee('Buat Password Baru');
        $response->assertSee('santri@example.com');
    }

    public function test_password_can_be_reset_with_a_valid_token(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'password-baru-123',
            'password_confirmation' => 'password-baru-123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status');
        $this->assertTrue(Hash::check('password-baru-123', $user->fresh()->password));
    }

    public function test_password_cannot_be_reset_with_an_invalid_token(): void
    {
        $user = User::factory()->create();

        $response = $this->from(route('password.reset', [
            'token' => 'token-palsu',
            'email' => $user->email,
        ]))->post(route('password.update'), [
            'token' => 'token-palsu',
            'email' => $user->email,
            'password' => 'password-baru-123',
            'password_confirmation' => 'password-baru-123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertFalse(Hash::check('password-baru-123', $user->fresh()->password));
    }

    public function test_password_reset_uses_the_custom_notification(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $token = Password::createToken($user);

        $user->sendPasswordResetNotification($token);

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    public function test_custom_notification_builds_a_branded_indonesian_email(): void
    {
        $user = User::factory()->create();
        $token = 'contoh-token-reset';

        $mail = (new ResetPasswordNotification($token))->toMail($user);

        $this->assertSame('emails.reset-password', $mail->view);
        $this->assertStringContainsString('Reset Password', $mail->subject);
        $this->assertStringContainsString('Pondok Pesantren Nurur Rahmah', $mail->subject);
        $this->assertStringContainsString(
            route('password.reset', ['token' => $token, 'email' => $user->email]),
            $mail->viewData['url'],
        );
        $this->assertSame(60, $mail->viewData['expireMinutes']);
    }

    public function test_custom_reset_email_view_renders_correctly(): void
    {
        $this->view('emails.reset-password', [
            'url' => 'https://nururrahmah.test/reset-password/contoh-token',
            'name' => 'Santri Contoh',
            'email' => 'santri@example.com',
            'expireMinutes' => 60,
        ])
            ->assertSee('Atur Ulang Password')
            ->assertSee('Santri Contoh')
            ->assertSee('https://nururrahmah.test/reset-password/contoh-token')
            ->assertSee('60 menit');
    }
}
