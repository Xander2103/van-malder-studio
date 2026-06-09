<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public static function landingPageSlugsProvider(): array
    {
        return array_map(fn($slug) => [$slug], [
            'website-laten-maken',
            'website-vernieuwen',
            'webshop-laten-maken',
            'offerteformulier-laten-maken',
            'website-onderhoud',
            'seo-voor-lokale-bedrijven',
            'website-laten-maken-tervuren',
            'website-laten-maken-duisburg',
            'website-laten-maken-overijse',
            'website-laten-maken-huldenberg',
            'website-laten-maken-hoeilaart',
            'website-laten-maken-vlaams-brabant',
            'webdesigner-tervuren',
            'webdesigner-vlaams-brabant',
        ]);
    }

    /** @dataProvider landingPageSlugsProvider */
    public function test_landing_page_returns_200(string $slug): void
    {
        $response = $this->get("/nl/$slug");

        $response->assertStatus(200);
    }

    public function test_unknown_slug_returns_404(): void
    {
        $this->get('/nl/bestaat-niet-hoor')->assertStatus(404);
    }

    public function test_landing_page_contains_h1_text(): void
    {
        $response = $this->get('/nl/website-laten-maken');

        $response->assertStatus(200);
        $response->assertSee('Website laten maken voor je zaak');
    }

    public function test_local_landing_page_contains_location_badge(): void
    {
        $response = $this->get('/nl/website-laten-maken-tervuren');

        $response->assertStatus(200);
        $response->assertSee('Tervuren');
    }
}
