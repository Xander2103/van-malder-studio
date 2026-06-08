# Mastechnics Heat Accent Polish — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Strengthen the warm red/orange heat accent on the Mastechnics homepage so Verwarming/heating is visually distinct from other services, while keeping blue dominant everywhere else.

**Architecture:** Pure CSS changes to `home.css` (6 targeted modifications) plus one conditional class added to the Blade template. No PHP logic, no translations, no other files touched. The modifier pattern `.service-chip--heat` / `.service-card--heat` mirrors the pattern introduced in the previous palette commit.

**Tech Stack:** Laravel 12, Blade templates, custom CSS, Vite (`npm run build`), PHPUnit (`php artisan test`).

---

## File Map

| File | What changes |
|---|---|
| `resources/css/pages/home.css` | 6 edits: hero glow values, chip-level warm accent, chip icon strengthened, chip hover, card heat modifier, why-card top border |
| `resources/views/pages/partials/home-page.blade.php` | 1 line: conditional `service-card--heat` class in the service card loop |

---

### Task 1: Strengthen hero heat glow

**Files:**
- Modify: `resources/css/pages/home.css` (lines 812–823)

Current state:
```css
background: radial-gradient(
    circle,
    rgba(255, 122, 69, 0.32) 0%,
    rgba(255, 122, 69, 0.09) 45%,
    transparent              70%
);

@keyframes heatPulse {
    0%, 100% { opacity: 0.45; transform: scale(0.93); }
    50%       { opacity: 1.00; transform: scale(1.05); }
}
```

- [ ] **Step 1: Update the radial gradient values inside `.hero-env-heat::before`**

Replace the `background: radial-gradient(...)` block:

```css
    background: radial-gradient(
        circle,
        rgba(255, 122, 69, 0.50) 0%,
        rgba(255, 122, 69, 0.15) 45%,
        transparent              70%
    );
```

- [ ] **Step 2: Update the `heatPulse` keyframes minimum opacity**

Replace the `@keyframes heatPulse` block:

```css
@keyframes heatPulse {
    0%, 100% { opacity: 0.62; transform: scale(0.93); }
    50%       { opacity: 1.00; transform: scale(1.05); }
}
```

---

### Task 2: Add chip-level warm accent for Verwarming chip

**Files:**
- Modify: `resources/css/pages/home.css` (after line 141, before `.service-chip-name`)

Currently `.service-chip--heat` has no chip-level rule — only `.service-chip--heat .service-chip-icon` exists.

- [ ] **Step 1: Add `.service-chip--heat` rule immediately before the existing `.service-chip--heat .service-chip-icon` block (line 136)**

Insert this new rule:

```css
.service-chip--heat {
    border-color: rgba(255, 122, 69, 0.35);
    background: rgba(255, 122, 69, 0.05);
    box-shadow: 0 4px 14px rgba(255, 122, 69, 0.14);
}
```

- [ ] **Step 2: Update `.service-chip--heat .service-chip-icon` gradient (line 136–141)**

Replace the existing block:

```css
.service-chip--heat .service-chip-icon {
    background: linear-gradient(135deg,
        rgba(255, 122, 69, 0.20),
        rgba(255, 122, 69, 0.10));
    color: var(--color-accent-heat);
}
```

- [ ] **Step 3: Add `.service-chip--heat:hover` rule immediately after the icon block**

Insert:

```css
.service-chip--heat:hover {
    border-color: rgba(255, 122, 69, 0.55);
    box-shadow: 0 8px 20px rgba(255, 122, 69, 0.22);
}
```

---

### Task 3: Add Verwarming service card warm accent

**Files:**
- Modify: `resources/css/pages/home.css` (after `.service-card span`, around line 234)

- [ ] **Step 1: Add `.service-card--heat` and its hover rule after `.service-card span`**

Insert these two rules immediately after the closing `}` of `.service-card span`:

```css
.service-card--heat {
    border-color: rgba(255, 122, 69, 0.30);
    box-shadow: 0 14px 34px rgba(255, 122, 69, 0.08);
}

.service-card--heat:hover {
    border-color: rgba(255, 122, 69, 0.50);
    box-shadow: 0 22px 46px rgba(255, 122, 69, 0.14);
}
```

---

### Task 4: Add warm top-border accent to first why-card

**Files:**
- Modify: `resources/css/pages/home.css` (after `.why-card p`, around line 597)

- [ ] **Step 1: Add `.why-card:first-child` rule immediately after `.why-card p { ... }`**

Insert:

```css
.why-card:first-child {
    border-top: 2px solid rgba(255, 122, 69, 0.45);
}
```

---

### Task 5: Add `service-card--heat` class to heating card in blade

**Files:**
- Modify: `resources/views/pages/partials/home-page.blade.php` (around line 331)

Current state (line 331):
```blade
                    class="service-card service-card-link"
```

- [ ] **Step 1: Add conditional class**

Replace that line with:

```blade
                    class="service-card service-card-link {{ $service['key'] === 'heating' ? 'service-card--heat' : '' }}"
```

Full context after change:
```blade
            @foreach ($services as $service)
                <a
                    class="service-card service-card-link {{ $service['key'] === 'heating' ? 'service-card--heat' : '' }}"
                    href="{{ route('pages.show', [
                        'locale' => $locale,
                        'slug' => $service['slug'],
                    ]) }}"
                >
```

---

### Task 6: Build and test

- [ ] **Step 1: Run Vite build**

```powershell
cd c:\Users\duisb\Documents\AWebsiteBuildingBusiness\website-martin
npm run build
```

Expected: Builds cleanly with no errors. Output shows CSS asset compiled.
If it fails: check for a missing closing `}` or misplaced rule in `home.css`.

- [ ] **Step 2: Run PHP test suite**

```powershell
php artisan test
```

Expected: All tests pass (2 passed, 3 assertions — these are CSS-only changes so failures indicate a pre-existing issue).

---

### Task 7: Commit

- [ ] **Step 1: Stage both changed files**

```powershell
git add resources/css/pages/home.css
git add resources/views/pages/partials/home-page.blade.php
```

- [ ] **Step 2: Commit**

```powershell
git commit -m "style: strengthen visible heat accent in mastechnics palette"
```

---

## Self-Review

**Spec coverage:**
- ✅ Hero heat glow stronger → Task 1
- ✅ Heating chip: chip-level border/bg/shadow → Task 2 step 1
- ✅ Heating chip: icon strengthened → Task 2 step 2
- ✅ Heating chip: warm hover → Task 2 step 3
- ✅ Heating service card warm accent → Task 3
- ✅ First why-card warm top border → Task 4
- ✅ Blade conditional class for card → Task 5
- ✅ Build + test → Task 6
- ✅ Commit → Task 7

**Placeholder scan:** None. All steps contain exact CSS and blade code.

**Consistency check:** `service-card--heat` used in Task 3 (CSS) and Task 5 (blade) — consistent. `rgba(255, 122, 69, ...)` values consistent with `--color-accent-heat: #FF7A45` = `rgb(255,122,69)`.
