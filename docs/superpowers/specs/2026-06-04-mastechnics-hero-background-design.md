# Mastechnics Hero Background Image — Design Spec
Date: 2026-06-04

## Goal

Replace the CSS gradient background of the homepage hero with the approved `hero.webp` technical photo (HVAC pipes + blueprint), maintaining text readability and keeping the service chips panel clean.

## Image Assessment

`public/assets/images/hero.webp`: Professional HVAC/technical photo. Left half fades from white to a blueprint-style line drawing. Right half shows real colored pipes and industrial equipment. Very light overall. Existing dark text (`#081d31`, `#405163`) has strong contrast against the light left portion without a heavy overlay.

## Changes — One file only

`resources/css/pages/home.css`

### Desktop (main rule)
Replace `background: radial-gradient(...), linear-gradient(...)` with:
```css
background:
    linear-gradient(to right,
        rgba(255, 255, 255, 0.45) 0%,
        rgba(255, 255, 255, 0.10) 50%,
        transparent 100%),
    url('/assets/images/hero.webp') center / cover no-repeat;
```
Left-to-right white fade: strong on text side (0→50%), gone on image side. Photo fills full width at any viewport.

### Mobile override (inside `@media (max-width: 680px)`)
Replace the mobile background with:
```css
background:
    linear-gradient(to bottom,
        rgba(255, 255, 255, 0.60) 0%,
        rgba(255, 255, 255, 0.20) 70%,
        rgba(255, 255, 255, 0.10) 100%),
    url('/assets/images/hero.webp') 25% center / cover no-repeat;
```
Top-to-bottom veil for stacked single-column layout. Position `25% center` keeps the lighter blueprint portion behind the text stack.

## Environmental Effects

All existing `.hero-env-*` effects unchanged. They're already very low opacity and won't clash with the light photo. The orange heat glow adds brand identity on top of the photo.

## Constraints

- No Blade changes
- No Smart Request Flow or admin changes
- No DB or schema changes
- Translations unaffected
- Service chips panel (`background: rgba(255,255,255,0.90)`) unchanged — already floats cleanly over photos
