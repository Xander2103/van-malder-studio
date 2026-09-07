<?php

/**
 * SEO Landing Pages — config-driven, quality over quantity.
 *
 * Each page must have unique intro and content — not just city-name substitution.
 * Do not add pages without unique, useful copy.
 * Initial set: Dutch only. FR/EN versions should not be created until translated.
 *
 * Primary region: Tervuren (thuisbasis) · Leuven · Vlaams-Brabant · Overijse — these four are
 * the pages Search Console shows impressions for. Duisburg, Hoeilaart, Huldenberg and
 * Bertem stay as supporting Druivenstreek pages. One primary page per search intent.
 *
 * Schema per page:
 *   slug             string   — URL path under /{locale}/
 *   locale           string   — nl | fr | en
 *   meta_title       string   — <title> tag (keep under 60 chars)
 *   meta_description string   — meta description (150–160 chars)
 *   h1               string   — visible page heading
 *   intro            string   — unique opening paragraph
 *   service_type     string   — website | webshop | redesign | forms | maintenance | seo | apps
 *   location         string|null — city/region, or null for general service pages
 *   who_for          string   — short "voor wie" sentence
 *   bullets          array    — "what is included" list (5–7 items)
 *   steps            array    — werkwijze steps: [{title, body}, ...]
 *   honest_note      string|null — honest SEO note (no guarantees)
 *   faq              array    — [[q, a], ...]
 *   related          array    — slugs of related landing pages
 *   cta_text         string   — CTA button label
 *   proof            array|null — client proof block: [heading, intro, clients => [client-work slug => one factual line]]
 *   redirect_to      string|null — retired slug: 301 to this slug (kept out of sitemap and related links)
 *   noindex          bool     — true = add noindex (use for stubs / untranslated)
 *   sitemap_priority string|null — sitemap <priority>; defaults to 0.8 when omitted.
 *                                  0.9 = primary region page.
 */

return [

    // ═══════════════════════════════════════════════════════════════════════════
    // PHASE 1 — Service pages
    // ═══════════════════════════════════════════════════════════════════════════

    // ─── 1. Website laten maken (algemeen) ───────────────────────────────────
    [
        'slug'             => 'website-laten-maken',
        'locale'           => 'nl',
        'meta_title'       => 'Website laten maken | Van Malder Studio',
        'meta_description' => 'Een professionele website laten maken voor je zaak? Van Malder Studio bouwt responsive, snelle websites met SEO-basis voor zelfstandigen en lokale bedrijven.',
        'h1'               => 'Website laten maken voor je zaak',
        'intro'            => 'Een website is vaak het eerste wat potentiële klanten van je zien. Niet een template die eruitziet als duizend andere sites, maar een doordachte online aanwezigheid die past bij wie je bent en wat je doet. Ik bouw websites voor zelfstandigen en lokale bedrijven — responsive, snel en met een technische SEO-basis die Google en bezoekers de weg wijst.',
        'service_type'     => 'website',
        'location'         => null,
        'who_for'          => 'Voor zelfstandigen, vrije beroepen en lokale bedrijven die professioneel online zichtbaar willen zijn.',
        'bullets'          => [
            'Responsive design — perfect op smartphone, tablet en desktop',
            'Snelle laadtijd door technische optimalisatie',
            'SEO-basis inbegrepen: titels, meta, semantische structuur',
            'Duidelijke contactflow of call-to-action',
            'Van eenvoudige landingspagina tot uitgebreide bedrijfssite',
            'Geen templates — doordacht maatwerk',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken jouw zaak, doelgroep en wat je verwacht van je nieuwe website. Vrijblijvend, zonder verplichtingen.'],
            ['title' => 'Voorstel op maat', 'body' => 'Je krijgt een concreet voorstel met scope, aanpak, prijs en timing. Geen verrassingen achteraf.'],
            ['title' => 'Ontwerp en bouw', 'body' => 'Ik ontwerp en bouw de website. Je krijgt updates over de voortgang en hebt inspraak in elke fase.'],
            ['title' => 'Lancering en opvolging', 'body' => 'We lanceren samen. Daarna ben ik bereikbaar voor vragen, aanpassingen en onderhoud.'],
        ],
        'honest_note'      => 'Een goede website legt de basis voor online zichtbaarheid. Garanties op Google-rankings geef ik niet — niemand kan dat eerlijk beloven. Wat ik wel doe: een technisch solide, inhoudelijk relevante site bouwen die bezoekers en zoekmachines de juiste informatie geeft.',
        'faq'              => [
            ['q' => 'Wat kost een website laten maken?', 'a' => 'Een starterspakket begint vanaf €750. De uiteindelijke prijs hangt af van het aantal pagina\'s, gewenste functionaliteiten, formulieren en talen. Na een gesprek maak ik een concreet voorstel op maat.'],
            ['q' => 'Hoe lang duurt het om een website te bouwen?', 'a' => 'Gemiddeld 2 tot 6 weken, afhankelijk van de scope en hoe snel feedback en inhoud aangeleverd worden.'],
            ['q' => 'Wat heb ik nodig om te starten?', 'a' => 'Een kort gesprek over je doelen en doelgroep is voldoende om te beginnen. Teksten en beelden kunnen later aangeleverd worden.'],
            ['q' => 'Kan ik de website nadien zelf aanpassen?', 'a' => 'Dat bespreken we op voorhand. Ik kan een eenvoudige admin-omgeving voorzien zodat je teksten en foto\'s zelf kunt beheren, of ik neem het onderhoud op mij.'],
        ],
        'related'          => ['website-laten-maken-tervuren', 'website-laten-maken-overijse', 'website-vernieuwen'],
        'cta_text'         => 'Bespreek je website vrijblijvend',
        'noindex'          => false,
    ],

    // ─── 2. Website vernieuwen ────────────────────────────────────────────────
    [
        'slug'             => 'website-vernieuwen',
        'locale'           => 'nl',
        'meta_title'       => 'Website vernieuwen | Van Malder Studio',
        'meta_description' => 'Je website is verouderd, traag of werkt slecht op mobiel? Ik verbouw je site met sterkere structuur, beter vertrouwen en een duidelijkere contactflow.',
        'h1'               => 'Je website vernieuwen',
        'intro'            => 'Een verouderde website wekt twijfel — bij bezoekers én bij Google. Trage laadtijd, slechte mobiele weergave, onduidelijke structuur of een uitstraling die niet meer past bij wie je bent: dat zijn allemaal redenen om je site te vernieuwen. Ik analyseer wat er beter kan en bouw een frissere versie die werkt op alle toestellen en de juiste boodschap uitstraalt.',
        'service_type'     => 'redesign',
        'location'         => null,
        'who_for'          => 'Voor bedrijven en zelfstandigen met een verouderde, trage, onduidelijke of niet-mobielvriendelijke website.',
        'bullets'          => [
            'Analyse van de huidige situatie: structuur, snelheid, mobiel',
            'Sterkere uitstraling die past bij wie je bent',
            'Betere mobiele ervaring op alle schermformaten',
            'Duidelijkere contactflow of call-to-action',
            'Correcte redirects zodat je bestaande SEO bewaard blijft',
            'Behoud van wat al werkt — verbetering van de rest',
        ],
        'steps'            => [
            ['title' => 'Analyse van de huidige site', 'body' => 'Ik bekijk je bestaande website: structuur, laadtijd, mobiele weergave en inhoud. Zo maak ik een eerlijke inschatting.'],
            ['title' => 'Plan voor de vernieuwing', 'body' => 'Je krijgt een voorstel: wat we bewaren, wat we verbeteren en wat we vervangen.'],
            ['title' => 'Herbouw', 'body' => 'Ik herbouw de website met behoud van je bestaande URL\'s en SEO-waarde waar mogelijk.'],
            ['title' => 'Lancering en migratie', 'body' => 'We migreren netjes van oud naar nieuw. Redirects worden ingesteld zodat je geen bestaand verkeer verliest.'],
        ],
        'honest_note'      => null,
        'faq'              => [
            ['q' => 'Verlies ik mijn huidige URL\'s of SEO?', 'a' => 'Niet als we dat goed plannen. Bij een vernieuwing zorg ik voor correcte redirects zodat bestaande URL\'s doorverwijzen naar de nieuwe structuur.'],
            ['q' => 'Kan ik mijn bestaande inhoud bewaren?', 'a' => 'Ja, teksten en afbeeldingen die je wilt bewaren kunnen overgenomen worden in de nieuwe versie.'],
            ['q' => 'Wat als mijn huidige site op een CMS staat dat ik niet wil bewaren?', 'a' => 'Dan stap je over naar een nieuw platform. Ik help je kiezen wat het beste past bij je wensen voor beheer en functionaliteiten.'],
        ],
        'related'          => ['website-laten-maken', 'website-laten-maken-tervuren', 'website-onderhoud'],
        'cta_text'         => 'Bespreek de vernieuwing',
        'noindex'          => false,
    ],

    // ─── 3. Webshop laten maken ───────────────────────────────────────────────
    [
        'slug'             => 'webshop-laten-maken',
        'locale'           => 'nl',
        'meta_title'       => 'Webshop laten maken | Van Malder Studio',
        'meta_description' => 'Een webshop laten maken voor je producten of diensten? Van Malder Studio bouwt productcatalogi en webshops op maat — van eenvoudig tot uitgebreid, met SEO-basis.',
        'h1'               => 'Webshop laten maken voor je producten',
        'intro'            => 'Wil je producten online tonen of verkopen? Dat hoeft niet groot of ingewikkeld te zijn. Ik bouw wat jij nodig hebt: een eenvoudige productcatalogus, een webshop met winkelmandje, of een uitgebreidere oplossing met betalingen en bestelopvolging. De scope bepaalt de prijs — en die bespreken we samen op basis van wat jij echt nodig hebt.',
        'service_type'     => 'webshop',
        'location'         => null,
        'who_for'          => 'Voor zelfstandigen en lokale bedrijven die producten online willen tonen of verkopen — van een productcatalogus tot een volledige webshop met betalingen.',
        'bullets'          => [
            'Productcatalogus (tonen zonder verkoop): v.a. €950',
            'Webshop met winkelmandje en betalingen: v.a. €1.500',
            'SEO-basis voor producten en categorieën inbegrepen',
            'Duidelijke productpagina\'s en overzichtelijke bestelprocedure',
            'Koppeling met veelgebruikte betaaloplossingen (Mollie, Stripe)',
            'Admin-omgeving om zelf producten en prijzen te beheren',
        ],
        'steps'            => [
            ['title' => 'Inventaris van je producten', 'body' => 'We inventariseren je producten, categorieën, gewenste functies en budget. Zo kies ik de juiste aanpak.'],
            ['title' => 'Voorstel en scope', 'body' => 'Je krijgt een voorstel op maat: van eenvoudige productcatalogus tot webshop met betalingen en bestelopvolging.'],
            ['title' => 'Bouw en integratie', 'body' => 'Ik bouw de shop en integreer productbeheer, eventuele betalingen en bevestigingsmails.'],
            ['title' => 'Test en lancering', 'body' => 'We testen alles grondig — bestelprocedure, betalingen, notificaties — voor je live gaat.'],
        ],
        'honest_note'      => 'Een webshop is niet zomaar een website met een bestelknop. De prijs en aanpak hangen af van wat je écht nodig hebt: aantallen, betalingen, verzending, beheer. Ik geef je een eerlijk voorstel op basis van jouw situatie.',
        'faq'              => [
            ['q' => 'Is een webshop duurder dan een website?', 'a' => 'Ja, in de meeste gevallen. Een webshop heeft extra functionaliteiten zoals productbeheer, winkelmandje en betalingen. De prijs hangt sterk af van de scope.'],
            ['q' => 'Welke betaaloplossingen zijn mogelijk?', 'a' => 'Dat bespreken we op basis van je noden. Veelgebruikte opties zijn Mollie, Stripe of PayPal. De keuze hangt af van je producten en budget.'],
            ['q' => 'Kan ik later producten zelf toevoegen?', 'a' => 'Ja. Ik kan een admin-omgeving voorzien waarmee je zelf producten, foto\'s en prijzen beheert.'],
            ['q' => 'Wat als ik maar een klein aantal producten heb?', 'a' => 'Dan is een productcatalogus (zonder winkelmandje) misschien voldoende. Dat is goedkoper en eenvoudiger te beheren. We bespreken wat het beste past.'],
        ],
        'related'          => ['website-laten-maken', 'offerteformulier-laten-maken', 'website-laten-maken-tervuren'],
        'cta_text'         => 'Bespreek je webshop',
        'noindex'          => false,
    ],

    // ─── 4. Offerteformulier laten maken ─────────────────────────────────────
    [
        'slug'             => 'offerteformulier-laten-maken',
        'locale'           => 'nl',
        'meta_title'       => 'Offerteformulier laten maken | Van Malder Studio',
        'meta_description' => 'Een offerteformulier laten maken dat de juiste vragen stelt? Van Malder Studio bouwt formulieren op maat voor aannemers, dienstverleners en kmo\'s.',
        'h1'               => 'Offerteformulier laten maken',
        'intro'            => 'Niet elk contactformulier hoeft "naam, e-mail, bericht" te zijn. Een goed offerteformulier stelt de juiste vragen, zodat aanvragen meteen duidelijker zijn — voor jou én voor de klant. Ik bouw formulieren op maat: van een eenvoudige aanvraagtool tot een meerstaps intake met samenvatting en bevestigingsmail.',
        'service_type'     => 'forms',
        'location'         => null,
        'who_for'          => 'Voor aannemers, tuinaanleggers, dienstverleners, kmo\'s en iedereen die betere en completere aanvragen wil ontvangen via hun website.',
        'bullets'          => [
            'Offerteformulier of aanvraagtool op maat',
            'Meerstapsformulier met validatie en samenvatting',
            'Afspraakaanvraag, reservatie of intakeformulier',
            'GDPR-conform, spambestendig en veilig gebouwd',
            'Duidelijke bevestigingsmails voor klant en eigenaar',
            'Integratie in je bestaande website mogelijk',
        ],
        'steps'            => [
            ['title' => 'Gesprek over je aanvraagproces', 'body' => 'We bespreken hoe je nu aanvragen krijgt, wat er mis gaat en welke informatie je echt nodig hebt van je klanten.'],
            ['title' => 'Formulierontwerp', 'body' => 'Ik ontwerp de stappen, velden en logica van het formulier op maat van jouw dienst.'],
            ['title' => 'Bouw en integratie', 'body' => 'Het formulier wordt gebouwd en geïntegreerd in je website, met bevestigingsmails en validatie.'],
            ['title' => 'Test en lancering', 'body' => 'We testen alles grondig voor je live gaat: verzenden, bevestigingen, spambescherming.'],
        ],
        'honest_note'      => null,
        'faq'              => [
            ['q' => 'Kan het formulier gekoppeld worden aan mijn e-mail?', 'a' => 'Ja — je ontvangt een duidelijke bevestigingsmail bij elke aanvraag. Koppeling aan andere tools is mogelijk op aanvraag.'],
            ['q' => 'Wat kost een formulier op maat?', 'a' => 'Een formulier op maat start vanaf €100. De prijs hangt af van het aantal stappen, velden en de gewenste logica.'],
            ['q' => 'Kan ik het formulier in mijn bestaande website integreren?', 'a' => 'Ja, dat is mogelijk. Ik bekijk je bestaande site en bouw het formulier in. Ik hoef je volledige website niet te herbouwen.'],
        ],
        'related'          => ['website-laten-maken', 'website-vernieuwen', 'website-onderhoud'],
        'cta_text'         => 'Bespreek je formulier',
        'noindex'          => false,
    ],

    // ─── 5. Website onderhoud ─────────────────────────────────────────────────
    [
        'slug'             => 'website-onderhoud',
        'locale'           => 'nl',
        'meta_title'       => 'Website onderhoud | Van Malder Studio',
        'meta_description' => 'Technisch onderhoud voor je website: updates, beveiligingscontroles, backups en kleine aanpassingen. Maandelijkse opvolging vanaf €50.',
        'h1'               => 'Website onderhoud en technische opvolging',
        'intro'            => 'Een website heeft onderhoud nodig. Beveiligingsupdates, technische fixes, kleine aanpassingen, backups — als je dat niet opvolgt, riskeert je site kwetsbaar te worden of te verouderen. Ik neem de technische opvolging op zodat jij je op je zaak kunt focussen, niet op je website.',
        'service_type'     => 'maintenance',
        'location'         => null,
        'who_for'          => 'Voor bedrijven en zelfstandigen met een bestaande website die gegarandeerd veilig, up-to-date en technisch in orde blijft.',
        'bullets'          => [
            'Maandelijkse updates en beveiligingschecks',
            'Kleine tekstuele of visuele aanpassingen',
            'Backups en monitoring',
            'Snelle reactie bij problemen',
            'Duidelijke afspraken — geen verborgen kosten',
            'Onderhoud vanaf €50/maand, geen lange contracten',
        ],
        'steps'            => [
            ['title' => 'Kennismaking', 'body' => 'We bespreken welke website je hebt, welke technologie eronder zit en wat er onderhouden moet worden.'],
            ['title' => 'Afspraken vastleggen', 'body' => 'Ik stel een duidelijk pakket voor met wat inbegrepen is en wat de maandelijkse kost is. Geen kleine lettertjes.'],
            ['title' => 'Actieve opvolging', 'body' => 'Ik hou updates, beveiliging en prestaties bij — zonder dat jij er aan hoeft te denken.'],
            ['title' => 'Feedback en rapportage', 'body' => 'Je krijgt periodiek een korte update over wat er gedaan werd. Bij problemen reageer ik snel.'],
        ],
        'honest_note'      => null,
        'faq'              => [
            ['q' => 'Wat is inbegrepen in het onderhoudspakket?', 'a' => 'Updates, beveiligingscontroles, backups en kleine aanpassingen. Grotere wijzigingen worden apart besproken en gefactureerd.'],
            ['q' => 'Moet ik een lange termijn engageren?', 'a' => 'Nee. Ik werk op maandbasis, zonder lange contracten. Je kunt maandelijks opzeggen met een korte opzegtermijn.'],
            ['q' => 'Kan je ook websites onderhouden die niet door jou gebouwd zijn?', 'a' => 'Dat hangt af van de technologie en toegangsrechten. Na een korte analyse laat ik je weten of en hoe ik het onderhoud kan overnemen.'],
        ],
        'related'          => ['website-laten-maken', 'website-vernieuwen', 'offerteformulier-laten-maken'],
        'cta_text'         => 'Vraag onderhoud aan',
        'noindex'          => false,
    ],

    // ─── 6. Lokale SEO voor bedrijven ────────────────────────────────────────
    [
        'slug'             => 'seo-voor-lokale-bedrijven',
        'locale'           => 'nl',
        'meta_title'       => 'Lokale SEO voor je bedrijf | Van Malder Studio',
        'meta_description' => 'Klanten zoeken lokaal — maar vinden ze jou? Ik leg de technische en inhoudelijke SEO-basis die Google nodig heeft om jouw zaak te tonen in lokale zoekresultaten.',
        'h1'               => 'Lokale SEO voor kleine bedrijven en zelfstandigen',
        'intro'            => 'Je klanten zoeken online. Soms letterlijk: "kapper Tervuren", "elektricien Overijse", "aannemer Huldenberg". Maar staat jouw zaak in die resultaten? Lokale SEO is niet hetzelfde als grote campagnes draaien — het is je website en je online aanwezigheid zo inrichten dat Google begrijpt wie je bent, waar je actief bent en voor wie je werkt. Ik help je die basis leggen: eerlijk, technisch correct en zonder beloften die ik niet kan waarmaken.',
        'service_type'     => 'seo',
        'location'         => null,
        'who_for'          => 'Voor zelfstandigen en lokale bedrijven in de Druivenstreek, Vlaams-Brabant en omgeving die beter gevonden willen worden door klanten in hun buurt.',
        'bullets'          => [
            'Google Business Profile optimalisatie (lokale zoekresultaten en Maps)',
            'Technische SEO-basis: titels, meta, semantische HTML, canonical',
            'Lokale zoekwoorden correct verwerkt in je pagina\'s',
            'Consistente NAP-informatie (naam, adres, telefoonnummer) doorheen het web',
            'Snelle laadtijd en mobile-friendly als ranking factor',
            'Eerlijk advies over wat werkt en wat niet — geen holle beloften',
        ],
        'steps'            => [
            ['title' => 'Analyse', 'body' => 'Ik bekijk je huidige website, Google Business Profile en zoekbaarheid. Waar liggen de kansen en problemen?'],
            ['title' => 'Prioriteitenplan', 'body' => 'Ik leg een concrete lijst voor met haalbare verbeteringen, gerangschikt op impact.'],
            ['title' => 'Implementatie', 'body' => 'Ik verwerk de aanpassingen — technisch en inhoudelijk — in je website en online profielen.'],
            ['title' => 'Opvolging', 'body' => 'Na enkele maanden evalueren we samen de resultaten en sturen bij waar nodig.'],
        ],
        'honest_note'      => 'SEO is een langetermijnproces. Garanties op specifieke posities zijn oneerlijk en onmogelijk — wie dat belooft, liegt. Wat ik doe: een sterke technische basis leggen die je kansen vergroot om gevonden te worden. De rest hangt af van relevantie, concurrentie en tijd.',
        'faq'              => [
            ['q' => 'Wat is het verschil tussen lokale SEO en gewone SEO?', 'a' => 'Lokale SEO richt zich op zoekopdrachten met een geografische component — "kapper in Tervuren" of "elektricien Overijse". Je optimaliseert voor een specifieke regio, niet voor het volledige internet.'],
            ['q' => 'Moet ik ook een Google Business Profile hebben?', 'a' => 'Ja, absoluut. Een geoptimaliseerd Google Business Profile is één van de meest impactvolle dingen die je kunt doen voor lokale zichtbaarheid — en het is gratis.'],
            ['q' => 'Hoe lang duurt het voor ik iets merk?', 'a' => 'Dat verschilt sterk per regio, sector en concurrentie. Vaak zie je na 3 tot 6 maanden beweging. Sommige lokale zoekopdrachten zijn sneller te beïnvloeden dan andere.'],
            ['q' => 'Werk je ook voor websites die door iemand anders gebouwd zijn?', 'a' => 'Ja. Ik kan SEO-verbeteringen doorvoeren op bestaande websites, ook als ik ze niet zelf gebouwd heb. Na een korte analyse vertel ik je wat mogelijk is.'],
        ],
        'related'          => ['website-laten-maken-tervuren', 'website-laten-maken-overijse', 'website-laten-maken'],
        'cta_text'         => 'Bespreek je online zichtbaarheid',
        'noindex'          => false,
    ],

    // ═══════════════════════════════════════════════════════════════════════════
    // PHASE 2 — Local priority pages
    // ═══════════════════════════════════════════════════════════════════════════

    // ─── 7. Website laten maken — Tervuren (thuisbasis, primaire lokale pagina) ─
    // Primaire pagina voor: website laten maken (in) Tervuren, webdesigner Tervuren,
    // webdesign Tervuren, website creation Tervuren. /nl/webdesigner-tervuren 301't hierheen.
    [
        'slug'             => 'website-laten-maken-tervuren',
        'locale'           => 'nl',
        'meta_title'       => 'Website laten maken in Tervuren | Van Malder Studio',
        'meta_description' => 'Webdesigner en developer uit Tervuren. Professionele websites voor zelfstandigen en kmo\'s, met maatwerk waar nodig. Rechtstreeks met Xander, vanaf €750.',
        'h1'               => 'Website laten maken in Tervuren',
        'intro'            => 'Van Malder Studio is de webstudio van Xander Van Malder, webdesigner en full stack developer gevestigd in Tervuren (Duisburg). Ik ontwerp en bouw professionele websites voor zelfstandigen, vrije beroepen en kmo\'s in Tervuren, Vossem, Moorsel en de Druivenstreek — en waar het nuttig is ook de functionaliteit erachter: een offerteformulier met opvolging, een eigen beheeromgeving of een koppeling met de tools die je al gebruikt. Rechtstreeks contact, een helder voorstel en een starterspakket vanaf €750.',
        'service_type'     => 'website',
        'location'         => 'Tervuren / Druivenstreek',
        'who_for'          => 'Voor zelfstandigen, vrije beroepen en lokale bedrijven in Tervuren, Vossem, Moorsel en Duisburg, en in de omliggende gemeenten van de Druivenstreek: Overijse, Hoeilaart, Huldenberg en Bertem.',
        'bullets'          => [
            'Ontwerp én bouw door dezelfde persoon — je praat rechtstreeks met Xander',
            'Responsive design: smartphone, tablet en desktop in balans',
            'SEO-basis voor lokale zoekopdrachten in Tervuren en omgeving',
            'Duidelijke contactflow: bezoekers vinden snel de weg naar een aanvraag',
            'Maatwerk waar nodig: offerteformulier, beheeromgeving of integratie',
            'Starterspakket vanaf €750 — concreet voorstel na gesprek, alle richtprijzen op de prijzenpagina',
            'Onderhoud en opvolging na lancering, vanaf €50/maand',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken jouw zaak, jouw klanten en wat je van je website verwacht. In Tervuren, bij jou op de zaak of via video — jij kiest.'],
            ['title' => 'Voorstel op maat', 'body' => 'Je krijgt een concreet plan met scope, aanpak, prijs en timing. Duidelijk en zonder verborgen kosten.'],
            ['title' => 'Ontwerp en bouw', 'body' => 'Ik ontwerp en bouw de website. Je wordt op de hoogte gehouden en hebt inspraak in elke stap.'],
            ['title' => 'Lancering', 'body' => 'We lanceren samen en ik blijf bereikbaar voor vragen, aanpassingen en eventueel onderhoud.'],
        ],
        'why_local'        => [
            ['title' => 'Gevestigd in Tervuren', 'body' => 'Van Malder Studio werkt vanuit Duisburg (Tervuren). Een kennismaking in de buurt is snel geregeld: in het centrum van Tervuren, bij jou op de zaak of via video.'],
            ['title' => 'Je werkt rechtstreeks met Xander', 'body' => 'Geen account manager, geen uitbesteding. Ik ontwerp en bouw zelf, en begeleid je project van het eerste gesprek tot de lancering.'],
            ['title' => 'Meer dan een brochure als dat nodig is', 'body' => 'Voor Mastechnics bouwde ik een meertalige website met slimme aanvraagformulieren en een eigen beheeromgeving voor de opvolging van klanten. Groeit je zaak, dan kan je website meegroeien.'],
            ['title' => 'Eerlijk en transparant', 'body' => 'Een helder voorstel met prijs en planning, geen verborgen kosten. En eerlijk advies, ook als een eenvoudigere oplossing beter past.'],
        ],
        'proof'            => [
            'heading' => 'Gebouwd voor echte bedrijven',
            'intro'   => 'Elke website hieronder staat live en werd ontworpen en ontwikkeld door Van Malder Studio. Zo zie je zelf hoe een website voor een zelfstandige of kmo eruit kan zien: van een lokale schrijnwerkerij tot een bedrijf met eigen beheeromgeving.',
            'clients' => [
                'mastechnics'                   => 'Meertalige website met slimme aanvraagflow en eigen beheeromgeving voor opvolging.',
                'dr-sue-liza-eta'               => 'Medische website gericht op vertrouwen en online afspraken.',
                'schrijnwerkerij-van-kerkhoven' => 'Website voor een lokale schrijnwerkerij met projectoverzicht en lokale vindbaarheid.',
            ],
        ],
        'honest_note'      => 'Lokale relevantie in je website helpt zoekmachines begrijpen wie je bent en waar je actief bent. Ik bouw die structuur correct in. Garanties op rankings geef ik niet — dat is onmogelijk om eerlijk te beloven.',
        'faq'              => [
            ['q' => 'Wat kost een website laten maken in Tervuren?', 'a' => 'Een starterswebsite begint vanaf €750, een professionele website vanaf €1.250. De prijs hangt af van het aantal pagina\'s, talen, formulieren en functies. Na een kennismakingsgesprek maak ik een concreet voorstel op maat.'],
            ['q' => 'Hoe lang duurt het om een website te laten maken?', 'a' => 'Gemiddeld 2 tot 6 weken, afhankelijk van de scope en hoe snel feedback en inhoud aangeleverd worden.'],
            ['q' => 'Kunnen we elkaar ontmoeten in Tervuren?', 'a' => 'Ja. Ik ben gevestigd in Duisburg (Tervuren) en spreek graag af in de buurt of bij jou op de zaak. Er is geen winkel of kantoor met openingsuren: afspreken gebeurt op afspraak, en via video kan uiteraard ook.'],
            ['q' => 'Werk je enkel in Tervuren?', 'a' => 'Tervuren en de Druivenstreek zijn mijn thuisbasis: Duisburg, Overijse, Hoeilaart, Huldenberg en Bertem liggen op een kwartier rijden. Daarbuiten werk ik ook — Leuven, de Brusselse rand en de rest van Vlaams-Brabant — maar in de directe regio kunnen we makkelijker persoonlijk afspreken.'],
            ['q' => 'Ontwerp je de website ook, of bouw je alleen?', 'a' => 'Allebei. Ik ontwerp en bouw de website zelf: lay-out, typografie, kleur, structuur en de technische kant. Heb je al een logo of huisstijl, dan bouw ik daarop verder. Heb je nog niets, dan bepalen we samen een eenvoudige professionele richting.'],
            ['q' => 'Kan mijn bestaande website vernieuwd worden?', 'a' => 'Ja. Ik analyseer eerst je huidige website — structuur, snelheid, mobiele ervaring, contactflow en SEO — en bespreek daarna eerlijk of een volledige vernieuwing of gerichte aanpassingen het meeste opleveren.'],
            ['q' => 'Kan ik later uitbreiden met een webshop, beheeromgeving of integratie?', 'a' => 'Ja. Websites bouw ik zo dat ze kunnen groeien. Een productcatalogus of webshop, een offerteformulier met opvolging, een eigen beheeromgeving om teksten en aanvragen zelf te beheren, of een koppeling met je agenda, nieuwsbrief of CRM kunnen later toegevoegd worden.'],
        ],
        'related'          => ['website-laten-maken-leuven', 'website-laten-maken-overijse', 'webdesigner-vlaams-brabant'],
        'cta_text'         => 'Bespreek je website',
        'noindex'          => false,
        'sitemap_priority' => '0.9',
    ],

    // ─── 8. Website laten maken — Duisburg ───────────────────────────────────
    [
        'slug'             => 'website-laten-maken-duisburg',
        'locale'           => 'nl',
        'meta_title'       => 'Website laten maken in Duisburg | Van Malder Studio',
        'meta_description' => 'Webdeveloper in Duisburg en de Druivenstreek. Professionele websites voor zelfstandigen en lokale bedrijven. Persoonlijk contact, duurzame aanpak.',
        'h1'               => 'Website laten maken in Duisburg',
        'intro'            => 'Duisburg is een rustig dorp in de gemeente Tervuren, op de grens met Huldenberg en Overijse. Veel zelfstandigen en kleine bedrijven hier werken met lokale klanten maar zijn online nauwelijks zichtbaar. Als developer woonachtig in de Druivenstreek ken ik de streek en de mensen. Of je nu elektricien bent, kinesist, tuinaanlegger of bakker — ik bouw een website die past bij jouw zaak en jouw klanten, zonder poespas.',
        'service_type'     => 'website',
        'location'         => 'Duisburg / Tervuren',
        'who_for'          => 'Voor zelfstandigen, handwerkers en kleine bedrijven in Duisburg, Tervuren, Eizer en de omliggende Druivenstreek.',
        'bullets'          => [
            'Persoonlijk contact — je praat rechtstreeks met de developer',
            'Lokale kennis van Duisburg en de Druivenstreek',
            'Responsive website die snel laadt op alle toestellen',
            'Duidelijke contactflow voor lokale klanten',
            'SEO-basis inbegrepen: lokale zoektermen, snelle laadtijd',
            'Onderhoud en opvolging mogelijk na lancering',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken jouw zaak, doelen en klanten. Lokaal in de buurt of via video.'],
            ['title' => 'Voorstel', 'body' => 'Je krijgt een concreet plan met prijs en timing. Geen verrassingen achteraf.'],
            ['title' => 'Bouw', 'body' => 'Ik bouw de website en hou je op de hoogte van de voortgang.'],
            ['title' => 'Lancering', 'body' => 'We zetten alles live. Daarna ben ik bereikbaar voor vragen en opvolging.'],
        ],
        'honest_note'      => 'Een website met correcte lokale informatie en goede technische basis vergroot je kansen om gevonden te worden door klanten in de buurt. Garanties op rankings geef ik niet — dat is simpelweg niet eerlijk te beloven.',
        'faq'              => [
            ['q' => 'Werk je enkel in Duisburg?', 'a' => 'Nee — Duisburg is mijn thuisdorp, maar ik werk voor heel de Druivenstreek, Vlaams-Brabant en ook verder.'],
            ['q' => 'Is een lokale website echt nuttig voor een kleine zaak?', 'a' => 'Zeker. Juist kleine lokale bedrijven profiteren sterk van een goede online aanwezigheid. Klanten zoeken je online, ook als je klein bent.'],
            ['q' => 'Kan ik de website nadien zelf beheren?', 'a' => 'Dat bespreken we vooraf. Een eenvoudige admin-omgeving is mogelijk. Of ik neem het onderhoud op mij — afhankelijk van wat je verkiest.'],
        ],
        'related'          => ['website-laten-maken-tervuren', 'website-laten-maken-huldenberg', 'website-laten-maken-overijse'],
        'cta_text'         => 'Neem contact op',
        'noindex'          => false,
        'sitemap_priority' => '0.9',
    ],

    // ─── 9. Website laten maken — Overijse / Druivenstreek ───────────────────
    [
        'slug'             => 'website-laten-maken-overijse',
        'locale'           => 'nl',
        'meta_title'       => 'Website laten maken in Overijse | Van Malder Studio',
        'meta_description' => 'Professionele website voor je zaak in Overijse, Jezus-Eik, Maleizen of Tombeek. Gebouwd door Xander Van Malder uit het naburige Tervuren, vanaf €750.',
        'h1'               => 'Website laten maken in Overijse en de Druivenstreek',
        'intro'            => 'Overijse is het hart van de Druivenstreek — een gemeente met een sterke lokale identiteit, actieve horeca en ambachtelijke ondernemers. Of je zaak nu in Overijse zelf ligt, in Jezus-Eik, Maleizen of Tombeek: klanten zoeken je online en een professionele website maakt dat eerste contact makkelijker. Ik ben Xander Van Malder, webdeveloper uit het naburige Tervuren, en ik bouw websites die passen bij de streek: persoonlijk, technisch sterk en gericht op aanvragen.',
        'service_type'     => 'website',
        'location'         => 'Overijse / Druivenstreek',
        'who_for'          => 'Voor horeca, zelfstandigen, ambachtslieden en lokale bedrijven in Overijse, Jezus-Eik, Maleizen, Tombeek en de Druivenstreek.',
        'bullets'          => [
            'Lokale kennis van de Druivenstreek en Overijse',
            'Responsive website met sterke mobiele weergave',
            'SEO-basis voor lokale zoekopdrachten in de regio',
            'Duidelijke contactflow — of een reservatiesysteem voor horeca',
            'Persoonlijk contact — je werkt rechtstreeks met de developer',
            'Starterspakket vanaf €750 — concreet voorstel na gesprek',
            'Onderhoud en opvolging mogelijk na lancering',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken je zaak, je klanten en je doelen. In de Druivenstreek of via video.'],
            ['title' => 'Voorstel', 'body' => 'Je krijgt een duidelijk plan met scope, prijs en planning.'],
            ['title' => 'Bouw', 'body' => 'Ik bouw de website en hou je op de hoogte van elke stap.'],
            ['title' => 'Lancering en opvolging', 'body' => 'We gaan live en ik blijf bereikbaar voor verdere opvolging.'],
        ],
        'why_local'        => [
            ['title' => 'Op tien minuten van Overijse', 'body' => 'Van Malder Studio zit in Duisburg (Tervuren), vlak naast Overijse. Een gesprek bij jou op de zaak of ergens in de buurt is snel geregeld.'],
            ['title' => 'Functie boven franje', 'body' => 'Een restaurant heeft een menukaart en reservaties nodig, een aannemer een offerteformulier en projectfoto\'s, een wijnbouwer een verhaal en een webshop. De website wordt opgebouwd rond wat jouw klanten zoeken.'],
        ],
        'proof'            => [
            'heading' => 'Voorbeelden van gebouwde websites',
            'intro'   => 'Deze websites staan live en tonen wat een lokale zaak van Van Malder Studio mag verwachten: van een ambachtelijk bedrijf tot een installateur met eigen beheeromgeving.',
            'clients' => [
                'schrijnwerkerij-van-kerkhoven' => 'Lokale schrijnwerkerij: diensten, gerealiseerde projecten en een eenvoudige offerteflow.',
                'mastechnics'                   => 'HVAC- en sanitairbedrijf: meertalige website met slimme aanvraagformulieren en eigen beheeromgeving.',
            ],
        ],
        'honest_note'      => 'Een website legt de basis voor online zichtbaarheid. Of klanten je ook effectief vinden, hangt af van je sector, je inhoud en hoe je website technisch in orde is. Ik leg die basis correct.',
        'faq'              => [
            ['q' => 'Werk je enkel in Overijse?', 'a' => 'Nee — ik werk voor heel de Druivenstreek en Vlaams-Brabant. Overijse ligt vlak naast mijn thuisbasis in Tervuren, dus persoonlijk afspreken is hier eenvoudig.'],
            ['q' => 'Wat kost een website laten maken in Overijse?', 'a' => 'Een professionele starterswebsite begint vanaf €750. De prijs hangt af van het aantal pagina\'s, functies zoals reservaties of een menukaart, en de inhoud. Na een kennismakingsgesprek krijg je een concreet voorstel.'],
            ['q' => 'Kan mijn website ook reservaties of bestellingen ontvangen?', 'a' => 'Ja, dat is mogelijk. We bespreken op voorhand welke functionaliteiten je nodig hebt — zo kies je de juiste aanpak en prijs.'],
            ['q' => 'Hoe lang duurt het?', 'a' => 'Gemiddeld 2 tot 6 weken, afhankelijk van de scope en hoe snel teksten en foto\'s aangeleverd worden.'],
            ['q' => 'Wat maakt jou anders dan een groter agency?', 'a' => 'Persoonlijk contact. Je werkt met mij, niet met een account manager. Korte lijnen, snelle reacties, eerlijke communicatie.'],
        ],
        'related'          => ['website-laten-maken-tervuren', 'website-laten-maken-hoeilaart', 'website-laten-maken-huldenberg'],
        'cta_text'         => 'Bespreek je website',
        'noindex'          => false,
        'sitemap_priority' => '0.9',
    ],

    // ─── 10. Website laten maken — Huldenberg ────────────────────────────────
    [
        'slug'             => 'website-laten-maken-huldenberg',
        'locale'           => 'nl',
        'meta_title'       => 'Website laten maken Huldenberg | Van Malder Studio',
        'meta_description' => 'Webdeveloper actief in Huldenberg en omgeving. Professionele websites voor zelfstandigen en lokale bedrijven in Huldenberg, Neerijse, Ottenburg en omgeving.',
        'h1'               => 'Website laten maken in Huldenberg en omgeving',
        'intro'            => 'Huldenberg is een landelijke gemeente op de grens van de Druivenstreek — met agrarische activiteit, dienstverlenende zelfstandigen en kleinschalige ondernemers in een hechte gemeenschap. Of je in Huldenberg, Neerijse, Ottenburg, Loonbeek of Sint-Agatha-Rode actief bent: een professionele website geeft je zaak geloofwaardigheid online en maakt dat klanten je gemakkelijker vinden. Ik bouw wat je nodig hebt — zonder poespas, met oog voor detail.',
        'service_type'     => 'website',
        'location'         => 'Huldenberg',
        'who_for'          => 'Voor zelfstandigen, handwerkers en lokale bedrijven in Huldenberg, Neerijse, Ottenburg, Loonbeek en Sint-Agatha-Rode.',
        'bullets'          => [
            'Lokale aanwezigheid in de Druivenstreek en Huldenberg',
            'Responsive website met goede mobiele weergave',
            'SEO-basis voor lokale zoekopdrachten in de regio',
            'Duidelijke contactflow — makkelijk bereikbaar voor je klanten',
            'Persoonlijk contact — je praat rechtstreeks met de developer',
            'Onderhoud en opvolging mogelijk na lancering',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken wie je bent, wat je aanbiedt en wie je klanten zijn.'],
            ['title' => 'Voorstel op maat', 'body' => 'Concreet plan met scope, prijs en planning — duidelijk en transparant.'],
            ['title' => 'Bouw', 'body' => 'Ik bouw de website en hou je op de hoogte van de voortgang.'],
            ['title' => 'Lancering', 'body' => 'We gaan live en daarna ben ik bereikbaar voor opvolging en onderhoud.'],
        ],
        'honest_note'      => 'Een goed ingestelde website is een fundament voor online zichtbaarheid. Garanties op Google-rankings zijn niet eerlijk te geven. Wat ik wél beloof: een technisch correcte, goed gestructureerde site die zoekmachines de juiste signalen geeft.',
        'faq'              => [
            ['q' => 'Werk je ook voor heel kleine bedrijven?', 'a' => 'Absoluut. Ik werk graag met zelfstandigen en kleine lokale ondernemers. De schaal van het project bepaalt de aanpak en de prijs.'],
            ['q' => 'Moet ik naar jou toe komen voor een gesprek?', 'a' => 'Nee, alles kan digitaal. Persoonlijk afspreken in de streek is ook mogelijk.'],
            ['q' => 'Hoe snel kan ik een website online hebben?', 'a' => 'Afhankelijk van de scope en je beschikbaarheid voor feedback: 2 tot 6 weken is realistisch.'],
        ],
        'related'          => ['website-laten-maken-bertem', 'website-laten-maken-overijse', 'website-laten-maken-tervuren'],
        'cta_text'         => 'Neem contact op',
        'noindex'          => false,
        'sitemap_priority' => '0.9',
    ],

    // ─── 11. Website laten maken — Hoeilaart ─────────────────────────────────
    [
        'slug'             => 'website-laten-maken-hoeilaart',
        'locale'           => 'nl',
        'meta_title'       => 'Website laten maken Hoeilaart | Van Malder Studio',
        'meta_description' => 'Webdeveloper actief in Hoeilaart en Druivenstreek. Professionele websites voor horeca, wellness en lokale bedrijven in Hoeilaart en omgeving.',
        'h1'               => 'Website laten maken in Hoeilaart',
        'intro'            => 'Hoeilaart ligt op de grens van het Zoniënwoud en de Druivenstreek — een gemeente waar toerisme, horeca, wellness en lokale ambachten samenkomen. Of je nu een restaurant uitbaat, een yogastudio hebt, als kinesist werkt of als zelfstandige actief bent in de buurt: een sterke website is je digitale uithangbord. Ik bouw websites die passen bij jouw zaak en klanten — met aandacht voor lokale context en een solide technische basis.',
        'service_type'     => 'website',
        'location'         => 'Hoeilaart / Druivenstreek',
        'who_for'          => 'Voor horeca, wellness-praktijken, zorgverleners en zelfstandigen in Hoeilaart, Overijse, Tervuren en de ruimere Druivenstreek.',
        'bullets'          => [
            'Kennis van de Druivenstreek en de lokale context',
            'Responsive website die bezoekers aanspreekt op mobiel',
            'Duidelijke presentatie van je aanbod, openingsuren en contact',
            'SEO-basis voor lokale zoekopdrachten',
            'Persoonlijk contact — je werkt rechtstreeks met de developer',
            'Onderhoud en updates na lancering mogelijk',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken je zaak, je sector en je online doelen.'],
            ['title' => 'Voorstel', 'body' => 'Je krijgt een concreet plan met prijs en timing — op maat van jouw noden.'],
            ['title' => 'Bouw', 'body' => 'Ik bouw de site en hou je op de hoogte van elke stap.'],
            ['title' => 'Lancering', 'body' => 'Online gaan en nadien beschikbaar voor opvolging en aanpassingen.'],
        ],
        'honest_note'      => null,
        'faq'              => [
            ['q' => 'Kan mijn website ook werken voor reservaties of afspraken?', 'a' => 'Ja, een afspraken­module of reservatieformulier is zeker mogelijk. We bespreken wat het beste past bij jouw situatie.'],
            ['q' => 'Werk je ook voor toeristische activiteiten of evenementen?', 'a' => 'Ja. Een site voor een B&B, restaurant, activiteit of lokale attractie heeft een andere aanpak dan een gewone bedrijfssite. Dat bespreken we samen.'],
            ['q' => 'Zijn er extra kosten na de lancering?', 'a' => 'Optioneel: je kunt een onderhoudspakket nemen. Dat is niet verplicht maar handig als je weinig tijd hebt voor technische updates.'],
        ],
        'related'          => ['website-laten-maken-overijse', 'website-laten-maken-tervuren', 'website-laten-maken-duisburg'],
        'cta_text'         => 'Neem contact op',
        'noindex'          => false,
        'sitemap_priority' => '0.9',
    ],

    // ─── 12. Website laten maken — Bertem ────────────────────────────────────
    [
        'slug'             => 'website-laten-maken-bertem',
        'locale'           => 'nl',
        'meta_title'       => 'Website laten maken Bertem | Van Malder Studio',
        'meta_description' => 'Webdeveloper actief in Bertem, Leefdaal en Korbeek-Dijle. Professionele websites voor zelfstandigen en lokale bedrijven tussen Tervuren en Leuven.',
        'h1'               => 'Website laten maken in Bertem',
        'intro'            => 'Bertem ligt tussen Tervuren en Leuven, met Leefdaal en Korbeek-Dijle als landelijke deelgemeenten in de Dijlevallei. Dat is een bijzondere positie: veel ondernemers hier bedienen zowel de dorpskernen als klanten uit Leuven. Een website die enkel "Bertem" zegt, laat de helft van die markt liggen — en een website die enkel op Leuven mikt, verliest de nabijheid die je lokaal net sterk maakt. Ik bouw sites die dat evenwicht respecteren: verankerd in je gemeente, maar zichtbaar in de bredere regio.',
        'service_type'     => 'website',
        'location'         => 'Bertem',
        'who_for'          => 'Voor zelfstandigen, zorgverleners, bouw- en tuinondernemingen en lokale zaken in Bertem, Leefdaal en Korbeek-Dijle.',
        'bullets'          => [
            'Website die zowel je gemeente als de regio Leuven aanspreekt',
            'Responsive design met sterke mobiele weergave',
            'SEO-basis voor lokale zoekopdrachten in Bertem en omgeving',
            'Duidelijke contactflow — afspraak, offerte of telefoon',
            'Persoonlijk contact — je werkt rechtstreeks met de developer',
            'Onderhoud en opvolging mogelijk na lancering',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken je zaak, je werkgebied en waar je klanten vandaan komen. In de streek of via video.'],
            ['title' => 'Voorstel op maat', 'body' => 'Een concreet plan met scope, prijs en planning — helder en zonder verrassingen.'],
            ['title' => 'Bouw', 'body' => 'Ik bouw de website en hou je op de hoogte van de voortgang.'],
            ['title' => 'Lancering', 'body' => 'We gaan live en daarna blijf ik bereikbaar voor vragen en aanpassingen.'],
        ],
        'honest_note'      => 'Wie in Bertem werkt maar ook op Leuven mikt, concurreert daar met een grotere markt. Ik zorg dat je website technisch en inhoudelijk klopt voor beide. Welke zoekopdrachten je effectief wint, hangt af van je sector en de concurrentie — garanties op posities geef ik niet.',
        'faq'              => [
            ['q' => 'Kan mijn website zowel op Bertem als op Leuven mikken?', 'a' => 'Ja. We bepalen samen welke gemeenten en diensten er inhoudelijk in je site verwerkt worden, zodat je zichtbaar bent in je eigen gemeente én in de bredere regio zonder geforceerde herhaling van plaatsnamen.'],
            ['q' => 'Werk je ook voor zaken in Leefdaal of Korbeek-Dijle?', 'a' => 'Zeker. De deelgemeenten horen bij mijn werkgebied — ik kom vanuit Tervuren in een kwartier ter plaatse.'],
            ['q' => 'Wat kost een website voor een kleine zaak in Bertem?', 'a' => 'Een starterspakket begint vanaf €750. De prijs hangt af van het aantal pagina\'s, de gewenste functies en hoeveel inhoud er verwerkt moet worden. Na een gesprek krijg je een concreet voorstel.'],
        ],
        'related'          => ['website-laten-maken-huldenberg', 'website-laten-maken-tervuren', 'website-laten-maken-leuven'],
        'cta_text'         => 'Neem contact op',
        'noindex'          => false,
        'sitemap_priority' => '0.9',
    ],

    // ─── 13. Website laten maken — Vlaams-Brabant (samengevoegd) ─────────────
    // Zelfde zoekintentie als /nl/webdesigner-vlaams-brabant: één regionale pagina.
    // Deze slug blijft bestaan als 301 zodat bestaande links en rankings meegaan.
    [
        'slug'        => 'website-laten-maken-vlaams-brabant',
        'locale'      => 'nl',
        'redirect_to' => 'webdesigner-vlaams-brabant',
    ],

    // ─── 14. Website laten maken — Leuven (hoogste prioriteit in Search Console) ─
    // Primaire pagina voor: website laten maken (in) Leuven, website maken Leuven,
    // webdesigner / webdesign / webbureau Leuven, drupal website laten maken Leuven.
    [
        'slug'             => 'website-laten-maken-leuven',
        'locale'           => 'nl',
        'meta_title'       => 'Website laten maken in Leuven | Van Malder Studio',
        'meta_description' => 'Professionele website voor zelfstandigen en kmo\'s in Leuven, gebouwd door Xander Van Malder uit Tervuren. Echte klantprojecten, maatwerk mogelijk, vanaf €750.',
        'h1'               => 'Website laten maken in Leuven',
        'intro'            => 'Van Malder Studio ontwerpt en bouwt professionele websites voor zelfstandigen, vrije beroepen en kmo\'s in Leuven en omgeving. Ik ben Xander Van Malder, webdesigner en full stack developer uit Tervuren, op twintig minuten van Leuven. Je krijgt een responsive website die vindbaar is in Google en bezoekers naar contact leidt — en waar het nuttig is ook de functionaliteit erachter: een offerteformulier met opvolging, een eigen beheeromgeving of een koppeling met de tools die je al gebruikt.',
        'service_type'     => 'website',
        'location'         => 'Leuven / Vlaams-Brabant',
        'who_for'          => 'Voor zelfstandigen, vrije beroepen, consultants, praktijken en kmo\'s in Leuven, Heverlee, Kessel-Lo, Wilsele en Wijgmaal, en in omliggende gemeenten zoals Herent, Bertem en Haasrode.',
        'bullets'          => [
            'Professionele website, ontworpen én gebouwd door dezelfde developer',
            'Responsive design dat werkt op smartphone, tablet en desktop',
            'SEO-basis voor zoekopdrachten in Leuven en omgeving',
            'Duidelijke contactflow: bezoekers weten meteen hoe ze je bereiken',
            'Maatwerk waar nodig: aanvraagflow, beheeromgeving, webshop of integratie',
            'Starterspakket vanaf €750 — concreet voorstel na gesprek, alle richtprijzen op de prijzenpagina',
            'Onderhoud en opvolging na lancering, vanaf €50/maand',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken jouw zaak, jouw doelgroep en wat je website moet overbrengen. Via video of op locatie in Leuven.'],
            ['title' => 'Voorstel op maat', 'body' => 'Je krijgt een concreet plan met scope, aanpak, prijs en timing — transparant, zonder kleine lettertjes.'],
            ['title' => 'Ontwerp en bouw', 'body' => 'Ik ontwerp en bouw de website. Je wordt op de hoogte gehouden en hebt inspraak in elke stap.'],
            ['title' => 'Lancering', 'body' => 'We gaan live. Daarna ben ik bereikbaar voor vragen, aanpassingen en eventueel onderhoud.'],
        ],
        'why_local'        => [
            ['title' => 'Dichtbij, zonder kantoor in Leuven', 'body' => 'Van Malder Studio is gevestigd in Tervuren. Leuven ligt op twintig minuten: afspreken bij jou op de zaak of ergens in de stad is geen probleem, en het meeste verloopt vlot via video.'],
            ['title' => 'Meer dan een brochure als je zaak dat vraagt', 'body' => 'Voor Mastechnics bouwde ik een meertalige website met slimme aanvraagformulieren en een eigen beheeromgeving voor de opvolging van klanten. Dezelfde aanpak past bij een praktijk, een aannemer of een groeiende kmo in Leuven.'],
            ['title' => 'Geen templates, geen tussenpersonen', 'body' => 'Elk project start vanuit jouw aanbod en jouw klanten, niet vanuit een kant-en-klaar thema. Je praat rechtstreeks met de persoon die ontwerpt en bouwt.'],
            ['title' => 'Transparante richtprijzen', 'body' => 'Starter vanaf €750, professionele website vanaf €1.250, onderhoud vanaf €50 per maand — dezelfde richtprijzen als op de prijzenpagina. Na een kennismaking krijg je een voorstel met scope, prijs en timing — zonder verborgen kosten.'],
        ],
        'proof'            => [
            'heading' => 'Gebouwd voor echte bedrijven',
            'intro'   => 'Elke website hieronder staat live en werd ontworpen en ontwikkeld door Van Malder Studio. Bekijk ze gerust: zo zie je wat een zelfstandige of kmo in Leuven mag verwachten.',
            'clients' => [
                'mastechnics'                   => 'HVAC-bedrijf: meertalige website, slimme aanvraagflow en eigen beheeromgeving voor klantopvolging.',
                'dr-sue-liza-eta'               => 'Medische praktijk: website gericht op vertrouwen en online afspraken.',
                'schrijnwerkerij-van-kerkhoven' => 'Schrijnwerkerij: website met projectoverzicht en lokale SEO-structuur.',
            ],
        ],
        'honest_note'      => 'Leuven is een competitieve regio voor veel sectoren. Een kwalitatieve website vergroot je geloofwaardigheid en legt een solide basis voor online zichtbaarheid. Rankings kan ik niet garanderen — dat is simpelweg niet eerlijk te beloven.',
        'faq'              => [
            ['q' => 'Werk je ook voor bedrijven in Leuven?', 'a' => 'Ja. Ik ben gevestigd in Tervuren, op 20 minuten van Leuven, en werk voor klanten in Leuven, Heverlee, Kessel-Lo en heel Vlaams-Brabant. Afspreken in Leuven is geen probleem; een kantoor in Leuven zelf heb ik niet.'],
            ['q' => 'Wat kost een website laten maken in Leuven?', 'a' => 'Een starterswebsite begint vanaf €750, een professionele website vanaf €1.250. De prijs hangt af van het aantal pagina\'s, talen, formulieren en functies. Na een kennismakingsgesprek krijg je een concreet voorstel.'],
            ['q' => 'Hoe lang duurt het om een website te bouwen?', 'a' => 'Gemiddeld 2 tot 6 weken, afhankelijk van de scope en hoe snel inhoud en feedback aangeleverd worden.'],
            ['q' => 'Kan mijn bestaande website vernieuwd worden?', 'a' => 'Ja. Ik analyseer eerst je huidige website — structuur, snelheid, mobiele ervaring, contactflow en SEO — en bespreek daarna eerlijk of een volledige vernieuwing of gerichte aanpassingen het meeste opleveren.'],
            ['q' => 'Bouw je ook webshops of een eigen beheeromgeving?', 'a' => 'Ja. Een productcatalogus of webshop, een offerteformulier met opvolging, een eigen beheeromgeving of een koppeling met je agenda, nieuwsbrief of CRM: dat bouw ik zelf, met Laravel of .NET afhankelijk van het project. Een website kan later uitgebreid worden.'],
            ['q' => 'Bouw je ook Drupal-websites?', 'a' => 'Ik heb ervaring met Drupal en kan een bestaande Drupal-website onderhouden, uitbreiden of vernieuwen. Voor nieuwe websites werk ik meestal met Laravel, omdat dat voor een zelfstandige of kmo sneller, lichter en eenvoudiger te onderhouden is. Heb je specifiek een Drupal-project? Bespreek het gerust — ik geef eerlijk advies over wat het beste past.'],
            ['q' => 'Kan ik mijn website nadien zelf beheren?', 'a' => 'Dat bespreken we vooraf. Een eenvoudige beheeromgeving is mogelijk, zodat je teksten en afbeeldingen zelf kunt aanpassen. Of ik neem het onderhoud op mij — afhankelijk van jouw voorkeur.'],
        ],
        'related'          => ['website-laten-maken-tervuren', 'webdesigner-vlaams-brabant', 'website-vernieuwen'],
        'cta_text'         => 'Bespreek je website',
        'noindex'          => false,
        'sitemap_priority' => '0.9',
    ],

    // ─── 15. Webdesigner Tervuren (samengevoegd) ──────────────────────────────
    // Zelfde zoekintentie als /nl/website-laten-maken-tervuren: één lokale pagina.
    // Het ontwerp-gedeelte (designer én developer, huisstijl) zit nu in die pagina.
    [
        'slug'        => 'webdesigner-tervuren',
        'locale'      => 'nl',
        'redirect_to' => 'website-laten-maken-tervuren',
    ],

    // ─── 16. Webdesign in Vlaams-Brabant (regionale pagina) ──────────────────
    // Primaire pagina voor: webdesign Vlaams-Brabant, webdesigner Vlaams-Brabant,
    // website laten maken Vlaams-Brabant. Eén regionale positionering, geen stadspagina's.
    [
        'slug'             => 'webdesigner-vlaams-brabant',
        'locale'           => 'nl',
        'meta_title'       => 'Webdesign in Vlaams-Brabant | Van Malder Studio',
        'meta_description' => 'Webdesign en webdevelopment voor bedrijven en zelfstandigen in Vlaams-Brabant. Websites, webshops en maatwerk vanuit Tervuren — rechtstreeks met één developer.',
        'h1'               => 'Webdesign en webdevelopment in Vlaams-Brabant',
        'intro'            => 'Van Malder Studio ontwerpt en bouwt websites voor bedrijven en zelfstandigen in heel Vlaams-Brabant, vanuit Tervuren. In de Druivenstreek en Leuven spreek ik makkelijk persoonlijk af; in Zaventem, Asse, Aarschot, Tienen of elders in de provincie verloopt de samenwerking vlot digitaal. Het aanbod is overal hetzelfde: een professionele website als basis, en waar het nuttig is een webshop of catalogus, een eigen beheersysteem, integraties of automatisering erachter.',
        'service_type'     => 'website',
        'location'         => 'Vlaams-Brabant',
        'who_for'          => 'Voor zelfstandigen, vrije beroepen en kmo\'s in Vlaams-Brabant — van de Druivenstreek en Leuven tot Zaventem, Aarschot en Tienen.',
        'bullets'          => [
            'Professionele websites — het hoofdaanbod, responsive en met SEO-basis',
            'Webshops en productcatalogi voor wie online wil tonen of verkopen',
            'Maatwerk: beheersystemen, klantportalen en slimme aanvraagflows',
            'Integraties en automatisering met de tools die je al gebruikt',
            'Onderhoud en lokale SEO na de lancering',
            'Eén developer voor ontwerp, bouw en techniek — geen tussenpersonen',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken jouw bedrijf, je klanten en je verwachtingen. Digitaal of ergens in Vlaams-Brabant.'],
            ['title' => 'Voorstel op maat', 'body' => 'Je krijgt een concreet plan met scope, aanpak, prijs en timing. Transparant en zonder kleine lettertjes.'],
            ['title' => 'Ontwerp en bouw', 'body' => 'Ik ontwerp en bouw de website en hou je op de hoogte. Jij hebt inspraak in elke fase.'],
            ['title' => 'Lancering en opvolging', 'body' => 'We lanceren samen. Daarna ben ik bereikbaar voor vragen, aanpassingen en onderhoud.'],
        ],
        'why_local'        => [
            ['title' => 'Thuisbasis in Tervuren, actief in de hele provincie', 'body' => 'Geen kantoor in elke stad, wel korte lijnen: in de Druivenstreek en Leuven kom ik langs, verder weg werken we via video. Dat maakt geen verschil in kwaliteit of prijs.'],
            ['title' => 'Websites eerst, maatwerk als het nodig is', 'body' => 'De meeste klanten hebben vooral een sterke website nodig. Wie meer nodig heeft — een beheeromgeving, een koppeling, een intern tool — krijgt dat van dezelfde developer, zonder tweede leverancier.'],
            ['title' => 'Ervaring met Laravel en .NET', 'body' => 'Klantenwebsites bouw ik met Laravel; voor bedrijfsapplicaties en integraties werk ik ook met C# en .NET. Zo past de techniek bij het project, niet omgekeerd.'],
            ['title' => 'Transparante richtprijzen', 'body' => 'Starter vanaf €750, professionele website vanaf €1.250, onderhoud vanaf €50 per maand — dezelfde richtprijzen als op de prijzenpagina. Elk voorstel is op maat en zonder verborgen kosten.'],
        ],
        'proof'            => [
            'heading' => 'Gebouwd voor bedrijven in de regio',
            'intro'   => 'Drie websites die live staan, ontworpen en ontwikkeld door Van Malder Studio. Ze tonen de drie kanten van het aanbod: een sterke lokale website, een conversiegerichte site en een website met eigen beheersysteem.',
            'clients' => [
                'schrijnwerkerij-van-kerkhoven' => 'Schrijnwerkerij: website met projectoverzicht en lokale SEO-structuur.',
                'dr-sue-liza-eta'               => 'Medische praktijk: website gericht op vertrouwen en online afspraken.',
                'mastechnics'                   => 'HVAC-bedrijf: meertalige website, slimme aanvraagflow en eigen beheeromgeving.',
            ],
        ],
        'honest_note'      => 'Een website met correcte lokale informatie en een technische SEO-basis legt een solide fundament om gevonden te worden in Vlaams-Brabant. Garanties op specifieke rankings geef ik niet.',
        'faq'              => [
            ['q' => 'Werk je enkel voor kleine zaken?', 'a' => 'Nee — ik werk voor zelfstandigen, vrije beroepen, kmo\'s en bedrijven met specifieke digitale noden. De schaal van het project bepaalt de aanpak.'],
            ['q' => 'Moet ik naar Tervuren komen?', 'a' => 'Dat hoeft niet. De meeste trajecten verlopen digitaal, met een kennismakingsgesprek via video. Persoonlijk afspreken in de Druivenstreek, Leuven of elders in Vlaams-Brabant is uiteraard ook mogelijk.'],
            ['q' => 'Bouw je ook webshops?', 'a' => 'Ja. Van een eenvoudige productcatalogus tot een webshop met winkelmandje, betalingen en bestelopvolging. De scope bepaalt de aanpak en de prijs.'],
            ['q' => 'Kun je een eigen beheeromgeving of integratie bouwen?', 'a' => 'Ja. Voor Mastechnics bouwde ik een beheeromgeving waarin aanvragen en klanten opgevolgd worden. Koppelingen met een agenda, nieuwsbrief, Google Maps, WhatsApp of een CRM zijn mogelijk; de complexiteit bepaalt de prijs.'],
            ['q' => 'Wat kost een website met professioneel webdesign?', 'a' => 'Een starterspakket begint vanaf €750, een professionele website vanaf €1.250. De prijs hangt af van omvang, gewenste functies en aantal pagina\'s. Na een gesprek maak ik een concreet voorstel.'],
            ['q' => 'Heb je referentieprojecten?', 'a' => 'Ja. Bekijk de klantprojecten op deze website: elke site staat live, met een korte toelichting van wat er gebouwd is.'],
        ],
        'related'          => ['website-laten-maken-leuven', 'website-laten-maken-tervuren', 'website-laten-maken'],
        'cta_text'         => 'Bespreek je project',
        'noindex'          => false,
        'sitemap_priority' => '0.9',
    ],

];
