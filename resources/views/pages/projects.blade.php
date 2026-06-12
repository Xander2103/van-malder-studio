<x-layouts.app
    title="Projecten | Van Malder Studio en VM Studios"
    description="Een overzicht van websites, apps, tools en interactieve projecten van Xander Van Malder, waaronder Killer Darts, Smart Card Mat en Chains of Glory."
    ogTitle="Projecten | Van Malder Studio"
>

    {{-- Header --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-12">
        <div class="reveal">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                VM Studios
            </p>
            <h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">Eigen projecten</h1>
            <p class="mt-4 text-lg text-slate-500 leading-relaxed max-w-2xl">
                Naast klantenwerk bouw ik eigen producten via <strong class="font-semibold text-slate-700">VM Studios</strong>.
                Geen schoolopdrachten, geen demo's — producten die ik van nul heb bedacht, gebouwd en afgewerkt.
                Ze tonen hoe ik denk over productontwerp, gebruikservaring en technische uitvoering.
            </p>
        </div>
    </section>

    {{-- Grouped cards --}}
    @php
    $grouped = collect($projects)->groupBy('category')->sortKeys();
    @endphp
    @foreach($grouped as $category => $group)
    <section class="max-w-6xl mx-auto px-6 {{ $loop->first ? 'pb-10' : 'py-10' }} {{ !$loop->first ? 'border-t border-stone-200' : '' }}" aria-labelledby="cat-{{ Str::slug($category) }}">
        <h2 id="cat-{{ Str::slug($category) }}" class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-6">{{ $category }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($group as $i => $project)
            <div class="reveal reveal-delay-{{ $i + 1 }}">
                <x-project-card :project="$project" />
            </div>
            @endforeach
        </div>
    </section>
    @endforeach
    <div class="pb-10"></div>

    {{-- Project detail sections --}}
    @foreach($projects as $project)
    <section id="{{ $project['slug'] }}" class="scroll-mt-20 border-t border-stone-200 bg-white" aria-labelledby="{{ $project['slug'] }}-heading">
        <div class="max-w-6xl mx-auto px-6 py-16 reveal">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <div>
                    <div class="flex items-center flex-wrap gap-2 mb-4">
                        <span class="text-xs font-semibold px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-full">{{ $project['category'] }}</span>
                        <span class="text-xs font-semibold px-2.5 py-1 {{ $project['status'] === 'Afgewerkt' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-stone-100 text-slate-500 border-stone-200' }} border rounded-full">{{ $project['status'] }}</span>
                    </div>
                    <h2 id="{{ $project['slug'] }}-heading" class="font-serif text-2xl md:text-3xl font-medium text-slate-900 leading-tight">{{ $project['title'] }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $project['type'] }}</p>
                    <p class="mt-4 text-slate-500 leading-relaxed">{{ $project['description'] }}</p>
                </div>
                <div class="space-y-6">
                    <div class="bg-stone-50 rounded-xl border border-stone-200 p-5">
                        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Wat het aantoont</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $project['proves'] }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Technologieën</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($project['technologies'] as $tech)
                            <span class="text-xs font-medium px-2.5 py-1 bg-white border border-stone-200 text-slate-600 rounded-full">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach

    {{-- CTA --}}
    <section class="bg-stone-100 border-t border-stone-200" aria-labelledby="projects-cta-heading">
        <div class="max-w-6xl mx-auto px-6 py-16 text-center">
            <h2 id="projects-cta-heading" class="font-serif text-3xl font-medium text-slate-900">Heb je zelf een idee?</h2>
            <p class="mt-3 text-slate-500 max-w-lg mx-auto leading-relaxed">
                Ik help graag bij het uitwerken van je digitale project — van idee tot werkende applicatie.
            </p>
            <div class="mt-7">
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                    Bespreek je idee
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
