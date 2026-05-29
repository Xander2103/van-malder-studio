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

    {{-- ── Extra mogelijkheden ── --}}
    <section class="bg-stone-50 border-t border-stone-200" aria-labelledby="addons-heading">
        <div class="max-w-6xl mx-auto px-6 py-16">
            <div class="reveal mb-10">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-3">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    Extra
                </p>
                <h2 id="addons-heading" class="font-serif text-2xl md:text-3xl font-medium text-slate-900 leading-tight">Extra mogelijkheden</h2>
                <p class="mt-2 text-slate-500 max-w-xl leading-relaxed">Aanvullende diensten die je website of project verder versterken — op aanvraag of als uitbreiding op een lopend project.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 reveal">

                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <h3 class="text-sm font-semibold text-slate-900">Website audit & verbeteradvies</h3>
                        <span class="text-xs font-medium text-blue-700 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full shrink-0 whitespace-nowrap">Vanaf €150</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">Ik kijk naar je huidige website en geef concreet aan wat beter kan: uitstraling, mobiel gebruik, snelheid, contactflow en SEO-basis. Korte audit gratis bij kennismaking.</p>
                </div>

                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <h3 class="text-sm font-semibold text-slate-900">Google Business Profile ondersteuning</h3>
                        <span class="text-xs font-medium text-blue-700 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full shrink-0 whitespace-nowrap">Vanaf €75</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">Contactgegevens, openingsuren, diensten, websitekoppeling en basisadvies rond reviews en foto's — zodat je bedrijf er goed uitziet op Google.</p>
                </div>

                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <h3 class="text-sm font-semibold text-slate-900">Contentstructuur & teksten</h3>
                        <span class="text-xs font-medium text-slate-500 bg-stone-100 border border-stone-200 px-2 py-0.5 rounded-full shrink-0 whitespace-nowrap">Op aanvraag</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">Ik help je aanbod duidelijk te structureren zodat bezoekers snel begrijpen wat je doet. Geen zware copywriting-beloftes — wel duidelijke websitecopy en betere indeling. Inbegrepen bij professionele websites.</p>
                </div>

                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <h3 class="text-sm font-semibold text-slate-900">Meertalige websites</h3>
                        <span class="text-xs font-medium text-blue-700 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full shrink-0 whitespace-nowrap">Vanaf €250/taal</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">Voor bedrijven in België kan de website meertalig worden opgebouwd met een duidelijke taalstructuur. De prijs hangt af van het aantal pagina's en de hoeveelheid inhoud.</p>
                </div>

                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <h3 class="text-sm font-semibold text-slate-900">Basis visuele richting</h3>
                        <span class="text-xs font-medium text-slate-500 bg-stone-100 border border-stone-200 px-2 py-0.5 rounded-full shrink-0 whitespace-nowrap">Op aanvraag</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">Heb je nog geen sterke stijl? Dan help ik met een eenvoudige professionele richting voor kleuren, typografie en uitstraling. Inbegrepen bij professionele websites.</p>
                </div>

                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <h3 class="text-sm font-semibold text-slate-900">Integraties</h3>
                        <span class="text-xs font-medium text-slate-500 bg-stone-100 border border-stone-200 px-2 py-0.5 rounded-full shrink-0 whitespace-nowrap">Op aanvraag</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">Koppeling aan tools die je al gebruikt: Google Maps, WhatsApp, e-mailmeldingen, nieuwsbrief of later Google Sheets en CRM. De complexiteit bepaalt de prijs.</p>
                </div>

            </div>
        </div>
    </section>

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
