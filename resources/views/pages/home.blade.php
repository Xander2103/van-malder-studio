<x-layouts.app
    title="Van Malder Studio | Websites by Xander Van Malder"
    description="Van Malder Studio bouwt professionele websites, webapplicaties en digitale oplossingen voor zelfstandigen en lokale bedrijven in de Druivenstreek en Vlaams-Brabant."
    :canonical="route('home')"
    ogTitle="Van Malder Studio | Websites by Xander Van Malder"
>

    {{-- ====================================================================
         HERO
         ==================================================================== --}}
    <section class="max-w-6xl mx-auto px-6 pt-14 pb-20 md:pt-20 md:pb-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

            {{-- Left: text --}}
            <div class="reveal">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-5">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    {{ config('studio.tagline') }}
                </p>
                <h1 class="font-serif text-4xl md:text-5xl lg:text-[3.2rem] font-medium text-slate-900 leading-[1.15] tracking-tight">
                    Professionele websites die vertrouwen uitstralen
                </h1>
                <p class="mt-6 text-[1.0625rem] text-slate-500 leading-relaxed max-w-lg">
                    Ik ben <strong class="font-semibold text-slate-700">Xander Van Malder</strong>, full stack developer uit de Druivenstreek.
                    Ik bouw websites, webapplicaties en digitale oplossingen voor zelfstandigen en lokale bedrijven —
                    met een focus op kwaliteit, veiligheid en duidelijke communicatie.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                        Bespreek je project
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('projects.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-white text-slate-700 border border-stone-300 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                        Bekijk projecten
                    </a>
                </div>
            </div>

            {{-- Right: Studio card --}}
            <div class="reveal reveal-delay-1">
                <div class="bg-white rounded-2xl border border-stone-200 shadow-md overflow-hidden">
                    {{-- Top accent bar --}}
                    <div class="studio-card-accent h-1 w-full" aria-hidden="true"></div>

                    <div class="p-7">
                        {{-- Header --}}
                        <div class="flex items-start justify-between mb-6">
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

                        {{-- Services list --}}
                        <div class="mb-6 space-y-2.5">
                            @foreach([
                                ['label' => 'Professionele websites',         'desc' => 'Van visitekaartje tot volledige site'],
                                ['label' => 'Webapplicaties op maat',         'desc' => 'Dashboards, portalen, tools'],
                                ['label' => 'Digitale oplossingen',           'desc' => 'Maatwerk voor specifieke noden'],
                            ] as $item)
                            <div class="flex items-center gap-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-700 shrink-0 mt-0.5" aria-hidden="true"></span>
                                <div>
                                    <span class="text-sm font-medium text-slate-800">{{ $item['label'] }}</span>
                                    <span class="text-xs text-slate-400 ml-1.5">{{ $item['desc'] }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Divider --}}
                        <div class="section-divider mb-5" aria-hidden="true"></div>

                        {{-- VM Studios projects --}}
                        <div>
                            <p class="text-[0.65rem] font-semibold text-stone-400 uppercase tracking-widest mb-3">Eigen projecten · VM Studios</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="text-xs font-medium px-2.5 py-1 bg-red-50 text-red-800 border border-red-100 rounded-full">Killer Darts</span>
                                <span class="text-xs font-medium px-2.5 py-1 bg-teal-50 text-teal-800 border border-teal-100 rounded-full">Smart Card Mat</span>
                                <span class="text-xs font-medium px-2.5 py-1 bg-amber-50 text-amber-800 border border-amber-100 rounded-full">Chains of Glory</span>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="mt-6 pt-5 border-t border-stone-100 flex items-center justify-between">
                            <div class="flex items-center gap-1 text-xs text-slate-400 flex-wrap">
                                <span>PHP · Laravel · JavaScript · Tailwind · React · SQL</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ====================================================================
         TRUST STRIP
         ==================================================================== --}}
    <section class="bg-white border-y border-stone-200" aria-label="Waarom Van Malder Studio">
        <div class="max-w-6xl mx-auto px-6 py-10">
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-px bg-stone-200 rounded-xl overflow-hidden">
                @foreach([
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                        'term' => 'Duidelijke websites',
                        'desc' => 'Structuur en inhoud afgestemd op je bezoeker',
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>',
                        'term' => 'Maatwerk waar nodig',
                        'desc' => 'Geen onnodige functies, wel wat telt',
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                        'term' => 'Veilig gebouwd',
                        'desc' => 'Beveiliging en onderhoudbaarheid van bij het begin',
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                        'term' => 'Persoonlijk contact',
                        'desc' => 'Je praat rechtstreeks met de developer',
                    ],
                ] as $point)
                <div class="bg-white px-6 py-7 flex items-start gap-4">
                    <div class="shrink-0 w-9 h-9 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center" aria-hidden="true">
                        <svg class="w-4.5 h-4.5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">{!! $point['icon'] !!}</svg>
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

    {{-- ====================================================================
         SERVICES
         ==================================================================== --}}
    <section class="max-w-6xl mx-auto px-6 py-20" aria-labelledby="services-heading">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
            <div class="reveal">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    Wat ik bouw
                </p>
                <h2 id="services-heading" class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">Diensten</h2>
                <p class="mt-3 text-slate-500 max-w-md leading-relaxed">
                    Van een eenvoudige website tot een op maat gebouwde webapplicatie.
                </p>
            </div>
            <a href="{{ route('services') }}"
               class="text-sm font-semibold text-blue-700 hover:text-blue-900 flex items-center gap-1.5 transition-colors duration-200 shrink-0 group">
                Alle diensten
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($services as $i => $service)
            <x-service-card :service="$service" :number="$i + 1" />
            @endforeach
        </div>
    </section>

    {{-- ====================================================================
         PROJECTS PREVIEW
         ==================================================================== --}}
    <section class="bg-slate-900 border-y border-slate-800" aria-labelledby="projects-heading">
        <div class="max-w-6xl mx-auto px-6 py-20">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
                <div class="reveal">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-500 uppercase tracking-widest mb-3">
                        <span class="w-4 h-px bg-amber-500 inline-block" aria-hidden="true"></span>
                        Eigen projecten
                    </p>
                    <h2 id="projects-heading" class="font-serif text-3xl md:text-4xl font-medium text-white leading-tight">Van VM Studios</h2>
                    <p class="mt-3 text-slate-400 max-w-lg leading-relaxed">
                        Geen klantenprojecten, geen schoolopdrachten. Eigen producten die ik van nul heb bedacht en gebouwd.
                        Ze tonen hoe ik denk over productontwerp, technische uitvoering en het afwerken van een idee.
                    </p>
                </div>
                <a href="{{ route('projects.index') }}"
                   class="text-sm font-semibold text-slate-300 hover:text-white flex items-center gap-1.5 transition-colors duration-200 shrink-0 group">
                    Alle projecten
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $i => $project)
                <div class="reveal reveal-delay-{{ $i + 1 }}">
                    <x-project-card :project="$project" />
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ====================================================================
         PROCESS PREVIEW
         ==================================================================== --}}
    <section class="max-w-6xl mx-auto px-6 py-20" aria-labelledby="process-heading">
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
                    Geen verrassingen halverwege. Ik werk stap voor stap, met heldere communicatie zodat je altijd weet waar je aan toe bent.
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
                        ['title' => 'Kennismaking',           'desc' => 'We bespreken je project, je doelen en wat je verwacht.'],
                        ['title' => 'Voorstel en scope',      'desc' => 'Een helder voorstel met aanpak en prijsindicatie zonder kleine lettertjes.'],
                        ['title' => 'Ontwerp en structuur',   'desc' => 'De paginastructuur en visuele richting worden uitgewerkt vóór de bouw.'],
                        ['title' => 'Ontwikkeling',           'desc' => 'Ik bouw met aandacht voor kwaliteit, snelheid en veiligheid.'],
                        ['title' => 'Feedback en lancering',  'desc' => 'Je geeft feedback, we verfijnen en de website gaat live.'],
                    ] as $i => $step)
                    <li class="flex gap-5 {{ !$loop->last ? 'pb-7' : '' }}">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full {{ $i === 0 ? 'bg-slate-900 text-white' : 'bg-white border-2 border-stone-300 text-slate-500' }} text-xs font-bold flex items-center justify-center shrink-0 z-10">
                                {{ $i + 1 }}
                            </div>
                            @if(!$loop->last)
                            <div class="w-px flex-1 bg-stone-200 mt-1" aria-hidden="true"></div>
                            @endif
                        </div>
                        <div class="{{ !$loop->last ? 'pb-2' : '' }}">
                            <h3 class="font-serif text-base font-medium text-slate-900 leading-snug">{{ $step['title'] }}</h3>
                            <p class="mt-1 text-sm text-slate-500 leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    </li>
                    @endforeach
                </ol>
            </div>

        </div>
    </section>

    {{-- ====================================================================
         PRICING PREVIEW
         ==================================================================== --}}
    <section class="bg-stone-100 border-y border-stone-200" aria-labelledby="pricing-heading">
        <div class="max-w-6xl mx-auto px-6 py-20">
            <div class="text-center mb-12 reveal">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    Tarieven
                </p>
                <h2 id="pricing-heading" class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">Wat kost het?</h2>
                <p class="mt-3 text-slate-500 max-w-lg mx-auto leading-relaxed">
                    Richtprijzen. De uiteindelijke prijs hangt af van scope en functionaliteiten.
                    Na een gesprek maak ik een concreet voorstel op maat.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach([
                    ['title' => 'Starter',       'price' => 'Vanaf €750',      'desc' => 'Professionele website voor starters en kleine zaken.', 'highlighted' => false],
                    ['title' => 'Professioneel', 'price' => 'Vanaf €1.250',    'desc' => 'Uitgebreidere website met meer pagina\'s en functionaliteiten.',   'highlighted' => true],
                    ['title' => 'Maatwerk',      'price' => 'Vanaf €1.750',    'desc' => 'Webapplicaties, dashboards en complexere oplossingen op maat.',     'highlighted' => false],
                    ['title' => 'Onderhoud',     'price' => 'Vanaf €50/mnd',   'desc' => 'Maandelijkse technische opvolging, updates en kleine aanpassingen.','highlighted' => false],
                ] as $plan)
                <div class="reveal">
                    <x-pricing-card
                        :title="$plan['title']"
                        :price="$plan['price']"
                        :description="$plan['desc']"
                        :highlighted="$plan['highlighted']"
                    />
                </div>
                @endforeach
            </div>
            <p class="mt-6 text-center text-sm text-slate-400">
                Elke prijs is een indicatie. Na een gesprek maak ik een concreet voorstel op maat.
            </p>
        </div>
    </section>

    {{-- ====================================================================
         FINAL CTA
         ==================================================================== --}}
    <section class="max-w-6xl mx-auto px-6 py-20" aria-labelledby="cta-heading">
        <div class="relative bg-slate-900 rounded-2xl overflow-hidden">
            {{-- subtle gradient accent --}}
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
                        Bekijk diensten
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
