<?php

/**
 * SEO Landing Pages — config-driven, quality over quantity.
 *
 * Each page must have unique intro and content — not just city-name substitution.
 * Do not add pages without unique, useful copy.
 * Initial set: Dutch only. FR/EN versions should not be created until translated.
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
 *   noindex          bool     — true = add noindex (use for stubs / untranslated)
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
        'related'          => ['website-laten-maken-tervuren', 'website-laten-maken-vlaams-brabant', 'website-vernieuwen'],
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
        'related'          => ['website-laten-maken', 'website-laten-maken-vlaams-brabant', 'website-onderhoud'],
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
        'related'          => ['website-laten-maken', 'offerteformulier-laten-maken', 'website-laten-maken-vlaams-brabant'],
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
        'related'          => ['website-laten-maken', 'website-laten-maken-tervuren', 'website-laten-maken-vlaams-brabant'],
        'cta_text'         => 'Bespreek je online zichtbaarheid',
        'noindex'          => false,
    ],

    // ═══════════════════════════════════════════════════════════════════════════
    // PHASE 2 — Local priority pages
    // ═══════════════════════════════════════════════════════════════════════════

    // ─── 7. Website laten maken — Tervuren / Druivenstreek ───────────────────
    [
        'slug'             => 'website-laten-maken-tervuren',
        'locale'           => 'nl',
        'meta_title'       => 'Website laten maken in Tervuren | Van Malder Studio',
        'meta_description' => 'Laat een professionele website maken door Xander Van Malder uit de Druivenstreek. Voor zelfstandigen en lokale bedrijven in Tervuren en Vlaams-Brabant. Vrijblijvende kennismaking.',
        'h1'               => 'Website laten maken in Tervuren',
        'intro'            => 'Ik ben Xander Van Malder — webdeveloper gevestigd in Duisburg, deelgemeente van Tervuren. Ik bouw professionele websites voor zelfstandigen en lokale bedrijven in de Druivenstreek en ruimer Vlaams-Brabant: van een kinesist in Vossem tot een aannemer in Moorsel, van een horecazaak in het centrum tot een vrij beroep aan de rand van de gemeente. Persoonlijk contact, een eerlijke aanpak en een website die iets oplevert.',
        'service_type'     => 'website',
        'location'         => 'Tervuren / Druivenstreek',
        'who_for'          => 'Voor zelfstandigen en lokale bedrijven in Tervuren, Vossem, Moorsel, Duisburg en de omliggende deelgemeenten van de Druivenstreek.',
        'bullets'          => [
            'Persoonlijk contact — je praat rechtstreeks met Xander',
            'Lokale kennis van Tervuren, Duisburg en de Druivenstreek',
            'Responsive website met SEO-basis voor lokale zoekopdrachten',
            'Duidelijke contactflow voor jouw doelgroep',
            'Snelle laadtijd op alle apparaten',
            'Starterspakket vanaf €750 — concreet voorstel na gesprek',
            'Onderhoud en opvolging mogelijk na lancering',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken jouw zaak, jouw klanten en wat je van je website verwacht. In de buurt of via video — jij kiest.'],
            ['title' => 'Voorstel op maat', 'body' => 'Je krijgt een concreet plan met scope, aanpak, prijs en timing. Duidelijk en zonder verborgen kosten.'],
            ['title' => 'Ontwerp en bouw', 'body' => 'Ik ontwerp en bouw de website. Je wordt op de hoogte gehouden en hebt inspraak in elke stap.'],
            ['title' => 'Lancering', 'body' => 'We lanceren samen en ik blijf bereikbaar voor vragen, aanpassingen en eventueel onderhoud.'],
        ],
        'why_local'        => [
            ['title' => 'Je werkt rechtstreeks met Xander', 'body' => 'Geen account manager, geen uitbesteding. Ik begeleid je project zelf van het eerste gesprek tot de lancering.'],
            ['title' => 'Ik ken de streek', 'body' => 'Als developer woonachtig in Duisburg (Tervuren) begrijp ik de lokale context — voor welke doelgroepen je werkt en hoe je die bereikt.'],
            ['title' => 'Kort op de bal', 'body' => 'Vragen, aanpassingen, problemen — ik reageer snel. Geen ticketsysteem, geen wachtrij. Je hebt altijd een aanspreekpunt.'],
            ['title' => 'Eerlijk en transparant', 'body' => 'Een helder voorstel met prijs en planning, geen verborgen kosten. En eerlijk advies, ook als een eenvoudigere oplossing beter past.'],
        ],
        'honest_note'      => 'Lokale relevantie in je website helpt zoekmachines begrijpen wie je bent en waar je actief bent. Ik bouw die structuur correct in. Garanties op rankings geef ik niet — dat is onmogelijk om eerlijk te beloven.',
        'faq'              => [
            ['q' => 'Wat kost een website laten maken in Tervuren?', 'a' => 'Een eenvoudige professionele website begint vanaf €750. De prijs hangt af van het aantal pagina\'s, gewenste functies en inhoud. Na een kennismakingsgesprek maak ik een concreet voorstel op maat.'],
            ['q' => 'Hoe lang duurt het om een website te laten maken?', 'a' => 'Gemiddeld 2 tot 6 weken, afhankelijk van de scope en hoe snel feedback en inhoud aangeleverd worden.'],
            ['q' => 'Kunnen we elkaar ontmoeten?', 'a' => 'Ja, zeker. Een kennismakingsgesprek in de buurt of via video — jij kiest wat het beste uitkomt.'],
            ['q' => 'Werk je enkel in Tervuren?', 'a' => 'Nee — ik werk voor heel Vlaams-Brabant en ook daarbuiten. Tervuren en de Druivenstreek zijn mijn thuisbasis, maar ik werk even goed met klanten in Leuven, Brussel-rand of elders.'],
            ['q' => 'Wat als ik al een verouderde website heb?', 'a' => 'Dan bespreken we of een volledige vernieuwing of gerichte aanpassingen de beste aanpak zijn. Ik analyseer eerlijk wat voor jou het meeste oplevert.'],
            ['q' => 'Kan ik de website nadien zelf aanpassen?', 'a' => 'Dat bespreken we op voorhand. Een eenvoudige admin-omgeving is mogelijk zodat je teksten en foto\'s zelf kunt beheren. Of ik neem het onderhoud op mij — afhankelijk van wat je verkiest.'],
        ],
        'related'          => ['website-laten-maken', 'website-laten-maken-vlaams-brabant', 'webdesigner-tervuren'],
        'cta_text'         => 'Gratis kennismaking aanvragen',
        'noindex'          => false,
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
        'related'          => ['website-laten-maken-tervuren', 'website-laten-maken-huldenberg', 'website-laten-maken'],
        'cta_text'         => 'Neem contact op',
        'noindex'          => false,
    ],

    // ─── 9. Website laten maken — Overijse / Druivenstreek ───────────────────
    [
        'slug'             => 'website-laten-maken-overijse',
        'locale'           => 'nl',
        'meta_title'       => 'Website laten maken Overijse | Van Malder Studio',
        'meta_description' => 'Webdeveloper actief in Overijse en de Druivenstreek. Professionele websites voor horeca, ambachtslieden en zelfstandigen in Overijse, Jezus-Eik en omgeving.',
        'h1'               => 'Website laten maken in Overijse en de Druivenstreek',
        'intro'            => 'Overijse is het hart van de Druivenstreek — een gemeente met een sterke lokale identiteit, actieve horeca en ambachtelijke ondernemers. Of je zaak nu in Overijse zelf ligt, in Jezus-Eik, Maleizen of Tombeek: klanten zoeken je online en een professionele website maakt dat eerste contact makkelijker. Ik bouw websites die passen bij de streek — persoonlijk, technisch sterk en met aandacht voor lokale context.',
        'service_type'     => 'website',
        'location'         => 'Overijse / Druivenstreek',
        'who_for'          => 'Voor horeca, zelfstandigen, ambachtslieden en lokale bedrijven in Overijse, Jezus-Eik, Maleizen, Tombeek en de Druivenstreek.',
        'bullets'          => [
            'Lokale kennis van de Druivenstreek en Overijse',
            'Responsive website met sterke mobiele weergave',
            'SEO-basis voor lokale zoekopdrachten in de regio',
            'Duidelijke contactflow — of een reservatiesysteem voor horeca',
            'Persoonlijk contact — je werkt rechtstreeks met de developer',
            'Onderhoud en opvolging mogelijk na lancering',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken je zaak, je klanten en je doelen. In de Druivenstreek of via video.'],
            ['title' => 'Voorstel', 'body' => 'Je krijgt een duidelijk plan met scope, prijs en planning.'],
            ['title' => 'Bouw', 'body' => 'Ik bouw de website en hou je op de hoogte van elke stap.'],
            ['title' => 'Lancering en opvolging', 'body' => 'We gaan live en ik blijf bereikbaar voor verdere opvolging.'],
        ],
        'honest_note'      => 'Een website legt de basis voor online zichtbaarheid. Of klanten je ook effectief vinden, hangt af van je sector, je inhoud en hoe je website technisch in orde is. Ik leg die basis correct.',
        'faq'              => [
            ['q' => 'Werk je enkel in Overijse?', 'a' => 'Nee — ik werk voor heel de Druivenstreek en Vlaams-Brabant. Overijse en omgeving is een regio waar ik graag voor werk.'],
            ['q' => 'Kan mijn website ook reservaties of bestellingen ontvangen?', 'a' => 'Ja, dat is mogelijk. We bespreken op voorhand welke functionaliteiten je nodig hebt — zo kies je de juiste aanpak en prijs.'],
            ['q' => 'Wat maakt jou anders dan een groter agency?', 'a' => 'Persoonlijk contact. Je werkt met mij, niet met een account manager. Korte lijnen, snelle reacties, eerlijke communicatie.'],
        ],
        'related'          => ['website-laten-maken-tervuren', 'website-laten-maken-huldenberg', 'website-laten-maken'],
        'cta_text'         => 'Neem contact op',
        'noindex'          => false,
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
        'related'          => ['website-laten-maken-tervuren', 'website-laten-maken-overijse', 'website-laten-maken'],
        'cta_text'         => 'Neem contact op',
        'noindex'          => false,
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
        'related'          => ['website-laten-maken-tervuren', 'website-laten-maken-overijse', 'website-laten-maken'],
        'cta_text'         => 'Neem contact op',
        'noindex'          => false,
    ],

    // ─── 12. Website laten maken — Vlaams-Brabant ────────────────────────────
    [
        'slug'             => 'website-laten-maken-vlaams-brabant',
        'locale'           => 'nl',
        'meta_title'       => 'Website laten maken Vlaams-Brabant | Van Malder Studio',
        'meta_description' => 'Webdeveloper actief in heel Vlaams-Brabant. Professionele websites, webshops en digitale oplossingen voor zelfstandigen en kmo\'s in Leuven, Halle, Zaventem en omgeving.',
        'h1'               => 'Website laten maken in Vlaams-Brabant',
        'intro'            => 'Van Malder Studio werkt voor zelfstandigen en bedrijven door heel Vlaams-Brabant. Of je nu in Leuven, Halle, Zaventem, Asse, Tervuren, Overijse of Huldenberg gevestigd bent — ik bouw een professionele website die aansluit bij jouw sector en jouw klanten. Persoonlijk contact, eerlijke aanpak en een resultaat dat werkt.',
        'service_type'     => 'website',
        'location'         => 'Vlaams-Brabant',
        'who_for'          => 'Voor zelfstandigen en kmo\'s in Leuven, Halle-Vilvoorde, Aarschot, Diest, Tienen, Zaventem, Bertem en de rest van Vlaams-Brabant.',
        'bullets'          => [
            'Actief in heel Vlaams-Brabant — geen afstandstoeslag',
            'Responsive website met SEO-basis voor lokale zichtbaarheid',
            'Persoonlijk contact — geen agency-tussenpersonen',
            'Duidelijke aanpak van eerste gesprek tot lancering',
            'Webshops, formulieren en maatwerkapplicaties mogelijk',
            'Onderhoud en opvolging na lancering mogelijk',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken jouw zaak, doelgroep en verwachtingen. Digitaal of persoonlijk in Vlaams-Brabant.'],
            ['title' => 'Voorstel op maat', 'body' => 'Je krijgt een concreet plan met scope, aanpak, prijs en timing. Transparant en zonder kleine lettertjes.'],
            ['title' => 'Ontwerp en bouw', 'body' => 'Ik bouw de website en hou je op de hoogte. Jij hebt inspraak in elke fase.'],
            ['title' => 'Lancering en opvolging', 'body' => 'We lanceren samen. Daarna ben ik bereikbaar voor vragen, aanpassingen en onderhoud.'],
        ],
        'honest_note'      => 'Een website met correcte lokale informatie en technische SEO-basis legt een solide fundament. Dat vergroot je kansen om gevonden te worden, maar garanties op specifieke rankings zijn onmogelijk te geven.',
        'faq'              => [
            ['q' => 'Werk je enkel voor kleine zaken?', 'a' => 'Nee — ik werk voor zelfstandigen, vrije beroepen, kmo\'s en bedrijven met specifieke digitale noden. De schaal van het project bepaalt de aanpak.'],
            ['q' => 'Moet ik naar jou toe komen?', 'a' => 'Dat hoeft niet. De meeste trajecten verlopen digitaal, met een kennismakingsgesprek via video. Persoonlijk afspreken in Vlaams-Brabant is uiteraard ook mogelijk.'],
            ['q' => 'Maak je ook websites voor specifieke sectoren?', 'a' => 'Ja — horeca, bouwbedrijven, zorgverleners, vrije beroepen, winkels. De inhoud en structuur passen we aan op je sector.'],
        ],
        'related'          => ['website-laten-maken', 'website-laten-maken-tervuren', 'webdesigner-vlaams-brabant'],
        'cta_text'         => 'Bespreek je project vrijblijvend',
        'noindex'          => false,
    ],

    // ─── 13. Webdesigner Tervuren ─────────────────────────────────────────────
    [
        'slug'             => 'webdesigner-tervuren',
        'locale'           => 'nl',
        'meta_title'       => 'Webdesigner in Tervuren en Druivenstreek | Van Malder Studio',
        'meta_description' => 'Op zoek naar een webdesigner in Tervuren? Xander Van Malder is webdesigner en developer in de Druivenstreek. Professioneel ontwerp en persoonlijk contact.',
        'h1'               => 'Webdesigner in Tervuren en de Druivenstreek',
        'intro'            => 'Op zoek naar een webdesigner in Tervuren of de Druivenstreek? Ik ben Xander Van Malder — webdesigner en full stack developer gevestigd in de regio. Ik ontwerp en bouw websites die er professioneel uitzien, snel laden en bezoekers omzetten naar klanten. Geen generieke templates of kant-en-klare thema\'s, maar een ontwerp dat specifiek past bij jouw zaak, jouw sector en jouw doelgroep.',
        'service_type'     => 'website',
        'location'         => 'Tervuren / Druivenstreek',
        'who_for'          => 'Voor zelfstandigen en bedrijven in Tervuren, Duisburg, Vossem, Moorsel en de Druivenstreek die een sterk ontwerp zoeken voor hun website.',
        'bullets'          => [
            'Doordacht ontwerp — geen templates, maar maatwerk',
            'Responsive design voor smartphone, tablet en desktop',
            'Goede balans tussen uitstraling en gebruiksgemak',
            'Snelle laadtijd en technisch correcte implementatie',
            'Persoonlijk contact in de Druivenstreek',
            'Van ontwerp tot lancering — alles onder één dak',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken jouw merk, je klanten en je verwachtingen van het ontwerp.'],
            ['title' => 'Ontwerpsuggestie', 'body' => 'Ik toon een eerste richting voor het design. We stemmen af en verfijnen.'],
            ['title' => 'Bouw', 'body' => 'Ik bouw de definitieve website en integreer alle inhoud en functies.'],
            ['title' => 'Lancering', 'body' => 'We gaan live, gecheckt op alle apparaten en schermformaten.'],
        ],
        'honest_note'      => 'Webdesign is méér dan kleur en typografie. Een goed design is pas goed als het ook bruikbaar is, snel laadt en de juiste boodschap overbrengt. Dat is wat ik nastreef.',
        'faq'              => [
            ['q' => 'Wat is het verschil tussen een webdesigner en een webdeveloper?', 'a' => 'Een webdesigner richt zich op de visuele kant — look and feel, layout, typografie. Een webdeveloper bouwt de technische kant. Ik doe allebei: ontwerpen én bouwen, wat zorgt voor een consistenter eindresultaat.'],
            ['q' => 'Gebruik je templates of werk je volledig op maat?', 'a' => 'Ik werk met kwalitatieve basistechnologieën en geen generieke kant-en-klare templates. Elk project start vanuit jouw specifieke noden en uitstraling.'],
            ['q' => 'Kan ik mijn bestaande branding meenemen?', 'a' => 'Ja. Als je al een logo of huisstijl hebt, bouw ik daar op verder. Heb je nog niets? Dan bespreken we samen wat past bij jouw zaak.'],
        ],
        'related'          => ['website-laten-maken-tervuren', 'webdesigner-vlaams-brabant', 'website-laten-maken'],
        'cta_text'         => 'Bespreek je websiteontwerp',
        'noindex'          => false,
    ],

    // ─── 14. Webdesigner Vlaams-Brabant ──────────────────────────────────────
    [
        'slug'             => 'webdesigner-vlaams-brabant',
        'locale'           => 'nl',
        'meta_title'       => 'Webdesigner in Vlaams-Brabant | Van Malder Studio',
        'meta_description' => 'Webdesigner actief in heel Vlaams-Brabant. Van Malder Studio ontwerpt en bouwt professionele websites voor zelfstandigen en kmo\'s in Leuven, Tervuren, Halle en omgeving.',
        'h1'               => 'Webdesigner in Vlaams-Brabant',
        'intro'            => 'Van Malder Studio is webdesigner en full stack developer actief in heel Vlaams-Brabant. Of je nu in Leuven, Tervuren, Overijse, Halle, Zaventem, Bertem of een andere gemeente in de provincie gevestigd bent: ik ontwerp en bouw websites die passen bij jouw merk en doelgroep. Geen kant-en-klare thema\'s, maar een doordacht ontwerp van A tot Z — met een technische basis die ook werkt.',
        'service_type'     => 'website',
        'location'         => 'Vlaams-Brabant',
        'who_for'          => 'Voor zelfstandigen, vrije beroepen en kmo\'s in Leuven, Tervuren, Halle, Zaventem, Overijse, Huldenberg, Bertem en heel Vlaams-Brabant.',
        'bullets'          => [
            'Professioneel ontwerp — geen templates, maar maatwerk',
            'Responsive en mobile-first van de eerste schets af',
            'Snelle laadtijd en solide technische basis',
            'SEO-basis inbegrepen in elk ontwerp',
            'Persoonlijk contact — geen tussenkomst van account managers',
            'Van eerste ontwerp tot lancering — alles in eigen handen',
        ],
        'steps'            => [
            ['title' => 'Kennismakingsgesprek', 'body' => 'We bespreken jouw bedrijf, je klanten en je verwachtingen van het ontwerp. Digitaal of ergens in Vlaams-Brabant.'],
            ['title' => 'Ontwerpsuggestie', 'body' => 'Ik presenteer een eerste richting en we verfijnen samen tot het klopt.'],
            ['title' => 'Bouw', 'body' => 'De definitieve website wordt gebouwd — met alle gewenste functies en inhoud.'],
            ['title' => 'Lancering', 'body' => 'Online gaan, gecheckt op alle schermformaten. Daarna bereikbaar voor opvolging.'],
        ],
        'honest_note'      => null,
        'faq'              => [
            ['q' => 'Werk je enkel voor kleine bedrijven?', 'a' => 'Nee — ik werk voor zelfstandigen, vrije beroepen en grotere kmo\'s. Het budget en de scope worden op maat bepaald na een kennismakingsgesprek.'],
            ['q' => 'Wat kost een website met professioneel webdesign?', 'a' => 'Een starterspakket begint vanaf €750. Prijs hangt af van omvang, gewenste functies en aantal pagina\'s. Na een gesprek maak ik een concreet voorstel.'],
            ['q' => 'Heb je referentieprojecten?', 'a' => 'Ja, ik toon graag wat ik al gebouwd heb. Neem contact op voor meer info of bekijk de showcase op mijn website.'],
        ],
        'related'          => ['webdesigner-tervuren', 'website-laten-maken-vlaams-brabant', 'website-laten-maken'],
        'cta_text'         => 'Bespreek je websiteontwerp',
        'noindex'          => false,
    ],

];
