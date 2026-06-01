---
name: business-card-interactive-contact
description: Design spec for the interactive 3D-flipping business card component on the contact page
metadata:
  type: project
---

# Interactive Business Card Component — Design Spec

**Date:** 2026-06-01
**Status:** Approved — pending implementation plan
**Scope:** Contact page left column + navigation logo mark

---

## Overview

Add a premium interactive business card to the contact page. The card sits in the left sticky column between the contact info block and the GDPR note. By default it shows the **FRONT** (QR / website side). A click, tap, or keyboard interaction flips it with a smooth 3D rotation to the **BACK** (contact info side). Clicking again flips it back.

A subtle float animation and hint text signal interactivity. Both stop after the first interaction.

---

## Terminology

| Term | Meaning |
|---|---|
| **FRONT** | QR / website side — shown by default |
| **BACK** | Contact information side — shown after flip |

This naming is used consistently throughout the spec and implementation.

---

## Files Changed

| Action | File | Purpose |
|---|---|---|
| NEW | `resources/views/components/business-card.blade.php` | Card component |
| MOD | `resources/css/app.css` | Business card CSS block + keyframes |
| MOD | `resources/js/app.js` | Flip IIFE |
| MOD | `resources/views/pages/contact.blade.php` | Include `<x-business-card />` |
| MOD | `resources/views/components/navigation.blade.php` | Add VM mark before brand text |
| MOD | `lang/nl/site.php` | 4 new translation keys |
| MOD | `lang/fr/site.php` | 4 new translation keys |
| MOD | `lang/en/site.php` | 4 new translation keys |
| MOD | `lang/de/site.php` | 4 new translation keys |
| ADD | `public/images/vm-logo.png` | **User provides** — see §Asset Requirements |
| ADD | `public/images/qr-code.png` | **User provides** — see §Asset Requirements |

---

## Component: `<x-business-card />`

### Responsibilities
- Render both card faces (FRONT and BACK) as a single self-contained Blade component
- Accept no props — all data is sourced from `config('studio.*')` and translation strings
- Provide the interactive wrapper elements that JS targets via `[data-flip-card]`
- Handle graceful degradation when asset files are missing

### HTML Structure

```
div.bc-scene [data-flip-card]
│   CSS custom property scope
│   Perspective container (perspective: 1000px)
│
├── div.bc-float-wrapper
│   │   Float animation target (translateY only — separate from flip)
│   │
│   └── div.bc-inner [role="button"] [tabindex="0"]
│       │   3D rotation target (transform-style: preserve-3d)
│       │   Flip class: .bc-flipped → transform: rotateY(180deg)
│       │
│       ├── div.bc-face.bc-front         [FRONT — QR/website side]
│       │   ├── div.bc-f-left            Left half (48%)
│       │   │   ├── h3 "Van Malder Studio"
│       │   │   ├── div.bc-hdivider
│       │   │   └── p tagline
│       │   └── div.bc-f-right           Right half (52%)
│       │       └── div.bc-qr-circle     Large warm-cream circle
│       │           └── div.bc-phone     White phone mockup (CSS only)
│       │               ├── header: globe SVG + "WEBSITE"
│       │               ├── img qr-code.png
│       │               ├── footer: phone SVG + scan label
│       │               └── div.bc-phone-btn  Home button circle
│       │
│       └── div.bc-face.bc-back          [BACK — contact info side]
│           ├── div.bc-b-left            Left half (45%)
│           │   ├── img vm-logo.png
│           │   ├── div.bc-hdivider
│           │   └── p tagline
│           ├── div.bc-vdivider          Vertical gold rule
│           └── div.bc-b-right           Right half (flex 1)
│               ├── h3 "Xander Van Malder"
│               ├── p "VAN MALDER STUDIO"
│               └── div.bc-contacts
│                   ├── [row] envelope icon + email + hdivider
│                   ├── [row] globe icon + website + hdivider
│                   ├── [row] pin icon + location + hdivider
│                   └── [row] linkedin icon + label + link
│
└── p.bc-hint
        "↻ Klik om te draaien" — fades after first interaction
```

---

## Design Tokens

All scoped to `.bc-scene` as CSS custom properties. They do not pollute the global CSS variable namespace.

Declared as:
```css
.bc-scene {
    --bc-gold:    #c49a3a;
    --bc-cream:   #f7f0e3;
    --bc-icon-bg: #f0e4c8;
    --bc-text:    #1c1917;
    --bc-muted:   #78716c;
    --bc-circle:  #ecdbb0;   /* warm tan circle behind phone mockup on FRONT */
}
```

| Variable | Value | Usage |
|---|---|---|
| `--bc-gold` | `#c49a3a` | Borders, dividers, icon fills, accent text |
| `--bc-cream` | `#f7f0e3` | Card face backgrounds |
| `--bc-icon-bg` | `#f0e4c8` | Soft cream circles behind contact icons |
| `--bc-text` | `#1c1917` | Primary text (near-black charcoal) |
| `--bc-muted` | `#78716c` | Secondary labels (VAN MALDER STUDIO, tagline) |
| `--bc-circle` | `#ecdbb0` | Warm tan circle background on FRONT right half |

---

## Card Dimensions and Layout

- **Aspect ratio:** `85.6 / 54` (standard business card: 85.6mm × 53.98mm)
- **Width:** `100%` of the left column — fills available space, never overflows
- **Border:** `1.5px solid var(--bc-gold)`, `border-radius: 10px`
- **Padding:** `5% 4%` on each face (percentage-based, scales with card width)

### FRONT face layout (QR / website side)
- Left 48%: brand name ("Van Malder Studio" in `font-serif`, large charcoal) + thin gold rule + tagline
- Right 52%: large warm-cream circle element + CSS phone mockup overlay (white, rounded-rect) containing: globe SVG + "WEBSITE" small-caps label + QR code image + phone icon + scan label + home-button circle
- Both halves flex-aligned to center vertically

### BACK face layout (contact info side)
- Left 45%: VM logo PNG (centered, ~55% of column width) + thin gold rule + tagline
- Center: thin vertical gold rule (`width: 1px, background: var(--bc-gold), opacity: 0.45`)
- Right flex-1: "Xander Van Malder" (Instrument Serif) + "VAN MALDER STUDIO" (small caps, muted) + four contact rows

### Contact rows (BACK face)
Each row: `display: flex; align-items: center; gap: 8px`. Icon in a soft cream circle. After each row (except the last): thin horizontal gold rule.

| Icon shape | Content |
|---|---|
| Envelope SVG | `info@vanmalderstudio.be` |
| Globe SVG | `www.vanmalderstudio.be` |
| Location pin SVG | `Druivenstreek (Tervuren)` |
| LinkedIn `in` SVG | Label: "LinkedIn" + link: `linkedin.com/in/xander-van-malder/` (in `--bc-gold`) |

All icon SVGs are inline in the component. No external icon library.

### Font sizing

The left column is approximately 330px wide on desktop. Font sizes inside the card faces should use a scaled base to fit this constraint. Set a base on `.bc-inner`:

```css
.bc-inner {
    font-size: clamp(0.52rem, 1.8vw, 0.78rem);
}
```

Then use `em` units internally (e.g. brand name `1.55em`, tagline `0.82em`, contact name `1.3em`, labels `0.72em`). This way the entire card scales proportionally if the left column width changes.

---

## CSS

### 3D Flip Mechanism — Wrapper Approach

Two separate elements handle two separate transforms — no CSS Individual Transform Properties required, maximum browser compatibility:

```css
/* Float animation lives on the wrapper */
.bc-float-wrapper {
    animation: bcFloat 3.5s ease-in-out infinite;
}

/* Flip lives on the inner element */
.bc-inner {
    position: relative;
    width: 100%;
    transform-style: preserve-3d;
    transition: transform 0.65s cubic-bezier(0.4, 0.2, 0.2, 1);
}

.bc-inner.bc-flipped {
    transform: rotateY(180deg);
}

/* Faces */
.bc-face {
    position: absolute;
    inset: 0;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
}

.bc-back {
    transform: rotateY(180deg);
}
```

`.bc-inner` needs `aspect-ratio: 85.6 / 54` and `position: relative` to give the absolutely-positioned faces a dimensions context.

### Shadow and Float Keyframe

**Critical constraint:** `filter` must NOT be applied to `.bc-float-wrapper` or any ancestor of `.bc-inner`. Any `filter` value other than `none` on an ancestor of a `transform-style: preserve-3d` element forces the browser to flatten the 3D context, breaking the flip animation. `box-shadow` does not create a stacking context and is safe.

Shadow and float animation are both on `.bc-float-wrapper`:

```css
.bc-float-wrapper {
    border-radius: 10px;   /* matches face radius, makes box-shadow follow card shape */
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
    animation: bcFloat 3.5s ease-in-out infinite;
}

@keyframes bcFloat {
    0%, 100% {
        transform: translateY(0);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
    }
    50% {
        transform: translateY(-5px);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.11);
    }
}
```

### Hover

```css
.bc-scene:hover .bc-float-wrapper {
    box-shadow: 0 14px 36px rgba(196, 154, 58, 0.14), 0 4px 10px rgba(0, 0, 0, 0.07);
}
```

Warm gold glow shadow on hover. Applied to the wrapper, not `.bc-inner` — no stacking context conflict. No transform applied on hover — float animation handles movement.

### First-interaction: stop float

When JS adds `bc-interacted` to `.bc-scene`:

```css
.bc-interacted .bc-float-wrapper {
    animation: none;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);   /* hold the resting shadow */
}
```

The float stops immediately on first click. The flip transition takes over visually. The shadow is held at its resting value so there is no visual pop when the animation ends.

### Hint text

```css
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

### Focus ring

```css
.bc-inner:focus-visible {
    outline: 2px solid var(--bc-gold);
    outline-offset: 5px;
    border-radius: 10px;
}
```

### Reduced motion

```css
@media (prefers-reduced-motion: reduce) {
    .bc-float-wrapper {
        animation: none;
    }
    .bc-inner {
        transition-duration: 0.01ms;
    }
}
```

The flip still works (class toggle), just without animation. Cards are still usable.

---

## JavaScript (IIFE in app.js)

Approximately 30 lines. Scoped to `[data-flip-card]`. No external dependencies.

```
(function () {
    // Query all flip card scenes on the page
    const scenes = document.querySelectorAll('[data-flip-card]');

    scenes.forEach(function (scene) {
        const wrapper = scene.querySelector('.bc-float-wrapper');
        const inner   = scene.querySelector('.bc-inner');
        const hint    = scene.querySelector('.bc-hint');
        if (!inner) return;

        // aria labels stored as data attributes for i18n support
        const labelFront = inner.dataset.labelFront || 'Business card';
        const labelBack  = inner.dataset.labelBack  || 'Business card — flipped';

        function flip() {
            const isFlipped = inner.classList.toggle('bc-flipped');
            inner.setAttribute('aria-pressed', isFlipped ? 'true' : 'false');
            inner.setAttribute('aria-label', isFlipped ? labelBack : labelFront);

            // First interaction: stop float animation + fade hint
            if (!scene.classList.contains('bc-interacted')) {
                scene.classList.add('bc-interacted');
                if (hint) hint.classList.add('bc-hint-gone');
            }
        }

        inner.addEventListener('click', flip);
        inner.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();   // prevent Space from scrolling the page
                flip();
            }
        });
    });
})();
```

---

## Translation Keys

Four new keys added to all four language files under the `'contact'` array:

| Key | NL | FR | EN | DE |
|---|---|---|---|---|
| `site.contact.card_hint` | Klik om te draaien | Cliquer pour retourner | Click to flip | Klicken zum Umdrehen |
| `site.contact.card_aria_front` | Visitekaartje — klik om te draaien | Carte de visite — cliquer pour retourner | Business card — click to flip | Visitenkarte — klicken zum Umdrehen |
| `site.contact.card_aria_back` | Visitekaartje — klik om terug te draaien | Carte de visite — cliquer pour retourner | Business card — click to flip back | Visitenkarte — zurückklicken |
| `site.contact.card_scan_label` | Scan voor website | Scanner le site | Scan for website | Website scannen |

`card_scan_label` is used inside the phone mockup on the FRONT face below the QR code.

---

## Navigation VM Mark

**Goal:** Add the VM brand mark to the navigation without cluttering the header.

**Change:** The existing text link in `navigation.blade.php`:
```html
<a ...>Van Malder Studio</a>
```
becomes:
```html
<a ... class="... flex items-center gap-2">
    [inline SVG — 22×22px VM mark]
    <span>Van Malder Studio</span>
</a>
```

**SVG spec:**
- ViewBox: `0 0 24 24`
- Circle: `cx=12 cy=12 r=10.5`, `stroke="#c49a3a"`, `stroke-width="1"`, `fill="none"`
- Text "VM": `font-family="'Instrument Serif', Georgia, serif"`, `font-size="9.5"`, `fill="#c49a3a"`, centered at `x=12 y=16`
- Fully transparent background — works on `stone-50/95` nav
- The PNG is **not** used in the nav (cannot guarantee transparency from a JPG source)

The same inline SVG logic applies to the mobile menu brand link.

---

## Asset Requirements

### `public/images/vm-logo.png`

**Required by:** BACK face of the business card.

**Specification:**
- Format: PNG with **transparent** background (not JPG — transparency required)
- Size: minimum 200×200px recommended for sharp rendering
- Content: the VM monogram in the gold circle (as per Image 3 reference)
- Rendered size on card: approximately 70–80px wide

**Graceful fallback (if file missing):**
The component checks `@if(file_exists(public_path('images/vm-logo.png')))`.
If missing: renders an inline SVG VM mark (same as the nav mark but larger, ~60px) as a placeholder. The layout does not break; the card still displays correctly.

### `public/images/qr-code.png`

**Required by:** FRONT face of the business card (inside the phone mockup).

**Specification:**
- Format: PNG (no transparency needed)
- Points to: `https://vanmalderstudio.be` — **no QR shortlinks**
- Size: minimum 300×300px recommended (rendered at ~80–90px, but higher source resolution = sharper scan)
- Generate at any trusted QR generator: e.g. qr-code-generator.com, goqr.me, or the free tier of QRCode Monkey (direct URL, no branding required)

**Graceful fallback (if file missing):**
The component checks `@if(file_exists(public_path('images/qr-code.png')))`.
If missing: renders a gray placeholder box (same dimensions as the QR image) with the text "QR" centered in it — styled minimally so the card layout is preserved. In production this should never be visible; it is a dev safeguard only.

**Scannability note:** At 80–90px rendered size, a properly generated QR code from a 300×300px+ source will remain scannable on modern phones. Test by scanning with your phone before going live.

---

## Contact Page Integration

**File:** `resources/views/pages/contact.blade.php`

**Location:** Between line ~64 (closing `</div>` of the `.mt-8.space-y-5` contact info block) and line ~66 (opening `<div class="mt-8 p-5 bg-stone-100 ...">` GDPR note).

```blade
                </div>

                {{-- Business card --}}
                <x-business-card />

                <div class="mt-8 p-5 bg-stone-100 rounded-xl border border-stone-200">
```

The component has `mt-8` top margin on `.bc-scene` to match the spacing rhythm of other elements in the column.

---

## Error Handling and Edge Cases

| Scenario | Handling |
|---|---|
| `vm-logo.png` missing | Inline SVG VM mark placeholder — layout preserved |
| `qr-code.png` missing | Gray placeholder box — layout preserved |
| JS disabled | Card still renders correctly; both faces exist in DOM; FRONT is visible (no flip needed for accessible contact info since it duplicates the content above) |
| `prefers-reduced-motion` | Animation off; flip class still toggles; all content accessible |
| Very narrow screen (<320px) | Card scales with `width: 100%` — minimum safe width |
| Card on non-contact pages | Component is safe to drop anywhere; scoped CSS and JS cause no conflicts |

---

## Open Items / Notes for Implementation

- The inline SVG icons (envelope, globe, pin, LinkedIn) in the BACK face contact rows should be consistent with the existing SVG icon style in the project (thin stroke, 2px `stroke-width`, `stroke-linecap: round`).
- The `bc-phone-btn` home button is a small aesthetic detail; if it makes the phone mockup look wrong at smaller sizes, it can be omitted.
- The large circle behind the phone mockup on the FRONT face uses approximate color `#ecdbb0` (warm tan). Adjust to taste after visual review.
- LinkedIn URL: `https://www.linkedin.com/in/xander-van-malder/` — use the full URL in the `href`, display the short form `linkedin.com/in/xander-van-malder/` as text.
