<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password — Pondok Pesantren Nurur Rahmah</title>
</head>
<body style="margin:0;padding:0;background-color:#fdfbf7;font-family:'Segoe UI',Arial,sans-serif;color:#0f172a;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#fdfbf7;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background-color:#ffffff;border-radius:24px;overflow:hidden;border:1px solid #e2e8f0;">
                    <tr>
                        <td style="background-color:#064e3b;padding:28px 32px;text-align:center;">
                            <p style="margin:0;font-size:11px;font-weight:700;letter-spacing:0.2em;text-transform:uppercase;color:#e8b04b;">
                                Pondok Pesantren Nurur Rahmah
                            </p>
                            <h1 style="margin:8px 0 0;font-size:22px;font-weight:700;color:#fdfbf7;">
                                Permintaan Reset Password
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 16px;font-size:15px;line-height:1.7;color:#0f172a;">
                                Assalamu&rsquo;alaikum, <strong>{{ $name }}</strong>.
                            </p>

                            <p style="margin:0 0 16px;font-size:15px;line-height:1.7;color:#334155;">
                                Kami menerima permintaan untuk mengatur ulang kata sandi akun portal
                                Pondok Pesantren Nurur Rahmah yang terhubung dengan email
                                <strong>{{ $email }}</strong>.
                            </p>

                            <p style="margin:0 0 24px;font-size:15px;line-height:1.7;color:#334155;">
                                Silakan klik tombol di bawah ini untuk membuat kata sandi baru.
                            </p>

                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto 24px;">
                                <tr>
                                    <td style="border-radius:9999px;background-color:#047857;">
                                        <a href="{{ $url }}" style="display:inline-block;padding:14px 32px;font-size:15px;font-weight:700;color:#ffffff;text-decoration:none;border-radius:9999px;">
                                            Atur Ulang Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 16px;font-size:13px;line-height:1.7;color:#64748b;">
                                Tautan ini hanya berlaku selama <strong>{{ $expireMinutes }} menit</strong>.
                                Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:
                            </p>

                            <p style="margin:0 0 24px;font-size:12px;line-height:1.6;color:#047857;word-break:break-all;">
                                {{ $url }}
                            </p>

                            <div style="border-top:1px solid #e2e8f0;padding-top:16px;">
                                <p style="margin:0;font-size:13px;line-height:1.7;color:#64748b;">
                                    Jika Anda tidak merasa meminta reset password, abaikan email ini.
                                    Kata sandi akun Anda tidak akan berubah dan tetap aman.
                                </p>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="background-color:#f8fafc;padding:20px 32px;text-align:center;">
                            <p style="margin:0;font-size:12px;line-height:1.6;color:#94a3b8;">
                                &copy; {{ date('Y') }} Pondok Pesantren Nurur Rahmah.<br>
                                Email resmi: <a href="mailto:kreseknururrahmah@gmail.com" style="color:#047857;text-decoration:none;">kreseknururrahmah@gmail.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
