<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Pengumuman', 'slug' => 'pengumuman'],
            ['name' => 'Berita Utama', 'slug' => 'berita-utama'],
            ['name' => 'Prestasi', 'slug' => 'prestasi'],
            ['name' => 'Syiar', 'slug' => 'syiar'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
