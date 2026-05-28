<x-layouts.app
    title="Diensten | Websites, webapplicaties en onderhoud"
    description="Bekijk de diensten van Van Malder Studio: websites laten maken, bestaande websites vernieuwen, webapplicaties, formulieren en technisch onderhoud."
    :canonical="route('services')"
    ogTitle="Diensten | Van Malder Studio"
>

    {{-- Page header --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-12">
        <div class="reveal">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                Wat ik bouw
            </p>
            <h1 class="font-serif text-4xl md:text-5xl font-medium text-slate-900 leading-tight">Diensten</h1>
            <p class="mt-4 text-lg text-slate-500 leading-relaxed max-w-2xl">
                Ik help zelfstandigen en lokale bedrijven met websites en digitale tools die werken.
                Geen onnodige complexiteit — wel een solide, veilige basis die past bij wie je bent.
            </p>
        </div>
    </section>

    {{-- Services --}}
    @foreach($services as $i => $service)
    <section
        id="{{ $service['slug'] }}"
        class="scroll-mt-20 border-t border-stone-200 {{ $i % 2 === 1 ? 'bg-stone-50' : 'bg-white' }}"
        aria-labelledby="service-{{ $service['slug'] }}-heading"
    >
        <div class="max-w-6xl mx-auto px-6 py-16 reveal">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">

                {{-- Text --}}
                <div>
                    <span class="text-[0.65rem] font-bold text-stone-300 tabular-nums tracking-widest">0{{ $i + 1 }}</span>
                    <h2 id="service-{{ $service['slug'] }}-heading" class="font-serif text-2xl md:text-3xl font-medium text-slate-900 mt-1 leading-tight">
                        {{ $service['title'] }}
                    </h2>
                    <p class="mt-4 text-slate-500 leading-relaxed">{{ $service['description'] }}</p>
                    <div class="mt-7">
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                            {{ $service['cta'] }}
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Bullets --}}
                <div>
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-5">Wat is inbegrepen</h3>
                    <ul class="space-y-3.5" role="list">
                        @foreach($service['bullets'] as $bullet)
                        <li class="flex items-start gap-3">
                            <span class="mt-1 w-4 h-4 rounded-full bg-blue-50 border border-blue-200 flex items-center justify-center shrink-0" aria-hidden="true">
                                <svg class="w-2.5 h-2.5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                            <span class="text-sm text-slate-600 leading-relaxed">{{ $bullet }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @endforeach

    {{-- CTA --}}
    <section class="bg-slate-900 mt-0" aria-labelledby="services-cta-heading">
        <div class="max-w-6xl mx-auto px-6 py-16 text-center">
            <h2 id="services-cta-heading" class="font-serif text-3xl font-medium text-white">Niet zeker welke dienst bij jou past?</h2>
            <p class="mt-3 text-slate-400 max-w-lg mx-auto leading-relaxed">Vertel me over je situatie en ik help je op weg.</p>
            <div class="mt-7">
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold bg-white text-slate-900 rounded-lg hover:bg-blue-50 transition-colors duration-200 cursor-pointer">
                    Neem contact op
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
