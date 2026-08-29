<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoAndClientWorkTest extends TestCase
{
    // ── Client work section (About page) ─────────────────────────────────────

    public static function aboutPathProvider(): array
    {
        return [
            'nl' => ['/nl/over-mij'],
            'fr' => ['/fr/a-propos'],
            'en' => ['/en/about'],
            'de' => ['/de/ueber-mich'],
        ];
    }

    /** @dataProvider aboutPathProvider */
    public function test_about_page_has_client_work_section_with_live_links(string $path): void
    {
        $response = $this->get($path);

        $response->assertStatus(200);
        $response->assertSee('id="client-work"', false);

        foreach (config('client-work') as $work) {
            $response->assertSee($work['title']);
            $response->assertSee('href="'.$work['url'].'"', false);
        }

        // External links open safely in a new tab.
        $response->assertSee('rel="noopener noreferrer"', false);
    }

    public function test_about_page_client_work_comes_before_own_projects(): void
    {
        $html = $this->get('/en/about')->getContent();

        $this->assertLessThan(
            strpos($html, 'id="vm-studios"'),
            strpos($html, 'id="client-work"'),
            'Client work must be rendered before the VM Studios section'
        );
    }

    public function test_about_page_shows_dotnet_positioning_and_updated_stack(): void
    {
        $response = $this->get('/en/about');

        $response->assertSee('.NET developer');
        $response->assertSee('ASP.NET Core');
        $response->assertSee('Entity Framework Core');
        $response->assertSee('Microsoft Azure');
        $response->assertDontSee('>PDO<', false);
    }

    public function test_about_page_lists_ballpicker_app(): void
    {
        $response = $this->get('/en/about');

        $response->assertSee('Ballpicker App');
        $response->assertSee('React Native');
        $response->assertSee('id="vm-ballpicker"', false);
    }

    // ── Navigation ───────────────────────────────────────────────────────────

    public static function workNavProvider(): array
    {
        return [
            'nl' => ['/nl', 'Klantprojecten', 'http://localhost/nl/over-mij#client-work'],
            'fr' => ['/fr', 'Projets clients', 'http://localhost/fr/a-propos#client-work'],
            'en' => ['/en', 'Client Projects', 'http://localhost/en/about#client-work'],
            'de' => ['/de', 'Kundenprojekte', 'http://localhost/de/ueber-mich#client-work'],
        ];
    }

    /** @dataProvider workNavProvider */
    public function test_navigation_has_locale_aware_work_link(string $path, string $label, string $href): void
    {
        $response = $this->get($path);

        $response->assertStatus(200);
        $response->assertSee('href="'.$href.'"', false);
        $response->assertSee($label);
    }

    public function test_visible_local_link_list_is_removed(): void
    {
        $home = $this->get('/nl');

        $home->assertDontSee('Lokaal in Tervuren, de Druivenstreek');
        $home->assertDontSee('Website laten maken in Hoeilaart');
        $home->assertDontSee('Webdesigner in Tervuren · Leuven');

        $services = $this->get('/nl/diensten');
        $services->assertDontSee('Lokaal in de Druivenstreek');
    }

    // ── Technical SEO ────────────────────────────────────────────────────────

    public function test_robots_txt_allows_search_and_ai_crawlers(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertSee("User-agent: *\nAllow: /", false);
        $response->assertSee("User-agent: OAI-SearchBot\nAllow: /", false);
        $response->assertSee('Sitemap: http://localhost/sitemap.xml');
        $response->assertDontSee("Disallow: /\n", false);
    }

    public function test_sitemap_lists_all_ready_locales_with_hreflang(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        foreach (['/nl/over-mij', '/fr/a-propos', '/en/about', '/de/ueber-mich', '/nl/website-laten-maken-tervuren'] as $path) {
            $response->assertSee('<loc>http://localhost'.$path.'</loc>', false);
        }
        $response->assertSee('hreflang="x-default"', false);
        $response->assertDontSee('<loc>http://localhost/</loc>', false);
    }

    public static function legacyRouteProvider(): array
    {
        return [
            ['/diensten', '/nl/diensten'],
            ['/over-mij', '/nl/over-mij'],
            ['/prijzen', '/nl/prijzen'],
            ['/werkwijze', '/nl/werkwijze'],
            ['/contact', '/nl/contact'],
            ['/showcase', '/nl/showcase'],
            ['/privacyverklaring', '/nl/privacyverklaring'],
        ];
    }

    /** @dataProvider legacyRouteProvider */
    public function test_legacy_unprefixed_routes_redirect_permanently(string $from, string $to): void
    {
        $response = $this->get($from);

        $response->assertStatus(301);
        $response->assertRedirect($to);
    }

    public function test_pages_are_indexable_and_carry_hreflang(): void
    {
        $response = $this->get('/en/services');

        $response->assertSee('<meta name="robots" content="index, follow">', false);
        $response->assertSee('hreflang="en" href="http://localhost/en/services"', false);
        $response->assertSee('hreflang="nl" href="http://localhost/nl/diensten"', false);
        $response->assertSee('hreflang="x-default" href="http://localhost/nl/diensten"', false);
        $response->assertSee('<html lang="en"', false);
    }

    public function test_landing_pages_do_not_emit_hreflang_cluster(): void
    {
        $response = $this->get('/nl/website-laten-maken-tervuren');

        $response->assertStatus(200);
        $response->assertDontSee('hreflang="x-default"', false);
        $response->assertSee('<link rel="canonical" href="http://localhost/nl/website-laten-maken-tervuren">', false);
    }

    public function test_open_graph_has_image_and_matching_url(): void
    {
        $response = $this->get('/en');

        $response->assertSee('property="og:image" content="http://localhost/preview.png"', false);
        $response->assertSee('name="twitter:card" content="summary_large_image"', false);
        $response->assertSee('property="og:url" content="http://localhost/en"', false);
    }

    // ── Structured data ──────────────────────────────────────────────────────

    public function test_every_page_emits_business_person_and_website_entities(): void
    {
        $html = $this->get('/en/about')->getContent();

        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches);
        $this->assertNotEmpty($matches[1], 'No JSON-LD found');

        $graph = null;
        foreach ($matches[1] as $json) {
            $decoded = json_decode(trim($json), true);
            $this->assertNotNull($decoded, 'JSON-LD is not valid JSON: '.json_last_error_msg());
            if (isset($decoded['@graph'])) {
                $graph = $decoded['@graph'];
            }
        }

        $this->assertNotNull($graph, 'Layout entity graph missing');
        $types = array_map(fn ($n) => is_array($n['@type']) ? $n['@type'][0] : $n['@type'], $graph);

        $this->assertContains('ProfessionalService', $types);
        $this->assertContains('Person', $types);
        $this->assertContains('WebSite', $types);
        $this->assertContains('AboutPage', $types);
        $this->assertContains('BreadcrumbList', $types);

        $business = collect($graph)->first(fn ($n) => in_array('ProfessionalService', (array) $n['@type']));
        $this->assertSame('Van Malder Studio', $business['name']);
        $this->assertSame('Tervuren', $business['address']['addressLocality']);
        $this->assertArrayNotHasKey('sameAs', $business, 'sameAs must be omitted when no real profiles are configured');
        $this->assertArrayNotHasKey('telephone', $business);
        $this->assertArrayNotHasKey('aggregateRating', $business);

        $person = collect($graph)->first(fn ($n) => $n['@type'] === 'Person');
        $this->assertSame('Xander Van Malder', $person['name']);
        $this->assertSame($business['@id'], $person['worksFor']['@id']);
    }

    public function test_about_page_emits_client_work_item_list(): void
    {
        $html = $this->get('/en/about')->getContent();

        $this->assertStringContainsString('"@type":"ItemList"', $html);
        $this->assertStringContainsString('"url":"https://mastechnics.be"', $html);
        $this->assertStringContainsString('"url":"https://drsuelizaeta.be"', $html);
        $this->assertStringContainsString('"url":"https://schrijnwerkerijvankerkhoven.be"', $html);
    }

    public function test_services_page_has_faq_with_schema(): void
    {
        $response = $this->get('/en/services');

        $response->assertSee('Do you develop in C# and .NET?');
        $response->assertSee('"@type":"FAQPage"', false);
    }

    // ── Conversion / content ─────────────────────────────────────────────────

    public function test_homepage_states_who_what_where_within_hero(): void
    {
        $html = $this->get('/en')->getContent();
        $hero = substr($html, 0, strpos($html, 'B. TRUST STRIP') ?: 6000);

        $this->assertStringContainsString('Van Malder Studio', $hero);
        $this->assertStringContainsString('Xander Van Malder', $hero);
        $this->assertStringContainsString('Tervuren', $hero);
        $this->assertStringContainsString('web applications', $hero);
        $this->assertStringContainsString('.NET', $hero);
    }

    public function test_homepage_links_to_client_work(): void
    {
        $response = $this->get('/en');

        $response->assertSee('href="http://localhost/en/about#client-work"', false);
        $response->assertSee('Mastechnics');
    }

    public function test_contact_page_shows_contact_details_and_form(): void
    {
        $response = $this->get('/en/contact');

        $response->assertSee(config('studio.email'));
        $response->assertSee(config('studio.location'));
        $response->assertSee('"@type":"ContactPage"', false);

        // The service-area / response-time / what-happens-next panel was removed.
        $response->assertDontSee('Service area');
        $response->assertDontSee('Response time');
        $response->assertDontSee('What happens next');
    }
}
