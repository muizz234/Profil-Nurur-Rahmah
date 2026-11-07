<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = User::where('email', 'kreseknururrahmah@gmail.com')->firstOrFail()->id;
        $categoryIds = Category::pluck('id', 'slug');

        $beritas = [
            [
                'title' => "Santri Nurur Rahmah Raih Juara Musabaqah Hifzhil Qur'an Tingkat Kabupaten",
                'slug' => 'santri-nurur-rahmah-juara-mhq-kabupaten',
                'content' => "Prestasi membanggakan datang dari cabang hifzhil Qur'an. Tiga santri Pondok Pesantren Nurur Rahmah berhasil membawa pulang juara satu, dua, dan harapan satu pada Musabaqah Hifzhil Qur'an tingkat Kabupaten Probolinggo.\n\nKeberhasilan ini merupakan buah dari pembinaan halaqah tahfidz yang konsisten, muraja'ah harian, serta dukungan penuh dari para asatidz dan orang tua santri.\n\nPesantren mengucapkan terima kasih atas doa dan dukungan seluruh keluarga besar Nurur Rahmah. Semoga prestasi ini menjadi pemacu semangat untuk terus menjaga dan mengamalkan Al-Qur'an.",
                'image' => 'images/news-1.jpg',
                'category_id' => $categoryIds['prestasi'],
                'user_id' => $adminId,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Pendaftaran Santri Baru Tahun Ajaran 2027/2028 Resmi Dibuka',
                'slug' => 'pendaftaran-santri-baru-2027-2028-dibuka',
                'content' => "Pendaftaran santri baru tahun ajaran 2027/2028 resmi dibuka. Gelombang pertama dibuka dengan kuota terbatas dan akan ditutup setelah kuota terpenuhi.\n\nCalon santri dapat mendaftar secara online melalui situs pesantren maupun langsung datang ke kantor pendaftaran. Berkas yang perlu disiapkan meliputi fotokopi akta kelahiran, kartu keluarga, rapor terakhir, dan pasfoto.\n\nInformasi lebih lanjut mengenai biaya, jadwal seleksi, dan persyaratan dapat menghubungi panitia PPDB melalui WhatsApp resmi pesantren.",
                'image' => 'images/news-2.jpg',
                'category_id' => $categoryIds['pengumuman'],
                'user_id' => $adminId,
                'is_published' => true,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'Kajian Rutin Kitab Akhlak: Menanamkan Adab Sejak Dini',
                'slug' => 'kajian-rutin-kitab-akhlak',
                'content' => "Majelis kajian kitab akhlak kembali digelar di masjid pesantren. Kegiatan ini menghadirkan pengasuh dan para asatidz untuk meneguhkan pentingnya adab dalam menuntut ilmu.\n\nSantri diajak memahami bahwa ilmu yang bermanfaat selalu lahir dari adab yang dijaga. Melalui kajian ini, diharapkan para santri tumbuh menjadi pribadi yang santun, disiplin, dan menghormati guru serta sesama.\n\nKajian rutin ini terbuka bagi santri dan masyarakat sekitar yang ingin menimba ilmu bersama.",
                'image' => 'images/news-3.jpg',
                'category_id' => $categoryIds['syiar'],
                'user_id' => $adminId,
                'is_published' => true,
                'published_at' => now()->subDays(35),
            ],
            [
                'title' => 'Wisuda Tahfidz Angkatan XII: 48 Santri Khatam 30 Juz',
                'slug' => 'wisuda-tahfidz-angkatan-xii',
                'content' => "Pondok Pesantren Nurur Rahmah menggelar wisuda tahfidz angkatan XII. Sebanyak 48 santri dinyatakan khatam 30 juz setelah melalui proses setoran dan tasmi'.\n\nProsesi wisuda dihadiri oleh pengasuh, dewan asatidz, orang tua santri, serta tamu undangan. Suasana haru menyelimuti acara ketika para santri menerima syahadah hafalan.\n\nPengasuh berpesan agar hafalan yang telah diraih senantiasa dijaga melalui muraja'ah dan diamalkan dalam kehidupan sehari-hari.",
                'image' => 'images/news-4.jpg',
                'category_id' => $categoryIds['berita-utama'],
                'user_id' => $adminId,
                'is_published' => true,
                'published_at' => now()->subDays(50),
            ],
        ];

        foreach ($beritas as $berita) {
            Berita::updateOrCreate(['slug' => $berita['slug']], $berita);
        }
    }
}
