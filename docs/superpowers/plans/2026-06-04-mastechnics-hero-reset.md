# Mastechnics Hero Reset — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Remove all experimental hero layers (background image, env effects, service chip panel, parallax JS) and replace with a clean single-column base hero: light grey background, headline, intro, two CTAs.

**Architecture:** Three files change. Blade template: remove env/chip markup, simplify hero HTML, add new hero content labels. CSS: strip ~350 lines of hero-only rules, replace with 10-line clean base. JS: remove `initHeroParallax()` only; `initMobileMenu` and `initPipeFlowAnimation` are untouched.

**Tech Stack:** Laravel 12 Blade, custom CSS, Vite build, PHPUnit tests.

---

## File Map

| File | What changes |
|---|---|
| `resources/views/pages/partials/home-page.blade.php` | Update labels; simplify hero HTML |
| `resources/css/pages/home.css` | New clean hero CSS; remove chip/env/image sections |
| `resources/js/app.js` | Remove `initHeroParallax()` |

---

### Task 1: Add hero headline/intro labels and update CTAs in Blade

**Files:**
- Modify: `resources/views/pages/partials/home-page.blade.php` (lines 22–97, NL locale)

The NL locale currently has `hero_services_label`, `panel_label`, `panel_title`, `panel_points` keys (last three never rendered — dead code), and `primary_cta`/`secondary_cta` with old text. Update the NL block to remove dead keys, add `hero_headline` + `hero_intro`, and update the CTAs.

- [ ] **Step 1: Replace the NL `$labels` block**

Find this exact opening in the NL block:
```php
        'nl' => [
            'primary_cta'    => 'Vraag een offerte aan',
            'secondary_cta'  => 'Bekijk onze diensten',
            'hero_badge'     => 'Technische service — particulieren & bedrijven',
            'hero_services_label' => 'Onze diensten',

            'panel_label'  => 'Slimme intake',
            'panel_title'  => 'Beschrijf uw situatie eenmalig duidelijk.',
            'panel_points' => [
                'Kies de juiste dienst: verwarming, airco, sanitair…',
                'Vul technische gegevens in over uw installatie of probleem',
                'Voeg desgewenst foto\'s toe voor snellere inschatting',
                'Ontvang sneller een richtprijs of concreet voorstel',
            ],

            'services_label' => 'Diensten',
```

Replace that entire block (from `'primary_cta'` through the end of `panel_points` closing bracket) with:

```php
        'nl' => [
            'primary_cta'    => 'Start aanvraag',
            'secondary_cta'  => 'Bekijk diensten',
            'hero_badge'     => 'Technische service — particulieren & bedrijven',
            'hero_headline'  => 'Technische oplossingen die comfort creëren.',
            'hero_intro'     => 'Uw partner voor sanitair, verwarming, airco, ventilatie, waterverzachters en koelcellen. Duurzame technologie, perfecte afwerking en service op maat.',

            'services_label' => 'Diensten',
```

- [ ] **Step 2: Replace the FR `$labels` block**

Find:
```php
        'fr' => [
            'primary_cta'    => 'Demander un devis',
            'secondary_cta'  => 'Voir nos services',
            'hero_badge'     => 'Service technique — particuliers et entreprises',
            'hero_services_label' => 'Nos services',

            'panel_label'  => 'Prise en charge intelligente',
            'panel_title'  => 'Décrivez votre situation une seule fois, clairement.',
            'panel_points' => [
                'Choisissez le bon service : chauffage, climatisation, plomberie…',
                'Ajoutez les données techniques de votre installation ou problème',
                'Joignez des photos pour une estimation plus rapide',
                'Recevez plus vite une estimation ou une proposition concrète',
            ],

            'services_label' => 'Services',
```

Replace with:
```php
        'fr' => [
            'primary_cta'    => 'Lancer une demande',
            'secondary_cta'  => 'Voir nos services',
            'hero_badge'     => 'Service technique — particuliers et entreprises',
            'hero_headline'  => 'Des solutions techniques qui créent le confort.',
            'hero_intro'     => 'Votre partenaire pour la plomberie, le chauffage, la climatisation, la ventilation, les adoucisseurs d\'eau et les chambres froides. Technologie durable, finition parfaite et service sur mesure.',

            'services_label' => 'Services',
```

- [ ] **Step 3: Replace the EN `$labels` block**

Find:
```php
        'en' => [
            'primary_cta'    => 'Request a quote',
            'secondary_cta'  => 'View our services',
            'hero_badge'     => 'Technical service — homes and businesses',
            'hero_services_label' => 'Our services',

            'panel_label'  => 'Smart intake',
            'panel_title'  => 'Describe your situation once, clearly.',
            'panel_points' => [
                'Choose the right service: heating, air conditioning, plumbing…',
                'Add technical details about your installation or issue',
                'Attach photos for a faster assessment',
                'Receive a faster estimate or concrete proposal',
            ],

            'services_label' => 'Services',
```

Replace with:
```php
        'en' => [
            'primary_cta'    => 'Start request',
            'secondary_cta'  => 'View our services',
            'hero_badge'     => 'Technical service — homes and businesses',
            'hero_headline'  => 'Technical solutions that create comfort.',
            'hero_intro'     => 'Your partner for plumbing, heating, air conditioning, ventilation, water softeners and cold rooms. Durable technology, perfect finish and tailored service.',

            'services_label' => 'Services',
```

---

### Task 2: Remove $serviceIcons array from Blade

**Files:**
- Modify: `resources/views/pages/partials/home-page.blade.php` (lines 13–20)

`$serviceIcons` is only used by the chip panel inside the hero. With the panel removed, it is dead code.

- [ ] **Step 1: Remove the `$serviceIcons` array**

Find and remove the entire block:
```php
    $serviceIcons = [
        'heating' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>',
        'airco' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2"/><path d="M9.6 4.6A2 2 0 1 1 11 8H2"/><path d="M12.6 19.4A2 2 0 1 0 14 16H2"/></svg>',
        'plumbing' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>',
        'ventilation' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 2v6h-6"/><path d="M21 13a9 9 0 1 1-3-7.7L21 8"/></svg>',
        'water-softeners' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 6.75 7 5.3c-.29 1.45-1.14 2.84-2.29 3.76S3 11.1 3 12.25c0 2.22 1.8 4.05 4 4.05z"/><path d="M12.56 6.6A10.97 10.97 0 0 0 14 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 0 1-11.91 4.97"/></svg>',
        'cold-rooms' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="2" x2="12" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><path d="m20 16-4-4 4-4"/><path d="m4 8 4 4-4 4"/><path d="m16 4-4 4-4-4"/><path d="m8 20 4-4 4 4"/></svg>',
    ];
```

Leave a blank line where it was. The `$services` collection above it is kept (used by service cards below the hero).

---

### Task 3: Rewrite hero HTML in Blade

**Files:**
- Modify: `resources/views/pages/partials/home-page.blade.php` (lines 253–316)

- [ ] **Step 1: Replace the entire hero section**

Find the entire current hero section from `<section class="home-hero">` through its closing `</section>`:

```blade
<section class="home-hero">
    <div class="hero-env" aria-hidden="true">
        <div class="hero-env-grid"></div>
        <div class="hero-env-glow"  data-parallax="0.4"></div>
        <div class="hero-env-lines" data-parallax="0.25"></div>
        <div class="hero-env-air" data-parallax="0.6">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="hero-env-water" data-parallax="0.3"></div>
        <div class="hero-env-heat"  data-parallax="0.5"></div>
    </div>
    <div class="container">
        <div class="home-hero-grid">
            <div class="home-hero-content">
                <span class="eyebrow">{{ $text['hero_badge'] }}</span>

                <h1>{{ $translation->title }}</h1>

                @if ($translation->intro)
                    <p class="hero-intro">{{ $translation->intro }}</p>
                @endif

                <div class="button-row">
                    <a
                        class="button button-primary button-large"
                        href="{{ route('pages.show', [
                            'locale' => $locale,
                            'slug' => $requestSlug,
                        ]) }}"
                    >
                        {{ $text['primary_cta'] }}
                    </a>

                    <a class="button button-secondary" href="#diensten">
                        {{ $text['secondary_cta'] }}
                    </a>
                </div>
            </div>

            <aside class="hero-services-visual">
                <p class="hero-services-visual-label">{{ $text['hero_services_label'] }}</p>

                <div class="hero-services-grid">
                    @foreach ($services as $service)
                        <a
                            class="service-chip {{ $service['key'] === 'heating' ? 'service-chip--heat' : '' }} {{ in_array($service['key'], ['airco', 'cold-rooms']) ? 'service-chip--cool' : '' }}"
                            href="{{ route('pages.show', [
                                'locale' => $locale,
                                'slug' => $service['slug'],
                            ]) }}"
                        >
                            <span class="service-chip-icon">
                                {!! $serviceIcons[$service['key']] ?? '' !!}
                            </span>
                            <span class="service-chip-name">{{ $service['title'] }}</span>
                        </a>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>
</section>
```

Replace with:

```blade
<section class="home-hero">
    <div class="container">
        <div class="home-hero-content">
            <span class="eyebrow">{{ $text['hero_badge'] }}</span>

            <h1>{{ $text['hero_headline'] }}</h1>

            <p class="hero-intro">{{ $text['hero_intro'] }}</p>

            <div class="button-row">
                <a
                    class="button button-primary button-large"
                    href="{{ route('pages.show', [
                        'locale' => $locale,
                        'slug' => $requestSlug,
                    ]) }}"
                >
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

---

### Task 4: Rewrite hero base CSS and remove chip CSS

**Files:**
- Modify: `resources/css/pages/home.css` (lines 1–179)

This removes the background image, the dead `::after` stub, the two-column `.home-hero-grid`, updates `.home-hero-content` max-width, and deletes all `.hero-services-visual*` and `.service-chip*` rules.

- [ ] **Step 1: Replace everything from `.home-hero` through `.service-chip-name`**

Find the block starting at line 1 through line 179 (`.service-chip-name` closing brace), ending just before `/* Homepage sections */`:

```css
/* ================================
   Homepage hero
================================ */

.home-hero {
    position: relative;
    overflow: hidden;
    padding: 54px 0 64px;
    background:
        linear-gradient(to right,
            rgba(255, 255, 255, 0.45) 0%,
            rgba(255, 255, 255, 0.10) 50%,
            transparent 100%),
        url('/assets/images/hero.webp') center / cover no-repeat;
}

.home-hero::after {
    display: none;
}

.home-hero-grid {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 54px;
    align-items: center;
}

.home-hero-content {
    max-width: 780px;
}
```

(continuing through all `.hero-services-visual*` and `.service-chip*` blocks ending at `.service-chip-name { ... }` on line 179)

Replace the entire block from the `/* Homepage hero */` comment through `.service-chip-name { line-height: 1.2; }` with:

```css
/* ================================
   Homepage hero
================================ */

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

Then the `/* Homepage sections */` comment follows immediately.

---

### Task 5: Remove hero env effects CSS

**Files:**
- Modify: `resources/css/pages/home.css` (lines 669–931)

The entire env effects section is hero-only and contains no rules used elsewhere.

- [ ] **Step 1: Remove the env effects section**

Find the block starting with the env comment and ending with the last closing `}` of the `@media (max-width: 680px)` env sub-block:

```css
/* ================================
   Hero environmental effects
   Air / water / heat ambient layers.
   Parallax movement driven by JS.
   Entirely hidden under
   prefers-reduced-motion.
================================ */

.hero-env {
```

...through the closing brace of the last env media query rule ending at:

```css
    .hero-env-heat {
        width: 180px;
        height: 180px;
    }
}
```

Delete this entire block — approximately 265 lines. The file ends after this block (or continues with an empty line).

---

### Task 6: Clean hero rules from media queries

**Files:**
- Modify: `resources/css/pages/home.css`

Several media query blocks contain hero-specific rules that must be removed.

- [ ] **Step 1: Remove `.home-hero-grid` from the tablet breakpoint**

Inside `@media (max-width: 1100px)` find and remove:

```css
    .home-hero-grid {
        grid-template-columns: 1fr;
        gap: 34px;
    }
```

The rest of that media block (`.service-grid`, `.process-grid`, `.home-cta`) stays intact.

- [ ] **Step 2: Remove hero-specific rules from the mobile breakpoint**

Inside `@media (max-width: 680px)` find and remove these four blocks:

**Block A — hero background override:**
```css
    .home-hero {
        padding: 38px 0 42px;
        background:
            linear-gradient(to bottom,
                rgba(255, 255, 255, 0.60) 0%,
                rgba(255, 255, 255, 0.20) 70%,
                rgba(255, 255, 255, 0.10) 100%),
            url('/assets/images/hero.webp') 25% center / cover no-repeat;
    }
```

Replace with the padding-only rule (the background is gone but the tighter padding on mobile is still good):
```css
    .home-hero {
        padding: 48px 0 56px;
    }
```

**Block B — grid override (no longer exists):**
```css
    .home-hero-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
```

Remove entirely.

**Block C — chip container/grid mobile overrides:**
```css
    .hero-services-visual {
        padding: 18px;
        border-radius: 22px;
    }

    .hero-services-grid {
        gap: 8px;
    }
```

Remove entirely.

**Block D — chip element mobile overrides:**
```css
    .service-chip {
        padding: 12px 6px;
    }

    .service-chip-icon {
        width: 32px;
        height: 32px;
    }

    .service-chip-icon svg {
        width: 17px;
        height: 17px;
    }

    .service-chip-name {
        font-size: 0.7rem;
    }
```

Remove entirely.

The `h1`, `hero-intro`, `button-row`, and all section rules in the mobile breakpoint are **kept**.

---

### Task 7: Remove `initHeroParallax` from app.js

**Files:**
- Modify: `resources/js/app.js`

- [ ] **Step 1: Remove the `initHeroParallax` function and its call**

Find and remove the entire function (lines 47–79):

```js
function initHeroParallax() {
    const hero = document.querySelector('.home-hero');
    if (!hero) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    if ('ontouchstart' in window) return;

    const layers = hero.querySelectorAll('[data-parallax]');
    if (!layers.length) return;

    hero.addEventListener('mouseenter', () => {
        layers.forEach(layer => { layer.style.transition = ''; });
    });

    hero.addEventListener('mousemove', (e) => {
        const rect = hero.getBoundingClientRect();
        const dx = (e.clientX - rect.left - rect.width  / 2) / rect.width;
        const dy = (e.clientY - rect.top  - rect.height / 2) / rect.height;

        layers.forEach(layer => {
            const speed = parseFloat(layer.dataset.parallax) || 0;
            layer.style.transform =
                `translate(${dx * speed * 18}px, ${dy * speed * 12}px)`;
        });
    });

    hero.addEventListener('mouseleave', () => {
        layers.forEach(layer => {
            layer.style.transition = 'transform 0.7s cubic-bezier(0.22, 1, 0.36, 1)';
            layer.style.transform = '';
        });
    });
}
```

Also remove `initHeroParallax();` from the `DOMContentLoaded` callback.

The final `app.js` should be:

```js
import './bootstrap';
import './request-form';

function initMobileMenu() {
    const header = document.querySelector('.site-header');
    const toggle = document.querySelector('.mobile-menu-toggle');

    if (!header || !toggle) {
        return;
    }

    toggle.addEventListener('click', () => {
        header.classList.toggle('is-open');
    });
}

function initPipeFlowAnimation() {
    const list = document.querySelector('.service-page--plumbing .use-cases-list');
    if (!list) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        list.classList.add('is-in-view');
        return;
    }

    if (!('IntersectionObserver' in window)) {
        list.classList.add('is-in-view');
        return;
    }

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-in-view');
                obs.unobserve(entry.target);
            });
        },
        { threshold: 0, rootMargin: '0px 0px 80px 0px' }
    );

    observer.observe(list);
}

document.addEventListener('DOMContentLoaded', () => {
    initMobileMenu();
    initPipeFlowAnimation();
});
```

---

### Task 8: Build and test

- [ ] **Step 1: Run Vite build**

```powershell
cd c:\Users\duisb\Documents\AWebsiteBuildingBusiness\website-martin
npm run build
```

Expected: Build completes cleanly. CSS asset size noticeably smaller (~350 lines removed).
If it fails: Check for unclosed `}` in `home.css` — the most likely cause after bulk deletions.

- [ ] **Step 2: Run PHP test suite**

```powershell
php artisan test
```

Expected: 2 passed, 3 assertions.

---

### Task 9: Inspect diff and commit

- [ ] **Step 1: Check the diff**

```powershell
git diff HEAD resources/views/pages/partials/home-page.blade.php resources/css/pages/home.css resources/js/app.js
```

Verify: hero-env gone, chips gone, $serviceIcons gone, new labels present, clean hero CSS, no parallax in app.js.

- [ ] **Step 2: Stage the 3 files**

```powershell
git add resources/views/pages/partials/home-page.blade.php
git add resources/css/pages/home.css
git add resources/js/app.js
```

- [ ] **Step 3: Commit**

```powershell
git commit -m "refactor: reset homepage hero to clean brand foundation"
```

---

## Self-Review

**Spec coverage:**
- ✅ hero-env removed → Task 3 (blade) + Task 5 (CSS)
- ✅ hero-services-visual removed → Task 3 (blade) + Task 4 (CSS)
- ✅ $serviceIcons removed → Task 2
- ✅ background image removed → Task 4 (CSS)
- ✅ parallax JS removed → Task 7
- ✅ New headline/intro/CTA labels (3 locales) → Task 1
- ✅ New clean hero HTML → Task 3
- ✅ New clean hero CSS (.home-hero + .home-hero-content) → Task 4
- ✅ Dead tablet/mobile hero overrides removed → Task 6
- ✅ initMobileMenu/initPipeFlowAnimation kept → Task 7 (explicitly preserved)
- ✅ Build → Task 8
- ✅ Commit → Task 9

**Placeholder scan:** None. All tasks show exact code to add or remove.

**Consistency check:** `$text['hero_headline']` and `$text['hero_intro']` added in Task 1, used in Task 3. `primary_cta`/`secondary_cta` updated in Task 1, already used in existing hero HTML (kept in Task 3). No inconsistencies.
