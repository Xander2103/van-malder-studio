<x-layouts.app
    :title="__('site.seo.home_title')"
    :description="__('site.seo.home_desc')"
    :ogTitle="__('site.seo.home_og_title')"
>

@php
    $loc          = app()->getLocale() ?: 'nl';
    $contactHref  = \Illuminate\Support\Facades\Route::has($loc . '.contact')  ? route($loc . '.contact')  : route('contact');
    $servicesHref = \Illuminate\Support\Facades\Route::has($loc . '.services') ? route($loc . '.services') : route('services');
    $pricingHref  = \Illuminate\Support\Facades\Route::has($loc . '.pricing')  ? route($loc . '.pricing')  : route('pricing');
    $processHref  = \Illuminate\Support\Facades\Route::has($loc . '.process')  ? route($loc . '.process')  : route('process');
@endphp

{{-- ════════════════════════════════════════════════════════════════════════
     A. HERO
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="hero-canvas-section pt-12 pb-14 md:pt-20 md:pb-24" aria-label="Van Malder Studio">
    <canvas id="hero-bg-canvas" class="absolute inset-0 w-full h-full pointer-events-none" aria-hidden="true" style="z-index:0;opacity:1;"></canvas>

    <div class="max-w-6xl mx-auto px-6 relative" style="z-index:1;">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-x-16 lg:gap-y-7 items-start">

            {{-- 1. Text top: eyebrow + headline + intro --}}
            <div class="reveal">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4 sm:mb-5">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    {{ __('site.hero.eyebrow') }}
                </p>
                <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl lg:text-[3.1rem] font-medium text-slate-900 leading-[1.15] tracking-tight">
                    {{ __('site.hero.headline') }}
                </h1>
                {{-- Mobile intro --}}
                <p class="block sm:hidden mt-3 text-base text-slate-500 leading-relaxed">
                    {{ __('site.hero.body_mobile') }}
                </p>
                {{-- Desktop body + byline --}}
                <p class="hidden sm:block mt-5 text-[1.0625rem] text-slate-500 leading-relaxed max-w-lg">
                    {{ __('site.hero.body') }}
                </p>
                <p class="hidden sm:block mt-2 text-sm text-slate-400 max-w-lg">
                    {!! __('site.hero.body_byline', ['name' => '<strong class="font-semibold text-slate-600">'.e(config('studio.owner')).'</strong>']) !!}
                </p>
            </div>

            {{-- 2. Studio card — lg:row-span-2 keeps it right of both text rows on desktop --}}
            <div class="reveal reveal-delay-1 relative lg:row-span-2">
                {{-- Soft ambient glow behind card --}}
                <div class="absolute -inset-6 bg-blue-100/25 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

                <div class="relative bg-white rounded-2xl border border-stone-200 shadow-xl shadow-slate-200/60 overflow-hidden">
                    <div class="studio-card-accent h-1 w-full" aria-hidden="true"></div>
                    <div class="p-5 sm:p-7">
                        <div class="flex items-start justify-between mb-4 sm:mb-5">
                            <div>
                                <p class="text-[0.65rem] font-semibold text-stone-400 uppercase tracking-widest mb-1">Web Studio</p>
                                <h2 class="font-serif text-xl font-medium text-slate-900">{{ config('studio.brand_name') }}</h2>
                                <p class="text-sm text-slate-500 mt-0.5">{{ config('studio.owner') }} · Tervuren, Vlaams-Brabant</p>
                            </div>
                            <span class="flex items-center gap-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full shrink-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse" aria-hidden="true"></span>
                                {{ __('site.common.available') }}
                            </span>
                        </div>

                        @php
                            $cardIcons = [
                                'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9',
                                'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
                                'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
                                'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                            ];
                            $cardItems = is_array(__('site.home.studio_card_items')) ? __('site.home.studio_card_items') : [];
                        @endphp
                        <div class="divide-y divide-stone-100 mb-3 sm:mb-4">
                            @foreach($cardItems as $i => $item)
                            <div class="flex items-center gap-3 text-sm font-medium text-slate-700 py-2 sm:py-2.5 {{ $loop->first ? 'pt-0' : '' }} {{ $loop->last ? 'pb-0' : '' }}">
                                <div class="w-8 h-8 rounded-lg bg-amber-50 border border-amber-200 flex items-center justify-center shrink-0" aria-hidden="true">
                                    <svg class="w-4 h-4 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $cardIcons[$i] ?? $cardIcons[0] }}"/>
                                    </svg>
                                </div>
                                {{ $item }}
                            </div>
                            @endforeach
                        </div>

                        @php $reassurance = is_array(__('site.home.studio_card_reassurance')) ? __('site.home.studio_card_reassurance') : []; @endphp
                        @if($reassurance)
                        <ul class="mb-3 sm:mb-4 space-y-1" aria-label="Werkwijze en aanpak">
                            @foreach($reassurance as $point)
                            <li class="flex items-start gap-1.5 text-xs text-slate-400 leading-snug">
                                <span class="mt-[0.2rem] w-1 h-1 rounded-full bg-slate-300 shrink-0" aria-hidden="true"></span>
                                {{ $point }}
                            </li>
                            @endforeach
                        </ul>
                        @endif

                        <div class="pt-3 sm:pt-4 border-t border-stone-100 flex items-center justify-between">
                            <p class="text-xs text-slate-400">Vanaf <span class="font-semibold text-slate-600">€750</span> · vrijblijvend gesprek</p>
                            <a href="{{ $contactHref }}"
                               class="text-xs font-semibold text-amber-700 hover:text-amber-900 transition-colors duration-200">
                                Kennismaking aanvragen →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. CTAs + trustline --}}
            <div class="reveal">
                <div class="flex flex-wrap gap-3 items-center">
                    <a href="{{ $contactHref }}"
                       class="hero-cta-primary inline-flex items-center gap-2 px-5 py-3.5 text-sm font-semibold text-white rounded-lg cursor-pointer">
                        {{ __('site.hero.cta_primary') }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ $servicesHref }}"
                       class="hidden sm:inline-flex items-center px-5 py-3.5 text-sm font-semibold bg-white text-slate-700 border border-stone-300 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                        {{ __('site.hero.cta_secondary') }}
                    </a>
                    <a href="{{ $servicesHref }}"
                       class="sm:hidden text-sm font-medium text-slate-500 hover:text-amber-700 transition-colors duration-200">
                        {{ __('site.hero.cta_secondary') }} →
                    </a>
                </div>
                @php $trustItems = __('site.hero.trustline_items'); @endphp
                @if(is_array($trustItems))
                <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2">
                    @foreach($trustItems as $item)
                    <span class="flex items-center gap-1.5 text-xs {{ $loop->last ? 'text-amber-700 font-semibold' : 'text-slate-400' }}">
                        <svg class="w-3.5 h-3.5 {{ $loop->last ? 'text-amber-500' : 'text-emerald-500' }} shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ $item }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════════════
     B. TRUST STRIP — 4 client benefits
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="bg-white border-y border-stone-200" aria-label="{{ __('site.home.trust_clear_title') }}">
    <div class="max-w-6xl mx-auto px-6 py-6 sm:py-9">
        <dl class="grid grid-cols-2 lg:grid-cols-4 gap-px bg-stone-100 rounded-xl overflow-hidden">
            @foreach([
                ['path' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
                 'term' => __('site.home.trust_clear_title'), 'desc' => __('site.home.trust_clear_desc')],
                ['path' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
                 'term' => __('site.home.trust_custom_title'), 'desc' => __('site.home.trust_custom_desc')],
                ['path' => 'M17 8l4 4m0 0l-4 4m4-4H3',
                 'term' => __('site.home.trust_secure_title'), 'desc' => __('site.home.trust_secure_desc')],
                ['path' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                 'term' => __('site.home.trust_personal_title'), 'desc' => __('site.home.trust_personal_desc')],
            ] as $point)
            <div class="bg-white px-4 py-4 sm:px-6 sm:py-5 flex items-start gap-3 sm:gap-4">
                <div class="shrink-0 w-7 h-7 sm:w-9 sm:h-9 rounded-lg bg-amber-50 border border-amber-100 flex items-center justify-center" aria-hidden="true">
                    <svg class="w-3.5 h-3.5 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $point['path'] }}"/>
                    </svg>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-900 leading-snug">{{ $point['term'] }}</dt>
                    <dd class="mt-0.5 text-xs sm:text-sm text-slate-500 leading-snug">{{ $point['desc'] }}</dd>
                </div>
            </div>
            @endforeach
        </dl>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════════════
     C. SERVICES — 3 main service cards
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="max-w-6xl mx-auto px-6 py-12 md:py-20" aria-labelledby="services-heading">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-5 mb-8 reveal">
        <div>
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                {{ __('site.home.offer_eyebrow') }}
            </p>
            <h2 id="services-heading" class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">
                {{ __('site.home.offer_heading') }}
            </h2>
        </div>
        <a href="{{ $servicesHref }}"
           class="text-sm font-semibold text-amber-700 hover:text-amber-900 flex items-center gap-1.5 transition-colors duration-200 shrink-0 group">
            {{ __('site.home.offer_link') }}
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- Nieuwe website — featured card --}}
        <article class="md:col-span-2 bg-slate-900 rounded-2xl p-6 sm:p-8 flex flex-col card-lift reveal"
                 aria-label="{{ __('site.home.service_website_title') }}">
            <p class="text-[0.65rem] font-bold text-slate-500 tracking-widest mb-3">01</p>
            <h3 class="font-serif text-2xl font-medium text-white">{{ __('site.home.service_website_title') }}</h3>
            <p class="mt-3 text-sm text-slate-300 leading-relaxed mb-5 sm:mb-6 flex-1">{{ __('site.home.service_website_body') }}</p>
            @php $wBullets = is_array(__('site.home.service_website_bullets')) ? __('site.home.service_website_bullets') : []; @endphp
            @if(!empty($wBullets))
            <ul class="space-y-2 sm:space-y-2.5 mb-5 sm:mb-6" role="list">
                @foreach($wBullets as $idx => $bullet)
                <li class="flex items-center gap-2.5 text-sm text-slate-300 {{ $idx >= 3 ? 'hidden sm:flex' : '' }}">
                    <svg class="w-3.5 h-3.5 shrink-0 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ $bullet }}
                </li>
                @endforeach
            </ul>
            @endif
            <a href="{{ $servicesHref }}"
               class="self-start inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold bg-amber-500 text-white rounded-lg hover:bg-amber-400 transition-colors duration-200 cursor-pointer">
                {{ __('site.home.service_website_cta') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </article>

        {{-- Website vernieuwen --}}
        <article class="bg-white rounded-2xl border border-stone-200 p-5 sm:p-7 flex flex-col card-lift reveal reveal-delay-1"
                 aria-label="{{ __('site.home.service_redesign_title') }}">
            <p class="text-[0.65rem] font-bold text-stone-300 tracking-widest mb-3">02</p>
            <h3 class="font-serif text-xl font-medium text-slate-900">{{ __('site.home.service_redesign_title') }}</h3>
            <p class="mt-3 text-sm text-slate-500 leading-relaxed flex-1">{{ __('site.home.service_redesign_body') }}</p>
            <a href="{{ $servicesHref }}#website-vernieuwen"
               class="mt-5 sm:mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-amber-700 hover:text-amber-900 transition-colors duration-200 group cursor-pointer">
                {{ __('site.home.service_redesign_cta') }}
                <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </article>

        {{-- Onderhoud & opvolging — full-width strip --}}
        <article class="md:col-span-3 bg-stone-50 border border-stone-200 rounded-2xl px-5 py-4 sm:px-8 sm:py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-5 card-lift reveal"
                 aria-label="{{ __('site.home.service_maintenance_title') }}">
            <div>
                <p class="text-[0.65rem] font-bold text-stone-400 tracking-widest mb-1">03</p>
                <h3 class="font-serif text-lg font-medium text-slate-900">{{ __('site.home.service_maintenance_title') }}</h3>
                <p class="mt-1 text-sm text-slate-500 max-w-xl">
                    {{ __('site.home.service_maintenance_body') }}
                    <span class="font-medium text-slate-700 ml-1">{{ __('site.home.service_maintenance_price') }}</span>
                </p>
            </div>
            <a href="{{ $contactHref }}"
               class="shrink-0 self-start sm:self-auto inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold bg-white border border-stone-300 text-slate-700 rounded-lg hover:border-amber-400 hover:text-amber-800 transition-colors duration-200 cursor-pointer">
                {{ __('site.home.service_maintenance_cta') }}
            </a>
        </article>

    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════════════
     D. VOOR WIE IS DIT? — warm recognition section
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="bg-amber-50 border-y border-amber-100" aria-labelledby="voor-wie-heading">
    <div class="max-w-6xl mx-auto px-6 py-10 md:py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 items-center">
            <div class="reveal">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    {{ __('site.home.voor_wie_eyebrow') }}
                </p>
                <h2 id="voor-wie-heading" class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">
                    {{ __('site.home.voor_wie_heading') }}
                </h2>
                <p class="mt-4 text-slate-600 text-sm">{{ __('site.home.voor_wie_intro') }}</p>
            </div>
            @php $voorWieItems = is_array(__('site.home.voor_wie_items')) ? __('site.home.voor_wie_items') : []; @endphp
            <ul class="space-y-2.5 md:space-y-3.5 reveal reveal-delay-1" role="list">
                @foreach($voorWieItems as $item)
                <li class="flex items-start gap-3 text-slate-700">
                    <div class="mt-0.5 w-5 h-5 rounded-full bg-amber-200 border border-amber-300 flex items-center justify-center shrink-0" aria-hidden="true">
                        <svg class="w-3 h-3 text-amber-800" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="text-sm leading-relaxed">{{ $item }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="mt-7 md:mt-8 reveal">
            <a href="{{ $contactHref }}"
               class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-200 shadow-sm cursor-pointer">
                {{ __('site.hero.cta_primary') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════════════
     E. WAT KRIJG JE CONCREET?
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="bg-white" aria-labelledby="concreet-heading">
    <div class="max-w-6xl mx-auto px-6 py-10 md:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 items-center">
            <div class="reveal">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    {{ __('site.home.concreet_eyebrow') }}
                </p>
                <h2 id="concreet-heading" class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">
                    {{ __('site.home.concreet_heading') }}
                </h2>
                <p class="mt-3 text-sm text-slate-500 leading-relaxed max-w-sm">
                    @if($loc === 'nl')
                    Geen vage beloftes. Dit zijn de concrete dingen die je krijgt bij elke website die ik bouw.
                    @else
                    {{ __('site.home.pricing_note') }}
                    @endif
                </p>
            </div>
            @php $concreetItems = is_array(__('site.home.concreet_items')) ? __('site.home.concreet_items') : []; @endphp
            <div class="reveal reveal-delay-1">
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3" role="list">
                    @foreach($concreetItems as $item)
                    <li class="flex items-center gap-3 bg-stone-50 border border-stone-200 rounded-lg px-3 py-2.5 sm:px-4 sm:py-3 text-sm text-slate-700">
                        <svg class="w-4 h-4 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════════════
     F. WHY VAN MALDER STUDIO + XANDER PORTRAIT
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="bg-stone-50 border-y border-stone-200" aria-labelledby="xander-heading">
    <div class="max-w-6xl mx-auto px-6 py-12 md:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-x-16 lg:gap-y-8 items-start">

            {{-- 1. Text top: eyebrow + heading + intro --}}
            <div class="reveal order-1 lg:col-start-2 lg:row-start-1">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    {{ __('site.home.xander_eyebrow') }}
                </p>
                <h2 id="xander-heading" class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">
                    {{ __('site.home.xander_heading') }}
                </h2>
                <p class="mt-4 text-slate-500 leading-relaxed">
                    {{ __('site.home.xander_body') }}
                </p>
            </div>

            {{-- 2. Portrait — after intro on mobile; left col spanning both rows on desktop --}}
            <div class="reveal order-2 lg:col-start-1 lg:row-start-1 lg:row-span-2">
                <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
                    <div class="relative overflow-hidden h-56 sm:h-72 lg:h-[535px]">
                        <img src="{{ asset('images/Xander.webp') }}"
                             alt="{{ __('site.home.xander_caption') }}"
                             class="absolute inset-0 w-full h-full object-cover object-top"
                             loading="lazy"
                             width="600"
                             height="380">
                    </div>
                    <div class="px-6 py-4 flex items-center gap-3 border-t border-stone-100">
                        <div class="w-2 h-2 rounded-full bg-amber-500 shrink-0" aria-hidden="true"></div>
                        <p class="text-sm text-slate-600 font-medium">{{ __('site.home.xander_caption') }}</p>
                    </div>
                </div>
            </div>

            {{-- 3. Reason cards + CTA --}}
            <div class="order-3 lg:col-start-2 lg:row-start-2">
                <div class="space-y-3 md:space-y-4 reveal reveal-delay-1">
                    @foreach(is_array(__('site.home.why_reasons')) ? __('site.home.why_reasons') : [] as $i => $reason)
                    <div class="flex items-start gap-4 bg-white rounded-xl border border-stone-200 px-4 py-3.5 sm:px-5 sm:py-4 card-lift">
                        <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center text-xs font-bold shrink-0" aria-hidden="true">
                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-slate-900">{{ $reason['title'] }}</h3>
                            <p class="mt-0.5 text-sm text-slate-500 leading-relaxed">{{ $reason['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 reveal">
                    <a href="{{ $contactHref }}"
                       class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors duration-200 cursor-pointer shadow-sm">
                        {{ __('site.hero.cta_primary') }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════════════
     G. PRICING PREVIEW — 3 cards
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="max-w-6xl mx-auto px-6 py-12 md:py-20" aria-labelledby="pricing-heading">
    <div class="text-center mb-8 md:mb-12 reveal">
        <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
            <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
            {{ __('site.home.pricing_eyebrow') }}
        </p>
        <h2 id="pricing-heading" class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">
            {{ __('site.home.pricing_heading') }}
        </h2>
        <p class="mt-3 text-slate-500 max-w-md mx-auto leading-relaxed text-sm">
            {{ __('site.home.pricing_note') }}
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        @foreach([
            ['title' => __('site.pricing.card_starter_title'), 'price' => __('site.pricing.card_starter_price'), 'desc' => __('site.pricing.card_starter_desc'), 'highlighted' => false],
            ['title' => __('site.pricing.card_pro_title'),     'price' => __('site.pricing.card_pro_price'),     'desc' => __('site.pricing.card_pro_desc'),     'highlighted' => true],
            ['title' => __('site.pricing.card_maint_title'),   'price' => __('site.pricing.card_maint_price'),   'desc' => __('site.pricing.card_maint_desc'),   'highlighted' => false],
        ] as $plan)
        <div class="reveal card-lift">
            <x-pricing-card :title="$plan['title']" :price="$plan['price']" :description="$plan['desc']" :highlighted="$plan['highlighted']" />
        </div>
        @endforeach
    </div>

    {{-- Advice note --}}
    <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 reveal">
        <p class="text-sm text-slate-500 text-center">{{ __('site.home.pricing_advice_text') }}</p>
        <a href="{{ $contactHref }}"
           class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-amber-700 bg-amber-50 border border-amber-200 rounded-lg hover:bg-amber-100 transition-colors duration-200 cursor-pointer whitespace-nowrap">
            {{ __('site.home.pricing_advice_cta') }}
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
    <div class="text-center mt-4 space-y-1.5 reveal">
        <p class="text-xs text-slate-400">{{ __('site.home.pricing_vat_note') }}</p>
        <a href="{{ $pricingHref }}"
           class="inline-flex items-center gap-1 text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors duration-200">
            {{ __('site.home.pricing_link') }}
        </a>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════════════
     H. SIMPLE 3-STEP PROCESS
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="bg-stone-50 border-t border-stone-200" aria-labelledby="process-heading">
    <div class="max-w-6xl mx-auto px-6 py-12 md:py-16">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-8 reveal">
            <div>
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    {{ __('site.home.process_eyebrow') }}
                </p>
                <h2 id="process-heading" class="font-serif text-3xl font-medium text-slate-900 leading-tight">
                    {{ __('site.home.process_heading') }}
                </h2>
                <p class="mt-2 text-slate-500 text-sm">{{ __('site.home.process_body') }}</p>
            </div>
            <a href="{{ $processHref }}"
               class="text-sm font-semibold text-amber-700 hover:text-amber-900 flex items-center gap-1.5 transition-colors duration-200 shrink-0 group whitespace-nowrap">
                {{ __('site.home.process_link') }}
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 reveal">
            @foreach(is_array(__('site.home.home_process_steps')) ? __('site.home.home_process_steps') : [] as $step)
            <div class="bg-white rounded-xl border border-stone-200 p-5 sm:p-7 flex flex-col card-lift">
                <span class="text-3xl font-bold text-stone-200 leading-none mb-4 select-none" aria-hidden="true">{{ $step['num'] }}</span>
                <h3 class="font-serif text-base font-medium text-slate-900 mb-2">{{ $step['title'] }}</h3>
                <p class="text-sm text-slate-500 leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════════════
     I. FINAL CTA — warm and direct
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="max-w-6xl mx-auto px-6 py-10 md:py-16 pb-12 md:pb-20" aria-labelledby="cta-heading">
    <div class="relative bg-slate-900 rounded-2xl overflow-hidden">
        <div class="absolute inset-0" style="background:linear-gradient(135deg,#0f172a 0%,#1c2f4a 55%,#0f172a 100%)" aria-hidden="true"></div>
        <div class="absolute top-0 left-0 right-0 h-px" style="background:linear-gradient(90deg,transparent,#c49a3a 50%,transparent)" aria-hidden="true"></div>
        <div class="relative px-6 py-10 md:px-14 md:py-20 text-center">
            <h2 id="cta-heading" class="font-serif text-3xl md:text-4xl font-medium text-white leading-tight max-w-2xl mx-auto">
                {{ __('site.home.cta_heading') }}
            </h2>
            <p class="mt-4 text-slate-300 max-w-lg mx-auto leading-relaxed">
                {{ __('site.home.cta_body') }}
            </p>
            <div class="mt-7 md:mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ $contactHref }}"
                   class="inline-flex items-center gap-2 px-6 py-3.5 text-sm font-semibold bg-amber-500 text-white rounded-lg hover:bg-amber-400 transition-colors duration-200 cursor-pointer shadow-sm">
                    {{ __('site.home.cta_primary') }}
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ $servicesHref }}"
                   class="inline-flex items-center px-6 py-3.5 text-sm font-semibold text-slate-300 border border-slate-700 rounded-lg hover:border-slate-500 hover:text-white transition-colors duration-200 cursor-pointer">
                    {{ __('site.hero.cta_secondary') }}
                </a>
            </div>
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════════════
     J. LOCAL PAGES STRIP — SEO internal links (Dutch only, premium pills)
     ════════════════════════════════════════════════════════════════════════ --}}
@if($loc === 'nl')
<section class="border-t border-stone-200 bg-stone-50" aria-label="Lokale diensten in de Druivenstreek">
    <div class="max-w-6xl mx-auto px-6 py-7">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Lokaal in de Druivenstreek &amp; Vlaams-Brabant</p>
        <div class="flex flex-wrap gap-2">
            <a href="/nl/website-laten-maken-tervuren"
               class="inline-flex items-center text-xs font-medium text-slate-600 bg-white border border-stone-200 rounded-full px-3 py-1.5 hover:border-amber-300 hover:text-amber-800 transition-colors duration-200">
                Website laten maken in Tervuren
            </a>
            <a href="/nl/website-laten-maken-vlaams-brabant"
               class="inline-flex items-center text-xs font-medium text-slate-600 bg-white border border-stone-200 rounded-full px-3 py-1.5 hover:border-amber-300 hover:text-amber-800 transition-colors duration-200">
                Vlaams-Brabant
            </a>
            <a href="/nl/webdesigner-tervuren"
               class="inline-flex items-center text-xs font-medium text-slate-600 bg-white border border-stone-200 rounded-full px-3 py-1.5 hover:border-amber-300 hover:text-amber-800 transition-colors duration-200">
                Webdesigner in Tervuren
            </a>
            <a href="/nl/website-laten-maken-overijse"
               class="inline-flex items-center text-xs font-medium text-slate-600 bg-white border border-stone-200 rounded-full px-3 py-1.5 hover:border-amber-300 hover:text-amber-800 transition-colors duration-200">
                Website laten maken in Overijse
            </a>
            <a href="/nl/website-laten-maken-huldenberg"
               class="inline-flex items-center text-xs font-medium text-slate-600 bg-white border border-stone-200 rounded-full px-3 py-1.5 hover:border-amber-300 hover:text-amber-800 transition-colors duration-200">
                Website laten maken in Huldenberg
            </a>
        </div>
    </div>
</section>
@endif

</x-layouts.app>
