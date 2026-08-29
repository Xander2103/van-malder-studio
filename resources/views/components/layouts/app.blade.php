@php
    $locale = app()->getLocale() ?: 'nl';
    $isReady = config('studio.translations_ready.' . $locale, false);
    $robotsMeta = isset($noindex) && $noindex ? 'noindex, nofollow' : (!$isReady ? 'noindex' : 'index, follow');

    // Self-referencing canonical: explicit prop wins, otherwise use the actual request URL.
    // url()->current() respects APP_URL + current path, always gives the localized URL.
    $selfCanonical = $canonical ?? url()->current();

    // Compute hreflang alternate URLs from current route name
    $routeName = request()->route()?->getName() ?? '';
    $parts = explode('.', $routeName);
    // Strip locale prefix: 'nl.services' → 'services', 'services' → 'services'
    $baseName = count($parts) > 1 ? implode('.', array_slice($parts, 1)) : $parts[0] ?? 'home';
    // Landing pages exist in one language only: no hreflang cluster for them.
    $isLandingPage = $baseName === 'landing';
    // Normalise landing/store back to home so switcher doesn't break
    if (in_array($baseName, ['landing', 'inquiries.store', 'home', ''])) {
        $baseName = 'home';
    }

    $hrefLangs = [];
    foreach (['nl', 'fr', 'en', 'de'] as $lang) {
        $key = $lang . '.' . $baseName;
        $hrefLangs[$lang] = Route::has($key) ? route($key) : route($lang . '.home');
    }

    $pageTitle       = $title ?? config('studio.brand_name');
    $pageDescription = $description ?? null;
    $ogImage         = asset(config('studio.og_image', 'preview.png'));
    $schemaPageType  = $pageType ?? 'WebPage';
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Primary meta --}}
    <title>{{ $pageTitle }}</title>
    @if (!empty($pageDescription))
        <meta name="description" content="{{ $pageDescription }}">
    @endif
    <meta name="author" content="{{ config('studio.owner') }}">
    <meta name="robots" content="{{ $robotsMeta }}">
    <meta name="theme-color" content="#fafaf9">

    {{-- Canonical URL — self-referencing, always matches the actual localized page --}}
    <link rel="canonical" href="{{ $selfCanonical }}">

    {{-- hreflang — only for pages that exist in every locale and are ready to index --}}
    @if ($isReady && !$isLandingPage)
        <link rel="alternate" hreflang="nl" href="{{ $hrefLangs['nl'] }}">
        <link rel="alternate" hreflang="fr" href="{{ $hrefLangs['fr'] }}">
        <link rel="alternate" hreflang="en" href="{{ $hrefLangs['en'] }}">
        <link rel="alternate" hreflang="de" href="{{ $hrefLangs['de'] }}">
        <link rel="alternate" hreflang="x-default" href="{{ $hrefLangs['nl'] }}">
    @endif

    {{-- Open Graph --}}
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:title" content="{{ $ogTitle ?? $pageTitle }}">
    <meta property="og:description" content="{{ $ogDescription ?? ($pageDescription ?? config('studio.positioning')) }}">
    <meta property="og:url" content="{{ $selfCanonical }}">
    <meta property="og:site_name" content="{{ config('studio.brand_name') }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:alt" content="{{ config('studio.brand_name') }} — {{ config('studio.tagline') }}">
    <meta property="og:locale"
        content="{{ match ($locale) {'fr' => 'fr_BE','en' => 'en_GB','de' => 'de_BE',default => 'nl_BE'} }}">
    @foreach (['nl' => 'nl_BE', 'fr' => 'fr_BE', 'en' => 'en_GB', 'de' => 'de_BE'] as $altLang => $ogAlt)
        @if ($altLang !== $locale)
    <meta property="og:locale:alternate" content="{{ $ogAlt }}">
        @endif
    @endforeach

    {{-- Twitter card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle ?? $pageTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription ?? ($pageDescription ?? config('studio.positioning')) }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    {{-- Favicons --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon-64x64.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon-192x192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Structured data — shared entity graph (business, person, website, page, breadcrumb) --}}
    <x-structured-data
        :title="$pageTitle"
        :description="$pageDescription"
        :canonical="$selfCanonical"
        :pageType="$schemaPageType"
        :baseName="$baseName"
    />
</head>

<body class="bg-stone-50 text-slate-800 antialiased">
    <x-navigation />
    <main>
        {{ $slot }}
    </main>
    <x-footer />
</body>

</html>
