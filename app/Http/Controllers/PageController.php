<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'projects'   => config('projects'),
            'clientWork' => config('client-work'),
        ]);
    }

    public function services()
    {
        $items = __('site.services.items');
        $services = collect($items)
            ->map(fn ($item, $slug) => array_merge($item, ['slug' => $slug]))
            ->values()
            ->all();

        return view('pages.services', ['services' => $services]);
    }

    public function process()
    {
        return view('pages.process');
    }

    public function pricing()
    {
        return view('pages.pricing');
    }

    public function about()
    {
        return view('pages.about', [
            'projects'   => config('projects'),
            'clientWork' => config('client-work'),
        ]);
    }

    public function clientWork()
    {
        return view('pages.client-work', [
            'clientWork' => config('client-work'),
        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function showcase()
    {
        return view('pages.showcase', [
            'projects' => config('projects'),
        ]);
    }

    public function studioIntro()
    {
        return view('pages.studio-intro');
    }

    public function sitemap()
    {
        $ready = config('studio.translations_ready', []);

        $pages = ['home', 'services', 'process', 'pricing', 'about', 'clientwork', 'contact', 'showcase', 'privacy'];
        $priorities = [
            'home'     => ['priority' => '1.0', 'freq' => 'weekly'],
            'services' => ['priority' => '0.9', 'freq' => 'monthly'],
            'pricing'  => ['priority' => '0.8', 'freq' => 'monthly'],
            'contact'  => ['priority' => '0.9', 'freq' => 'monthly'],
            'showcase' => ['priority' => '0.8', 'freq' => 'monthly'],
            'about'    => ['priority' => '0.7', 'freq' => 'monthly'],
            'clientwork' => ['priority' => '0.8', 'freq' => 'monthly'],
            'process'  => ['priority' => '0.7', 'freq' => 'monthly'],
            'privacy'  => ['priority' => '0.3', 'freq' => 'yearly'],
        ];

        $routes = [];

        foreach (['nl', 'fr', 'en', 'de'] as $locale) {
            if (empty($ready[$locale])) {
                continue;
            }

            foreach ($pages as $page) {
                $routeName = $locale . '.' . $page;
                if (!Route::has($routeName)) {
                    continue;
                }

                // Build hreflang alternates for all ready locales
                $alternates = [];
                foreach (['nl', 'fr', 'en', 'de'] as $altLocale) {
                    $altRoute = $altLocale . '.' . $page;
                    if (Route::has($altRoute) && !empty($ready[$altLocale])) {
                        $alternates[$altLocale] = route($altRoute);
                    }
                }
                $xDefault = Route::has('nl.' . $page) ? route('nl.' . $page) : route($routeName);
                $alternates['x-default'] = $xDefault;

                $routes[] = [
                    'url'        => route($routeName),
                    'priority'   => $priorities[$page]['priority'],
                    'freq'       => $priorities[$page]['freq'],
                    'alternates' => $alternates,
                ];
            }
        }

        // Dutch landing pages (noindex pages excluded)
        $landingPages = collect(config('landing-pages', []))
            ->filter(fn($p) => $p['locale'] === 'nl' && empty($p['noindex']));

        foreach ($landingPages as $lp) {
            $routes[] = [
                'url'      => url('/nl/' . $lp['slug']),
                'priority' => $lp['sitemap_priority'] ?? '0.8',
                'freq'     => 'monthly',
            ];
        }

        return response()
            ->view('sitemap', ['routes' => $routes])
            ->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        // Public marketing site: everything is crawlable except framework internals.
        // AI search crawlers (OpenAI's OAI-SearchBot, Perplexity, Anthropic) are
        // explicitly allowed so the studio can be cited in generative answers.
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /storage/',
            'Disallow: /up',
            'Disallow: /bericht',
            'Disallow: /*/bericht',
            '',
            'User-agent: OAI-SearchBot',
            'Allow: /',
            '',
            'User-agent: PerplexityBot',
            'Allow: /',
            '',
            'User-agent: ClaudeBot',
            'Allow: /',
            '',
            'Sitemap: ' . route('sitemap'),
        ];

        return response(implode("\n", $lines) . "\n", 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
