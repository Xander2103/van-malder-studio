<?php

return [
    'brand_name'   => 'Van Malder Studio',
    'tagline'      => 'Websites by Xander Van Malder',
    'owner'        => 'Xander Van Malder',
    'role'         => 'Full stack & .NET developer',
    'email'        => 'info@vanmalderstudio.be',
    'location'     => 'Druivenstreek (Tervuren) / Vlaams-Brabant',
    'positioning'  => 'Moderne websites en digitale oplossingen voor zelfstandigen en lokale bedrijven.',

    // Canonical public origin used in structured data. Falls back to APP_URL.
    'url'          => env('STUDIO_URL', env('APP_URL', 'https://vanmalderstudio.be')),

    // Factual location data for structured data (no street address is published).
    'city'         => 'Tervuren',
    'region'       => 'Vlaams-Brabant',
    'country'      => 'BE',

    // Places the studio actually serves — used for schema.org areaServed.
    'area_served'  => ['Tervuren', 'Duisburg', 'Overijse', 'Hoeilaart', 'Huldenberg', 'Bertem', 'Leuven', 'Vlaams-Brabant', 'Brussel', 'België'],

    // Real public profile URLs only. Empty = omitted from schema.org sameAs.
    'same_as'      => [],

    // Social preview image (1200×630 recommended). Existing asset in /public.
    'og_image'     => 'preview.png',

    // Locales where content is fully translated and ready to index.
    // Set de => true once German copy has been reviewed by a native speaker.
    'translations_ready' => [
        'nl' => true,
        'fr' => true,
        'en' => true,
        'de' => true,
    ],
];
