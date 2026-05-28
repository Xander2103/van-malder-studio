<x-layouts.app
    title="Over mij | Xander Van Malder — Full stack developer"
    description="Xander Van Malder is een full stack developer uit de Druivenstreek die professionele websites, webapplicaties en digitale oplossingen bouwt voor zelfstandigen en lokale bedrijven in Vlaams-Brabant."
    :canonical="route('about')"
    ogTitle="Over mij | Van Malder Studio"
>

    {{-- Header --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-16">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 lg:gap-16 items-start">

            {{-- Main text --}}
            <div class="lg:col-span-3 reveal">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    Over mij
                </p>
                <h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">Xander Van Malder</h1>
                <p class="mt-2 text-slate-500">Full stack developer · Druivenstreek, Vlaams-Brabant</p>

                <div class="mt-8 space-y-4 text-slate-600 leading-relaxed">
                    <p>
                        Ik bouw websites en webapplicaties voor zelfstandigen, lokale bedrijven en eigen projecten.
                        Mijn focus ligt op dingen die werken: duidelijk gebouwd, veilig, onderhoudbaar en passend bij wie de klant is.
                    </p>
                    <p>
                        Ik ben begonnen met game development en heb mijn weg gevonden naar full stack webdevelopment.
                        Dat geeft me een brede technische basis: van logica en datastructuren tot gebruikersinterface en productdenken.
                    </p>
                    <p>
                        Naast klantenwerk bouw ik eigen producten via <strong class="text-slate-800 font-medium">VM Studios</strong>:
                        apps, spellen en tools die ik van nul heb bedacht en zelf heb afgewerkt.
                        Dat leert me dingen die je niet leert door louter in opdracht te werken.
                    </p>
                    <p>
                        Ik werk liever aan minder projecten met meer aandacht dan aan veel projecten oppervlakkig.
                        Je werkt rechtstreeks met mij — geen account manager, geen uitbesteding.
                    </p>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                        Neem contact op
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('projects.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-white border border-stone-300 text-slate-700 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                        Bekijk projecten
                    </a>
                </div>
            </div>

            {{-- Sidebar cards --}}
            <div class="lg:col-span-2 space-y-4 reveal reveal-delay-1">

                {{-- Stack card --}}
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm">
                    <h2 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-5">Technologieën</h2>
                    <div class="space-y-4">
                        @foreach([
                            ['label' => 'Frontend',             'items' => ['HTML', 'CSS', 'JavaScript', 'Tailwind CSS', 'Bootstrap', 'React']],
                            ['label' => 'Backend & database',   'items' => ['PHP', 'Laravel', 'MySQL', 'SQL']],
                            ['label' => 'CMS & tools',          'items' => ['Drupal', 'Git', 'Vite']],
                            ['label' => 'Creative & 3D',        'items' => ['Unreal Engine', 'Blender', 'Substance Painter']],
                            ['label' => 'Mobile & games',       'items' => ['Flutter', 'Dart', 'Unity', 'C#']],
                        ] as $group)
                        <div>
                            <p class="text-[0.6rem] font-semibold text-stone-400 uppercase tracking-widest mb-1.5">{{ $group['label'] }}</p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($group['items'] as $tech)
                                <span class="text-xs font-medium px-2 py-0.5 bg-stone-100 border border-stone-200 text-slate-600 rounded-full">{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Focus areas --}}
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm">
                    <h2 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Focusgebieden</h2>
                    <ul class="space-y-2.5" role="list">
                        @foreach([
                            'Gebruiksvriendelijke interfaces',
                            'Veilige en onderhoudbare code',
                            'Duidelijke projectstructuur',
                            'Eerlijke communicatie',
                            'Projecten volledig afwerken',
                        ] as $focus)
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 shrink-0" aria-hidden="true"></span>
                            {{ $focus }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Own projects --}}
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm">
                    <h2 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Eigen projecten · VM Studios</h2>
                    <ul class="space-y-3.5" role="list">
                        @foreach($projects as $project)
                        <li>
                            <a href="{{ route('projects.index') }}#{{ $project['slug'] }}"
                               class="group flex items-start gap-3 cursor-pointer">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-slate-900 group-hover:text-blue-700 transition-colors duration-200">{{ $project['title'] }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $project['type'] }} · <span class="{{ $project['status'] === 'Afgewerkt' ? 'text-emerald-600' : 'text-slate-400' }}">{{ $project['status'] }}</span></p>
                                </div>
                                <svg class="mt-1 w-3.5 h-3.5 text-stone-300 group-hover:text-blue-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
