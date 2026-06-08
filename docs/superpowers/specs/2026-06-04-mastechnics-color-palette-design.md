# Mastechnics Color Palette Refinement — Design Spec
Date: 2026-06-04

## Goal

Refine the Mastechnics website color system so it visually connects to the brand's services (water, heat, cooling, ventilation) without redesigning the site. Blue remains the dominant brand color. Warm red/orange (#FF7A45, #E5473F) is introduced as a subtle accent for heating and urgency contexts only.

## Palette

| Variable | Value | Role |
|---|---|---|
| `--color-primary` | `#0F66C2` | Brand blue — dominant, all CTAs, nav, icons |
| `--color-primary-dark` | `#09243F` | Deep navy — headings, dark text, button hover |
| `--color-text` | `#09243F` | Body text |
| `--color-muted` | `#5B6B7A` | Secondary text, labels |
| `--color-border` | `#D9E1EA` | Card borders, input borders |
| `--color-background` | `#F5F7FA` | Page and card backgrounds |
| `--color-white` | `#FFFFFF` | White space |
| `--color-accent-heat` | `#FF7A45` | Heating icon, hero heat glow |
| `--color-accent-urgent` | `#E5473F` | Urgent badges, warning boxes |

## Constraints

- Do not redesign the full site.
- Do not touch Smart Request Flow logic, admin logic, database, routes, or controllers.
- Keep nl/fr/en working — no translation changes needed.
- Primary buttons stay blue at all times — no warm hover applied.
- Red/orange visible in exactly 4 surface areas (see below).
- Keep WCAG AA contrast for all text on colored backgrounds.

## Where Accent Colors Appear

### Blue (dominant — unchanged)
- All primary buttons and CTAs
- Navigation, header, footer
- All service chips except heating
- Form steps, input focus rings
- Service detail pages
- Status badges: new, contacted, planned, done

### Warm red-orange (#FF7A45 — heating accent)
- Hero heat glow top-right: `rgba(255, 122, 69, 0.32)` and `rgba(255, 122, 69, 0.09)`
- `.service-chip--heat .service-chip-icon` background + icon stroke

### Warm red (#E5473F — urgent accent, text at #B52A24 for contrast)
- Admin: `.admin-urgency-urgent`, `.admin-urgency-water_leaking`, `.admin-status-cancelled`
- Request flow: `.urgent-warning-box` border and text

### Grey/white (dominant backgrounds — unchanged)
- All page backgrounds (`--color-background`)
- Card backgrounds
- Form fields

## Files Changed

1. `resources/css/base/variables.css` — 5 value updates + 2 new variables + shadow rgba update
2. `resources/css/pages/home.css` — hero heat glow rgba values + new `.service-chip--heat` rule
3. `resources/views/pages/partials/home-page.blade.php` — conditional `service-chip--heat` class
4. `resources/css/pages/admin.css` — 3 badge selectors (urgent, water_leaking, cancelled)
5. `resources/css/pages/request.css` — `.urgent-warning-box` border and text color

## Not Changed

- `resources/css/components/buttons.css` — CTA hover stays blue
- `resources/css/pages/service.css`
- `resources/css/pages/contact.css`
- `resources/css/layout/header.css`
- `resources/css/layout/footer.css`
- All blade files except home-page (1 line)
- All PHP: controllers, models, routes, config, migrations
