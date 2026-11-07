<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_the_main_sections(): void
    {
        $this->seed();

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Pondok Pesantren Nurur Rahmah');
        $response->assertSee('Tahfidz');
        $response->assertSee('Masuk');
        $response->assertSee('Daftar');
        $response->assertSee('Galeri');
        $response->assertSee('Alamat');
        $response->assertSee('Probolinggo');
        $response->assertSee('Peta lokasi Pondok Pesantren Nurur Rahmah');
    }
}
