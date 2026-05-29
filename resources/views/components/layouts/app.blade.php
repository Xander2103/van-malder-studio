@php
    $locale      = app()->getLocale() ?: 'nl';
    $isReady     = config('studio.translations_ready.' . $locale, false);
    $robotsMeta  = (isset($noindex) && $noindex) ? 'noindex, nofollow'
                 : (!$isReady ? 'noindex' : 'index, follow');

    // Compute hreflang alternate URLs from current route name
    $routeName  = request()->route()?->getName() ?? '';
    $parts      = explode('.', $routeName);
    // Strip locale prefix: 'nl.services' → 'services', 'services' → 'services'
    $baseName   = count($parts) > 1 ? implode('.', array_slice($parts, 1)) : ($parts[0] ?? 'home');
    // Normalise landing/store back to home so switcher doesn't break
    if (in_array($baseName, ['landing', 'inquiries.store', 'home', ''])) $baseName = 'home';

    $hrefLangs = [];
    foreach (['nl', 'fr', 'en', 'de'] as $lang) {
        $key = $lang . '.' . $baseName;
        $hrefLangs[$lang] = Route::has($key) ? route($key) : route($lang . '.home');
    }
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Primary meta --}}
    <title>{{ $title ?? config('studio.brand_name') }}</title>
    @if(!empty($description))
    <meta name="description" content="{{ $description }}">
    @endif
    <meta name="author" content="{{ config('studio.owner') }}">
    <meta name="robots" content="{{ $robotsMeta }}">

    {{-- Canonical URL --}}
    @if(!empty($canonical))
    <link rel="canonical" href="{{ $canonical }}">
    @else
    <link rel="canonical" href="{{ rtrim(config('app.url'), '/') . request()->getPathInfo() }}">
    @endif

    {{-- hreflang — only output when current locale translation is ready --}}
    @if($isReady)
    <link rel="alternate" hreflang="nl"        href="{{ $hrefLangs['nl'] }}">
    <link rel="alternate" hreflang="fr"        href="{{ $hrefLangs['fr'] }}">
    <link rel="alternate" hreflang="en"        href="{{ $hrefLangs['en'] }}">
    <link rel="alternate" hreflang="de"        href="{{ $hrefLangs['de'] }}">
    <link rel="alternate" hreflang="x-default" href="{{ $hrefLangs['nl'] }}">
    @endif

    {{-- Open Graph --}}
    <meta property="og:type"        content="{{ $ogType ?? 'website' }}">
    <meta property="og:title"       content="{{ $ogTitle ?? ($title ?? config('studio.brand_name')) }}">
    <meta property="og:description" content="{{ $ogDescription ?? ($description ?? config('studio.positioning')) }}">
    <meta property="og:url"         content="{{ $canonical ?? rtrim(config('app.url'), '/') . request()->getPathInfo() }}">
    <meta property="og:site_name"   content="{{ config('studio.brand_name') }}">
    <meta property="og:locale"      content="{{ match($locale) { 'fr' => 'fr_BE', 'en' => 'en_GB', 'de' => 'de_BE', default => 'nl_BE' } }}">

    {{-- Twitter card --}}
    <meta name="twitter:card"        content="summary">
    <meta name="twitter:title"       content="{{ $ogTitle ?? ($title ?? config('studio.brand_name')) }}">
    <meta name="twitter:description" content="{{ $ogDescription ?? ($description ?? config('studio.positioning')) }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-slate-800 antialiased">
    <x-navigation />
    <main>
        {{ $slot }}
    </main>
    <x-footer />
</body>
</html>
