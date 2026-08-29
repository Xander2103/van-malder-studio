<x-layouts.app
    :title="$page['meta_title']"
    :description="$page['meta_description']"
    :canonical="$canonical"
    :ogTitle="$page['meta_title']"
    :ogDescription="$page['meta_description']"
    :noindex="$noindex"
>

@php
    // Landing pages are NL-only today, but never link to the legacy unprefixed routes (they 301 to /nl/...).
    $lpLocale   = $page['locale'] ?? (app()->getLocale() ?: 'nl');
    $lpRoute    = fn (string $name) => \Illuminate\Support\Facades\Route::has($lpLocale . '.' . $name) ? route($lpLocale . '.' . $name) : route($name);
    $lpContact  = $lpRoute('contact');
    $lpServices = $lpRoute('services');
    $lpAbout    = $lpRoute('about');
    $lpClientWork = $lpRoute('clientwork');
@endphp

    {{-- ── Hero ── --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-12">
        <div class="reveal">
            @if(!empty($page['location']))
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                {{ $page['location'] }}
            </p>
            @else
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                Van Malder Studio
            </p>
            @endif

            <h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">
                {{ $page['h1'] }}
            </h1>
            <p class="mt-5 text-lg text-slate-500 leading-relaxed max-w-2xl">
                {{ $page['intro'] }}
            </p>
            <div class="mt-7 flex flex-wrap gap-3">
                <a href="{{ $lpContact }}"
                   class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                    {{ $page['cta_text'] }}
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ $lpServices }}"
                   class="inline-flex items-center px-5 py-3 text-sm font-semibold bg-white border border-stone-300 text-slate-700 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                    Bekijk alle diensten
                </a>
            </div>
        </div>
    </section>

    {{-- ── Who for + bullets ── --}}
    <section class="bg-stone-100 border-y border-stone-200" aria-labelledby="landing-included-heading">
        <div class="max-w-6xl mx-auto px-6 py-14">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start reveal">
                <div>
                    <h2 id="landing-included-heading" class="font-serif text-2xl font-medium text-slate-900 mb-3">Wat is inbegrepen?</h2>
                    <p class="text-slate-500 leading-relaxed mb-6">{{ $page['who_for'] }}</p>

                    <ul class="space-y-3" role="list">
                        @foreach($page['bullets'] as $bullet)
                        <li class="flex items-start gap-3">
                            <span class="mt-1 w-4 h-4 rounded-full bg-blue-50 border border-blue-200 flex items-center justify-center shrink-0" aria-hidden="true">
                                <svg class="w-2.5 h-2.5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                            <span class="text-sm text-slate-600 leading-relaxed">{{ $bullet }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-white rounded-xl border border-stone-200 p-7 shadow-sm">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-full bg-slate-900 flex items-center justify-center shrink-0" aria-hidden="true">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Xander Van Malder</p>
                            <p class="text-xs text-slate-500">Full stack developer · Druivenstreek</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed mb-5">
                        Ik werk rechtstreeks met je samen — geen account managers, geen uitbesteding.
                        Je praat altijd met de developer zelf.
                    </p>
                    <a href="{{ $lpContact }}"
                       class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                        {{ $page['cta_text'] }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Werkwijze / Steps ── --}}
    @if(!empty($page['steps']))
    <section class="max-w-6xl mx-auto px-6 py-12" aria-labelledby="landing-steps-heading">
        <div class="reveal">
            <h2 id="landing-steps-heading" class="font-serif text-2xl font-medium text-slate-900 mb-8">Hoe werkt het?</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($page['steps'] as $i => $step)
                <div class="bg-white border border-stone-200 rounded-xl p-5 flex flex-col">
                    <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold mb-4 shrink-0">
                        {{ $i + 1 }}
                    </div>
                    <h3 class="font-serif text-sm font-medium text-slate-900 mb-2">{{ $step['title'] }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ $step['body'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── Waarom lokaal werken met Xander? ── --}}
    @if(!empty($page['why_local']))
    <section class="bg-stone-50 border-y border-stone-200" aria-labelledby="landing-why-local-heading">
        <div class="max-w-6xl mx-auto px-6 py-14">
            <div class="reveal">
                <h2 id="landing-why-local-heading" class="font-serif text-2xl font-medium text-slate-900 mb-8">Waarom lokaal werken met Xander?</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($page['why_local'] as $i => $reason)
                    <div class="bg-white border border-stone-200 rounded-xl p-6 flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center text-xs font-bold shrink-0" aria-hidden="true">
                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-slate-900 mb-1">{{ $reason['title'] }}</h3>
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $reason['body'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ── Honest SEO note ── --}}
    @if(!empty($page['honest_note']))
    <section class="max-w-6xl mx-auto px-6 py-12">
        <div class="bg-white border border-stone-200 rounded-xl p-6 flex items-start gap-4 reveal">
            <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-slate-600 leading-relaxed">{{ $page['honest_note'] }}</p>
        </div>
    </section>
    @endif

    {{-- ── FAQ ── --}}
    @if(!empty($page['faq']))
    <section class="max-w-6xl mx-auto px-6 py-12" aria-labelledby="landing-faq-heading">
        <div class="reveal">
            <h2 id="landing-faq-heading" class="font-serif text-2xl font-medium text-slate-900 mb-8">Veelgestelde vragen</h2>
            <div class="space-y-5">
                @foreach($page['faq'] as $item)
                <div class="bg-white border border-stone-200 rounded-xl p-6">
                    <h3 class="font-serif text-base font-medium text-slate-900 mb-2">{{ $item['q'] }}</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $item['a'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── Related pages ── --}}
    @if($relatedPages->isNotEmpty())
    <section class="bg-stone-100 border-t border-stone-200" aria-labelledby="landing-related-heading">
        <div class="max-w-6xl mx-auto px-6 py-12">
            <div class="reveal">
                <h2 id="landing-related-heading" class="font-serif text-xl font-medium text-slate-900 mb-6">Gerelateerde diensten</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($relatedPages as $rel)
                    <a href="{{ url('/' . $rel['locale'] . '/' . $rel['slug']) }}"
                       class="bg-white border border-stone-200 rounded-xl p-5 hover:border-slate-300 hover:shadow-sm transition-all duration-200 group">
                        <h3 class="text-sm font-semibold text-slate-900 group-hover:text-blue-700 transition-colors duration-200">{{ $rel['h1'] }}</h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed line-clamp-2">{{ $rel['intro'] }}</p>
                        <span class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-blue-700 group-hover:text-blue-900">
                            Meer info
                            <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ── Final CTA ── --}}
    <section class="max-w-6xl mx-auto px-6 py-14" aria-labelledby="landing-cta-heading">
        <div class="bg-slate-900 rounded-2xl overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-px studio-card-accent" aria-hidden="true"></div>
            <div class="px-8 py-14 md:px-14 md:py-16 text-center">
                <h2 id="landing-cta-heading" class="font-serif text-2xl md:text-3xl font-medium text-white leading-tight max-w-xl mx-auto">
                    Klaar om samen iets te bouwen?
                </h2>
                <p class="mt-3 text-slate-300 max-w-md mx-auto leading-relaxed">
                    Vertel me over je project. Het eerste gesprek is vrijblijvend.
                </p>
                <div class="mt-7 flex flex-wrap justify-center gap-3">
                    <a href="{{ $lpContact }}"
                       class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold bg-white text-slate-900 rounded-lg hover:bg-blue-50 transition-colors duration-200 cursor-pointer shadow-sm">
                        {{ $page['cta_text'] }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ $lpClientWork }}"
                       class="inline-flex items-center px-6 py-3 text-sm font-semibold text-slate-300 border border-slate-700 rounded-lg hover:border-slate-500 hover:text-white transition-colors duration-200 cursor-pointer">
                        Bekijk klantenprojecten
                    </a>
                </div>
            </div>
        </div>
    </section>


    {{-- ── Structured data — FAQ only; WebPage / ProfessionalService / Person come from the shared layout graph ── --}}
    @php
        $schemas = [];

        if (!empty($page['faq'])) {
            $schemas[] = [
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => array_map(fn($item) => [
                    '@type'          => 'Question',
                    'name'           => $item['q'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => $item['a'],
                    ],
                ], $page['faq']),
            ];
        }
    @endphp
    @foreach($schemas as $schema)
    <script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endforeach

</x-layouts.app>
