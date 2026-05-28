<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'services' => array_slice(config('services.studio'), 0, 4),
            'projects' => config('projects'),
        ]);
    }

    public function services()
    {
        return view('pages.services', [
            'services' => config('services.studio'),
        ]);
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
            'projects' => config('projects'),
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

    public function sitemap()
    {
        $routes = [
            ['url' => route('home'),           'priority' => '1.0',  'freq' => 'weekly'],
            ['url' => route('services'),        'priority' => '0.9',  'freq' => 'monthly'],
            ['url' => route('projects.index'),  'priority' => '0.8',  'freq' => 'monthly'],
            ['url' => route('process'),         'priority' => '0.7',  'freq' => 'monthly'],
            ['url' => route('pricing'),         'priority' => '0.8',  'freq' => 'monthly'],
            ['url' => route('about'),           'priority' => '0.7',  'freq' => 'monthly'],
            ['url' => route('contact'),         'priority' => '0.9',  'freq' => 'monthly'],
            ['url' => route('privacy'),         'priority' => '0.3',  'freq' => 'yearly'],
        ];

        return response()
            ->view('sitemap', ['routes' => $routes])
            ->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /storage/\nSitemap: " . route('sitemap') . "\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
