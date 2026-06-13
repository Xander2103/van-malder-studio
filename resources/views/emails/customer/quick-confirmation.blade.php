<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('site.quick_contact.confirmation_subject') }}</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: #0f172a; line-height: 1.6; margin: 0; padding: 0; background: #f8fafc;">
    <div style="max-width: 560px; margin: 24px auto; background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden;">

        <div style="background: #0f172a; padding: 24px 32px;">
            <h1 style="color: #ffffff; font-size: 18px; font-weight: 600; margin: 0;">Van Malder Studio</h1>
        </div>

        <div style="padding: 32px;">
            <p style="margin: 0 0 16px; font-size: 15px;">{{ __('site.quick_contact.confirmation_greeting', ['name' => $firstName]) }}</p>
            <p style="margin: 0 0 16px; font-size: 15px;">{{ __('site.quick_contact.confirmation_body_1') }}</p>
            <p style="margin: 0 0 24px; font-size: 15px;">{{ __('site.quick_contact.confirmation_body_2') }}</p>

            @if(!empty($userMessage))
            <div style="background: #f8fafc; border-left: 3px solid #d1d5db; padding: 12px 16px; margin-bottom: 24px; border-radius: 0 4px 4px 0;">
                <p style="color: #64748b; font-size: 12px; font-weight: 500; margin: 0 0 6px; text-transform: uppercase; letter-spacing: 0.05em;">Uw bericht</p>
                <p style="color: #374151; font-size: 14px; margin: 0; white-space: pre-wrap;">{{ $userMessage }}</p>
            </div>
            @endif

            <p style="margin: 0 0 4px; font-size: 15px;">{{ __('site.quick_contact.confirmation_sign_off') }}</p>
            <p style="margin: 0; font-weight: 600; font-size: 15px;">{{ __('site.quick_contact.confirmation_sender') }}</p>
            <p style="margin: 0; color: #64748b; font-size: 13px;">{{ __('site.quick_contact.confirmation_brand') }}</p>
        </div>

    </div>
</body>
</html>
