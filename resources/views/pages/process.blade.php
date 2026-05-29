<x-layouts.app
    :title="__('site.seo.process_title')"
    :description="__('site.seo.process_desc')"
    :canonical="route('process')"
    :ogTitle="__('site.seo.process_title')"
>

    {{-- Header --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-12">
        <div class="reveal">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                {{ __('site.process.eyebrow') }}
            </p>
            <h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">{{ __('site.process.heading_full') }}</h1>
            <p class="mt-4 text-lg text-slate-500 leading-relaxed max-w-2xl">
                {{ __('site.process.intro') }}
            </p>
        </div>
    </section>

    {{-- Steps + sidebar --}}
    <section class="max-w-6xl mx-auto px-6 pb-5">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16 items-start">

            {{-- Steps --}}
            <div class="lg:col-span-2 reveal">
                <ol class="space-y-0" aria-label="{{ __('site.process.eyebrow') }}">
                    @foreach(__('site.process.steps') as $i => $step)
                    <li class="flex gap-6 {{ !$loop->last ? 'pb-8' : '' }}">
                        <div class="flex flex-col items-center">
                            <div class="w-9 h-9 rounded-full {{ $i === 0 ? 'bg-slate-900 text-white shadow-sm' : 'bg-white border-2 border-stone-300 text-slate-400' }} text-xs font-bold flex items-center justify-center shrink-0 z-10">
                                {{ $i + 1 }}
                            </div>
                            @if(!$loop->last)
                            <div class="w-px flex-1 bg-stone-200 mt-2" aria-hidden="true"></div>
                            @endif
                        </div>
                        <div class="{{ !$loop->last ? 'pb-2' : '' }}">
                            <h2 class="font-serif text-lg font-medium text-slate-900 leading-snug">{{ $step['title'] }}</h2>
                            <p class="mt-2 text-sm text-slate-500 leading-relaxed max-w-xl">{{ $step['desc'] }}</p>
                        </div>
                    </li>
                    @endforeach
                </ol>
            </div>

            {{-- Sidebar --}}
            @php
                $loc = app()->getLocale() ?: 'nl';
                $processContactHref = \Illuminate\Support\Facades\Route::has($loc . '.contact') ? route($loc . '.contact') : route('contact');
            @endphp
            <div class="space-y-5 lg:sticky lg:top-24 reveal reveal-delay-1">
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm">
                    <h2 class="font-serif text-base font-medium text-slate-900 mb-4">{{ __('site.process.expects_heading') }}</h2>
                    <ul class="space-y-3" role="list">
                        @foreach(__('site.process.expects_items') as $point)
                        <li class="flex items-start gap-3 text-sm text-slate-600">
                            <span class="mt-1 w-4 h-4 rounded-full bg-blue-50 border border-blue-200 flex items-center justify-center shrink-0" aria-hidden="true">
                                <svg class="w-2.5 h-2.5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                            {{ $point }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-blue-50 rounded-xl border border-blue-100 p-6">
                    <h2 class="font-serif text-base font-medium text-slate-900 mb-2">{{ __('site.process.cta_heading') }}</h2>
                    <p class="text-sm text-slate-500 leading-relaxed mb-5">{{ __('site.process.cta_body') }}</p>
                    <a href="{{ $processContactHref }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer">
                        {{ __('site.process.cta_btn') }}
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
