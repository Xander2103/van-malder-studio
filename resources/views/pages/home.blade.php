<x-layouts.app
    :title="__('site.seo.home_title')"
    :description="__('site.seo.home_desc')"
    :ogTitle="__('site.seo.home_og_title')"
>

    {{-- ================================================================
         1. HERO — with interactive canvas wave background
         ================================================================ --}}
    <section class="hero-canvas-section pt-14 pb-20 md:pt-20 md:pb-28" aria-label="{{ __('site.hero.eyebrow') }}">
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
                        {{ __('site.hero.headline') }}
                    </h1>
                    <p class="mt-6 text-[1.0625rem] text-slate-500 leading-relaxed max-w-lg">
                        {!! __('site.hero.body', ['name' => '<strong class="font-semibold text-slate-700">'.e(config('studio.owner')).'</strong>']) !!}
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        @php
                            $loc = app()->getLocale() ?: 'nl';
                            $contactHref  = \Illuminate\Support\Facades\Route::has($loc . '.contact')  ? route($loc . '.contact')  : route('contact');
                            $servicesHref = \Illuminate\Support\Facades\Route::has($loc . '.services') ? route($loc . '.services') : route('services');
                        @endphp
                        <a href="{{ $contactHref }}"
                           class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors duration-200 cursor-pointer shadow-sm">
                            {{ __('site.hero.cta_primary') }}
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="{{ $servicesHref }}"
                           class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-white text-slate-700 border border-stone-300 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                            {{ __('site.hero.cta_secondary') }}
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
                                    <h2 class="font-serif text-xl font-medium text-slate-900">{{ config('studio.brand_name') }}</h2>
                                    <p class="text-sm text-slate-500 mt-0.5">{{ config('studio.owner') }} · Vlaams-Brabant</p>
                                </div>
                                <span class="flex items-center gap-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse" aria-hidden="true"></span>
                                    {{ __('site.common.available') }}
                                </span>
                            </div>

                            <div class="space-y-2 mb-5">
                                @foreach([
                                    __('site.home.service_website_title'),
                                    __('site.home.service_redesign_title'),
                                    __('site.home.service_webshop_title'),
                                    __('site.home.service_forms_title'),
                                    __('site.home.service_apps_title'),
                                    __('site.home.service_maintenance_title'),
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
                                <p class="text-xs text-slate-400">PHP · Laravel · JavaScript · React · Tailwind · MySQL · HTML · CSS · UI/UX design  </p>
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
    <section class="bg-white border-y border-stone-200" aria-label="{{ __('site.home.trust_clear_title') }}">
        <div class="max-w-6xl mx-auto px-6 py-10">
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-px bg-stone-200 rounded-xl overflow-hidden">
                @foreach([
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                      'term' => __('site.home.trust_clear_title'),  'desc' => __('site.home.trust_clear_desc')],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>',
                      'term' => __('site.home.trust_custom_title'), 'desc' => __('site.home.trust_custom_desc')],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                      'term' => __('site.home.trust_secure_title'), 'desc' => __('site.home.trust_secure_desc')],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                      'term' => __('site.home.trust_personal_title'), 'desc' => __('site.home.trust_personal_desc')],
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
                    {{ __('site.home.offer_eyebrow') }}
                </p>
                <h2 id="offer-heading" class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">{{ __('site.home.offer_heading') }}</h2>
            </div>
            <a href="{{ $servicesHref }}"
               class="text-sm font-semibold text-blue-700 hover:text-blue-900 flex items-center gap-1.5 transition-colors duration-200 shrink-0 group">
                {{ __('site.home.offer_link') }}
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

            {{-- 1. Website --}}
            <article class="bento-card md:col-span-2 lg:col-span-2 bg-slate-900 rounded-xl p-7 flex flex-col reveal" aria-label="{{ __('site.home.service_website_title') }}">
                <span class="text-[0.65rem] font-bold text-slate-600 tracking-widest mb-3">01</span>
                <h3 class="font-serif text-xl font-medium text-white">{{ __('site.home.service_website_title') }}</h3>
                <p class="mt-2 text-sm text-slate-400 leading-relaxed mb-5 flex-1">{{ __('site.home.service_website_body') }}</p>
                <ul class="space-y-2" role="list">
                    @foreach(__('site.home.service_website_bullets') as $point)
                    <li class="flex items-center gap-2.5 text-sm text-slate-300">
                        <svg class="w-3.5 h-3.5 shrink-0 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $point }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ $servicesHref }}#nieuwe-website"
                   class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-400 hover:text-blue-300 transition-colors duration-200 group cursor-pointer">
                    {{ __('site.common.more_details') }} <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </article>

            {{-- 2. Website vernieuwen --}}
            <article class="bento-card bg-white rounded-xl border border-stone-200 p-7 flex flex-col reveal reveal-delay-1">
                <span class="text-[0.65rem] font-bold text-stone-300 tracking-widest mb-3">02</span>
                <h3 class="font-serif text-xl font-medium text-slate-900">{{ __('site.home.service_redesign_title') }}</h3>
                <p class="mt-2 text-sm text-slate-500 leading-relaxed flex-1">{{ __('site.home.service_redesign_body') }}</p>
                <a href="{{ $servicesHref }}#website-vernieuwen"
                   class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 group cursor-pointer">
                    {{ __('site.common.more_details') }} <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </article>

            {{-- 3. Webshop --}}
            <article class="bento-card bg-white rounded-xl border border-stone-200 p-7 flex flex-col reveal">
                <span class="text-[0.65rem] font-bold text-stone-300 tracking-widest mb-3">03</span>
                <h3 class="font-serif text-xl font-medium text-slate-900">{{ __('site.home.service_webshop_title') }}</h3>
                <p class="mt-2 text-sm text-slate-500 leading-relaxed flex-1">{{ __('site.home.service_webshop_body') }}</p>
                <p class="mt-2 text-xs text-stone-400">{{ __('site.home.service_webshop_seo') }}</p>
                <a href="{{ $servicesHref }}#webshop"
                   class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 group cursor-pointer">
                    {{ __('site.common.more_details') }} <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </article>

            {{-- 4. Slimme aanvraagflow --}}
            <article class="bento-card bg-white rounded-xl border border-stone-200 p-7 flex flex-col reveal reveal-delay-1">
                <span class="text-[0.65rem] font-bold text-stone-300 tracking-widest mb-3">04</span>
                <h3 class="font-serif text-xl font-medium text-slate-900">{{ __('site.home.service_forms_title') }}</h3>
                <p class="mt-2 text-sm text-slate-500 leading-relaxed flex-1">{{ __('site.home.service_forms_body') }}</p>
                <p class="mt-3 text-xs text-amber-700 bg-amber-50 border border-amber-100 rounded-lg px-3 py-2 leading-relaxed">{{ __('site.home.service_forms_ai_note') }}</p>
                <a href="{{ $servicesHref }}#formulieren"
                   class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 group cursor-pointer">
                    {{ __('site.home.service_forms_cta') }} <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </article>

            {{-- 5. Apps --}}
            <article class="bento-card bg-white rounded-xl border border-stone-200 p-7 flex flex-col reveal reveal-delay-2">
                <span class="text-[0.65rem] font-bold text-stone-300 tracking-widest mb-3">05</span>
                <h3 class="font-serif text-xl font-medium text-slate-900">{{ __('site.home.service_apps_title') }}</h3>
                <p class="mt-2 text-sm text-slate-500 leading-relaxed flex-1">{{ __('site.home.service_apps_body') }}</p>
                <a href="{{ $servicesHref }}#webapplicatie"
                   class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 group cursor-pointer">
                    {{ __('site.common.more_details') }} <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </article>

            {{-- 6. Onderhoud --}}
            <article class="bento-card lg:col-span-2 bg-stone-100 border border-stone-200 rounded-xl px-7 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 reveal reveal-delay-3">
                <div>
                    <span class="text-[0.65rem] font-bold text-stone-400 tracking-widest">06</span>
                    <h3 class="font-serif text-lg font-medium text-slate-900 mt-1">{{ __('site.home.service_maintenance_title') }}</h3>
                    <p class="text-sm text-slate-500 mt-1 max-w-sm">
                        {{ __('site.home.service_maintenance_body') }}
                        <span class="font-medium text-slate-700">{{ __('site.home.service_maintenance_price') }}</span>
                    </p>
                </div>
                <a href="{{ $contactHref }}"
                   class="shrink-0 inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold bg-white border border-stone-300 text-slate-700 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                    {{ __('site.home.service_maintenance_cta') }}
                </a>
            </article>

            {{-- SEO note --}}
            <div class="bg-white border border-stone-200 rounded-xl p-5 flex flex-col gap-3 reveal reveal-delay-3">
                <div class="flex items-start gap-3">
                    <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <div>
                        <p class="text-xs font-semibold text-slate-700 mb-1">{{ __('site.home.seo_note_title') }}</p>
                        <p class="text-xs text-slate-500 leading-relaxed">{{ __('site.home.seo_note_body') }}</p>
                    </div>
                </div>
                <a href="{{ $servicesHref }}#seo-landingspaginas"
                   class="text-xs font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 flex items-center gap-1 group">
                    {{ __('site.home.seo_note_link') }}
                    <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

        </div>
    </section>

    {{-- ================================================================
         4. COMPARISON BLOCK
         ================================================================ --}}
    <section class="max-w-6xl mx-auto px-6 pb-20" aria-labelledby="compare-heading">
        <div class="reveal">
            <h2 id="compare-heading" class="font-serif text-2xl font-medium text-slate-900 mb-6">{{ __('site.home.compare_heading') }}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 reveal">
            <div class="compare-neg border rounded-xl p-6">
                <h3 class="text-sm font-semibold text-red-700 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    {{ __('site.home.compare_without_title') }}
                </h3>
                <ul class="space-y-3" role="list">
                    @foreach(__('site.home.compare_without_items') as $item)
                    <li class="flex items-start gap-2.5 text-sm text-red-800">
                        <svg class="mt-0.5 w-4 h-4 shrink-0 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                        </svg>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="compare-pos border rounded-xl p-6">
                <h3 class="text-sm font-semibold text-green-700 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('site.home.compare_with_title') }}
                </h3>
                <ul class="space-y-3" role="list">
                    @foreach(__('site.home.compare_with_items') as $item)
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
                        {{ __('site.home.process_eyebrow') }}
                    </p>
                    <h2 id="process-heading" class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">
                        {{ __('site.home.process_heading') }}
                    </h2>
                    <p class="mt-4 text-slate-500 leading-relaxed">{{ __('site.home.process_body') }}</p>
                    <div class="mt-8">
                        @php $processHref = \Illuminate\Support\Facades\Route::has($loc . '.process') ? route($loc . '.process') : route('process'); @endphp
                        <a href="{{ $processHref }}"
                           class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-white border border-stone-300 text-slate-700 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                            {{ __('site.home.process_link') }}
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-3 reveal reveal-delay-1">
                    <ol class="space-y-0" aria-label="{{ __('site.process.heading') }}">
                        @foreach(__('site.process.steps') as $i => $step)
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
                {{ __('site.home.pricing_eyebrow') }}
            </p>
            <h2 id="pricing-heading" class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">{{ __('site.home.pricing_heading') }}</h2>
            <p class="mt-3 text-slate-500 max-w-lg mx-auto leading-relaxed">{{ __('site.home.pricing_note') }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach([
                ['title' => __('site.pricing.card_starter_title'), 'price' => __('site.pricing.card_starter_price'), 'desc' => __('site.pricing.card_starter_desc'), 'highlighted' => false],
                ['title' => __('site.pricing.card_pro_title'),     'price' => __('site.pricing.card_pro_price'),     'desc' => __('site.pricing.card_pro_desc'),     'highlighted' => true],
                ['title' => __('site.pricing.card_webshop_title'), 'price' => __('site.pricing.card_webshop_price'), 'desc' => __('site.pricing.card_webshop_desc'), 'highlighted' => false],
                ['title' => __('site.pricing.card_maint_title'),   'price' => __('site.pricing.card_maint_price'),   'desc' => __('site.pricing.card_maint_desc'),   'highlighted' => false],
            ] as $plan)
            <div class="reveal">
                <x-pricing-card :title="$plan['title']" :price="$plan['price']" :description="$plan['desc']" :highlighted="$plan['highlighted']" />
            </div>
            @endforeach
        </div>
        <div class="text-center mt-6 space-y-1.5">
            <p class="text-xs font-medium text-slate-500">{{ __('site.home.pricing_vat_note') }}</p>
            <p class="text-sm text-slate-400">{{ __('site.home.pricing_note') }}</p>
            @php $pricingHref = \Illuminate\Support\Facades\Route::has($loc . '.pricing') ? route($loc . '.pricing') : route('pricing'); @endphp
            <a href="{{ $pricingHref }}" class="inline-flex items-center gap-1 text-sm font-medium text-blue-700 hover:text-blue-900 transition-colors duration-200">
                {{ __('site.home.pricing_link') }}
            </a>
        </div>
    </section>

    {{-- ================================================================
         7. SHOWCASE TEASER
         ================================================================ --}}
    <section class="max-w-6xl mx-auto px-6 py-8">
        @php $showcaseHref = \Illuminate\Support\Facades\Route::has($loc . '.showcase') ? route($loc . '.showcase') : route('showcase'); @endphp
        <div class="bg-stone-100 border border-stone-200 rounded-xl px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 reveal">
            <div>
                <p class="text-sm font-semibold text-slate-700">{{ __('site.home.showcase_teaser_title') }}</p>
                <p class="text-sm text-slate-500 mt-0.5">{{ __('site.home.showcase_teaser_body') }}</p>
            </div>
            <a href="{{ $showcaseHref }}"
               class="shrink-0 inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold bg-white border border-stone-300 text-slate-700 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                {{ __('site.home.showcase_teaser_cta') }}
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
                    {{ __('site.home.cta_heading') }}
                </h2>
                <p class="mt-4 text-slate-300 text-lg max-w-xl mx-auto leading-relaxed">
                    {{ __('site.home.cta_body') }}
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <a href="{{ $contactHref }}"
                       class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold bg-white text-slate-900 rounded-lg hover:bg-blue-50 transition-colors duration-200 cursor-pointer shadow-sm">
                        {{ __('site.hero.cta_primary') }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ $servicesHref }}"
                       class="inline-flex items-center px-6 py-3 text-sm font-semibold text-slate-300 border border-slate-700 rounded-lg hover:border-slate-500 hover:text-white transition-colors duration-200 cursor-pointer">
                        {{ __('site.hero.cta_secondary') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
