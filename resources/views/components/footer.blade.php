@php
    $locale         = app()->getLocale() ?: 'nl';
    $footerHomeHref = \Illuminate\Support\Facades\Route::has($locale . '.home')    ? route($locale . '.home')    : route('home');
    $footerContactHref = \Illuminate\Support\Facades\Route::has($locale . '.contact') ? route($locale . '.contact') : route('contact');
    $footerPrivacyHref = \Illuminate\Support\Facades\Route::has($locale . '.privacy') ? route($locale . '.privacy') : route('privacy');

    $footerNav = [
        ['key' => 'services',  'label' => __('site.nav.services')],
        ['key' => 'showcase',  'label' => __('site.nav.showcase_footer')],
        ['key' => 'process',   'label' => __('site.nav.process')],
        ['key' => 'pricing',   'label' => __('site.nav.pricing')],
        ['key' => 'about',     'label' => __('site.nav.about')],
        ['key' => 'privacy',   'label' => __('site.footer.privacy_label')],
    ];

    // Primary region — Tervuren / Druivenstreek. Order matters: first focus first.
    $footerLocal = [
        ['href' => '/nl/website-laten-maken-tervuren',   'label' => 'Website laten maken in Tervuren'],
        ['href' => '/nl/website-laten-maken-duisburg',   'label' => 'Website laten maken in Duisburg'],
        ['href' => '/nl/website-laten-maken-overijse',   'label' => 'Website laten maken in Overijse'],
        ['href' => '/nl/website-laten-maken-hoeilaart',  'label' => 'Website laten maken in Hoeilaart'],
        ['href' => '/nl/website-laten-maken-huldenberg', 'label' => 'Website laten maken in Huldenberg'],
        ['href' => '/nl/website-laten-maken-bertem',     'label' => 'Website laten maken in Bertem'],
    ];

    // Secondary regions and service variants — linked, but not the first focus.
    $footerLocalSecondary = [
        ['href' => '/nl/webdesigner-tervuren',              'label' => 'Webdesigner in Tervuren'],
        ['href' => '/nl/website-laten-maken-leuven',        'label' => 'Leuven'],
        ['href' => '/nl/website-laten-maken-vlaams-brabant', 'label' => 'Vlaams-Brabant'],
    ];
@endphp
<footer class="bg-slate-900 text-slate-300">
    <div class="max-w-6xl mx-auto px-6 pt-10 pb-6 md:pt-16 md:pb-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-10 pb-7 md:pb-12 border-b border-slate-800">

            {{-- Brand column --}}
            <div class="md:col-span-4">
                <a href="{{ $footerHomeHref }}" class="font-serif text-lg font-medium text-white hover:text-blue-400 transition-colors duration-200">
                    Van Malder Studio
                </a>
                <p class="mt-2 text-sm leading-snug text-slate-400 max-w-xs">
                    {{ __('site.footer.description') ?: config('studio.positioning') }}
                </p>
                <p class="mt-1.5 text-xs text-slate-500 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ config('studio.location') }}
                </p>
            </div>

            {{-- Nav column — Studio links + Lokaal in 2-col grid on mobile --}}
            <div class="md:col-span-3 md:col-start-6">
                <div class="{{ $locale === 'nl' ? 'grid grid-cols-2 md:grid-cols-1 gap-5 md:gap-0' : '' }}">

                    {{-- Studio nav links --}}
                    <div>
                        <h3 class="text-xs font-semibold text-white uppercase tracking-wider mb-3 md:mb-4">{{ __('site.footer.studio_label') }}</h3>
                        <ul class="space-y-2 md:space-y-2.5" role="list">
                            @foreach($footerNav as $link)
                            @php
                                $href = \Illuminate\Support\Facades\Route::has($locale . '.' . $link['key'])
                                    ? route($locale . '.' . $link['key'])
                                    : route($link['key']);
                            @endphp
                            <li class="{{ $link['key'] === 'showcase' ? 'hidden md:block' : '' }}">
                                <a href="{{ $href }}" class="text-sm text-slate-400 hover:text-white transition-colors duration-200">
                                    {{ $link['label'] }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Lokaal links — NL only, beside Studio on mobile, below on desktop.
                         Primary region first (Druivenstreek), secondary regions on one compact line. --}}
                    @if($locale === 'nl')
                    <div class="md:mt-6 md:pt-5 md:border-t md:border-slate-800">
                        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Lokaal</h3>
                        <ul class="space-y-2" role="list">
                            @foreach($footerLocal as $local)
                            <li><a href="{{ $local['href'] }}" class="text-sm text-slate-500 hover:text-white transition-colors duration-200">{{ $local['label'] }}</a></li>
                            @endforeach
                        </ul>
                        <p class="mt-3 text-xs text-slate-600 leading-relaxed">
                            @foreach($footerLocalSecondary as $local)
                            <a href="{{ $local['href'] }}" class="hover:text-slate-400 transition-colors duration-200">{{ $local['label'] }}</a>@if(! $loop->last)<span aria-hidden="true"> · </span>@endif
                            @endforeach
                        </p>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Contact column --}}
            <div class="md:col-span-3">
                <h3 class="text-xs font-semibold text-white uppercase tracking-wider mb-3 md:mb-4">{{ __('site.nav.contact') }}</h3>
                <p class="text-sm text-slate-400 leading-snug mb-3">
                    {{ __('site.footer.contact_cta') }}
                </p>
                <a href="{{ $footerContactHref }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold bg-blue-700 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 cursor-pointer">
                    {{ __('site.footer.contact_btn') }}
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <p class="mt-3">
                    <a href="mailto:{{ config('studio.email') }}" class="text-sm text-slate-500 hover:text-slate-300 transition-colors duration-200">
                        {{ config('studio.email') }}
                    </a>
                </p>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="pt-5 md:pt-6 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-slate-600">
            <p>&copy; {{ date('Y') }} {{ config('studio.brand_name') }}. {{ __('site.footer.rights') }}</p>
            <div class="flex items-center gap-3">
                <a href="{{ $footerPrivacyHref }}" class="hover:text-slate-400 transition-colors duration-200">{{ __('site.footer.privacy_label') }}</a>
                <span aria-hidden="true">·</span>
                <p>{{ config('studio.tagline') }}</p>
            </div>
        </div>
    </div>
</footer>
