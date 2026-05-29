<x-layouts.app
    title="Prijzen | Website laten maken vanaf €750"
    description="Richtprijzen voor websites, webapplicaties en onderhoud bij Van Malder Studio. Transparante startprijzen afhankelijk van scope, talen en functionaliteiten."
    :canonical="route('pricing')"
    ogTitle="Prijzen | Van Malder Studio"
>

    {{-- Header --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-12">
        <div class="reveal">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                Tarieven
            </p>
            <h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">Wat kost het?</h1>
            <p class="mt-4 text-lg text-slate-500 leading-relaxed max-w-2xl">
                Hieronder vind je richtprijzen. De uiteindelijke prijs hangt af van het aantal pagina's,
                de gewenste functionaliteiten en de complexiteit. Na een gesprek maak ik een concreet voorstel op maat.
            </p>
        </div>
    </section>

    {{-- Pricing cards --}}
    <section class="max-w-6xl mx-auto px-6 pb-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 reveal">
            <x-pricing-card
                title="Starter"
                price="Vanaf €750"
                description="Voor starters, zelfstandigen en kleine bedrijven die een professionele online aanwezigheid nodig hebben."
                :bullets="[
                    'Tot 5 pagina\'s',
                    'Responsive design',
                    'Contactformulier',
                    'Basisoptimalisatie voor zoekmachines',
                    '1 feedbackronde',
                ]"
                cta="Vraag een voorstel aan"
            />
            <x-pricing-card
                title="Professioneel"
                price="Vanaf €1.250"
                description="Voor bedrijven die een uitgebreidere website nodig hebben met meer pagina's en functionaliteiten."
                :highlighted="true"
                :bullets="[
                    'Tot 10 pagina\'s',
                    'Responsive en snel',
                    'Contactformulier met validatie',
                    'SEO-vriendelijke structuur',
                    '2 feedbackronden',
                    'Technische lanceringsondersteuning',
                ]"
                cta="Meest gekozen pakket"
            />
            <x-pricing-card
                title="Maatwerk"
                price="Vanaf €1.750"
                description="Webapplicaties, dashboards, klantportalen of andere specifieke digitale oplossingen op maat."
                :bullets="[
                    'Analyse en technische architectuur',
                    'Maatwerk logica en database',
                    'Gebruiksvriendelijke interface',
                    'Documentatie en overdracht',
                    'Prijs op basis van scope',
                ]"
                cta="Bespreek je project"
            />
            <x-pricing-card
                title="Onderhoud"
                price="Vanaf €50/mnd"
                description="Maandelijkse technische opvolging zodat je website veilig, up-to-date en goed blijft werken."
                :bullets="[
                    'Maandelijkse updates',
                    'Beveiligingscontroles',
                    'Kleine aanpassingen',
                    'Monitoring en snelle reactie',
                ]"
                cta="Vraag onderhoud aan"
            />
        </div>
        <p class="mt-5 text-center text-sm text-slate-400">
            Elke prijs is een indicatie. Na een gesprek maak ik een concreet voorstel op maat.
        </p>
    </section>

    {{-- What determines price --}}
    <section class="bg-stone-100 border-y border-stone-200" aria-labelledby="pricing-factors-heading">
        <div class="max-w-6xl mx-auto px-6 py-16 reveal">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
                <div>
                    <h2 id="pricing-factors-heading" class="font-serif text-2xl font-medium text-slate-900 mb-6">Wat bepaalt de prijs?</h2>
                    <ul class="space-y-3.5" role="list">
                        @foreach([
                            'Aantal pagina\'s en secties',
                            'Meertaligheid (NL, FR, EN, …)',
                            'Formulieren op maat (offerteformulier, reservatie, …)',
                            'Behoefte aan een adminomgeving of contentbeheer',
                            "Extra SEO-landingspagina's voor diensten of regio's",
                            'Specifieke integraties (reservaties, nieuwsbrief, CRM)',
                            'Complexiteit van het ontwerp en de functionaliteiten',
                            'Onderhoudsverwachtingen na lancering',
                        ] as $factor)
                        <li class="flex items-start gap-3 text-sm text-slate-600">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-amber-600 shrink-0" aria-hidden="true"></span>
                            {{ $factor }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-white rounded-xl border border-stone-200 p-7 shadow-sm">
                    <h3 class="font-serif text-lg font-medium text-slate-900 mb-3">Niet zeker over je budget?</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-5">
                        Geen probleem. Vertel me wat je nodig hebt en ik maak een voorstel dat past bij wat je wil bereiken.
                        Geen verborgen kosten en geen verrassingen achteraf.
                    </p>
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                        Vraag een vrijblijvend voorstel aan
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Optional add-ons --}}
    <section class="max-w-6xl mx-auto px-6 py-16" aria-labelledby="addons-heading">
        <div class="reveal mb-8">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                Extra
            </p>
            <h2 id="addons-heading" class="font-serif text-2xl font-medium text-slate-900 leading-tight">Optionele uitbreidingen</h2>
            <p class="mt-2 text-slate-500 max-w-xl leading-relaxed">Uitbreidingen die je website of project verder versterken. Prijzen zijn richtprijzen — de uiteindelijke kost hangt af van scope.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 reveal">

            @foreach([
                ['title' => "Extra SEO-landingspagina", 'price' => 'Vanaf €150/pagina', 'desc' => "Per pagina gericht op een specifieke dienst of regio, met nuttige unieke inhoud."],
                ['title' => 'Formulier op maat',         'price' => '€150 – €400',       'desc' => 'Offerteformulier, reservatieaanvraag, intake of meerstapsformulier met validatie.'],
                ['title' => 'Website audit',             'price' => 'Vanaf €150',         'desc' => 'Concreet advies over uitstraling, mobiel gebruik, snelheid, contactflow en SEO-basis. Korte check gratis bij kennismaking.'],
                ['title' => 'Google Business Profile basischeck', 'price' => '€75 – €150', 'desc' => 'Contactgegevens, openingsuren, diensten, websitekoppeling en basisadvies over reviews en foto\'s.'],
                ['title' => 'Extra taal',                'price' => 'Vanaf €250',         'desc' => 'Extra taalversie van je website met duidelijke taalstructuur. Prijs afhankelijk van aantal pagina\'s.'],
                ['title' => "SEO-structuur meerdere diensten/regio's", 'price' => 'Op aanvraag', 'desc' => "Uitgebreidere lokale SEO-aanpak met meerdere landingspagina's, structurele opbouw en contentstrategie."],
                ['title' => "Contentstructuur & tekstbegeleiding", 'price' => 'Op aanvraag', 'desc' => "Hulp bij het structureren van je aanbod en het schrijven van duidelijke websiteteksten."],
            ] as $addon)
            <div class="bg-white border border-stone-200 rounded-xl p-5 flex items-start gap-4">
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-semibold text-slate-900">{{ $addon['title'] }}</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $addon['desc'] }}</p>
                </div>
                <span class="text-xs font-medium text-blue-700 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full shrink-0 whitespace-nowrap">{{ $addon['price'] }}</span>
            </div>
            @endforeach

        </div>
        <p class="mt-6 text-sm text-slate-400 text-center">
            Alle prijzen zijn indicaties. Na een gesprek maak ik een concreet voorstel op maat.
        </p>
    </section>

</x-layouts.app>
