# Mastechnics Color Palette Refinement — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Refine the Mastechnics website color palette so blue stays dominant, warm red/orange (#FF7A45, #E5473F) appears as a subtle accent in exactly four surfaces (hero heat glow, heating service chip, admin urgency badges, request urgent warning box), and all grey/white backgrounds become slightly cleaner.

**Architecture:** All changes are CSS variable updates and targeted selector overrides. One blade template line adds a conditional CSS modifier class for the heating chip. No PHP logic, no database, no translations, no JS changes.

**Tech Stack:** Laravel 12, Blade templates, custom CSS (no Tailwind config), Vite build (`npm run build`), PHPUnit (`php artisan test`).

---

## File Map

| File | What changes |
|---|---|
| `resources/css/base/variables.css` | 5 existing variable values updated; 2 new accent variables added; shadow rgba updated |
| `resources/css/pages/home.css` | Hero heat glow rgba values; new `.service-chip--heat .service-chip-icon` rule |
| `resources/views/pages/partials/home-page.blade.php` | Conditional `service-chip--heat` class on heating chip (1 line) |
| `resources/css/pages/admin.css` | 3 urgency/status badge selectors: bg + color |
| `resources/css/pages/request.css` | `.urgent-warning-box` border-color + color |

**Not touched:** `buttons.css`, `cards.css`, `service.css`, `contact.css`, `header.css`, `footer.css`, all PHP files.

---

### Task 1: Update CSS variables

**Files:**
- Modify: `resources/css/base/variables.css`

- [ ] **Step 1: Replace the full `:root` block**

Open `resources/css/base/variables.css`. Replace the entire file content with:

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

    --container-width: 1120px;
    --container-padding: 32px;

    --radius-small: 12px;
    --radius-medium: 22px;
    --radius-large: 30px;

    --shadow-soft: 0 18px 38px rgba(9, 36, 63, 0.09);
    --shadow-strong: 0 24px 60px rgba(9, 36, 63, 0.12);
}
```

Changes vs current:
- `--color-primary-dark`: `#0f3557` → `#09243F`
- `--color-text`: `#13202f` → `#09243F`
- `--color-muted`: `#596b7d` → `#5B6B7A`
- `--color-border`: `#e0e7f0` → `#D9E1EA`
- `--color-background`: `#f6f8fb` → `#F5F7FA`
- New: `--color-accent-heat: #FF7A45`
- New: `--color-accent-urgent: #E5473F`
- Shadow rgba updated from `(15, 53, 87, ...)` to `(9, 36, 63, ...)` to match new dark navy

---

### Task 2: Update hero heat glow in home.css

**Files:**
- Modify: `resources/css/pages/home.css` (around line 805–810)

- [ ] **Step 1: Find the `.hero-env-heat::before` radial gradient**

Locate this block (around line 800):

```css
.hero-env-heat::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background: radial-gradient(
        circle,
        rgba(251, 146, 60, 0.32) 0%,
        rgba(251, 146, 60, 0.09) 45%,
        transparent              70%
    );
    animation: heatPulse 7s ease-in-out 1.5s infinite both;
}
```

- [ ] **Step 2: Replace the two rgba values**

Change only the two rgba lines. `#FF7A45` = `rgb(255, 122, 69)`:

```css
.hero-env-heat::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background: radial-gradient(
        circle,
        rgba(255, 122, 69, 0.32) 0%,
        rgba(255, 122, 69, 0.09) 45%,
        transparent              70%
    );
    animation: heatPulse 7s ease-in-out 1.5s infinite both;
}
```

Everything else in the block stays identical.

---

### Task 3: Add heating service chip accent rule in home.css

**Files:**
- Modify: `resources/css/pages/home.css` (add rule after `.service-chip-icon` block, around line 129)

- [ ] **Step 1: Find the `.service-chip-icon` block**

Locate:

```css
.service-chip-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
    color: var(--color-primary);
    flex-shrink: 0;
}
```

- [ ] **Step 2: Add the heating modifier rule immediately after**

Insert this new rule directly after the closing `}` of `.service-chip-icon`:

```css
.service-chip--heat .service-chip-icon {
    background: linear-gradient(135deg,
        rgba(255, 122, 69, 0.12),
        rgba(255, 122, 69, 0.06));
    color: var(--color-accent-heat);
}
```

This overrides only the icon background and stroke color for the heating chip. All other chips keep the blue gradient.

---

### Task 4: Add service-chip--heat class to heating chip in blade

**Files:**
- Modify: `resources/views/pages/partials/home-page.blade.php` (around line 299–300)

- [ ] **Step 1: Find the service chip loop**

Locate this block (around line 297):

```blade
@foreach ($services as $service)
    <a
        class="service-chip"
        href="{{ route('pages.show', [
            'locale' => $locale,
            'slug' => $service['slug'],
        ]) }}"
    >
```

- [ ] **Step 2: Add the conditional class**

Replace the `class="service-chip"` attribute with:

```blade
class="service-chip {{ $service['key'] === 'heating' ? 'service-chip--heat' : '' }}"
```

Full updated block:

```blade
@foreach ($services as $service)
    <a
        class="service-chip {{ $service['key'] === 'heating' ? 'service-chip--heat' : '' }}"
        href="{{ route('pages.show', [
            'locale' => $locale,
            'slug' => $service['slug'],
        ]) }}"
    >
```

No logic change. No language impact. The `heating` key comes from `config/services.php`.

---

### Task 5: Update urgency badge colors in admin.css

**Files:**
- Modify: `resources/css/pages/admin.css` (around lines 286–309)

- [ ] **Step 1: Find the three urgent/red badge selectors**

Locate these three blocks:

```css
.admin-status-cancelled {
    background: #fee2e2;
    color: #991b1b;
}

.admin-urgency-urgent {
    background: #fee2e2;
    color: #991b1b;
}

.admin-urgency-water_leaking {
    background: #fee2e2;
    color: #7f1d1d;
    font-weight: 900;
}
```

- [ ] **Step 2: Update all three**

Replace with:

```css
.admin-status-cancelled {
    background: rgba(229, 71, 63, 0.10);
    color: #B52A24;
}

.admin-urgency-urgent {
    background: rgba(229, 71, 63, 0.10);
    color: #B52A24;
}

.admin-urgency-water_leaking {
    background: rgba(229, 71, 63, 0.10);
    color: #B52A24;
    font-weight: 900;
}
```

`#B52A24` is a darkened version of `--color-accent-urgent` (#E5473F) that passes WCAG AA contrast (ratio ≥ 4.5:1) on the light `rgba(229, 71, 63, 0.10)` background. `font-weight: 900` on `water_leaking` is preserved unchanged.

All green/amber/blue status badges (`.admin-status-new`, `.admin-status-contacted`, `.admin-status-planned`, `.admin-status-done`, `.admin-urgency-within_days`, `.admin-urgency-not_urgent`) are not touched.

---

### Task 6: Update urgent warning box in request.css

**Files:**
- Modify: `resources/css/pages/request.css` (around line 184–197)

- [ ] **Step 1: Find `.urgent-warning-box`**

Locate:

```css
.urgent-warning-box {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px 20px;
    border: 1.5px solid rgba(220, 38, 38, 0.35);
    border-radius: 16px;
    background: #fff1f2;
    color: #991b1b;
    font-size: 0.95rem;
    font-weight: 700;
    line-height: 1.5;
}
```

- [ ] **Step 2: Update border and color only**

Replace with:

```css
.urgent-warning-box {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px 20px;
    border: 1.5px solid rgba(229, 71, 63, 0.35);
    border-radius: 16px;
    background: #fff1f2;
    color: #B52A24;
    font-size: 0.95rem;
    font-weight: 700;
    line-height: 1.5;
}
```

Only `border` rgba and `color` change. Background `#fff1f2` stays (virtually identical visually). Layout, padding, font properties untouched.

Note: Form validation colors (`#dc2626`, `#ef4444` on `.required-star`, `.field-has-error`, `.upload-box.field-has-error`) are **not changed** — those are standard validation conventions, not brand accent colors.

---

### Task 7: Build and test

- [ ] **Step 1: Run the Vite build**

```powershell
cd c:\Users\duisb\Documents\AWebsiteBuildingBusiness\website-martin
npm run build
```

Expected: Build completes with no errors. Output shows CSS assets compiled.
If build fails: Check for CSS syntax errors in the files just edited.

- [ ] **Step 2: Run the PHP test suite**

```powershell
php artisan test
```

Expected: All tests pass. No failures.
If tests fail: The changes are CSS-only — a PHP test failure is unrelated to this task. Check whether there are pre-existing failures on `main` before investigating.

---

### Task 8: Commit

- [ ] **Step 1: Stage the 5 changed files**

```powershell
git add resources/css/base/variables.css
git add resources/css/pages/home.css
git add resources/views/pages/partials/home-page.blade.php
git add resources/css/pages/admin.css
git add resources/css/pages/request.css
```

- [ ] **Step 2: Commit**

```powershell
git commit -m "style: refine mastechnics color palette"
```

---

## Self-Review

**Spec coverage:**
- ✅ variables.css: 5 updates + 2 new accent variables + shadow rgba → Task 1
- ✅ Hero heat glow replaced → Task 2
- ✅ Heating chip warm accent (CSS + blade class) → Tasks 3 & 4
- ✅ Admin urgency/cancelled badges → Task 5
- ✅ Request urgent warning box → Task 6
- ✅ CTA hover not changed → explicitly excluded in Task 2/3 scope
- ✅ Build + test → Task 7
- ✅ Commit → Task 8

**Placeholder scan:** None found. All steps contain exact code.

**Type consistency:** No function signatures. CSS selectors are consistent across tasks (`.service-chip--heat`, `.admin-urgency-urgent`, `.urgent-warning-box`). `#B52A24` and `rgba(229, 71, 63, ...)` used consistently in Tasks 5 and 6.
