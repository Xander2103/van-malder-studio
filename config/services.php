<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel'              => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Studio Services
    |--------------------------------------------------------------------------
    */

    'studio' => [
        [
            'slug'        => 'nieuwe-website',
            'title'       => 'Website laten maken',
            'short'       => 'Voor zelfstandigen die professioneel online zichtbaar willen zijn.',
            'description' => 'Een nieuwe website die past bij je zaak en doelgroep. Responsive, snel en SEO-vriendelijk gebouwd. Van een gerichte landingspagina tot een uitgebreide bedrijfssite — met een duidelijke contactflow die bezoekers omzet in klanten. Geen generieke templates, maar een doordachte structuur die aansluit bij wie je bent.',
            'bullets'     => [
                'Responsive design voor alle toestellen',
                'Snelle laadtijd en technische optimalisatie',
                'SEO-vriendelijke structuur inbegrepen',
                'Duidelijke contactflow voor bezoekers',
                'Van landingspagina tot volledige bedrijfssite',
            ],
            'cta'         => 'Bespreek je nieuwe website',
        ],
        [
            'slug'        => 'website-vernieuwen',
            'title'       => 'Website vernieuwen',
            'short'       => 'Voor bedrijven met een verouderde of onduidelijke website.',
            'description' => 'Je website is verouderd, traag, onduidelijk of werkt slecht op mobiel? Ik analyseer wat er beter kan en verbouw je site met een sterkere structuur, verbeterd vertrouwen bij bezoekers en een duidelijkere contactflow. Wat al werkt, bewaar ik — de rest verbeter ik.',
            'bullets'     => [
                'Sterkere structuur en uitstraling',
                'Verbeterd vertrouwen bij bezoekers',
                'Duidelijkere contactflow',
                'Betere mobiele ervaring',
                'Behoud van wat al werkt, verbetering van de rest',
            ],
            'cta'         => 'Bespreek de vernieuwing',
        ],
        [
            'slug'        => 'formulieren',
            'title'       => 'Contact- en offerteformulieren',
            'short'       => 'Voor duidelijke aanvragen met de juiste info vanaf het eerste contact.',
            'description' => 'Niet elk formulier hoeft "naam, e-mail, bericht" te zijn. Ik bouw formulieren die de juiste vragen stellen, zodat aanvragen meteen duidelijker zijn — voor jou én voor de bezoeker. Van een eenvoudig contactformulier tot een meerstaps offerteaanvraag.',
            'bullets'     => [
                'Offerteformulier op maat',
                'Afspraakaanvraag of reservatieformulier',
                'Intakeformulier of serviceaanvraag',
                'Meerstapsformulier met validatie en samenvatting',
                'Veilig, spam-bestendig en GDPR-conform gebouwd',
            ],
            'cta'         => 'Bespreek je formulier',
        ],
        [
            'slug'        => 'seo-landingspaginas',
            'title'       => "Lokale SEO & landingspagina's",
            'short'       => "Voor betere vindbaarheid op diensten en regio's.",
            'description' => "Voor bedrijven die gevonden willen worden op specifieke diensten of regio's. Denk aan tuinaanleg in Tervuren, elektricien in Leuven, imkerij in de Druivenstreek of website laten maken in Vlaams-Brabant. Nuttige unieke inhoud met lokale relevantie — geen spampagina's, geen garanties op rankings.",
            'bullets'     => [
                "Landingspagina's voor specifieke diensten of regio's",
                'Nuttige unieke inhoud per pagina',
                'Lokale relevantie voor Google',
                'Technische SEO-structuur inbegrepen',
                "Geen spampagina's — eerlijk en transparant",
            ],
            'cta'         => "Bespreek lokale SEO",
        ],
        [
            'slug'        => 'webapplicatie',
            'title'       => 'Apps, tools & webapplicaties',
            'short'       => "Voor ideeën die verder gaan dan een standaard website.",
            'description' => 'Heb je een idee voor een formulier-app, een klein dashboard, een intern tool, een klantportaal of een andere digitale oplossing? Ik denk mee over de structuur, de gebruikerservaring en de technische aanpak. Volledig op maat, veilig en onderhoudbaar.',
            'bullets'     => [
                'Formulieren en opvolgsystemen op maat',
                'Kleine dashboards of interne tools',
                'Klantportalen of reservatiesystemen',
                'Veilige dataopslag en logica',
                'Documentatie en overdracht',
            ],
            'cta'         => 'Vertel me over je idee',
        ],
        [
            'slug'        => 'onderhoud',
            'title'       => 'Onderhoud & opvolging',
            'short'       => 'Voor updates, kleine aanpassingen, technische controle en veiligheid.',
            'description' => 'Websites hebben onderhoud nodig: beveiligingsupdates, technische fixes, kleine aanpassingen en backups. Ik neem de technische opvolging over zodat jij je kan focussen op je zaak. Geen verrassingen, geen zware facturen per kleine aanpassing. Onderhoud vanaf €50/maand.',
            'bullets'     => [
                'Maandelijkse updates en beveiligingschecks',
                'Kleine tekstuele of visuele aanpassingen',
                'Backups en monitoring',
                'Snelle reactie bij problemen',
                'Duidelijke afspraken — geen verrassingen',
            ],
            'cta'         => 'Vraag onderhoud aan',
        ],
    ],

];
