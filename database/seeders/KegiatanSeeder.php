<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
use Illuminate\Database\Seeder;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kegiatan = [
            [
                'title' => "Tahfidz Al-Qur'an",
                'slug' => 'tahfidz-al-quran',
                'description' => "Program unggulan dengan halaqah kecil, target hafalan terukur, dan bimbingan muraja'ah harian agar hafalan santri mutqin sekaligus terjaga.",
                'icon_or_image' => 'images/program-tahfidz.jpg',
                'category' => 'tahfidz',
                'is_active' => true,
            ],
            [
                'title' => 'Kajian Kitab Kuning',
                'slug' => 'kajian-kitab-kuning',
                'description' => 'Kajian turats dengan metode sorogan dan bandongan, membangun pemahaman agama yang berakar pada tradisi ulama dan relevan dengan zaman.',
                'icon_or_image' => 'images/program-kitab.jpg',
                'category' => 'kitab_kuning',
                'is_active' => true,
            ],
            [
                'title' => 'Pendidikan Formal',
                'slug' => 'pendidikan-formal',
                'description' => 'Madrasah dan sekolah formal yang memadukan kurikulum nasional dengan nilai pesantren, menyiapkan santri untuk melanjutkan ke jenjang perguruan tinggi.',
                'icon_or_image' => 'images/program-formal.jpg',
                'category' => 'formal',
                'is_active' => true,
            ],
            [
                'title' => 'Ekstrakurikuler & Kemandirian',
                'slug' => 'ekstrakurikuler-kemandirian',
                'description' => 'Ruang berekspresi dan berorganisasi untuk menumbuhkan percaya diri, kepemimpinan, dan keterampilan hidup yang seimbang dengan adab.',
                'icon_or_image' => 'images/program-ekskul.jpg',
                'category' => 'ekstrakurikuler',
                'is_active' => true,
            ],
        ];

        foreach ($kegiatan as $item) {
            Kegiatan::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
