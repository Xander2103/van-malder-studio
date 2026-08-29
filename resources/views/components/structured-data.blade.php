@props([
    'title'       => null,
    'description' => null,
    'canonical'   => null,
    'pageType'    => 'WebPage',
    'baseName'    => 'home',
])

@php
    /**
     * Site-wide JSON-LD entity graph.
     *
     * Emits ONE @graph with stable @ids so every page reinforces the same entities:
     *   #business  → ProfessionalService (Van Malder Studio)
     *   #person    → Person (Xander Van Malder), founder of #business
     *   #website   → WebSite
     *   <page>     → WebPage / AboutPage / ContactPage for the current URL
     *   #breadcrumb→ BreadcrumbList (non-home pages)
     *
     * Only factual data from config/studio.php and the lang files is used.
     * No street address, phone number, ratings or reviews are published.
     */
    $locale   = app()->getLocale() ?: 'nl';
    $base     = rtrim(config('studio.url'), '/');
    $homeUrl  = \Illuminate\Support\Facades\Route::has($locale . '.home') ? route($locale . '.home') : $base;
    $aboutUrl = \Illuminate\Support\Facades\Route::has($locale . '.about') ? route($locale . '.about') : $homeUrl;
    $contactUrl = \Illuminate\Support\Facades\Route::has($locale . '.contact') ? route($locale . '.contact') : $homeUrl;
    $servicesUrl = \Illuminate\Support\Facades\Route::has($locale . '.services') ? route($locale . '.services') : $homeUrl;

    $businessId  = $base . '/#business';
    $personId    = $base . '/#person';
    $websiteId   = $base . '/#website';
    $breadcrumbId = ($canonical ?? $homeUrl) . '#breadcrumb';

    $inLanguage = match ($locale) {
        'fr'    => 'fr-BE',
        'en'    => 'en',
        'de'    => 'de',
        default => 'nl-BE',
    };

    $areaServed = array_map(
        fn ($place) => ['@type' => 'Place', 'name' => $place],
        config('studio.area_served', [])
    );

    $serviceItems = __('site.services.items');
    $offerCatalog = [];
    if (is_array($serviceItems)) {
        foreach ($serviceItems as $slug => $item) {
            $offerCatalog[] = [
                '@type'         => 'Offer',
                'itemOffered'   => [
                    '@type'       => 'Service',
                    'name'        => $item['title'] ?? $slug,
                    'description' => $item['short'] ?? null,
                    'url'         => $servicesUrl . '#' . $slug,
                    'provider'    => ['@id' => $businessId],
                    'areaServed'  => $areaServed,
                ],
            ];
        }
    }

    $sameAs = array_values(array_filter(config('studio.same_as', [])));

    $business = [
        '@type'       => ['ProfessionalService', 'Organization'],
        '@id'         => $businessId,
        'name'        => config('studio.brand_name'),
        'url'         => $base . '/',
        'email'       => config('studio.email'),
        'description' => __('site.seo.home_desc'),
        'image'       => asset(config('studio.og_image')),
        'logo'        => asset('favicon-512x512.png'),
        'founder'     => ['@id' => $personId],
        'employee'    => ['@id' => $personId],
        'address'     => [
            '@type'           => 'PostalAddress',
            'addressLocality' => config('studio.city'),
            'addressRegion'   => config('studio.region'),
            'addressCountry'  => config('studio.country'),
        ],
        'areaServed'  => $areaServed,
        'knowsAbout'  => ['Web design', 'Web development', 'Web applications', 'Custom software development', 'Laravel', 'PHP', 'C#', '.NET', 'ASP.NET Core', 'React', 'TypeScript', 'Local SEO'],
        'hasOfferCatalog' => [
            '@type'           => 'OfferCatalog',
            'name'            => __('site.services.heading'),
            'itemListElement' => $offerCatalog,
        ],
        'contactPoint' => [
            '@type'             => 'ContactPoint',
            'contactType'       => 'sales',
            'email'             => config('studio.email'),
            'url'               => $contactUrl,
            'availableLanguage' => ['nl', 'fr', 'en', 'de'],
        ],
    ];
    if ($sameAs) {
        $business['sameAs'] = $sameAs;
    }

    $person = [
        '@type'       => 'Person',
        '@id'         => $personId,
        'name'        => config('studio.owner'),
        'jobTitle'    => config('studio.role'),
        'url'         => $aboutUrl,
        'image'       => asset('images/Xander.webp'),
        'email'       => config('studio.email'),
        'worksFor'    => ['@id' => $businessId],
        'homeLocation' => [
            '@type'   => 'Place',
            'address' => [
                '@type'           => 'PostalAddress',
                'addressLocality' => config('studio.city'),
                'addressRegion'   => config('studio.region'),
                'addressCountry'  => config('studio.country'),
            ],
        ],
        'knowsAbout'  => ['Laravel', 'PHP', 'C#', '.NET', 'ASP.NET Core', 'Entity Framework Core', 'SQL Server', 'Microsoft Azure', 'JavaScript', 'TypeScript', 'React', 'React Native', 'Tailwind CSS', 'Web development', 'Custom software development'],
    ];
    if ($sameAs) {
        $person['sameAs'] = $sameAs;
    }

    $website = [
        '@type'      => 'WebSite',
        '@id'        => $websiteId,
        'url'        => $base . '/',
        'name'       => config('studio.brand_name'),
        'publisher'  => ['@id' => $businessId],
        'inLanguage' => ['nl-BE', 'fr-BE', 'en', 'de'],
    ];

    $webPage = [
        '@type'       => $pageType,
        '@id'         => $canonical,
        'url'         => $canonical,
        'name'        => $title,
        'description' => $description,
        'inLanguage'  => $inLanguage,
        'isPartOf'    => ['@id' => $websiteId],
        'about'       => ['@id' => $businessId],
    ];
    if ($pageType === 'AboutPage') {
        $webPage['mainEntity'] = ['@id' => $personId];
    }

    $graph = [$business, $person, $website];

    if ($baseName !== 'home' && $canonical) {
        $webPage['breadcrumb'] = ['@id' => $breadcrumbId];
        $graph[] = [
            '@type'           => 'BreadcrumbList',
            '@id'             => $breadcrumbId,
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => config('studio.brand_name'), 'item' => $homeUrl],
                ['@type' => 'ListItem', 'position' => 2, 'name' => $title, 'item' => $canonical],
            ],
        ];
    }

    $graph[] = $webPage;

    $jsonLd = [
        '@context' => 'https://schema.org',
        '@graph'   => $graph,
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
