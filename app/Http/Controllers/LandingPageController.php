<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function show(Request $request, string $slug)
    {
        // Locale is set by the setlocale middleware on the route group — no need to inject it.
        $locale = app()->getLocale() ?: 'nl';

        $pages = collect(config('landing-pages', []));

        $page = $pages->first(
            fn($p) => $p['slug'] === $slug && $p['locale'] === $locale
        );

        if (!$page) {
            abort(404);
        }

        // Consolidated pages: one URL per search intent. Retired slugs 301 to the
        // primary page so existing rankings and links carry over.
        if (!empty($page['redirect_to'])) {
            return redirect()->to(url("/$locale/" . $page['redirect_to']), 301);
        }

        // Collect related pages data for the template (never link to a retired slug)
        $relatedPages = collect($page['related'] ?? [])
            ->map(fn($s) => $pages->first(fn($p) => $p['slug'] === $s && $p['locale'] === $locale && empty($p['redirect_to'])))
            ->filter()
            ->values();

        // Client proof: real projects from config/client-work, copy from the lang file
        $proofClients = collect($page['proof']['clients'] ?? [])
            ->map(function (string $note, string $clientSlug) {
                $work = collect(config('client-work', []))->firstWhere('slug', $clientSlug);

                return $work ? array_merge($work, ['note' => $note]) : null;
            })
            ->filter()
            ->values();

        return view('pages.landing-page', [
            'page'         => $page,
            'relatedPages' => $relatedPages,
            'proofClients' => $proofClients,
            'canonical'    => url("/$locale/$slug"),
            'noindex'      => $page['noindex'] ?? false,
        ]);
    }
}
