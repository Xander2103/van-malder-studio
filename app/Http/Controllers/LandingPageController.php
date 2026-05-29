<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function show(Request $request, string $locale, string $slug)
    {
        $pages = collect(config('landing-pages', []));

        $page = $pages->first(
            fn($p) => $p['slug'] === $slug && $p['locale'] === $locale
        );

        if (!$page) {
            abort(404);
        }

        // Collect related pages data for the template
        $relatedPages = collect($page['related'] ?? [])
            ->map(fn($s) => $pages->first(fn($p) => $p['slug'] === $s && $p['locale'] === $locale))
            ->filter()
            ->values();

        return view('pages.landing-page', [
            'page'         => $page,
            'relatedPages' => $relatedPages,
            'canonical'    => url("/$locale/$slug"),
            'noindex'      => $page['noindex'] ?? false,
        ]);
    }
}
