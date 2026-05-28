<x-layouts.app
    title="Contact | Bespreek je website of digitaal project"
    description="Neem contact op met Xander Van Malder voor een nieuwe website, webapplicatie, websitevernieuwing of digitaal project in de Druivenstreek of Vlaams-Brabant."
    :canonical="route('contact')"
>

@php
/*
 * Determine which step to open when there are validation errors.
 * Maps each form step to the field names it contains.
 */
$stepFieldMap = [
    1 => ['project_type', 'existing_website_url'],
    2 => ['name', 'company_name', 'email', 'phone'],
    3 => ['multilingual_needs', 'other_language', 'content_admin_needs', 'project_description'],
    4 => ['budget_range', 'timeline'],
    5 => ['gdpr_consent'],
];

$initialStep = 1;
if ($errors->any()) {
    foreach ($stepFieldMap as $step => $fields) {
        foreach ($fields as $field) {
            if ($errors->has($field) || $errors->has($field . '.*')) {
                $initialStep = $step;
                break 2;
            }
        }
    }
}
@endphp

    <section class="max-w-6xl mx-auto px-6 pt-16 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-14 items-start">

            {{-- Left: intro --}}
            <div class="lg:sticky lg:top-24">
                <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                    <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                    Contact
                </p>
                <h1 class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">Laten we praten</h1>
                <p class="mt-3 text-slate-500 leading-relaxed">Vertel me over je project of idee. Het invullen is vrijblijvend.</p>

                <div class="mt-8 space-y-5">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">E-mail</p>
                        <a href="mailto:{{ config('studio.email') }}" class="text-sm text-blue-700 hover:text-blue-900 transition-colors duration-200">
                            {{ config('studio.email') }}
                        </a>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Locatie</p>
                        <p class="text-sm text-slate-600">{{ config('studio.location') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Reactietijd</p>
                        <p class="text-sm text-slate-600">Doorgaans binnen 1–2 werkdagen</p>
                    </div>
                </div>

                <div class="mt-8 p-5 bg-stone-100 rounded-xl border border-stone-200">
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Je gegevens worden enkel gebruikt om je aanvraag te behandelen en worden nooit doorgegeven aan derden.
                        Zie de <a href="{{ route('privacy') }}" class="text-blue-700 hover:underline">privacyverklaring</a>.
                    </p>
                </div>
            </div>

            {{-- Right: form --}}
            <div class="lg:col-span-2">

                @if(session('success'))
                <div class="mb-8 rounded-xl bg-green-50 border border-green-200 p-6" role="alert" aria-live="polite">
                    <h2 class="font-serif text-xl font-medium text-green-900">Bericht ontvangen</h2>
                    <p class="mt-2 text-sm text-green-700 leading-relaxed">
                        Bedankt voor je bericht. Ik neem zo snel mogelijk contact met je op, doorgaans binnen 1 à 2 werkdagen.
                    </p>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4" role="alert" aria-live="polite" id="error-summary">
                    <p class="text-sm font-semibold text-red-800 mb-2">Controleer de onderstaande velden:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                        <li class="text-sm text-red-700">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @unless(session('success'))
                <form
                    action="{{ route('inquiries.store') }}"
                    method="POST"
                    novalidate
                    id="inquiry-form"
                    data-initial-step="{{ $initialStep }}"
                >
                    @csrf

                    {{-- Honeypot: hidden from real users, filled by bots --}}
                    <div class="hidden" aria-hidden="true">
                        <label for="website-field">Laat dit veld leeg</label>
                        <input type="text" id="website-field" name="website" tabindex="-1" autocomplete="off" value="">
                    </div>

                    {{-- Step indicator --}}
                    <nav class="mb-8" aria-label="Formulierstappen">
                        <ol class="flex items-center gap-0" id="step-indicators" role="list">
                            @foreach([
                                ['num' => 1, 'label' => 'Project'],
                                ['num' => 2, 'label' => 'Gegevens'],
                                ['num' => 3, 'label' => 'Details'],
                                ['num' => 4, 'label' => 'Budget'],
                                ['num' => 5, 'label' => 'Afronden'],
                            ] as $s)
                            <li class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
                                <div class="flex flex-col items-center">
                                    <div
                                        data-step-dot="{{ $s['num'] }}"
                                        aria-current="{{ $s['num'] === $initialStep ? 'step' : 'false' }}"
                                        class="w-7 h-7 rounded-full text-xs font-bold flex items-center justify-center transition-colors duration-200 {{ $s['num'] <= $initialStep ? 'bg-slate-900 text-white' : 'bg-stone-200 text-slate-400' }}"
                                    >
                                        {{ $s['num'] }}
                                    </div>
                                    <span class="hidden sm:block mt-1 text-[0.65rem] text-slate-400 whitespace-nowrap leading-none">{{ $s['label'] }}</span>
                                </div>
                                @if(!$loop->last)
                                <div data-step-line="{{ $s['num'] }}" class="flex-1 h-px mx-1 mb-3 sm:mb-0 transition-colors duration-200 {{ $s['num'] < $initialStep ? 'bg-slate-900' : 'bg-stone-200' }}"></div>
                                @endif
                            </li>
                            @endforeach
                        </ol>
                    </nav>

                    {{-- ── Step 1: Project type ── --}}
                    <fieldset data-step="1" class="form-step {{ $initialStep !== 1 ? 'hidden' : '' }} space-y-5">
                        <legend class="font-serif text-xl font-medium text-slate-900 mb-6">Wat is je project?</legend>

                        <x-form.select
                            label="Type project"
                            name="project_type"
                            :required="true"
                            placeholder="Kies een optie"
                            :options="[
                                'new_website'     => 'Nieuwe website',
                                'redesign'        => 'Bestaande website vernieuwen',
                                'web_application' => 'Webapplicatie / dashboard',
                                'app_idea'        => 'App idee',
                                'maintenance'     => 'Onderhoud / aanpassingen',
                                'other'           => 'Iets anders',
                            ]"
                        />

                        <x-form.input
                            label="Heb je al een website? (optioneel)"
                            name="existing_website_url"
                            type="url"
                            placeholder="https://jouwwebsite.be"
                        />
                    </fieldset>

                    {{-- ── Step 2: Contact details ── --}}
                    <fieldset data-step="2" class="form-step {{ $initialStep !== 2 ? 'hidden' : '' }} space-y-5">
                        <legend class="font-serif text-xl font-medium text-slate-900 mb-6">Hoe kan ik je bereiken?</legend>

                        <x-form.input label="Naam" name="name" :required="true" autocomplete="name" placeholder="Je volledige naam" />
                        <x-form.input label="Bedrijfs- of handelsnaam (optioneel)" name="company_name" autocomplete="organization" placeholder="Naam van je zaak" />
                        <x-form.input label="E-mailadres" name="email" type="email" :required="true" autocomplete="email" placeholder="jouw@email.be" />
                        <x-form.input label="Telefoonnummer (optioneel)" name="phone" type="tel" autocomplete="tel" placeholder="+32 ..." />
                    </fieldset>

                    {{-- ── Step 3: Project details ── --}}
                    <fieldset data-step="3" class="form-step {{ $initialStep !== 3 ? 'hidden' : '' }} space-y-6">
                        <legend class="font-serif text-xl font-medium text-slate-900 mb-6">Vertel me meer over je project</legend>

                        {{-- Multilingual checkboxes --}}
                        <div>
                            <p class="block text-sm font-medium text-slate-700 mb-3">Meertaligheid <span class="text-slate-400 font-normal">(meerdere keuzes mogelijk)</span></p>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2" role="group" aria-label="Taalwensen">
                                @foreach(['Nederlands', 'Frans', 'Engels', 'Duits', 'Spaans', 'Andere taal', 'Nog niet zeker'] as $lang)
                                <label class="flex items-center gap-2.5 px-3 py-2.5 bg-white border border-stone-200 rounded-lg cursor-pointer hover:border-slate-400 transition-colors duration-150 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input
                                        type="checkbox"
                                        name="multilingual_needs[]"
                                        value="{{ $lang }}"
                                        id="lang-{{ Str::slug($lang) }}"
                                        {{ in_array($lang, (array) old('multilingual_needs', [])) ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-stone-300 text-blue-600 focus:ring-blue-600 cursor-pointer"
                                        @if($lang === 'Andere taal') data-triggers="other-lang-wrapper" @endif
                                    >
                                    <span class="text-sm text-slate-700 select-none">{{ $lang }}</span>
                                </label>
                                @endforeach
                            </div>
                            <x-form.error name="multilingual_needs" />

                            {{-- "Andere taal" conditional text field --}}
                            <div
                                id="other-lang-wrapper"
                                class="{{ in_array('Andere taal', (array) old('multilingual_needs', [])) ? '' : 'hidden' }} mt-3"
                            >
                                <x-form.input
                                    label="Welke andere taal?"
                                    name="other_language"
                                    placeholder="bijv. Italiaans, Portugees …"
                                />
                            </div>
                        </div>

                        <x-form.select
                            label="Contentbeheer"
                            name="content_admin_needs"
                            placeholder="Nog niet zeker"
                            :options="[
                                'static'     => 'Ik wil gewoon een vaste website',
                                'basic_edit' => 'Ik wil zelf teksten of foto\'s kunnen aanpassen',
                                'admin'      => 'Ik wil een eenvoudige adminomgeving',
                                'not_sure'   => 'Nog niet zeker',
                            ]"
                        />

                        <x-form.textarea
                            label="Beschrijving van je project"
                            name="project_description"
                            :required="true"
                            :rows="6"
                            placeholder="Vertel me wat je wil bouwen, voor wie het bedoeld is en wat het moet kunnen doen. Hoe meer detail, hoe beter ik kan inschatten wat het vereist."
                        />
                    </fieldset>

                    {{-- ── Step 4: Budget & timing ── --}}
                    <fieldset data-step="4" class="form-step {{ $initialStep !== 4 ? 'hidden' : '' }} space-y-5">
                        <legend class="font-serif text-xl font-medium text-slate-900 mb-6">Budget en timing</legend>

                        <x-form.select
                            label="Budgetindicatie"
                            name="budget_range"
                            placeholder="Nog niet zeker"
                            :options="[
                                'not_sure'   => 'Nog niet zeker',
                                '750_1250'   => '€750 – €1.250',
                                '1250_2500'  => '€1.250 – €2.500',
                                '2500_5000'  => '€2.500 – €5.000',
                                '5000_plus'  => '€5.000+',
                            ]"
                        />

                        <x-form.select
                            label="Gewenste timing"
                            name="timeline"
                            placeholder="Geen voorkeur"
                            :options="[
                                'no_rush'           => 'Geen haast',
                                'within_1_month'    => 'Binnen 1 maand',
                                'within_2_3_months' => 'Binnen 2–3 maanden',
                                'asap'              => 'Zo snel mogelijk',
                                'not_sure'          => 'Nog niet zeker',
                            ]"
                        />
                    </fieldset>

                    {{-- ── Step 5: Confirm & GDPR ── --}}
                    <fieldset data-step="5" class="form-step {{ $initialStep !== 5 ? 'hidden' : '' }} space-y-5">
                        <legend class="font-serif text-xl font-medium text-slate-900 mb-6">Bevestig en verstuur</legend>

                        {{-- Summary card --}}
                        <div class="bg-stone-50 rounded-xl border border-stone-200 p-5">
                            <h2 class="text-sm font-semibold text-slate-700 mb-3">Overzicht van je aanvraag</h2>
                            <dl class="space-y-1.5 text-sm" id="summary">
                                <div class="flex gap-2">
                                    <dt class="text-slate-500 w-28 shrink-0">Projecttype:</dt>
                                    <dd id="summary-project-type" class="text-slate-800 font-medium">—</dd>
                                </div>
                                <div class="flex gap-2">
                                    <dt class="text-slate-500 w-28 shrink-0">Naam:</dt>
                                    <dd id="summary-name" class="text-slate-800 font-medium">—</dd>
                                </div>
                                <div class="flex gap-2">
                                    <dt class="text-slate-500 w-28 shrink-0">E-mail:</dt>
                                    <dd id="summary-email" class="text-slate-800 font-medium">—</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <label for="field-gdpr_consent" class="flex items-start gap-3 cursor-pointer">
                                <input
                                    type="checkbox"
                                    id="field-gdpr_consent"
                                    name="gdpr_consent"
                                    value="1"
                                    {{ old('gdpr_consent') ? 'checked' : '' }}
                                    required
                                    aria-required="true"
                                    class="mt-0.5 w-4 h-4 rounded border-stone-300 text-blue-600 focus:ring-blue-600 cursor-pointer {{ $errors->has('gdpr_consent') ? 'border-red-400' : '' }}"
                                >
                                <span class="text-sm text-slate-600 leading-relaxed">
                                    Ik ga akkoord met de
                                    <a href="{{ route('privacy') }}" target="_blank" class="text-blue-700 hover:underline">privacyverklaring</a>
                                    en geef toestemming om mijn gegevens te gebruiken voor het behandelen van deze aanvraag.
                                </span>
                            </label>
                            <x-form.error name="gdpr_consent" />
                        </div>
                    </fieldset>

                    {{-- Navigation buttons --}}
                    <div class="flex items-center justify-between pt-8 border-t border-stone-200 mt-8">
                        <button
                            type="button"
                            id="btn-prev"
                            class="{{ $initialStep <= 1 ? 'invisible' : '' }} px-5 py-2.5 text-sm font-medium text-slate-600 border border-stone-200 rounded-lg hover:bg-stone-100 hover:text-slate-900 transition-colors duration-200 cursor-pointer"
                            aria-label="Vorige stap"
                        >
                            ← Vorige
                        </button>
                        <div class="ml-auto flex gap-3">
                            <button
                                type="button"
                                id="btn-next"
                                class="{{ $initialStep >= 5 ? 'hidden' : '' }} px-6 py-2.5 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer"
                                aria-label="Volgende stap"
                            >
                                Volgende →
                            </button>
                            <button
                                type="submit"
                                id="btn-submit"
                                class="{{ $initialStep < 5 ? 'hidden' : '' }} px-6 py-2.5 text-sm font-semibold bg-blue-700 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 cursor-pointer"
                                aria-label="Aanvraag versturen"
                            >
                                Verstuur aanvraag
                            </button>
                        </div>
                    </div>

                </form>
                @endunless
            </div>

        </div>
    </section>

</x-layouts.app>
