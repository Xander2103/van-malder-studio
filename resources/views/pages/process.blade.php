<x-layouts.app
    title="Werkwijze | Van Malder Studio"
    description="Hoe verloopt een websiteproject bij Van Malder Studio? Een helder, stap-voor-stap traject van eerste gesprek tot lancering en opvolging."
    :canonical="route('process')"
    ogTitle="Werkwijze | Van Malder Studio"
>

    {{-- Header --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-12">
        <div class="reveal">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                Hoe ik werk
            </p>
            <h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">Een duidelijk traject</h1>
            <p class="mt-4 text-lg text-slate-500 leading-relaxed max-w-2xl">
                Samenwerken met mij is rechttoe rechtaan. Geen vage beloftes, geen onverwachte wendingen —
                maar een gestructureerd traject met heldere communicatie op elk punt.
            </p>
        </div>
    </section>

    {{-- Steps + sidebar --}}
    <section class="max-w-6xl mx-auto px-6 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16 items-start">

            {{-- Steps --}}
            <div class="lg:col-span-2 reveal">
                @php
                $steps = [
                    [
                        'title' => 'Kennismaking',
                        'desc'  => 'We plannen een korte call of ontmoeting. Ik luister naar wat je wil bouwen, wie je doelgroep is en wat je verwacht. Geen pitch, gewoon een eerlijk gesprek. Je hoeft technisch niet onderlegd te zijn.',
                    ],
                    [
                        'title' => 'Scope en voorstel',
                        'desc'  => 'Na ons gesprek stel ik een helder voorstel op: wat ik bouw, hoe ik het aanpak en wat het kost. Geen verborgen kosten, geen vage schatting. Je weet op voorhand waar je aan toe bent.',
                    ],
                    [
                        'title' => 'Ontwerp en structuur',
                        'desc'  => 'Ik werk de paginastructuur en de visuele richting uit. Je geeft feedback vóór ik begin te bouwen, zodat we allebei op dezelfde lijn zitten.',
                    ],
                    [
                        'title' => 'Ontwikkeling',
                        'desc'  => 'Ik bouw de website of applicatie. Ik werk gestructureerd, schrijf leesbare code en let op veiligheid en snelheid. Tussendoor communiceer ik over de voortgang.',
                    ],
                    [
                        'title' => 'Feedbackronde',
                        'desc'  => 'Je bekijkt het resultaat en geeft feedback. We verfijnen samen totdat je tevreden bent.',
                    ],
                    [
                        'title' => 'Lancering',
                        'desc'  => 'De website gaat live. Ik help bij de technische setup: domein, hosting, e-mail. Jij focust op je zaak, ik zorg dat alles technisch in orde is.',
                    ],
                    [
                        'title' => 'Opvolging (optioneel)',
                        'desc'  => 'Na de lancering kan ik de technische opvolging op me nemen: updates, kleine aanpassingen, monitoring. Zo blijft je website veilig en up-to-date.',
                    ],
                ];
                @endphp
                <ol class="space-y-0" aria-label="Werkwijze stappen">
                    @foreach($steps as $i => $step)
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
            </div>

            {{-- Sidebar --}}
            <div class="space-y-5 lg:sticky lg:top-24 reveal reveal-delay-1">
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm">
                    <h2 class="font-serif text-base font-medium text-slate-900 mb-4">Wat je kan verwachten</h2>
                    <ul class="space-y-3" role="list">
                        @foreach([
                            'Duidelijke communicatie in elke fase',
                            'Geen verborgen kosten of verrassingen',
                            'Rechtstreeks contact met de developer',
                            'Leesbare, veilige en onderhoudbare code',
                            'Aandacht voor mobiel en toegankelijkheid',
                            'Een website die ook na lancering goed blijft werken',
                        ] as $point)
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
                    <h2 class="font-serif text-base font-medium text-slate-900 mb-2">Klaar om te starten?</h2>
                    <p class="text-sm text-slate-500 leading-relaxed mb-5">Vertel me over je project. Het eerste gesprek is vrijblijvend.</p>
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer">
                        Neem contact op
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
