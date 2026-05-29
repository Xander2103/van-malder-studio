<?php

/**
 * SEO Landing Pages — config-driven, quality over quantity.
 *
 * Each page must have unique intro and content — not just city-name substitution.
 * Do not add pages without unique, useful copy.
 * Initial set: Dutch only. FR/EN versions should not be created until translated.
 *
 * Schema per page:
 *   slug           string   — URL path under /{locale}/
 *   locale         string   — nl | fr | en
 *   meta_title     string   — <title> tag (keep under 60 chars)
 *   meta_description string — meta description (150–160 chars)
 *   h1             string   — visible page heading
 *   intro          string   — unique opening paragraph
 *   service_type   string   — website | webshop | redesign | forms | maintenance | seo | apps
 *   location       string|null — city/region, or null for general service pages
 *   bullets        array    — "what is included" list
 *   who_for        string   — short "voor wie" sentence
 *   honest_note    string|null — honest SEO note (no guarantees)
 *   faq            array    — [[q, a], ...]
 *   related        array    — slugs of related landing pages
 *   cta_text       string   — CTA button label
 *   noindex        bool     — true = add noindex (use for stubs / untranslated)
 */

return [

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

    // ─── 2. Website laten maken — Tervuren / Druivenstreek ───────────────────
    [
        'slug'             => 'website-laten-maken-tervuren',
        'locale'           => 'nl',
        'meta_title'       => 'Website laten maken Tervuren & Druivenstreek | Van Malder Studio',
        'meta_description' => 'Lokale webdeveloper in Tervuren en de Druivenstreek. Professionele websites voor zelfstandigen en bedrijven in de buurt. Persoonlijk contact, kwalitatief maatwerk.',
        'h1'               => 'Website laten maken in Tervuren en de Druivenstreek',
        'intro'            => 'Als developer uit de Druivenstreek ken ik de lokale markt. Of je nu een tuinarchitect bent in Tervuren, een imker langs de Voer, een kinesist in Overijse of een aannemer in Huldenberg — ik bouw een website die past bij jouw zaak en jouw klanten. Korte lijnen, persoonlijk contact en een resultaat waar je iets aan hebt.',
        'service_type'     => 'website',
        'location'         => 'Tervuren / Druivenstreek',
        'who_for'          => 'Voor zelfstandigen en lokale bedrijven in Tervuren, Huldenberg, Overijse, Duisburg en de omliggende deelgemeenten.',
        'bullets'          => [
            'Persoonlijk contact — je praat rechtstreeks met de developer',
            'Lokale kennis van de Druivenstreek en omgeving',
            'Responsive website met SEO-basis',
            'Duidelijke contactflow voor lokale klanten',
            'Onderhoud mogelijk na lancering',
        ],
        'honest_note'      => 'Lokale relevantie in je website helpt zoekmachines begrijpen wie je bent en waar je actief bent. Ik bouw die structuur correct in. Garanties op rankings geef ik niet — dat is onmogelijk om eerlijk te beloven.',
        'faq'              => [
            ['q' => 'Werk je enkel in Tervuren?', 'a' => 'Nee — ik werk voor heel Vlaams-Brabant en ook daarbuiten. Tervuren en de Druivenstreek zijn mijn thuisbasis, maar ik werk even goed met klanten in Leuven, Brussel-rand of elders.'],
            ['q' => 'Kunnen we elkaar ontmoeten?', 'a' => 'Ja, dat is zeker mogelijk. Een kennismakingsgesprek in de buurt of via video — jij kiest.'],
        ],
        'related'          => ['website-laten-maken', 'website-laten-maken-vlaams-brabant'],
        'cta_text'         => 'Neem contact op',
        'noindex'          => false,
    ],

    // ─── 3. Website laten maken — Vlaams-Brabant ─────────────────────────────
    [
        'slug'             => 'website-laten-maken-vlaams-brabant',
        'locale'           => 'nl',
        'meta_title'       => 'Website laten maken in Vlaams-Brabant | Van Malder Studio',
        'meta_description' => 'Webdeveloper actief in heel Vlaams-Brabant. Professionele websites, webshops en digitale oplossingen voor zelfstandigen en kmo\'s in Leuven, Halle, Zaventem en omgeving.',
        'h1'               => 'Website laten maken in Vlaams-Brabant',
        'intro'            => 'Van Malder Studio werkt voor zelfstandigen en bedrijven door heel Vlaams-Brabant. Of je nu in Leuven, Halle, Zaventem, Asse of Tervuren gevestigd bent — ik bouw een professionele website die aansluit bij jouw sector en jouw klanten. Persoonlijk contact, eerlijke aanpak en een resultaat dat werkt.',
        'service_type'     => 'website',
        'location'         => 'Vlaams-Brabant',
        'who_for'          => 'Voor zelfstandigen en kmo\'s in Leuven, Halle-Vilvoorde, Aarschot, Diest, Tienen, Zaventem en de rest van Vlaams-Brabant.',
        'bullets'          => [
            'Actief in heel Vlaams-Brabant',
            'Responsive website met SEO-basis voor lokale zichtbaarheid',
            'Persoonlijk contact — geen agency-tussenpersonen',
            'Duidelijke aanpak van eerste gesprek tot lancering',
            'Onderhoud en opvolging na lancering mogelijk',
        ],
        'honest_note'      => 'Een website met correcte lokale informatie en technische SEO-basis legt een solide fundament. Dat vergroot je kansen om gevonden te worden, maar garanties op specifieke rankings zijn onmogelijk te geven.',
        'faq'              => [
            ['q' => 'Werk je enkel voor kleine zaken?', 'a' => 'Nee — ik werk voor zelfstandigen, vrije beroepen, kmo\'s en bedrijven met specifieke digitale noden. De schaal van het project bepaalt de aanpak.'],
            ['q' => 'Moet ik naar jou toe komen?', 'a' => 'Dat hoeft niet. De meeste trajecten verlopen digitaal, met een kennismakingsgesprek via video. Persoonlijk afspreken is uiteraard ook mogelijk.'],
        ],
        'related'          => ['website-laten-maken', 'website-laten-maken-tervuren', 'webshop-laten-maken'],
        'cta_text'         => 'Bespreek je project vrijblijvend',
        'noindex'          => false,
    ],

    // ─── 4. Webshop laten maken ───────────────────────────────────────────────
    [
        'slug'             => 'webshop-laten-maken',
        'locale'           => 'nl',
        'meta_title'       => 'Webshop laten maken | Van Malder Studio',
        'meta_description' => 'Een webshop laten maken voor je producten of diensten? Van Malder Studio bouwt productcatalogi en webshops op maat — van eenvoudig tot uitgebreid, met SEO-basis.',
        'h1'               => 'Webshop laten maken voor je producten',
        'intro'            => 'Wil je producten online tonen of verkopen? Dat hoeft niet groot of ingewikkeld te zijn. Ik bouw wat jij nodig hebt: een eenvoudige productcatalogus, een webshop met winkelmandje, of een uitgebreidere oplossing met betalingen en bestelopvolging. De scope bepaalt de prijs — en die bespreken we samen.',
        'service_type'     => 'webshop',
        'location'         => null,
        'who_for'          => 'Voor zelfstandigen en lokale bedrijven die producten online willen tonen of verkopen.',
        'bullets'          => [
            'Productcatalogus (tonen zonder verkoop): v.a. €950',
            'Eenvoudige webshop met winkelmandje: v.a. €1.500',
            'Betaalmogelijkheden afhankelijk van scope',
            'SEO-basis voor producten en categorieën inbegrepen',
            'Duidelijke productpagina\'s en bestelprocedure',
            'Prijs afhankelijk van producten, categorieën, talen en functies',
        ],
        'honest_note'      => 'Een webshop is niet zomaar een website met een bestelknop. De prijs en aanpak hangen af van wat je écht nodig hebt: aantallen, betalingen, verzending, beheer. Ik geef je een eerlijk voorstel op basis van jouw situatie.',
        'faq'              => [
            ['q' => 'Is een webshop duurder dan een website?', 'a' => 'Ja, in de meeste gevallen. Een webshop heeft extra functionaliteiten zoals productbeheer, winkelmandje en betalingen. De prijs hangt sterk af van de scope.'],
            ['q' => 'Welke betaaloplossingen zijn mogelijk?', 'a' => 'Dat bespreken we op basis van je noden. Veelgebruikte opties zijn Mollie, Stripe of PayPal. De keuze hangt af van je producten en budget.'],
            ['q' => 'Kan ik later producten zelf toevoegen?', 'a' => 'Ja. Ik kan een admin-omgeving voorzien waarmee je zelf producten, foto\'s en prijzen beheert.'],
        ],
        'related'          => ['website-laten-maken', 'website-laten-maken-vlaams-brabant'],
        'cta_text'         => 'Bespreek je webshop',
        'noindex'          => false,
    ],

    // ─── 5. Website vernieuwen ────────────────────────────────────────────────
    [
        'slug'             => 'website-vernieuwen',
        'locale'           => 'nl',
        'meta_title'       => 'Website vernieuwen | Van Malder Studio',
        'meta_description' => 'Je website is verouderd, traag of werkt slecht op mobiel? Ik verbouw je site met sterkere structuur, beter vertrouwen en een duidelijkere contactflow.',
        'h1'               => 'Je website vernieuwen',
        'intro'            => 'Een verouderde website wekt twijfel — bij bezoekers én bij Google. Trage laadtijd, slechte mobiele weergave, onduidelijke structuur of een uitstraling die niet meer past bij wie je bent: dat zijn allemaal redenen om je site te vernieuwen. Ik analyseer wat er beter kan en bouw een frissere versie die werkt op alle toestellen.',
        'service_type'     => 'redesign',
        'location'         => null,
        'who_for'          => 'Voor bedrijven en zelfstandigen met een verouderde, trage, onduidelijke of niet-mobielvriendelilke website.',
        'bullets'          => [
            'Analyse van de huidige situatie',
            'Sterkere structuur en verbeterde uitstraling',
            'Betere mobiele ervaring',
            'Verbeterd vertrouwen bij bezoekers',
            'Duidelijkere contactflow of call-to-action',
            'Behoud van wat al werkt, verbetering van de rest',
        ],
        'honest_note'      => null,
        'faq'              => [
            ['q' => 'Verlies ik mijn huidige URL\'s of SEO?', 'a' => 'Niet als we dat goed plannen. Bij een vernieuwing zorg ik voor correcte redirects zodat bestaande URL\'s doorverwijzen naar de nieuwe structuur.'],
            ['q' => 'Kan ik mijn bestaande inhoud bewaren?', 'a' => 'Ja, teksten en afbeeldingen die je wilt bewaren kunnen overgenomen worden in de nieuwe versie.'],
        ],
        'related'          => ['website-laten-maken', 'website-laten-maken-vlaams-brabant'],
        'cta_text'         => 'Bespreek de vernieuwing',
        'noindex'          => false,
    ],

    // ─── 6. Offerteformulier laten maken ─────────────────────────────────────
    [
        'slug'             => 'offerteformulier-laten-maken',
        'locale'           => 'nl',
        'meta_title'       => 'Offerteformulier laten maken | Van Malder Studio',
        'meta_description' => 'Een offerteformulier laten maken dat de juiste vragen stelt? Van Malder Studio bouwt formulieren op maat voor aannemers, dienstverleners en kmo\'s.',
        'h1'               => 'Offerteformulier laten maken',
        'intro'            => 'Niet elk contactformulier hoeft "naam, e-mail, bericht" te zijn. Een goed offerteformulier stelt de juiste vragen, zodat aanvragen meteen duidelijker zijn — voor jou én voor de klant. Ik bouw formulieren op maat: van een eenvoudige aanvraagtool tot een meerstaps intake met samenvatting en validatie.',
        'service_type'     => 'forms',
        'location'         => null,
        'who_for'          => 'Voor aannemers, tuinaanleggers, dienstverleners, kmo\'s en iedereen die betere en duidelijkere aanvragen wil ontvangen via hun website.',
        'bullets'          => [
            'Offerteformulier of aanvraagtool op maat',
            'Meerstapsformulier met validatie en samenvatting',
            'Afspraakaanvraag, reservatie of intakeformulier',
            'GDPR-conform, spam-bestendig en veilig gebouwd',
            'Duidelijke bevestigingsmails voor klant en eigenaar',
        ],
        'honest_note'      => null,
        'faq'              => [
            ['q' => 'Kan het formulier gekoppeld worden aan mijn e-mail?', 'a' => 'Ja — je ontvangt een duidelijke bevestigingsmail bij elke aanvraag. Koppeling aan andere tools is mogelijk op aanvraag.'],
            ['q' => 'Wat kost een formulier op maat?', 'a' => 'Een formulier op maat start vanaf €100. De prijs hangt af van het aantal stappen, velden en de gewenste logica.'],
        ],
        'related'          => ['website-laten-maken', 'website-vernieuwen'],
        'cta_text'         => 'Bespreek je formulier',
        'noindex'          => false,
    ],

    // ─── 7. Website onderhoud ─────────────────────────────────────────────────
    [
        'slug'             => 'website-onderhoud',
        'locale'           => 'nl',
        'meta_title'       => 'Website onderhoud | Van Malder Studio',
        'meta_description' => 'Technisch onderhoud voor je website: updates, beveiligingscontroles, backups en kleine aanpassingen. Maandelijkse opvolging vanaf €50.',
        'h1'               => 'Website onderhoud en technische opvolging',
        'intro'            => 'Een website heeft onderhoud nodig. Beveiligingsupdates, technische fixes, kleine aanpassingen, backups — als je dat niet opvolgt, riskeert je site kwetsbaar te worden of te verouderen. Ik neem de technische opvolging op zodat jij je op je zaak kunt focussen.',
        'service_type'     => 'maintenance',
        'location'         => null,
        'who_for'          => 'Voor bedrijven en zelfstandigen met een bestaande website die gegarandeerd veilig, up-to-date en technisch in orde blijft.',
        'bullets'          => [
            'Maandelijkse updates en beveiligingschecks',
            'Kleine tekstuele of visuele aanpassingen',
            'Backups en monitoring',
            'Snelle reactie bij problemen',
            'Duidelijke afspraken — geen verborgen kosten',
            'Onderhoud vanaf €50/maand',
        ],
        'honest_note'      => null,
        'faq'              => [
            ['q' => 'Wat is inbegrepen in het onderhoudspakket?', 'a' => 'Updates, beveiligingscontroles, backups en kleine aanpassingen. Grotere wijzigingen worden apart besproken en gefactureerd.'],
            ['q' => 'Moet ik een lange termijn engageren?', 'a' => 'Nee. Ik werk op maandbasis, zonder lange contracten. Je kunt maandelijks opzeggen met een korte opzegtermijn.'],
        ],
        'related'          => ['website-laten-maken', 'website-vernieuwen'],
        'cta_text'         => 'Vraag onderhoud aan',
        'noindex'          => false,
    ],

];
