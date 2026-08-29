<x-layouts.app
    :title="__('site.seo.about_title')"
    :description="__('site.seo.about_desc')"
    :ogTitle="__('site.seo.about_og_title')"
    pageType="AboutPage"
>

@php
    $loc               = app()->getLocale() ?: 'nl';
    $aboutContactHref  = \Illuminate\Support\Facades\Route::has($loc . '.contact')  ? route($loc . '.contact')  : route('contact');
    $aboutShowcaseHref = \Illuminate\Support\Facades\Route::has($loc . '.showcase') ? route($loc . '.showcase') : route('showcase');
    $aboutServicesHref = \Illuminate\Support\Facades\Route::has($loc . '.services') ? route($loc . '.services') : route('services');
    $aboutClientWorkHref = \Illuminate\Support\Facades\Route::has($loc . '.clientwork') ? route($loc . '.clientwork') : $aboutServicesHref;
@endphp

    {{-- ── 1. Introduction ── --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-16">
        <div class="grid grid-cols-1 lg:grid-cols-5 lg:grid-rows-[auto_1fr] gap-8 lg:gap-16 items-start">

            {{-- Heading + intro --}}
            <div class="lg:col-span-3 reveal order-1">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    {{ __('site.about.eyebrow') }}
                </p>
                <h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">{{ __('site.about.heading') }}</h1>
                <p class="mt-2 text-slate-500">{{ __('site.about.subtitle') }}</p>
            </div>

            {{-- Sidebar (portrait first on mobile; spans both rows on desktop) --}}
            <div class="lg:col-span-2 lg:row-span-2 space-y-4 reveal reveal-delay-1 order-2">

                {{-- Portrait --}}
                <div class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden">
                    <div class="relative overflow-hidden rounded-t-xl" style="height:240px;">
                        <img src="{{ asset('images/Xander.webp') }}"
                             alt="{{ __('site.home.xander_caption') }}"
                             class="absolute inset-0 w-full h-full object-cover object-center"
                             loading="eager"
                             fetchpriority="high"
                             decoding="async"
                             width="480"
                             height="280">
                    </div>
                    <div class="px-5 py-3 flex items-center gap-2 border-t border-stone-100">
                        <div class="w-2 h-2 rounded-full bg-amber-500 shrink-0" aria-hidden="true"></div>
                        <p class="text-sm text-slate-600 font-medium">{{ __('site.home.xander_caption') }}</p>
                    </div>
                </div>

                {{-- 2. Technologies --}}
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm">
                    <h2 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-5">{{ __('site.about.tech_heading') }}</h2>
                    <div class="space-y-4">
                        @foreach(__('site.about.tech_groups') as $group)
                        <div>
                            <h3 class="font-sans text-[0.6rem] font-semibold text-stone-400 uppercase tracking-widest mb-1.5">{{ $group['label'] }}</h3>
                            <ul class="flex flex-wrap gap-1.5" role="list">
                                @foreach($group['items'] as $tech)
                                <li class="text-xs font-medium px-2 py-0.5 bg-stone-100 border border-stone-200 text-slate-600 rounded-full">{{ $tech }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Body text + CTAs --}}
            <div class="lg:col-span-3 reveal order-3">
                <div class="space-y-4 text-slate-600 leading-relaxed">
                    <p>{{ __('site.about.body_1') }}</p>
                    <p>{{ __('site.about.body_2') }}</p>
                    <p>{{ __('site.about.body_3') }}</p>
                    <p>{{ __('site.about.body_4', ['brand' => 'VM Studios']) }}</p>
                    <p>{{ __('site.about.body_5') }}</p>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ $aboutContactHref }}"
                       class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                        {{ __('site.about.cta_contact') }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ $aboutClientWorkHref }}"
                       class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-white border border-stone-300 text-slate-700 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                        {{ __('site.about.cta_work') }}
                    </a>
                    <a href="{{ $aboutShowcaseHref }}"
                       class="inline-flex items-center px-5 py-3 text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                        {{ __('site.about.cta_showcase') }}
                    </a>
                </div>

                <div class="mt-10">
                    <x-business-card size="compact" />
                </div>
            </div>
        </div>
    </section>

    {{-- ── 4. Client work — concise reference; the full cases live on their own page ── --}}
    <section id="client-work" class="bg-white border-t border-stone-200 scroll-mt-20" aria-labelledby="client-work-heading">
        <div class="max-w-6xl mx-auto px-6 py-14">
            <div class="reveal flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div class="max-w-2xl">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                        <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                        {{ __('site.client_work.eyebrow') }}
                    </p>
                    <h2 id="client-work-heading" class="font-serif text-2xl md:text-3xl font-medium text-slate-900 leading-tight">
                        {{ __('site.client_work.heading') }}
                    </h2>
                    <p class="mt-3 text-slate-500 leading-relaxed">{{ __('site.client_work.body') }}</p>
                </div>
                <a href="{{ $aboutClientWorkHref }}"
                   class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm shrink-0">
                    {{ __('site.about.cta_work') }}
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            {{-- Crawlable client list; each name deep-links to its case on the portfolio page --}}
            <ul class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 reveal" role="list">
                @foreach($clientWork as $work)
                @php
                    $tw = __('site.client_work.items.' . $work['slug']);
                    $tw = is_array($tw) ? $tw : [];
                @endphp
                <li class="bg-stone-50 border border-stone-200 rounded-xl px-5 py-4">
                    <p class="text-[0.65rem] font-semibold text-slate-400 uppercase tracking-widest mb-1">{{ $tw['sector'] ?? $work['sector'] }}</p>
                    <a href="{{ $aboutClientWorkHref }}#project-{{ $work['slug'] }}"
                       class="font-serif text-base font-medium text-slate-900 hover:text-amber-800 transition-colors duration-200">
                        {{ $work['title'] }}
                    </a>
                    @if(!empty($tw['service']))
                    <p class="mt-0.5 text-xs text-slate-500">{{ $tw['service'] }}</p>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- ── 5. Own projects / VM Studios ── --}}
    <section id="vm-studios" class="border-t border-stone-200 scroll-mt-20" aria-labelledby="vm-studios-heading">
        <div class="max-w-6xl mx-auto px-6 py-16">
            <div class="reveal mb-10">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    {{ __('site.about.vm_studios_eyebrow') }}
                </p>
                <h2 id="vm-studios-heading" class="font-serif text-3xl font-medium text-slate-900 leading-tight">{{ __('site.about.vm_studios_heading') }}</h2>
                <p class="mt-3 text-slate-500 leading-relaxed max-w-2xl">
                    {{ __('site.about.vm_studios_body') }}
                </p>
            </div>

            <div class="space-y-6">
                @foreach($projects as $i => $project)
                @php
                    $statusKey = $project['status_key'] ?? 'in-development';
                    $articleBadge = match($statusKey) {
                        'live'           => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                        'prototype'      => 'bg-amber-50 text-amber-700 border-amber-100',
                        default          => 'bg-slate-100 text-slate-600 border-slate-200',
                    };
                    $statusLabel = __('site.about.status.' . $statusKey) ?: $project['status'];
                    $tProject = __('site.projects.' . $project['slug']);
                    $displayCategory    = is_array($tProject) ? $tProject['category']    : $project['category'];
                    $displayType        = is_array($tProject) ? $tProject['type']        : $project['type'];
                    $displayLabel       = is_array($tProject) ? ($tProject['label'] ?? $project['label'] ?? '') : ($project['label'] ?? '');
                    $displayDescription = is_array($tProject) ? $tProject['description'] : $project['description'];
                    $displayProves      = is_array($tProject) ? $tProject['proves']      : $project['proves'];
                @endphp
                <article id="vm-{{ $project['slug'] }}" class="bg-white rounded-xl border border-stone-200 p-6 md:p-8 reveal scroll-mt-20" aria-labelledby="vm-{{ $project['slug'] }}-heading">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-10">
                        <div class="md:col-span-2">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="text-xs font-semibold px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-full">{{ $displayCategory }}</span>
                                <span class="text-xs font-medium px-2.5 py-1 {{ $articleBadge }} border rounded-full">{{ $statusLabel }}</span>
                                @if(!empty($displayLabel))
                                <span class="text-xs font-medium text-stone-400">{{ $displayLabel }}</span>
                                @endif
                            </div>
                            <h3 id="vm-{{ $project['slug'] }}-heading" class="font-serif text-xl font-medium text-slate-900">{{ $project['title'] }}</h3>
                            <p class="text-sm text-slate-500 mt-0.5 mb-3">{{ $displayType }}</p>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $displayDescription }}</p>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('site.about.project_proves') }}</h4>
                                <p class="text-sm text-slate-600 leading-relaxed">{{ $displayProves }}</p>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('site.about.project_tech') }}</h4>
                                <ul class="flex flex-wrap gap-1.5" role="list">
                                    @foreach($project['technologies'] as $tech)
                                    <li class="text-xs font-medium px-2 py-0.5 bg-stone-100 border border-stone-200 text-slate-600 rounded-full">{{ $tech }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── 6. Closing CTA ── --}}
    <section class="max-w-6xl mx-auto px-6 pb-16" aria-labelledby="about-cta-heading">
        <div class="relative bg-slate-900 rounded-2xl overflow-hidden reveal">
            <div class="absolute inset-0" style="background:linear-gradient(135deg,#0f172a 0%,#1c2f4a 55%,#0f172a 100%)" aria-hidden="true"></div>
            <div class="absolute top-0 left-0 right-0 h-px" style="background:linear-gradient(90deg,transparent,#c49a3a 50%,transparent)" aria-hidden="true"></div>
            <div class="relative px-6 py-10 md:px-14 md:py-14 text-center">
                <h2 id="about-cta-heading" class="font-serif text-2xl md:text-3xl font-medium text-white leading-tight max-w-xl mx-auto">
                    {{ __('site.about.cta_band_heading') }}
                </h2>
                <p class="mt-3 text-slate-300 max-w-md mx-auto leading-relaxed">
                    {{ __('site.about.cta_band_body') }}
                </p>
                <div class="mt-7 flex flex-wrap justify-center gap-3">
                    <a href="{{ $aboutContactHref }}"
                       class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold bg-amber-500 text-white rounded-lg hover:bg-amber-400 transition-colors duration-200 cursor-pointer shadow-sm">
                        {{ __('site.about.cta_band_primary') }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ $aboutServicesHref }}"
                       class="inline-flex items-center px-6 py-3 text-sm font-semibold text-slate-300 border border-slate-700 rounded-lg hover:border-slate-500 hover:text-white transition-colors duration-200 cursor-pointer">
                        {{ __('site.about.cta_band_secondary') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Structured data: client work as an ItemList of real websites ── --}}
    @php
        $base = rtrim(config('studio.url'), '/');
        $clientWorkSchema = [
            '@context'        => 'https://schema.org',
            '@type'           => 'ItemList',
            '@id'             => url()->current() . '#client-work',
            'name'            => __('site.client_work.heading'),
            'description'     => __('site.client_work.body'),
            'itemListElement' => collect($clientWork)->values()->map(function ($work, $i) use ($base) {
                $t = __('site.client_work.items.' . $work['slug']);
                $t = is_array($t) ? $t : [];
                return [
                    '@type'    => 'ListItem',
                    'position' => $i + 1,
                    'item'     => [
                        '@type'       => 'WebSite',
                        'name'        => $work['title'],
                        'url'         => $work['url'],
                        'description' => $t['description'] ?? '',
                        'about'       => $t['sector'] ?? $work['sector'],
                        'creator'     => ['@id' => $base . '/#business'],
                        'keywords'    => implode(', ', $work['technologies']),
                    ],
                ];
            })->all(),
        ];
    @endphp
    <script type="application/ld+json">
{!! json_encode($clientWorkSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>

</x-layouts.app>
