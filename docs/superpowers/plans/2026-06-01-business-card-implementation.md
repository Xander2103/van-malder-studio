# Interactive Business Card Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add an interactive 3D-flipping business card component to the contact page left column that shows the QR/website side by default and flips to the contact info side on click/tap/keyboard, matching the physical business card branding.

**Architecture:** A new self-contained Blade component (`<x-business-card />`) contains both card faces as HTML. CSS in `app.css` handles the 3D perspective/rotation via `transform-style: preserve-3d` on a wrapper element, keeping float animation and flip on separate DOM elements to avoid `transform` conflicts. A minimal JS IIFE in `app.js` toggles the flip class and manages aria state.

**Tech Stack:** Laravel Blade components, Tailwind CSS v4 (`@layer components`), vanilla JS IIFE, inline SVG icons, static PNG assets for logo and QR code.

---

## Prerequisites (user action required before starting)

- [ ] Export the VM monogram logo as a **transparent-background PNG** (min 200×200px) → place at `public/images/vm-logo.png`
- [ ] Generate a QR code pointing to **`https://vanmalderstudio.be`** (no shortlinks), min 300×300px → place at `public/images/qr-code.png`. Free generators: goqr.me, qr-code-generator.com. Export as PNG.

The component renders gracefully without these files (CSS placeholder), but they must be in place before going live.

---

## File Map

| File | Action | What changes |
|---|---|---|
| `lang/nl/site.php` | Modify | Add 4 translation keys to `'contact'` array |
| `lang/fr/site.php` | Modify | Add 4 translation keys to `'contact'` array |
| `lang/en/site.php` | Modify | Add 4 translation keys to `'contact'` array |
| `lang/de/site.php` | Modify | Add 4 translation keys to `'contact'` array |
| `resources/css/app.css` | Modify | Add business card CSS block + `@keyframes bcFloat` |
| `resources/views/components/business-card.blade.php` | Create | Full card component HTML |
| `resources/js/app.js` | Modify | Add flip IIFE at end of file |
| `resources/views/pages/contact.blade.php` | Modify | Insert `<x-business-card />` in left column |
| `resources/views/components/navigation.blade.php` | Modify | Add inline SVG VM mark before brand text |

---

### Task 1: Add translation keys to all four language files

**Files:**
- Modify: `lang/nl/site.php`
- Modify: `lang/fr/site.php`
- Modify: `lang/en/site.php`
- Modify: `lang/de/site.php`

The four new keys belong inside the existing `'contact' => [...]` array, after the closing `],` of the nested `'validation'` sub-array and before the final `],` that closes `'contact'`.

In each file, find this line (it is the last line of the `'validation'` nested array):
```php
        ],
    ],
```
Where the inner `],` closes `'validation'` and the outer `],` closes `'contact'`. Insert the four keys between them.

- [ ] **Step 1.1 — Edit `lang/nl/site.php`**

Find and replace (the closing of 'validation' → closing of 'contact' boundary):
```php
        ],
    ],

    // ── About
```

Replace with:
```php
        ],
        'card_hint'       => 'Klik om te draaien',
        'card_aria_front' => 'Visitekaartje — klik om te draaien',
        'card_aria_back'  => 'Visitekaartje — klik om terug te draaien',
        'card_scan_label' => 'Scan voor website',
    ],

    // ── About
```

- [ ] **Step 1.2 — Edit `lang/fr/site.php`**

Find the same boundary in `lang/fr/site.php` and insert:
```php
        ],
        'card_hint'       => 'Cliquer pour retourner',
        'card_aria_front' => 'Carte de visite — cliquer pour retourner',
        'card_aria_back'  => 'Carte de visite — cliquer pour retourner',
        'card_scan_label' => 'Scanner le site',
    ],

    // ── About
```

- [ ] **Step 1.3 — Edit `lang/en/site.php`**

Find the same boundary in `lang/en/site.php` and insert:
```php
        ],
        'card_hint'       => 'Click to flip',
        'card_aria_front' => 'Business card — click to flip',
        'card_aria_back'  => 'Business card — click to flip back',
        'card_scan_label' => 'Scan for website',
    ],

    // ── About
```

- [ ] **Step 1.4 — Edit `lang/de/site.php`**

Find the same boundary in `lang/de/site.php` and insert:
```php
        ],
        'card_hint'       => 'Klicken zum Umdrehen',
        'card_aria_front' => 'Visitenkarte — klicken zum Umdrehen',
        'card_aria_back'  => 'Visitenkarte — zurückklicken',
        'card_scan_label' => 'Website scannen',
    ],

    // ── About
```

- [ ] **Step 1.5 — Verify all four keys exist in each language**

```bash
php artisan tinker --execute="echo __('site.contact.card_hint');"
# Expected (NL locale by default): Klik om te draaien
```

Run with each locale to confirm:
```bash
php artisan tinker --execute="App::setLocale('fr'); echo __('site.contact.card_hint');"
# Expected: Cliquer pour retourner

php artisan tinker --execute="App::setLocale('en'); echo __('site.contact.card_hint');"
# Expected: Click to flip

php artisan tinker --execute="App::setLocale('de'); echo __('site.contact.card_hint');"
# Expected: Klicken zum Umdrehen
```

---

### Task 2: Add business card CSS to app.css

**Files:**
- Modify: `resources/css/app.css`

Two insertions: (1) CSS block inside `@layer components { }`, (2) `@keyframes bcFloat` after the existing keyframes.

**Note on reduced motion:** The existing `@media (prefers-reduced-motion: reduce)` block in this file already has a `*` selector that sets `animation-duration: 0.01ms !important` and `transition-duration: 0.01ms !important`. This handles the business card automatically — no extra reduced-motion rules needed.

- [ ] **Step 2.1 — Add business card CSS inside `@layer components`**

In `resources/css/app.css`, find the closing `}` of `@layer components` (the line that follows `.card-woven-hint { ... }`). Insert the entire block **before** that closing `}`:

```css
    /* -----------------------------------------------------------------------
       Business Card — 3D flip component
       ----------------------------------------------------------------------- */
    .bc-scene {
        --bc-gold:    #c49a3a;
        --bc-cream:   #f7f0e3;
        --bc-icon-bg: #f0e4c8;
        --bc-text:    #1c1917;
        --bc-muted:   #78716c;
        --bc-circle:  #ecdbb0;
        perspective: 1000px;
        width: 100%;
        margin-top: 2rem;
    }

    .bc-float-wrapper {
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        animation: bcFloat 3.5s ease-in-out infinite;
        transition: box-shadow 0.3s ease;
    }

    .bc-scene:hover .bc-float-wrapper {
        box-shadow: 0 14px 36px rgba(196, 154, 58, 0.14), 0 4px 10px rgba(0, 0, 0, 0.07);
    }

    .bc-interacted .bc-float-wrapper {
        animation: none;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    .bc-inner {
        position: relative;
        width: 100%;
        aspect-ratio: 85.6 / 54;
        transform-style: preserve-3d;
        transition: transform 0.65s cubic-bezier(0.4, 0.2, 0.2, 1);
        border-radius: 10px;
        cursor: pointer;
        font-size: clamp(0.52rem, 1.8vw, 0.78rem);
    }

    .bc-inner.bc-flipped {
        transform: rotateY(180deg);
    }

    .bc-inner:focus-visible {
        outline: 2px solid var(--bc-gold);
        outline-offset: 5px;
        border-radius: 10px;
    }

    .bc-face {
        position: absolute;
        inset: 0;
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        background: var(--bc-cream);
        border: 1.5px solid var(--bc-gold);
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        align-items: stretch;
        color: var(--bc-text);
    }

    .bc-back {
        transform: rotateY(180deg);
    }

    /* Front face */
    .bc-f-left {
        width: 48%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 5% 4% 5% 6%;
        gap: 0.55em;
    }

    .bc-f-right {
        width: 52%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2% 3%;
        position: relative;
    }

    .bc-brand-name {
        font-family: var(--font-serif);
        font-size: 1.55em;
        font-weight: 400;
        line-height: 1.2;
        color: var(--bc-text);
        margin: 0;
    }

    .bc-tagline {
        font-size: 0.75em;
        line-height: 1.4;
        color: var(--bc-muted);
        margin: 0;
    }

    .bc-hdivider {
        width: 100%;
        height: 1px;
        background: var(--bc-gold);
        opacity: 0.5;
        flex-shrink: 0;
    }

    .bc-qr-circle-bg {
        position: absolute;
        width: 86%;
        aspect-ratio: 1;
        border-radius: 50%;
        background: var(--bc-circle);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .bc-phone {
        position: relative;
        z-index: 1;
        width: 52%;
        background: white;
        border-radius: 8px;
        box-shadow: 0 3px 14px rgba(0, 0, 0, 0.13);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 5% 5% 3%;
        gap: 4%;
        border: 0.75px solid rgba(196, 154, 58, 0.25);
    }

    .bc-phone-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
        width: 100%;
    }

    .bc-phone-header svg {
        width: 0.9em;
        height: 0.9em;
        color: var(--bc-gold);
    }

    .bc-website-label {
        font-size: 0.55em;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--bc-gold);
        font-weight: 500;
        line-height: 1;
    }

    .bc-qr-frame {
        width: 88%;
        aspect-ratio: 1;
    }

    .bc-qr-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    .bc-qr-placeholder {
        width: 100%;
        height: 100%;
        background: #e8e0d0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65em;
        color: var(--bc-muted);
        border-radius: 2px;
    }

    .bc-phone-footer {
        display: flex;
        align-items: center;
        gap: 3px;
        justify-content: center;
        width: 100%;
    }

    .bc-phone-footer svg {
        width: 0.7em;
        height: 0.7em;
        color: var(--bc-gold);
    }

    .bc-phone-footer span {
        font-size: 0.52em;
        color: var(--bc-muted);
        white-space: nowrap;
    }

    .bc-phone-btn {
        width: 18%;
        aspect-ratio: 1;
        border-radius: 50%;
        border: 1px solid rgba(0, 0, 0, 0.1);
        flex-shrink: 0;
    }

    /* Back face */
    .bc-b-left {
        width: 45%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 5% 3% 5% 4%;
        gap: 0.55em;
        text-align: center;
    }

    .bc-logo-img,
    .bc-logo-svg {
        width: 55%;
        height: auto;
        object-fit: contain;
        display: block;
    }

    .bc-vdivider {
        width: 1px;
        background: var(--bc-gold);
        opacity: 0.45;
        margin: 6% 0;
        flex-shrink: 0;
    }

    .bc-b-right {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 4% 5% 4% 3%;
        gap: 0.25em;
        min-width: 0;
    }

    .bc-name {
        font-family: var(--font-serif);
        font-size: 1.3em;
        font-weight: 400;
        color: var(--bc-text);
        line-height: 1.2;
        margin: 0;
    }

    .bc-studio-label {
        font-size: 0.65em;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--bc-muted);
        margin: 0 0 0.4em;
    }

    .bc-contacts {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .bc-contact-row {
        display: flex;
        align-items: center;
        gap: 0.45em;
        padding: 0.3em 0;
    }

    .bc-icon-circle {
        width: 1.6em;
        height: 1.6em;
        border-radius: 50%;
        background: var(--bc-icon-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .bc-icon-circle svg {
        width: 0.78em;
        height: 0.78em;
        color: var(--bc-gold);
    }

    .bc-contact-text {
        font-size: 0.7em;
        color: var(--bc-text);
        line-height: 1.3;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .bc-contact-link {
        font-size: 0.62em;
        color: var(--bc-gold);
        text-decoration: none;
        line-height: 1.3;
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .bc-hdivider-sm {
        height: 1px;
        background: var(--bc-gold);
        opacity: 0.2;
        width: 100%;
        flex-shrink: 0;
    }

    /* Interaction hint */
    .bc-hint {
        text-align: center;
        font-size: 0.68rem;
        color: var(--bc-gold);
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-top: 0.75rem;
        opacity: 1;
        transition: opacity 0.5s ease;
        pointer-events: none;
        user-select: none;
    }

    .bc-hint.bc-hint-gone {
        opacity: 0;
    }
```

- [ ] **Step 2.2 — Add `@keyframes bcFloat` after existing keyframes**

In `resources/css/app.css`, find the end of `@keyframes introFadeUp` (the `}` closing it, before the `/* Reduced motion */` comment). Insert immediately after:

```css
@keyframes bcFloat {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-5px); }
}
```

- [ ] **Step 2.3 — Verify CSS compiles without errors**

```bash
npm run build 2>&1 | head -30
```

Expected: build completes with no errors. If Tailwind purge is too aggressive and strips `.bc-*` classes, verify the `@source '../**/*.blade.php'` directive in app.css covers the new component (it does — already present on line 8).

---

### Task 3: Create the business card Blade component

**Files:**
- Create: `resources/views/components/business-card.blade.php`

- [ ] **Step 3.1 — Create the file with the complete content below**

Create `resources/views/components/business-card.blade.php` with this exact content:

```blade
<div class="bc-scene" data-flip-card>
    <div class="bc-float-wrapper">
        <div
            class="bc-inner"
            role="button"
            tabindex="0"
            aria-pressed="false"
            aria-label="{{ __('site.contact.card_aria_front') }}"
            data-label-front="{{ __('site.contact.card_aria_front') }}"
            data-label-back="{{ __('site.contact.card_aria_back') }}"
        >
            {{-- ───────────────────────────────────────────────────────── --}}
            {{-- FRONT — QR / website side (shown by default)             --}}
            {{-- ───────────────────────────────────────────────────────── --}}
            <div class="bc-face bc-front" aria-hidden="true">

                {{-- Left: brand name --}}
                <div class="bc-f-left">
                    <h3 class="bc-brand-name">Van Malder<br>Studio</h3>
                    <div class="bc-hdivider"></div>
                    <p class="bc-tagline">Websites, automatisatie<br>&amp; digitale oplossingen</p>
                </div>

                {{-- Right: phone mockup with QR --}}
                <div class="bc-f-right">
                    <div class="bc-qr-circle-bg"></div>
                    <div class="bc-phone">
                        <div class="bc-phone-header">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="2" y1="12" x2="22" y2="12"/>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                            </svg>
                            <span class="bc-website-label">WEBSITE</span>
                        </div>

                        <div class="bc-qr-frame">
                            @if(file_exists(public_path('images/qr-code.png')))
                                <img
                                    src="{{ asset('images/qr-code.png') }}"
                                    alt="QR code — vanmalderstudio.be"
                                    class="bc-qr-img"
                                    loading="lazy"
                                >
                            @else
                                <div class="bc-qr-placeholder">
                                    <span>QR</span>
                                </div>
                            @endif
                        </div>

                        <div class="bc-phone-footer">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                                <line x1="12" y1="18" x2="12.01" y2="18"/>
                            </svg>
                            <span>{{ __('site.contact.card_scan_label') }}</span>
                        </div>

                        <div class="bc-phone-btn"></div>
                    </div>
                </div>

            </div>{{-- .bc-front --}}

            {{-- ───────────────────────────────────────────────────────── --}}
            {{-- BACK — contact info side (shown after flip)              --}}
            {{-- ───────────────────────────────────────────────────────── --}}
            <div class="bc-face bc-back" aria-hidden="true">

                {{-- Left: VM logo --}}
                <div class="bc-b-left">
                    @if(file_exists(public_path('images/vm-logo.png')))
                        <img
                            src="{{ asset('images/vm-logo.png') }}"
                            alt=""
                            class="bc-logo-img"
                            aria-hidden="true"
                            loading="lazy"
                        >
                    @else
                        <svg class="bc-logo-svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                            <circle cx="12" cy="12" r="10.5" stroke="#c49a3a" stroke-width="1"/>
                            <text x="12" y="16.5" text-anchor="middle" font-family="'Instrument Serif', Georgia, serif" font-size="9.5" fill="#c49a3a">VM</text>
                        </svg>
                    @endif
                    <div class="bc-hdivider"></div>
                    <p class="bc-tagline">Websites, automatisatie<br>&amp; digitale oplossingen</p>
                </div>

                {{-- Vertical divider --}}
                <div class="bc-vdivider"></div>

                {{-- Right: contact details --}}
                <div class="bc-b-right">
                    <h3 class="bc-name">Xander Van Malder</h3>
                    <p class="bc-studio-label">VAN MALDER STUDIO</p>

                    <div class="bc-contacts">

                        {{-- Email --}}
                        <div class="bc-contact-row">
                            <div class="bc-icon-circle">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                                    <polyline points="2,4 12,13 22,4"/>
                                </svg>
                            </div>
                            <span class="bc-contact-text">{{ config('studio.email') }}</span>
                        </div>
                        <div class="bc-hdivider-sm"></div>

                        {{-- Website --}}
                        <div class="bc-contact-row">
                            <div class="bc-icon-circle">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="2" y1="12" x2="22" y2="12"/>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                                </svg>
                            </div>
                            <span class="bc-contact-text">www.vanmalderstudio.be</span>
                        </div>
                        <div class="bc-hdivider-sm"></div>

                        {{-- Location --}}
                        <div class="bc-contact-row">
                            <div class="bc-icon-circle">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <span class="bc-contact-text">Druivenstreek (Tervuren)</span>
                        </div>
                        <div class="bc-hdivider-sm"></div>

                        {{-- LinkedIn --}}
                        <div class="bc-contact-row">
                            <div class="bc-icon-circle">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                                    <rect x="2" y="9" width="4" height="12"/>
                                    <circle cx="4" cy="4" r="2"/>
                                </svg>
                            </div>
                            <div style="min-width:0">
                                <p class="bc-contact-text">LinkedIn</p>
                                <a
                                    href="https://www.linkedin.com/in/xander-van-malder/"
                                    class="bc-contact-link"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    tabindex="-1"
                                >linkedin.com/in/xander-van-malder/</a>
                            </div>
                        </div>

                    </div>{{-- .bc-contacts --}}
                </div>{{-- .bc-b-right --}}

            </div>{{-- .bc-back --}}

        </div>{{-- .bc-inner --}}
    </div>{{-- .bc-float-wrapper --}}

    <p class="bc-hint" aria-hidden="true">↻&ensp;{{ __('site.contact.card_hint') }}</p>

</div>{{-- .bc-scene --}}
```

**Note on the LinkedIn `<a>` link:** `tabindex="-1"` is intentional. The link is inside a card face that is `aria-hidden="true"`. Removing it from the tab order prevents screen readers from navigating into a hidden element. Sighted users who want to open the LinkedIn link can click through to it visually after flipping the card.

- [ ] **Step 3.2 — Verify the component is discoverable by Blade**

Blade components in `resources/views/components/` are auto-discovered. No registration needed. Verify the file exists at the correct path:

```bash
php -r "echo file_exists('resources/views/components/business-card.blade.php') ? 'OK' : 'MISSING';"
```

Expected: `OK`

---

### Task 4: Add the flip JS IIFE to app.js

**Files:**
- Modify: `resources/js/app.js`

- [ ] **Step 4.1 — Append the flip IIFE to the end of `resources/js/app.js`**

Add the following at the very end of the file (after the last `})();` block):

```javascript
// =============================================================================
// Business Card — 3D flip interaction
// Scoped to [data-flip-card]. No external dependencies.
// =============================================================================
(function () {
    const scenes = document.querySelectorAll('[data-flip-card]');
    if (!scenes.length) return;

    scenes.forEach(function (scene) {
        const inner = scene.querySelector('.bc-inner');
        const hint  = scene.querySelector('.bc-hint');
        if (!inner) return;

        const labelFront = inner.dataset.labelFront || '';
        const labelBack  = inner.dataset.labelBack  || '';

        function flip() {
            const isFlipped = inner.classList.toggle('bc-flipped');
            inner.setAttribute('aria-pressed', isFlipped ? 'true' : 'false');
            if (labelFront || labelBack) {
                inner.setAttribute('aria-label', isFlipped ? labelBack : labelFront);
            }
            if (!scene.classList.contains('bc-interacted')) {
                scene.classList.add('bc-interacted');
                if (hint) hint.classList.add('bc-hint-gone');
            }
        }

        inner.addEventListener('click', flip);
        inner.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                flip();
            }
        });
    });
})();
```

---

### Task 5: Insert `<x-business-card />` into the contact page

**Files:**
- Modify: `resources/views/pages/contact.blade.php`

- [ ] **Step 5.1 — Insert the component between the contact info block and the GDPR note**

In `resources/views/pages/contact.blade.php`, find this exact sequence (around line 64–66):

```blade
                </div>

                <div class="mt-8 p-5 bg-stone-100 rounded-xl border border-stone-200">
```

Replace with:

```blade
                </div>

                {{-- Business card --}}
                <x-business-card />

                <div class="mt-8 p-5 bg-stone-100 rounded-xl border border-stone-200">
```

The `.bc-scene` in the component has `margin-top: 2rem` in CSS, which matches the `mt-8` rhythm of the surrounding elements.

- [ ] **Step 5.2 — Verify the contact page renders without error**

```bash
php artisan route:list | grep contact
# Note the contact URL, then:
curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/contact
# Expected: 200
```

If the dev server is not running, start it first: `php artisan serve`

---

### Task 6: Add the VM mark to the navigation

**Files:**
- Modify: `resources/views/components/navigation.blade.php`

- [ ] **Step 6.1 — Replace the plain text brand link with logo mark + text**

In `resources/views/components/navigation.blade.php`, find the desktop brand link (around line 32–36):

```blade
        <a href="{{ navRoute('home', $locale) }}"
           class="font-serif text-[1.05rem] font-medium text-slate-900 tracking-tight hover:text-blue-700 transition-colors duration-200"
           aria-label="{{ config('studio.brand_name') }} — homepage">
            Van Malder Studio
        </a>
```

Replace with:

```blade
        <a href="{{ navRoute('home', $locale) }}"
           class="font-serif text-[1.05rem] font-medium text-slate-900 tracking-tight hover:text-blue-700 transition-colors duration-200 inline-flex items-center gap-2"
           aria-label="{{ config('studio.brand_name') }} — homepage">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="shrink-0">
                <circle cx="12" cy="12" r="10.5" stroke="#c49a3a" stroke-width="1"/>
                <text x="12" y="16.5" text-anchor="middle" font-family="'Instrument Serif', Georgia, serif" font-size="9.5" fill="#c49a3a">VM</text>
            </svg>
            <span>Van Malder Studio</span>
        </a>
```

Changes: added `inline-flex items-center gap-2` to the class list, added the 22px SVG mark, wrapped the text in `<span>`.

- [ ] **Step 6.2 — Verify navigation renders without layout shift**

Open the site in a browser and check:
- VM mark appears to the left of "Van Malder Studio"
- Mark is ~22px, gold circle with "VM" serif letters
- Header height is unchanged (still `h-16`)
- Hover colour applies to both mark and text (since they're inside the same `<a>`)
- Mobile hamburger and overall nav layout are unaffected

---

### Task 7: Build, test, and verify

- [ ] **Step 7.1 — Build production assets**

```bash
npm run build
```

Expected: Vite completes with no errors. Output should include the CSS and JS bundles. Watch for any Tailwind purge warnings about unknown classes (there should be none since `@source` covers blade files).

- [ ] **Step 7.2 — Run existing PHP tests**

```bash
php artisan test
```

Expected: all tests pass. The business card is purely frontend (no new PHP logic), so no existing tests should be affected. If any test fails, it is unrelated to this change.

- [ ] **Step 7.3 — Manual verification checklist**

Open the contact page in a browser (`/contact` or `/{locale}/contact`).

**Rendering:**
- [ ] Business card appears between the contact info block and the GDPR note
- [ ] Card shows the FRONT face by default (brand name + phone mockup with QR code)
- [ ] Card is correctly proportioned (approximately 1.6:1 landscape ratio)
- [ ] Cream background, gold border, gold divider line visible
- [ ] If `qr-code.png` is in place: QR is visible inside the phone mockup
- [ ] If `vm-logo.png` is in place: logo is visible on the BACK left half

**Interaction:**
- [ ] Click/tap the card: it flips to BACK (contact info side)
- [ ] Click/tap again: it flips back to FRONT
- [ ] Float animation runs on page load (card gently floats up and down)
- [ ] Float animation stops after first click
- [ ] "Klik om te draaien" hint is visible initially
- [ ] Hint fades after first click

**Desktop-specific:**
- [ ] Hover: gold shadow glow appears on the card
- [ ] Hover shadow transitions smoothly (0.3s)

**Keyboard:**
- [ ] Tab to the card: gold focus ring appears
- [ ] Press Enter: card flips
- [ ] Press Space: card flips (without scrolling the page)
- [ ] `aria-pressed` attribute updates (check via browser DevTools → Accessibility panel)

**Navigation:**
- [ ] VM mark appears to the left of "Van Malder Studio" text
- [ ] Mark is visually subtle, header is not cluttered

**Locale switching:**
- [ ] Hint text shows in the current locale (NL: "Klik om te draaien", FR: "Cliquer pour retourner", EN: "Click to flip", DE: "Klicken zum Umdrehen")

**Mobile (browser DevTools or real device):**
- [ ] Card fills the column width correctly
- [ ] Tap interaction works
- [ ] QR code is scannable with a phone camera (if asset is in place)

- [ ] **Step 7.4 — Only commit once the user has explicitly approved the result**

Do not commit automatically. Present the result for review. When the user approves:

```bash
git add \
  lang/nl/site.php \
  lang/fr/site.php \
  lang/en/site.php \
  lang/de/site.php \
  resources/css/app.css \
  resources/views/components/business-card.blade.php \
  resources/js/app.js \
  resources/views/pages/contact.blade.php \
  resources/views/components/navigation.blade.php

git commit -m "$(cat <<'EOF'
feat: add interactive 3D business card to contact page

Adds a premium flipping business card component to the contact page
left column. Front shows QR/brand side, back shows contact info.
Includes CSS 3D flip with float animation, keyboard accessibility,
reduced-motion support, and VM monogram mark in the navigation.

Co-Authored-By: Claude Sonnet 4.6 <noreply@anthropic.com>
EOF
)"
```

---

## Self-Review Notes

**Spec coverage check:**
- ✅ FRONT = QR/website side, shown by default
- ✅ BACK = contact info side (email, website, location, LinkedIn)
- ✅ Click/tap/Enter/Space flip interaction
- ✅ Float animation stops after first interaction
- ✅ Hint text "Klik om te draaien" (i18n, all 4 locales)
- ✅ 4 translation keys in all 4 language files
- ✅ `file_exists()` fallbacks for both `vm-logo.png` and `qr-code.png`
- ✅ No Composer QR dependency — static image asset only
- ✅ `aria-pressed` + `aria-label` updates on flip
- ✅ `tabindex="-1"` on LinkedIn `<a>` inside `aria-hidden` face
- ✅ `transform-style: preserve-3d` on `.bc-inner` only; no `filter` on ancestors
- ✅ Float (`translateY`) on `.bc-float-wrapper`; flip (`rotateY`) on `.bc-inner` — no conflict
- ✅ `box-shadow` not in keyframe — hover transition works correctly
- ✅ Existing reduced-motion `*` selector in app.css already covers `.bc-float-wrapper` and `.bc-inner`
- ✅ VM mark in navigation as 22px inline SVG
- ✅ `npm run build` step included
- ✅ Existing tests run in Task 7.2
- ✅ No commit until user approves
- ✅ Asset prerequisites documented at top of plan
