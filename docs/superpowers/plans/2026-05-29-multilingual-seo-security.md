# Multilingual SEO + Security Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add German (`de`) as a fourth locale, finalise multilingual SEO for all four languages (nl/fr/en/de), fix contact form locale awareness, add locale tracking to inquiries, improve sitemap with hreflang alternates, and complete a security review — without breaking anything that works.

**Architecture:** Laravel Blade + Tailwind + vanilla JS. Locale routing already exists for nl/fr/en via `Route::prefix($locale)` groups driven by `config/localized-routes.php`. Translations live in `lang/{locale}/site.php`. The layout (`app.blade.php`) generates hreflang and OG tags from the current route name. The SetLocale middleware sets `app()->getLocale()` for all requests.

**Tech Stack:** PHP 8.x / Laravel 11, Blade, Tailwind CSS, vanilla JavaScript, SQLite/MySQL

---

## Current State (read before touching anything)

- **Routes**: `nl`, `fr`, `en` prefixed routes exist. `de` does NOT exist anywhere yet.
- **Translations**: `lang/nl/site.php`, `lang/fr/site.php`, `lang/en/site.php` all fully populated. `lang/de/site.php` does NOT exist.
- **`config/localized-routes.php`**: Has `nl`, `fr`, `en`. Missing `de`.
- **`SetLocale::ALLOWED`**: `['nl', 'fr', 'en']`. Missing `de`.
- **`config/studio.php` `translations_ready`**: `nl:true`, `fr:false`, `en:false`. No `de`. **FR and EN translations are in fact complete — they just aren't marked ready yet.** This means FR and EN pages are currently noindexed and hreflang is suppressed even though translations exist.
- **Root `/`**: Serves NL home content. Should redirect to `/nl`.
- **Layout hreflang**: Only loops over `nl/fr/en`. No `de`. Only outputs when `$isReady` (currently only nl).
- **Navigation switcher**: Shows `NL FR EN`. No `DE`.
- **`InquiryController::store`**: Redirects to `route('contact')` (Dutch non-prefixed) after every submission, even from `/fr/contact` or `/en/contact`.
- **`StoreInquiryRequest::messages()`**: All Dutch hardcoded strings. Not locale-aware.
- **`contact.blade.php` canonical**: Hardcoded to `route('contact')` (Dutch). Should be locale-aware.
- **`inquiries` table**: No `locale` column.
- **Sitemap**: Only includes NL pages. No hreflang alternates.
- **`config/landing-pages.php`**: NL-only landing pages. Fine as-is.

---

## File Map

| File | Action | Purpose |
|------|--------|---------|
| `config/localized-routes.php` | Modify | Add `de` slug paths |
| `app/Http/Middleware/SetLocale.php` | Modify | Add `de` to ALLOWED |
| `routes/web.php` | Modify | Add `de` to locale loop, add root redirect |
| `config/studio.php` | Modify | Mark fr/en ready:true, add de:false |
| `lang/de/site.php` | Create | Full German translations |
| `resources/views/components/layouts/app.blade.php` | Modify | Add de hreflang, de OG locale |
| `resources/views/components/navigation.blade.php` | Modify | Add DE to language switcher |
| `resources/views/pages/contact.blade.php` | Modify | Locale-aware canonical |
| `app/Http/Requests/StoreInquiryRequest.php` | Modify | Locale-aware messages via `__()` |
| `app/Http/Controllers/InquiryController.php` | Modify | Locale-aware redirect after store |
| `database/migrations/2026_05_29_add_locale_to_inquiries.php` | Create | Add locale column |
| `app/Models/Inquiry.php` | Modify | Add locale to `$fillable` |
| `app/Services/InquiryService.php` | Modify | Store locale from `app()->getLocale()` |
| `app/Http/Controllers/PageController.php` | Modify | Multilingual sitemap |
| `resources/views/sitemap.blade.php` | Modify | Add hreflang xhtml namespace |

---

## Task 1 — Root redirect + de config foundation

**Files:**
- Modify: `routes/web.php`
- Modify: `config/localized-routes.php`
- Modify: `app/Http/Middleware/SetLocale.php`

- [ ] **Step 1.1: Add root redirect in routes/web.php**

Replace the top-level home route:
```php
// Before:
Route::get('/', [PageController::class, 'home'])->name('home');

// After:
Route::redirect('/', '/nl', 301)->name('home');
```

This keeps the `home` named route (used in sitemap) but makes it a 301 redirect. The legacy Dutch non-prefixed routes remain intact for backwards compatibility.

- [ ] **Step 1.2: Add de to localized-routes.php**

Open `config/localized-routes.php` and add a `de` block after `en`:
```php
'de' => [
    'home'     => '/',
    'services' => 'dienstleistungen',
    'contact'  => 'kontakt',
    'pricing'  => 'preise',
    'about'    => 'ueber-mich',
    'process'  => 'arbeitsweise',
    'showcase' => 'showcase',
    'privacy'  => 'datenschutzerklaerung',
],
```

- [ ] **Step 1.3: Add de to SetLocale middleware**

Open `app/Http/Middleware/SetLocale.php`. Change:
```php
private const ALLOWED = ['nl', 'fr', 'en'];
```
To:
```php
private const ALLOWED = ['nl', 'fr', 'en', 'de'];
```

- [ ] **Step 1.4: Add de to routes/web.php locale loop**

In `routes/web.php`, change:
```php
foreach (['nl', 'fr', 'en'] as $locale) {
```
To:
```php
foreach (['nl', 'fr', 'en', 'de'] as $locale) {
```

- [ ] **Step 1.5: Commit**
```bash
git add config/localized-routes.php app/Http/Middleware/SetLocale.php routes/web.php
git commit -m "feat: add German locale to routing config"
```

---

## Task 2 — Create lang/de/site.php

**Files:**
- Create: `lang/de/site.php`

- [ ] **Step 2.1: Create lang/de/site.php with full German translations**

Create `lang/de/site.php` with the following content:

```php
<?php

return [

    // ── Navigation ────────────────────────────────────────────────────────────
    'nav' => [
        'services' => 'Leistungen',
        'showcase' => 'Showcase',
        'process'  => 'Arbeitsweise',
        'pricing'  => 'Preise',
        'about'    => 'Über mich',
        'contact'  => 'Kontakt',
    ],

    'lang_switcher' => [
        'label' => 'Sprache',
        'nl'    => 'NL',
        'fr'    => 'FR',
        'en'    => 'EN',
        'de'    => 'DE',
    ],

    // ── Common ────────────────────────────────────────────────────────────────
    'common' => [
        'cta_contact'      => 'Projekt besprechen',
        'cta_services'     => 'Leistungen ansehen',
        'cta_contact_btn'  => 'Kontakt aufnehmen',
        'cta_more'         => 'Mehr erfahren',
        'available'        => 'Verfügbar',
        'on_request'       => 'Auf Anfrage',
        'included'         => 'Inbegriffen',
        'view_services'    => 'Alle Leistungen',
        'request_proposal' => 'Kostenloses Angebot anfragen',
        'view_showcase'    => 'Showcase ansehen',
        'view_about'       => 'Über mich',
        'view_process'     => 'Vollständige Arbeitsweise',
        'more_details'     => 'Mehr Details',
    ],

    'available' => 'Verfügbar',

    // ── Hero ──────────────────────────────────────────────────────────────────
    'hero' => [
        'eyebrow'       => 'Websites von Xander Van Malder',
        'headline'      => 'Professionelle Websites, Webshops und digitale Lösungen für lokale Unternehmen.',
        'body'          => 'Ich bin :name, Full-Stack-Entwickler aus der Druivenstreek (Belgien). Ich entwickle Websites, Webanwendungen und digitale Tools für Selbstständige und lokale Unternehmen — mit Fokus auf Qualität, SEO-Grundlagen und persönlicher Kommunikation.',
        'cta_primary'   => 'Projekt besprechen',
        'cta_secondary' => 'Leistungen ansehen',
    ],

    // ── Home ──────────────────────────────────────────────────────────────────
    'home' => [
        'offer_eyebrow'  => 'Was ich für Sie entwickeln kann',
        'offer_heading'  => 'Leistungen',
        'offer_link'     => 'Alle Leistungen',

        'trust_clear_title'    => 'Klare Websites',
        'trust_clear_desc'     => 'Struktur und Inhalt auf Ihre Besucher abgestimmt',
        'trust_custom_title'   => 'Maßarbeit wo nötig',
        'trust_custom_desc'    => 'Keine unnötigen Funktionen — nur was zählt',
        'trust_secure_title'   => 'Sicher entwickelt',
        'trust_secure_desc'    => 'Sicherheit und Wartbarkeit von Anfang an',
        'trust_personal_title' => 'Persönlicher Kontakt',
        'trust_personal_desc'  => 'Sie sprechen direkt mit dem Entwickler',

        'service_website_title'    => 'Website erstellen lassen',
        'service_website_body'     => 'Für Selbstständige, die eine professionelle Online-Präsenz möchten. Responsive, schnell und SEO-freundlich — von der gezielten Landingpage bis zur vollständigen Unternehmenswebsite mit klarer Kontaktführung.',
        'service_website_bullets'  => ['Responsive auf allen Geräten', 'SEO-Grundlagen inbegriffen', 'Klare Kontaktführung für Besucher', 'Keine Templates — durchdachte Maßarbeit'],
        'service_redesign_title'   => 'Website neu gestalten',
        'service_redesign_body'    => 'Für Unternehmen mit einer veralteten oder unklaren Website. Stärkere Struktur, besseres Vertrauen, klarere Kontaktführung und bessere mobile Nutzung.',
        'service_webshop_title'    => 'Webshop & Online-Verkauf',
        'service_webshop_body'     => 'Für Produkte, Bestellungen oder einfachen Online-Verkauf. Vom Produktkatalog bis zum Webshop mit Warenkorb und Zahlungsmöglichkeiten — je nach Umfang.',
        'service_webshop_seo'      => 'SEO-Grundlagen für Produkte inbegriffen',
        'service_forms_title'      => 'Kontakt- und Angebotsformulare',
        'service_forms_body'       => 'Für klare Anfragen mit den richtigen Informationen beim ersten Kontakt. Nicht nur „Name, E-Mail, Nachricht" — sondern Formulare, die die richtigen Fragen stellen.',
        'service_apps_title'       => 'Apps, Tools & Maßarbeit',
        'service_apps_body'        => 'Für digitale Ideen, die über eine Standard-Website oder einen Webshop hinausgehen: interne Tools, kleine Dashboards, Kundenportale oder spezifische Workflows.',
        'service_maintenance_title' => 'Wartung & Betreuung',
        'service_maintenance_body'  => 'Updates, Sicherheitsprüfungen, Backups und kleine Anpassungen — damit Ihre Website sicher und aktuell bleibt.',
        'service_maintenance_price' => 'Ab €50/Monat',
        'service_maintenance_cta'   => 'Wartung anfragen',
        'seo_note_title'           => 'SEO-Grundlagen inbegriffen',
        'seo_note_body'            => 'Jede Website und jeder Webshop wird mit soliden technischen SEO-Grundlagen ausgeliefert. Für bessere lokale Sichtbarkeit bei spezifischen Leistungen oder Regionen können wir Landingpages oder eine lokale SEO-Struktur hinzufügen.',
        'seo_note_link'            => 'Mehr über lokales SEO',

        'compare_heading'       => 'Ohne gute Website vs. mit starker Online-Präsenz',
        'compare_without_title' => 'Ohne klare Website',
        'compare_with_title'    => 'Mit starker Online-Präsenz',
        'compare_without_items' => [
            'Schwer bei Google für Ihre Region oder Leistung auffindbar',
            'Schlechter erster Eindruck bei potenziellen Kunden',
            'Kein klarer Weg, Kontakt aufzunehmen',
            'Besucher verlassen die Seite schnell ohne zu handeln',
            'Zweifel an Professionalität oder Vertrauenswürdigkeit',
        ],
        'compare_with_items' => [
            'Bei Google für Ihre Leistungen und Region auffindbar',
            'Professioneller erster Eindruck, der Vertrauen weckt',
            'Klares Kontaktformular oder Call-to-Action',
            'Besucher werden zu Interessenten und Kunden',
            'Glaubwürdigkeit und Wiedererkennungswert online',
        ],

        'process_eyebrow' => 'Wie ich arbeite',
        'process_heading' => 'Ein klarer Ablauf von Anfang bis Ende',
        'process_body'    => 'Keine Überraschungen unterwegs. Schritt für Schritt, mit klarer Kommunikation.',
        'process_link'    => 'Vollständige Arbeitsweise',

        'pricing_eyebrow' => 'Preise',
        'pricing_heading' => 'Was kostet es?',
        'pricing_note'    => 'Richtpreise. Der endgültige Preis hängt von Umfang, Sprachen, Formularen, Integrationen und Funktionen ab.',
        'pricing_link'    => 'Vollständige Preisseite ansehen →',

        'projects_eyebrow' => 'Technische Tiefe',
        'projects_heading'  => 'Eigene Projekte als Beweis technischer Tiefe',
        'projects_body'     => 'Eigene Produkte, die zeigen, wie ich über Design, Code und Produktqualität denke.',
        'projects_link'     => 'Mehr Details',

        'showcase_teaser_title' => 'Sehen Sie, wie Interaktion eine Website stärker macht',
        'showcase_teaser_body'  => 'Im Showcase zeige ich interaktive Details: von subtiler Hero-Animation bis zu Formular-Feedback und Scroll-Vorschau. Nicht als Gimmick, sondern als Möglichkeit, Websites klarer und professioneller zu gestalten.',
        'showcase_teaser_cta'   => 'Showcase ansehen',

        'cta_heading' => 'Möchten Sie wissen, was ich für Ihre Website oder Ihr Projekt tun kann?',
        'cta_body'    => 'Erzählen Sie mir von Ihrem Projekt. Das erste Gespräch ist unverbindlich.',
    ],

    // ── Services ──────────────────────────────────────────────────────────────
    'services' => [
        'heading'    => 'Leistungen',
        'eyebrow'    => 'Was ich entwickle',
        'body'       => 'Ich helfe Selbstständigen und lokalen Unternehmen mit Websites und digitalen Tools, die funktionieren. Keine unnötige Komplexität — nur eine solide, sichere Grundlage, die zu Ihnen passt.',
        'included'   => 'Was ist inbegriffen',
        'cta_heading' => 'Nicht sicher, welche Leistung zu Ihnen passt?',
        'cta_body'    => 'Erzählen Sie mir von Ihrer Situation und ich helfe Ihnen auf den richtigen Weg.',
        'cta_btn'     => 'Kontakt aufnehmen',
        'addons_eyebrow' => 'Extras',
        'addons_heading' => 'Zusätzliche Optionen',
        'addons_body'    => 'Ergänzende Leistungen, die Ihre Website oder Ihr Projekt weiter stärken — auf Anfrage oder als Erweiterung eines laufenden Projekts.',
        'items' => [
            'nieuwe-website' => [
                'title'       => 'Website erstellen lassen',
                'short'       => 'Für Selbstständige, die eine professionelle Online-Präsenz möchten.',
                'description' => 'Eine neue Website, die auf Ihr Unternehmen und Ihre Zielgruppe zugeschnitten ist. Responsive, schnell und SEO-freundlich. Von der gezielten Landingpage bis zur vollständigen Unternehmenswebsite — mit einer klaren Kontaktführung, die Besucher in Kunden umwandelt.',
                'bullets'     => ['Responsives Design für alle Geräte', 'Schnelle Ladezeit und technische Optimierung', 'SEO-freundliche Struktur inbegriffen', 'Klare Kontaktführung für Besucher', 'Von der Landingpage zur vollständigen Website'],
                'cta'         => 'Ihre Website besprechen',
            ],
            'website-vernieuwen' => [
                'title'       => 'Website neu gestalten',
                'short'       => 'Für Unternehmen mit einer veralteten oder unklaren Website.',
                'description' => 'Ist Ihre Website veraltet, langsam, unklar oder schlecht für Mobilgeräte optimiert? Ich analysiere, was verbessert werden kann, und baue Ihre Website mit stärkerer Struktur, besserem Vertrauen und klarerer Kontaktführung neu auf.',
                'bullets'     => ['Stärkere Struktur und visuelles Erscheinungsbild', 'Verbessertes Vertrauen bei Besuchern', 'Klarere Kontaktführung', 'Bessere mobile Nutzererfahrung', 'Behalten, was funktioniert — verbessern, was nicht'],
                'cta'         => 'Neugestaltung besprechen',
            ],
            'webshop' => [
                'title'       => 'Webshop & Online-Verkauf',
                'short'       => 'Für Produkte, Bestellungen oder einfachen Online-Verkauf.',
                'description' => 'Für Selbstständige und lokale Unternehmen, die Produkte online zeigen oder verkaufen möchten. Vom einfachen Produktkatalog bis zum Webshop mit Warenkorb, Zahlungen und Bestellverfolgung. Der Funktionsumfang bestimmt den Preis.',
                'bullets'     => ['Produktkatalog oder einfacher Webshop', 'Warenkorb bei Bedarf', 'Online-Bestellungen und Zahlungsoptionen je nach Umfang', 'Klare Produktseiten', 'SEO-Grundlagen für Produkte und Kategorien inbegriffen', 'Wartungsfreundlich entwickelt'],
                'cta'         => 'Ihren Webshop besprechen',
            ],
            'formulieren' => [
                'title'       => 'Kontakt- und Angebotsformulare',
                'short'       => 'Für klare Anfragen mit den richtigen Informationen beim ersten Kontakt.',
                'description' => 'Nicht jedes Formular muss „Name, E-Mail, Nachricht" sein. Ich entwickle Formulare, die die richtigen Fragen stellen, damit Anfragen von Anfang an klarer sind — für Sie und für den Besucher.',
                'bullets'     => ['Individuelles Angebotsformular', 'Terminanfrage oder Reservierungsformular', 'Intake-Formular oder Serviceanfrage', 'Mehrstufiges Formular mit Validierung und Zusammenfassung', 'Sicher, spam-geschützt und DSGVO-konform'],
                'cta'         => 'Ihr Formular besprechen',
            ],
            'seo-landingspaginas' => [
                'title'       => 'Lokales SEO & Landingpages',
                'short'       => 'Für bessere Sichtbarkeit bei spezifischen Leistungen oder Regionen.',
                'description' => 'Für Unternehmen, die bei spezifischen Leistungen oder Regionen gefunden werden möchten. Nützliche, einzigartige Inhalte mit lokaler Relevanz — keine Spam-Seiten, keine Ranking-Garantien.',
                'bullets'     => ['Landingpages für spezifische Leistungen oder Regionen', 'Nützlicher einzigartiger Inhalt pro Seite', 'Lokale Relevanz für Google', 'Technische SEO-Struktur inbegriffen', 'Keine Spam-Seiten — ehrlich und transparent'],
                'cta'         => 'Lokales SEO besprechen',
            ],
            'webapplicatie' => [
                'title'       => 'Apps, Tools & Maßarbeit',
                'short'       => 'Für digitale Ideen, die über eine Standard-Website oder einen Webshop hinausgehen.',
                'description' => 'Haben Sie eine Idee für ein internes Tool, ein kleines Dashboard, ein Kundenportal oder einen spezifischen digitalen Workflow? Vollständig maßgeschneidert, sicher und wartungsfreundlich mit Laravel entwickelt.',
                'bullets'     => ['Individuelle Formulare und Tracking-Systeme', 'Kleine Dashboards oder interne Tools', 'Kundenportale oder Buchungssysteme', 'Sichere Datenspeicherung und Logik', 'Dokumentation und Übergabe'],
                'cta'         => 'Erzählen Sie mir von Ihrer Idee',
            ],
            'onderhoud' => [
                'title'       => 'Wartung & Betreuung',
                'short'       => 'Für Updates, Anpassungen, technische Prüfungen und Sicherheit.',
                'description' => 'Websites brauchen Wartung: Sicherheits-Updates, technische Fixes, kleine Anpassungen und Backups. Ich übernehme die technische Betreuung, damit Sie sich auf Ihr Unternehmen konzentrieren können. Wartung ab €50/Monat.',
                'bullets'     => ['Monatliche Updates und Sicherheitsprüfungen', 'Kleine inhaltliche oder visuelle Anpassungen', 'Backups und Monitoring', 'Schnelle Reaktion bei Problemen', 'Klare Vereinbarungen — keine Überraschungen'],
                'cta'         => 'Wartung anfragen',
            ],
        ],
        'addons_items' => [
            ['title' => 'Website-Audit & Verbesserungsberatung', 'price' => 'Ab €75',                 'desc' => 'Ich analysiere Ihre aktuelle Website und gebe konkrete Empfehlungen: Erscheinungsbild, mobile Nutzung, Ladegeschwindigkeit, Kontaktführung und SEO-Grundlagen. Kurzcheck kostenlos beim Kennenlernen.'],
            ['title' => 'Google Business Profil Unterstützung',  'price' => 'Ab €50',                 'desc' => 'Kontaktdaten, Öffnungszeiten, Leistungen, Website-Verknüpfung und Grundberatung zu Bewertungen und Fotos — damit Ihr Unternehmen bei Google gut aussieht.'],
            ['title' => 'Inhaltsstruktur & Texte',               'price' => 'Inbegriffen / auf Anfrage', 'desc' => 'Inbegriffen bei professionellen Websites. Zusätzliche Hilfe bei der Strukturierung Ihres Angebots und beim Verfassen klarer Website-Texte auf Anfrage.'],
            ['title' => 'Mehrsprachige Websites',                'price' => 'Ab €150/Sprache',        'desc' => 'Ihre Website kann in mehreren Sprachen aufgebaut werden mit einer klaren Sprachstruktur. Der Preis hängt von der Anzahl der Seiten ab.'],
            ['title' => 'Visuelle Grundausrichtung',             'price' => 'Auf Anfrage',            'desc' => 'Noch keinen starken visuellen Stil? Ich helfe mit einer einfachen, professionellen Richtung für Farben, Typografie und Erscheinungsbild. Inbegriffen bei professionellen Websites.'],
            ['title' => 'Integrationen',                         'price' => 'Auf Anfrage',            'desc' => 'Verknüpfung mit Tools, die Sie bereits nutzen: Google Maps, WhatsApp, E-Mail-Benachrichtigungen, Newsletter oder Google Sheets und CRM. Preis je nach Komplexität.'],
        ],
    ],

    // ── Pricing ───────────────────────────────────────────────────────────────
    'pricing' => [
        'eyebrow'            => 'Preise',
        'heading'            => 'Was kostet es?',
        'body'               => 'Richtpreise für Websites, Webshops, Wartung und Maßarbeit. Der endgültige Preis hängt von Umfang, Sprachen, Formularen, Integrationen und Funktionen ab.',
        'note'               => 'Jeder Preis ist ein Richtpreis. Nach einem kurzen Gespräch erstelle ich ein konkretes, auf Ihr Projekt zugeschnittenes Angebot.',
        'popular'            => 'Häufig gewählt',
        'webshop_note_title' => 'Webshop — Preis je nach Umfang',
        'webshop_note_body'  => 'Der Preis eines Webshops hängt von der Anzahl der Produkte, Kategorien, Zahlungsmethoden, Versandoptionen, Lagerverwaltung, Kundenkonten, Bestellbestätigungen, Sprachen und Anforderungen an die Verwaltung ab.',
        'factors_heading'    => 'Was bestimmt den Preis?',
        'factors_items'      => [
            'Anzahl der Seiten und Bereiche',
            'Mehrsprachigkeit (NL, FR, EN, DE, …)',
            'Individuelle Formulare (Angebotsformular, Reservierung, …)',
            'Bedarf an einem Verwaltungsbereich oder Content-Management',
            'Zusätzliche SEO-Landingpages für Leistungen oder Regionen',
            'Spezifische Integrationen (Buchungen, Newsletter, CRM)',
            'Design-Komplexität und Funktionen',
            'Wartungserwartungen nach dem Launch',
        ],
        'budget_heading'    => 'Noch nicht sicher über Ihr Budget?',
        'budget_body'       => 'Kein Problem. Sagen Sie mir, was Sie brauchen, und ich erstelle ein Angebot, das zu Ihren Zielen passt. Keine versteckten Kosten, keine Überraschungen im Nachhinein.',
        'budget_cta'        => 'Kostenloses Angebot anfragen',
        'addons_eyebrow'    => 'Extras',
        'addons_heading'    => 'Optionale Erweiterungen',
        'addons_body'       => 'Erweiterungen, die Ihre Website oder Ihr Projekt weiter stärken. Preise sind Richtpreise — die endgültigen Kosten hängen vom Umfang ab.',
        'addons_note'       => 'Diese Preise sind Richtpreise. Bei größeren Websites können bestimmte Erweiterungen in das Gesamtangebot gebündelt werden.',
        'addons_items'      => [
            ['title' => 'Zusätzliche SEO-Landingpage',         'price' => 'Ab €100/Seite',            'desc' => 'Pro Seite, die auf eine spezifische Leistung oder Region ausgerichtet ist, mit nützlichem einzigartigem Inhalt.'],
            ['title' => 'Individuelles Formular',              'price' => 'Ab €100',                  'desc' => 'Angebotsformular, Terminanfrage, Intake oder mehrstufiges Formular mit Validierung.'],
            ['title' => 'Website-Audit',                       'price' => 'Ab €75',                   'desc' => 'Konkrete Empfehlungen zu Erscheinungsbild, mobiler Nutzung, Ladegeschwindigkeit, Kontaktführung und SEO-Grundlagen. Kurzcheck kostenlos beim Kennenlernen.'],
            ['title' => 'Google Business Profil Grundcheck',   'price' => 'Ab €50',                   'desc' => 'Kontaktdaten, Öffnungszeiten, Leistungen, Website-Verknüpfung und Grundberatung zu Bewertungen und Fotos.'],
            ['title' => 'Zusätzliche Sprache',                 'price' => 'Ab €150',                  'desc' => 'Zusätzliche Sprachversion Ihrer Website mit klarer Sprachstruktur. Preis je nach Seitenanzahl.'],
            ['title' => 'SEO-Struktur für mehrere Leistungen/Regionen', 'price' => 'Auf Anfrage',     'desc' => 'Umfangreicherer lokaler SEO-Ansatz mit mehreren Landingpages und Content-Strategie.'],
            ['title' => 'Inhaltsstruktur & Textbegleitung',    'price' => 'Inbegriffen / auf Anfrage', 'desc' => 'Inbegriffen bei professionellen Websites. Zusätzliche Hilfe bei Struktur und Website-Texten auf Anfrage.'],
            ['title' => 'Integrationen',                       'price' => 'Auf Anfrage',              'desc' => 'Google Maps, WhatsApp, E-Mail-Benachrichtigungen, Newsletter, Google Sheets oder CRM. Preis je nach Komplexität.'],
        ],
        'card_starter_title'   => 'Starter',
        'card_starter_price'   => 'Ab €750',
        'card_starter_desc'    => 'Für Gründer, Selbstständige und kleine Unternehmen, die eine professionelle Online-Präsenz benötigen.',
        'card_starter_bullets' => ['Bis zu 5 Seiten', 'Responsives Design', 'Kontaktformular', 'SEO-Grundlagen inbegriffen', '1 Feedbackrunde'],
        'card_starter_cta'     => 'Angebot anfragen',
        'card_pro_title'       => 'Professionell',
        'card_pro_price'       => 'Ab €1.250',
        'card_pro_desc'        => 'Für Unternehmen, die eine umfangreichere Website mit mehr Seiten und Funktionen benötigen.',
        'card_pro_bullets'     => ['Bis zu 10 Seiten', 'Responsive und schnell', 'Kontaktformular mit Validierung', 'SEO-freundliche Struktur', '2 Feedbackrunden', 'Technischer Launch-Support'],
        'card_pro_cta'         => 'Angebot anfragen',
        'card_webshop_title'   => 'Webshop',
        'card_webshop_price'   => 'Ab €950',
        'card_webshop_desc'    => 'Vom Produktkatalog bis zum Webshop mit Warenkorb und Zahlungsmöglichkeiten. Preis je nach Umfang.',
        'card_webshop_bullets' => ['Produktkatalog: ab €950', 'Einfacher Webshop: ab €1.500', 'Zahlungsoptionen auf Anfrage', 'SEO-Grundlagen für Produkte inbegriffen', 'Preis je nach Funktionen'],
        'card_webshop_cta'     => 'Webshop besprechen',
        'card_maint_title'     => 'Wartung',
        'card_maint_price'     => 'Ab €50/Mo.',
        'card_maint_desc'      => 'Monatliche technische Betreuung, damit Ihre Website sicher, aktuell und funktionsfähig bleibt.',
        'card_maint_bullets'   => ['Monatliche Updates', 'Sicherheitsprüfungen', 'Kleine Anpassungen', 'Monitoring und schnelle Reaktion'],
        'card_maint_cta'       => 'Wartung anfragen',
    ],

    // ── Contact ───────────────────────────────────────────────────────────────
    'contact' => [
        'heading'          => 'Lassen Sie uns sprechen',
        'body'             => 'Erzählen Sie mir von Ihrem Projekt oder Ihrer Idee. Unverbindlich.',
        'email_label'      => 'E-Mail',
        'location_label'   => 'Standort',
        'response_label'   => 'Antwortzeit',
        'response_value'   => 'In der Regel innerhalb von 1–2 Werktagen',
        'gdpr_note'        => 'Ihre Daten werden ausschließlich zur Bearbeitung Ihrer Anfrage verwendet und niemals an Dritte weitergegeben. Siehe die :link.',
        'gdpr_link'        => 'Datenschutzerklärung',
        'success_heading'  => 'Nachricht erhalten',
        'success_body'     => 'Vielen Dank für Ihre Nachricht. Ich melde mich so schnell wie möglich, in der Regel innerhalb von 1 bis 2 Werktagen.',
        'step_project'     => 'Projekt',
        'step_details'     => 'Angaben',
        'step_info'        => 'Details',
        'step_budget'      => 'Budget',
        'step_confirm'     => 'Bestätigen',
        'step1_heading'    => 'Was ist Ihr Projekt?',
        'step2_heading'    => 'Wie kann ich Sie erreichen?',
        'step3_heading'    => 'Erzählen Sie mir mehr über Ihr Projekt',
        'step4_heading'    => 'Budget und Zeitplan',
        'step5_heading'    => 'Bestätigen und absenden',
        'project_type_label' => 'Projekttyp',
        'existing_url_label' => 'Haben Sie bereits eine Website? (optional)',
        'name_label'         => 'Name',
        'company_label'      => 'Unternehmens- oder Handelsname (optional)',
        'email_field_label'  => 'E-Mail-Adresse',
        'phone_label'        => 'Telefonnummer (optional)',
        'multilingual_label' => 'Mehrsprachigkeit',
        'multilingual_hint'  => '(Mehrfachauswahl möglich)',
        'admin_label'        => 'Content-Verwaltung',
        'needs_label'        => 'Was ist Ihnen wichtig?',
        'needs_hint'         => '(optional, Mehrfachauswahl möglich)',
        'description_label'  => 'Projektbeschreibung',
        'description_ph'     => 'Erzählen Sie mir, was Sie entwickeln möchten, für wen es bestimmt ist und was es leisten soll. Je mehr Details, desto besser kann ich einschätzen, was es erfordert.',
        'budget_label'       => 'Budgetindikation',
        'timeline_label'     => 'Gewünschter Zeitplan',
        'summary_heading'    => 'Zusammenfassung Ihrer Anfrage',
        'summary_type'       => 'Projekttyp:',
        'summary_name'       => 'Name:',
        'summary_email'      => 'E-Mail:',
        'gdpr_label'         => 'Ich stimme der :link zu und gebe mein Einverständnis, dass meine Daten zur Bearbeitung dieser Anfrage verwendet werden.',
        'btn_prev'           => '← Zurück',
        'btn_next'           => 'Weiter →',
        'btn_submit'         => 'Anfrage absenden',
        'type_new_website'   => 'Neue Website',
        'type_redesign'      => 'Website neu gestalten',
        'type_webshop'       => 'Webshop / Online-Verkauf',
        'type_contact_form'  => 'Kontakt- oder Angebotsformular',
        'type_seo_local'     => 'SEO / lokale Sichtbarkeit',
        'type_app_tool'      => 'App, Tool oder Webanwendung',
        'type_maintenance'   => 'Wartung / Anpassungen',
        'type_audit'         => 'Website-Audit / Beratung',
        'type_other'         => 'Etwas anderes',
        'need_seo'           => 'Ich möchte bei Google besser gefunden werden',
        'need_landing_pages' => 'Ich möchte SEO-Landingpages',
        'need_form'          => 'Ich möchte ein individuelles Formular',
        'need_products'      => 'Ich möchte Produkte online zeigen oder verkaufen',
        'need_multilingual'  => 'Ich möchte eine mehrsprachige Website',
        'need_maintenance'   => 'Ich möchte Wartung nach dem Launch',
        'need_advice'        => 'Ich möchte Beratung zu meiner aktuellen Website',
        'budget_not_sure'    => 'Noch nicht sicher',
        'budget_750_1250'    => '€750 – €1.250',
        'budget_1250_2500'   => '€1.250 – €2.500',
        'budget_2500_5000'   => '€2.500 – €5.000',
        'budget_5000_plus'   => '€5.000+',
        'timeline_no_rush'   => 'Keine Eile',
        'timeline_1_month'   => 'Innerhalb von 1 Monat',
        'timeline_2_3_months' => 'Innerhalb von 2–3 Monaten',
        'timeline_asap'      => 'So schnell wie möglich',
        'timeline_not_sure'  => 'Noch nicht sicher',
        'admin_static'       => 'Ich möchte einfach eine feste Website',
        'admin_basic_edit'   => 'Ich möchte Texte oder Fotos selbst bearbeiten können',
        'admin_admin'        => 'Ich möchte einen einfachen Verwaltungsbereich',
        'admin_not_sure'     => 'Noch nicht sicher',
        'lang_nl'            => 'Niederländisch',
        'lang_fr'            => 'Französisch',
        'lang_en'            => 'Englisch',
        'lang_de'            => 'Deutsch',
        'lang_es'            => 'Spanisch',
        'lang_other'         => 'Andere Sprache',
        'lang_not_sure'      => 'Noch nicht sicher',
        'other_lang_ph'      => 'z.B. Italienisch, Portugiesisch …',
        'other_lang_label'   => 'Welche Sprache?',
        'validation_choose'  => 'Bitte wählen Sie eine Option, um fortzufahren.',
        'placeholder_url'    => 'https://ihrewebsite.de',
        'placeholder_name'   => 'Ihr vollständiger Name',
        'placeholder_company' => 'Name Ihres Unternehmens',
        'placeholder_email'  => 'ihre@email.de',
        'placeholder_phone'  => '+49 ...',
        // Validation messages (used by StoreInquiryRequest)
        'validation' => [
            'name_required'        => 'Ihr Name ist erforderlich.',
            'email_required'       => 'Ihre E-Mail-Adresse ist erforderlich.',
            'email_email'          => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
            'project_type_required' => 'Bitte wählen Sie einen Projekttyp.',
            'project_type_in'      => 'Ungültiger Projekttyp.',
            'multilingual_in'      => 'Ungültige Sprachoption ausgewählt.',
            'description_required' => 'Bitte beschreiben Sie Ihr Projekt.',
            'description_min'      => 'Bitte beschreiben Sie Ihr Projekt mit mindestens 20 Zeichen.',
            'gdpr_accepted'        => 'Sie müssen der Datenschutzerklärung zustimmen.',
        ],
    ],

    // ── About ─────────────────────────────────────────────────────────────────
    'about' => [
        'eyebrow'             => 'Über mich',
        'heading'             => 'Xander Van Malder',
        'subtitle'            => 'Full-Stack-Entwickler · Druivenstreek, Belgien',
        'body_1'              => 'Ich entwickle Websites und Webanwendungen für Selbstständige, lokale Unternehmen und eigene Projekte. Mein Fokus liegt auf Dingen, die funktionieren: klar entwickelt, sicher, wartungsfreundlich und passend zum Kunden.',
        'body_2'              => 'Ich habe mit Game Development begonnen und meinen Weg zur Full-Stack-Webentwicklung gefunden. Das gibt mir eine breite technische Grundlage: von Logik und Datenstrukturen bis zur Benutzeroberfläche und Produktdenken.',
        'body_3'              => 'Neben der Kundenarbeit entwickle ich eigene Produkte über :brand: Apps, Spiele und Tools, die ich selbst konzipiert und umgesetzt habe. Das lehrt mich Dinge, die man nicht lernt, wenn man nur im Auftrag arbeitet.',
        'body_4'              => 'Ich arbeite lieber an weniger Projekten mit mehr Sorgfalt als an vielen Projekten oberflächlich. Sie arbeiten direkt mit mir — kein Projektmanager, keine Auslagerung.',
        'cta_contact'         => 'Kontakt aufnehmen',
        'cta_showcase'        => 'Showcase ansehen',
        'tech_heading'        => 'Technologien',
        'focus_heading'       => 'Schwerpunkte',
        'focus_items'         => ['Benutzerfreundliche Oberflächen', 'Sicherer und wartungsfreundlicher Code', 'Klare Projektstruktur', 'Ehrliche Kommunikation', 'Projekte vollständig abschließen'],
        'projects_heading'    => 'Eigene Projekte · VM Studios',
        'vm_studios_eyebrow'  => 'Eigene Projekte',
        'vm_studios_heading'  => 'VM Studios',
        'vm_studios_body'     => 'Neben der Kundenarbeit entwickle ich eigene Apps, Spiele und digitale Projekte über VM Studios. Sie demonstrieren meinen technischen Hintergrund, mein Produktdenken und meine Fähigkeit, Ideen bis zu einem fertigen, funktionierenden Produkt umzusetzen.',
        'project_proves'      => 'Was es zeigt',
        'project_tech'        => 'Technologien',
    ],

    // ── Showcase ──────────────────────────────────────────────────────────────
    'showcase' => [
        'eyebrow'           => 'Showcase',
        'heading'           => 'Showcase',
        'body'              => 'Interaktive Details, die zeigen, wie eine Website klarer und professioneller wirken kann. Von subtiler Hero-Animation bis zu Formular-Feedback und Scroll-Vorschau.',
        'note'              => 'Dies sind Demos technischer Möglichkeiten — keine Kundenprojekte. Die echten Leistungen finden Sie auf der :link.',
        'note_link'         => 'Leistungsseite',
        'card_hero_eyebrow' => 'Interaktiver Hero-Hintergrund',
        'card_hero_title'   => 'Interaktiver Hero-Hintergrund',
        'card_hero_body'    => 'Subtile animierte Linien und Lichtakzente verleihen einer Website mehr Charakter, ohne die Botschaft zu überlagern. Canvas 2D, keine externen Bibliotheken.',
        'card_hero_value'   => 'Kundenwert: mehr Charakter ohne die Botschaft zu dominieren.',
        'card_hero_cta'     => 'Studio-Intro ansehen',
        'card_ui_eyebrow'   => 'UI-Details',
        'card_ui_title'     => 'UI-Mikrointeraktionen',
        'card_ui_body'      => 'Hover-Zustände, aktive Zustände, deaktivierte Zustände, Fokus-Feedback und Formularschritte machen eine Website klarer und professioneller in der Nutzung.',
        'card_ui_cta'       => 'Kontaktformular ansehen',
        'card_scroll_eyebrow' => 'Website-Ablauf',
        'card_scroll_title'   => 'Scroll-Vorschau für Websites',
        'card_scroll_body'    => 'Eine Website soll nicht nur gut aussehen — sie soll Besucher logisch führen: vom ersten Eindruck über Leistungen und Vertrauen bis zum Kontakt.',
        'card_cf_eyebrow'   => 'Kontaktführung',
        'card_cf_title'     => 'Kontaktführung & Formularerfahrung',
        'card_cf_body'      => 'Ein gutes Formular fühlt sich nicht wie ein Hindernis an. Mit klaren Schritten, Feedback und einer Zusammenfassung ist es für Besucher einfacher, eine Anfrage zu senden.',
        'card_cf_cta'       => 'Kontaktformular ansehen',
        'vm_studios_heading' => 'VM Studios · eigene Projekte',
        'vm_studios_body'    => 'Beweis technischer Tiefe über mehrere Plattformen und Stacks.',
        'vm_details_link'    => 'Details auf Über mich',
        'cta_heading'        => 'Bereit, gemeinsam etwas zu entwickeln?',
        'cta_body'           => 'Der Showcase zeigt technische Kompetenz. Die echte Arbeit beginnt mit einem Gespräch.',
        'cta_primary'        => 'Projekt besprechen',
        'cta_secondary'      => 'Leistungen ansehen',
        'scroll_tabs' => [
            'first_impression' => 'Erster Eindruck',
            'offer'            => 'Leistungen',
            'seo'              => 'SEO',
            'pricing'          => 'Preise',
            'contact'          => 'Kontakt',
        ],
        'scroll_captions' => [
            'first-impression' => 'Der Besucher sieht sofort, wer Sie sind und was Sie anbieten.',
            'offer'            => 'Leistungen sind klar aufgeteilt, damit Besucher schnell finden, was sie brauchen.',
            'seo'              => 'Eine solide SEO-Grundlage hilft Google und Besuchern, die Website besser zu verstehen.',
            'pricing'          => 'Richtpreise schaffen Vertrauen, ohne Sie auf jedes Detail festzulegen.',
            'contact'          => 'Ein klarer CTA senkt die Schwelle, eine Anfrage zu senden.',
        ],
    ],

    // ── Footer ────────────────────────────────────────────────────────────────
    'footer' => [
        'rights'       => 'Alle Rechte vorbehalten.',
        'contact_cta'  => 'Möchten Sie zusammenarbeiten oder haben Sie eine Frage?',
        'contact_btn'  => 'Nachricht senden',
        'studio_label' => 'Studio',
    ],

    // ── Process ───────────────────────────────────────────────────────────────
    'process' => [
        'heading'      => 'Arbeitsweise',
        'eyebrow'      => 'Wie ich arbeite',
        'heading_full' => 'Ein klarer Ablauf von Anfang bis Ende',
        'body'         => 'Keine Überraschungen unterwegs. Schritt für Schritt, mit klarer Kommunikation.',
        'steps' => [
            ['title' => 'Kennenlernen',             'desc' => 'Wir besprechen Ihr Projekt, Ihre Ziele und Ihre Erwartungen.'],
            ['title' => 'Angebot und Umfang',       'desc' => 'Ein klares Angebot mit Ansatz und Preisindikation — keine Überraschungen.'],
            ['title' => 'Design und Struktur',      'desc' => 'Seitenstruktur und visuelle Ausrichtung werden vor der Entwicklung festgelegt.'],
            ['title' => 'Entwicklung',              'desc' => 'Ich entwickle mit Fokus auf Qualität, Geschwindigkeit und Sicherheit.'],
            ['title' => 'Feedback und Launch',      'desc' => 'Sie geben Feedback, wir verfeinern und die Website geht online.'],
        ],
    ],

    // ── SEO meta ─────────────────────────────────────────────────────────────
    'seo' => [
        'home_title'      => 'Van Malder Studio | Professionelle Websites aus Belgien',
        'home_desc'       => 'Van Malder Studio entwickelt professionelle Websites, Webanwendungen und digitale Lösungen für Selbstständige und lokale Unternehmen in Belgien und der Umgebung.',
        'home_og_title'   => 'Van Malder Studio | Professionelle Websites aus Belgien',
        'services_title'  => 'Leistungen | Websites, Webanwendungen und Wartung',
        'services_desc'   => 'Entdecken Sie die Leistungen von Van Malder Studio: Website-Erstellung, Neugestaltung, Webanwendungen, Kontaktformulare und technische Wartung für lokale Unternehmen.',
        'services_og_title' => 'Leistungen | Van Malder Studio',
        'pricing_title'   => 'Preise | Website ab €750',
        'pricing_desc'    => 'Richtpreise für Websites, Webanwendungen und Wartung bei Van Malder Studio. Transparente Startpreise je nach Umfang, Sprachen und Funktionen.',
        'pricing_og_title' => 'Preise | Van Malder Studio',
        'about_title'     => 'Über mich | Xander Van Malder — Full-Stack-Entwickler',
        'about_desc'      => 'Xander Van Malder ist Full-Stack-Entwickler aus der Druivenstreek (Belgien) und entwickelt professionelle Websites, Webanwendungen und digitale Lösungen für Selbstständige und lokale Unternehmen.',
        'about_og_title'  => 'Über mich | Van Malder Studio',
        'contact_title'   => 'Kontakt | Ihr Projekt besprechen',
        'contact_desc'    => 'Nehmen Sie Kontakt mit Xander Van Malder auf, um eine neue Website, eine Webanwendung, eine Neugestaltung oder ein digitales Projekt zu besprechen.',
        'showcase_title'  => 'Showcase | Van Malder Studio',
        'showcase_desc'   => 'Interaktive Demos, die zeigen, wie Design-Details, UI-Mikrointeraktionen, Scroll-Vorschau und Formularerfahrung Websites klarer und professioneller machen.',
        'showcase_og_title' => 'Showcase | Van Malder Studio',
        'process_title'   => 'Arbeitsweise | Wie ich arbeite',
        'process_desc'    => 'Entdecken Sie die Arbeitsweise von Van Malder Studio: vom Kennenlernen und Angebot bis zu Design, Entwicklung und Launch.',
        'privacy_title'   => 'Datenschutzerklärung | Van Malder Studio',
        'privacy_desc'    => 'Datenschutzerklärung von Van Malder Studio.',
    ],

    // ── Landing pages (UI shell) ──────────────────────────────────────────────
    'landing_pages' => [
        'who_for_heading' => 'Was ist inbegriffen?',
        'faq_heading'     => 'Häufig gestellte Fragen',
        'related_heading' => 'Verwandte Leistungen',
        'developer_title' => 'Full-Stack-Entwickler · Druivenstreek, Belgien',
        'developer_note'  => 'Ich arbeite direkt mit Ihnen zusammen — keine Projektmanager, keine Auslagerung. Sie sprechen immer direkt mit dem Entwickler.',
        'cta_heading'     => 'Bereit, gemeinsam etwas zu entwickeln?',
        'cta_body'        => 'Erzählen Sie mir von Ihrem Projekt. Das erste Gespräch ist unverbindlich.',
        'cta_secondary'   => 'Über mich',
        'view_services'   => 'Alle Leistungen ansehen',
    ],

];
```

- [ ] **Step 2.2: Add validation keys to NL site.php**

Open `lang/nl/site.php`, find the `'contact'` section and add validation sub-array at the end of that section (after `'placeholder_phone'`):

```php
// After 'placeholder_phone' key:
'validation' => [
    'name_required'         => 'Je naam is verplicht.',
    'email_required'        => 'Je e-mailadres is verplicht.',
    'email_email'           => 'Voer een geldig e-mailadres in.',
    'project_type_required' => 'Kies een projecttype.',
    'project_type_in'       => 'Ongeldig projecttype.',
    'multilingual_in'       => 'Ongeldige taaloptie geselecteerd.',
    'description_required'  => 'Beschrijf je project.',
    'description_min'       => 'Beschrijf je project in minstens 20 tekens.',
    'gdpr_accepted'         => 'Je moet akkoord gaan met de privacyverklaring.',
],
```

- [ ] **Step 2.3: Add validation keys to FR site.php**

Open `lang/fr/site.php`, add to the `'contact'` section:

```php
'validation' => [
    'name_required'         => 'Votre nom est obligatoire.',
    'email_required'        => 'Votre adresse e-mail est obligatoire.',
    'email_email'           => 'Veuillez saisir une adresse e-mail valide.',
    'project_type_required' => 'Veuillez choisir un type de projet.',
    'project_type_in'       => 'Type de projet invalide.',
    'multilingual_in'       => 'Option de langue invalide sélectionnée.',
    'description_required'  => 'Veuillez décrire votre projet.',
    'description_min'       => 'Veuillez décrire votre projet en au moins 20 caractères.',
    'gdpr_accepted'         => 'Vous devez accepter la politique de confidentialité.',
],
```

- [ ] **Step 2.4: Add validation keys to EN site.php**

Open `lang/en/site.php`, add to the `'contact'` section:

```php
'validation' => [
    'name_required'         => 'Your name is required.',
    'email_required'        => 'Your email address is required.',
    'email_email'           => 'Please enter a valid email address.',
    'project_type_required' => 'Please choose a project type.',
    'project_type_in'       => 'Invalid project type.',
    'multilingual_in'       => 'Invalid language option selected.',
    'description_required'  => 'Please describe your project.',
    'description_min'       => 'Please describe your project in at least 20 characters.',
    'gdpr_accepted'         => 'You must agree to the privacy policy.',
],
```

- [ ] **Step 2.5: Commit**
```bash
git add lang/
git commit -m "feat: add German translations and locale-aware validation messages"
```

---

## Task 3 — Update layout + navigation for German

**Files:**
- Modify: `resources/views/components/layouts/app.blade.php`
- Modify: `resources/views/components/navigation.blade.php`

- [ ] **Step 3.1: Update app.blade.php hreflang to include de**

In `app.blade.php`, replace the entire `@php` block at the top:

```php
@php
    $locale      = app()->getLocale() ?: 'nl';
    $isReady     = config('studio.translations_ready.' . $locale, false);
    $robotsMeta  = (isset($noindex) && $noindex) ? 'noindex, nofollow'
                 : (!$isReady ? 'noindex' : 'index, follow');

    $routeName  = request()->route()?->getName() ?? '';
    $parts      = explode('.', $routeName);
    $baseName   = count($parts) > 1 ? implode('.', array_slice($parts, 1)) : ($parts[0] ?? 'home');
    if (in_array($baseName, ['landing', 'inquiries.store', 'home', ''])) $baseName = 'home';

    $hrefLangs = [];
    foreach (['nl', 'fr', 'en', 'de'] as $lang) {
        $key = $lang . '.' . $baseName;
        $hrefLangs[$lang] = Route::has($key) ? route($key) : route($lang . '.home');
    }
@endphp
```

- [ ] **Step 3.2: Update hreflang output in app.blade.php to include de**

Replace the hreflang block:
```php
    {{-- hreflang — only output when current locale translation is ready --}}
    @if($isReady)
    <link rel="alternate" hreflang="nl"        href="{{ $hrefLangs['nl'] }}">
    <link rel="alternate" hreflang="fr"        href="{{ $hrefLangs['fr'] }}">
    <link rel="alternate" hreflang="en"        href="{{ $hrefLangs['en'] }}">
    <link rel="alternate" hreflang="de"        href="{{ $hrefLangs['de'] }}">
    <link rel="alternate" hreflang="x-default" href="{{ $hrefLangs['nl'] }}">
    @endif
```

- [ ] **Step 3.3: Update OG locale in app.blade.php to include de**

Replace:
```php
    <meta property="og:locale" content="{{ $locale === 'fr' ? 'fr_BE' : ($locale === 'en' ? 'en_GB' : 'nl_BE') }}">
```
With:
```php
    <meta property="og:locale" content="{{ match($locale) { 'fr' => 'fr_BE', 'en' => 'en_GB', 'de' => 'de_BE', default => 'nl_BE' } }}">
```

- [ ] **Step 3.4: Update navigation.blade.php to include de in hrefLangs computation**

In `navigation.blade.php`, replace the `$langLinks` loop:
```php
    foreach (['nl', 'fr', 'en', 'de'] as $lang) {
        $key = $lang . '.' . $baseName;
        $langLinks[$lang] = Route::has($key) ? route($key) : route($lang . '.home');
    }
```

- [ ] **Step 3.5: Add DE to desktop language switcher in navigation.blade.php**

Replace:
```php
            @foreach(['nl' => 'NL', 'fr' => 'FR', 'en' => 'EN'] as $lang => $label)
```
With:
```php
            @foreach(['nl' => 'NL', 'fr' => 'FR', 'en' => 'EN', 'de' => 'DE'] as $lang => $label)
```

And update the `aria-label` mapping to include `de`:
```php
                   aria-label="{{ $lang === 'nl' ? 'Nederlands' : ($lang === 'fr' ? 'Français' : ($lang === 'en' ? 'English' : 'Deutsch')) }}">
```

- [ ] **Step 3.6: Add DE to mobile language switcher in navigation.blade.php**

Replace:
```php
                    @foreach(['nl' => 'NL', 'fr' => 'FR', 'en' => 'EN'] as $lang => $label)
```
With:
```php
                    @foreach(['nl' => 'NL', 'fr' => 'FR', 'en' => 'EN', 'de' => 'DE'] as $lang => $label)
```

- [ ] **Step 3.7: Commit**
```bash
git add resources/views/components/layouts/app.blade.php resources/views/components/navigation.blade.php
git commit -m "feat: add German to layout hreflang and navigation language switcher"
```

---

## Task 4 — Mark FR/EN translations_ready, finalise config

**Files:**
- Modify: `config/studio.php`

- [ ] **Step 4.1: Update config/studio.php**

French and English translations are complete. Mark them ready. Add German as not ready yet.

```php
'translations_ready' => [
    'nl' => true,
    'fr' => true,
    'en' => true,
    'de' => false,
],
```

When DE is fully reviewed and ready to index, change `de` to `true`.

- [ ] **Step 4.2: Commit**
```bash
git add config/studio.php
git commit -m "feat: mark FR and EN translations as ready, add de:false"
```

---

## Task 5 — Contact form locale fixes

**Files:**
- Modify: `resources/views/pages/contact.blade.php`
- Modify: `app/Http/Requests/StoreInquiryRequest.php`
- Modify: `app/Http/Controllers/InquiryController.php`

- [ ] **Step 5.1: Fix canonical in contact.blade.php**

Replace the layout opening tag canonical:
```php
{{-- Before --}}
<x-layouts.app
    :title="__('site.seo.contact_title')"
    :description="__('site.seo.contact_desc')"
    :canonical="route('contact')"
>

{{-- After --}}
@php
    $loc = app()->getLocale() ?: 'nl';
    $canonicalRoute = \Illuminate\Support\Facades\Route::has($loc . '.contact') ? route($loc . '.contact') : route('contact');
@endphp
<x-layouts.app
    :title="__('site.seo.contact_title')"
    :description="__('site.seo.contact_desc')"
    :canonical="$canonicalRoute"
>
```

Note: The `$loc` variable and `$privacyHref`/`$inquiryRoute` are already computed in the existing `@php` block further down. Move the canonical computation there instead of duplicating, if the existing `@php` block is the first one in the file. In practice, check whether the existing block can absorb the canonical. If you prefer minimal change, just add the small block above the layout tag as shown.

- [ ] **Step 5.2: Update StoreInquiryRequest messages() to use translations**

Replace the `messages()` method in `app/Http/Requests/StoreInquiryRequest.php`:

```php
public function messages(): array
{
    return [
        'name.required'                => __('site.contact.validation.name_required'),
        'email.required'               => __('site.contact.validation.email_required'),
        'email.email'                  => __('site.contact.validation.email_email'),
        'project_type.required'        => __('site.contact.validation.project_type_required'),
        'project_type.in'              => __('site.contact.validation.project_type_in'),
        'multilingual_needs.*.in'      => __('site.contact.validation.multilingual_in'),
        'project_description.required' => __('site.contact.validation.description_required'),
        'project_description.min'      => __('site.contact.validation.description_min'),
        'gdpr_consent.accepted'        => __('site.contact.validation.gdpr_accepted'),
    ];
}
```

This works because `app()->getLocale()` is already set by `SetLocale` middleware when `messages()` is called.

- [ ] **Step 5.3: Fix InquiryController redirect to be locale-aware**

Replace both redirects in `app/Http/Controllers/InquiryController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Services\InquiryService;
use Illuminate\Support\Facades\Route;

class InquiryController extends Controller
{
    public function __construct(private InquiryService $inquiryService) {}

    public function store(StoreInquiryRequest $request)
    {
        $locale = app()->getLocale() ?: 'nl';
        $contactRoute = Route::has($locale . '.contact') ? $locale . '.contact' : 'contact';

        if ($request->filled('website')) {
            return redirect()->route($contactRoute)->with('success', true);
        }

        $this->inquiryService->store($request->validated(), $request);

        return redirect()->route($contactRoute)->with('success', true);
    }
}
```

- [ ] **Step 5.4: Commit**
```bash
git add resources/views/pages/contact.blade.php app/Http/Requests/StoreInquiryRequest.php app/Http/Controllers/InquiryController.php
git commit -m "fix: locale-aware contact form canonical, error messages, and post-submit redirect"
```

---

## Task 6 — Add locale column to inquiries

**Files:**
- Create: `database/migrations/2026_05_29_100000_add_locale_to_inquiries_table.php`
- Modify: `app/Models/Inquiry.php`
- Modify: `app/Services/InquiryService.php`

- [ ] **Step 6.1: Create migration**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('locale', 5)->nullable()->after('gdpr_consent');
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn('locale');
        });
    }
};
```

- [ ] **Step 6.2: Add locale to Inquiry model $fillable**

In `app/Models/Inquiry.php`, add `'locale'` to the `$fillable` array (after `'user_agent'`):

```php
protected $fillable = [
    'name',
    'company_name',
    'email',
    'phone',
    'existing_website_url',
    'project_type',
    'timeline',
    'budget_range',
    'multilingual_needs',
    'other_language',
    'content_admin_needs',
    'needs',
    'project_description',
    'gdpr_consent',
    'source',
    'ip_hash',
    'user_agent',
    'locale',
];
```

- [ ] **Step 6.3: Store locale in InquiryService**

In `app/Services/InquiryService.php`, add `'locale'` to the `Inquiry::create` call:

```php
$inquiry = Inquiry::create([
    // ... existing fields ...
    'user_agent'           => substr($request->userAgent() ?? '', 0, 255),
    'locale'               => app()->getLocale() ?: 'nl',
]);
```

- [ ] **Step 6.4: Run migration**

```bash
php artisan migrate
```

Expected output: `2026_05_29_100000_add_locale_to_inquiries_table ........ DONE`

- [ ] **Step 6.5: Commit**
```bash
git add database/migrations/2026_05_29_100000_add_locale_to_inquiries_table.php app/Models/Inquiry.php app/Services/InquiryService.php
git commit -m "feat: add locale column to inquiries table and store it on submission"
```

---

## Task 7 — Multilingual sitemap with hreflang

**Files:**
- Modify: `app/Http/Controllers/PageController.php`
- Modify: `resources/views/sitemap.blade.php`

- [ ] **Step 7.1: Update sitemap view to support hreflang alternates**

Replace `resources/views/sitemap.blade.php` with:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
    @foreach($routes as $route)
    <url>
        <loc>{{ $route['url'] }}</loc>
        <changefreq>{{ $route['freq'] }}</changefreq>
        <priority>{{ $route['priority'] }}</priority>
        @if(!empty($route['alternates']))
        @foreach($route['alternates'] as $lang => $altUrl)
        <xhtml:link rel="alternate" hreflang="{{ $lang }}" href="{{ $altUrl }}"/>
        @endforeach
        @endif
    </url>
    @endforeach
</urlset>
```

- [ ] **Step 7.2: Update PageController::sitemap() to include all locales**

Replace the `sitemap()` method in `app/Http/Controllers/PageController.php`:

```php
public function sitemap()
{
    $localeRoutes = config('localized-routes');
    $ready        = config('studio.translations_ready', []);

    $pages = ['home', 'services', 'process', 'pricing', 'about', 'contact', 'showcase', 'privacy'];
    $priorities = [
        'home'     => ['priority' => '1.0', 'freq' => 'weekly'],
        'services' => ['priority' => '0.9', 'freq' => 'monthly'],
        'pricing'  => ['priority' => '0.8', 'freq' => 'monthly'],
        'contact'  => ['priority' => '0.9', 'freq' => 'monthly'],
        'showcase' => ['priority' => '0.8', 'freq' => 'monthly'],
        'about'    => ['priority' => '0.7', 'freq' => 'monthly'],
        'process'  => ['priority' => '0.7', 'freq' => 'monthly'],
        'privacy'  => ['priority' => '0.3', 'freq' => 'yearly'],
    ];

    $routes = [];

    foreach (['nl', 'fr', 'en', 'de'] as $locale) {
        if (empty($ready[$locale])) {
            continue; // skip locales not yet ready to index
        }

        foreach ($pages as $page) {
            $routeName = $locale . '.' . $page;
            if (!Route::has($routeName)) {
                continue;
            }

            // Build hreflang alternates for this page across all ready locales
            $alternates = [];
            foreach (['nl', 'fr', 'en', 'de'] as $altLocale) {
                $altRoute = $altLocale . '.' . $page;
                if (Route::has($altRoute)) {
                    $alternates[$altLocale] = route($altRoute);
                }
            }
            $alternates['x-default'] = Route::has('nl.' . $page) ? route('nl.' . $page) : route($routeName);

            $routes[] = [
                'url'        => route($routeName),
                'priority'   => $priorities[$page]['priority'],
                'freq'       => $priorities[$page]['freq'],
                'alternates' => $alternates,
            ];
        }
    }

    // Dutch landing pages (noindex excluded)
    $landingPages = collect(config('landing-pages', []))
        ->filter(fn($p) => $p['locale'] === 'nl' && empty($p['noindex']));

    foreach ($landingPages as $lp) {
        $routes[] = [
            'url'      => url('/nl/' . $lp['slug']),
            'priority' => '0.8',
            'freq'     => 'monthly',
        ];
    }

    return response()
        ->view('sitemap', ['routes' => $routes])
        ->header('Content-Type', 'application/xml');
}
```

- [ ] **Step 7.3: Verify robots() method is correct**

Check current robots() method. It should look like:
```php
public function robots()
{
    $content = "User-agent: *\nAllow: /\nDisallow: /storage/\nSitemap: " . route('sitemap') . "\n";
    return response($content, 200)->header('Content-Type', 'text/plain');
}
```

This is correct. `/studio-intro` is noindex via the `$robotsMeta` computed in the layout — no need to add a robots.txt Disallow for it (noindex is sufficient).

- [ ] **Step 7.4: Commit**
```bash
git add app/Http/Controllers/PageController.php resources/views/sitemap.blade.php
git commit -m "feat: multilingual sitemap with hreflang alternates for all ready locales"
```

---

## Task 8 — Security review

**Files:**
- Review only; fix only real issues found

- [ ] **Step 8.1: CSRF check**

Verify all forms have `@csrf`. The contact form at line 98 in `contact.blade.php` has `@csrf`. No other forms. ✓

- [ ] **Step 8.2: Honeypot check**

`InquiryController::store` checks `$request->filled('website')` and silently succeeds. The honeypot field `website` is validated with `['nullable', 'max:0']` in `StoreInquiryRequest` — so if a bot fills it, the honeypot redirect fires first. Both layers are correct. ✓

- [ ] **Step 8.3: Rate limiting check**

Contact POST routes have `->middleware('throttle:5,1')`. This covers all locales since the loop applies it to each `$locale.inquiries.store` route and the legacy `inquiries.store`. ✓

- [ ] **Step 8.4: Input rendering check**

Search for any `{!! !!}` usage that renders user input:
```bash
grep -r '{!!' resources/views/ --include="*.blade.php"
```

Expected to find only: contact.blade.php `gdpr_note` and `gdpr_label` — both use `e()` to escape the URL and the link label text. This is correct: the HTML is hardcoded, only the URL/label are escaped. ✓

- [ ] **Step 8.5: Mass assignment check**

`Inquiry::$fillable` is explicit. The `locale` column we're adding will be in `$fillable`. `InquiryService` builds the create array explicitly — no `$request->all()` or mass-fill from user input. ✓

- [ ] **Step 8.6: Enum/allowlist validation check**

`project_type` uses `Rule::in([...])`. `multilingual_needs.*` uses `Rule::in([...])` with Dutch values (intentional — values are always Dutch regardless of UI language, only labels are translated). `needs.*` uses `Rule::in([...])`. ✓

- [ ] **Step 8.7: GDPR consent check**

`gdpr_consent` rule is `['accepted']` — requires truthy value "1". The privacy link in the form uses `route($loc . '.privacy')` which is locale-aware. ✓

- [ ] **Step 8.8: Check for APP_DEBUG in production**

Check `.env` is in `.gitignore`:
```bash
cat .gitignore | grep .env
```
Expected: `.env` is listed. If not, add it.

Document in code or README: `APP_DEBUG=false` must be set in production `.env`.

- [ ] **Step 8.9: No file uploads check**

No file upload fields in any form. No `enctype="multipart/form-data"`. ✓

- [ ] **Step 8.10: No admin panel exposed check**

No `/admin` routes. `studio-intro` is noindex but not sensitive. ✓

- [ ] **Step 8.11: No XSS in JS check**

Search for `innerHTML` or `eval` in JS files:
```bash
grep -r 'innerHTML\|eval(' resources/js/ --include="*.js"
```
If found, review context to ensure user input is never inserted unescaped.

- [ ] **Step 8.12: IP storage check**

`InquiryService` stores `hash('sha256', $request->ip())` — hashed, not raw IP. This is privacy-compliant. ✓

- [ ] **Step 8.13: Commit any security fixes found**
```bash
git add <changed files>
git commit -m "fix: security review findings"
```
(If no issues found, skip commit.)

---

## Task 9 — Final checks

- [ ] **Step 9.1: Run php artisan route:list and verify**
```bash
php artisan route:list | grep -E "^(GET|POST).*/[a-z]{2}/"
```
Expected: Routes exist for nl, fr, en, de prefixes for all 8 pages + contact POST.

- [ ] **Step 9.2: Run php artisan migrate**
```bash
php artisan migrate
```
Expected: All migrations up to date (locale column already added in Task 6).

- [ ] **Step 9.3: Run npm run build**
```bash
npm run build
```
Expected: Build succeeds, no new heavy packages added.

- [ ] **Step 9.4: Run php artisan view:cache**
```bash
php artisan view:cache
```
Expected: All Blade views compile without errors.

- [ ] **Step 9.5: Verify root redirect**

Hit `GET /` — confirm 301 redirect to `/nl`.

- [ ] **Step 9.6: Verify de routes exist**

```bash
php artisan route:list | grep "^GET.*de/"
```
Expected: de.home, de.services (dienstleistungen), de.process (arbeitsweise), de.pricing (preise), de.about (ueber-mich), de.showcase, de.contact (kontakt), de.privacy (datenschutzerklaerung).

- [ ] **Step 9.7: Verify DE language switcher**

Visit `/nl` in browser. Language switcher should show NL FR EN DE. Click DE → should go to `/de`.

- [ ] **Step 9.8: Verify hreflang output**

View source on `/nl` — should see 5 hreflang tags: nl, fr, en, de, x-default.
View source on `/de/dienstleistungen` — should NOT see hreflang (de is not ready yet, `$isReady = false`).

- [ ] **Step 9.9: Verify contact form from German locale**

Visit `/de/kontakt`. Form should render in German. Submit with empty name — should show German error message.

- [ ] **Step 9.10: Verify sitemap includes nl/fr/en pages**

Hit `/sitemap.xml` — should include nl, fr, en pages (de not yet, since `de:false`). Each URL should have xhtml:link alternates.

- [ ] **Step 9.11: Verify studio-intro stays noindex**

View source on `/studio-intro` — robots meta should be `noindex`.

- [ ] **Step 9.12: Final commit summary**
```bash
git add .
git commit -m "chore: post-multilingual final checks passed"
```

---

## Post-implementation Manual Tasks

These require human review and are NOT automated:

1. **Review German copy** — Have a native German speaker review `lang/de/site.php` before marking `de: true` in `config/studio.php`.
2. **Review FR/EN copy for naturalness** — Translations exist and are marked ready; a final editorial pass is recommended.
3. **Privacy page translations** — `resources/views/pages/privacy.blade.php` likely still has Dutch content. Create localized versions or add translation keys for it.
4. **German privacy page content** — The `datenschutzerklaerung` route will serve whatever `pages/privacy.blade.php` contains — ensure it has German content or translation support.
5. **Email notifications** — `InquiryService` has a `TODO` for email. When implemented, use locale to send in the right language.
6. **Production `.env`** — Set `APP_DEBUG=false` and `APP_ENV=production`.
7. **Google Search Console** — Submit updated sitemap after deployment.
8. **Confirm `de` indexing** — Once German copy is reviewed and approved, change `'de' => false` to `'de' => true` in `config/studio.php` and re-deploy.
