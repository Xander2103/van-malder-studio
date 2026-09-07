<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Search Console driven local SEO: one primary page per intent
 * (Leuven, Tervuren, Vlaams-Brabant, Overijse), indexable, canonical,
 * in the sitemap, internally linked, with real client proof.
 */
class LocalSeoPriorityPagesTest extends TestCase
{
    public static function priorityPageProvider(): array
    {
        return [
            'leuven'         => ['website-laten-maken-leuven', 'Website laten maken in Leuven', 'Website laten maken in Leuven | Van Malder Studio'],
            'tervuren'       => ['website-laten-maken-tervuren', 'Website laten maken in Tervuren', 'Website laten maken in Tervuren | Van Malder Studio'],
            'vlaams-brabant' => ['webdesigner-vlaams-brabant', 'Webdesign en webdevelopment in Vlaams-Brabant', 'Webdesign in Vlaams-Brabant | Van Malder Studio'],
            'overijse'       => ['website-laten-maken-overijse', 'Website laten maken in Overijse en de Druivenstreek', 'Website laten maken in Overijse | Van Malder Studio'],
        ];
    }

    /** @dataProvider priorityPageProvider */
    public function test_priority_page_is_indexable_canonical_and_has_single_h1(string $slug, string $h1, string $title): void
    {
        $response = $this->get("/nl/$slug");
        $response->assertStatus(200);

        $html = $response->getContent();

        $this->assertSame(1, preg_match_all('/<h1\b/', $html), "Exactly one <h1> expected on /nl/$slug");
        $response->assertSee($h1);
        $response->assertSee('<title>' . e($title) . '</title>', false);
        $response->assertSee('<meta name="robots" content="index, follow">', false);
        $response->assertSee('<link rel="canonical" href="http://localhost/nl/' . $slug . '">', false);
        $response->assertSee('property="og:url" content="http://localhost/nl/' . $slug . '"', false);
        $response->assertSee('<html lang="nl"', false);
        // NL-only landing pages must not emit a cross-locale cluster.
        $response->assertDontSee('hreflang="x-default"', false);
        // No literal translation keys (e.g. "site.landing_pages.cta_heading") leaked into the page.
        $this->assertDoesNotMatchRegularExpression('/\bsite\.[a-z_]+\.[a-z_]+/', strip_tags($html));
    }

    /** @dataProvider priorityPageProvider */
    public function test_priority_page_links_to_client_projects_and_contact(string $slug): void
    {
        $response = $this->get("/nl/$slug");

        $response->assertSee('href="http://localhost/nl/klantprojecten"', false);
        $response->assertSee('href="http://localhost/nl/klantprojecten#project-mastechnics"', false);
        $response->assertSee('href="http://localhost/nl/contact"', false);
        $response->assertSee('Mastechnics');
        // Proof stays short: the full case-study copy is not duplicated.
        $response->assertDontSee(__('site.client_work.items.mastechnics.description'));
        $response->assertSee('"@type": "FAQPage"', false);
    }

    /** @dataProvider priorityPageProvider */
    public function test_priority_page_is_in_sitemap(string $slug): void
    {
        $xml = $this->get('/sitemap.xml')->getContent();

        $this->assertStringContainsString("<loc>http://localhost/nl/$slug</loc>", $xml);
    }

    public function test_retired_slugs_are_not_in_sitemap(): void
    {
        $xml = $this->get('/sitemap.xml')->getContent();

        $this->assertStringNotContainsString('/nl/webdesigner-tervuren<', $xml);
        $this->assertStringNotContainsString('/nl/website-laten-maken-vlaams-brabant<', $xml);
    }

    public function test_no_page_links_to_a_retired_slug(): void
    {
        foreach (['/nl', '/nl/diensten', '/nl/website-laten-maken-leuven', '/nl/website-laten-maken-tervuren', '/nl/webdesigner-vlaams-brabant', '/nl/website-laten-maken-overijse', '/nl/website-laten-maken'] as $path) {
            $html = $this->get($path)->getContent();
            $this->assertStringNotContainsString('/nl/webdesigner-tervuren"', $html, "$path links to retired slug webdesigner-tervuren");
            $this->assertStringNotContainsString('/nl/website-laten-maken-vlaams-brabant"', $html, "$path links to retired slug website-laten-maken-vlaams-brabant");
        }
    }

    public function test_leuven_page_answers_the_commercial_and_drupal_intents(): void
    {
        $response = $this->get('/nl/website-laten-maken-leuven');

        $response->assertSee('gevestigd in Tervuren');
        $response->assertSee('Bouw je ook Drupal-websites?');
        $response->assertSee('Bespreek je website');
        $response->assertSee('750');
        // No fake Leuven office.
        $response->assertDontSee('kantoor in Leuven.');
        $response->assertSee('href="http://localhost/nl/website-laten-maken-tervuren"', false);
        $response->assertSee('href="http://localhost/nl/webdesigner-vlaams-brabant"', false);
    }

    public function test_leuven_page_is_linked_from_homepage_and_services_page(): void
    {
        $this->get('/nl')->assertSee('href="http://localhost/nl/website-laten-maken-leuven"', false);
        $this->get('/nl/diensten')->assertSee('href="http://localhost/nl/website-laten-maken-leuven"', false);
        $this->get('/nl/website-laten-maken-tervuren')->assertSee('href="http://localhost/nl/website-laten-maken-leuven"', false);
        $this->get('/nl/webdesigner-vlaams-brabant')->assertSee('href="http://localhost/nl/website-laten-maken-leuven"', false);
    }

    public function test_homepage_local_sentence_is_nl_only_and_not_a_city_list(): void
    {
        $nl = $this->get('/nl');
        $nl->assertSee('href="http://localhost/nl/website-laten-maken-tervuren"', false);
        $nl->assertSee('href="http://localhost/nl/webdesigner-vlaams-brabant"', false);
        $nl->assertDontSee('Website laten maken in Hoeilaart');
        $nl->assertDontSee('Website laten maken in Duisburg');

        foreach (['/en', '/fr', '/de'] as $path) {
            $response = $this->get($path);
            $response->assertDontSee('/nl/website-laten-maken-leuven', false);
            $this->assertStringNotContainsString('site.home.local_note', $response->getContent());
        }
    }

    public function test_homepage_title_no_longer_competes_with_tervuren_landing_page(): void
    {
        $this->get('/nl')->assertSee('<title>Van Malder Studio — Webdesign &amp; webdevelopment uit Tervuren</title>', false);
        $this->get('/nl')->assertDontSee('<title>Website laten maken in Tervuren', false);
    }

    /**
     * Every price quoted on a landing page must be one of the official
     * guide prices from the pricing page (Starter €750, Professioneel €1.250,
     * Productcatalogus €950, eenvoudige webshop €1.500, onderhoud €50/maand,
     * add-ons €75 / €150). No invented tiers.
     */
    public function test_landing_pages_only_quote_official_prices_and_link_to_pricing_page(): void
    {
        $official = ['750', '1.250', '950', '1.500', '50', '150', '75'];
        // Local pages only (those with a location); service pages such as the form page carry their own add-on prices.
        $pages = collect(config('landing-pages'))->filter(fn ($p) => empty($p['redirect_to']) && !empty($p['location']))->pluck('slug');
        $this->assertGreaterThanOrEqual(4, $pages->count());

        foreach ($pages as $slug) {
            $response = $this->get("/nl/$slug");
            $response->assertSee('href="http://localhost/nl/prijzen"', false);

            preg_match_all('/€\s?([0-9][0-9.,]*)/u', strip_tags($response->getContent()), $matches);
            foreach ($matches[1] as $amount) {
                $this->assertContains(rtrim($amount, '.,'), $official, "/nl/$slug quotes €$amount which is not an official guide price");
            }
        }
    }

    public function test_services_technology_faq_mentions_drupal_in_every_locale(): void
    {
        foreach (['/nl/diensten', '/en/services', '/fr/services', '/de/dienstleistungen'] as $path) {
            $this->get($path)->assertSee('Drupal');
        }
    }
}
