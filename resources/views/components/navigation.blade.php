@php
    $locale = app()->getLocale() ?: 'nl';

    $links = [
        ['route' => 'services',  'label' => __('site.nav.services')],
        ['route' => 'showcase',  'label' => __('site.nav.showcase')],
        ['route' => 'process',   'label' => __('site.nav.process')],
        ['route' => 'pricing',   'label' => __('site.nav.pricing')],
        ['route' => 'about',     'label' => __('site.nav.about')],
    ];

    // Resolve locale-aware route name for a given link
    if (!function_exists('navRoute')) {
        function navRoute(string $name, string $locale): string {
            $localeName = $locale . '.' . $name;
            return Route::has($localeName) ? route($localeName) : route($name);
        }
    }

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
@endphp
<header class="fixed top-0 inset-x-0 z-50 bg-stone-50/95 backdrop-blur-md border-b border-stone-200/80">
    <nav class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between" aria-label="Hoofdnavigatie">
        <a href="{{ navRoute('home', $locale) }}"
           class="font-serif text-[1.05rem] font-medium text-slate-900 tracking-tight hover:text-blue-700 transition-colors duration-200 inline-flex items-center gap-2"
           aria-label="{{ config('studio.brand_name') }} — homepage">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="shrink-0 nav-vm-mark">
                <circle cx="12" cy="12" r="10.5" stroke="#c49a3a" stroke-width="1"/>
                <text x="12" y="16.5" text-anchor="middle" font-family="'Instrument Serif', Georgia, serif" font-size="9.5" fill="#c49a3a">VM</text>
            </svg>
            <span>Van Malder Studio</span>
        </a>

        {{-- Desktop nav --}}
        <ul class="hidden md:flex items-center gap-5" role="list">
            @foreach($links as $link)
            <li>
                <a href="{{ navRoute($link['route'], $locale) }}"
                   class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs($locale . '.' . $link['route']) || request()->routeIs($link['route']) ? 'text-slate-900' : 'text-slate-500 hover:text-slate-800' }}">
                    {{ $link['label'] }}
                </a>
            </li>
            @endforeach
        </ul>

        <div class="hidden md:flex items-center gap-3">

            {{-- Language switcher --}}
            <div class="flex items-center gap-0.5" role="navigation" aria-label="Taalwissel">
                @foreach(['nl' => 'NL', 'fr' => 'FR', 'en' => 'EN', 'de' => 'DE'] as $lang => $label)
                <a href="{{ $langLinks[$lang] }}"
                   class="px-2 py-1 text-[0.7rem] font-semibold rounded transition-colors duration-150 {{ $locale === $lang ? 'text-slate-900 bg-stone-200' : 'text-slate-400 hover:text-slate-700' }}"
                   hreflang="{{ $lang }}"
                   aria-current="{{ $locale === $lang ? 'true' : 'false' }}"
                   aria-label="{{ match($lang) { 'nl' => 'Nederlands', 'fr' => 'Français', 'en' => 'English', 'de' => 'Deutsch', default => $lang } }}">
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

        {{-- Mobile hamburger --}}
        <button id="nav-toggle"
                type="button"
                class="md:hidden p-2 rounded-md text-slate-500 hover:text-slate-900 hover:bg-stone-100 transition-colors duration-200 cursor-pointer"
                aria-controls="mobile-menu"
                aria-expanded="false"
                aria-label="Menu openen">
            <svg id="icon-open" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg id="icon-close" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </nav>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden md:hidden border-t border-stone-200 bg-stone-50" role="dialog" aria-label="Mobiel menu">
        <ul class="max-w-6xl mx-auto px-4 py-3 flex flex-col gap-0.5" role="list">
            @foreach($links as $link)
            <li>
                <a href="{{ navRoute($link['route'], $locale) }}"
                   class="block px-3 py-2.5 text-sm font-medium rounded-md transition-colors duration-200 {{ request()->routeIs($locale . '.' . $link['route']) || request()->routeIs($link['route']) ? 'text-slate-900 bg-stone-100' : 'text-slate-600 hover:bg-stone-100 hover:text-slate-900' }}">
                    {{ $link['label'] }}
                </a>
            </li>
            @endforeach

            {{-- Mobile language switcher --}}
            <li class="pt-2 mt-1 border-t border-stone-200">
                <div class="flex items-center gap-2 px-3 py-2" aria-label="Taalwissel">
                    @foreach(['nl' => 'NL', 'fr' => 'FR', 'en' => 'EN', 'de' => 'DE'] as $lang => $label)
                    <a href="{{ $langLinks[$lang] }}"
                       class="px-2.5 py-1 text-xs font-semibold rounded border transition-colors duration-150 {{ $locale === $lang ? 'bg-slate-900 text-white border-slate-900' : 'text-slate-500 border-stone-200 hover:border-slate-400 hover:text-slate-700' }}"
                       hreflang="{{ $lang }}"
                       aria-current="{{ $locale === $lang ? 'true' : 'false' }}">
                        {{ $label }}
                    </a>
                    @endforeach
                </div>
            </li>

            <li class="pt-1">
                <a href="{{ navRoute('contact', $locale) }}"
                   class="block px-3 py-2.5 text-sm font-semibold text-white bg-slate-900 rounded-md hover:bg-blue-800 transition-colors duration-200 text-center cursor-pointer">
                    {{ __('site.nav.contact') }}
                </a>
            </li>
        </ul>
    </div>
</header>
<div class="h-16" aria-hidden="true"></div>
