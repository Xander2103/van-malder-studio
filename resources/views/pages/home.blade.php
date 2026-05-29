<x-layouts.app
    title="Van Malder Studio | Websites by Xander Van Malder"
    description="Van Malder Studio bouwt professionele websites, webapplicaties en digitale oplossingen voor zelfstandigen en lokale bedrijven in de Druivenstreek en Vlaams-Brabant."
    :canonical="route('home')"
    ogTitle="Van Malder Studio | Websites by Xander Van Malder"
>

    {{-- ================================================================
         1. HERO — with interactive canvas wave background
         ================================================================ --}}
    <section class="hero-canvas-section pt-14 pb-20 md:pt-20 md:pb-28" aria-label="Introductie">
        {{-- Canvas: sine-wave lines, mouse-interactive --}}
        <canvas id="hero-bg-canvas" class="absolute inset-0 w-full h-full pointer-events-none" aria-hidden="true" style="z-index:0; opacity:1;"></canvas>

        <div class="max-w-6xl mx-auto px-6 relative" style="z-index:1;">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                {{-- Left: headline + CTA --}}
                <div class="reveal">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-5">
                        <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                        {{ config('studio.tagline') }}
                    </p>
                    <h1 class="font-serif text-4xl md:text-5xl lg:text-[3.2rem] font-medium text-slate-900 leading-[1.15] tracking-tight">
                        Professionele websites, apps en digitale oplossingen voor lokale ondernemers.
                    </h1>
                    <p class="mt-6 text-[1.0625rem] text-slate-500 leading-relaxed max-w-lg">
                        Ik ben <strong class="font-semibold text-slate-700">Xander Van Malder</strong>, full stack developer uit de Druivenstreek.
                        Ik bouw websites, webapplicaties en digitale tools voor zelfstandigen en lokale bedrijven —
                        met een focus op kwaliteit, SEO-basis en persoonlijke communicatie.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                            Bespreek je project
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="{{ route('services') }}"
                           class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-white text-slate-700 border border-stone-300 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                            Bekijk aanbod
                        </a>
                    </div>
                </div>

                {{-- Right: service card --}}
                <div class="reveal reveal-delay-1">
                    <div class="bg-white rounded-2xl border border-stone-200 shadow-md overflow-hidden">
                        <div class="studio-card-accent h-1 w-full" aria-hidden="true"></div>
                        <div class="p-7">
                            <div class="flex items-start justify-between mb-5">
                                <div>
                                    <p class="text-[0.65rem] font-semibold text-stone-400 uppercase tracking-widest mb-1">Web Studio</p>
                                    <h2 class="font-serif text-xl font-medium text-slate-900">Van Malder Studio</h2>
                                    <p class="text-sm text-slate-500 mt-0.5">Xander Van Malder · Vlaams-Brabant</p>
                                </div>
                                <span class="flex items-center gap-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse" aria-hidden="true"></span>
                                    Beschikbaar
                                </span>
                            </div>

                            <div class="space-y-2 mb-5">
                                @foreach([
                                    'Website laten maken',
                                    'Website vernieuwen',
                                    'Contact- en offerteformulieren',
                                    "Lokale SEO & landingspagina's",
                                    'Apps, tools & webapplicaties',
                                    'Onderhoud & opvolging',
                                ] as $item)
                                <div class="flex items-center gap-2.5 text-sm text-slate-700">
                                    <svg class="w-3.5 h-3.5 shrink-0 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ $item }}
                                </div>
                                @endforeach
                            </div>

                            <div class="pt-4 border-t border-stone-100">
                                <p class="text-xs text-slate-400">PHP · Laravel · JavaScript · Tailwind · SQL</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ================================================================
         2. TRUST STRIP
         ================================================================ --}}
    <section class="bg-white border-y border-stone-200" aria-label="Waarom Van Malder Studio">
        <div class="max-w-6xl mx-auto px-6 py-10">
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-px bg-stone-200 rounded-xl overflow-hidden">
                @foreach([
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                      'term' => 'Duidelijke websites',  'desc' => 'Structuur en inhoud afgestemd op je bezoeker'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>',
                      'term' => 'Maatwerk waar nodig',  'desc' => 'Geen onnodige functies, wel wat telt'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                      'term' => 'Veilig gebouwd',       'desc' => 'Beveiliging en onderhoudbaarheid van bij het begin'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                      'term' => 'Persoonlijk contact',  'desc' => 'Je praat rechtstreeks met de developer'],
                ] as $point)
                <div class="bg-white px-6 py-7 flex items-start gap-4">
                    <div class="shrink-0 w-9 h-9 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center" aria-hidden="true">
                        <svg class="w-4 h-4 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">{!! $point['icon'] !!}</svg>
                    </div>
                    <div>
                        <dt class="text-sm font-semibold text-slate-900">{{ $point['term'] }}</dt>
                        <dd class="mt-0.5 text-sm text-slate-500 leading-snug">{{ $point['desc'] }}</dd>
                    </div>
                </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- ================================================================
         3. BENTO OFFER GRID — 6 service cards
         ================================================================ --}}
    <section class="max-w-6xl mx-auto px-6 py-20" aria-labelledby="offer-heading">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-10 reveal">
            <div>
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    Wat ik voor je kan bouwen
                </p>
                <h2 id="offer-heading" class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">Aanbod</h2>
            </div>
            <a href="{{ route('services') }}"
               class="text-sm font-semibold text-blue-700 hover:text-blue-900 flex items-center gap-1.5 transition-colors duration-200 shrink-0 group">
                Alle diensten
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

            {{-- 1. Website laten maken — wide --}}
            <article class="bento-card md:col-span-2 bg-white rounded-xl border border-stone-200 p-7 flex flex-col reveal">
                <span class="text-[0.65rem] font-bold text-stone-300 tracking-widest mb-3">01</span>
                <h3 class="font-serif text-xl font-medium text-slate-900">Website laten maken</h3>
                <p class="mt-2 text-sm text-slate-500 leading-relaxed flex-1">
                    Voor zelfstandigen die professioneel online zichtbaar willen zijn.
                    Responsive, snel en SEO-vriendelijk — van landingspagina tot volledige bedrijfssite met een duidelijke contactflow.
                </p>
                <ul class="mt-4 space-y-1.5" role="list">
                    @foreach(['Responsive voor alle toestellen', 'SEO-vriendelijk', 'Duidelijke contactflow'] as $b)
                    <li class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="w-1 h-1 rounded-full bg-blue-500 shrink-0" aria-hidden="true"></span>{{ $b }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('services') }}#nieuwe-website"
                   class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 group cursor-pointer">
                    Meer info <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </article>

            {{-- 2. Website vernieuwen --}}
            <article class="bento-card bg-white rounded-xl border border-stone-200 p-7 flex flex-col reveal reveal-delay-1">
                <span class="text-[0.65rem] font-bold text-stone-300 tracking-widest mb-3">02</span>
                <h3 class="font-serif text-xl font-medium text-slate-900">Website vernieuwen</h3>
                <p class="mt-2 text-sm text-slate-500 leading-relaxed flex-1">
                    Voor bedrijven met een verouderde of onduidelijke website.
                    Sterkere structuur, beter vertrouwen, duidelijkere contactflow en betere mobiele ervaring.
                </p>
                <a href="{{ route('services') }}#website-vernieuwen"
                   class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 group cursor-pointer">
                    Meer info <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </article>

            {{-- 3. Contact- en offerteformulieren --}}
            <article class="bento-card bg-white rounded-xl border border-stone-200 p-7 flex flex-col reveal">
                <span class="text-[0.65rem] font-bold text-stone-300 tracking-widest mb-3">03</span>
                <h3 class="font-serif text-xl font-medium text-slate-900">Contact- en offerteformulieren</h3>
                <p class="mt-2 text-sm text-slate-500 leading-relaxed flex-1">
                    Voor duidelijke aanvragen met de juiste info vanaf het eerste contact.
                    Niet gewoon "naam, e-mail, bericht" — maar formulieren die de juiste vragen stellen.
                </p>
                <a href="{{ route('services') }}#formulieren"
                   class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 group cursor-pointer">
                    Meer info <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </article>

            {{-- 4. Lokale SEO — dark wide card --}}
            <article class="bento-card md:col-span-2 bg-slate-900 rounded-xl p-7 flex flex-col reveal reveal-delay-1" aria-label="Lokale SEO en landingspaginas">
                <span class="text-[0.65rem] font-bold text-slate-600 tracking-widest mb-3">SEO</span>
                <h3 class="font-serif text-xl font-medium text-white">Lokale SEO & landingspagina's</h3>
                <p class="mt-2 text-sm text-slate-400 leading-relaxed mb-5">
                    Voor betere vindbaarheid op diensten en regio's. Nuttige unieke inhoud met lokale relevantie —
                    geen spampagina's, geen garanties op rankings.
                </p>
                <ul class="space-y-2" role="list">
                    @foreach([
                        "Tuinaanleg in Tervuren, elektricien in Leuven, imkerij in de Druivenstreek",
                        "Landingspagina's voor specifieke diensten of regio's",
                        'Technische SEO-structuur inbegrepen bij elke website',
                        'Google Business Profile basischeck mogelijk',
                    ] as $point)
                    <li class="flex items-center gap-2.5 text-sm text-slate-300">
                        <svg class="w-3.5 h-3.5 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $point }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('services') }}#seo-landingspaginas"
                   class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-amber-400 hover:text-amber-300 transition-colors duration-200 group cursor-pointer">
                    Meer over lokale SEO <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </article>

            {{-- 5. Apps, tools & webapplicaties — wide on lg --}}
            <article class="bento-card lg:col-span-2 bg-white rounded-xl border border-stone-200 p-7 flex flex-col reveal reveal-delay-2">
                <span class="text-[0.65rem] font-bold text-stone-300 tracking-widest mb-3">04</span>
                <h3 class="font-serif text-xl font-medium text-slate-900">Apps, tools & webapplicaties</h3>
                <p class="mt-2 text-sm text-slate-500 leading-relaxed flex-1">
                    Voor ideeën die verder gaan dan een standaard website.
                    Formulieren, kleine dashboards, interne tools, klantportalen of andere digitale oplossingen — volledig op maat gebouwd.
                </p>
                <a href="{{ route('services') }}#webapplicatie"
                   class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 group cursor-pointer">
                    Meer info <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </article>

            {{-- 6. Onderhoud & opvolging --}}
            <article class="bento-card bg-stone-100 border border-stone-200 rounded-xl p-7 flex flex-col reveal reveal-delay-3">
                <span class="text-[0.65rem] font-bold text-stone-400 tracking-widest mb-3">05</span>
                <h3 class="font-serif text-lg font-medium text-slate-900">Onderhoud & opvolging</h3>
                <p class="text-sm text-slate-500 mt-2 leading-relaxed flex-1">
                    Voor updates, kleine aanpassingen, technische controle en veiligheid.
                    Backups, beveiligingschecks en monitoring — zodat je website veilig en up-to-date blijft.
                </p>
                <p class="text-xs font-semibold text-slate-700 mt-3">Vanaf €50/maand</p>
                <a href="{{ route('contact') }}"
                   class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-slate-700 hover:text-slate-900 transition-colors duration-200 group cursor-pointer">
                    Vraag onderhoud aan <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </article>

        </div>
    </section>

    {{-- ================================================================
         4. COMPARISON BLOCK
         ================================================================ --}}
    <section class="max-w-6xl mx-auto px-6 pb-20" aria-labelledby="compare-heading">
        <div class="reveal">
            <h2 id="compare-heading" class="font-serif text-2xl font-medium text-slate-900 mb-6">Zonder goede website vs. met een sterke online basis</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 reveal">
            {{-- Negatief --}}
            <div class="compare-neg border rounded-xl p-6">
                <h3 class="text-sm font-semibold text-red-700 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Zonder duidelijke website
                </h3>
                <ul class="space-y-3" role="list">
                    @foreach([
                        'Moeilijk te vinden in Google voor je regio of dienst',
                        'Slechte eerste indruk op potentiële klanten',
                        'Geen duidelijke manier om contact op te nemen',
                        'Bezoekers vertrekken snel zonder iets te doen',
                        'Twijfels over professionaliteit of betrouwbaarheid',
                    ] as $item)
                    <li class="flex items-start gap-2.5 text-sm text-red-800">
                        <svg class="mt-0.5 w-4 h-4 shrink-0 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                        </svg>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Positief --}}
            <div class="compare-pos border rounded-xl p-6">
                <h3 class="text-sm font-semibold text-green-700 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Met een sterke online aanwezigheid
                </h3>
                <ul class="space-y-3" role="list">
                    @foreach([
                        'Gevonden in Google voor je diensten en regio',
                        'Professionele eerste indruk die vertrouwen wekt',
                        'Duidelijk contactformulier of call-to-action',
                        'Bezoekers worden leads en klanten',
                        'Geloofwaardigheid en herkenbaarheid online',
                    ] as $item)
                    <li class="flex items-start gap-2.5 text-sm text-green-800">
                        <svg class="mt-0.5 w-4 h-4 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- ================================================================
         5. PROCESS
         ================================================================ --}}
    <section class="bg-stone-100 border-y border-stone-200" aria-labelledby="process-heading">
        <div class="max-w-6xl mx-auto px-6 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-14 items-start">
                <div class="lg:col-span-2 reveal">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                        <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                        Hoe ik werk
                    </p>
                    <h2 id="process-heading" class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">
                        Een helder traject van begin tot einde
                    </h2>
                    <p class="mt-4 text-slate-500 leading-relaxed">
                        Geen verrassingen halverwege. Stap voor stap, met heldere communicatie.
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('process') }}"
                           class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-white border border-stone-300 text-slate-700 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                            Volledige werkwijze
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-3 reveal reveal-delay-1">
                    <ol class="space-y-0" aria-label="Werkwijze stappen">
                        @foreach([
                            ['title' => 'Kennismaking',           'desc' => 'We bespreken je project, doelen en wat je verwacht.'],
                            ['title' => 'Voorstel en scope',      'desc' => 'Helder voorstel met aanpak en prijsindicatie, geen verrassingen.'],
                            ['title' => 'Ontwerp en structuur',   'desc' => 'Paginastructuur en visuele richting uitgewerkt vóór de bouw.'],
                            ['title' => 'Ontwikkeling',           'desc' => 'Ik bouw met aandacht voor kwaliteit, snelheid en veiligheid.'],
                            ['title' => 'Feedback en lancering',  'desc' => 'Je geeft feedback, we verfijnen en de website gaat live.'],
                        ] as $i => $step)
                        <li class="flex gap-5 {{ !$loop->last ? 'pb-7' : '' }}">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full {{ $i === 0 ? 'bg-slate-900 text-white' : 'bg-white border-2 border-stone-300 text-slate-500' }} text-xs font-bold flex items-center justify-center shrink-0">{{ $i + 1 }}</div>
                                @if(!$loop->last)<div class="w-px flex-1 bg-stone-200 mt-1" aria-hidden="true"></div>@endif
                            </div>
                            <div>
                                <h3 class="font-serif text-base font-medium text-slate-900 leading-snug">{{ $step['title'] }}</h3>
                                <p class="mt-1 text-sm text-slate-500 leading-relaxed">{{ $step['desc'] }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
         6. PRICING PREVIEW
         ================================================================ --}}
    <section class="max-w-6xl mx-auto px-6 py-20" aria-labelledby="pricing-heading">
        <div class="text-center mb-12 reveal">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                Tarieven
            </p>
            <h2 id="pricing-heading" class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">Wat kost het?</h2>
            <p class="mt-3 text-slate-500 max-w-lg mx-auto leading-relaxed">
                Richtprijzen. De uiteindelijke prijs hangt af van scope, talen, formulieren, integraties en functionaliteiten.
            </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach([
                ['title' => 'Starter',       'price' => 'Vanaf €750',    'desc' => 'Professionele website voor starters en kleine zaken.',            'highlighted' => false],
                ['title' => 'Professioneel', 'price' => 'Vanaf €1.250',  'desc' => 'Uitgebreidere website met meer pagina\'s en functionaliteiten.',  'highlighted' => true],
                ['title' => 'Maatwerk',      'price' => 'Vanaf €1.750',  'desc' => 'Apps, tools, webapplicaties en complexere oplossingen op maat.',  'highlighted' => false],
                ['title' => 'Onderhoud',     'price' => 'Vanaf €50/mnd', 'desc' => 'Maandelijkse updates, beveiliging en kleine aanpassingen.',       'highlighted' => false],
            ] as $plan)
            <div class="reveal">
                <x-pricing-card :title="$plan['title']" :price="$plan['price']" :description="$plan['desc']" :highlighted="$plan['highlighted']" />
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5 space-y-2">
            <p class="text-sm text-slate-400">Elke prijs is een indicatie. Na een gesprek maak ik een concreet voorstel op maat.</p>
            <a href="{{ route('pricing') }}" class="inline-flex items-center gap-1 text-sm font-medium text-blue-700 hover:text-blue-900 transition-colors duration-200">
                Zie uitgebreide prijspagina →
            </a>
        </div>
    </section>

    {{-- ================================================================
         7. COMPACT PROJECTS PROOF (secondary)
         ================================================================ --}}
    <section class="bg-slate-900 border-y border-slate-800" aria-labelledby="proof-heading">
        <div class="max-w-6xl mx-auto px-6 py-14">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8 reveal">
                <div>
                    <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-500 uppercase tracking-widest mb-2">
                        <span class="w-4 h-px bg-amber-500 inline-block" aria-hidden="true"></span>
                        Technische diepgang
                    </p>
                    <h2 id="proof-heading" class="font-serif text-2xl font-medium text-white leading-tight">
                        Eigen projecten als bewijs van technische diepgang
                    </h2>
                    <p class="mt-1 text-sm text-slate-400 max-w-lg">Eigen producten die tonen hoe ik denk over design, code en productafwerking.</p>
                </div>
                <a href="{{ route('about') }}#vm-studios"
                   class="text-sm font-semibold text-slate-300 hover:text-white flex items-center gap-1.5 transition-colors duration-200 shrink-0 group">
                    Meer details
                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                @foreach($projects as $i => $project)
                @php
                    $badgeClass = match($project['status']) {
                        'Live'   => 'bg-emerald-900/50 text-emerald-400 border border-emerald-700/40',
                        'Prototype' => 'bg-amber-900/50 text-amber-400 border border-amber-700/40',
                        default  => 'bg-slate-700/50 text-slate-500 border border-slate-600/40',
                    };
                @endphp
                <article class="bg-slate-800/60 border border-slate-700/60 rounded-xl p-4 hover:border-slate-600 hover:bg-slate-800 transition-all duration-200 reveal reveal-delay-{{ min($i + 1, 4) }}">
                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                        <span class="text-[0.6rem] font-semibold text-slate-500 uppercase tracking-wider">{{ $project['type'] }}</span>
                        <span class="text-[0.6rem] font-medium px-1.5 py-0.5 {{ $badgeClass }} rounded-full">{{ $project['status'] }}</span>
                    </div>
                    <h3 class="text-sm font-semibold text-white">{{ $project['title'] }}</h3>
                    <p class="mt-1 text-xs text-slate-400 leading-relaxed">{{ Str::limit($project['short'], 70) }}</p>
                    <div class="mt-3 flex flex-wrap gap-1">
                        @foreach(array_slice($project['technologies'], 0, 2) as $tech)
                        <span class="text-[0.6rem] px-1.5 py-0.5 bg-slate-700/50 text-slate-400 rounded border border-slate-600/30">{{ $tech }}</span>
                        @endforeach
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================================================================
         8. SHOWCASE TEASER
         ================================================================ --}}
    <section class="max-w-6xl mx-auto px-6 py-8">
        <div class="bg-stone-100 border border-stone-200 rounded-xl px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 reveal">
            <div>
                <p class="text-sm font-semibold text-slate-700">Zie hoe interactie een website sterker maakt</p>
                <p class="text-sm text-slate-500 mt-0.5">In de Showcase toon ik enkele interactieve details: van subtiele hero-beweging tot formulierfeedback en scroll-preview. Niet als gimmick, maar als manier om een website duidelijker en professioneler te maken.</p>
            </div>
            <a href="{{ route('showcase') }}"
               class="shrink-0 inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold bg-white border border-stone-300 text-slate-700 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                Bekijk showcase
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </section>

    {{-- ================================================================
         9. FINAL CTA
         ================================================================ --}}
    <section class="max-w-6xl mx-auto px-6 py-12 pb-20" aria-labelledby="cta-heading">
        <div class="relative bg-slate-900 rounded-2xl overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-900 to-blue-950 opacity-80" aria-hidden="true"></div>
            <div class="absolute top-0 left-0 right-0 h-px studio-card-accent" aria-hidden="true"></div>
            <div class="relative px-8 py-16 md:px-14 md:py-20 text-center">
                <h2 id="cta-heading" class="font-serif text-3xl md:text-4xl font-medium text-white leading-tight max-w-2xl mx-auto">
                    Wil je weten wat ik voor jouw website of idee kan betekenen?
                </h2>
                <p class="mt-4 text-slate-300 text-lg max-w-xl mx-auto leading-relaxed">
                    Vertel me over je project. Het eerste gesprek is vrijblijvend.
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold bg-white text-slate-900 rounded-lg hover:bg-blue-50 transition-colors duration-200 cursor-pointer shadow-sm">
                        Bespreek je project
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('services') }}"
                       class="inline-flex items-center px-6 py-3 text-sm font-semibold text-slate-300 border border-slate-700 rounded-lg hover:border-slate-500 hover:text-white transition-colors duration-200 cursor-pointer">
                        Bekijk aanbod
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
