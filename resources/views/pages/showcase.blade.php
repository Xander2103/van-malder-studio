<x-layouts.app
    :title="__('site.seo.showcase_title')"
    :description="__('site.seo.showcase_desc')"
    :ogTitle="__('site.seo.showcase_og_title')"
>

    {{-- Header --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-10">
        <div class="reveal">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                {{ __('site.showcase.eyebrow') }}
            </p>
            <h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">{{ __('site.showcase.heading') }}</h1>
            <p class="mt-4 text-lg text-slate-500 leading-relaxed max-w-2xl">
                {{ __('site.showcase.body') }}
            </p>
            @php
                $loc = app()->getLocale() ?: 'nl';
                $showcaseServicesHref = \Illuminate\Support\Facades\Route::has($loc . '.services') ? route($loc . '.services') : route('services');
                $noteLink = '<a href="' . $showcaseServicesHref . '" class="text-blue-700 hover:underline">' . __('site.showcase.note_link') . '</a>';
            @endphp
            <p class="mt-3 text-sm text-slate-400 max-w-xl leading-relaxed">
                {!! str_replace(':link', $noteLink, __('site.showcase.note')) !!}
            </p>
        </div>
    </section>

    {{-- ── Showcase cards ── --}}
    <section class="max-w-6xl mx-auto px-6 pb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- ─────────────────────────────────────────────────────────
                 CARD 1: Interactive canvas hero (links to studio-intro)
                 ───────────────────────────────────────────────────────── --}}
            <a href="{{ route('studio.intro') }}"
               class="showcase-card group bg-slate-900 rounded-xl border border-slate-800 overflow-hidden flex flex-col reveal"
               aria-label="{{ __('site.showcase.card_hero_aria') }}">
                <div class="h-48 card-woven-hint relative overflow-hidden" aria-hidden="true">
                    <div class="absolute top-0 left-0 w-52 h-52 rounded-full bg-blue-900/25" style="filter:blur(45px);transform:translate(-20%,-20%)"></div>
                    <div class="absolute bottom-0 right-0 w-44 h-44 rounded-full bg-slate-800/40" style="filter:blur(40px);transform:translate(10%,10%)"></div>
                    <svg class="absolute inset-0 w-full h-full opacity-20" viewBox="0 0 400 192" fill="none" aria-hidden="true">
                        <line x1="80" y1="70" x2="160" y2="105" stroke="rgba(148,163,184,0.6)" stroke-width="0.7"/>
                        <line x1="160" y1="105" x2="250" y2="75" stroke="rgba(99,120,190,0.5)" stroke-width="0.7"/>
                        <line x1="250" y1="75" x2="320" y2="55" stroke="rgba(148,163,184,0.4)" stroke-width="0.7"/>
                        <line x1="80" y1="70" x2="100" y2="130" stroke="rgba(148,163,184,0.3)" stroke-width="0.7"/>
                        <line x1="160" y1="105" x2="180" y2="145" stroke="rgba(99,120,190,0.3)" stroke-width="0.7"/>
                        <circle cx="80" cy="70" r="2.5" fill="rgba(148,163,184,0.5)"/>
                        <circle cx="160" cy="105" r="2" fill="rgba(148,163,184,0.4)"/>
                        <circle cx="250" cy="75" r="2" fill="rgba(99,120,190,0.5)"/>
                        <circle cx="320" cy="55" r="1.5" fill="rgba(148,163,184,0.3)"/>
                        <circle cx="100" cy="130" r="1.5" fill="rgba(148,163,184,0.3)"/>
                        <circle cx="180" cy="145" r="2" fill="rgba(99,120,190,0.3)"/>
                    </svg>
                    <div class="absolute bottom-3 right-4 text-[0.6rem] font-mono text-slate-500 tracking-widest">CANVAS · PARTICLES · PARALLAX</div>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <span class="text-[0.65rem] font-semibold text-amber-600 uppercase tracking-widest mb-2">{{ __('site.showcase.card_hero_eyebrow') }}</span>
                    <h2 class="font-serif text-lg font-medium text-white leading-snug">{{ __('site.showcase.card_hero_title') }}</h2>
                    <p class="mt-2 text-sm text-slate-400 leading-relaxed flex-1">
                        {{ __('site.showcase.card_hero_body') }}
                    </p>
                    <p class="mt-2 text-xs text-slate-600 italic">{{ __('site.showcase.card_hero_value') }}</p>
                    <div class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-amber-500 group-hover:text-amber-400 transition-colors duration-200">
                        {{ __('site.showcase.card_hero_cta') }}
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </a>

            {{-- ─────────────────────────────────────────────────────────
                 CARD 2: UI micro-interactions (genuinely interactive)
                 ───────────────────────────────────────────────────────── --}}
            <div class="showcase-card bg-white rounded-xl border border-stone-200 overflow-hidden flex flex-col reveal reveal-delay-1"
                 data-showcase-card="interactions">

                {{-- Live preview area --}}
                <div class="h-48 bg-stone-50 border-b border-stone-100 p-5 space-y-4">

                    {{-- State toggle buttons --}}
                    <div class="flex gap-2" role="group" aria-label="{{ __('site.showcase.card_ui_title') }}">
                        <button data-interact-state="hover"
                                class="interact-state-btn px-3 py-1.5 text-xs font-semibold rounded-md border border-stone-200 bg-slate-900 text-white cursor-pointer"
                                aria-pressed="true">
                            Hover
                        </button>
                        <button data-interact-state="active"
                                class="interact-state-btn px-3 py-1.5 text-xs font-semibold rounded-md border border-stone-200 bg-white text-slate-600 cursor-pointer"
                                aria-pressed="false">
                            Active
                        </button>
                        <button data-interact-state="disabled"
                                class="interact-state-btn px-3 py-1.5 text-xs font-semibold rounded-md border border-stone-200 bg-white text-slate-600 cursor-pointer"
                                aria-pressed="false">
                            Disabled
                        </button>
                    </div>

                    {{-- Preview button that changes with state --}}
                    <div data-interact-preview aria-live="polite">
                        <button data-preview-btn
                                class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold rounded-lg border transition-all duration-200 bg-blue-50 border-blue-400 text-blue-700 shadow-sm"
                                tabindex="-1" aria-hidden="true">
                            Hover →
                        </button>
                    </div>

                    {{-- Step indicator --}}
                    <div class="flex items-center gap-0" role="group" aria-label="{{ __('site.showcase.card_ui_title') }}">
                        @foreach([1,2,3] as $s)
                        <button data-interact-step="{{ $s }}"
                                class="w-7 h-7 rounded-full text-xs font-bold transition-colors duration-200 cursor-pointer {{ $s === 1 ? 'bg-slate-900 text-white' : 'bg-stone-200 text-stone-400' }}"
                                aria-current="{{ $s === 1 ? 'step' : 'false' }}"
                                aria-label="{{ $s }}">
                            {{ $s }}
                        </button>
                        @if($s < 3)
                        <div data-interact-line="{{ $s }}" class="flex-1 h-px mx-1 transition-colors duration-200 {{ $s < 1 ? 'bg-slate-900' : 'bg-stone-200' }}" aria-hidden="true"></div>
                        @endif
                        @endforeach
                    </div>

                    {{-- Progress bar --}}
                    <div class="w-full bg-stone-200 rounded-full h-1.5" role="progressbar" aria-label="{{ __('site.showcase.card_ui_title') }}">
                        <div data-interact-progress class="bg-blue-600 h-1.5 rounded-full transition-all duration-300" style="width:33%"></div>
                    </div>
                </div>

                {{-- Content + microcopy --}}
                <div class="p-6 flex flex-col flex-1">
                    <span class="text-[0.65rem] font-semibold text-amber-700 uppercase tracking-widest mb-2">{{ __('site.showcase.card_ui_eyebrow') }}</span>
                    <h2 class="font-serif text-lg font-medium text-slate-900 leading-snug">{{ __('site.showcase.card_ui_title') }}</h2>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                        {{ __('site.showcase.card_ui_body') }}
                    </p>
                    <p data-interact-copy class="mt-3 text-xs text-slate-400 leading-relaxed italic">
                        Hover →
                    </p>
                    @php
                        $loc = app()->getLocale() ?: 'nl';
                        $showcaseContactHref = \Illuminate\Support\Facades\Route::has($loc . '.contact') ? route($loc . '.contact') : route('contact');
                    @endphp
                    <a href="{{ $showcaseContactHref }}"
                       class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 group cursor-pointer">
                        {{ __('site.showcase.card_ui_cta') }}
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- ─────────────────────────────────────────────────────────
                 CARD 3: Scroll preview — mini VMS website with section tabs
                 ───────────────────────────────────────────────────────── --}}
            <div class="showcase-card bg-white rounded-xl border border-stone-200 overflow-hidden flex flex-col reveal reveal-delay-2"
                 data-showcase-card="scroll-preview">

                {{-- Browser mockup --}}
                <div class="h-56 bg-gradient-to-b from-stone-100 to-stone-50 border-b border-stone-100 flex items-start pt-3 px-3 overflow-hidden" aria-hidden="true">
                    <div id="scroll-mockup" class="scroll-mockup w-full bg-white rounded-lg shadow-sm border border-stone-200 overflow-hidden">
                        {{-- Browser chrome --}}
                        <div class="h-6 bg-stone-100 border-b border-stone-200 flex items-center px-2 gap-1 shrink-0">
                            <div class="w-2 h-2 rounded-full bg-red-300"></div>
                            <div class="w-2 h-2 rounded-full bg-amber-300"></div>
                            <div class="w-2 h-2 rounded-full bg-green-300"></div>
                            <div class="ml-2 flex-1 h-3 bg-stone-200 rounded-full max-w-28 flex items-center px-1.5">
                                <span class="text-[0.45rem] text-stone-400 leading-none">vanmalderstudio.be</span>
                            </div>
                        </div>
                        {{-- Mini website sections --}}
                        <div data-section-content="first-impression" class="transition-all duration-300 opacity-40">
                            <div class="bg-stone-50 px-3 py-2">
                                <div class="h-2 bg-slate-700 rounded w-3/5 mb-1.5"></div>
                                <div class="h-1 bg-stone-300 rounded w-full mb-0.5"></div>
                                <div class="h-1 bg-stone-300 rounded w-4/5 mb-2"></div>
                                <div class="flex gap-1.5">
                                    <div class="h-4 bg-slate-800 rounded w-16"></div>
                                    <div class="h-4 bg-stone-200 border border-stone-300 rounded w-12"></div>
                                </div>
                            </div>
                        </div>
                        <div data-section-content="offer" class="transition-all duration-300 opacity-40">
                            <div class="bg-white px-3 py-2 border-t border-stone-100">
                                <div class="h-1 bg-amber-300 rounded w-12 mb-1.5"></div>
                                <div class="grid grid-cols-3 gap-1.5">
                                    <div class="bg-stone-100 rounded h-7 border border-stone-200"></div>
                                    <div class="bg-stone-100 rounded h-7 border border-stone-200 col-span-2"></div>
                                    <div class="bg-stone-100 rounded h-7 border border-stone-200"></div>
                                    <div class="bg-slate-800 rounded h-7 col-span-2"></div>
                                </div>
                            </div>
                        </div>
                        <div data-section-content="seo" class="transition-all duration-300 opacity-40">
                            <div class="bg-slate-800 px-3 py-2">
                                <div class="h-1 bg-slate-500 rounded w-2/5 mb-1.5"></div>
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1"><div class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></div><div class="h-0.5 bg-slate-600 rounded flex-1"></div></div>
                                    <div class="flex items-center gap-1"><div class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></div><div class="h-0.5 bg-slate-600 rounded w-4/5"></div></div>
                                </div>
                            </div>
                        </div>
                        <div data-section-content="pricing" class="transition-all duration-300 opacity-40">
                            <div class="bg-white px-3 py-2 border-t border-stone-100">
                                <div class="flex gap-1.5">
                                    <div class="flex-1 bg-stone-100 border border-stone-200 rounded h-9"></div>
                                    <div class="flex-1 bg-slate-800 rounded h-9"></div>
                                    <div class="flex-1 bg-stone-100 border border-stone-200 rounded h-9"></div>
                                </div>
                            </div>
                        </div>
                        <div data-section-content="contact" class="transition-all duration-300 opacity-40">
                            <div class="bg-slate-900 px-3 py-2">
                                <div class="h-1.5 bg-slate-600 rounded w-3/5 mx-auto mb-1.5"></div>
                                <div class="flex justify-center"><div class="h-4 bg-white/20 border border-white/10 rounded w-20"></div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-1">
                    <span class="text-[0.65rem] font-semibold text-amber-700 uppercase tracking-widest mb-2">{{ __('site.showcase.card_scroll_eyebrow') }}</span>
                    <h2 class="font-serif text-lg font-medium text-slate-900 leading-snug">{{ __('site.showcase.card_scroll_title') }}</h2>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                        {{ __('site.showcase.card_scroll_body') }}
                    </p>

                    {{-- Play button --}}
                    <button data-scroll-play
                            class="mt-4 self-start inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer"
                            aria-label="{{ __('site.showcase.card_scroll_play') }}">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        {{ __('site.showcase.card_scroll_play') }}
                    </button>

                    {{-- Section tabs --}}
                    <div class="mt-3 flex flex-wrap gap-1.5" role="group" aria-label="{{ __('site.showcase.card_scroll_tabs_aria') }}">
                        @foreach(__('site.showcase.scroll_tabs') as $key => $label)
                        @php
                            $tabKey = str_replace('_', '-', $key);
                            $captionKey = $tabKey;
                            $caption = __('site.showcase.scroll_captions.' . $captionKey);
                        @endphp
                        <button data-section-tab="{{ $tabKey }}"
                                data-caption="{{ $caption }}"
                                class="px-2.5 py-1 text-xs font-medium rounded-md border cursor-pointer transition-all duration-150 {{ $tabKey === 'first-impression' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-500 border-stone-200' }}"
                                aria-pressed="{{ $tabKey === 'first-impression' ? 'true' : 'false' }}">
                            {{ $label }}
                        </button>
                        @endforeach
                    </div>

                    {{-- Progress --}}
                    <div class="mt-3 w-full bg-stone-200 rounded-full h-1" role="progressbar" aria-label="{{ __('site.showcase.card_scroll_title') }}">
                        <div data-section-progress class="bg-blue-600 h-1 rounded-full transition-all duration-300" style="width:20%"></div>
                    </div>

                    {{-- Caption --}}
                    <p data-section-caption class="mt-2 text-xs text-slate-400 leading-relaxed italic" aria-live="polite">
                        {{ __('site.showcase.scroll_captions.first-impression') }}
                    </p>
                </div>
            </div>

            {{-- ─────────────────────────────────────────────────────────
                 CARD 4: Slimme aanvraagflow demo
                 ───────────────────────────────────────────────────────── --}}
            @php
                $loc = app()->getLocale() ?: 'nl';
                $cfContactHref = \Illuminate\Support\Facades\Route::has($loc . '.contact') ? route($loc . '.contact') : route('contact');
            @endphp
            <div class="showcase-card bg-white rounded-xl border border-stone-200 overflow-hidden flex flex-col reveal reveal-delay-3"
                 data-showcase-card="contactflow">

                {{-- Interactive demo area --}}
                <div class="bg-stone-50 border-b border-stone-100 p-4 flex flex-col gap-2">
                    <p class="text-xs font-semibold text-slate-600 mb-0.5">{{ __('site.showcase.card_cf_choice_label') }}</p>

                    {{-- Option buttons --}}
                    <div class="flex flex-wrap gap-1.5">
                        @foreach(__('site.showcase.cf_options') as $opt)
                        <button data-cf-option="{{ $opt['key'] }}"
                                class="px-2.5 py-1.5 text-xs font-medium rounded-lg border cursor-pointer transition-all duration-150 text-left bg-white text-slate-600 border-stone-200"
                                aria-pressed="false">
                            {{ $opt['label'] }}
                        </button>
                        @endforeach
                    </div>

                    {{-- Summary row --}}
                    <div class="flex items-center gap-2 bg-white border border-stone-200 rounded-lg px-2.5 py-1.5">
                        <span class="text-xs text-slate-400 shrink-0">{{ __('site.showcase.card_cf_choice_keuze') }}</span>
                        <span data-cf-summary class="text-xs font-semibold text-slate-700">—</span>
                    </div>

                    {{-- Checklist (shown after selection) --}}
                    <div data-cf-checklist class="hidden">
                        <p class="text-[0.65rem] font-semibold text-slate-500 uppercase tracking-wider mb-1">{{ __('site.showcase.card_cf_checklist_heading') }}</p>
                        <ul data-cf-checklist-items class="space-y-0.5"></ul>
                    </div>

                    {{-- Validation hint --}}
                    <div data-cf-validation class="text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-lg px-2.5 py-1.5">
                        {{ __('site.showcase.card_cf_validation') }}
                    </div>

                    {{-- Result message --}}
                    <div data-cf-success class="hidden text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg px-2.5 py-1.5">
                        <div class="flex items-center gap-1.5 mb-0.5">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="font-semibold">{{ __('site.showcase.card_cf_result_heading') }}</span>
                        </div>
                        <span data-cf-result-text></span>
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-1">
                    <span class="text-[0.65rem] font-semibold text-amber-700 uppercase tracking-widest mb-2">{{ __('site.showcase.card_cf_eyebrow') }}</span>
                    <h2 class="font-serif text-lg font-medium text-slate-900 leading-snug">{{ __('site.showcase.card_cf_title') }}</h2>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed flex-1">
                        {{ __('site.showcase.card_cf_body') }}
                    </p>
                    <p class="mt-3 text-xs text-amber-700 bg-amber-50 border border-amber-100 rounded-lg px-3 py-2 leading-relaxed">
                        {{ __('site.showcase.card_cf_ai_note') }}
                    </p>
                    <a href="{{ $cfContactHref }}"
                       class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 group cursor-pointer">
                        {{ __('site.showcase.card_cf_cta') }}
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- ── CTA ── --}}
    <section class="max-w-6xl mx-auto px-6 py-14" aria-labelledby="showcase-cta-heading">
        <div class="bg-white rounded-xl border border-stone-200 p-8 md:p-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6 shadow-sm reveal">
            <div>
                <h2 id="showcase-cta-heading" class="font-serif text-xl md:text-2xl font-medium text-slate-900 leading-tight">{{ __('site.showcase.cta_heading') }}</h2>
                <p class="mt-2 text-sm text-slate-500 leading-relaxed max-w-lg">{{ __('site.showcase.cta_body') }}</p>
            </div>
            @php
                $loc = app()->getLocale() ?: 'nl';
                $showcaseFinalContactHref = \Illuminate\Support\Facades\Route::has($loc . '.contact') ? route($loc . '.contact') : route('contact');
                $showcaseFinalServicesHref = \Illuminate\Support\Facades\Route::has($loc . '.services') ? route($loc . '.services') : route('services');
            @endphp
            <div class="flex flex-wrap gap-3 shrink-0">
                <a href="{{ $showcaseFinalContactHref }}"
                   class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                    {{ __('site.showcase.cta_primary') }}
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ $showcaseFinalServicesHref }}"
                   class="inline-flex items-center px-5 py-3 text-sm font-semibold bg-white border border-stone-300 text-slate-700 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                    {{ __('site.showcase.cta_secondary') }}
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
