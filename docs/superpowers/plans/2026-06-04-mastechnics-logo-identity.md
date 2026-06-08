# MAS Technics Logo Identity Alignment — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the plain text header with the real MAS Technics logo image and complete the 3-color service identity (orange-red heat / cool grey-blue cooling / default blue water) matching the logo's three hexagons.

**Architecture:** All changes are CSS variable additions, CSS rule additions, one Blade template image swap, and two conditional class additions in Blade loops. No PHP logic, no DB, no translations. The logo image already exists at `public/assets/images/Logo.webp`.

**Tech Stack:** Laravel 12, Blade templates, custom CSS (no Tailwind config), Vite (`npm run build`), PHPUnit (`php artisan test`).

---

## File Map

| File | What changes |
|---|---|
| `resources/css/base/variables.css` | Add `--color-accent-cool: #7A9EBB` |
| `resources/views/layouts/app.blade.php` | Replace text logo with `<img>` tag |
| `resources/css/layout/header.css` | Add `.site-logo-img` sizing rule |
| `resources/css/pages/home.css` | Add `.service-chip--cool` + `.service-card--cool` rules (after existing heat rules) |
| `resources/views/pages/partials/home-page.blade.php` | Add `service-chip--cool` / `service-card--cool` condition in both loops |

---

### Task 1: Add cool accent variable

**Files:**
- Modify: `resources/css/base/variables.css`

Current state of the file:
```css
:root {
    --color-primary: #0f66c2;
    --color-primary-dark: #09243F;
    --color-text: #09243F;
    --color-muted: #5B6B7A;
    --color-border: #D9E1EA;
    --color-background: #F5F7FA;
    --color-white: #ffffff;
    --color-accent-heat: #FF7A45;
    --color-accent-urgent: #E5473F;
    ...
}
```

- [ ] **Step 1: Add `--color-accent-cool` on the line after `--color-accent-urgent`**

The `:root` block becomes:

```css
:root {
    --color-primary: #0f66c2;
    --color-primary-dark: #09243F;
    --color-text: #09243F;
    --color-muted: #5B6B7A;
    --color-border: #D9E1EA;
    --color-background: #F5F7FA;
    --color-white: #ffffff;
    --color-accent-heat: #FF7A45;
    --color-accent-urgent: #E5473F;
    --color-accent-cool: #7A9EBB;

    --container-width: 1120px;
    --container-padding: 32px;

    --radius-small: 12px;
    --radius-medium: 22px;
    --radius-large: 30px;

    --shadow-soft: 0 18px 38px rgba(9, 36, 63, 0.09);
    --shadow-strong: 0 24px 60px rgba(9, 36, 63, 0.12);
}
```

`#7A9EBB` = `rgb(122, 158, 187)` — desaturated cool blue-grey matching the grey snowflake hexagon in the logo.

---

### Task 2: Swap text logo for image in header

**Files:**
- Modify: `resources/views/layouts/app.blade.php` (around line 132–134)

Current state:
```blade
<a class="site-logo" href="{{ route('pages.home', ['locale' => $locale ?? 'nl']) }}">
    {{ config('site.name') }}
</a>
```

- [ ] **Step 1: Replace the text content with the logo image**

```blade
<a class="site-logo" href="{{ route('pages.home', ['locale' => $locale ?? 'nl']) }}">
    <img
        src="{{ asset('assets/images/Logo.webp') }}"
        alt="MAS Technics"
        class="site-logo-img"
        width="176"
        height="44"
    >
</a>
```

`width="176" height="44"` matches the ~4:1 aspect ratio of Logo.webp and prevents layout shift (CLS). The actual display size is controlled by CSS `max-height`, not these HTML attributes.

---

### Task 3: Add logo image sizing to header CSS

**Files:**
- Modify: `resources/css/layout/header.css`

- [ ] **Step 1: Add `.site-logo-img` sizing rules at the end of the desktop section (before the `@media (max-width: 680px)` block)**

Find this block near the bottom of the desktop styles:
```css
.language-switcher a {
    width: 36px;
    height: 36px;
    ...
}

.mobile-menu-toggle {
    display: none;
}
```

Insert immediately after the `.language-switcher a` closing `}`, before `.mobile-menu-toggle`:

```css
.site-logo-img {
    display: block;
    max-height: 40px;
    width: auto;
}
```

- [ ] **Step 2: Add the mobile override inside the existing `@media (max-width: 680px)` block**

Inside the `@media (max-width: 680px)` block, find the existing mobile `.site-logo, .brand` rule:
```css
.site-logo,
.brand {
    font-size: 1.35rem;
}
```

Add this rule immediately after it:
```css
.site-logo-img {
    max-height: 36px;
}
```

---

### Task 4: Add cooling service chip and card CSS

**Files:**
- Modify: `resources/css/pages/home.css`

**A — Chip rules** (insert after `.service-chip--heat:hover` which ends at line 152, before `.service-chip-name` at line 154):

- [ ] **Step 1: Add `.service-chip--cool` rules immediately after `.service-chip--heat:hover { ... }`**

```css
.service-chip--cool {
    border-color: rgba(122, 158, 187, 0.35);
    background: rgba(122, 158, 187, 0.05);
    box-shadow: 0 4px 14px rgba(122, 158, 187, 0.12);
}

.service-chip--cool .service-chip-icon {
    background: linear-gradient(135deg,
        rgba(122, 158, 187, 0.20),
        rgba(122, 158, 187, 0.10));
    color: var(--color-accent-cool);
}

.service-chip--cool:hover {
    border-color: rgba(122, 158, 187, 0.55);
    box-shadow: 0 8px 20px rgba(122, 158, 187, 0.18);
}
```

Opacities are intentionally lower than the heat accent — the logo's grey hexagon is less dominant than the orange-red one.

**B — Card rules** (insert after `.service-card--heat:hover` which ends at line 255, before the `/* Smart intake process */` comment):

- [ ] **Step 2: Add `.service-card--cool` rules immediately after `.service-card--heat:hover { ... }`**

```css
.service-card--cool {
    border-color: rgba(122, 158, 187, 0.30);
    box-shadow: 0 14px 34px rgba(122, 158, 187, 0.07);
}

.service-card--cool:hover {
    border-color: rgba(122, 158, 187, 0.50);
    box-shadow: 0 22px 46px rgba(122, 158, 187, 0.12);
}
```

---

### Task 5: Add cool conditional classes in Blade loops

**Files:**
- Modify: `resources/views/pages/partials/home-page.blade.php`

**A — Service chip loop** (around line 300):

Current state:
```blade
class="service-chip {{ $service['key'] === 'heating' ? 'service-chip--heat' : '' }}"
```

- [ ] **Step 1: Add the cool condition as a second expression on the class attribute**

```blade
class="service-chip {{ $service['key'] === 'heating' ? 'service-chip--heat' : '' }} {{ in_array($service['key'], ['airco', 'cold-rooms']) ? 'service-chip--cool' : '' }}"
```

Full `<a>` tag context:
```blade
                        <a
                            class="service-chip {{ $service['key'] === 'heating' ? 'service-chip--heat' : '' }} {{ in_array($service['key'], ['airco', 'cold-rooms']) ? 'service-chip--cool' : '' }}"
                            href="{{ route('pages.show', [
                                'locale' => $locale,
                                'slug' => $service['slug'],
                            ]) }}"
                        >
```

**B — Service card loop** (around line 331):

Current state:
```blade
class="service-card service-card-link {{ $service['key'] === 'heating' ? 'service-card--heat' : '' }}"
```

- [ ] **Step 2: Add the cool condition as a second expression**

```blade
class="service-card service-card-link {{ $service['key'] === 'heating' ? 'service-card--heat' : '' }} {{ in_array($service['key'], ['airco', 'cold-rooms']) ? 'service-card--cool' : '' }}"
```

Full `<a>` tag context:
```blade
                <a
                    class="service-card service-card-link {{ $service['key'] === 'heating' ? 'service-card--heat' : '' }} {{ in_array($service['key'], ['airco', 'cold-rooms']) ? 'service-card--cool' : '' }}"
                    href="{{ route('pages.show', [
                        'locale' => $locale,
                        'slug' => $service['slug'],
                    ]) }}"
                >
```

Service keys `plumbing`, `water-softeners`, `ventilation` produce `''` for both conditions — they render with no modifier class, keeping the default blue treatment.

---

### Task 6: Build and test

- [ ] **Step 1: Run the Vite build**

```powershell
cd c:\Users\duisb\Documents\AWebsiteBuildingBusiness\website-martin
npm run build
```

Expected: Build completes cleanly. CSS asset size increases slightly (new rules added).
If it fails: Check for a missing `}` in `home.css` or `header.css`.

- [ ] **Step 2: Run the PHP test suite**

```powershell
php artisan test
```

Expected: 2 passed, 3 assertions. These are CSS/Blade-only changes; PHP test failures indicate a pre-existing issue unrelated to this sprint.

---

### Task 7: Inspect diff and commit

- [ ] **Step 1: Inspect the diff**

```powershell
git diff HEAD resources/views/layouts/app.blade.php resources/css/layout/header.css resources/css/base/variables.css resources/css/pages/home.css resources/views/pages/partials/home-page.blade.php
```

Verify: logo image tag in `app.blade.php`, sizing rule in `header.css`, `--color-accent-cool` in `variables.css`, cool chip/card rules in `home.css`, cool conditionals in `home-page.blade.php`. No other files changed.

- [ ] **Step 2: Stage the 5 changed files**

```powershell
git add resources/views/layouts/app.blade.php
git add resources/css/layout/header.css
git add resources/css/base/variables.css
git add resources/css/pages/home.css
git add resources/views/pages/partials/home-page.blade.php
```

- [ ] **Step 3: Commit**

```powershell
git commit -m "style: align public site with MAS Technics logo identity"
```

---

## Self-Review

**Spec coverage:**
- ✅ `Logo.webp` in header → Task 2
- ✅ `logoMetTekst.webp` not used → not referenced anywhere
- ✅ Logo sizing desktop 40px, mobile 36px → Task 3
- ✅ Alt text "MAS Technics" → Task 2
- ✅ Aspect ratio preserved (`width: auto`) → Task 3
- ✅ `--color-accent-cool: #7A9EBB` → Task 1
- ✅ `.service-chip--cool` / `.service-card--cool` for `airco` + `cold-rooms` → Tasks 4 & 5
- ✅ `plumbing`, `water-softeners`, `ventilation` stay default → Task 5 (no modifier applied)
- ✅ Build → Task 6 step 1
- ✅ Test → Task 6 step 2
- ✅ Diff inspect → Task 7 step 1
- ✅ Commit message → Task 7 step 3

**Placeholder scan:** None. All steps contain exact code, exact commands, exact expected output.

**Consistency check:** `service-chip--cool` used in Task 4 (CSS) and Task 5 (Blade) — consistent. `service-card--cool` consistent across Task 4 and Task 5. `rgba(122, 158, 187, ...)` matches `#7A9EBB` = `rgb(122,158,187)` throughout.
