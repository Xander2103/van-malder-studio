@props(['contactHref' => null, 'servicesHref' => null, 'showProof' => true])

@php
    // Supporting section: custom systems, integrations and automation sit *behind*
    // the website offer, never in front of it. Proof links to a real project.
    $mtwLocale     = app()->getLocale() ?: 'nl';
    $mtwItems      = is_array(__('site.more_than_website.items')) ? __('site.more_than_website.items') : [];
    $mtwClientWork = \Illuminate\Support\Facades\Route::has($mtwLocale . '.clientwork')
        ? route($mtwLocale . '.clientwork')
        : ($servicesHref ?? '#');
@endphp

<section class="bg-stone-100 border-y border-stone-200" aria-labelledby="more-than-website-heading">
    <div class="max-w-6xl mx-auto px-6 py-14 md:py-16 reveal">

        <div class="max-w-2xl">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                {{ __('site.more_than_website.eyebrow') }}
            </p>
            <h2 id="more-than-website-heading" class="font-serif text-2xl md:text-3xl font-medium text-slate-900 leading-tight">
                {{ __('site.more_than_website.heading') }}
            </h2>
            <p class="mt-3 text-slate-600 leading-relaxed">{{ __('site.more_than_website.body') }}</p>
        </div>

        @if($mtwItems)
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach($mtwItems as $item)
            <div class="bg-white border border-stone-200 rounded-xl p-5">
                <h3 class="text-sm font-semibold text-slate-900">{{ $item['title'] }}</h3>
                <p class="mt-1.5 text-sm text-slate-500 leading-relaxed">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
        @endif

        <div class="mt-6 flex flex-col sm:flex-row sm:items-center gap-x-6 gap-y-2">
            <p class="text-xs font-medium text-slate-500">{{ __('site.more_than_website.price_note') }}</p>
            @if($showProof)
            <a href="{{ $mtwClientWork }}#project-mastechnics"
               class="text-xs font-semibold text-amber-700 hover:text-amber-900 transition-colors duration-200 inline-flex items-center gap-1.5">
                {{ __('site.more_than_website.proof_link') }}
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            @endif
        </div>

        @if($showProof)
        <p class="mt-3 text-sm text-slate-500 leading-relaxed max-w-2xl">{{ __('site.more_than_website.proof') }}</p>
        @endif
    </div>
</section>
