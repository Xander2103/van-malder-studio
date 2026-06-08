# Homepage Hero Hexagon Cluster — Design Spec
Date: 2026-06-04

## Goal

Add an interactive 6-service hexagon cluster to the right side of the homepage hero. Each hexagon is a real `<a>` link to the correct service page for the active locale. The left hero text, CTA buttons, and hero.webp background remain unchanged.

## Files Changed (2)

- `resources/views/pages/partials/home-page.blade.php`
- `resources/css/pages/home.css`

No JS. No admin/request flow/database changes. No new dependencies.

## Blade Structure

### PHP section additions
Add after `$services` is built:
```php
$hexServices = $services->keyBy('key');
```

### Hero HTML change
Wrap the existing `.home-hero-content` and the new `.hero-hex-cluster` inside a `.home-hero-layout` div inside `.container`:

```blade
<div class="container">
    <div class="home-hero-layout">
        <div class="home-hero-content">...</div>
        <div class="hero-hex-cluster" aria-label="{{ $text['services_label'] }}">
            <div class="hero-hex-row">
                <!-- Row 1: Sanitair, Verwarming, Airco -->
            </div>
            <div class="hero-hex-row">
                <!-- Row 2 (offset): Ventilatie, Waterverzachters, Koelcellen -->
            </div>
        </div>
    </div>
</div>
```

### Service → hex mapping

| Row | Service key | CSS modifier | Color |
|---|---|---|---|
| 1 | `plumbing` (Sanitair) | `hero-hex--water` | `#0F66C2` |
| 1 | `heating` (Verwarming) | `hero-hex--heat` | `#E55A22` |
| 1 | `airco` | `hero-hex--cool` | `#5A8FAD` |
| 2 | `ventilation` (Ventilatie) | `hero-hex--vent` | `#7A96A8` |
| 2 | `water-softeners` (Waterverzachters) | `hero-hex--water` | `#1A76CC` |
| 2 | `cold-rooms` (Koelcellen) | `hero-hex--icy` | `#3B7A99` |

### Link generation
```blade
href="{{ route('pages.show', ['locale' => $locale, 'slug' => $hexServices['plumbing']['slug']]) }}"
aria-label="{{ $hexServices['plumbing']['title'] }}"
```
Slugs are locale-aware via the existing `$services` collection.

### Each hexagon inner structure
```blade
<a class="hero-hex hero-hex--water" href="..." aria-label="...">
    <span class="hero-hex-icon" aria-hidden="true"><!-- inline SVG --></span>
    <span class="hero-hex-label">{{ $hexServices['plumbing']['title'] }}</span>
</a>
```

### SVG icons (inline, 24px)
- plumbing: water droplet
- heating: flame
- airco: wind/airflow lines
- ventilation: rotating arrows
- water-softeners: water drop (slightly different)
- cold-rooms: snowflake (4-spoke with cross-bars)

## CSS

### Two-column hero layout
```css
.home-hero-layout {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 54px;
    align-items: center;
}
```

### Hex dimensions
- `--hx-w: 110px`
- `--hx-h: 127px` (110 × 1.1547 for regular hexagon)
- `--hx-gap: 6px`
- Row 2 margin-left: 58px (half-hex width + half-gap)
- Row 2 margin-top: -32px (row overlap = 127 × 0.25)

### Clip-path (pointy-top hexagon)
```css
clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
```

### Hover (drop-shadow follows clip-path)
```css
.hero-hex:hover { transform: translateY(-4px); }
.hero-hex--water:hover  { filter: drop-shadow(0 6px 14px rgba(15,102,194,0.55)); }
.hero-hex--heat:hover   { filter: drop-shadow(0 6px 14px rgba(229,90,34,0.55)); }
.hero-hex--cool:hover   { filter: drop-shadow(0 6px 14px rgba(90,143,173,0.55)); }
.hero-hex--vent:hover   { filter: drop-shadow(0 6px 14px rgba(122,150,168,0.50)); }
.hero-hex--icy:hover    { filter: drop-shadow(0 6px 14px rgba(59,122,153,0.55)); }
```

### Focus
```css
.hero-hex:focus-visible {
    outline: 3px solid #fff;
    outline-offset: 4px;
}
```

## Responsive

### Tablet (≤1100px)
- Hero layout collapses to single column
- Hex cluster centers under the text content

### Mobile (≤680px)
- Hex cluster becomes a 2×3 grid (2 columns, 3 rows)
- No honeycomb offset
- `clip-path` removed → `border-radius: 14px` pill shape
- Each card 72px tall with centered icon + label
- Labels readable (0.75rem minimum)

## Accessibility
- All `<a>` have `aria-label` with service name
- Visible focus via `:focus-visible` white outline
- Service name visible as `.hero-hex-label` text
- Keyboard tab order: left-to-right, row 1 then row 2

## Constraints
- No center/empty hexagon
- No JS
- No admin/request flow changes
- No database changes
- nl/fr/en slugs via existing `$hexServices` lookup
- Hero.webp, left text, CTA buttons unchanged
