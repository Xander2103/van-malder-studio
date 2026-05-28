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
                            'Meertaligheid (NL, FR, EN)',
                            'Behoefte aan een adminomgeving of contentbeheer',
                            'Specifieke integraties (reservaties, betaling, CRM)',
                            'Complexiteit van het ontwerp',
                            'Kopij en beeldmateriaal (aangeleverd of te voorzien)',
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

</x-layouts.app>
