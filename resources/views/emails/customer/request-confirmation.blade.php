<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('site.mail.confirmation_subject') }}</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: #0f172a; line-height: 1.6; margin: 0; padding: 0; background: #f8fafc;">
    <div style="max-width: 560px; margin: 24px auto; background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden;">

        <div style="background: #0f172a; padding: 24px 32px;">
            <h1 style="color: #ffffff; font-size: 18px; font-weight: 600; margin: 0;">Van Malder Studio</h1>
        </div>

        <div style="padding: 32px;">
            <p style="margin: 0 0 16px; font-size: 15px;">{{ __('site.mail.confirmation_greeting', ['name' => $firstName]) }}</p>
            <p style="margin: 0 0 16px; font-size: 15px;">{{ __('site.mail.confirmation_body_1') }}</p>
            <p style="margin: 0 0 32px; font-size: 15px;">{{ __('site.mail.confirmation_body_2') }}</p>
            <p style="margin: 0 0 4px; font-size: 15px;">{{ __('site.mail.confirmation_sign_off') }}</p>
            <p style="margin: 0; font-weight: 600; font-size: 15px;">{{ __('site.mail.confirmation_sender') }}</p>
            <p style="margin: 0; color: #64748b; font-size: 13px;">{{ __('site.mail.confirmation_brand') }}</p>
        </div>

    </div>
</body>
</html>
