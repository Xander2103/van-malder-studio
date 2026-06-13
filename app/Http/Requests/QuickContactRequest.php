<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuickContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'qc_name'    => ['required', 'string', 'max:120'],
            'qc_email'   => ['required', 'email', 'max:190'],
            'qc_message' => ['required', 'string', 'min:5', 'max:2000'],
            'qc_privacy' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'qc_name.required'    => __('site.quick_contact.validation.name_required'),
            'qc_email.required'   => __('site.quick_contact.validation.email_required'),
            'qc_email.email'      => __('site.quick_contact.validation.email_email'),
            'qc_message.required' => __('site.quick_contact.validation.message_required'),
            'qc_message.min'      => __('site.quick_contact.validation.message_min'),
            'qc_message.max'      => __('site.quick_contact.validation.message_max'),
            'qc_privacy.accepted' => __('site.quick_contact.validation.privacy_accepted'),
        ];
    }

    public function attributes(): array
    {
        return [
            'qc_name'    => 'naam',
            'qc_email'   => 'e-mailadres',
            'qc_message' => 'bericht',
            'qc_privacy' => 'privacyverklaring',
        ];
    }
}
