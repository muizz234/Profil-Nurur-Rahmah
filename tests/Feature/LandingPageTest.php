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

    public function test_header_displays_the_pesantren_kop_branding(): void
    {
        $this->seed();

        $response = $this->get(route('home'))->assertOk();

        $response->assertSee('font-arabic', false);
        $response->assertSee('معهد نور الرحمة الإسلامي');
        $response->assertSee('PONDOK PESANTREN NURUR RAHMAH');
        $response->assertSee("Sekretariat: Jl. KH. Zainul Mu'in, PP. Nurur Rahmah, Sambirampak Lor, Kotaanyar, Probolinggo.", false);
        $response->assertSee('border-double', false);
    }

    public function test_header_brand_text_is_center_aligned(): void
    {
        $this->seed();

        $html = $this->get(route('home'))->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<a[^>]*data-header-brand[^>]*class="[^"]*\bitems-center\b[^"]*"/', $html);
        $this->assertMatchesRegularExpression('/<span[^>]*data-header-brand-text[^>]*class="[^"]*\btext-center\b[^"]*"/', $html);
    }

    public function test_header_arabic_brand_line_is_center_aligned(): void
    {
        $this->seed();

        $html = $this->get(route('home'))->assertOk()->getContent();

        $this->assertMatchesRegularExpression(
            '/<span[^>]*data-header-brand-arabic[^>]*class="[^"]*\bw-full\b[^"]*\btext-center\b[^"]*"/',
            $html
        );
        $this->assertStringNotContainsString('text-left font-arabic', $html);
    }

    public function test_hero_displays_styled_bismillah_lafaz(): void
    {
        $this->seed();

        $response = $this->get(route('home'))->assertOk();

        $response->assertSee('بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ');
        $response->assertSee('data-hero-bismillah', false);

        $html = $response->getContent();

        $this->assertMatchesRegularExpression(
            '/<p[^>]*data-hero-bismillah[^>]*class="[^"]*\btext-amber-300\b[^"]*"/',
            $html
        );
        $this->assertMatchesRegularExpression(
            '/<p[^>]*data-hero-bismillah[^>]*class="[^"]*\btext-center\b[^"]*"/',
            $html
        );
        $this->assertMatchesRegularExpression(
            '/<p[^>]*data-hero-bismillah[^>]*class="[^"]*\bfont-arabic\b[^"]*"/',
            $html
        );
    }
}
