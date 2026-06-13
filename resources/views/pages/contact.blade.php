@php
    $_loc = app()->getLocale() ?: 'nl';
    $_contactCanonical = \Illuminate\Support\Facades\Route::has($_loc . '.contact') ? route($_loc . '.contact') : route('contact');
@endphp
<x-layouts.app
    :title="__('site.seo.contact_title')"
    :description="__('site.seo.contact_desc')"
    :canonical="$_contactCanonical"
>

@php
$stepFieldMap = [
    1 => ['project_type', 'existing_website_url'],
    2 => ['name', 'company_name', 'email', 'phone'],
    3 => ['multilingual_needs', 'other_language', 'content_admin_needs', 'needs', 'project_description'],
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

$loc          = app()->getLocale() ?: 'nl';
$privacyHref  = \Illuminate\Support\Facades\Route::has($loc . '.privacy')  ? route($loc . '.privacy')  : route('privacy');
$inquiryRoute = \Illuminate\Support\Facades\Route::has($loc . '.inquiries.store')    ? route($loc . '.inquiries.store')    : route('inquiries.store');
$quickRoute   = \Illuminate\Support\Facades\Route::has($loc . '.quick_message.store') ? route($loc . '.quick_message.store') : route('quick_message.store');

$hasQuickErrors = $errors->hasAny(['qc_name', 'qc_email', 'qc_message', 'qc_privacy']);

// Which tab opens by default: switch to project tab if project-side state is active
$activeTab = 'quick';
if (($errors->any() && !$hasQuickErrors) || session('success') || session('mail_error')) {
    $activeTab = 'project';
}
@endphp

<section class="max-w-6xl mx-auto px-6 pt-16 pb-20">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-14 items-start">

        {{-- ── Left: sticky info panel ──────────────────────────────────────────────── --}}
        <div class="lg:sticky lg:top-24">
            <p class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700 uppercase tracking-widest mb-4">
                <span class="w-4 h-px bg-amber-600 inline-block" aria-hidden="true"></span>
                {{ __('site.nav.contact') }}
            </p>
            <h1 class="font-serif text-3xl md:text-4xl font-medium text-slate-900 leading-tight">{{ __('site.contact.heading') }}</h1>
            <p class="mt-3 text-slate-500 leading-relaxed">{{ __('site.contact.body') }}</p>

            <div class="mt-8 space-y-5">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">{{ __('site.contact.email_label') }}</p>
                    <a href="mailto:{{ config('studio.email') }}" class="text-sm text-blue-700 hover:text-blue-900 transition-colors duration-200">
                        {{ config('studio.email') }}
                    </a>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">{{ __('site.contact.location_label') }}</p>
                    <p class="text-sm text-slate-600">{{ config('studio.location') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">{{ __('site.contact.response_label') }}</p>
                    <p class="text-sm text-slate-600">{{ __('site.contact.response_value') }}</p>
                </div>
            </div>

            <div class="mt-8 p-5 bg-stone-100 rounded-xl border border-stone-200">
                <p class="text-sm text-slate-500 leading-relaxed">
                    {!! __('site.contact.gdpr_note', ['link' => '<a href="' . e($privacyHref) . '" class="text-blue-700 hover:underline">' . e(__('site.contact.gdpr_link')) . '</a>']) !!}
                </p>
            </div>

            <x-business-card />
        </div>

        {{-- ── Right: tab-switched forms ───────────────────────────────────────────── --}}
        <div class="lg:col-span-2">

            {{-- Scroll target for quick-contact redirect and direct links --}}
            <span id="snel-bericht" aria-hidden="true"></span>

            <h2 class="font-serif text-2xl font-medium text-slate-900 mb-6">{{ __('site.contact.choice_heading') }}</h2>

            {{-- ── Tab switcher ──────────────────────────────────────────────────────── --}}
            <div role="tablist" aria-label="{{ __('site.contact.choice_heading') }}" class="grid grid-cols-2 gap-3 mb-8">

                {{-- Option A: Quick message --}}
                <button
                    id="btn-tab-quick"
                    role="tab"
                    aria-selected="{{ $activeTab === 'quick' ? 'true' : 'false' }}"
                    aria-controls="tab-quick"
                    type="button"
                    data-tab-target="quick"
                    class="text-left flex flex-col gap-1.5 px-4 py-4 rounded-xl border-2 transition-all duration-200 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500
                           {{ $activeTab === 'quick' ? 'bg-amber-50 border-amber-400' : 'bg-white border-stone-200 hover:border-slate-300' }}"
                >
                    <span class="flex items-center gap-2 text-sm font-semibold {{ $activeTab === 'quick' ? 'text-amber-800' : 'text-slate-700' }}">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 {{ $activeTab === 'quick' ? 'bg-amber-500 text-white' : 'bg-stone-200 text-slate-500' }}" aria-hidden="true">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        {{ __('site.quick_contact.path_a_heading') }}
                    </span>
                    <span class="text-xs leading-snug {{ $activeTab === 'quick' ? 'text-amber-700' : 'text-slate-400' }}">
                        {{ __('site.quick_contact.path_a_helper') }}
                    </span>
                </button>

                {{-- Option B: Project request --}}
                <button
                    id="btn-tab-project"
                    role="tab"
                    aria-selected="{{ $activeTab === 'project' ? 'true' : 'false' }}"
                    aria-controls="tab-project"
                    type="button"
                    data-tab-target="project"
                    class="text-left flex flex-col gap-1.5 px-4 py-4 rounded-xl border-2 transition-all duration-200 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500
                           {{ $activeTab === 'project' ? 'bg-amber-50 border-amber-400' : 'bg-white border-stone-200 hover:border-slate-300' }}"
                >
                    <span class="flex items-center gap-2 text-sm font-semibold {{ $activeTab === 'project' ? 'text-amber-800' : 'text-slate-700' }}">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 {{ $activeTab === 'project' ? 'bg-amber-500 text-white' : 'bg-stone-200 text-slate-500' }}" aria-hidden="true">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        {{ __('site.quick_contact.path_b_heading') }}
                    </span>
                    <span class="text-xs leading-snug {{ $activeTab === 'project' ? 'text-amber-700' : 'text-slate-400' }}">
                        {{ __('site.quick_contact.path_b_helper') }}
                    </span>
                </button>

            </div>{{-- /tablist --}}

            {{-- ════ PANEL A: QUICK CONTACT ══════════════════════════════════════════ --}}
            <div
                id="tab-quick"
                role="tabpanel"
                aria-labelledby="btn-tab-quick"
                tabindex="0"
                class="focus:outline-none {{ $activeTab !== 'quick' ? 'hidden' : '' }}"
            >
                {{-- Trust cues --}}
                <div class="flex flex-wrap gap-x-5 gap-y-1.5 mb-5">
                    @foreach([
                        __('site.quick_contact.trust_free'),
                        __('site.quick_contact.trust_response'),
                        __('site.quick_contact.trust_no_obligation'),
                    ] as $trust)
                    <span class="flex items-center gap-1.5 text-xs text-slate-400">
                        <svg class="w-3.5 h-3.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ $trust }}
                    </span>
                    @endforeach
                </div>

                {{-- Success flash --}}
                @if(session('quick_success'))
                <div class="mb-5 rounded-xl bg-green-50 border border-green-200 p-5" role="alert" aria-live="polite">
                    <h3 class="font-serif text-lg font-medium text-green-900">{{ __('site.quick_contact.success_heading') }}</h3>
                    <p class="mt-1.5 text-sm text-green-700 leading-relaxed">{{ __('site.quick_contact.success_body') }}</p>
                </div>
                @endif

                {{-- Error flash --}}
                @if(session('quick_error'))
                <div class="mb-5 rounded-xl bg-amber-50 border border-amber-200 p-5" role="alert" aria-live="polite">
                    <p class="text-sm text-amber-800 leading-relaxed">{{ __('site.quick_contact.error_body') }}</p>
                </div>
                @endif

                {{-- Validation errors --}}
                @if($hasQuickErrors)
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 p-4" role="alert" aria-live="polite">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->get('qc_name') as $e)<li class="text-sm text-red-700">{{ $e }}</li>@endforeach
                        @foreach($errors->get('qc_email') as $e)<li class="text-sm text-red-700">{{ $e }}</li>@endforeach
                        @foreach($errors->get('qc_message') as $e)<li class="text-sm text-red-700">{{ $e }}</li>@endforeach
                        @foreach($errors->get('qc_privacy') as $e)<li class="text-sm text-red-700">{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif

                @unless(session('quick_success'))
                <form action="{{ $quickRoute }}" method="POST" novalidate id="quick-contact-form">
                    @csrf

                    {{-- Honeypot: must stay empty --}}
                    <div class="absolute left-[-9999px] top-auto w-px h-px overflow-hidden" aria-hidden="true">
                        <label for="qc-hp">Laat dit veld leeg</label>
                        <input type="text" id="qc-hp" name="qc_hp" tabindex="-1" autocomplete="off" value="">
                    </div>

                    {{-- Time check: hidden timestamp --}}
                    <input type="hidden" name="qc_form_time" value="{{ time() }}">

                    <div class="space-y-4">

                        {{-- Name + Email side by side on wider screens --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="qc-name" class="block text-sm font-medium text-slate-700 mb-1.5">
                                    {{ __('site.quick_contact.name_label') }}<span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="qc-name"
                                    name="qc_name"
                                    value="{{ old('qc_name') }}"
                                    required
                                    aria-required="true"
                                    autocomplete="name"
                                    maxlength="120"
                                    class="w-full rounded-lg border px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-amber-500 {{ $errors->has('qc_name') ? 'border-red-400 bg-red-50' : 'border-stone-300 bg-white' }}"
                                >
                            </div>
                            <div>
                                <label for="qc-email" class="block text-sm font-medium text-slate-700 mb-1.5">
                                    {{ __('site.quick_contact.email_label') }}<span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="qc-email"
                                    name="qc_email"
                                    value="{{ old('qc_email') }}"
                                    required
                                    aria-required="true"
                                    autocomplete="email"
                                    maxlength="190"
                                    class="w-full rounded-lg border px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-amber-500 {{ $errors->has('qc_email') ? 'border-red-400 bg-red-50' : 'border-stone-300 bg-white' }}"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="qc-message" class="block text-sm font-medium text-slate-700 mb-1.5">
                                {{ __('site.quick_contact.message_label') }}<span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                            </label>
                            <textarea
                                id="qc-message"
                                name="qc_message"
                                rows="4"
                                required
                                aria-required="true"
                                maxlength="2000"
                                placeholder="{{ __('site.quick_contact.message_placeholder') }}"
                                class="w-full rounded-lg border px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 resize-y transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-amber-500 {{ $errors->has('qc_message') ? 'border-red-400 bg-red-50' : 'border-stone-300 bg-white' }}"
                            >{{ old('qc_message') }}</textarea>
                        </div>

                        <div>
                            <label for="qc-privacy" class="flex items-start gap-3 cursor-pointer">
                                <input
                                    type="checkbox"
                                    id="qc-privacy"
                                    name="qc_privacy"
                                    value="1"
                                    {{ old('qc_privacy') ? 'checked' : '' }}
                                    required
                                    aria-required="true"
                                    class="mt-0.5 w-4 h-4 rounded border-stone-300 text-amber-600 focus:ring-amber-500 cursor-pointer shrink-0 {{ $errors->has('qc_privacy') ? 'border-red-400' : '' }}"
                                >
                                <span class="text-sm text-slate-600 leading-relaxed">
                                    {!! __('site.quick_contact.privacy_label', ['link' => '<a href="' . e($privacyHref) . '" target="_blank" class="text-blue-700 hover:underline">' . e(__('site.quick_contact.privacy_link')) . '</a>']) !!}
                                </span>
                            </label>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold bg-amber-600 text-white rounded-lg hover:bg-amber-700 active:bg-amber-800 transition-colors duration-200 cursor-pointer shadow-sm"
                        >
                            {{ __('site.quick_contact.cta') }}
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </button>

                    </div>
                </form>
                @endunless

            </div>{{-- #tab-quick --}}

            {{-- ════ PANEL B: PROJECT REQUEST ════════════════════════════════════════ --}}
            <div
                id="tab-project"
                role="tabpanel"
                aria-labelledby="btn-tab-project"
                tabindex="0"
                class="focus:outline-none {{ $activeTab !== 'project' ? 'hidden' : '' }}"
            >
                @if(session('success'))
                <div class="mb-6 rounded-xl bg-green-50 border border-green-200 p-6" role="alert" aria-live="polite">
                    <h3 class="font-serif text-xl font-medium text-green-900">{{ __('site.contact.success_heading') }}</h3>
                    <p class="mt-2 text-sm text-green-700 leading-relaxed">{{ __('site.contact.success_body') }}</p>
                </div>
                @endif

                @if(session('mail_error'))
                <div class="mb-6 rounded-xl bg-amber-50 border border-amber-200 p-6" role="alert" aria-live="polite">
                    <h3 class="font-serif text-xl font-medium text-amber-900">{{ __('site.contact.success_heading') }}</h3>
                    <p class="mt-2 text-sm text-amber-700 leading-relaxed">{{ __('site.contact.mail_error') }}</p>
                </div>
                @endif

                @if($errors->any() && !$hasQuickErrors)
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 p-4" role="alert" aria-live="polite" id="error-summary">
                    <p class="text-sm font-semibold text-red-800 mb-2">{{ __('site.contact.validation_choose') }}</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                        <li class="text-sm text-red-700">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @unless(session('success') || session('mail_error'))
                <form
                    action="{{ $inquiryRoute }}"
                    method="POST"
                    novalidate
                    id="inquiry-form"
                    data-initial-step="{{ $initialStep }}"
                >
                    @csrf

                    {{-- Honeypot --}}
                    <div class="hidden" aria-hidden="true">
                        <label for="website-field">Laat dit veld leeg</label>
                        <input type="text" id="website-field" name="website" tabindex="-1" autocomplete="off" value="">
                    </div>

                    {{-- Step indicator --}}
                    <nav class="mb-8" aria-label="{{ __('site.contact.step_project') }}">
                        <ol class="flex items-center gap-0" id="step-indicators" role="list">
                            @foreach([
                                ['num' => 1, 'label' => __('site.contact.step_project')],
                                ['num' => 2, 'label' => __('site.contact.step_details')],
                                ['num' => 3, 'label' => __('site.contact.step_info')],
                                ['num' => 4, 'label' => __('site.contact.step_budget')],
                                ['num' => 5, 'label' => __('site.contact.step_confirm')],
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
                        <legend class="font-serif text-xl font-medium text-slate-900 mb-6">{{ __('site.contact.step1_heading') }}</legend>

                        <x-form.select
                            :label="__('site.contact.project_type_label')"
                            name="project_type"
                            :required="true"
                            placeholder="—"
                            :options="[
                                'new_website'  => __('site.contact.type_new_website'),
                                'redesign'     => __('site.contact.type_redesign'),
                                'webshop'      => __('site.contact.type_webshop'),
                                'contact_form' => __('site.contact.type_contact_form'),
                                'seo_local'    => __('site.contact.type_seo_local'),
                                'app_tool'     => __('site.contact.type_app_tool'),
                                'maintenance'  => __('site.contact.type_maintenance'),
                                'audit'        => __('site.contact.type_audit'),
                                'other'        => __('site.contact.type_other'),
                            ]"
                        />

                        <x-form.input
                            :label="__('site.contact.existing_url_label')"
                            name="existing_website_url"
                            type="url"
                            :placeholder="__('site.contact.placeholder_url')"
                        />
                    </fieldset>

                    {{-- ── Step 2: Contact details ── --}}
                    <fieldset data-step="2" class="form-step {{ $initialStep !== 2 ? 'hidden' : '' }} space-y-5">
                        <legend class="font-serif text-xl font-medium text-slate-900 mb-6">{{ __('site.contact.step2_heading') }}</legend>

                        <x-form.input :label="__('site.contact.name_label')" name="name" :required="true" autocomplete="name" :placeholder="__('site.contact.placeholder_name')" />
                        <x-form.input :label="__('site.contact.company_label')" name="company_name" autocomplete="organization" :placeholder="__('site.contact.placeholder_company')" />
                        <x-form.input :label="__('site.contact.email_field_label')" name="email" type="email" :required="true" autocomplete="email" :placeholder="__('site.contact.placeholder_email')" />
                        <x-form.input :label="__('site.contact.phone_label')" name="phone" type="tel" autocomplete="tel" :placeholder="__('site.contact.placeholder_phone')" />
                    </fieldset>

                    {{-- ── Step 3: Project details ── --}}
                    <fieldset data-step="3" class="form-step {{ $initialStep !== 3 ? 'hidden' : '' }} space-y-6">
                        <legend class="font-serif text-xl font-medium text-slate-900 mb-6">{{ __('site.contact.step3_heading') }}</legend>

                        <div>
                            <p class="block text-sm font-medium text-slate-700 mb-3">{{ __('site.contact.multilingual_label') }} <span class="text-slate-400 font-normal">{{ __('site.contact.multilingual_hint') }}</span></p>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2" role="group" aria-label="{{ __('site.contact.multilingual_label') }}">
                                @foreach([
                                    'Nederlands'     => 'lang_nl',
                                    'Frans'          => 'lang_fr',
                                    'Engels'         => 'lang_en',
                                    'Duits'          => 'lang_de',
                                    'Spaans'         => 'lang_es',
                                    'Andere taal'    => 'lang_other',
                                    'Nog niet zeker' => 'lang_not_sure',
                                ] as $value => $transKey)
                                <label class="flex items-center gap-2.5 px-3 py-2.5 bg-white border border-stone-200 rounded-lg cursor-pointer hover:border-slate-400 transition-colors duration-150 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input
                                        type="checkbox"
                                        name="multilingual_needs[]"
                                        value="{{ $value }}"
                                        id="lang-{{ Str::slug($value) }}"
                                        {{ in_array($value, (array) old('multilingual_needs', [])) ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-stone-300 text-blue-600 focus:ring-blue-600 cursor-pointer"
                                        @if($value === 'Andere taal') data-triggers="other-lang-wrapper" @endif
                                    >
                                    <span class="text-sm text-slate-700 select-none">{{ __('site.contact.' . $transKey) }}</span>
                                </label>
                                @endforeach
                            </div>
                            <x-form.error name="multilingual_needs" />

                            <div id="other-lang-wrapper" class="{{ in_array('Andere taal', (array) old('multilingual_needs', [])) ? '' : 'hidden' }} mt-3">
                                <x-form.input
                                    :label="__('site.contact.other_lang_label')"
                                    name="other_language"
                                    :placeholder="__('site.contact.other_lang_ph')"
                                />
                            </div>
                        </div>

                        <x-form.select
                            :label="__('site.contact.admin_label')"
                            name="content_admin_needs"
                            placeholder="—"
                            :options="[
                                'static'     => __('site.contact.admin_static'),
                                'basic_edit' => __('site.contact.admin_basic_edit'),
                                'admin'      => __('site.contact.admin_admin'),
                                'not_sure'   => __('site.contact.admin_not_sure'),
                            ]"
                        />

                        <div>
                            <p class="block text-sm font-medium text-slate-700 mb-3">{{ __('site.contact.needs_label') }} <span class="text-slate-400 font-normal">{{ __('site.contact.needs_hint') }}</span></p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2" role="group" aria-label="{{ __('site.contact.needs_label') }}">
                                @foreach([
                                    'seo_visibility'          => 'need_seo',
                                    'seo_landing_pages'       => 'need_landing_pages',
                                    'custom_form'             => 'need_form',
                                    'products_online'         => 'need_products',
                                    'multilingual'            => 'need_multilingual',
                                    'post_launch_maintenance' => 'need_maintenance',
                                    'website_advice'          => 'need_advice',
                                    'ai_summary_support'      => 'need_ai_summary',
                                    'auto_followup'           => 'need_auto_followup',
                                ] as $value => $transKey)
                                <label class="flex items-center gap-2.5 px-3 py-2.5 bg-white border border-stone-200 rounded-lg cursor-pointer hover:border-slate-400 transition-colors duration-150 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input
                                        type="checkbox"
                                        name="needs[]"
                                        value="{{ $value }}"
                                        {{ in_array($value, (array) old('needs', [])) ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-stone-300 text-blue-600 focus:ring-blue-600 cursor-pointer"
                                    >
                                    <span class="text-sm text-slate-700 select-none">{{ __('site.contact.' . $transKey) }}</span>
                                </label>
                                @endforeach
                            </div>
                            <x-form.error name="needs" />
                        </div>

                        <x-form.textarea
                            :label="__('site.contact.description_label')"
                            name="project_description"
                            :required="true"
                            :rows="6"
                            :placeholder="__('site.contact.description_ph')"
                        />
                    </fieldset>

                    {{-- ── Step 4: Budget & timing ── --}}
                    <fieldset data-step="4" class="form-step {{ $initialStep !== 4 ? 'hidden' : '' }} space-y-5">
                        <legend class="font-serif text-xl font-medium text-slate-900 mb-6">{{ __('site.contact.step4_heading') }}</legend>

                        <x-form.select
                            :label="__('site.contact.budget_label')"
                            name="budget_range"
                            placeholder="—"
                            :options="[
                                'not_sure'   => __('site.contact.budget_not_sure'),
                                '750_1250'   => __('site.contact.budget_750_1250'),
                                '1250_2500'  => __('site.contact.budget_1250_2500'),
                                '2500_5000'  => __('site.contact.budget_2500_5000'),
                                '5000_plus'  => __('site.contact.budget_5000_plus'),
                            ]"
                        />

                        <x-form.select
                            :label="__('site.contact.timeline_label')"
                            name="timeline"
                            placeholder="—"
                            :options="[
                                'no_rush'           => __('site.contact.timeline_no_rush'),
                                'within_1_month'    => __('site.contact.timeline_1_month'),
                                'within_2_3_months' => __('site.contact.timeline_2_3_months'),
                                'asap'              => __('site.contact.timeline_asap'),
                                'not_sure'          => __('site.contact.timeline_not_sure'),
                            ]"
                        />
                    </fieldset>

                    {{-- ── Step 5: Confirm & GDPR ── --}}
                    <fieldset data-step="5" class="form-step {{ $initialStep !== 5 ? 'hidden' : '' }} space-y-5">
                        <legend class="font-serif text-xl font-medium text-slate-900 mb-6">{{ __('site.contact.step5_heading') }}</legend>

                        <div class="bg-stone-50 rounded-xl border border-stone-200 p-5">
                            <h3 class="text-sm font-semibold text-slate-700 mb-3">{{ __('site.contact.summary_heading') }}</h3>
                            <dl class="space-y-1.5 text-sm" id="summary">
                                <div class="flex gap-2">
                                    <dt class="text-slate-500 w-28 shrink-0">{{ __('site.contact.summary_type') }}</dt>
                                    <dd id="summary-project-type" class="text-slate-800 font-medium">—</dd>
                                </div>
                                <div class="flex gap-2">
                                    <dt class="text-slate-500 w-28 shrink-0">{{ __('site.contact.summary_name') }}</dt>
                                    <dd id="summary-name" class="text-slate-800 font-medium">—</dd>
                                </div>
                                <div class="flex gap-2">
                                    <dt class="text-slate-500 w-28 shrink-0">{{ __('site.contact.summary_email') }}</dt>
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
                                    {!! __('site.contact.gdpr_label', ['link' => '<a href="' . e($privacyHref) . '" target="_blank" class="text-blue-700 hover:underline">' . e(__('site.contact.gdpr_link')) . '</a>']) !!}
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
                            aria-label="{{ __('site.contact.btn_prev') }}"
                        >
                            {{ __('site.contact.btn_prev') }}
                        </button>
                        <div class="ml-auto flex gap-3">
                            <button
                                type="button"
                                id="btn-next"
                                class="{{ $initialStep >= 5 ? 'hidden' : '' }} px-6 py-2.5 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors duration-200 cursor-pointer"
                                aria-label="{{ __('site.contact.btn_next') }}"
                            >
                                {{ __('site.contact.btn_next') }}
                            </button>
                            <button
                                type="submit"
                                id="btn-submit"
                                class="{{ $initialStep < 5 ? 'hidden' : '' }} px-6 py-2.5 text-sm font-semibold bg-blue-700 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 cursor-pointer"
                                aria-label="{{ __('site.contact.btn_submit') }}"
                            >
                                {{ __('site.contact.btn_submit') }}
                            </button>
                        </div>
                    </div>

                </form>
                @endunless

            </div>{{-- #tab-project --}}

        </div>{{-- .lg:col-span-2 --}}
    </div>
</section>

<script>
(function () {
    var tabBtns  = document.querySelectorAll('[role="tab"]');
    var tabPanels = document.querySelectorAll('[role="tabpanel"]');

    function activate(targetId) {
        tabBtns.forEach(function (btn) {
            var isActive = btn.dataset.tabTarget === targetId;
            btn.setAttribute('aria-selected', isActive ? 'true' : 'false');

            // Card background / border
            btn.classList.toggle('bg-amber-50',     isActive);
            btn.classList.toggle('border-amber-400', isActive);
            btn.classList.toggle('bg-white',         !isActive);
            btn.classList.toggle('border-stone-200', !isActive);

            // Label span (first direct child span)
            var label = btn.querySelector('span');
            if (label) {
                label.classList.toggle('text-amber-800', isActive);
                label.classList.toggle('text-slate-700', !isActive);

                // Icon dot inside label
                var dot = label.querySelector('span[aria-hidden]');
                if (dot) {
                    dot.classList.toggle('bg-amber-500', isActive);
                    dot.classList.toggle('text-white',   isActive);
                    dot.classList.toggle('bg-stone-200', !isActive);
                    dot.classList.toggle('text-slate-500', !isActive);
                }
            }

            // Helper span (last direct child span)
            var spans = btn.querySelectorAll(':scope > span');
            var helper = spans[spans.length - 1];
            if (helper && helper !== label) {
                helper.classList.toggle('text-amber-700', isActive);
                helper.classList.toggle('text-slate-400', !isActive);
            }
        });

        tabPanels.forEach(function (panel) {
            panel.classList.toggle('hidden', panel.id !== 'tab-' + targetId);
        });
    }

    tabBtns.forEach(function (btn, i) {
        btn.addEventListener('click', function () {
            activate(btn.dataset.tabTarget);
        });

        btn.addEventListener('keydown', function (e) {
            var len = tabBtns.length;
            if (e.key === 'ArrowRight') {
                var next = tabBtns[(i + 1) % len];
                next.focus();
                activate(next.dataset.tabTarget);
                e.preventDefault();
            }
            if (e.key === 'ArrowLeft') {
                var prev = tabBtns[(i - 1 + len) % len];
                prev.focus();
                activate(prev.dataset.tabTarget);
                e.preventDefault();
            }
        });
    });
})();
</script>

</x-layouts.app>
