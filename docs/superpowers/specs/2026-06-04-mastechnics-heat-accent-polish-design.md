# Mastechnics Heat Accent Polish — Design Spec
Date: 2026-06-04

## Goal

Strengthen the warm red/orange heat accent on the homepage so it is clearly visible without making the site feel orange or aggressive. Blue remains dominant. The heating/Verwarming identity should be unmistakably warmer than all other services.

## Problem

After the initial palette update, the warm accent was too subtle — only a faint icon tint on the Verwarming chip. Hero heat glow was barely perceptible. Service cards had no heat differentiation.

## Changes

### Hero heat glow (`home.css`)
- Gradient center: `rgba(255,122,69,0.32)` → `0.50`
- Gradient edge: `rgba(255,122,69,0.09)` → `0.15`
- `heatPulse` min opacity: `0.45` → `0.62`
- Max opacity stays `1.00`
- Size and animation timing unchanged

### Verwarming service chip (`home.css`)
- Chip level (`.service-chip--heat`): warm border `rgba(255,122,69,0.35)`, background `rgba(255,122,69,0.05)`, box-shadow `rgba(255,122,69,0.14)`
- Icon (`.service-chip--heat .service-chip-icon`): gradient `rgba(255,122,69,0.20→0.10)`, color `--color-accent-heat`
- Hover (`.service-chip--heat:hover`): border `rgba(255,122,69,0.55)`, shadow `rgba(255,122,69,0.22)`

### Verwarming service card (`home.css` + `home-page.blade.php`)
- New modifier class `service-card--heat` applied via conditional in blade
- Default: border `rgba(255,122,69,0.30)`, shadow `rgba(255,122,69,0.08)`
- Hover: border `rgba(255,122,69,0.50)`, shadow `rgba(255,122,69,0.14)`

### Waarom Mastechnics section (`home.css`)
- `.why-card:first-child` gets `border-top: 2px solid rgba(255,122,69,0.45)`
- Targets "Erkende technici" (gas/F-gas certified) — heating-adjacent
- No blade change needed

## Constraints

- Primary buttons stay blue at all times
- All non-heating chips, cards, and sections untouched
- Admin, request flow, service detail pages untouched
- Urgent warning red unchanged
- nl/fr/en unaffected — no translation changes

## Files

| File | Change |
|---|---|
| `resources/css/pages/home.css` | 6 targeted CSS changes |
| `resources/views/pages/partials/home-page.blade.php` | 1 line: conditional `service-card--heat` class |
