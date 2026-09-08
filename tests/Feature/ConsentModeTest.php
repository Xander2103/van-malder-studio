<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Google Consent Mode v2 + custom cookie banner.
 * The tag ID comes from config('services.google.tag_id') (GOOGLE_TAG_ID).
 */
class ConsentModeTest extends TestCase
{
    private const TAG = 'G-TEST12345';

    private function withTag(): void
    {
        config(['services.google.tag_id' => self::TAG]);
    }

    public function test_without_tag_id_no_google_tag_and_no_banner_is_rendered(): void
    {
        config(['services.google.tag_id' => null]);

        $html = $this->get('/nl')->getContent();

        $this->assertStringNotContainsString('googletagmanager.com', $html);
        $this->assertStringNotContainsString("gtag('consent'", $html);
        $this->assertStringNotContainsString('data-consent-banner', $html);
        $this->assertStringNotContainsString('data-consent-open', $html);
    }

    public function test_consent_default_is_denied_before_config_and_before_the_tag_loads(): void
    {
        $this->withTag();
        $html = $this->get('/nl')->getContent();

        $default = strpos($html, "gtag('consent', 'default'");
        $config  = strpos($html, "gtag('config', \"" . self::TAG . "\")");
        $script  = strpos($html, 'https://www.googletagmanager.com/gtag/js?id=' . self::TAG);
        $vite    = strpos($html, 'resources/js/app.js') ?: strpos($html, '/build/assets/app-');

        $this->assertNotFalse($default, 'consent default missing');
        $this->assertNotFalse($config, 'gtag config missing');
        $this->assertNotFalse($script, 'gtag.js script missing');

        $this->assertLessThan($config, $default, 'consent default must come before gtag config');
        $this->assertLessThan($script, $config, 'gtag config must be queued before gtag.js is loaded');
        if ($vite) {
            $this->assertLessThan($vite, $script, 'gtag must be set up before the app bundle');
        }

        // All four Consent Mode v2 keys default to denied; nothing granted server-side.
        $block = substr($html, $default, strpos($html, '});', $default) - $default);
        foreach (['ad_storage', 'analytics_storage', 'ad_user_data', 'ad_personalization'] as $key) {
            $this->assertMatchesRegularExpression("/$key:\s*'denied'/", $block, "$key must default to denied");
        }
        $this->assertStringNotContainsString("'granted'", $block);
        $this->assertStringContainsString('vms_consent=', $html, 'saved choice must be restored from the first-party cookie');
    }

    public function test_google_tag_is_initialised_exactly_once(): void
    {
        $this->withTag();
        $html = $this->get('/nl')->getContent();

        $this->assertSame(1, substr_count($html, 'googletagmanager.com/gtag/js'));
        $this->assertSame(1, substr_count($html, "gtag('config'"));
        $this->assertSame(1, substr_count($html, "gtag('js'"));
        $this->assertSame(1, substr_count($html, 'data-consent-banner'));
    }

    public static function localeProvider(): array
    {
        return [
            'nl' => ['/nl', 'Accepteren', 'Weigeren', 'Voorkeuren', 'Cookievoorkeuren'],
            'en' => ['/en', 'Accept', 'Reject', 'Preferences', 'Cookie preferences'],
            'fr' => ['/fr', 'Accepter', 'Refuser', 'Préférences', 'Préférences des cookies'],
            'de' => ['/de', 'Akzeptieren', 'Ablehnen', 'Einstellungen', 'Cookie-Einstellungen'],
        ];
    }

    /** @dataProvider localeProvider */
    public function test_banner_is_localised_hidden_by_default_and_reopenable(string $path, string $accept, string $reject, string $prefs, string $reopen): void
    {
        $this->withTag();
        $response = $this->get($path);
        $html = $response->getContent();

        // Rendered hidden; JS reveals it only when no decision is stored.
        $this->assertMatchesRegularExpression('/<div id="cookie-consent"[^>]*\bhidden\b/s', $html);
        $response->assertSee('role="region"', false);
        $response->assertSee('aria-labelledby="cookie-consent-title"', false);
        $response->assertSee('data-consent-action="accept"', false);
        $response->assertSee('data-consent-action="reject"', false);
        $response->assertSee('data-consent-category="analytics"', false);
        $response->assertSee('data-consent-category="ads"', false);
        foreach ([$accept, $reject, $prefs, $reopen] as $label) {
            $this->assertMatchesRegularExpression('/>\s*' . preg_quote(e($label), '/') . '\s*</', $html, "Button label \"$label\" missing on $path");
        }
        // Footer link to reopen the preferences.
        $response->assertSee('data-consent-open', false);
        // No literal translation keys.
        $this->assertStringNotContainsString('site.consent.', strip_tags($html));
    }

    public function test_banner_does_not_touch_seo_head(): void
    {
        $this->withTag();
        $response = $this->get('/en/services');

        $response->assertSee('<meta name="robots" content="index, follow">', false);
        $response->assertSee('<link rel="canonical" href="http://localhost/en/services">', false);
        $response->assertSee('hreflang="x-default" href="http://localhost/nl/diensten"', false);
        $response->assertSee('"@type":"FAQPage"', false);
    }

    public static function privacyProvider(): array
    {
        return [
            'nl' => ['/nl/privacyverklaring', 'Cookies en tracking', 'Cookievoorkeuren'],
            'en' => ['/en/privacy', 'Cookies and tracking', 'Cookie preferences'],
            'fr' => ['/fr/politique-de-confidentialite', 'Cookies et suivi', 'Préférences des cookies'],
            'de' => ['/de/datenschutzerklaerung', 'Cookies und Tracking', 'Cookie-Einstellungen'],
        ];
    }

    /** @dataProvider privacyProvider */
    public function test_privacy_page_explains_consent_based_google_tracking(string $path, string $heading, string $reopen): void
    {
        $this->withTag();
        $response = $this->get($path);

        $response->assertStatus(200);
        $response->assertSee($heading);
        $response->assertSee('Google Analytics');
        $response->assertSee('Google Ads');
        $response->assertSee('vms_consent');
        $response->assertSee('Consent Mode');
        $response->assertSee('policies.google.com/privacy');
        $response->assertSee('data-consent-open', false);
        $response->assertSee($reopen);
        $response->assertDontSee('gebruikt geen tracking-cookies');
    }

    public function test_privacy_page_without_tag_states_only_essential_cookies(): void
    {
        config(['services.google.tag_id' => null]);
        $response = $this->get('/nl/privacyverklaring');

        $response->assertSee('Cookies en tracking');
        $response->assertDontSee('Google Analytics');
        $response->assertDontSee('data-consent-open', false);
    }

    public function test_confirmed_form_success_carries_a_conversion_hook_but_nothing_fires_server_side(): void
    {
        $this->withTag();

        // Plain contact page: no hook.
        $this->get('/nl/contact')->assertDontSee('data-track-event', false);

        // After a confirmed submission (flash from the controller): one generate_lead hook with its lead_type.
        $response = $this->withSession(['success' => true])->get('/nl/contact');
        $response->assertSee('data-track-event="generate_lead" data-track-lead-type="project_inquiry"', false);
        $this->assertSame(1, substr_count($response->getContent(), 'data-track-event='));
        // Still no server-rendered gtag('event' …): the event is only sent by consent.js.
        $response->assertDontSee("gtag('event'", false);

        $this->flushSession();
        $quick = $this->withSession(['quick_success' => true])->get('/nl/contact');
        $quick->assertSee('data-track-event="generate_lead" data-track-lead-type="quick_message"', false);
        $this->assertSame(1, substr_count($quick->getContent(), 'data-track-event='));

        // Failed submissions (validation errors / mail error) never carry the hook.
        $this->flushSession();
        $this->withSession(['mail_error' => true])->get('/nl/contact')->assertDontSee('data-track-event', false);

        // The JS module sends exactly this shape: generate_lead + lead_type.
        $js = file_get_contents(base_path('resources/js/consent.js'));
        $this->assertStringContainsString("params.lead_type = el.dataset.trackLeadType", $js);
        $this->assertStringNotContainsString('params.form', $js);
    }
}
