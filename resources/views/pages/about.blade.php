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
                    <a href="{{ route('showcase') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-white border border-stone-300 text-slate-700 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                        Bekijk showcase
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

                {{-- Own projects compact links --}}
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm">
                    <h2 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Eigen projecten · VM Studios</h2>
                    <ul class="space-y-3" role="list">
                        @foreach($projects as $project)
                        @php
                            $sidebarBadge = match($project['status']) {
                                'Live', 'Afgewerkt' => 'text-emerald-600 bg-emerald-50 border-emerald-100',
                                'Prototype'         => 'text-amber-600 bg-amber-50 border-amber-100',
                                default             => 'text-slate-400 bg-stone-100 border-stone-200',
                            };
                        @endphp
                        <li class="flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600 shrink-0" aria-hidden="true"></span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ $project['title'] }}</p>
                                <p class="text-xs text-slate-400">{{ $project['type'] }}</p>
                            </div>
                            <span class="text-[0.6rem] font-medium px-1.5 py-0.5 {{ $sidebarBadge }} border rounded-full shrink-0">{{ $project['status'] }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ── VM Studios — expanded ── --}}
    <section id="vm-studios" class="border-t border-stone-200 scroll-mt-20" aria-labelledby="vm-studios-heading">
        <div class="max-w-6xl mx-auto px-6 py-16">
            <div class="reveal mb-10">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    Eigen projecten
                </p>
                <h2 id="vm-studios-heading" class="font-serif text-3xl font-medium text-slate-900 leading-tight">VM Studios</h2>
                <p class="mt-3 text-slate-500 leading-relaxed max-w-2xl">
                    Naast klantwerk bouw ik eigen apps, games en digitale projecten via <strong class="font-semibold text-slate-700">VM Studios</strong>.
                    Ze tonen mijn technische achtergrond, productdenken en vermogen om ideeën volledig uit te werken —
                    van eerste idee tot afgewerkt en werkend product.
                </p>
            </div>

            <div class="space-y-6">
                @foreach($projects as $i => $project)
                @php
                    $articleBadge = match($project['status']) {
                        'Live', 'Afgewerkt' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                        'Prototype'         => 'bg-amber-50 text-amber-700 border-amber-100',
                        default             => 'bg-slate-100 text-slate-600 border-slate-200',
                    };
                @endphp
                <article class="bg-white rounded-xl border border-stone-200 p-6 md:p-8 reveal" aria-labelledby="vm-{{ $project['slug'] }}-heading">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-10">
                        <div class="md:col-span-2">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="text-xs font-semibold px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-full">{{ $project['category'] }}</span>
                                <span class="text-xs font-medium px-2.5 py-1 {{ $articleBadge }} border rounded-full">{{ $project['status'] }}</span>
                                @if(!empty($project['label']))
                                <span class="text-xs font-medium text-stone-400">{{ $project['label'] }}</span>
                                @endif
                            </div>
                            <h3 id="vm-{{ $project['slug'] }}-heading" class="font-serif text-xl font-medium text-slate-900">{{ $project['title'] }}</h3>
                            <p class="text-sm text-slate-500 mt-0.5 mb-3">{{ $project['type'] }}</p>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $project['description'] }}</p>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Wat het aantoont</h4>
                                <p class="text-sm text-slate-600 leading-relaxed">{{ $project['proves'] }}</p>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Technologieën</h4>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($project['technologies'] as $tech)
                                    <span class="text-xs font-medium px-2 py-0.5 bg-stone-100 border border-stone-200 text-slate-600 rounded-full">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

</x-layouts.app>
