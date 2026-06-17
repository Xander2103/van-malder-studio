# Homepage CRO Sharpening — Van Malder Studio

## Project Context

Laravel 11 multilingual website for Van Malder Studio (Xander Van Malder, webdesigner in Tervuren, Vlaams-Brabant).

**Brand positioning:**
- Premium, local, personal, calm, trustworthy, conversion-focused
- NOT aggressive / black-yellow / ad-style
- Target: zelfstandigen and local businesses in Tervuren, Druivenstreek, Vlaams-Brabant
- Pricing: vanaf €750
- USP: direct contact with Xander, no intermediaries

**Current hero structure (3-item CSS grid on home.blade.php):**
- Div 1: text-top (eyebrow, h1, body_mobile/body/byline)
- Div 2: studio card with lg:row-span-2
- Div 3: CTAs + trustline

**Files:**
- `resources/views/pages/home.blade.php`
- `resources/views/pages/about.blade.php`
- `lang/nl/site.php`, `lang/fr/site.php`, `lang/en/site.php`, `lang/de/site.php`

## Global Constraints

- Do NOT break: multilingual routes, canonical/hreflang, contact forms, quick contact security, project request form, sitemap, SEO landing pages, existing tests
- Do NOT add fake reviews, fake client logos, fake ratings or fake claims
- Do NOT add unnecessary packages
- Do NOT redesign from scratch
- Do NOT copy competitor style (black/yellow, aggressive ad layout)
- Do NOT add WhatsApp unless already configured
- Keep mobile ordering: offer first → trust second → detail later
- Do NOT reintroduce mobile Xander trust card in hero
- Do NOT add tech stack to studio card
- Keep premium amber/navy/white visual style
- Keep natural local SEO wording (no keyword stuffing)
- Run `npm run build` and `php artisan test` after implementation tasks
- Existing `GET / → 301` test failure is pre-existing, acceptable
- All lang key changes go into nl/fr/en/de site.php files
- Basic accurate translations are fine for fr/en/de; NL is primary

---

## Task 1 — Sharpen the hero value proposition

**Goal:** Make the first screen commercially direct without becoming pushy. The hero must immediately answer:
1. What do I get? (professional website)
2. What does it cost from? (€750)
3. Can I trust this person? (Xander, lokaal, direct contact)
4. What do I do next? (CTA)

**Current headline:** "Websites die vertrouwen wekken en aanvragen opleveren."
Keep it or slightly refine it only if clearly stronger.

**Current body (desktop):** `site.hero.body` — customer-first, for zelfstandigen/lokale bedrijven
**Current body_mobile:** shorter version of body

**Action:** Review and optionally refine:
- `site.hero.headline` in nl/site.php (keep or improve)
- `site.hero.body` — make sure it communicates WHAT + WHO
- `site.hero.body_mobile` — should be crisp 1-sentence value prop on mobile
- `site.hero.eyebrow` — keep current or sharpen

Prefer small, targeted improvements. Do not rewrite the entire page.

If no change is clearly better, keep current copy.

**Files to touch:** `lang/nl/site.php` (hero section only). `home.blade.php` only if structural tweak needed.
**Do NOT change fr/en/de yet** — that is Task 12.

---

## Task 2 — Make pricing more visible above the fold

**Goal:** "Vanaf €750" must be visible on the first screen in a tasteful way.

**Current state:**
- Trustline already has "Vanaf €750" as one item
- Studio card footer has: `Vanaf <span>€750</span> · vrijblijvend gesprek`

**Action:**
- Evaluate if pricing is already visible enough in trustline + studio card
- If not, make it slightly more prominent (e.g., styled differently in trustline, or as a small badge near the CTA)
- Suggested label options: "Nieuwe website vanaf €750" or "Vanaf €750 · vrijblijvend eerste gesprek"
- Keep it clean, not loud

**Files:** `home.blade.php` (styling tweak if needed), `lang/nl/site.php` (trustline_items if wording changes)
**Do NOT change fr/en/de yet.**

---

## Task 3 — Strengthen "everything handled" reassurance

**Goal:** Reduce uncertainty for non-technical clients with copy that communicates:
- Van structuur en ontwerp tot livegang
- Domein, hosting en e-mail kunnen mee geregeld worden
- Eén rechtstreeks aanspreekpunt
- Geen technisch gedoe voor jou

**Avoid overpromising.** Use "kunnen mee geregeld worden" not "worden altijd geregeld".

**Where to add:** Either in the studio card body (as a small sub-line), or as a short line below the studio card in Div 2, or as part of the body copy. Avoid adding a whole new section.

**Files:** `home.blade.php`, `lang/nl/site.php`
**Do NOT change fr/en/de yet.**

---

## Task 4 — Improve trust bullets near hero

**Goal:** The trustline (Div 3) should clearly communicate:
- Vrijblijvend eerste gesprek
- Voor zelfstandigen en kmo's
- Vanaf €750
- Rechtstreeks contact / geen tussenpersonen

Current: ['Vrijblijvend eerste gesprek', 'Voor zelfstandigen en kmo\'s', 'Vanaf €750']

**Action:** Consider adding a 4th item: "Rechtstreeks contact met Xander" or "Geen tussenpersonen"
If 4 items is too many on mobile, make the 4th item hidden on mobile (`hidden sm:flex`).

**Files:** `lang/nl/site.php` (trustline_items), possibly `home.blade.php`
**Do NOT change fr/en/de yet.**

---

## Task 5 — CTA clarity

**Goal:** Make CTAs sharper and clearer.

**Primary CTA:** "Gratis kennismaking aanvragen" — keep or evaluate
**Secondary CTA:** "Bekijk diensten" — keep or improve
**Optional tertiary:** If there is a quick contact form anchor (`#quick-contact` or similar), add a subtle text link: "Snel een vraag stellen" near CTAs or in the hero section.

**Check:** Is there a `#quick-contact` anchor or quick contact section on the homepage? If yes, add the subtle link. If no, skip.

**Do NOT add WhatsApp.**

**Files:** `lang/nl/site.php` (cta keys), `home.blade.php` (if adding tertiary link)
**Do NOT change fr/en/de yet.**

---

## Task 6 — Social proof placeholder without fake reviews

**Goal:** Add honest trust signals. No fake stars, no fake logos.

**Do NOT add:** fake Google ratings, fake client names, fake logos

**Do add (only if truthful):**
A compact line or small element with copy such as:
- "Rechtstreeks contact met Xander"
- "Lokaal uit Tervuren"
- "Transparante richtprijzen"
- "Geen verplichting na het eerste gesprek"

These can go in or near the hero section, or below as a compact strip.

**Also:** Make the layout friendly for a future Google review badge (add a `{{-- TODO: Google review badge --}}` comment where it would go).

**Files:** `home.blade.php`, `lang/nl/site.php`
**Do NOT change fr/en/de yet.**

---

## Task 7 — Make the studio card more offer-focused

**Goal:** Studio card should communicate the concrete offer, not just list services.

**Keep these 4 service items:**
- Nieuwe website laten maken
- Website vernieuwen
- Goed vindbaar in Google
- Onderhoud & opvolging

**Improve footer text:** "Vanaf €750 · vrijblijvend gesprek" (already present — verify or enhance)
**CTA in card:** "Kennismaking aanvragen →" (already present — verify or enhance)

**Do NOT add:** tech stack, webshop/apps/smart flow

**Files:** `home.blade.php` (studio card section only), `lang/nl/site.php` (studio_card_items if wording changes)
**Do NOT change fr/en/de yet.**

---

## Task 8 — Mobile-first hero check

**Goal:** Verify the first screen on mobile is commercially clear.

**Check that mobile shows:**
1. Headline (h1)
2. Short intro (`body_mobile`)
3. Studio card early (Div 2 in 3-item grid)
4. Price/CTA visible quickly (Div 3 with CTAs + trustline)
5. No excessive personal intro before the offer

**The Xander section (personal trust) should be further down the page — do NOT move it up.**

**Action:** Read `home.blade.php` and verify the 3-item grid mobile order is correct. If any mobile-specific padding or spacing feels excessive, trim it. This is mostly a verification task with small tweaks if needed.

**Files:** `home.blade.php` (minor tweaks only)

---

## Task 9 — Add compact "wat is inbegrepen?" reassurance block

**Goal:** If it fits naturally, add a compact block early on the homepage listing what clients get.

**Suggested items:**
- Structuur & ontwerp op maat
- Mobielvriendelijke website
- Contactformulier
- Basis-SEO
- Hulp bij livegang
- Optioneel: hosting/domein/e-mail advies

**Placement:** After the hero section or after the trust strip, before pricing/Xander section. Keep it compact (icon list or 2-col grid). If adding it makes the page too long or cluttered, skip this task.

**Files:** `home.blade.php`, `lang/nl/site.php`
**Do NOT change fr/en/de yet.**

---

## Task 10 — Local SEO and conversion copy review

**Goal:** Verify natural local wording appears in the hero and early sections.

**Must appear naturally somewhere above the fold or in the first sections:**
- Tervuren
- Druivenstreek or Vlaams-Brabant
- zelfstandigen
- lokale bedrijven
- website laten maken or webdesigner

**Action:** Read current NL copy. Verify these terms appear naturally. If a key term is missing entirely from the visible first-screen content, add it naturally — no keyword stuffing.

**Files:** `lang/nl/site.php` (copy only, no structural changes)

---

## Task 11 — Visual direction (NO IMPLEMENTATION)

**Status:** REFERENCE ONLY — no implementation needed.

Keep current visual style:
- Navy, amber accents, white/soft backgrounds
- Elegant serif typography (font-serif)
- Subtle canvas background
- Do NOT switch to competitor black/yellow style
- Do NOT add stock background photos or loud ad blocks

---

## Task 12 — Multilingual support

**Goal:** Apply all NL copy changes from Tasks 1-10 to FR, EN, DE.

**Approach:**
- Read the final state of `lang/nl/site.php` for hero/home sections
- Provide accurate basic translations for FR, EN, DE
- Do NOT leave missing keys
- Translations can be basic/functional, not marketing-polished

**Files:** `lang/fr/site.php`, `lang/en/site.php`, `lang/de/site.php`

---

## Task 13 — Verification

Run:
```
npm run build
php artisan test
```

Expected:
- Build succeeds
- 83/84 tests pass (1 pre-existing `GET / → 301` failure acceptable)
- No new failures introduced

---

## Task 14 — Final report

Report:
- Files changed
- Hero copy/offer changes
- Price visibility changes
- Reassurance/trust changes
- CTA changes
- Mobile impact
- Build/test result
