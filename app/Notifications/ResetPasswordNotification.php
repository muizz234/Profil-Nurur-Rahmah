<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPasswordBase
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $expireMinutes = (int) config(
            'auth.passwords.'.config('auth.defaults.passwords').'.expire',
            60,
        );

        return (new MailMessage)
            ->subject('Reset Password Akun — Pondok Pesantren Nurur Rahmah')
            ->view('emails.reset-password', [
                'url' => $url,
                'name' => $notifiable->name,
                'email' => $notifiable->getEmailForPasswordReset(),
                'expireMinutes' => $expireMinutes,
            ]);
    }
}
