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
        'process'  => 'arbeitsweise',
        'showcase' => 'showcase',
        'privacy'  => 'datenschutzerklaerung',
    ],

];
