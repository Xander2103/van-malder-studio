<?php

/**
 * Client work — real websites designed and developed through Van Malder Studio.
 *
 * Language-independent data lives here; all visible copy (sector label,
 * description, highlights) lives in lang/{locale}/site.php under
 * 'client_work.items.{slug}'.
 *
 * Schema per entry:
 *   slug          string      — stable key, also used for lang lookup and DOM ids
 *   title         string      — client / project name (not translated)
 *   url           string      — live website (external, opened in a new tab)
 *   domain        string      — shown in the card's browser frame
 *   sector        string      — schema.org-friendly sector hint (English, for JSON-LD)
 *   service_slug  string      — related service section on the services page
 *   technologies  string[]    — badge list
 *   image         string|null — path relative to /public (e.g. images/mastechnics.webp).
 *                               Leave null until a real screenshot exists; the card
 *                               then renders a CSS browser frame instead.
 *   accent        string      — CSS art variant for the card header (no screenshot)
 */
return [

    [
        'slug'         => 'mastechnics',
        'title'        => 'Mastechnics',
        'url'          => 'https://mastechnics.be',
        'domain'       => 'mastechnics.be',
        'sector'       => 'HVAC and plumbing (heating, air conditioning, ventilation, sanitary installations)',
        'service_slug' => 'nieuwe-website',
        'technologies' => ['Laravel', 'Tailwind CSS', 'JavaScript', 'Admin dashboard', 'SEO'],
        'image'        => 'images/mastechnics.webp',
        'accent'       => 'heat',
    ],

    [
        'slug'         => 'dr-sue-liza-eta',
        'title'        => 'Dr. Sue-Liza Eta',
        'url'          => 'https://drsuelizaeta.be',
        'domain'       => 'drsuelizaeta.be',
        'sector'       => 'Medical practice (vascular surgery, aesthetic medicine)',
        'service_slug' => 'nieuwe-website',
        'technologies' => ['Laravel', 'Tailwind CSS', 'Responsive Design', 'SEO'],
        'image'        => 'images/sue-liza-eta.webp',
        'accent'       => 'medical',
    ],

    [
        'slug'         => 'schrijnwerkerij-van-kerkhoven',
        'title'        => 'Schrijnwerkerij Van Kerkhoven',
        'url'          => 'https://schrijnwerkerijvankerkhoven.be',
        'domain'       => 'schrijnwerkerijvankerkhoven.be',
        'sector'       => 'Custom woodworking',
        'service_slug' => 'seo-landingspaginas',
        'technologies' => ['Laravel', 'Tailwind CSS', 'Local SEO', 'Responsive Design'],
        'image'        => 'images/van-kerkhoven.webp',
        'accent'       => 'wood',
    ],

];
