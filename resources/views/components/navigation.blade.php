@php
    $locale = app()->getLocale() ?: 'nl';

    // Resolve locale-aware route name for a given link
    if (!function_exists('navRoute')) {
        function navRoute(string $name, string $locale): string {
            $localeName = $locale . '.' . $name;
            return Route::has($localeName) ? route($localeName) : route($name);
        }
    }

    // 'anchor' links point at a section on another page (no separate route yet).
    $links = [
        ['route' => 'services',  'label' => __('site.nav.services')],
        ['route' => 'process',   'label' => __('site.nav.process')],
        ['route' => 'pricing',   'label' => __('site.nav.pricing')],
        ['route' => 'about',     'label' => __('site.nav.about')],
        ['route' => 'about',     'label' => __('site.nav.work'), 'anchor' => 'client-work'],
    ];

    foreach ($links as &$link) {
        $link['href']   = navRoute($link['route'], $locale) . (isset($link['anchor']) ? '#' . $link['anchor'] : '');
        // Anchor links never claim the "current page" state — the page link already does.
        $link['active'] = !isset($link['anchor'])
            && (request()->routeIs($locale . '.' . $link['route']) || request()->routeIs($link['route']));
    }
    unset($link);

    // Determine the equivalent page name for the language switcher
    $routeName = request()->route()?->getName() ?? '';
    $parts     = explode('.', $routeName);
    $baseName  = count($parts) > 1 ? implode('.', array_slice($parts, 1)) : ($parts[0] ?? 'home');
    if (in_array($baseName, ['landing', 'inquiries.store', 'home', ''])) $baseName = 'home';

    $langLinks = [];
    foreach (['nl', 'fr', 'en', 'de'] as $lang) {
        $key = $lang . '.' . $baseName;
        $langLinks[$lang] = Route::has($key) ? route($key) : route($lang . '.home');
    }

    $langLabels = ['nl' => 'Nederlands', 'fr' => 'Français', 'en' => 'English', 'de' => 'Deutsch'];
@endphp

<header class="fixed top-0 inset-x-0 z-50 bg-stone-50/95 backdrop-blur-md border-b border-stone-200/80">
    <nav class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between" aria-label="Hoofdnavigatie">

        {{-- Logo --}}
        <a href="{{ navRoute('home', $locale) }}"
           class="font-serif text-[1.05rem] font-medium text-slate-900 tracking-tight hover:text-blue-700 transition-colors duration-200 inline-flex items-center gap-2"
           aria-label="{{ config('studio.brand_name') }} — homepage">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="shrink-0 nav-vm-mark">
                <circle cx="12" cy="12" r="10.5" stroke="#c49a3a" stroke-width="1"/>
                <text x="12" y="16.5" text-anchor="middle" font-family="'Instrument Serif', Georgia, serif" font-size="9.5" fill="#c49a3a">VM</text>
            </svg>
            <span>Van Malder Studio</span>
        </a>

        {{-- Desktop: nav links --}}
        <ul class="hidden md:flex items-center gap-5" role="list">
            @foreach($links as $link)
            <li>
                <a href="{{ $link['href'] }}"
                   class="text-sm font-medium transition-colors duration-200 {{ $link['active'] ? 'text-slate-900' : 'text-slate-500 hover:text-slate-800' }}"
                   @if($link['active']) aria-current="page" @endif>
                    {{ $link['label'] }}
                </a>
            </li>
            @endforeach
        </ul>

        {{-- Desktop: language switcher + contact --}}
        <div class="hidden md:flex items-center gap-3">
            <div class="flex items-center gap-0.5" role="navigation" aria-label="{{ __('site.lang_switcher.label') }}">
                @foreach(['nl' => 'NL', 'fr' => 'FR', 'en' => 'EN', 'de' => 'DE'] as $lang => $label)
                <a href="{{ $langLinks[$lang] }}"
                   class="px-2 py-1 text-[0.7rem] font-semibold rounded transition-colors duration-150 {{ $locale === $lang ? 'text-slate-900 bg-stone-200' : 'text-slate-400 hover:text-slate-700' }}"
                   hreflang="{{ $lang }}"
                   aria-current="{{ $locale === $lang ? 'true' : 'false' }}"
                   aria-label="{{ $langLabels[$lang] ?? $lang }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            <a href="{{ navRoute('contact', $locale) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                {{ __('site.nav.contact') }}
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        {{-- Mobile: language dropdown + hamburger --}}
        <div class="flex items-center gap-1.5 md:hidden">

            {{-- Compact language dropdown --}}
            <div class="relative" id="lang-switcher-mobile">
                <button id="lang-toggle"
                        type="button"
                        class="flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-slate-700 bg-stone-100 border border-stone-200 rounded-md hover:bg-stone-200/70 transition-colors duration-150 cursor-pointer"
                        aria-expanded="false"
                        aria-controls="lang-dropdown"
                        aria-haspopup="true"
                        aria-label="{{ __('site.lang_switcher.label') }}: {{ strtoupper($locale) }}">
                    <span>{{ strtoupper($locale) }}</span>
                    <svg class="w-3 h-3 text-slate-400 shrink-0 transition-transform duration-150" id="lang-toggle-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <nav id="lang-dropdown"
                     class="lang-dropdown absolute right-0 top-full mt-1.5 bg-white border border-stone-200/80 rounded-lg shadow-lg py-1.5 z-10"
                     aria-label="{{ __('site.lang_switcher.label') }}">
                    @foreach(['nl' => 'NL', 'fr' => 'FR', 'en' => 'EN', 'de' => 'DE'] as $lang => $label)
                    <a href="{{ $langLinks[$lang] }}"
                       class="flex items-center justify-between px-3.5 py-2 text-xs font-semibold tracking-wider whitespace-nowrap transition-colors duration-100 {{ $locale === $lang ? 'text-slate-900 bg-stone-50' : 'text-slate-500 hover:text-slate-900 hover:bg-stone-50' }}"
                       hreflang="{{ $lang }}"
                       aria-current="{{ $locale === $lang ? 'true' : 'false' }}"
                       aria-label="{{ $langLabels[$lang] ?? $lang }}">
                        {{ $label }}
                        @if($locale === $lang)
                        <span class="w-1 h-1 rounded-full shrink-0 ml-2" style="background:#c49a3a" aria-hidden="true"></span>
                        @endif
                    </a>
                    @endforeach
                </nav>
            </div>

            {{-- Hamburger --}}
            <button id="nav-toggle"
                    type="button"
                    class="p-2 rounded-md text-slate-500 hover:text-slate-900 hover:bg-stone-100 transition-colors duration-200 cursor-pointer"
                    aria-controls="mobile-menu"
                    aria-expanded="false"
                    aria-label="{{ __('site.nav.open_menu') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

    </nav>
</header>

{{-- ── Mobile menu overlay ─────────────────────────────────────────────────── --}}
{{-- Full-screen fixed overlay. Language switching is now in the header button. --}}
<div id="mobile-menu"
     class="mobile-nav-overlay"
     role="dialog"
     aria-modal="true"
     aria-label="{{ __('site.nav.menu_label') }}">

    {{-- Top bar: logo + close --}}
    <div class="flex items-center justify-between px-6 h-16 border-b border-stone-200/60 shrink-0">
        <a href="{{ navRoute('home', $locale) }}"
           class="font-serif text-[1.05rem] font-medium text-slate-900 tracking-tight inline-flex items-center gap-2"
           aria-label="{{ config('studio.brand_name') }} — homepage"
           tabindex="-1">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="shrink-0">
                <circle cx="12" cy="12" r="10.5" stroke="#c49a3a" stroke-width="1"/>
                <text x="12" y="16.5" text-anchor="middle" font-family="'Instrument Serif', Georgia, serif" font-size="9.5" fill="#c49a3a">VM</text>
            </svg>
            <span>Van Malder Studio</span>
        </a>

        <button id="mobile-menu-close"
                type="button"
                class="p-2 rounded-md text-slate-400 hover:text-slate-800 hover:bg-stone-100 transition-colors duration-200 cursor-pointer"
                aria-label="{{ __('site.nav.close_menu') }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Navigation links --}}
    <nav class="px-6 pt-5 pb-1" aria-label="{{ __('site.nav.menu_label') }}">
        <ul class="flex flex-col" role="list">
            @foreach($links as $link)
            @php $isActive = $link['active']; @endphp
            <li>
                <a href="{{ $link['href'] }}"
                   class="flex items-center justify-between py-3.5 border-b border-stone-100 last:border-b-0 transition-colors duration-200 {{ $isActive ? 'text-slate-900' : 'text-slate-500 hover:text-slate-900' }}"
                   @if($isActive) aria-current="page" @endif>
                    <span class="font-serif text-[1.35rem] font-normal leading-snug">{{ $link['label'] }}</span>
                    @if($isActive)
                    <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background:#c49a3a" aria-hidden="true"></span>
                    @endif
                </a>
            </li>
            @endforeach
        </ul>
    </nav>

    {{-- CTA + supporting meta (language switching is now in header) --}}
    <div class="px-6 pt-5 pb-8 border-t border-stone-200/60 flex flex-col gap-4">

        {{-- CTA — one strong primary, one quiet secondary --}}
        <div class="flex flex-col gap-2">
            <a href="{{ navRoute('contact', $locale) }}"
               class="flex items-center justify-center gap-2 w-full px-6 py-3.5 text-sm font-semibold bg-slate-900 text-white rounded-xl hover:bg-blue-800 transition-colors duration-200 cursor-pointer">
                {{ __('site.nav.mobile_cta') }}
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>

            <a href="{{ navRoute('services', $locale) }}"
               class="text-center text-[0.8125rem] font-medium text-slate-400 hover:text-slate-700 transition-colors duration-200 py-1.5">
                {{ __('site.nav.cta_secondary') }}
            </a>
        </div>

        {{-- Supporting meta --}}
        <p class="text-[0.6875rem] text-slate-400 leading-relaxed">
            {{ __('site.nav.mobile_tagline') }}<span class="mx-1.5 text-stone-300" aria-hidden="true">·</span>{{ __('site.nav.mobile_price') }}
        </p>
    </div>
</div>

<div class="h-16" aria-hidden="true"></div>
