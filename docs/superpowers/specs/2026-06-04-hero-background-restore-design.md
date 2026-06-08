# Hero Background Image Restore — Design Spec
Date: 2026-06-04

## Goal
Restore hero.webp as the full-width background of the clean base hero in home.css.

## Change
`resources/css/pages/home.css` only.

- Desktop: left-to-right white veil over the image so headline text stays readable against the lighter blueprint side.
- Mobile: top-to-bottom white veil + background shifted to 25% so the lighter part of the image sits behind the stacked text.
- `border-bottom` removed — photo edge serves the same visual purpose.

## No other files change.
