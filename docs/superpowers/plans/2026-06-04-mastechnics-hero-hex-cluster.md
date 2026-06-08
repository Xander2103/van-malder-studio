# Homepage Hero Hexagon Cluster — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add an interactive 6-service hexagon honeycomb cluster to the right side of the homepage hero — each hexagon is a real `<a>` link to its service page for the active locale, styled with brand colors and CSS hover effects.

**Architecture:** Blade template gets a `$hexServices` lookup and a new `.home-hero-layout` two-column wrapper; the hex cluster sits as a sibling to `.home-hero-content`. CSS adds the hexagon shape via `clip-path`, color modifiers, hover via `filter: drop-shadow`, and a 2-column flat-card grid at mobile. No JS.

**Tech Stack:** Laravel 12 Blade, custom CSS, Vite build, PHPUnit.

---

## File Map

| File | What changes |
|---|---|
| `resources/views/pages/partials/home-page.blade.php` | Add `$hexServices` lookup; add `.home-hero-layout` wrapper; add `.hero-hex-cluster` with 6 `<a>` hexagons |
| `resources/css/pages/home.css` | Add layout + hex shape + color modifiers + hover/focus + tablet/mobile responsive |

---

### Task 1: Add `$hexServices` lookup and two-column layout wrapper in Blade

**Files:**
- Modify: `resources/views/pages/partials/home-page.blade.php`

- [ ] **Step 1: Add `$hexServices` after `$text` assignment in the `@php` block**

Find this line (near the end of the `@php` block, around line 219):
```php
    $text = $labels[$locale] ?? $labels['nl'];
    $requestSlug = $locale === 'fr' ? 'demande' : ($locale === 'en' ? 'request' : 'aanvraag');
@endphp
```

Replace with:
```php
    $text = $labels[$locale] ?? $labels['nl'];
    $requestSlug = $locale === 'fr' ? 'demande' : ($locale === 'en' ? 'request' : 'aanvraag');
    $hexServices = $services->keyBy('key');
@endphp
```

- [ ] **Step 2: Wrap `.home-hero-content` in a `.home-hero-layout` div**

Find:
```blade
    <div class="container">
        <div class="home-hero-content">
```

Replace with:
```blade
    <div class="container">
        <div class="home-hero-layout">
        <div class="home-hero-content">
```

Find the closing tag of `.home-hero-content` (the `</div>` before `</div>` before `</section>`):
```blade
        </div>
    </div>
</section>
```

Replace with:
```blade
        </div>
        </div>{{-- end .home-hero-layout --}}
    </div>
</section>
```

---

### Task 2: Add hex cluster HTML to Blade

**Files:**
- Modify: `resources/views/pages/partials/home-page.blade.php`

- [ ] **Step 1: Insert the hex cluster between `.home-hero-content` closing tag and `.home-hero-layout` closing tag**

Find:
```blade
        </div>
        </div>{{-- end .home-hero-layout --}}
```

Replace with:
```blade
        </div>{{-- end .home-hero-content --}}

        <div class="hero-hex-cluster" aria-label="{{ $text['services_label'] }}">

            <div class="hero-hex-row">

                <a class="hero-hex hero-hex--water"
                   href="{{ route('pages.show', ['locale' => $locale, 'slug' => $hexServices['plumbing']['slug']]) }}"
                   aria-label="{{ $hexServices['plumbing']['title'] }}">
                    <span class="hero-hex-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg></span>
                    <span class="hero-hex-label">{{ $hexServices['plumbing']['title'] }}</span>
                </a>

                <a class="hero-hex hero-hex--heat"
                   href="{{ route('pages.show', ['locale' => $locale, 'slug' => $hexServices['heating']['slug']]) }}"
                   aria-label="{{ $hexServices['heating']['title'] }}">
                    <span class="hero-hex-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg></span>
                    <span class="hero-hex-label">{{ $hexServices['heating']['title'] }}</span>
                </a>

                <a class="hero-hex hero-hex--cool"
                   href="{{ route('pages.show', ['locale' => $locale, 'slug' => $hexServices['airco']['slug']]) }}"
                   aria-label="{{ $hexServices['airco']['title'] }}">
                    <span class="hero-hex-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2"/><path d="M9.6 4.6A2 2 0 1 1 11 8H2"/><path d="M12.6 19.4A2 2 0 1 0 14 16H2"/></svg></span>
                    <span class="hero-hex-label">{{ $hexServices['airco']['title'] }}</span>
                </a>

            </div>

            <div class="hero-hex-row">

                <a class="hero-hex hero-hex--vent"
                   href="{{ route('pages.show', ['locale' => $locale, 'slug' => $hexServices['ventilation']['slug']]) }}"
                   aria-label="{{ $hexServices['ventilation']['title'] }}">
                    <span class="hero-hex-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M21 2v6h-6"/><path d="M21 13a9 9 0 1 1-3-7.7L21 8"/></svg></span>
                    <span class="hero-hex-label">{{ $hexServices['ventilation']['title'] }}</span>
                </a>

                <a class="hero-hex hero-hex--water"
                   href="{{ route('pages.show', ['locale' => $locale, 'slug' => $hexServices['water-softeners']['slug']]) }}"
                   aria-label="{{ $hexServices['water-softeners']['title'] }}">
                    <span class="hero-hex-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 6.75 7 5.3c-.29 1.45-1.14 2.84-2.29 3.76S3 11.1 3 12.25c0 2.22 1.8 4.05 4 4.05z"/><path d="M12.56 6.6A10.97 10.97 0 0 0 14 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 0 1-11.91 4.97"/></svg></span>
                    <span class="hero-hex-label">{{ $hexServices['water-softeners']['title'] }}</span>
                </a>

                <a class="hero-hex hero-hex--icy"
                   href="{{ route('pages.show', ['locale' => $locale, 'slug' => $hexServices['cold-rooms']['slug']]) }}"
                   aria-label="{{ $hexServices['cold-rooms']['title'] }}">
                    <span class="hero-hex-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><line x1="12" y1="2" x2="12" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><path d="m20 16-4-4 4-4"/><path d="m4 8 4 4-4 4"/><path d="m16 4-4 4-4-4"/><path d="m8 20 4-4 4 4"/></svg></span>
                    <span class="hero-hex-label">{{ $hexServices['cold-rooms']['title'] }}</span>
                </a>

            </div>

        </div>{{-- end .hero-hex-cluster --}}

        </div>{{-- end .home-hero-layout --}}
```

---

### Task 3: Add hero layout and hex base CSS

**Files:**
- Modify: `resources/css/pages/home.css`

- [ ] **Step 1: Add `.home-hero-layout`, `.hero-hex-cluster`, `.hero-hex-row`, and `.hero-hex` base styles**

Find the line:
```css
.home-hero-content {
    max-width: 720px;
}
```

Insert the following block **before** that line:

```css
/* ================================
   Hero two-column layout
================================ */

.home-hero-layout {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 54px;
    align-items: center;
}

/* ================================
   Hero hex cluster
================================ */

.hero-hex-cluster {
    --hx-w: 110px;
    --hx-gap: 6px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin: 0 auto;
}

.hero-hex-row {
    display: flex;
    gap: var(--hx-gap);
}

.hero-hex-row + .hero-hex-row {
    margin-top: -32px;
    margin-left: 58px;
}

.hero-hex {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    width: var(--hx-w);
    height: 127px;
    clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
    color: #ffffff;
    text-decoration: none;
    transition: transform 0.18s ease, filter 0.18s ease;
    cursor: pointer;
    -webkit-clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
}

.hero-hex:focus-visible {
    outline: 3px solid #ffffff;
    outline-offset: 4px;
}

.hero-hex-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.hero-hex-icon svg {
    width: 26px;
    height: 26px;
}

.hero-hex-label {
    font-size: 0.72rem;
    font-weight: 800;
    line-height: 1.2;
    text-align: center;
    letter-spacing: 0.01em;
    padding: 0 8px;
}

```

---

### Task 4: Add hex color modifiers and hover/focus CSS

**Files:**
- Modify: `resources/css/pages/home.css`

- [ ] **Step 1: Insert color modifiers and hover rules immediately after the `.hero-hex-label` block from Task 3**

```css
/* ---- Color identities ---- */

.hero-hex--water { background: #0F66C2; }
.hero-hex--heat  { background: #E55A22; }
.hero-hex--cool  { background: #5A8FAD; }
.hero-hex--vent  { background: #7A96A8; }
.hero-hex--icy   { background: #3B7A99; }

/* ---- Hover: drop-shadow follows clip-path ---- */

.hero-hex:hover {
    transform: translateY(-4px);
}

.hero-hex--water:hover {
    filter: drop-shadow(0 6px 16px rgba(15, 102, 194, 0.55));
}

.hero-hex--heat:hover {
    filter: drop-shadow(0 6px 16px rgba(229, 90, 34, 0.55));
}

.hero-hex--cool:hover {
    filter: drop-shadow(0 6px 16px rgba(90, 143, 173, 0.55));
}

.hero-hex--vent:hover {
    filter: drop-shadow(0 6px 16px rgba(122, 150, 168, 0.50));
}

.hero-hex--icy:hover {
    filter: drop-shadow(0 6px 16px rgba(59, 122, 153, 0.55));
}

```

---

### Task 5: Add tablet and mobile responsive CSS

**Files:**
- Modify: `resources/css/pages/home.css`

- [ ] **Step 1: Add tablet override inside the existing `@media (max-width: 1100px)` block**

Find:
```css
@media (max-width: 1100px) {
    .service-grid {
```

Insert the following **before** `.service-grid`:

```css
    .home-hero-layout {
        grid-template-columns: 1fr;
        gap: 36px;
    }

    .hero-hex-cluster {
        align-self: center;
    }

    .hero-hex-cluster {
        --hx-w: 94px;
    }

    .hero-hex {
        height: 108px;
    }

    .hero-hex-row + .hero-hex-row {
        margin-top: -27px;
        margin-left: 50px;
    }

```

- [ ] **Step 2: Add mobile override inside the existing `@media (max-width: 680px)` block**

Find the `.home-hero` rule inside the mobile breakpoint:
```css
    .home-hero {
        padding: 48px 0 56px;
    }
```

Insert the following **after** it (but still inside the same `@media (max-width: 680px)` block):

```css
    .home-hero-layout {
        grid-template-columns: 1fr;
        gap: 28px;
    }

    .hero-hex-cluster {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
        width: 100%;
    }

    .hero-hex-row {
        display: contents;
    }

    .hero-hex-row + .hero-hex-row {
        margin: 0;
    }

    .hero-hex {
        width: 100%;
        height: 80px;
        clip-path: none;
        -webkit-clip-path: none;
        border-radius: 14px;
        flex-direction: row;
        gap: 10px;
        justify-content: flex-start;
        padding: 0 16px;
    }

    .hero-hex-icon svg {
        width: 22px;
        height: 22px;
    }

    .hero-hex-label {
        font-size: 0.82rem;
        text-align: left;
        padding: 0;
    }

```

---

### Task 6: Build and test

- [ ] **Step 1: Run Vite build**

```powershell
cd c:\Users\duisb\Documents\AWebsiteBuildingBusiness\website-martin
npm run build
```

Expected: Build completes cleanly, CSS asset grows by ~3–4 kB.
If it fails: Check for unclosed `}` in the newly added CSS blocks.

- [ ] **Step 2: Run PHP test suite**

```powershell
php artisan test
```

Expected: 2 passed, 3 assertions.

---

### Task 7: Inspect diff and commit

- [ ] **Step 1: Check diff**

```powershell
git diff HEAD resources/views/pages/partials/home-page.blade.php resources/css/pages/home.css
```

Verify: `hero-hex-cluster` present in blade with 6 `<a>` elements; `hero-hex` CSS rules in home.css; no unrelated changes.

- [ ] **Step 2: Stage and commit**

```powershell
git add resources/views/pages/partials/home-page.blade.php
git add resources/css/pages/home.css
git commit -m "style: add interactive service hexagon cluster to homepage hero"
```

---

## Self-Review

**Spec coverage:**
- ✅ `$hexServices` lookup → Task 1
- ✅ `.home-hero-layout` two-column grid → Tasks 1 + 3
- ✅ 6 hexagon `<a>` links (plumbing/heating/airco/ventilation/water-softeners/cold-rooms) → Task 2
- ✅ Locale-aware slugs via `$hexServices['key']['slug']` → Task 2
- ✅ Inline SVG icons for all 6 services → Task 2
- ✅ `aria-label` on every hexagon → Task 2
- ✅ Clip-path hex shape → Task 3
- ✅ `:focus-visible` outline → Task 3
- ✅ Color modifiers (water/heat/cool/vent/icy) → Task 4
- ✅ Hover `drop-shadow` + `translateY` → Task 4
- ✅ Tablet collapse to single column, smaller hex → Task 5
- ✅ Mobile 2-column grid, flat rounded cards, row-direction layout → Task 5
- ✅ Build → Task 6
- ✅ Commit → Task 7

**Placeholder scan:** None. All CSS values are explicit, all SVG paths are complete, all route calls are complete.

**Consistency check:** `hero-hex--water/heat/cool/vent/icy` defined in Task 4, applied in Task 2. `$hexServices['plumbing']` key matches `config/services.php` key `'plumbing'`. Tablet and mobile `--hx-w` and height values are consistent overrides. `.hero-hex-row + .hero-hex-row` margin overrides in mobile correctly reset to `0`.
