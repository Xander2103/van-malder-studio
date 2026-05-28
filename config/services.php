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
            'short'       => 'Een nieuwe website van nul, afgestemd op je zaak en doelgroep.',
            'description' => 'Heb je nog geen website, of is je huidige site niet meer representatief? Ik bouw een nieuwe website die past bij wie je bent en wat je doet. Geen kant-en-klaar template dat eruitziet als duizend andere sites, maar een doordachte structuur met een ontwerp dat aansluit bij jouw zaak.',
            'bullets'     => [
                'Persoonlijk overleg over je doelen en doelgroep',
                'Responsive en mobiel geoptimaliseerd',
                'SEO-vriendelijke structuur',
                'Veilig en onderhoudbaar gebouwd',
                'Contactformulier of andere integraties',
            ],
            'cta'         => 'Bespreek je nieuwe website',
        ],
        [
            'slug'        => 'website-vernieuwen',
            'title'       => 'Website vernieuwen',
            'short'       => 'Je huidige website is verouderd of werkt niet meer goed. Tijd voor een upgrade.',
            'description' => 'Je hebt al een website, maar die is ondertussen verouderd, traag of past gewoon niet meer bij je zaak. Ik analyseer wat er beter kan en bouw een frissere versie die werkt op alle toestellen en een betere indruk achterlaat.',
            'bullets'     => [
                'Analyse van de huidige situatie',
                'Modern en overzichtelijk herontwerp',
                'Betere laadsnelheid en prestaties',
                'Behoud van wat al werkt, verbetering van de rest',
                'Migratie van bestaande inhoud indien gewenst',
            ],
            'cta'         => 'Bespreek de vernieuwing',
        ],
        [
            'slug'        => 'webapplicatie',
            'title'       => 'Webapplicatie of dashboard',
            'short'       => 'Een op maat gebouwde webapplicatie of intern tool voor jouw specifieke noden.',
            'description' => 'Soms volstaat een eenvoudige website niet. Als je een intern tool, een klantportaal, een reservatiesysteem of een andere specifieke oplossing nodig hebt, kan ik dat bouwen. Ik denk mee over de structuur, de gebruikerservaring en de technische aanpak.',
            'bullets'     => [
                'Analyse van je vereisten en workflows',
                'Technische architectuur op maat',
                'Gebruiksvriendelijke interface',
                'Veilige data-opslag en logica',
                'Documentatie en overdracht',
            ],
            'cta'         => 'Vertel me over je idee',
        ],
        [
            'slug'        => 'onderhoud',
            'title'       => 'Onderhoud en technische opvolging',
            'short'       => 'Je website blijft veilig, up-to-date en technisch in orde zonder dat je er zelf naar moet omkijken.',
            'description' => 'Websites hebben onderhoud nodig: beveiligingsupdates, technische fixes, kleine aanpassingen. Ik neem de technische opvolging over zodat jij je kan focussen op je zaak. Geen verrassingen, geen zware facturen per kleine aanpassing.',
            'bullets'     => [
                'Maandelijkse updates en beveiligingschecks',
                'Kleine tekstuele of visuele aanpassingen',
                'Monitoring en snelle reactie bij problemen',
                'Duidelijke maandelijkse rapportage',
            ],
            'cta'         => 'Vraag onderhoud aan',
        ],
    ],

];
