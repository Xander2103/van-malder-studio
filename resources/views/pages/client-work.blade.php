<x-layouts.app
    :title="__('site.seo.clientwork_title')"
    :description="__('site.seo.clientwork_desc')"
    :ogTitle="__('site.seo.clientwork_og_title')"
    pageType="CollectionPage"
>

@php
    $loc          = app()->getLocale() ?: 'nl';
    $contactHref  = \Illuminate\Support\Facades\Route::has($loc . '.contact')  ? route($loc . '.contact')  : route('contact');
    $servicesHref = \Illuminate\Support\Facades\Route::has($loc . '.services') ? route($loc . '.services') : route('services');
@endphp

    {{-- ── 1. Intro ── --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-10">
        <div class="reveal max-w-3xl">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                {{ __('site.clientwork_page.eyebrow') }}
            </p>
            <h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">
                {{ __('site.clientwork_page.heading') }}
            </h1>
            <p class="mt-4 text-lg text-slate-500 leading-relaxed">
                {{ __('site.clientwork_page.intro') }}
            </p>
            <p class="mt-4 text-sm text-slate-500 leading-relaxed border-l-2 border-amber-500/70 pl-4">
                {{ __('site.clientwork_page.permission') }}
            </p>
        </div>
    </section>

    {{-- ── 2. Projects — one full-width section per client, image and text alternate ── --}}
    <section class="max-w-6xl mx-auto px-6 pb-8" aria-label="{{ __('site.clientwork_page.heading') }}">
        <div class="space-y-14 md:space-y-20">
            @foreach($clientWork as $index => $work)
            @php
                $t          = __('site.client_work.items.' . $work['slug']);
                $t          = is_array($t) ? $t : [];
                $sector     = $t['sector'] ?? $work['sector'];
                $desc       = $t['description'] ?? '';
                $highlights = is_array($t['highlights'] ?? null) ? $t['highlights'] : [];
                $service    = $t['service'] ?? null;
                $alt        = !empty($t['alt'])
                    ? $t['alt']
                    : __('site.client_work.preview_alt', ['name' => $work['title']]);
                $headingId  = 'project-' . $work['slug'];
                $hasImage   = !empty($work['image']) && file_exists(public_path($work['image']));
                $imageFirst = $index % 2 === 0;
            @endphp

            <article id="{{ $headingId }}" class="scroll-mt-24 reveal" aria-labelledby="{{ $headingId }}-heading">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

                    {{-- Screenshot of the live site --}}
                    <div class="lg:col-span-7 {{ $imageFirst ? '' : 'lg:order-2' }}">
                        @if($hasImage)
                        <a href="{{ $work['url'] }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="block aspect-[16/9] overflow-hidden rounded-xl border border-stone-200 bg-stone-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <img src="{{ asset($work['image']) }}"
                                 alt="{{ $alt }}"
                                 class="w-full h-full object-cover object-top"
                                 loading="lazy"
                                 decoding="async"
                                 width="1600"
                                 height="900">
                        </a>
                        @else
                        <div class="aspect-[16/9] rounded-xl border border-stone-200 bg-stone-100" aria-hidden="true"></div>
                        @endif
                    </div>

                    {{-- Facts + what was built --}}
                    <div class="lg:col-span-5 {{ $imageFirst ? '' : 'lg:order-1' }}">
                        <p class="text-xs font-semibold text-amber-700 uppercase tracking-widest mb-2">{{ $sector }}</p>
                        <h2 id="{{ $headingId }}-heading" class="font-serif text-2xl md:text-3xl font-medium text-slate-900 leading-snug">
                            {{ $work['title'] }}
                        </h2>

                        @if($service)
                        <p class="mt-2 text-sm font-medium text-slate-500">
                            <span class="sr-only">{{ __('site.clientwork_page.type_label') }}: </span>{{ $service }}
                        </p>
                        @endif

                        <p class="mt-4 text-slate-600 leading-relaxed">{{ $desc }}</p>

                        @if($highlights)
                        <h3 class="mt-6 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2.5">
                            {{ __('site.clientwork_page.built_heading') }}
                        </h3>
                        <ul class="space-y-2" role="list">
                            @foreach($highlights as $point)
                            <li class="flex items-start gap-2.5 text-sm text-slate-600 leading-relaxed">
                                <span class="mt-2 w-1.5 h-1.5 rounded-full bg-amber-600 shrink-0" aria-hidden="true"></span>
                                <span>{{ $point }}</span>
                            </li>
                            @endforeach
                        </ul>
                        @endif

                        <a href="{{ $work['url'] }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="mt-7 inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                            {{ __('site.clientwork_page.visit') }}
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5h5m0 0v5m0-5L10 14"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14v4a1 1 0 01-1 1H6a1 1 0 01-1-1V6a1 1 0 011-1h4"/>
                            </svg>
                            <span class="sr-only">({{ $work['domain'] }})</span>
                        </a>
                        <p class="mt-2 text-xs text-slate-400">{{ $work['domain'] }}</p>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </section>

    {{-- ── 3. More than a website — links custom capability back to a real project ── --}}
    <x-more-than-website :contactHref="$contactHref" :servicesHref="$servicesHref" />

    {{-- ── 4. Closing CTA ── --}}
    <section class="max-w-6xl mx-auto px-6 py-16" aria-labelledby="clientwork-cta-heading">
        <div class="bg-white border border-stone-200 rounded-2xl p-8 md:p-10 shadow-sm reveal">
            <div class="max-w-2xl">
                <h2 id="clientwork-cta-heading" class="font-serif text-2xl md:text-3xl font-medium text-slate-900 leading-tight">
                    {{ __('site.clientwork_page.cta_heading') }}
                </h2>
                <p class="mt-3 text-slate-500 leading-relaxed">{{ __('site.clientwork_page.cta_body') }}</p>
                <div class="mt-7 flex flex-wrap items-center gap-3">
                    <a href="{{ $contactHref }}"
                       class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                        {{ __('site.clientwork_page.cta_button') }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ $servicesHref }}"
                       class="inline-flex items-center px-5 py-3 text-sm font-semibold bg-white text-slate-700 border border-stone-300 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                        {{ __('site.clientwork_page.cta_secondary') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Structured data: the three live client websites, factual only ── --}}
    @php
        $itemListSchema = [
            '@context'        => 'https://schema.org',
            '@type'           => 'ItemList',
            'name'            => __('site.clientwork_page.heading'),
            'description'     => __('site.clientwork_page.intro'),
            'itemListElement' => [],
        ];
        foreach ($clientWork as $i => $work) {
            $t = __('site.client_work.items.' . $work['slug']);
            $t = is_array($t) ? $t : [];
            $itemListSchema['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'item'     => array_filter([
                    '@type'       => 'WebSite',
                    'name'        => $work['title'],
                    'url'         => $work['url'],
                    'description' => $t['description'] ?? null,
                    'keywords'    => implode(', ', $work['technologies']),
                    'creator'     => ['@id' => rtrim(config('studio.url'), '/') . '/#business'],
                ]),
            ];
        }
    @endphp
    <script type="application/ld+json">
{!! json_encode($itemListSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>

</x-layouts.app>
