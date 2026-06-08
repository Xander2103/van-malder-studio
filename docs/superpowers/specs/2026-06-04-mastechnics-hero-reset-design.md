# Mastechnics Hero Reset — Design Spec
Date: 2026-06-04

## Goal

Remove all accumulated experimental layers from the homepage hero (background image, service chip panel, env effects, parallax JS) and replace with a clean, professional single-column base hero: headline, intro, two CTAs, light grey background.

## Files Changed (3)

- `resources/views/pages/partials/home-page.blade.php`
- `resources/css/pages/home.css`
- `resources/js/app.js`

## What Is Removed

| Removed | Location |
|---|---|
| `<div class="hero-env">` + all 6 child divs | Blade |
| `<aside class="hero-services-visual">` + chips loop | Blade |
| `$serviceIcons` PHP array | Blade |
| `hero_services_label` labels (3 locales) | Blade |
| `panel_label/title/points` labels (3 locales, dead code) | Blade |
| `.home-hero-grid` wrapper div | Blade |
| `$translation->title` in hero (replaced by `$text['hero_headline']`) | Blade |
| `$translation->intro` conditional (replaced by direct `$text['hero_intro']`) | Blade |
| Hero background image rule | CSS |
| `.home-hero::after { display:none }` dead stub | CSS |
| `.hero-services-visual*` (3 rules) | CSS |
| All `.service-chip*` rules (~10 rules, ~80 lines) | CSS |
| Entire env effects section (~265 lines: grid, glow, lines, air, water, heat, keyframes, 3 media blocks) | CSS |
| Tablet `.home-hero-grid` override | CSS |
| Mobile `.home-hero { background: ... }` image rule | CSS |
| Mobile `.hero-services-*` and `.service-chip*` sub-rules | CSS |
| `@media prefers-reduced-motion .hero-env` | CSS |
| `initHeroParallax()` function + DOMContentLoaded call | JS |

## What Is Kept

- All sections below hero (`#diensten`, why, process, CTA) — untouched
- `.eyebrow`, `.eyebrow-dark` (used in multiple sections)
- `.home-hero h1`, `.hero-intro`, `.home-hero-content`
- Mobile font-size rules for h1 and hero-intro
- `button-row` responsive rules
- `initMobileMenu()` and `initPipeFlowAnimation()` in app.js
- All service card CSS (`.service-card*`)

## New Hero Structure

### Blade
```blade
<section class="home-hero">
    <div class="container">
        <div class="home-hero-content">
            <span class="eyebrow">{{ $text['hero_badge'] }}</span>
            <h1>{{ $text['hero_headline'] }}</h1>
            <p class="hero-intro">{{ $text['hero_intro'] }}</p>
            <div class="button-row">
                <a class="button button-primary button-large" href="{{ route('pages.show', ['locale' => $locale, 'slug' => $requestSlug]) }}">
                    {{ $text['primary_cta'] }}
                </a>
                <a class="button button-secondary" href="#diensten">
                    {{ $text['secondary_cta'] }}
                </a>
            </div>
        </div>
    </div>
</section>
```

### CSS
```css
.home-hero {
    position: relative;
    padding: 80px 0 88px;
    background: var(--color-background);
    border-bottom: 1px solid var(--color-border);
}

.home-hero-content {
    max-width: 720px;
}
```

## New Content Labels

| Key | NL | FR | EN |
|---|---|---|---|
| `hero_headline` | Technische oplossingen die comfort creëren. | Des solutions techniques qui créent le confort. | Technical solutions that create comfort. |
| `hero_intro` | Uw partner voor sanitair, verwarming, airco, ventilatie, waterverzachters en koelcellen. Duurzame technologie, perfecte afwerking en service op maat. | Votre partenaire pour la plomberie, le chauffage, la climatisation, la ventilation, les adoucisseurs d'eau et les chambres froides. Technologie durable, finition parfaite et service sur mesure. | Your partner for plumbing, heating, air conditioning, ventilation, water softeners and cold rooms. Durable technology, perfect finish and tailored service. |
| `primary_cta` | Start aanvraag | Lancer une demande | Start request |
| `secondary_cta` | Bekijk diensten | Voir nos services | View our services |

## Constraints
- No new animations, no background image, no right-side panel
- Smart Request Flow, admin, DB, routes untouched
- nl/fr/en all working via updated $labels array
- Header logo unchanged
