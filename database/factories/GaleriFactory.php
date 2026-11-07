<?php

namespace Database\Factories;

use App\Models\Galeri;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Galeri>
 */
class GaleriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'title' => Str::title($title),
            'image_path' => 'galeri/'.Str::uuid().'.jpg',
            'caption' => fake()->sentence(),
            'category' => fake()->randomElement(['Tahfidz', 'Akademik', 'Fasilitas', 'Kegiatan']),
        ];
    }
}
