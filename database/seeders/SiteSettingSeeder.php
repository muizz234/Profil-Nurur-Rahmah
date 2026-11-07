<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'hero_title' => "Membentuk generasi Qur'ani, berakhlak mulia, siap berkarya.",
            'hero_subtitle' => "Pondok Pesantren Nurur Rahmah memadukan tahfidz Al-Qur'an, kajian kitab kuning, dan pendidikan formal dalam lingkungan yang hangat dan penuh keberkahan.",
            'hero_year' => '1998',
            'target_juz' => '30',
            'total_santri' => '480',
            'total_pengajar' => '36',
            'history' => "Berdiri sejak 1998, Pondok Pesantren Nurur Rahmah tumbuh dari sebuah majelis kecil di Probolinggo menjadi pesantren yang memadukan tahfidz Al-Qur'an, kajian kitab kuning, dan pendidikan formal. Kami percaya bahwa ilmu yang bermanfaat lahir dari adab yang dijaga dan lingkungan yang hangat.",
            'vision' => "Menjadi pesantren rujukan yang melahirkan generasi Qur'ani, berakal terbuka, berakhlak mulia, dan mandiri dalam berkarya.",
            'missions' => implode("\n", [
                'Menyelenggarakan pendidikan tahfidz dan diniyah yang mutqin serta menyenangkan.',
                'Memadukan kajian turats dengan kompetensi akademik dan literasi modern.',
                'Menumbuhkan adab, kemandirian, dan kepedulian sosial melalui keteladanan.',
                'Membangun lingkungan pesantren yang aman, bersih, dan penuh keberkahan.',
            ]),
            'leader_name' => 'KH. Ahmad Fauzi Abdurrahman',
            'leader_title' => 'Pengasuh Pondok Pesantren Nurur Rahmah',
            'leader_quote' => 'Pendidikan terbaik adalah yang menumbuhkan iman, ilmu, dan adab sekaligus. Kami menemani setiap santri untuk tumbuh dengan tenang, terarah, dan penuh keberkahan.',
            'leader_photo' => 'images/pengasuh.jpg',
            'site_logo' => null,
            'leader_since' => 'Mengasuh sejak 1998',
            'address' => 'Krajan, Sambirampak Lor, Kec. Kotaanyar, Kabupaten Probolinggo, Jawa Timur 67293',
            'whatsapp' => '+62 812-3456-7890',
            'email' => 'kreseknururrahmah@gmail.com',
            'operational_hours' => 'Senin – Sabtu, 08.00 – 16.00 WIB',
            'maps_embed' => 'https://www.google.com/maps?q=-7.7738738,113.5466582&z=16&output=embed',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
