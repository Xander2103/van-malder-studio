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

$loc = app()->getLocale() ?: 'nl';
$privacyHref  = \Illuminate\Support\Facades\Route::has($loc . '.privacy')  ? route($loc . '.privacy')  : route('privacy');
$inquiryRoute = \Illuminate\Support\Facades\Route::has($loc . '.inquiries.store') ? route($loc . '.inquiries.store') : route('inquiries.store');
@endphp

    <section class="max-w-6xl mx-auto px-6 pt-16 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-14 items-start">

            {{-- Left: intro --}}
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

                {{-- Business card — placed below GDPR note --}}
                <x-business-card />
            </div>

            {{-- Right: form --}}
            <div class="lg:col-span-2">

                @if(session('success'))
                <div class="mb-8 rounded-xl bg-green-50 border border-green-200 p-6" role="alert" aria-live="polite">
                    <h2 class="font-serif text-xl font-medium text-green-900">{{ __('site.contact.success_heading') }}</h2>
                    <p class="mt-2 text-sm text-green-700 leading-relaxed">{{ __('site.contact.success_body') }}</p>
                </div>
                @endif

                @if(session('mail_error'))
                <div class="mb-8 rounded-xl bg-amber-50 border border-amber-200 p-6" role="alert" aria-live="polite">
                    <h2 class="font-serif text-xl font-medium text-amber-900">{{ __('site.contact.success_heading') }}</h2>
                    <p class="mt-2 text-sm text-amber-700 leading-relaxed">{{ __('site.contact.mail_error') }}</p>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4" role="alert" aria-live="polite" id="error-summary">
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

                        {{-- Multilingual checkboxes — values stay Dutch for DB consistency --}}
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

                            <div
                                id="other-lang-wrapper"
                                class="{{ in_array('Andere taal', (array) old('multilingual_needs', [])) ? '' : 'hidden' }} mt-3"
                            >
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

                        {{-- Needs checkboxes --}}
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
                            <h2 class="text-sm font-semibold text-slate-700 mb-3">{{ __('site.contact.summary_heading') }}</h2>
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
            </div>

        </div>
    </section>

</x-layouts.app>
