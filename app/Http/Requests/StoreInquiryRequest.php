<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                   => ['required', 'string', 'max:120'],
            'company_name'           => ['nullable', 'string', 'max:160'],
            'email'                  => ['required', 'email', 'max:190'],
            'phone'                  => ['nullable', 'string', 'max:60'],
            'existing_website_url'   => ['nullable', 'url', 'max:255'],
            'project_type'           => ['required', Rule::in([
                                            'new_website', 'redesign', 'contact_form', 'seo_local',
                                            'app_tool', 'maintenance', 'audit', 'other',
                                            // legacy values kept for backwards compat
                                            'web_application', 'app_idea',
                                        ])],
            'timeline'               => ['nullable', 'string', 'max:120'],
            'budget_range'           => ['nullable', 'string', 'max:120'],
            'multilingual_needs'     => ['nullable', 'array', 'max:7'],
            'multilingual_needs.*'   => ['string', Rule::in(['Nederlands','Frans','Engels','Duits','Spaans','Andere taal','Nog niet zeker'])],
            'other_language'         => ['nullable', 'string', 'max:120'],
            'content_admin_needs'    => ['nullable', 'string', 'max:255'],
            'needs'                  => ['nullable', 'array', 'max:6'],
            'needs.*'                => ['string', Rule::in([
                                            'seo_visibility', 'seo_landing_pages', 'custom_form',
                                            'multilingual', 'post_launch_maintenance', 'website_advice',
                                        ])],
            'project_description'    => ['required', 'string', 'min:20', 'max:5000'],
            'gdpr_consent'           => ['accepted'],
            'website'                => ['nullable', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'                => 'Je naam is verplicht.',
            'email.required'               => 'Je e-mailadres is verplicht.',
            'email.email'                  => 'Voer een geldig e-mailadres in.',
            'project_type.required'        => 'Kies een projecttype.',
            'project_type.in'              => 'Ongeldig projecttype.',
            'multilingual_needs.*.in'      => 'Ongeldige taaloptie geselecteerd.',
            'project_description.required' => 'Beschrijf je project.',
            'project_description.min'      => 'Beschrijf je project in minstens 20 tekens.',
            'gdpr_consent.accepted'        => 'Je moet akkoord gaan met de privacyverklaring.',
        ];
    }
}
