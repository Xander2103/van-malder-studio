<?php

/**
 * Locale-specific URL path segments.
 * Maps abstract route names to the slug used in each language's URLs.
 *
 * Example: route 'services' → /nl/diensten, /fr/services, /en/services
 */
return [

    'nl' => [
        'home'     => '/',
        'services' => 'diensten',
        'contact'  => 'contact',
        'pricing'  => 'prijzen',
        'about'    => 'over-mij',
        'clientwork' => 'klantprojecten',
        'process'  => 'werkwijze',
        'showcase' => 'showcase',
        'privacy'  => 'privacyverklaring',
    ],

    'fr' => [
        'home'     => '/',
        'services' => 'services',
        'contact'  => 'contact',
        'pricing'  => 'tarifs',
        'about'    => 'a-propos',
        'clientwork' => 'projets-clients',
        'process'  => 'methode',
        'showcase' => 'showcase',
        'privacy'  => 'politique-de-confidentialite',
    ],

    'en' => [
        'home'     => '/',
        'services' => 'services',
        'contact'  => 'contact',
        'pricing'  => 'pricing',
        'about'    => 'about',
        'clientwork' => 'client-projects',
        'process'  => 'process',
        'showcase' => 'showcase',
        'privacy'  => 'privacy',
    ],

    'de' => [
        'home'     => '/',
        'services' => 'dienstleistungen',
        'contact'  => 'kontakt',
        'pricing'  => 'preise',
        'about'    => 'ueber-mich',
        'clientwork' => 'kundenprojekte',
        'process'  => 'arbeitsweise',
        'showcase' => 'showcase',
        'privacy'  => 'datenschutzerklaerung',
    ],

];
