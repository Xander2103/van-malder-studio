# MAS Technics Logo Identity Alignment — Design Spec
Date: 2026-06-04

## Goal

Align the Mastechnics public website with the visual identity of the real MAS Technics logo: replace the plain text header with the real logo image, and complete the 3-color service identity system (blue water / orange-red heat / cool grey-blue cooling) so the site reflects the logo's three hexagons.

## Logo Assets

- `public/assets/images/Logo.webp` — Three overlapping hexagons (blue water droplet, orange-red flame, grey snowflake) + bold dark charcoal "MAS TECHNICS" text. Sharp, ~4:1 ratio. **Use this in the header.**
- `public/assets/images/logoMetTekst.webp` — Same mark plus multilingual service categories below. Too tall for header. **Reserved for footer/About in a future sprint.**

## Changes

### 1. Header logo (`app.blade.php`)
Replace `{{ config('site.name') }}` text inside `.site-logo` with:
```blade
<img
    src="{{ asset('assets/images/Logo.webp') }}"
    alt="MAS Technics"
    class="site-logo-img"
    width="176"
    height="44"
>
```
Explicit width/height prevents CLS. Aspect ratio ~4:1.

### 2. Header logo sizing (`header.css`)
Add `.site-logo-img` rule:
- Desktop: `max-height: 40px; width: auto; display: block;`
- Mobile (≤680px): `max-height: 36px;`

### 3. Cool accent variable (`variables.css`)
Add after `--color-accent-urgent`:
```css
--color-accent-cool: #7A9EBB;
```
`#7A9EBB` = `rgb(122,158,187)` — desaturated cool blue-grey. Mirrors the grey snowflake hexagon. Intentionally more muted than the heat accent.

### 4. Cooling service CSS (`home.css`)
Add chip and card modifier rules for the cooling identity. Intentionally lower opacity than heat accent — the logo's grey hexagon is less visually dominant than the orange-red one.

`.service-chip--cool`: warm border, subtle background, soft shadow
`.service-chip--cool .service-chip-icon`: cool gradient + accent color
`.service-chip--cool:hover`: stronger border/shadow
`.service-card--cool`: cool border + shadow
`.service-card--cool:hover`: stronger cool border/shadow

### 5. Blade conditional classes (`home-page.blade.php`)
Both chip loop and card loop get a second condition alongside the existing heat condition:
- `airco` → `service-chip--cool` / `service-card--cool`
- `cold-rooms` → `service-chip--cool` / `service-card--cool`

## Service Identity Map (Final State)

| Service | CSS modifier | Identity |
|---|---|---|
| `heating` | `--heat` | Orange-red flame |
| `airco` | `--cool` | Cool grey-blue snowflake |
| `cold-rooms` | `--cool` | Cool grey-blue snowflake |
| `plumbing` | Default | Primary blue (water) |
| `water-softeners` | Default | Primary blue (water) |
| `ventilation` | Default | Neutral blue/grey |

## Constraints

- No change to Smart Request Flow, admin, controllers, models, routes, DB, service detail pages, footer
- Primary buttons stay blue
- Urgent warning red unchanged
- nl/fr/en translations unaffected
- No `logoMetTekst.webp` in the header
- No distortion of logo — aspect ratio preserved, max-height only

## Files Changed

1. `resources/views/layouts/app.blade.php`
2. `resources/css/layout/header.css`
3. `resources/css/base/variables.css`
4. `resources/css/pages/home.css`
5. `resources/views/pages/partials/home-page.blade.php`
