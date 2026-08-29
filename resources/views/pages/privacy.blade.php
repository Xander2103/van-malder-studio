<x-layouts.app
    title="Privacyverklaring | Van Malder Studio"
    description="Privacyverklaring van Van Malder Studio. Hoe worden je gegevens verzameld, gebruikt en bewaard bij het invullen van het contactformulier?"
    ogType="article"
>

    <section class="max-w-3xl mx-auto px-6 pt-16 pb-20">

        <div class="mb-10">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                Juridisch
            </p>
            <h1 class="font-serif text-4xl font-medium text-slate-900 leading-tight">Privacyverklaring</h1>
            <p class="mt-3 text-sm text-slate-400">Laatst bijgewerkt: {{ date('d F Y') }}</p>
        </div>

        <div class="prose-content space-y-10 text-slate-600">

            <section aria-labelledby="privacy-wie">
                <h2 id="privacy-wie" class="font-serif text-xl font-medium text-slate-900 mb-3">Wie ben ik?</h2>
                <p class="leading-relaxed">
                    Van Malder Studio is de handelsnaam van <strong class="text-slate-800">Xander Van Malder</strong>, full stack developer
                    gevestigd in de Druivenstreek, Vlaams-Brabant.
                </p>
                <p class="mt-3 leading-relaxed">
                    Contactadres: <a href="mailto:{{ config('studio.email') }}" class="text-blue-700 hover:underline">{{ config('studio.email') }}</a>
                </p>
            </section>

            <div class="border-t border-stone-200"></div>

            <section aria-labelledby="privacy-welke">
                <h2 id="privacy-welke" class="font-serif text-xl font-medium text-slate-900 mb-3">Welke gegevens worden verzameld?</h2>
                <p class="leading-relaxed mb-3">
                    Via het contactformulier op deze website worden de volgende gegevens verzameld:
                </p>
                <ul class="space-y-2 list-none" role="list">
                    @foreach([
                        'Naam (verplicht)',
                        'E-mailadres (verplicht)',
                        'Bedrijfs- of handelsnaam (optioneel)',
                        'Telefoonnummer (optioneel)',
                        'URL van een bestaande website (optioneel)',
                        'Projecttype, budget en timing (optioneel)',
                        'Taalwensen en beheerbehoefte (optioneel)',
                        'Beschrijving van je project (verplicht)',
                        'GDPR-toestemmingsbevestiging',
                        'Technische metadata: een gehashte versie van je IP-adres (niet leesbaar), browsertype en referrer-URL',
                    ] as $item)
                    <li class="flex items-start gap-2.5 text-sm">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-slate-400 shrink-0" aria-hidden="true"></span>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
                <p class="mt-4 text-sm text-slate-500 leading-relaxed">
                    Het ruwe IP-adres wordt nooit bewaard — enkel een onherleidbare hash voor spamdetectie.
                </p>
            </section>

            <div class="border-t border-stone-200"></div>

            <section aria-labelledby="privacy-waarom">
                <h2 id="privacy-waarom" class="font-serif text-xl font-medium text-slate-900 mb-3">Waarvoor worden die gegevens gebruikt?</h2>
                <p class="leading-relaxed">
                    Je gegevens worden uitsluitend gebruikt om:
                </p>
                <ul class="mt-3 space-y-2 list-none" role="list">
                    @foreach([
                        'Je aanvraag te beantwoorden en te beoordelen',
                        'Contact op te nemen voor opvolging of bijkomende vragen',
                        'Spam en misbruik te detecteren',
                    ] as $item)
                    <li class="flex items-start gap-2.5 text-sm">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0" aria-hidden="true"></span>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
                <p class="mt-4 leading-relaxed">
                    Je gegevens worden nooit verkocht, verhuurd of doorgegeven aan derden voor commerciële doeleinden.
                    Ze worden enkel gedeeld als dit wettelijk verplicht is.
                </p>
            </section>

            <div class="border-t border-stone-200"></div>

            <section aria-labelledby="privacy-bewaring">
                <h2 id="privacy-bewaring" class="font-serif text-xl font-medium text-slate-900 mb-3">Hoe lang worden gegevens bewaard?</h2>
                <p class="leading-relaxed">
                    Contactaanvragen worden bewaard zolang ze relevant zijn voor de opvolging.
                    Gegevens van aanvragen waarbij geen samenwerking tot stand is gekomen, worden verwijderd wanneer ze niet langer nodig zijn.
                </p>
            </section>

            <div class="border-t border-stone-200"></div>

            <section aria-labelledby="privacy-beveiliging">
                <h2 id="privacy-beveiliging" class="font-serif text-xl font-medium text-slate-900 mb-3">Beveiliging</h2>
                <p class="leading-relaxed">
                    De website maakt gebruik van CSRF-bescherming, rate limiting, invoervalidatie en een honeypot-veld om misbruik te voorkomen.
                    IP-adressen worden opgeslagen als een onherleidbare hash (SHA-256).
                </p>
            </section>

            <div class="border-t border-stone-200"></div>

            <section aria-labelledby="privacy-cookies">
                <h2 id="privacy-cookies" class="font-serif text-xl font-medium text-slate-900 mb-3">Cookies en tracking</h2>
                <p class="leading-relaxed">
                    Deze website gebruikt geen tracking-cookies, advertentiecookies of analytics van derden.
                    Er worden enkel technisch noodzakelijke sessiecookies gebruikt voor het correct functioneren van het contactformulier (CSRF-token).
                </p>
            </section>

            <div class="border-t border-stone-200"></div>

            <section aria-labelledby="privacy-rechten">
                <h2 id="privacy-rechten" class="font-serif text-xl font-medium text-slate-900 mb-3">Jouw rechten</h2>
                <p class="leading-relaxed mb-3">Je hebt het recht om:</p>
                <ul class="space-y-2 list-none" role="list">
                    @foreach([
                        'Inzage te vragen in je opgeslagen gegevens',
                        'Onjuiste gegevens te laten corrigeren',
                        'Je gegevens te laten verwijderen',
                        'Bezwaar te maken tegen de verwerking',
                    ] as $item)
                    <li class="flex items-start gap-2.5 text-sm">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0" aria-hidden="true"></span>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
                <p class="mt-4 leading-relaxed">
                    Neem hiervoor contact op via
                    <a href="mailto:{{ config('studio.email') }}" class="text-blue-700 hover:underline">{{ config('studio.email') }}</a>.
                    Ik reageer zo snel mogelijk, uiterlijk binnen 30 dagen.
                </p>
            </section>

            <div class="border-t border-stone-200"></div>

            <section aria-labelledby="privacy-contact">
                <h2 id="privacy-contact" class="font-serif text-xl font-medium text-slate-900 mb-3">Vragen of klachten?</h2>
                <p class="leading-relaxed">
                    Heb je vragen over deze privacyverklaring of over hoe je gegevens worden verwerkt?
                    Neem gerust contact op:
                    <a href="mailto:{{ config('studio.email') }}" class="text-blue-700 hover:underline">{{ config('studio.email') }}</a>.
                </p>
                <p class="mt-3 leading-relaxed text-sm text-slate-500">
                    Je hebt ook het recht om een klacht in te dienen bij de Belgische
                    <a href="https://www.gegevensbeschermingsautoriteit.be" target="_blank" rel="noopener noreferrer" class="text-blue-700 hover:underline">Gegevensbeschermingsautoriteit (GBA)</a>.
                </p>
            </section>

        </div>

        <div class="mt-12 pt-8 border-t border-stone-200">
            <a href="{{ Route::has((app()->getLocale() ?: 'nl') . '.home') ? route((app()->getLocale() ?: 'nl') . '.home') : route('home') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                </svg>
                Terug naar de homepage
            </a>
        </div>
    </section>

</x-layouts.app>
