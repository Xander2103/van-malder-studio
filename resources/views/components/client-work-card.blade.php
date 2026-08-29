@props(['work', 'servicesHref'])

@php
    // Client work card - a real website built through Van Malder Studio.
    // $work comes from config/client-work.php; all visible copy comes from the
    // site.client_work.items.{slug} translation group. The visual header is a
    // screenshot of the live site, cropped 16:9 from the top so all cards line
    // up; an entry without a screenshot falls back to a neutral empty panel of
    // the same size, so the grid never shifts.
    $translationKey = 'site.client_work.items.' . $work['slug'];
    $t              = __($translationKey);
    $isArray        = is_array($t);

    $sector     = $isArray ? ($t['sector'] ?? $work['sector']) : $work['sector'];
    $desc       = $isArray ? ($t['description'] ?? '') : '';
    $highlights = $isArray && is_array($t['highlights'] ?? null) ? $t['highlights'] : [];
    $service    = $isArray ? ($t['service'] ?? null) : null;
    $alt        = ($isArray && !empty($t['alt']))
        ? $t['alt']
        : __('site.client_work.preview_alt', ['name' => $work['title']]);

    $headingId  = 'client-work-' . $work['slug'] . '-heading';
    $hasImage   = !empty($work['image']) && file_exists(public_path($work['image']));
@endphp

<article class="bg-white rounded-xl border border-stone-200 overflow-hidden flex flex-col card-lift reveal h-full"
         aria-labelledby="{{ $headingId }}">

    {{-- Visual header: screenshot of the live website, cropped 16:9 from the top
         so each site's own header stays visible and all three cards line up. --}}
    <div class="relative">
        @if($hasImage)
        <a href="{{ $work['url'] }}" target="_blank" rel="noopener noreferrer" tabindex="-1"
           class="block aspect-[16/9] overflow-hidden border-b border-stone-200 bg-stone-100">
            <img src="{{ asset($work['image']) }}"
                 alt="{{ $alt }}"
                 class="w-full h-full object-cover object-top"
                 loading="lazy"
                 decoding="async"
                 width="1600"
                 height="900">
        </a>
        @else
        <div class="aspect-[16/9] bg-stone-100 border-b border-stone-200" aria-hidden="true"></div>
        @endif

        {{-- Sector badge --}}
        <span class="absolute top-3 left-3 text-[0.65rem] font-semibold px-2.5 py-1 rounded-full bg-white/95 text-slate-700 border border-stone-200 shadow-sm backdrop-blur">
            {{ $sector }}
        </span>
    </div>

    {{-- Content --}}
    <div class="p-6 flex flex-col flex-1">
        <h3 id="{{ $headingId }}" class="font-serif text-xl font-medium text-slate-900 leading-snug">{{ $work['title'] }}</h3>
        <p class="mt-2.5 text-sm text-slate-600 leading-relaxed">{{ $desc }}</p>

        @if($highlights)
        <h4 class="mt-5 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('site.client_work.highlights_heading') }}</h4>
        <ul class="space-y-1.5" role="list">
            @foreach($highlights as $point)
            <li class="flex items-start gap-2.5 text-sm text-slate-600 leading-relaxed">
                <span class="mt-2 w-1.5 h-1.5 rounded-full bg-amber-600 shrink-0" aria-hidden="true"></span>
                <span>{{ $point }}</span>
            </li>
            @endforeach
        </ul>
        @endif

        {{-- Footer: external link + related service (pushed to the bottom for equal card heights) --}}
        <div class="mt-auto pt-6">
            <div class="border-t border-stone-100 pt-4">
                <a href="{{ $work['url'] }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="{{ __('site.client_work.visit_aria', ['name' => $work['title']]) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                    {{ __('site.client_work.visit') }}
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5h5m0 0v5m0-5L10 14"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 14v4a1 1 0 01-1 1H6a1 1 0 01-1-1V6a1 1 0 011-1h4"/>
                    </svg>
                </a>
                @if($service)
                <a href="{{ $servicesHref }}#{{ $work['service_slug'] }}"
                   class="block mt-3 text-xs font-medium text-slate-500 hover:text-amber-800 transition-colors duration-200">
                    <span class="sr-only">{{ __('site.client_work.related_service') }}</span>{{ $service }} →
                </a>
                @endif
            </div>
        </div>
    </div>
</article>
