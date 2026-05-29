# Full Multilingual Translation Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Translate all remaining public pages (about, showcase, process, privacy, footer) into NL/FR/EN/DE, fix services page addons + white space issue, and ensure all SEO metadata is locale-aware.

**Architecture:** All translations live in `lang/{locale}/site.php`. Blade templates use `__('site.*')` helpers. Locale is set by `SetLocale` middleware. Routes are already configured for nl/fr/en/de. The homepage, services, pricing, and contact pages already use `__()` throughout — this plan covers the remaining pages that still have hardcoded Dutch text.

**Tech Stack:** PHP 8.x / Laravel 11, Blade, Tailwind CSS, vanilla JS

---

## Current State (read before touching anything)

**Already done — do not re-do:**
- `lang/nl/site.php`, `lang/fr/site.php`, `lang/en/site.php`, `lang/de/site.php` all exist and are comprehensive
- Homepage, services, pricing, contact pages already use `__()` throughout
- Navigation component already locale-aware
- Routes nl/fr/en/de all registered

**What still needs work:**
1. `footer.blade.php` — hardcoded "Diensten", "Werkwijze", "Stuur een bericht", etc.
2. `about.blade.php` — entirely hardcoded Dutch; translations EXIST in `site.php` but template doesn't use them
3. `showcase.blade.php` — entirely hardcoded Dutch
4. `process.blade.php` — entirely hardcoded Dutch
5. `privacy.blade.php` — entirely hardcoded Dutch; needs per-locale content
6. Services addons: hard price badges need softer labels (update `lang/nl/site.php` + FR/EN/DE)
7. Footer `mt-24` causes white gap on services page
8. SEO metadata on about/showcase/process/privacy uses hardcoded strings and non-locale-aware canonicals
9. FR/EN/DE missing new translation keys from previous sessions (service_forms_ai_note, vat_note, etc.)
10. Projects config in Dutch — need locale-aware status labels + project content translations

---

## File Map

| File | Action | Purpose |
|------|--------|---------|
| `resources/views/components/footer.blade.php` | Modify | Use `__()` + locale-aware routes |
| `resources/views/pages/about.blade.php` | Modify | Use `__()` throughout |
| `resources/views/pages/showcase.blade.php` | Modify | Use `__()` throughout |
| `resources/views/pages/process.blade.php` | Modify | Use `__()` throughout |
| `resources/views/pages/privacy.blade.php` | Modify | Use `__()` throughout |
| `lang/nl/site.php` | Modify | Update addons labels + add privacy + project status + missing keys |
| `lang/fr/site.php` | Modify | Add missing keys + privacy content + project status + addons |
| `lang/en/site.php` | Modify | Same as FR |
| `lang/de/site.php` | Modify | Same as FR |

---

## Task 1 — Fix footer spacing and make footer locale-aware

**Files:**
- Modify: `resources/views/components/footer.blade.php`

The footer has `mt-24` on its root element, which causes the large white gap on the services page (which ends with a dark full-width CTA). Change `mt-24` to `mt-0`. Also wire all hardcoded text to translation keys.

- [ ] **Step 1.1: Remove mt-24 from footer**

Replace the opening `<footer>` tag:
```html
{{-- Before --}}
<footer class="bg-slate-900 text-slate-300 mt-24">

{{-- After --}}
<footer class="bg-slate-900 text-slate-300">
```

- [ ] **Step 1.2: Replace hardcoded footer nav links with locale-aware routes**

Replace the entire footer nav links section. The nav labels use `site.nav.*` keys that already exist. The routes must be locale-aware. Replace the hardcoded links array:

```php
{{-- Before --}}
@foreach([
    ['route' => 'services',  'label' => 'Diensten'],
    ['route' => 'showcase',  'label' => 'Showcase'],
    ['route' => 'process',   'label' => 'Werkwijze'],
    ['route' => 'pricing',   'label' => 'Prijzen'],
    ['route' => 'about',     'label' => 'Over mij'],
    ['route' => 'privacy',   'label' => 'Privacyverklaring'],
] as $link)
<li>
    <a href="{{ route($link['route']) }}" ...>{{ $link['label'] }}</a>
</li>
@endforeach

{{-- After --}}
@php
    $locale = app()->getLocale() ?: 'nl';
    $footerLinks = [
        ['key' => 'services', 'label' => __('site.nav.services')],
        ['key' => 'showcase', 'label' => __('site.nav.showcase')],
        ['key' => 'process',  'label' => __('site.nav.process')],
        ['key' => 'pricing',  'label' => __('site.nav.pricing')],
        ['key' => 'about',    'label' => __('site.nav.about')],
        ['key' => 'privacy',  'label' => __('site.footer.privacy_label')],
    ];
@endphp
@foreach($footerLinks as $link)
@php
    $footerHref = \Illuminate\Support\Facades\Route::has($locale . '.' . $link['key'])
        ? route($locale . '.' . $link['key'])
        : route($link['key']);
@endphp
<li>
    <a href="{{ $footerHref }}" class="text-sm text-slate-400 hover:text-white transition-colors duration-200">
        {{ $link['label'] }}
    </a>
</li>
@endforeach
```

- [ ] **Step 1.3: Replace hardcoded footer contact text**

```php
{{-- Before --}}
<h3 class="...">Contact</h3>
<p class="text-sm text-slate-400 leading-relaxed mb-4">Wil je samenwerken of heb je een vraag?</p>
<a href="{{ route('contact') }}" ...>
    Stuur een bericht
    ...
</a>
```

```php
{{-- After --}}
@php
    $footerContactHref = \Illuminate\Support\Facades\Route::has($locale . '.contact')
        ? route($locale . '.contact')
        : route('contact');
@endphp
<h3 class="text-xs font-semibold text-white uppercase tracking-wider mb-4">{{ __('site.nav.contact') }}</h3>
<p class="text-sm text-slate-400 leading-relaxed mb-4">{{ __('site.footer.contact_cta') }}</p>
<a href="{{ $footerContactHref }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold bg-blue-700 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 cursor-pointer">
    {{ __('site.footer.contact_btn') }}
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
    </svg>
</a>
```

- [ ] **Step 1.4: Replace hardcoded footer bottom bar text**

```php
{{-- Before --}}
<p>&copy; {{ date('Y') }} {{ config('studio.brand_name') }}. Alle rechten voorbehouden.</p>
<div ...>
    <a href="{{ route('privacy') }}" ...>Privacyverklaring</a>
    ...
    <p>{{ config('studio.tagline') }}</p>
</div>

{{-- After --}}
@php
    $footerHomeHref = \Illuminate\Support\Facades\Route::has($locale . '.home')
        ? route($locale . '.home')
        : route('home');
    $footerPrivacyHref = \Illuminate\Support\Facades\Route::has($locale . '.privacy')
        ? route($locale . '.privacy')
        : route('privacy');
@endphp
<p>&copy; {{ date('Y') }} {{ config('studio.brand_name') }}. {{ __('site.footer.rights') }}</p>
<div class="flex items-center gap-4">
    <a href="{{ $footerPrivacyHref }}" class="hover:text-slate-400 transition-colors duration-200">{{ __('site.footer.privacy_label') }}</a>
    <span aria-hidden="true">·</span>
    <p>{{ config('studio.tagline') }}</p>
</div>
```

Also replace the brand link href:
```php
<a href="{{ $footerHomeHref }}" class="font-serif text-lg font-medium text-white hover:text-blue-400 transition-colors duration-200">
    Van Malder Studio
</a>
```

Also replace the Studio heading:
```php
<h3 class="text-xs font-semibold text-white uppercase tracking-wider mb-4">{{ __('site.footer.studio_label') }}</h3>
```

- [ ] **Step 1.5: Add `footer.privacy_label` key to lang/nl/site.php**

In `lang/nl/site.php`, find the `'footer'` section and add:
```php
'privacy_label' => 'Privacyverklaring',
```

- [ ] **Step 1.6: Commit**
```bash
git add resources/views/components/footer.blade.php lang/nl/site.php
git commit -m "fix: locale-aware footer + remove mt-24 gap before footer"
```

---

## Task 2 — Update services addons to use softer labels

**Files:**
- Modify: `lang/nl/site.php` (services.addons_items)

- [ ] **Step 2.1: Replace addons_items in lang/nl/site.php**

Find the `'addons_items'` array inside `'services'` and replace it:

```php
'addons_items' => [
    [
        'title' => 'Website audit & verbeteradvies',
        'price' => 'Korte check mogelijk',
        'desc'  => 'Ik kijk naar je huidige website en geef concreet aan wat beter kan: uitstraling, mobiel gebruik, snelheid, contactflow en SEO-basis. Een korte check kan tijdens de kennismaking.',
    ],
    [
        'title' => 'Google Business Profile ondersteuning',
        'price' => 'Lokale zichtbaarheid',
        'desc'  => "Contactgegevens, diensten, openingsuren, websitekoppeling en basisadvies rond reviews en foto's — zodat je Google-profiel vertrouwen wekt.",
    ],
    [
        'title' => 'Contentstructuur & teksten',
        'price' => 'Vaak inbegrepen',
        'desc'  => 'Ik help je aanbod duidelijk structureren zodat bezoekers sneller begrijpen wat je doet. Extra hulp bij duidelijke websiteteksten kan besproken worden.',
    ],
    [
        'title' => 'Meertalige websites',
        'price' => 'Op aanvraag',
        'desc'  => 'Voor bedrijven in België kan de website meertalig worden opgebouwd met een duidelijke taalstructuur. De aanpak hangt af van het aantal talen, pagina\'s en content.',
    ],
    [
        'title' => 'Basis visuele richting',
        'price' => 'Vaak inbegrepen',
        'desc'  => 'Heb je nog geen sterke stijl? Dan help ik met een eenvoudige professionele richting voor kleuren, typografie en uitstraling.',
    ],
    [
        'title' => 'Integraties',
        'price' => 'Op aanvraag',
        'desc'  => "Koppelingen aan tools die je al gebruikt: Google Maps, WhatsApp, e-mailmeldingen, nieuwsbrief of later Google Sheets en CRM. De complexiteit bepaalt de aanpak.",
    ],
],
```

- [ ] **Step 2.2: Commit**
```bash
git add lang/nl/site.php
git commit -m "fix: services addons — softer labels instead of hard mini-prices"
```

---

## Task 3 — Add missing new keys to FR/EN/DE site.php

Keys added in previous sessions that are missing from FR/EN/DE:
- `home.service_forms_ai_note`
- `home.service_forms_cta`
- `home.service_webshop_title` (changed from "Webshop" to "Productcatalogus & online verkoop")
- `home.pricing_vat_note`
- `pricing.vat_note`
- `contact.need_ai_summary`
- `contact.need_auto_followup`
- `services.items.formulieren` title/desc/cta updated for smart request flow
- `footer.privacy_label` (new)
- Updated `services.addons_items` with softer labels

**Files:**
- Modify: `lang/fr/site.php`
- Modify: `lang/en/site.php`
- Modify: `lang/de/site.php`

- [ ] **Step 3.1: Update lang/fr/site.php with missing keys**

In the `'home'` section, add after `'service_forms_body'`:
```php
'service_forms_ai_note'    => 'Support IA possible : résumé, informations manquantes ou base de devis préparée. Vous approuvez toujours.',
'service_forms_cta'        => 'Voir le parcours de demande',
```

Update `service_webshop_title`:
```php
'service_webshop_title'    => 'Catalogue produits & vente en ligne',
```

Update `service_webshop_body`:
```php
'service_webshop_body'     => 'Pour les produits, services ou la vente en ligne simple. Du catalogue produits à un parcours de demande ou une boutique avec panier et paiements — selon la portée et les besoins.',
```

Add `pricing_vat_note` in the `'home'` section after `pricing_link`:
```php
'pricing_vat_note' => 'Tous les prix indicatifs sont hors TVA.',
```

In the `'pricing'` section, add after `'note'`:
```php
'vat_note' => 'Tous les prix indicatifs sont hors TVA, sauf mention contraire.',
```

In `'contact'` section, after `'need_advice'`:
```php
'need_ai_summary'    => 'Je veux un support IA pour résumé ou préparation de devis',
'need_auto_followup' => 'Je veux automatiser le suivi des demandes',
```

In `'footer'` section, add:
```php
'privacy_label' => 'Politique de confidentialité',
```

Update `'services.items.formulieren'`:
```php
'formulieren' => [
    'title'       => 'Parcours de demande intelligent & suivi',
    'short'       => 'Pour les entreprises qui veulent perdre moins de temps avec des e-mails peu clairs.',
    'description' => 'Je conçois des formulaires de contact et de devis qui collectent les bonnes informations, structurent les demandes et préparent le suivi. Pas juste "nom, e-mail, message" — mais un parcours qui clarifie directement ce dont vous avez besoin. Support IA possible pour résumé, informations manquantes ou base de devis. Vous approuvez toujours.',
    'bullets'     => ['Formulaire de devis ou d\'intake sur mesure', 'Formulaire multi-étapes avec validation et récapitulatif', 'Demande de rendez-vous ou flux de réservation', 'Suivi des demandes préparé', 'Optionnel : résumé IA ou base de devis — vous approuvez', 'Sécurisé, anti-spam et conforme RGPD'],
    'cta'         => 'Discutons de votre parcours de demande',
],
```

Update `'services.addons_items'`:
```php
'addons_items' => [
    ['title' => 'Audit de site & conseils',             'price' => 'Bref audit possible',      'desc' => 'Je passe en revue votre site actuel et donne des conseils concrets : apparence, mobile, vitesse, parcours de contact et bases SEO. Un bref audit peut avoir lieu lors du premier contact.'],
    ['title' => 'Google Business Profile',               'price' => 'Visibilité locale',        'desc' => 'Coordonnées, services, horaires, lien vers le site et conseils de base sur les avis et photos — pour que votre profil Google inspire confiance.'],
    ['title' => 'Structure de contenu & rédaction',      'price' => 'Souvent inclus',           'desc' => 'Je vous aide à structurer clairement votre offre pour que les visiteurs comprennent rapidement ce que vous faites. Une aide supplémentaire pour des textes clairs peut être discutée.'],
    ['title' => 'Sites web multilingues',                'price' => 'Sur demande',              'desc' => 'Votre site peut être conçu en plusieurs langues avec une structure linguistique claire. L\'approche dépend du nombre de langues, de pages et de contenu.'],
    ['title' => 'Direction visuelle de base',            'price' => 'Souvent inclus',           'desc' => 'Pas encore de style visuel fort ? Je peux aider avec une direction simple et professionnelle pour les couleurs, la typographie et l\'apparence.'],
    ['title' => 'Intégrations',                          'price' => 'Sur demande',              'desc' => 'Connexion aux outils que vous utilisez déjà : Google Maps, WhatsApp, notifications e-mail, newsletter ou Google Sheets et CRM. La complexité détermine l\'approche.'],
],
```

- [ ] **Step 3.2: Update lang/en/site.php with missing keys**

Add in `'home'` section:
```php
'service_forms_ai_note' => 'AI assistance available: summary, missing information or quote foundation prepared. You always approve.',
'service_forms_cta'     => 'View request flow',
```

Update `service_webshop_title`:
```php
'service_webshop_title' => 'Product catalogue & online sales',
```

Update `service_webshop_body`:
```php
'service_webshop_body' => 'For products, services or simple online sales. From a product catalogue to a request flow or a webshop with shopping cart and payments — depending on scope.',
```

Add `pricing_vat_note` in `'home'`:
```php
'pricing_vat_note' => 'All guide prices are excluding VAT.',
```

Add in `'pricing'`:
```php
'vat_note' => 'All guide prices are excluding VAT unless stated otherwise.',
```

Add in `'contact'`:
```php
'need_ai_summary'    => 'I want AI assistance for summary or quote preparation',
'need_auto_followup' => 'I want to automate request follow-up',
```

Add in `'footer'`:
```php
'privacy_label' => 'Privacy Policy',
```

Update `'services.items.formulieren'`:
```php
'formulieren' => [
    'title'       => 'Smart request flow & follow-up',
    'short'       => 'For businesses that want to spend less time on unclear enquiries and loose emails.',
    'description' => 'I build contact and quote forms that collect the right information, structure enquiries and set up follow-up. Not just "name, email, message" — but a request flow that immediately clarifies what you need. AI assistance available for summaries, missing information or a quote foundation. You always approve.',
    'bullets'     => ['Custom quote or intake form', 'Multi-step form with validation and summary', 'Appointment request or booking flow', 'Request follow-up prepared', 'Optional: AI summary or quote foundation — you approve', 'Secure, spam-proof and GDPR-compliant'],
    'cta'         => 'Discuss your request flow',
],
```

Update `'services.addons_items'`:
```php
'addons_items' => [
    ['title' => 'Website audit & improvement advice',  'price' => 'Short check possible',     'desc' => 'I review your current website and give concrete advice on what can be improved: appearance, mobile use, speed, contact flow and SEO foundations. A short check can happen during our introduction.'],
    ['title' => 'Google Business Profile support',     'price' => 'Local visibility',         'desc' => 'Contact details, services, opening hours, website link and basic advice on reviews and photos — so your Google profile builds trust.'],
    ['title' => 'Content structure & copy',            'price' => 'Often included',           'desc' => 'I help you structure your offer clearly so visitors quickly understand what you do. Extra help with clear website copy can be discussed.'],
    ['title' => 'Multilingual websites',               'price' => 'On request',               'desc' => 'Your website can be built in multiple languages with a clear language structure. The approach depends on the number of languages, pages and content.'],
    ['title' => 'Basic visual direction',              'price' => 'Often included',           'desc' => 'Don\'t have a strong visual style yet? I can help with a simple, professional direction for colours, typography and appearance.'],
    ['title' => 'Integrations',                        'price' => 'On request',               'desc' => 'Connecting to tools you already use: Google Maps, WhatsApp, email notifications, newsletter or Google Sheets and CRM. Complexity determines the approach.'],
],
```

- [ ] **Step 3.3: Update lang/de/site.php with missing keys**

Add in `'home'` section:
```php
'service_forms_ai_note' => 'KI-Unterstützung möglich: Zusammenfassung, fehlende Informationen oder Angebotsbasis vorbereiten. Sie genehmigen immer.',
'service_forms_cta'     => 'Anfrageprozess ansehen',
```

Update `service_webshop_title`:
```php
'service_webshop_title' => 'Produktkatalog & Online-Verkauf',
```

Update `service_webshop_body`:
```php
'service_webshop_body' => 'Für Produkte, Dienstleistungen oder einfachen Online-Verkauf. Vom Produktkatalog bis zu einem Anfrageprozess oder Webshop mit Warenkorb und Zahlungen — je nach Umfang.',
```

Add `pricing_vat_note` in `'home'`:
```php
'pricing_vat_note' => 'Alle Richtpreise verstehen sich exkl. MwSt.',
```

Add in `'pricing'`:
```php
'vat_note' => 'Alle Richtpreise verstehen sich exkl. MwSt., sofern nicht anders angegeben.',
```

Add in `'contact'`:
```php
'need_ai_summary'    => 'Ich möchte KI-Unterstützung für Zusammenfassung oder Angebotsvorbereitung',
'need_auto_followup' => 'Ich möchte die Anfragebearbeitung automatisieren',
```

Add in `'footer'`:
```php
'privacy_label' => 'Datenschutzerklärung',
```

Update `'services.items.formulieren'`:
```php
'formulieren' => [
    'title'       => 'Smarter Anfrageprozess & Nachverfolgung',
    'short'       => 'Für Unternehmen, die weniger Zeit mit unklaren Anfragen und losen E-Mails verlieren möchten.',
    'description' => 'Ich entwickle Kontakt- und Angebotsformulare, die die richtigen Informationen sammeln, Anfragen strukturieren und die Nachverfolgung vorbereiten. Nicht nur „Name, E-Mail, Nachricht" — sondern ein Anfrageprozess, der sofort klärt, was Sie brauchen. KI-Unterstützung möglich für Zusammenfassungen, fehlende Informationen oder Angebotsbasis. Sie genehmigen immer.',
    'bullets'     => ['Individuelles Angebots- oder Intake-Formular', 'Mehrstufiges Formular mit Validierung und Zusammenfassung', 'Terminanfrage oder Buchungsprozess', 'Nachverfolgung von Anfragen vorbereitet', 'Optional: KI-Zusammenfassung oder Angebotsbasis — Sie genehmigen', 'Sicher, spam-geschützt und DSGVO-konform'],
    'cta'         => 'Ihren Anfrageprozess besprechen',
],
```

Update `'services.addons_items'`:
```php
'addons_items' => [
    ['title' => 'Website-Audit & Verbesserungsberatung', 'price' => 'Kurzcheck möglich',    'desc' => 'Ich analysiere Ihre aktuelle Website und gebe konkrete Empfehlungen: Erscheinungsbild, mobiler Einsatz, Geschwindigkeit, Kontaktführung und SEO-Grundlagen. Ein Kurzcheck kann beim Kennenlernen stattfinden.'],
    ['title' => 'Google Business Profil Unterstützung',  'price' => 'Lokale Sichtbarkeit',  'desc' => 'Kontaktdaten, Leistungen, Öffnungszeiten, Website-Verknüpfung und Grundberatung zu Bewertungen und Fotos — damit Ihr Google-Profil Vertrauen weckt.'],
    ['title' => 'Inhaltsstruktur & Texte',               'price' => 'Oft inbegriffen',      'desc' => 'Ich helfe Ihnen, Ihr Angebot klar zu strukturieren, damit Besucher schnell verstehen, was Sie tun. Zusätzliche Hilfe bei klaren Website-Texten kann besprochen werden.'],
    ['title' => 'Mehrsprachige Websites',                'price' => 'Auf Anfrage',          'desc' => 'Ihre Website kann in mehreren Sprachen aufgebaut werden mit einer klaren Sprachstruktur. Der Ansatz hängt von der Anzahl der Sprachen, Seiten und Inhalte ab.'],
    ['title' => 'Visuelle Grundausrichtung',             'price' => 'Oft inbegriffen',      'desc' => 'Noch keinen starken visuellen Stil? Ich helfe mit einer einfachen, professionellen Richtung für Farben, Typografie und Erscheinungsbild.'],
    ['title' => 'Integrationen',                         'price' => 'Auf Anfrage',          'desc' => 'Verknüpfung mit Tools, die Sie bereits nutzen: Google Maps, WhatsApp, E-Mail-Benachrichtigungen, Newsletter oder Google Sheets und CRM. Die Komplexität bestimmt den Ansatz.'],
],
```

- [ ] **Step 3.4: Commit**
```bash
git add lang/fr/site.php lang/en/site.php lang/de/site.php
git commit -m "feat: add missing translation keys to FR/EN/DE (forms AI, vat note, new needs, updated addons)"
```

---

## Task 4 — Add project status labels + privacy keys to all site.php files

**Files:**
- Modify: `lang/nl/site.php`, `lang/fr/site.php`, `lang/en/site.php`, `lang/de/site.php`

- [ ] **Step 4.1: Add project_status_labels to lang/nl/site.php**

After the `'available'` key at the top of the file, add:
```php
'project_status_labels' => [
    'Live'            => 'Live',
    'Afgewerkt'       => 'Afgewerkt',
    'Prototype'       => 'Prototype',
    'In ontwikkeling' => 'In ontwikkeling',
],
```

- [ ] **Step 4.2: Add project_status_labels to lang/fr/site.php**

```php
'project_status_labels' => [
    'Live'            => 'En ligne',
    'Afgewerkt'       => 'En ligne',
    'Prototype'       => 'Prototype',
    'In ontwikkeling' => 'En développement',
],
```

- [ ] **Step 4.3: Add project_status_labels to lang/en/site.php**

```php
'project_status_labels' => [
    'Live'            => 'Live',
    'Afgewerkt'       => 'Live',
    'Prototype'       => 'Prototype',
    'In ontwikkeling' => 'In development',
],
```

- [ ] **Step 4.4: Add project_status_labels to lang/de/site.php**

```php
'project_status_labels' => [
    'Live'            => 'Live',
    'Afgewerkt'       => 'Live',
    'Prototype'       => 'Prototyp',
    'In ontwikkeling' => 'In Entwicklung',
],
```

- [ ] **Step 4.5: Add privacy section to lang/nl/site.php**

Add a `'privacy'` section at the end of `lang/nl/site.php` (before the final `];`):
```php
// ── Privacy ───────────────────────────────────────────────────────────────
'privacy' => [
    'eyebrow'            => 'Juridisch',
    'heading'            => 'Privacyverklaring',
    'back_home'          => 'Terug naar de homepage',
    'last_updated'       => 'Laatst bijgewerkt',

    'who_heading'        => 'Wie ben ik?',
    'who_body'           => 'Van Malder Studio is de handelsnaam van <strong class="text-slate-800">Xander Van Malder</strong>, full stack developer gevestigd in de Druivenstreek, Vlaams-Brabant.',
    'who_contact'        => 'Contactadres',

    'data_heading'       => 'Welke gegevens worden verzameld?',
    'data_intro'         => 'Via het contactformulier op deze website worden de volgende gegevens verzameld:',
    'data_items'         => [
        'Naam (verplicht)',
        'E-mailadres (verplicht)',
        'Bedrijfs- of handelsnaam (optioneel)',
        'Telefoonnummer (optioneel)',
        'URL van een bestaande website (optioneel)',
        'Projecttype, budget en timing (optioneel)',
        'Taalwensen en beheerbehoefte (optioneel)',
        'Beschrijving van je project (verplicht)',
        'GDPR-toestemmingsbevestiging',
        'Technische metadata: een gehashte versie van je IP-adres (niet leesbaar), browsertype en referrer-URL',
    ],
    'data_ip_note'       => 'Het ruwe IP-adres wordt nooit bewaard — enkel een onherleidbare hash voor spamdetectie.',

    'purpose_heading'    => 'Waarvoor worden die gegevens gebruikt?',
    'purpose_intro'      => 'Je gegevens worden uitsluitend gebruikt om:',
    'purpose_items'      => [
        'Je aanvraag te beantwoorden en te beoordelen',
        'Contact op te nemen voor opvolging of bijkomende vragen',
        'Spam en misbruik te detecteren',
    ],
    'purpose_no_share'   => 'Je gegevens worden nooit verkocht, verhuurd of doorgegeven aan derden voor commerciële doeleinden. Ze worden enkel gedeeld als dit wettelijk verplicht is.',

    'retention_heading'  => 'Hoe lang worden gegevens bewaard?',
    'retention_body'     => 'Contactaanvragen worden bewaard zolang ze relevant zijn voor de opvolging. Gegevens van aanvragen waarbij geen samenwerking tot stand is gekomen, worden verwijderd wanneer ze niet langer nodig zijn.',

    'security_heading'   => 'Beveiliging',
    'security_body'      => 'De website maakt gebruik van CSRF-bescherming, rate limiting, invoervalidatie en een honeypot-veld om misbruik te voorkomen. IP-adressen worden opgeslagen als een onherleidbare hash (SHA-256).',

    'cookies_heading'    => 'Cookies en tracking',
    'cookies_body'       => 'Deze website gebruikt geen tracking-cookies, advertentiecookies of analytics van derden. Er worden enkel technisch noodzakelijke sessiecookies gebruikt voor het correct functioneren van het contactformulier (CSRF-token).',

    'rights_heading'     => 'Jouw rechten',
    'rights_intro'       => 'Je hebt het recht om:',
    'rights_items'       => [
        'Inzage te vragen in je opgeslagen gegevens',
        'Onjuiste gegevens te laten corrigeren',
        'Je gegevens te laten verwijderen',
        'Bezwaar te maken tegen de verwerking',
    ],
    'rights_contact'     => 'Neem hiervoor contact op via :email. Ik reageer zo snel mogelijk, uiterlijk binnen 30 dagen.',

    'questions_heading'  => 'Vragen of klachten?',
    'questions_body'     => 'Heb je vragen over deze privacyverklaring of over hoe je gegevens worden verwerkt? Neem gerust contact op: :email.',
    'questions_dpa'      => 'Je hebt ook het recht om een klacht in te dienen bij de Belgische :link.',
    'questions_dpa_link' => 'Gegevensbeschermingsautoriteit (GBA)',
    'questions_dpa_url'  => 'https://www.gegevensbeschermingsautoriteit.be',
],
```

- [ ] **Step 4.6: Add privacy section to lang/fr/site.php**

```php
'privacy' => [
    'eyebrow'            => 'Mentions légales',
    'heading'            => 'Politique de confidentialité',
    'back_home'          => 'Retour à l\'accueil',
    'last_updated'       => 'Dernière mise à jour',

    'who_heading'        => 'Qui suis-je ?',
    'who_body'           => 'Van Malder Studio est le nom commercial de <strong class="text-slate-800">Xander Van Malder</strong>, développeur full stack basé dans le Druivenstreek, Brabant flamand (Belgique).',
    'who_contact'        => 'Adresse de contact',

    'data_heading'       => 'Quelles données sont collectées ?',
    'data_intro'         => 'Via le formulaire de contact de ce site, les données suivantes sont collectées :',
    'data_items'         => [
        'Nom (obligatoire)',
        'Adresse e-mail (obligatoire)',
        'Nom de l\'entreprise (optionnel)',
        'Numéro de téléphone (optionnel)',
        'URL d\'un site web existant (optionnel)',
        'Type de projet, budget et délai (optionnel)',
        'Besoins linguistiques et de gestion (optionnel)',
        'Description de votre projet (obligatoire)',
        'Confirmation de consentement RGPD',
        'Métadonnées techniques : une version hachée de votre adresse IP (non lisible), type de navigateur et URL de référence',
    ],
    'data_ip_note'       => 'L\'adresse IP brute n\'est jamais conservée — seulement un hash irréversible pour la détection de spam.',

    'purpose_heading'    => 'À quoi servent ces données ?',
    'purpose_intro'      => 'Vos données sont utilisées exclusivement pour :',
    'purpose_items'      => [
        'Répondre à votre demande et l\'évaluer',
        'Vous contacter pour le suivi ou des questions complémentaires',
        'Détecter le spam et les abus',
    ],
    'purpose_no_share'   => 'Vos données ne sont jamais vendues, louées ni transmises à des tiers à des fins commerciales. Elles ne sont partagées que si la loi l\'exige.',

    'retention_heading'  => 'Combien de temps les données sont-elles conservées ?',
    'retention_body'     => 'Les demandes de contact sont conservées aussi longtemps qu\'elles sont pertinentes pour le suivi. Les données des demandes sans collaboration aboutissant sont supprimées lorsqu\'elles ne sont plus nécessaires.',

    'security_heading'   => 'Sécurité',
    'security_body'      => 'Le site utilise la protection CSRF, la limitation de débit, la validation des entrées et un champ honeypot pour prévenir les abus. Les adresses IP sont stockées sous forme de hash irréversible (SHA-256).',

    'cookies_heading'    => 'Cookies et suivi',
    'cookies_body'       => 'Ce site n\'utilise pas de cookies de suivi, de publicité ou d\'analytique tiers. Seuls des cookies de session techniquement nécessaires sont utilisés pour le bon fonctionnement du formulaire de contact (jeton CSRF).',

    'rights_heading'     => 'Vos droits',
    'rights_intro'       => 'Vous avez le droit de :',
    'rights_items'       => [
        'Demander l\'accès à vos données stockées',
        'Faire corriger des données inexactes',
        'Demander la suppression de vos données',
        'Vous opposer au traitement',
    ],
    'rights_contact'     => 'Pour cela, contactez-moi via :email. Je réponds aussi vite que possible, au plus tard dans les 30 jours.',

    'questions_heading'  => 'Questions ou réclamations ?',
    'questions_body'     => 'Vous avez des questions sur cette politique de confidentialité ou sur la façon dont vos données sont traitées ? N\'hésitez pas à me contacter : :email.',
    'questions_dpa'      => 'Vous avez également le droit de déposer une plainte auprès de l\'Autorité de protection des données belge : :link.',
    'questions_dpa_link' => 'Autorité de protection des données (APD)',
    'questions_dpa_url'  => 'https://www.autoriteprotectiondonnees.be',
],
```

- [ ] **Step 4.7: Add privacy section to lang/en/site.php**

```php
'privacy' => [
    'eyebrow'            => 'Legal',
    'heading'            => 'Privacy Policy',
    'back_home'          => 'Back to homepage',
    'last_updated'       => 'Last updated',

    'who_heading'        => 'Who am I?',
    'who_body'           => 'Van Malder Studio is the trading name of <strong class="text-slate-800">Xander Van Malder</strong>, full stack developer based in the Druivenstreek, Flemish Brabant (Belgium).',
    'who_contact'        => 'Contact address',

    'data_heading'       => 'What data is collected?',
    'data_intro'         => 'Via the contact form on this website, the following data is collected:',
    'data_items'         => [
        'Name (required)',
        'Email address (required)',
        'Company or trading name (optional)',
        'Phone number (optional)',
        'URL of an existing website (optional)',
        'Project type, budget and timeline (optional)',
        'Language preferences and admin needs (optional)',
        'Description of your project (required)',
        'GDPR consent confirmation',
        'Technical metadata: a hashed version of your IP address (not readable), browser type and referrer URL',
    ],
    'data_ip_note'       => 'The raw IP address is never stored — only an irreversible hash for spam detection.',

    'purpose_heading'    => 'What is this data used for?',
    'purpose_intro'      => 'Your data is used solely to:',
    'purpose_items'      => [
        'Answer and assess your enquiry',
        'Contact you for follow-up or additional questions',
        'Detect spam and abuse',
    ],
    'purpose_no_share'   => 'Your data is never sold, rented or shared with third parties for commercial purposes. It is only shared if legally required.',

    'retention_heading'  => 'How long is data kept?',
    'retention_body'     => 'Contact enquiries are kept as long as they are relevant for follow-up. Data from enquiries where no collaboration resulted is deleted when no longer needed.',

    'security_heading'   => 'Security',
    'security_body'      => 'The website uses CSRF protection, rate limiting, input validation and a honeypot field to prevent abuse. IP addresses are stored as an irreversible hash (SHA-256).',

    'cookies_heading'    => 'Cookies and tracking',
    'cookies_body'       => 'This website does not use tracking cookies, advertising cookies or third-party analytics. Only technically necessary session cookies are used for the proper functioning of the contact form (CSRF token).',

    'rights_heading'     => 'Your rights',
    'rights_intro'       => 'You have the right to:',
    'rights_items'       => [
        'Request access to your stored data',
        'Have inaccurate data corrected',
        'Request deletion of your data',
        'Object to processing',
    ],
    'rights_contact'     => 'Contact me via :email. I respond as soon as possible, within 30 days at the latest.',

    'questions_heading'  => 'Questions or complaints?',
    'questions_body'     => 'Do you have questions about this privacy policy or how your data is processed? Feel free to get in touch: :email.',
    'questions_dpa'      => 'You also have the right to file a complaint with the Belgian :link.',
    'questions_dpa_link' => 'Data Protection Authority (GBA)',
    'questions_dpa_url'  => 'https://www.gegevensbeschermingsautoriteit.be',
],
```

- [ ] **Step 4.8: Add privacy section to lang/de/site.php**

```php
'privacy' => [
    'eyebrow'            => 'Rechtliches',
    'heading'            => 'Datenschutzerklärung',
    'back_home'          => 'Zurück zur Startseite',
    'last_updated'       => 'Zuletzt aktualisiert',

    'who_heading'        => 'Wer bin ich?',
    'who_body'           => 'Van Malder Studio ist der Handelsname von <strong class="text-slate-800">Xander Van Malder</strong>, Full-Stack-Entwickler mit Sitz in der Druivenstreek, Flämisch-Brabant (Belgien).',
    'who_contact'        => 'Kontaktadresse',

    'data_heading'       => 'Welche Daten werden erfasst?',
    'data_intro'         => 'Über das Kontaktformular dieser Website werden folgende Daten erfasst:',
    'data_items'         => [
        'Name (erforderlich)',
        'E-Mail-Adresse (erforderlich)',
        'Unternehmens- oder Handelsname (optional)',
        'Telefonnummer (optional)',
        'URL einer bestehenden Website (optional)',
        'Projekttyp, Budget und Zeitplan (optional)',
        'Sprachbedarf und Verwaltungsanforderungen (optional)',
        'Beschreibung Ihres Projekts (erforderlich)',
        'DSGVO-Einwilligungsbestätigung',
        'Technische Metadaten: eine gehashte Version Ihrer IP-Adresse (nicht lesbar), Browsertyp und Referrer-URL',
    ],
    'data_ip_note'       => 'Die rohe IP-Adresse wird niemals gespeichert — nur ein nicht umkehrbarer Hash zur Spam-Erkennung.',

    'purpose_heading'    => 'Wofür werden diese Daten verwendet?',
    'purpose_intro'      => 'Ihre Daten werden ausschließlich verwendet, um:',
    'purpose_items'      => [
        'Ihre Anfrage zu beantworten und zu bewerten',
        'Sie für die Nachverfolgung oder Rückfragen zu kontaktieren',
        'Spam und Missbrauch zu erkennen',
    ],
    'purpose_no_share'   => 'Ihre Daten werden niemals verkauft, vermietet oder zu kommerziellen Zwecken an Dritte weitergegeben. Sie werden nur weitergegeben, wenn dies gesetzlich vorgeschrieben ist.',

    'retention_heading'  => 'Wie lange werden Daten aufbewahrt?',
    'retention_body'     => 'Kontaktanfragen werden so lange aufbewahrt, wie sie für die Nachverfolgung relevant sind. Daten von Anfragen ohne zustande gekommene Zusammenarbeit werden gelöscht, wenn sie nicht mehr benötigt werden.',

    'security_heading'   => 'Sicherheit',
    'security_body'      => 'Die Website verwendet CSRF-Schutz, Rate Limiting, Eingabevalidierung und ein Honeypot-Feld, um Missbrauch zu verhindern. IP-Adressen werden als nicht umkehrbarer Hash (SHA-256) gespeichert.',

    'cookies_heading'    => 'Cookies und Tracking',
    'cookies_body'       => 'Diese Website verwendet keine Tracking-Cookies, Werbe-Cookies oder Drittanbieter-Analysen. Es werden nur technisch notwendige Session-Cookies für das ordnungsgemäße Funktionieren des Kontaktformulars (CSRF-Token) verwendet.',

    'rights_heading'     => 'Ihre Rechte',
    'rights_intro'       => 'Sie haben das Recht:',
    'rights_items'       => [
        'Auskunft über Ihre gespeicherten Daten anzufordern',
        'Unrichtige Daten berichtigen zu lassen',
        'Die Löschung Ihrer Daten zu verlangen',
        'Der Verarbeitung zu widersprechen',
    ],
    'rights_contact'     => 'Kontaktieren Sie mich unter :email. Ich antworte so schnell wie möglich, spätestens innerhalb von 30 Tagen.',

    'questions_heading'  => 'Fragen oder Beschwerden?',
    'questions_body'     => 'Haben Sie Fragen zu dieser Datenschutzerklärung oder zur Verarbeitung Ihrer Daten? Nehmen Sie gerne Kontakt auf: :email.',
    'questions_dpa'      => 'Sie haben auch das Recht, eine Beschwerde bei der belgischen :link einzureichen.',
    'questions_dpa_link' => 'Datenschutzbehörde (GBA)',
    'questions_dpa_url'  => 'https://www.gegevensbeschermingsautoriteit.be',
],
```

- [ ] **Step 4.9: Commit**
```bash
git add lang/nl/site.php lang/fr/site.php lang/en/site.php lang/de/site.php
git commit -m "feat: add project_status_labels and full privacy section to all locales"
```

---

## Task 5 — Translate about.blade.php

**Files:**
- Modify: `resources/views/pages/about.blade.php`

The `lang/*/site.php` files already have `about.*`, `seo.*` sections with correct translations.

- [ ] **Step 5.1: Update SEO metadata and canonical to be locale-aware**

Replace the opening layout tag at the top of `about.blade.php`:
```php
{{-- Before --}}
<x-layouts.app
    title="Over mij | Xander Van Malder — Full stack developer"
    description="Xander Van Malder is een full stack developer uit de Druivenstreek..."
    :canonical="route('about')"
    ogTitle="Over mij | Van Malder Studio"
>

{{-- After --}}
@php
    $loc = app()->getLocale() ?: 'nl';
    $aboutCanonical = \Illuminate\Support\Facades\Route::has($loc . '.about') ? route($loc . '.about') : route('about');
    $contactHref    = \Illuminate\Support\Facades\Route::has($loc . '.contact')  ? route($loc . '.contact')  : route('contact');
    $showcaseHref   = \Illuminate\Support\Facades\Route::has($loc . '.showcase') ? route($loc . '.showcase') : route('showcase');
@endphp
<x-layouts.app
    :title="__('site.seo.about_title')"
    :description="__('site.seo.about_desc')"
    :canonical="$aboutCanonical"
    :ogTitle="__('site.seo.about_og_title')"
>
```

- [ ] **Step 5.2: Replace hardcoded bio text in the header section**

Replace lines 14-53 of about.blade.php:
```php
<div class="lg:col-span-3 reveal">
    <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
        <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
        {{ __('site.about.eyebrow') }}
    </p>
    <h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">{{ __('site.about.heading') }}</h1>
    <p class="mt-2 text-slate-500">{{ __('site.about.subtitle') }}</p>

    <div class="mt-8 space-y-4 text-slate-600 leading-relaxed">
        <p>{!! __('site.about.body_1') !!}</p>
        <p>{!! __('site.about.body_2') !!}</p>
        <p>{!! __('site.about.body_3', ['brand' => '<strong class="text-slate-800 font-medium">VM Studios</strong>']) !!}</p>
        <p>{!! __('site.about.body_4') !!}</p>
    </div>

    <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ $contactHref }}"
           class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
            {{ __('site.about.cta_contact') }}
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
        <a href="{{ $showcaseHref }}"
           class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-white border border-stone-300 text-slate-700 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
            {{ __('site.about.cta_showcase') }}
        </a>
    </div>
</div>
```

- [ ] **Step 5.3: Replace hardcoded sidebar card headings and focus items**

Replace the "Technologieën" card heading:
```php
{{-- Before --}}
<h2 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-5">Technologieën</h2>

{{-- After --}}
<h2 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-5">{{ __('site.about.tech_heading') }}</h2>
```

Note: technology group labels (Frontend, Backend & database, etc.) are technical terms that can remain in English as they are universal. Keep them as-is.

Replace the "Focusgebieden" card heading and items:
```php
{{-- Before --}}
<h2 ...>Focusgebieden</h2>
<ul ...>
    @foreach(['Gebruiksvriendelijke interfaces', 'Veilige en onderhoudbare code', ...] as $focus)
    ...
    @endforeach
</ul>

{{-- After --}}
<h2 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">{{ __('site.about.focus_heading') }}</h2>
<ul class="space-y-2.5" role="list">
    @foreach(__('site.about.focus_items') as $focus)
    <li class="flex items-center gap-3 text-sm text-slate-600">
        <span class="w-1.5 h-1.5 rounded-full bg-amber-600 shrink-0" aria-hidden="true"></span>
        {{ $focus }}
    </li>
    @endforeach
</ul>
```

Replace the "Eigen projecten · VM Studios" card heading:
```php
{{-- Before --}}
<h2 ...>Eigen projecten · VM Studios</h2>

{{-- After --}}
<h2 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">{{ __('site.about.projects_heading') }}</h2>
```

- [ ] **Step 5.4: Update project status badges in the sidebar to use locale-aware labels**

Replace the badge match expression in the sidebar projects loop:
```php
{{-- Before --}}
$sidebarBadge = match($project['status']) {
    'Live', 'Afgewerkt' => 'text-emerald-600 bg-emerald-50 border-emerald-100',
    'Prototype'         => 'text-amber-600 bg-amber-50 border-amber-100',
    default             => 'text-slate-400 bg-stone-100 border-stone-200',
};

{{-- After --}}
$statusLabels = __('site.project_status_labels');
$statusLabel  = is_array($statusLabels) && isset($statusLabels[$project['status']])
    ? $statusLabels[$project['status']]
    : $project['status'];
$sidebarBadge = in_array($project['status'], ['Live', 'Afgewerkt'])
    ? 'text-emerald-600 bg-emerald-50 border-emerald-100'
    : ($project['status'] === 'Prototype' ? 'text-amber-600 bg-amber-50 border-amber-100' : 'text-slate-400 bg-stone-100 border-stone-200');
```

Then change the badge output from `$project['status']` to `$statusLabel`:
```php
{{-- Before --}}
<span class="text-[0.6rem] font-medium px-1.5 py-0.5 {{ $sidebarBadge }} border rounded-full shrink-0">{{ $project['status'] }}</span>

{{-- After --}}
<span class="text-[0.6rem] font-medium px-1.5 py-0.5 {{ $sidebarBadge }} border rounded-full shrink-0">{{ $statusLabel }}</span>
```

- [ ] **Step 5.5: Replace hardcoded VM Studios section headings**

```php
{{-- Before --}}
<p ...>Eigen projecten</p>
<h2 id="vm-studios-heading" ...>VM Studios</h2>
<p class="mt-3 text-slate-500 ...">
    Naast klantwerk bouw ik eigen apps, games en digitale projecten via <strong ...>VM Studios</strong>.
    Ze tonen mijn technische achtergrond, ...
</p>

{{-- After --}}
<p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
    {{ __('site.about.vm_studios_eyebrow') }}
</p>
<h2 id="vm-studios-heading" class="font-serif text-3xl font-medium text-slate-900 leading-tight">{{ __('site.about.vm_studios_heading') }}</h2>
<p class="mt-3 text-slate-500 leading-relaxed max-w-2xl">
    {!! __('site.about.vm_studios_body', ['brand' => '<strong class="font-semibold text-slate-700">VM Studios</strong>']) !!}
</p>
```

- [ ] **Step 5.6: Replace hardcoded project card headings ("Wat het aantoont", "Technologieën") and update badge logic**

In the detailed project articles loop:
```php
{{-- Before --}}
$articleBadge = match($project['status']) { ... };
...
<span>{{ $project['status'] }}</span>
...
<h4 ...>Wat het aantoont</h4>
<p ...>{{ $project['proves'] }}</p>
...
<h4 ...>Technologieën</h4>

{{-- After --}}
@php
    $articleStatusLabels = __('site.project_status_labels');
    $articleStatusLabel  = is_array($articleStatusLabels) && isset($articleStatusLabels[$project['status']])
        ? $articleStatusLabels[$project['status']]
        : $project['status'];
    $articleBadge = in_array($project['status'], ['Live', 'Afgewerkt'])
        ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
        : ($project['status'] === 'Prototype' ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-slate-100 text-slate-600 border-slate-200');
@endphp
...
<span class="text-xs font-medium px-2.5 py-1 {{ $articleBadge }} border rounded-full">{{ $articleStatusLabel }}</span>
...
<h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('site.about.project_proves') }}</h4>
<p class="text-sm text-slate-600 leading-relaxed">{{ $project['proves'] }}</p>
...
<h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('site.about.project_tech') }}</h4>
```

- [ ] **Step 5.7: Commit**
```bash
git add resources/views/pages/about.blade.php
git commit -m "feat: about page fully locale-aware using translation keys"
```

---

## Task 6 — Translate showcase.blade.php

**Files:**
- Modify: `resources/views/pages/showcase.blade.php`

- [ ] **Step 6.1: Update SEO metadata and canonical**

Replace opening layout tag:
```php
@php
    $loc = app()->getLocale() ?: 'nl';
    $showcaseCanonical = \Illuminate\Support\Facades\Route::has($loc . '.showcase') ? route($loc . '.showcase') : route('showcase');
    $contactHref       = \Illuminate\Support\Facades\Route::has($loc . '.contact')  ? route($loc . '.contact')  : route('contact');
    $servicesHref      = \Illuminate\Support\Facades\Route::has($loc . '.services') ? route($loc . '.services') : route('services');
    $aboutHref         = \Illuminate\Support\Facades\Route::has($loc . '.about')    ? route($loc . '.about')    : route('about');
    $studioIntroHref   = route('studio.intro');
@endphp
<x-layouts.app
    :title="__('site.seo.showcase_title')"
    :description="__('site.seo.showcase_desc')"
    :canonical="$showcaseCanonical"
    :ogTitle="__('site.seo.showcase_og_title')"
>
```

- [ ] **Step 6.2: Replace hardcoded header section**

```php
{{-- Before --}}
<p ...>Showcase</p>
<h1 ...>Showcase</h1>
<p ...>Interactieve details die tonen hoe een website ...</p>
<p ...>Dit zijn demo's van technische mogelijkheden — geen klantprojecten.
    Het echte aanbod staat op de <a href="{{ route('services') }}" ...>diensten-pagina</a>.
</p>

{{-- After --}}
<p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
    {{ __('site.showcase.eyebrow') }}
</p>
<h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">{{ __('site.showcase.heading') }}</h1>
<p class="mt-4 text-lg text-slate-500 leading-relaxed max-w-2xl">{{ __('site.showcase.body') }}</p>
<p class="mt-3 text-sm text-slate-400 max-w-xl leading-relaxed">
    {!! __('site.showcase.note', ['link' => '<a href="' . e($servicesHref) . '" class="text-blue-700 hover:underline">' . e(__('site.showcase.note_link')) . '</a>']) !!}
</p>
```

- [ ] **Step 6.3: Replace hardcoded card 1 (Interactive hero background) content**

```php
{{-- Card 1 — studio-intro link --}}
<a href="{{ $studioIntroHref }}"
   class="showcase-card group bg-slate-900 ..."
   aria-label="{{ __('site.showcase.card_hero_cta') }}">
    {{-- ... visual area stays unchanged ... --}}
    <div class="p-6 flex flex-col flex-1">
        <span class="text-[0.65rem] font-semibold text-amber-600 uppercase tracking-widest mb-2">{{ __('site.showcase.card_hero_eyebrow') }}</span>
        <h2 class="font-serif text-lg font-medium text-white leading-snug">{{ __('site.showcase.card_hero_title') }}</h2>
        <p class="mt-2 text-sm text-slate-400 leading-relaxed flex-1">{{ __('site.showcase.card_hero_body') }}</p>
        <p class="mt-2 text-xs text-slate-600 italic">{{ __('site.showcase.card_hero_value') }}</p>
        <div class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-amber-500 group-hover:text-amber-400 transition-colors duration-200">
            {{ __('site.showcase.card_hero_cta') }}
            <svg ...><path .../></svg>
        </div>
    </div>
</a>
```

- [ ] **Step 6.4: Replace hardcoded card 2 (UI micro-interactions) text**

```php
{{-- Content section of card 2 --}}
<div class="p-6 flex flex-col flex-1">
    <span class="text-[0.65rem] font-semibold text-amber-700 uppercase tracking-widest mb-2">{{ __('site.showcase.card_ui_eyebrow') }}</span>
    <h2 class="font-serif text-lg font-medium text-slate-900 leading-snug">{{ __('site.showcase.card_ui_title') }}</h2>
    <p class="mt-2 text-sm text-slate-500 leading-relaxed">{{ __('site.showcase.card_ui_body') }}</p>
    <p data-interact-copy class="mt-3 text-xs text-slate-400 leading-relaxed italic">
        {{ __('site.showcase.card_ui_interact_hint') }}
    </p>
    <a href="{{ $contactHref }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 group cursor-pointer">
        {{ __('site.showcase.card_ui_cta') }}
        <svg ...><path .../></svg>
    </a>
</div>
```

Also replace the interactive button state labels ("Kies een interactiestaat", "Hover", "Actief", "Disabled") — these are UI demo labels. Since they demonstrate a concept visually, they can stay in Dutch for the demo, OR use translation keys. Use translation keys for consistency:

Replace the state buttons and their aria-label:
```php
<div class="flex gap-2" role="group" aria-label="{{ __('site.showcase.card_ui_state_label') }}">
    <button data-interact-state="hover" ...>{{ __('site.showcase.card_ui_state_hover') }}</button>
    <button data-interact-state="active" ...>{{ __('site.showcase.card_ui_state_active') }}</button>
    <button data-interact-state="disabled" ...>{{ __('site.showcase.card_ui_state_disabled') }}</button>
</div>
```

- [ ] **Step 6.5: Replace hardcoded card 3 (Scroll preview) text**

```php
{{-- Content section of card 3 --}}
<div class="p-6 flex flex-col flex-1">
    <span class="text-[0.65rem] font-semibold text-amber-700 uppercase tracking-widest mb-2">{{ __('site.showcase.card_scroll_eyebrow') }}</span>
    <h2 class="font-serif text-lg font-medium text-slate-900 leading-snug">{{ __('site.showcase.card_scroll_title') }}</h2>
    <p class="mt-2 text-sm text-slate-500 leading-relaxed">{{ __('site.showcase.card_scroll_body') }}</p>

    {{-- Section tabs --}}
    <div class="mt-4 flex flex-wrap gap-1.5" role="group" aria-label="{{ __('site.showcase.scroll_tabs_label') }}">
        @foreach([
            ['key' => 'first-impression', 'label' => __('site.showcase.scroll_tabs.first_impression')],
            ['key' => 'offer',            'label' => __('site.showcase.scroll_tabs.offer')],
            ['key' => 'seo',              'label' => __('site.showcase.scroll_tabs.seo')],
            ['key' => 'pricing',          'label' => __('site.showcase.scroll_tabs.pricing')],
            ['key' => 'contact',          'label' => __('site.showcase.scroll_tabs.contact')],
        ] as $tab)
        <button data-section-tab="{{ $tab['key'] }}"
                class="px-2.5 py-1 text-xs font-medium rounded-md border cursor-pointer transition-all duration-150 {{ $tab['key'] === 'first-impression' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-500 border-stone-200' }}"
                aria-pressed="{{ $tab['key'] === 'first-impression' ? 'true' : 'false' }}"
                data-caption="{{ __('site.showcase.scroll_captions.' . str_replace('-', '_', $tab['key'])) }}">
            {{ $tab['label'] }}
        </button>
        @endforeach
    </div>
    <div class="mt-3 w-full bg-stone-200 rounded-full h-1" role="progressbar" ...>...</div>
    <p data-section-caption class="mt-2 text-xs text-slate-400 leading-relaxed italic" aria-live="polite">
        {{ __('site.showcase.scroll_captions.first_impression') }}
    </p>
</div>
```

Note: The JS reads `data-caption` from each tab button and updates `data-section-caption`. By putting the caption text in `data-caption`, the JS still works and the captions are locale-aware.

- [ ] **Step 6.6: Replace hardcoded card 4 (Contact flow) text**

```php
{{-- Mini form preview area - demo labels --}}
<p class="text-xs font-semibold text-slate-600">{{ __('site.showcase.card_cf_demo_question') }}</p>
<button data-cf-option="new_website" ...>{{ __('site.contact.type_new_website') }}</button>
<button data-cf-option="redesign"    ...>{{ __('site.contact.type_redesign') }}</button>
<button data-cf-option="contact_form" ...>{{ __('site.contact.type_contact_form') }}</button>
<button data-cf-option="audit"       ...>{{ __('site.contact.type_audit') }}</button>

{{-- Summary row --}}
<span class="text-xs text-slate-400">{{ __('site.showcase.card_cf_choice_label') }}</span>

{{-- Validation hint --}}
<div data-cf-validation ...>{{ __('site.contact.validation_choose') }}</div>

{{-- Success feedback --}}
<div data-cf-success ...>
    <svg ...></svg>
    {{ __('site.showcase.card_cf_ready') }}
</div>

{{-- Content section --}}
<div class="p-6 flex flex-col flex-1">
    <span class="text-[0.65rem] font-semibold text-amber-700 uppercase tracking-widest mb-2">{{ __('site.showcase.card_cf_eyebrow') }}</span>
    <h2 class="font-serif text-lg font-medium text-slate-900 leading-snug">{{ __('site.showcase.card_cf_title') }}</h2>
    <p class="mt-2 text-sm text-slate-500 leading-relaxed flex-1">{{ __('site.showcase.card_cf_body') }}</p>
    <a href="{{ $contactHref }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 group cursor-pointer">
        {{ __('site.showcase.card_cf_cta') }}
        <svg ...><path .../></svg>
    </a>
</div>
```

- [ ] **Step 6.7: Replace VM Studios section on showcase**

```php
{{-- Before --}}
<h2 ...>VM Studios · eigen projecten</h2>
<p ...>Bewijs van technische diepgang over meerdere platforms en stacks.</p>
<a href="{{ route('about') }}#vm-studios" ...>
    Details op Over mij
    ...
</a>
{{-- Project status badges --}}
<span class="...">{{ $project['status'] }}</span>

{{-- After --}}
<h2 id="sc-projects-heading" class="font-serif text-xl font-medium text-slate-900">{{ __('site.showcase.vm_studios_heading') }}</h2>
<p class="text-sm text-slate-500 mt-1">{{ __('site.showcase.vm_studios_body') }}</p>
...
<a href="{{ $aboutHref }}#vm-studios" ...>
    {{ __('site.showcase.vm_details_link') }}
    ...
</a>
{{-- Project badges --}}
@php
    $scStatusLabels = __('site.project_status_labels');
    $scStatusLabel  = is_array($scStatusLabels) && isset($scStatusLabels[$project['status']])
        ? $scStatusLabels[$project['status']]
        : $project['status'];
    $scBadge = in_array($project['status'], ['Live', 'Afgewerkt'])
        ? 'text-emerald-600 bg-emerald-50 border-emerald-100'
        : ($project['status'] === 'Prototype' ? 'text-amber-600 bg-amber-50 border-amber-100' : 'text-slate-400 bg-stone-100 border-stone-200');
@endphp
<span ...>{{ $scStatusLabel }}</span>
```

- [ ] **Step 6.8: Replace CTA section**

```php
{{-- Before --}}
<h2 ...>Klaar om samen iets te bouwen?</h2>
<p ...>De showcase toont technisch vermogen. Het echte werk begint bij een gesprek.</p>
<a href="{{ route('contact') }}" ...>Bespreek je project ...</a>
<a href="{{ route('services') }}" ...>Bekijk diensten</a>

{{-- After --}}
<h2 id="showcase-cta-heading" class="font-serif text-xl md:text-2xl font-medium text-slate-900 leading-tight">{{ __('site.showcase.cta_heading') }}</h2>
<p class="mt-2 text-sm text-slate-500 leading-relaxed max-w-lg">{{ __('site.showcase.cta_body') }}</p>
...
<a href="{{ $contactHref }}" ...>
    {{ __('site.showcase.cta_primary') }}
    ...
</a>
<a href="{{ $servicesHref }}" ...>{{ __('site.showcase.cta_secondary') }}</a>
```

- [ ] **Step 6.9: Add missing showcase keys to all site.php files**

Add to `lang/nl/site.php` `'showcase'` section (several keys may be missing):
```php
'scroll_tabs_label'    => 'Website-secties',
'card_ui_state_label'  => 'Kies een interactiestaat',
'card_ui_state_hover'  => 'Hover',
'card_ui_state_active' => 'Actief',
'card_ui_state_disabled' => 'Disabled',
'card_ui_interact_hint'  => 'Op hover: kleur en schaduw communiceren dat het element klikbaar is.',
'card_cf_demo_question'  => 'Wat heb je nodig?',
'card_cf_choice_label'   => 'Keuze:',
'card_cf_ready'          => 'Aanvraag klaar om te versturen.',
'scroll_captions' => [
    'first_impression' => 'De bezoeker ziet meteen wie je bent en wat je aanbiedt.',
    'offer'            => 'Diensten worden duidelijk opgesplitst zodat de bezoeker snel herkent wat hij nodig heeft.',
    'seo'              => 'Een technische SEO-basis helpt Google en bezoekers de site beter begrijpen.',
    'pricing'          => 'Richtprijzen geven vertrouwen zonder je vast te pinnen op elk detail.',
    'contact'          => 'Een duidelijke CTA verlaagt de drempel om een aanvraag te sturen.',
],
```

Add equivalent keys to FR, EN, DE:

**FR:**
```php
'scroll_tabs_label'     => 'Sections du site',
'card_ui_state_label'   => 'Choisir un état d\'interaction',
'card_ui_state_hover'   => 'Survol',
'card_ui_state_active'  => 'Actif',
'card_ui_state_disabled' => 'Désactivé',
'card_ui_interact_hint' => 'Au survol : couleur et ombre indiquent que l\'élément est cliquable.',
'card_cf_demo_question' => 'Ce dont vous avez besoin ?',
'card_cf_choice_label'  => 'Choix :',
'card_cf_ready'         => 'Demande prête à être envoyée.',
'scroll_captions' => [
    'first_impression' => 'Le visiteur voit immédiatement qui vous êtes et ce que vous proposez.',
    'offer'            => 'Les services sont clairement divisés pour que les visiteurs trouvent rapidement ce dont ils ont besoin.',
    'seo'              => 'Des bases SEO solides aident Google et les visiteurs à mieux comprendre le site.',
    'pricing'          => 'Des prix indicatifs inspirent confiance sans vous engager sur chaque détail.',
    'contact'          => 'Un appel à l\'action clair abaisse le seuil pour envoyer une demande.',
],
```

**EN:**
```php
'scroll_tabs_label'     => 'Website sections',
'card_ui_state_label'   => 'Choose an interaction state',
'card_ui_state_hover'   => 'Hover',
'card_ui_state_active'  => 'Active',
'card_ui_state_disabled' => 'Disabled',
'card_ui_interact_hint' => 'On hover: colour and shadow communicate that the element is clickable.',
'card_cf_demo_question' => 'What do you need?',
'card_cf_choice_label'  => 'Choice:',
'card_cf_ready'         => 'Request ready to send.',
'scroll_captions' => [
    'first_impression' => 'The visitor immediately sees who you are and what you offer.',
    'offer'            => 'Services are clearly split so visitors quickly find what they need.',
    'seo'              => 'A solid SEO foundation helps Google and visitors understand the site better.',
    'pricing'          => 'Guide prices build trust without locking you into every detail.',
    'contact'          => 'A clear CTA lowers the threshold for sending an enquiry.',
],
```

**DE:**
```php
'scroll_tabs_label'     => 'Website-Bereiche',
'card_ui_state_label'   => 'Interaktionszustand wählen',
'card_ui_state_hover'   => 'Hover',
'card_ui_state_active'  => 'Aktiv',
'card_ui_state_disabled' => 'Deaktiviert',
'card_ui_interact_hint' => 'Beim Hover: Farbe und Schatten kommunizieren, dass das Element klickbar ist.',
'card_cf_demo_question' => 'Was brauchen Sie?',
'card_cf_choice_label'  => 'Auswahl:',
'card_cf_ready'         => 'Anfrage versandbereit.',
'scroll_captions' => [
    'first_impression' => 'Der Besucher sieht sofort, wer Sie sind und was Sie anbieten.',
    'offer'            => 'Leistungen sind klar aufgeteilt, damit Besucher schnell finden, was sie brauchen.',
    'seo'              => 'Eine solide SEO-Grundlage hilft Google und Besuchern, die Website besser zu verstehen.',
    'pricing'          => 'Richtpreise schaffen Vertrauen, ohne Sie auf jedes Detail festzulegen.',
    'contact'          => 'Ein klarer CTA senkt die Schwelle, eine Anfrage zu senden.',
],
```

- [ ] **Step 6.10: Commit**
```bash
git add resources/views/pages/showcase.blade.php lang/nl/site.php lang/fr/site.php lang/en/site.php lang/de/site.php
git commit -m "feat: showcase page fully locale-aware with translated interactive labels"
```

---

## Task 7 — Translate process.blade.php

**Files:**
- Modify: `resources/views/pages/process.blade.php`

The process page has rich content (7 steps + sidebar). The `lang/*/site.php` files already have `process.steps` arrays.

- [ ] **Step 7.1: Update SEO metadata and canonical**

Replace opening layout tag:
```php
@php
    $loc = app()->getLocale() ?: 'nl';
    $processCanonical = \Illuminate\Support\Facades\Route::has($loc . '.process') ? route($loc . '.process') : route('process');
    $contactHref      = \Illuminate\Support\Facades\Route::has($loc . '.contact') ? route($loc . '.contact') : route('contact');
@endphp
<x-layouts.app
    :title="__('site.seo.process_title')"
    :description="__('site.seo.process_desc')"
    :canonical="$processCanonical"
    :ogTitle="__('site.seo.process_title')"
>
```

- [ ] **Step 7.2: Replace hardcoded header section**

```php
{{-- Before --}}
<p ...>Hoe ik werk</p>
<h1 ...>Een duidelijk traject</h1>
<p ...>Samenwerken met mij is rechttoe rechtaan. Geen vage beloftes, geen onverwachte wendingen —
    maar een gestructureerd traject met heldere communicatie op elk punt.</p>

{{-- After --}}
<p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
    {{ __('site.process.eyebrow') }}
</p>
<h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">{{ __('site.process.heading_full') }}</h1>
<p class="mt-4 text-lg text-slate-500 leading-relaxed max-w-2xl">{{ __('site.process.body') }}</p>
```

- [ ] **Step 7.3: Replace hardcoded steps array with translation keys**

The existing `lang/*/site.php` already has `process.steps` with 5 steps. The process page currently has 7 hardcoded steps. We need to either:
- Extend the translation files to 7 steps, OR
- Use the 5 existing steps from translations

The spec says 5 steps (Kennismaking, Voorstel en scope, Ontwerp en structuur, Ontwikkeling, Feedback en lancering). The process page has 7 (adds Feedbackronde, Lancering, Opvolging as separate entries). 

**Decision:** Update `lang/*/site.php` `process.steps` to the 7-step version matching the page, and use translations.

Update `lang/nl/site.php` `process.steps`:
```php
'steps' => [
    ['title' => 'Kennismaking',          'desc' => 'We plannen een korte call of ontmoeting. Ik luister naar wat je wil bouwen, wie je doelgroep is en wat je verwacht. Geen pitch, gewoon een eerlijk gesprek.'],
    ['title' => 'Scope en voorstel',     'desc' => 'Na ons gesprek stel ik een helder voorstel op: wat ik bouw, hoe ik het aanpak en wat het kost. Geen verborgen kosten, geen vage schatting.'],
    ['title' => 'Ontwerp en structuur',  'desc' => 'Ik werk de paginastructuur en de visuele richting uit. Je geeft feedback vóór ik begin te bouwen, zodat we allebei op dezelfde lijn zitten.'],
    ['title' => 'Ontwikkeling',          'desc' => 'Ik bouw de website of applicatie. Ik werk gestructureerd, schrijf leesbare code en let op veiligheid en snelheid.'],
    ['title' => 'Feedbackronde',         'desc' => 'Je bekijkt het resultaat en geeft feedback. We verfijnen samen totdat je tevreden bent.'],
    ['title' => 'Lancering',             'desc' => 'De website gaat live. Ik help bij de technische setup: domein, hosting, e-mail. Jij focust op je zaak, ik zorg dat alles technisch in orde is.'],
    ['title' => 'Opvolging (optioneel)', 'desc' => 'Na de lancering kan ik de technische opvolging op me nemen: updates, kleine aanpassingen, monitoring. Zo blijft je website veilig en up-to-date.'],
],
```

Update `lang/fr/site.php` `process.steps`:
```php
'steps' => [
    ['title' => 'Prise de contact',      'desc' => 'Nous planifions un court appel ou une rencontre. J\'écoute ce que vous voulez réaliser, qui est votre public cible et ce que vous attendez. Pas de pitch, juste une conversation honnête.'],
    ['title' => 'Portée et proposition', 'desc' => 'Après notre échange, je prépare une proposition claire : ce que je développe, comment j\'approche le projet et ce que cela coûte. Pas de coûts cachés, pas d\'estimation vague.'],
    ['title' => 'Design et structure',   'desc' => 'Je définis la structure des pages et la direction visuelle. Vous donnez votre avis avant que je commence à développer, pour que nous soyons alignés.'],
    ['title' => 'Développement',         'desc' => 'Je développe le site ou l\'application. Je travaille de manière structurée, écris du code lisible et fais attention à la sécurité et à la rapidité.'],
    ['title' => 'Ronde de retours',      'desc' => 'Vous examinez le résultat et donnez vos retours. Nous affinons ensemble jusqu\'à ce que vous soyez satisfait.'],
    ['title' => 'Lancement',             'desc' => 'Le site est mis en ligne. Je vous aide avec la configuration technique : domaine, hébergement, e-mail. Vous vous concentrez sur votre activité, je m\'assure que tout est en ordre.'],
    ['title' => 'Suivi (optionnel)',      'desc' => 'Après le lancement, je peux prendre en charge le suivi technique : mises à jour, petits ajustements, monitoring. Votre site reste ainsi sécurisé et à jour.'],
],
```

Update `lang/en/site.php` `process.steps`:
```php
'steps' => [
    ['title' => 'Introduction',          'desc' => 'We plan a short call or meeting. I listen to what you want to build, who your audience is and what you expect. No pitch, just an honest conversation.'],
    ['title' => 'Scope and proposal',    'desc' => 'After our conversation I put together a clear proposal: what I build, how I approach it and what it costs. No hidden costs, no vague estimates.'],
    ['title' => 'Design and structure',  'desc' => 'I work out the page structure and visual direction. You give feedback before I start building, so we\'re both on the same page.'],
    ['title' => 'Development',           'desc' => 'I build the website or application. I work in a structured way, write readable code and pay attention to security and speed.'],
    ['title' => 'Feedback round',        'desc' => 'You review the result and give feedback. We refine together until you\'re satisfied.'],
    ['title' => 'Launch',                'desc' => 'The website goes live. I help with the technical setup: domain, hosting, email. You focus on your business, I make sure everything is technically in order.'],
    ['title' => 'Follow-up (optional)',  'desc' => 'After launch I can handle the technical follow-up: updates, small adjustments, monitoring. Your website stays secure and up to date.'],
],
```

Update `lang/de/site.php` `process.steps`:
```php
'steps' => [
    ['title' => 'Kennenlernen',                 'desc' => 'Wir planen einen kurzen Anruf oder ein Treffen. Ich höre zu, was Sie entwickeln möchten, wer Ihre Zielgruppe ist und was Sie erwarten. Kein Pitch, nur ein ehrliches Gespräch.'],
    ['title' => 'Umfang und Angebot',           'desc' => 'Nach unserem Gespräch erstelle ich ein klares Angebot: was ich entwickle, wie ich vorgehe und was es kostet. Keine versteckten Kosten, keine vagen Schätzungen.'],
    ['title' => 'Design und Struktur',          'desc' => 'Ich erarbeite die Seitenstruktur und die visuelle Ausrichtung. Sie geben Feedback, bevor ich mit dem Entwickeln beginne, damit wir beide auf derselben Linie sind.'],
    ['title' => 'Entwicklung',                  'desc' => 'Ich entwickle die Website oder Anwendung. Ich arbeite strukturiert, schreibe lesbaren Code und achte auf Sicherheit und Geschwindigkeit.'],
    ['title' => 'Feedbackrunde',                'desc' => 'Sie prüfen das Ergebnis und geben Feedback. Wir verfeinern gemeinsam, bis Sie zufrieden sind.'],
    ['title' => 'Launch',                       'desc' => 'Die Website geht live. Ich helfe beim technischen Setup: Domain, Hosting, E-Mail. Sie konzentrieren sich auf Ihr Unternehmen, ich sorge dafür, dass alles technisch stimmt.'],
    ['title' => 'Nachbetreuung (optional)',      'desc' => 'Nach dem Launch kann ich die technische Nachbetreuung übernehmen: Updates, kleine Anpassungen, Monitoring. So bleibt Ihre Website sicher und aktuell.'],
],
```

- [ ] **Step 7.4: Replace hardcoded steps rendering with translation keys**

Replace the `@php $steps = [...]` block and the ol loop:
```php
{{-- Before --}}
@php
$steps = [
    ['title' => 'Kennismaking', 'desc' => '...'],
    ...
];
@endphp
<ol ...>
    @foreach($steps as $i => $step)
    ...
    @endforeach
</ol>

{{-- After --}}
<ol class="space-y-0" aria-label="{{ __('site.process.heading') }}">
    @foreach(__('site.process.steps') as $i => $step)
    <li class="flex gap-6 {{ !$loop->last ? 'pb-8' : '' }}">
        <div class="flex flex-col items-center">
            <div class="w-9 h-9 rounded-full {{ $i === 0 ? 'bg-slate-900 text-white shadow-sm' : 'bg-white border-2 border-stone-300 text-slate-400' }} text-xs font-bold flex items-center justify-center shrink-0 z-10">
                {{ $i + 1 }}
            </div>
            @if(!$loop->last)
            <div class="w-px flex-1 bg-stone-200 mt-2" aria-hidden="true"></div>
            @endif
        </div>
        <div class="{{ !$loop->last ? 'pb-2' : '' }}">
            <h2 class="font-serif text-lg font-medium text-slate-900 leading-snug">{{ $step['title'] }}</h2>
            <p class="mt-2 text-sm text-slate-500 leading-relaxed max-w-xl">{{ $step['desc'] }}</p>
        </div>
    </li>
    @endforeach
</ol>
```

- [ ] **Step 7.5: Replace hardcoded sidebar content**

Add translation keys for process sidebar to `lang/nl/site.php` `process` section:
```php
'sidebar_heading'      => 'Wat je kan verwachten',
'sidebar_items'        => [
    'Duidelijke communicatie in elke fase',
    'Geen verborgen kosten of verrassingen',
    'Rechtstreeks contact met de developer',
    'Leesbare, veilige en onderhoudbare code',
    'Aandacht voor mobiel en toegankelijkheid',
    'Een website die ook na lancering goed blijft werken',
],
'cta_box_heading'      => 'Klaar om te starten?',
'cta_box_body'         => 'Vertel me over je project. Het eerste gesprek is vrijblijvend.',
'cta_box_btn'          => 'Neem contact op',
```

Add equivalents to FR/EN/DE:

**FR:**
```php
'sidebar_heading' => 'Ce à quoi vous pouvez vous attendre',
'sidebar_items'   => [
    'Communication claire à chaque étape',
    'Pas de coûts cachés ni de surprises',
    'Contact direct avec le développeur',
    'Code lisible, sécurisé et maintenable',
    'Attention au mobile et à l\'accessibilité',
    'Un site qui continue de bien fonctionner après le lancement',
],
'cta_box_heading' => 'Prêt à commencer ?',
'cta_box_body'    => 'Parlez-moi de votre projet. La première conversation est sans engagement.',
'cta_box_btn'     => 'Prendre contact',
```

**EN:**
```php
'sidebar_heading' => 'What you can expect',
'sidebar_items'   => [
    'Clear communication at every stage',
    'No hidden costs or surprises',
    'Direct contact with the developer',
    'Readable, secure and maintainable code',
    'Attention to mobile and accessibility',
    'A website that continues to work well after launch',
],
'cta_box_heading' => 'Ready to get started?',
'cta_box_body'    => 'Tell me about your project. The first conversation is free and without obligation.',
'cta_box_btn'     => 'Get in touch',
```

**DE:**
```php
'sidebar_heading' => 'Was Sie erwarten können',
'sidebar_items'   => [
    'Klare Kommunikation in jeder Phase',
    'Keine versteckten Kosten oder Überraschungen',
    'Direkter Kontakt mit dem Entwickler',
    'Lesbarer, sicherer und wartungsfreundlicher Code',
    'Aufmerksamkeit für Mobile und Zugänglichkeit',
    'Eine Website, die auch nach dem Launch gut funktioniert',
],
'cta_box_heading' => 'Bereit loszulegen?',
'cta_box_body'    => 'Erzählen Sie mir von Ihrem Projekt. Das erste Gespräch ist unverbindlich.',
'cta_box_btn'     => 'Kontakt aufnehmen',
```

Then update the sidebar in the blade:
```php
<div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm">
    <h2 class="font-serif text-base font-medium text-slate-900 mb-4">{{ __('site.process.sidebar_heading') }}</h2>
    <ul class="space-y-3" role="list">
        @foreach(__('site.process.sidebar_items') as $point)
        <li class="flex items-start gap-3 text-sm text-slate-600">
            <span class="mt-1 w-4 h-4 rounded-full bg-blue-50 border border-blue-200 flex items-center justify-center shrink-0" aria-hidden="true">
                <svg class="w-2.5 h-2.5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </span>
            {{ $point }}
        </li>
        @endforeach
    </ul>
</div>

<div class="bg-blue-50 rounded-xl border border-blue-100 p-6">
    <h2 class="font-serif text-base font-medium text-slate-900 mb-2">{{ __('site.process.cta_box_heading') }}</h2>
    <p class="text-sm text-slate-500 leading-relaxed mb-5">{{ __('site.process.cta_box_body') }}</p>
    <a href="{{ $contactHref }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer">
        {{ __('site.process.cta_box_btn') }}
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
    </a>
</div>
```

- [ ] **Step 7.6: Commit**
```bash
git add resources/views/pages/process.blade.php lang/nl/site.php lang/fr/site.php lang/en/site.php lang/de/site.php
git commit -m "feat: process page fully locale-aware with 7 translated steps"
```

---

## Task 8 — Translate privacy.blade.php

**Files:**
- Modify: `resources/views/pages/privacy.blade.php`

The `lang/*/site.php` files now have `privacy.*` sections (added in Task 4).

- [ ] **Step 8.1: Replace opening layout tag with locale-aware SEO**

```php
@php
    $loc = app()->getLocale() ?: 'nl';
    $privacyCanonical = \Illuminate\Support\Facades\Route::has($loc . '.privacy') ? route($loc . '.privacy') : route('privacy');
    $homeHref         = \Illuminate\Support\Facades\Route::has($loc . '.home') ? route($loc . '.home') : route('home');
@endphp
<x-layouts.app
    :title="__('site.seo.privacy_title')"
    :description="__('site.seo.privacy_desc')"
    :canonical="$privacyCanonical"
    ogType="article"
>
```

- [ ] **Step 8.2: Replace header section**

```php
{{-- Before --}}
<p ...>Juridisch</p>
<h1 ...>Privacyverklaring</h1>
<p ...>Laatst bijgewerkt: {{ date('d F Y') }}</p>

{{-- After --}}
<p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
    {{ __('site.privacy.eyebrow') }}
</p>
<h1 class="font-serif text-4xl font-medium text-slate-900 leading-tight">{{ __('site.privacy.heading') }}</h1>
<p class="mt-3 text-sm text-slate-400">{{ __('site.privacy.last_updated') }}: {{ date('d F Y') }}</p>
```

- [ ] **Step 8.3: Replace all hardcoded sections**

Replace the entire `<div class="prose-content space-y-10 text-slate-600">` block:

```php
<div class="prose-content space-y-10 text-slate-600">

    <section aria-labelledby="privacy-wie">
        <h2 id="privacy-wie" class="font-serif text-xl font-medium text-slate-900 mb-3">{{ __('site.privacy.who_heading') }}</h2>
        <p class="leading-relaxed">{!! __('site.privacy.who_body') !!}</p>
        <p class="mt-3 leading-relaxed">
            {{ __('site.privacy.who_contact') }}:
            <a href="mailto:{{ config('studio.email') }}" class="text-blue-700 hover:underline">{{ config('studio.email') }}</a>
        </p>
    </section>

    <div class="border-t border-stone-200"></div>

    <section aria-labelledby="privacy-welke">
        <h2 id="privacy-welke" class="font-serif text-xl font-medium text-slate-900 mb-3">{{ __('site.privacy.data_heading') }}</h2>
        <p class="leading-relaxed mb-3">{{ __('site.privacy.data_intro') }}</p>
        <ul class="space-y-2 list-none" role="list">
            @foreach(__('site.privacy.data_items') as $item)
            <li class="flex items-start gap-2.5 text-sm">
                <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-slate-400 shrink-0" aria-hidden="true"></span>
                {{ $item }}
            </li>
            @endforeach
        </ul>
        <p class="mt-4 text-sm text-slate-500 leading-relaxed">{{ __('site.privacy.data_ip_note') }}</p>
    </section>

    <div class="border-t border-stone-200"></div>

    <section aria-labelledby="privacy-waarom">
        <h2 id="privacy-waarom" class="font-serif text-xl font-medium text-slate-900 mb-3">{{ __('site.privacy.purpose_heading') }}</h2>
        <p class="leading-relaxed">{{ __('site.privacy.purpose_intro') }}</p>
        <ul class="mt-3 space-y-2 list-none" role="list">
            @foreach(__('site.privacy.purpose_items') as $item)
            <li class="flex items-start gap-2.5 text-sm">
                <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0" aria-hidden="true"></span>
                {{ $item }}
            </li>
            @endforeach
        </ul>
        <p class="mt-4 leading-relaxed">{{ __('site.privacy.purpose_no_share') }}</p>
    </section>

    <div class="border-t border-stone-200"></div>

    <section aria-labelledby="privacy-bewaring">
        <h2 id="privacy-bewaring" class="font-serif text-xl font-medium text-slate-900 mb-3">{{ __('site.privacy.retention_heading') }}</h2>
        <p class="leading-relaxed">{{ __('site.privacy.retention_body') }}</p>
    </section>

    <div class="border-t border-stone-200"></div>

    <section aria-labelledby="privacy-beveiliging">
        <h2 id="privacy-beveiliging" class="font-serif text-xl font-medium text-slate-900 mb-3">{{ __('site.privacy.security_heading') }}</h2>
        <p class="leading-relaxed">{{ __('site.privacy.security_body') }}</p>
    </section>

    <div class="border-t border-stone-200"></div>

    <section aria-labelledby="privacy-cookies">
        <h2 id="privacy-cookies" class="font-serif text-xl font-medium text-slate-900 mb-3">{{ __('site.privacy.cookies_heading') }}</h2>
        <p class="leading-relaxed">{{ __('site.privacy.cookies_body') }}</p>
    </section>

    <div class="border-t border-stone-200"></div>

    <section aria-labelledby="privacy-rechten">
        <h2 id="privacy-rechten" class="font-serif text-xl font-medium text-slate-900 mb-3">{{ __('site.privacy.rights_heading') }}</h2>
        <p class="leading-relaxed mb-3">{{ __('site.privacy.rights_intro') }}</p>
        <ul class="space-y-2 list-none" role="list">
            @foreach(__('site.privacy.rights_items') as $item)
            <li class="flex items-start gap-2.5 text-sm">
                <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0" aria-hidden="true"></span>
                {{ $item }}
            </li>
            @endforeach
        </ul>
        <p class="mt-4 leading-relaxed">
            {!! __('site.privacy.rights_contact', ['email' => '<a href="mailto:' . config('studio.email') . '" class="text-blue-700 hover:underline">' . config('studio.email') . '</a>']) !!}
        </p>
    </section>

    <div class="border-t border-stone-200"></div>

    <section aria-labelledby="privacy-contact">
        <h2 id="privacy-contact" class="font-serif text-xl font-medium text-slate-900 mb-3">{{ __('site.privacy.questions_heading') }}</h2>
        <p class="leading-relaxed">
            {!! __('site.privacy.questions_body', ['email' => '<a href="mailto:' . config('studio.email') . '" class="text-blue-700 hover:underline">' . config('studio.email') . '</a>']) !!}
        </p>
        <p class="mt-3 leading-relaxed text-sm text-slate-500">
            {!! __('site.privacy.questions_dpa', ['link' => '<a href="' . __('site.privacy.questions_dpa_url') . '" target="_blank" rel="noopener noreferrer" class="text-blue-700 hover:underline">' . __('site.privacy.questions_dpa_link') . '</a>']) !!}
        </p>
    </section>

</div>
```

- [ ] **Step 8.4: Replace back link**

```php
{{-- Before --}}
<a href="{{ route('home') }}" ...>
    <svg ...></svg>
    Terug naar de homepage
</a>

{{-- After --}}
<a href="{{ $homeHref }}"
   class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors duration-200">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
    </svg>
    {{ __('site.privacy.back_home') }}
</a>
```

- [ ] **Step 8.5: Commit**
```bash
git add resources/views/pages/privacy.blade.php
git commit -m "feat: privacy page fully locale-aware using translation keys"
```

---

## Task 9 — Fix services page canonical + remaining hardcoded items

**Files:**
- Modify: `resources/views/pages/services.blade.php`
- Modify: `resources/views/pages/pricing.blade.php`

Both pages currently have hardcoded `route('services')` and `route('pricing')` for canonical, which is not locale-aware.

- [ ] **Step 9.1: Fix services.blade.php canonical**

```php
{{-- Before --}}
<x-layouts.app
    :title="__('site.seo.services_title')"
    :description="__('site.seo.services_desc')"
    :canonical="route('services')"
    :ogTitle="__('site.seo.services_og_title')"
>

{{-- After --}}
@php
    $loc = app()->getLocale() ?: 'nl';
    $servicesCanonical = \Illuminate\Support\Facades\Route::has($loc . '.services') ? route($loc . '.services') : route('services');
@endphp
<x-layouts.app
    :title="__('site.seo.services_title')"
    :description="__('site.seo.services_desc')"
    :canonical="$servicesCanonical"
    :ogTitle="__('site.seo.services_og_title')"
>
```

- [ ] **Step 9.2: Fix pricing.blade.php canonical**

```php
{{-- Before --}}
<x-layouts.app
    :title="__('site.seo.pricing_title')"
    ...
    :canonical="route('pricing')"
    ...

{{-- After --}}
@php
    $loc = app()->getLocale() ?: 'nl';
    $pricingCanonical = \Illuminate\Support\Facades\Route::has($loc . '.pricing') ? route($loc . '.pricing') : route('pricing');
@endphp
<x-layouts.app
    :title="__('site.seo.pricing_title')"
    ...
    :canonical="$pricingCanonical"
    ...
```

- [ ] **Step 9.3: Commit**
```bash
git add resources/views/pages/services.blade.php resources/views/pages/pricing.blade.php
git commit -m "fix: locale-aware canonical on services and pricing pages"
```

---

## Task 10 — Final checks

- [ ] **Step 10.1: Clear cached config and views**
```bash
rm bootstrap/cache/config.php 2>/dev/null; php artisan view:clear; php artisan view:cache
```
Expected: "Blade templates cached successfully."

- [ ] **Step 10.2: Verify Blade compiles without errors**

If `php artisan view:cache` fails, check the error output and fix any template syntax issues.

- [ ] **Step 10.3: Run npm build**
```bash
npm run build
```
Expected: Build succeeds with similar bundle sizes as before.

- [ ] **Step 10.4: Run route:list to verify all locales**
```bash
php artisan route:list --path=de/ | head -20
php artisan route:list --path=fr/ | head -20
```
Expected: All 8+ routes per locale showing correctly.

- [ ] **Step 10.5: Verify no missing translation key strings visible**

Visit `/nl`, `/fr/services`, `/en/werkwijze`... and scan for any `site.` key patterns visible on page (indicates missing translation key). Fix if found.

- [ ] **Step 10.6: Final commit**
```bash
git add .
git commit -m "chore: multilingual translation complete — all public pages locale-aware"
```

---

## Self-Review — Spec Coverage

1. ✅ Task 1 (find all non-translated pages) — covered by reading codebase before writing plan
2. ✅ Task 2 (translate services) — services page already uses `__()`, new addons labels in Tasks 2+3
3. ✅ Task 3 (refine Extra mogelijkheden) — Task 2 in this plan
4. ✅ Task 4 (fix white space) — Task 1 step 1.1 removes `mt-24`
5. ✅ Task 5 (translate pricing) — pricing page already uses `__()`, missing keys added in Task 3
6. ✅ Task 6 (translate process) — Task 7 in this plan
7. ✅ Task 7 (translate showcase) — Task 6 in this plan
8. ✅ Task 8 (translate about) — Task 5 in this plan
9. ✅ Task 9 (translate contact) — contact page already uses `__()`, new needs added in previous session
10. ✅ Task 10 (translate privacy) — Tasks 4+8 in this plan
11. ✅ Task 11 (SEO metadata) — Tasks 5/6/7/8/9 all fix locale-aware canonical + SEO metadata
12. ✅ Task 12 (routes, sitemap, hreflang) — routes already done, sitemap already done
13. ✅ Task 13 (final checks) — Task 10 in this plan

## Manual Review Needed After Completion

1. **German copy** — Set `config/studio.php` `translations_ready.de = true` after native German speaker reviews `lang/de/site.php`
2. **Project descriptions in FR/EN/DE** — `config/projects.php` is Dutch. Project descriptions/proves text shows in Dutch on FR/EN/DE about and showcase pages. To fully translate: add `lang/{locale}/projects.php` and update controllers to merge locale-specific data (out of scope for this plan, recommend manual review)
3. **Technology group labels** in about page sidebar — kept in English as universal technical terms (Frontend, Backend & database, etc.)
4. **Privacy "last updated" date** — uses `date('d F Y')` in PHP locale. Consider using Carbon with locale awareness if French/German month names are needed
5. **OG images** — No locale-specific OG images exist; all locales share the same default brand name OG
