<footer class="bg-slate-900 text-slate-300 mt-24">
    <div class="max-w-6xl mx-auto px-6 pt-16 pb-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-slate-800">

            {{-- Brand column --}}
            <div class="md:col-span-4">
                <a href="{{ route('home') }}" class="font-serif text-lg font-medium text-white hover:text-blue-400 transition-colors duration-200">
                    Van Malder Studio
                </a>
                <p class="mt-3 text-sm leading-relaxed text-slate-400 max-w-xs">
                    {{ config('studio.positioning') }}
                </p>
                <p class="mt-3 text-xs text-slate-500 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ config('studio.location') }}
                </p>
            </div>

            {{-- Nav columns --}}
            <div class="md:col-span-3 md:col-start-6">
                <h3 class="text-xs font-semibold text-white uppercase tracking-wider mb-4">Studio</h3>
                <ul class="space-y-2.5" role="list">
                    @foreach([
                        ['route' => 'services',       'label' => 'Diensten'],
                        ['route' => 'projects.index', 'label' => 'Projecten'],
                        ['route' => 'process',        'label' => 'Werkwijze'],
                        ['route' => 'pricing',        'label' => 'Prijzen'],
                        ['route' => 'about',          'label' => 'Over mij'],
                        ['route' => 'privacy',        'label' => 'Privacyverklaring'],
                    ] as $link)
                    <li>
                        <a href="{{ route($link['route']) }}" class="text-sm text-slate-400 hover:text-white transition-colors duration-200">
                            {{ $link['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact column --}}
            <div class="md:col-span-3">
                <h3 class="text-xs font-semibold text-white uppercase tracking-wider mb-4">Contact</h3>
                <p class="text-sm text-slate-400 leading-relaxed mb-4">
                    Wil je samenwerken of heb je een vraag?
                </p>
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold bg-blue-700 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 cursor-pointer">
                    Stuur een bericht
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <p class="mt-4">
                    <a href="mailto:{{ config('studio.email') }}" class="text-sm text-slate-500 hover:text-slate-300 transition-colors duration-200">
                        {{ config('studio.email') }}
                    </a>
                </p>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-slate-600">
            <p>&copy; {{ date('Y') }} {{ config('studio.brand_name') }}. Alle rechten voorbehouden.</p>
            <div class="flex items-center gap-4">
                <a href="{{ route('privacy') }}" class="hover:text-slate-400 transition-colors duration-200">Privacyverklaring</a>
                <span aria-hidden="true">·</span>
                <p>{{ config('studio.tagline') }}</p>
            </div>
        </div>
    </div>
</footer>
