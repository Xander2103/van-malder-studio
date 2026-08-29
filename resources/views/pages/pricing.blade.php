<x-layouts.app
    :title="__('site.seo.pricing_title')"
    :description="__('site.seo.pricing_desc')"
    :ogTitle="__('site.seo.pricing_og_title')"
>

    {{-- Header --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-12">
        <div class="reveal">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                {{ __('site.pricing.eyebrow') }}
            </p>
            <h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">{{ __('site.pricing.heading') }}</h1>
            <p class="mt-4 text-lg text-slate-500 leading-relaxed max-w-2xl">
                {{ __('site.pricing.body') }}
            </p>
        </div>
    </section>

    {{-- Pricing cards --}}
    <section class="max-w-6xl mx-auto px-6 pb-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 reveal">
            <x-pricing-card
                :title="__('site.pricing.card_starter_title')"
                :price="__('site.pricing.card_starter_price')"
                :description="__('site.pricing.card_starter_desc')"
                :bullets="__('site.pricing.card_starter_bullets')"
                :cta="__('site.pricing.card_starter_cta')"
            />
            <x-pricing-card
                :title="__('site.pricing.card_pro_title')"
                :price="__('site.pricing.card_pro_price')"
                :description="__('site.pricing.card_pro_desc')"
                :highlighted="true"
                :bullets="__('site.pricing.card_pro_bullets')"
                :cta="__('site.pricing.card_pro_cta')"
            />
            <x-pricing-card
                :title="__('site.pricing.card_webshop_title')"
                :price="__('site.pricing.card_webshop_price')"
                :description="__('site.pricing.card_webshop_desc')"
                :bullets="__('site.pricing.card_webshop_bullets')"
                :cta="__('site.pricing.card_webshop_cta')"
            />
            <x-pricing-card
                :title="__('site.pricing.card_maint_title')"
                :price="__('site.pricing.card_maint_price')"
                :description="__('site.pricing.card_maint_desc')"
                :bullets="__('site.pricing.card_maint_bullets')"
                :cta="__('site.pricing.card_maint_cta')"
            />
        </div>
        <p class="mt-6 text-center text-sm text-slate-400 leading-relaxed max-w-xl mx-auto">
            {{ __('site.pricing.note') }}
        </p>
        <p class="mt-2 text-center text-xs font-medium text-slate-500">
            {{ __('site.pricing.vat_note') }}
        </p>
        {{-- Webshop price note --}}
        <div class="mt-5 bg-white border border-stone-200 rounded-xl p-5 max-w-2xl mx-auto text-center reveal">
            <p class="text-sm font-medium text-slate-700 mb-1">{{ __('site.pricing.webshop_note_title') }}</p>
            <p class="text-xs text-slate-500 leading-relaxed">
                {{ __('site.pricing.webshop_note_body') }}
            </p>
        </div>
    </section>

    {{-- What determines price --}}
    <section class="bg-stone-100 border-y border-stone-200" aria-labelledby="pricing-factors-heading">
        <div class="max-w-6xl mx-auto px-6 py-16 reveal">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
                <div>
                    <h2 id="pricing-factors-heading" class="font-serif text-2xl font-medium text-slate-900 mb-6">{{ __('site.pricing.factors_heading') }}</h2>
                    <ul class="space-y-3.5" role="list">
                        @foreach(__('site.pricing.factors_items') as $factor)
                        <li class="flex items-start gap-3 text-sm text-slate-600">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-amber-600 shrink-0" aria-hidden="true"></span>
                            {{ $factor }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-white rounded-xl border border-stone-200 p-7 shadow-sm">
                    <h3 class="font-serif text-lg font-medium text-slate-900 mb-3">{{ __('site.pricing.budget_heading') }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-5">
                        {{ __('site.pricing.budget_body') }}
                    </p>
                    @php
                        $loc = app()->getLocale() ?: 'nl';
                        $contactHref = \Illuminate\Support\Facades\Route::has($loc . '.contact') ? route($loc . '.contact') : route('contact');
                    @endphp
                    <a href="{{ $contactHref }}"
                       class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors duration-200 cursor-pointer shadow-sm">
                        {{ __('site.pricing.budget_cta') }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    @if(is_array(__('site.pricing.faq')))
    <section class="max-w-6xl mx-auto px-6 py-16" aria-labelledby="pricing-faq-heading">
        <div class="reveal">
            <h2 id="pricing-faq-heading" class="font-serif text-2xl font-medium text-slate-900 mb-8">{{ __('site.pricing.faq_heading') }}</h2>
            <div class="space-y-5">
                @foreach(__('site.pricing.faq') as $item)
                <div class="bg-white border border-stone-200 rounded-xl p-6">
                    <h3 class="font-serif text-base font-medium text-slate-900 mb-2">{{ $item['q'] }}</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $item['a'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- FAQPage structured data --}}
    @if(is_array(__('site.pricing.faq')))
    @php
        $pricingFaqSchema = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => array_map(fn($item) => [
                '@type'          => 'Question',
                'name'           => $item['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']],
            ], __('site.pricing.faq')),
        ];
    @endphp
    <script type="application/ld+json">
{!! json_encode($pricingFaqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

</x-layouts.app>
