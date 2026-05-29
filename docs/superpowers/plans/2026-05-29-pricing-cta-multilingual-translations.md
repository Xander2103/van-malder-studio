# Pricing, CTA & Multilingual Translation Refinements — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fix 19 content/translation issues across Van Malder Studio — pricing card accuracy, raw translation keys, missing FR/EN/DE translations, hardcoded Dutch text on all pages, and incorrect tech-tag claims.

**Architecture:** All translations live in `lang/{locale}/site.php` (one flat file per locale). Blade templates reference them via `__('site.section.key')`. No new files or packages. No route changes. No backend logic changes.

**Tech Stack:** Laravel Blade, Tailwind CSS, vanilla JS, PHP 8.x translation helpers.

---

## File Map

| File | Action |
|---|---|
| `lang/nl/site.php` | Update pricing card, process steps (→7), add mockup/add-on keys |
| `lang/fr/site.php` | Add all missing keys + new FR translations |
| `lang/en/site.php` | Add all missing keys + new EN translations |
| `lang/de/site.php` | Add all missing keys + new DE translations |
| `config/projects.php` | Fix tech tags; add `status_key` stable field per project |
| `resources/views/pages/about.blade.php` | Replace all hardcoded Dutch with `__('site.about.*')` |
| `resources/views/pages/process.blade.php` | Replace all hardcoded Dutch with `__('site.process.*')` |
| `resources/views/pages/showcase.blade.php` | Replace all hardcoded Dutch with `__('site.showcase.*')` |
| `resources/views/components/footer.blade.php` | Replace `config('studio.positioning')` with `__('site.footer.description')` |

---

## New/Updated Translation Keys Required

### site.pricing (all 4 locales)
- `vat_note` — missing in FR/EN/DE
- `card_webshop_title` — rename to "Productcatalogus" (NL) / locale equivalents
- `card_webshop_desc` — updated copy that doesn't overpromise full webshop
- `card_webshop_bullets` — 5 bullets (catalogue price, simple webshop, payment options, SEO, price depends)
- `card_webshop_cta` — "Bespreek je productcatalogus" (NL) / locale equivalents
- `addons_items` — add/update: SEO landing page, extra language, smart flow, AI quote prep

### site.home (FR/EN/DE only — NL already has these)
- `service_forms_ai_note`
- `service_forms_cta`
- `pricing_vat_note`

### site.mockup (new section, all 4 locales)
- `heading` — "Gratis eerste mockup na kennismaking" / locale equivalents
- `body` — multiline copy
- `cta` — button label
- `note` — "Na een korte kennismaking, geen verplichting." / locale equivalents

### site.process (all 4 locales)
- `heading_full` — detailed h1
- `intro` — new detailed intro paragraph  
- `steps` — expand from 5 to 7 detailed steps with full desc
- `expects_heading` — "Wat je kan verwachten" / locale
- `expects_items` — 6 items array
- `cta_heading` — "Klaar om te starten?" / locale
- `cta_body` — "Vertel me over je project..." / locale
- `cta_btn` — "Neem contact op" / locale

### site.showcase (all 4 locales)
- `card_hero_aria` — aria-label for card 1 link
- `card_scroll_play` — play button text
- `card_scroll_aria` — aria-label for section tabs group
- `card_scroll_tabs` — already exists, ensure all locales present
- `card_scroll_captions` — already exists, ensure all locales present
- `card_cf_choice_label` — "Wat heb je nodig?" / locale
- `card_cf_choice_keuze` — "Keuze:" / locale
- `card_cf_checklist_heading` — "Wat wordt gevraagd?" / locale
- `card_cf_validation` — "Kies een optie..." / locale
- `card_cf_result_heading` — "Resultaat:" / locale
- `card_cf_ai_note` — AI note on card 4 / locale
- `card_cf_cta` — link text on card 4
- `scroll_preview_options` — 5 option labels (new website, redesign, catalogue, smart flow, maintenance)
- Link preview translations (studio intro, contact form, services, about)
- CTA section: `cta_heading`, `cta_body`, `cta_primary`, `cta_secondary` — already exist, ensure FR/EN/DE present

### site.about (all 4 locales)
- `body_1–4` — update NL to new approved copy; ensure FR/EN/DE updated
- `tech_groups` — array of group labels (Frontend, Backend, CMS & tools, etc.)
- `status` — sub-keys: `live`, `prototype`, `in-development` for badge display
- `vm_studios_body` — updated NL copy

### site.footer (all 4 locales)
- `description` — positioned text (was in config/studio.php as `positioning`)

### site.projects.{slug} (FR/EN/DE only — NL uses config data)
For each slug: `van-malder-studio`, `killer-darts`, `smart-card-mat`, `chains-of-glory`, `the-bar-game`
Keys: `category`, `type`, `label`, `description`, `proves`, `status_label`

---

## config/projects.php Changes

- Add `status_key` field: `'live'`, `'prototype'`, `'in-development'`  
- Fix `technologies` arrays:
  - Van Malder Studio: `['Laravel', 'Blade', 'Tailwind CSS', 'JavaScript', 'PHP', 'SEO', 'UX']`
  - Killer Darts: `['JavaScript', 'HTML', 'CSS', 'Capacitor', 'Android', 'UI/UX']`
  - Smart Card Mat: `['React', 'Laravel', 'ESP32', 'NFC/RFID', 'BLE', 'JavaScript', 'Hardware prototyping']` (remove `Arduino`)
  - Chains of Glory: `['Unreal Engine', 'Blueprints', 'Blender', 'Substance Painter', 'Game design']` (remove `C++`)
  - TheBarGame: `['Unreal Engine', 'Blueprints', 'Blender', 'Substance Painter', 'Game design']` (remove `C++`, `Multiplayer`)

---

## about.blade.php Changes

- `title`, `description`, `ogTitle` → use `__('site.seo.about_title')` etc.
- Eyebrow, h1, subtitle → `__('site.about.eyebrow')`, `__('site.about.heading')`, `__('site.about.subtitle')`
- Body paragraphs → `__('site.about.body_1')` through `body_4`
- Buttons → `__('site.about.cta_contact')`, `__('site.about.cta_showcase')`
- Tech card heading → `__('site.about.tech_heading')`
- Tech groups → loop over `__('site.about.tech_groups')`
- Focus areas heading → `__('site.about.focus_heading')`
- Focus items → `__('site.about.focus_items')`
- VM Studios section text → existing keys `vm_studios_eyebrow`, `vm_studios_heading`, `vm_studios_body`
- Project sidebar heading → `__('site.about.projects_heading')`
- Project status display → `__('site.about.status.' . $project['status_key'])`
- Project badge match → `match($project['status_key'])`
- Project cards → `__('site.projects.' . $project['slug'])` with config fallback for NL
- "Wat het aantoont" / "Technologieën" labels → `__('site.about.project_proves')`, `__('site.about.project_tech')`

---

## process.blade.php Changes

- `title`, `description`, `ogTitle` → `__('site.seo.process_title')` etc.
- Eyebrow → `__('site.process.eyebrow')`
- h1 → `__('site.process.heading_full')`  
- Intro → `__('site.process.intro')`
- Steps loop → `__('site.process.steps')`
- Sidebar heading → `__('site.process.expects_heading')`
- Sidebar items → `__('site.process.expects_items')`
- CTA heading/body/button → `__('site.process.cta_heading')`, `__('site.process.cta_body')`, `__('site.process.cta_btn')`
- Contact route → already locale-aware

---

## showcase.blade.php Changes

- `title`, `description`, `ogTitle` → `__('site.seo.showcase_title')` etc.
- All visible Dutch text → corresponding `__('site.showcase.*')` keys
- Interactive button labels in Card 2 (Hover/Actief/Disabled) are functional UI state labels — these can stay in English (universal) or be translated via new keys
- Scroll preview tabs/captions → already exist as `__('site.showcase.scroll_tabs.*')` and `__('site.showcase.scroll_captions.*')`  
- Card 4 option labels → new keys `site.showcase.cf_options`
- Card 4 labels ("Keuze:", "Wat wordt gevraagd?", etc.) → new `site.showcase.cf_*` keys
- CTA → `__('site.showcase.cta_heading')` etc. — keys already exist

---

## footer.blade.php Changes

- Replace `config('studio.positioning')` with `__('site.footer.description') ?: config('studio.positioning')`
