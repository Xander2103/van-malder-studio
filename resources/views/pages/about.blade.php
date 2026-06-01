<x-layouts.app
    :title="__('site.seo.about_title')"
    :description="__('site.seo.about_desc')"
    :canonical="route('about')"
    :ogTitle="__('site.seo.about_og_title')"
>

    {{-- Header --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-16">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 lg:gap-16 items-start">

            {{-- Main text --}}
            <div class="lg:col-span-3 reveal">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    {{ __('site.about.eyebrow') }}
                </p>
                <h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">{{ __('site.about.heading') }}</h1>
                <p class="mt-2 text-slate-500">{{ __('site.about.subtitle') }}</p>

                <div class="mt-8 space-y-4 text-slate-600 leading-relaxed">
                    <p>{{ __('site.about.body_1') }}</p>
                    <p>{{ __('site.about.body_2') }}</p>
                    <p>{{ __('site.about.body_3', ['brand' => 'VM Studios']) }}</p>
                    <p>{{ __('site.about.body_4', ['brand' => 'VM Studios']) }}</p>
                    <p>{{ __('site.about.body_5') }}</p>
                </div>

                @php
                    $loc = app()->getLocale() ?: 'nl';
                    $aboutContactHref = \Illuminate\Support\Facades\Route::has($loc . '.contact') ? route($loc . '.contact') : route('contact');
                    $aboutShowcaseHref = \Illuminate\Support\Facades\Route::has($loc . '.showcase') ? route($loc . '.showcase') : route('showcase');
                @endphp
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ $aboutContactHref }}"
                       class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                        {{ __('site.about.cta_contact') }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ $aboutShowcaseHref }}"
                       class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-white border border-stone-300 text-slate-700 rounded-lg hover:border-slate-400 hover:text-slate-900 transition-colors duration-200 cursor-pointer">
                        {{ __('site.about.cta_showcase') }}
                    </a>
                </div>

                <div class="mt-10">
                    <x-business-card size="compact" />
                </div>
            </div>

            {{-- Sidebar cards --}}
            <div class="lg:col-span-2 space-y-4 reveal reveal-delay-1">

                {{-- Stack card --}}
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm">
                    <h2 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-5">{{ __('site.about.tech_heading') }}</h2>
                    <div class="space-y-4">
                        @foreach(__('site.about.tech_groups') as $group)
                        <div>
                            <p class="text-[0.6rem] font-semibold text-stone-400 uppercase tracking-widest mb-1.5">{{ $group['label'] }}</p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($group['items'] as $tech)
                                <span class="text-xs font-medium px-2 py-0.5 bg-stone-100 border border-stone-200 text-slate-600 rounded-full">{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Focus areas --}}
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm">
                    <h2 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">{{ __('site.about.focus_heading') }}</h2>
                    <ul class="space-y-2.5" role="list">
                        @foreach(__('site.about.focus_items') as $focus)
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 shrink-0" aria-hidden="true"></span>
                            {{ $focus }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Own projects compact links --}}
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm">
                    <h2 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">{{ __('site.about.projects_heading') }}</h2>
                    <ul class="space-y-3" role="list">
                        @foreach($projects as $project)
                        @php
                            $statusKey = $project['status_key'] ?? 'in-development';
                            $sidebarBadge = match($statusKey) {
                                'live'           => 'text-emerald-600 bg-emerald-50 border-emerald-100',
                                'prototype'      => 'text-amber-600 bg-amber-50 border-amber-100',
                                default          => 'text-slate-400 bg-stone-100 border-stone-200',
                            };
                            $statusLabel = __('site.about.status.' . $statusKey) ?: $project['status'];
                            $tProject = __('site.projects.' . $project['slug']);
                            $displayType = is_array($tProject) ? $tProject['type'] : $project['type'];
                        @endphp
                        <li class="flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600 shrink-0" aria-hidden="true"></span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ $project['title'] }}</p>
                                <p class="text-xs text-slate-400">{{ $displayType }}</p>
                            </div>
                            <span class="text-[0.6rem] font-medium px-1.5 py-0.5 {{ $sidebarBadge }} border rounded-full shrink-0">{{ $statusLabel }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ── VM Studios — expanded ── --}}
    <section id="vm-studios" class="border-t border-stone-200 scroll-mt-20" aria-labelledby="vm-studios-heading">
        <div class="max-w-6xl mx-auto px-6 py-16">
            <div class="reveal mb-10">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    {{ __('site.about.vm_studios_eyebrow') }}
                </p>
                <h2 id="vm-studios-heading" class="font-serif text-3xl font-medium text-slate-900 leading-tight">{{ __('site.about.vm_studios_heading') }}</h2>
                <p class="mt-3 text-slate-500 leading-relaxed max-w-2xl">
                    {{ __('site.about.vm_studios_body') }}
                </p>
            </div>

            <div class="space-y-6">
                @foreach($projects as $i => $project)
                @php
                    $statusKey = $project['status_key'] ?? 'in-development';
                    $articleBadge = match($statusKey) {
                        'live'           => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                        'prototype'      => 'bg-amber-50 text-amber-700 border-amber-100',
                        default          => 'bg-slate-100 text-slate-600 border-slate-200',
                    };
                    $statusLabel = __('site.about.status.' . $statusKey) ?: $project['status'];
                    $tProject = __('site.projects.' . $project['slug']);
                    $displayCategory    = is_array($tProject) ? $tProject['category']    : $project['category'];
                    $displayType        = is_array($tProject) ? $tProject['type']        : $project['type'];
                    $displayLabel       = is_array($tProject) ? ($tProject['label'] ?? $project['label'] ?? '') : ($project['label'] ?? '');
                    $displayDescription = is_array($tProject) ? $tProject['description'] : $project['description'];
                    $displayProves      = is_array($tProject) ? $tProject['proves']      : $project['proves'];
                @endphp
                <article class="bg-white rounded-xl border border-stone-200 p-6 md:p-8 reveal" aria-labelledby="vm-{{ $project['slug'] }}-heading">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-10">
                        <div class="md:col-span-2">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="text-xs font-semibold px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-full">{{ $displayCategory }}</span>
                                <span class="text-xs font-medium px-2.5 py-1 {{ $articleBadge }} border rounded-full">{{ $statusLabel }}</span>
                                @if(!empty($displayLabel))
                                <span class="text-xs font-medium text-stone-400">{{ $displayLabel }}</span>
                                @endif
                            </div>
                            <h3 id="vm-{{ $project['slug'] }}-heading" class="font-serif text-xl font-medium text-slate-900">{{ $project['title'] }}</h3>
                            <p class="text-sm text-slate-500 mt-0.5 mb-3">{{ $displayType }}</p>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $displayDescription }}</p>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('site.about.project_proves') }}</h4>
                                <p class="text-sm text-slate-600 leading-relaxed">{{ $displayProves }}</p>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('site.about.project_tech') }}</h4>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($project['technologies'] as $tech)
                                    <span class="text-xs font-medium px-2 py-0.5 bg-stone-100 border border-stone-200 text-slate-600 rounded-full">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

</x-layouts.app>
