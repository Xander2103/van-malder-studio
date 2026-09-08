@php
    // Cookie / consent banner — rendered hidden; resources/js/consent.js shows it only when
    // no saved choice exists (cookie "vms_consent"). No dark patterns: Accept and Reject are equal.
    $ccLocale  = app()->getLocale() ?: 'nl';
    $ccPrivacy = \Illuminate\Support\Facades\Route::has($ccLocale . '.privacy') ? route($ccLocale . '.privacy') : route('privacy');
    $ccBtn     = 'inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold rounded-lg transition-colors duration-200 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2';
@endphp
<div id="cookie-consent"
     class="fixed inset-x-0 bottom-0 z-40 p-4 sm:inset-x-auto sm:left-6 sm:bottom-6 sm:p-0 sm:max-w-md consent-enter"
     role="region"
     aria-labelledby="cookie-consent-title"
     data-consent-banner
     hidden>
    <div class="relative bg-white rounded-2xl border border-stone-200 shadow-xl shadow-slate-900/10 overflow-y-auto max-h-[calc(100dvh-2rem)] sm:max-h-[calc(100dvh-3rem)]">
        <div class="absolute top-0 left-0 right-0 h-px studio-card-accent" aria-hidden="true"></div>

        {{-- Panel 1: notice --}}
        <div class="p-5 sm:p-6" data-consent-panel="notice">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-2">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                {{ __('site.consent.eyebrow') }}
            </p>
            <h2 id="cookie-consent-title" class="font-serif text-lg font-medium text-slate-900 leading-snug">{{ __('site.consent.title') }}</h2>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                {{ __('site.consent.body') }}
                <a href="{{ $ccPrivacy }}" class="font-medium text-slate-800 underline decoration-stone-300 underline-offset-2 hover:text-amber-800 hover:decoration-amber-400 transition-colors duration-200">{{ __('site.consent.privacy_link') }}</a>
            </p>
            <div class="mt-5 flex flex-wrap items-center gap-2">
                <button type="button" data-consent-action="accept" class="{{ $ccBtn }} bg-slate-900 text-white hover:bg-blue-800">
                    {{ __('site.consent.accept') }}
                </button>
                <button type="button" data-consent-action="reject" class="{{ $ccBtn }} bg-white border border-stone-300 text-slate-700 hover:border-slate-400 hover:text-slate-900">
                    {{ __('site.consent.reject') }}
                </button>
                <button type="button" data-consent-action="preferences" class="{{ $ccBtn }} text-slate-600 hover:text-slate-900 px-2">
                    {{ __('site.consent.preferences') }}
                </button>
            </div>
        </div>

        {{-- Panel 2: preferences (same card, no modal, no focus trap) --}}
        <div class="p-5 sm:p-6" data-consent-panel="preferences" hidden>
            <h2 class="font-serif text-lg font-medium text-slate-900 leading-snug">{{ __('site.consent.preferences_title') }}</h2>
            <p class="mt-1.5 text-sm text-slate-600 leading-relaxed">{{ __('site.consent.preferences_body') }}</p>

            <ul class="mt-4 space-y-2.5" role="list">
                <li class="flex items-start gap-3 rounded-xl border border-stone-200 bg-stone-50 p-3.5">
                    <input type="checkbox" id="consent-essential" checked disabled class="mt-1 h-4 w-4 rounded border-stone-300 text-slate-900 shrink-0">
                    <label for="consent-essential" class="text-sm">
                        <span class="block font-semibold text-slate-800">{{ __('site.consent.essential_label') }}</span>
                        <span class="block text-slate-500 leading-relaxed">{{ __('site.consent.essential_desc') }}</span>
                    </label>
                </li>
                <li class="flex items-start gap-3 rounded-xl border border-stone-200 p-3.5">
                    <input type="checkbox" id="consent-analytics" data-consent-category="analytics" class="mt-1 h-4 w-4 rounded border-stone-300 text-slate-900 shrink-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                    <label for="consent-analytics" class="text-sm cursor-pointer">
                        <span class="block font-semibold text-slate-800">{{ __('site.consent.analytics_label') }}</span>
                        <span class="block text-slate-500 leading-relaxed">{{ __('site.consent.analytics_desc') }}</span>
                    </label>
                </li>
                <li class="flex items-start gap-3 rounded-xl border border-stone-200 p-3.5">
                    <input type="checkbox" id="consent-ads" data-consent-category="ads" class="mt-1 h-4 w-4 rounded border-stone-300 text-slate-900 shrink-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                    <label for="consent-ads" class="text-sm cursor-pointer">
                        <span class="block font-semibold text-slate-800">{{ __('site.consent.ads_label') }}</span>
                        <span class="block text-slate-500 leading-relaxed">{{ __('site.consent.ads_desc') }}</span>
                    </label>
                </li>
            </ul>

            <div class="mt-5 flex flex-wrap items-center gap-2">
                <button type="button" data-consent-action="save" class="{{ $ccBtn }} bg-slate-900 text-white hover:bg-blue-800">
                    {{ __('site.consent.save') }}
                </button>
                <button type="button" data-consent-action="reject" class="{{ $ccBtn }} bg-white border border-stone-300 text-slate-700 hover:border-slate-400 hover:text-slate-900">
                    {{ __('site.consent.reject') }}
                </button>
                <button type="button" data-consent-action="back" class="{{ $ccBtn }} text-slate-600 hover:text-slate-900 px-2">
                    {{ __('site.consent.back') }}
                </button>
            </div>
        </div>
    </div>
</div>
