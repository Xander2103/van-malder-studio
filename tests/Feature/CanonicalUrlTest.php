<?php

namespace Tests\Feature;

use Tests\TestCase;

class CanonicalUrlTest extends TestCase
{
    public static function localeHomepageProvider(): array
    {
        return [
            'nl homepage' => ['/nl', 'http://localhost/nl'],
            'fr homepage' => ['/fr', 'http://localhost/fr'],
            'en homepage' => ['/en', 'http://localhost/en'],
            'de homepage' => ['/de', 'http://localhost/de'],
        ];
    }

    /**
     * @dataProvider localeHomepageProvider
     */
    public function test_locale_homepage_has_self_referencing_canonical(string $path, string $expected): void
    {
        $response = $this->get($path);
        $response->assertStatus(200);
        $response->assertSee('<link rel="canonical" href="' . $expected . '">', false);
    }

    /**
     * @dataProvider localeHomepageProvider
     */
    public function test_locale_homepage_og_url_matches_canonical(string $path, string $expected): void
    {
        $response = $this->get($path);
        $response->assertStatus(200);
        $response->assertSee('og:url', false);
        $response->assertSee($expected, false);
    }

    public function test_canonical_does_not_point_to_root_for_nl_homepage(): void
    {
        $response = $this->get('/nl');
        $response->assertStatus(200);
        // Must NOT contain the root as canonical
        $html = $response->getContent();
        $this->assertStringNotContainsString('<link rel="canonical" href="http://localhost/">', $html);
        $this->assertStringNotContainsString('<link rel="canonical" href="http://localhost">', $html);
    }

    public function test_inner_page_has_self_referencing_canonical(): void
    {
        $response = $this->get('/nl/diensten');
        $response->assertStatus(200);
        $response->assertSee('<link rel="canonical" href="http://localhost/nl/diensten">', false);
    }

    public function test_landing_page_canonical_is_set_by_controller(): void
    {
        $response = $this->get('/nl/website-laten-maken');
        $response->assertStatus(200);
        $response->assertSee('<link rel="canonical" href="http://localhost/nl/website-laten-maken">', false);
    }

    public function test_contact_page_has_locale_aware_canonical(): void
    {
        $response = $this->get('/nl/contact');
        $response->assertStatus(200);
        $response->assertSee('<link rel="canonical" href="http://localhost/nl/contact">', false);
    }
}
