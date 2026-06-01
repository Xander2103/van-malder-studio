# Mail & Privacy Acknowledgement — Implementation Design

**Date:** 2026-06-01
**Project:** Van Malder Studio (Laravel 12, vanmalderstudio.be)
**Author:** Xander Van Malder / Claude

---

## Context

The public contact/request form already stores inquiries (`Inquiry` model, `inquiries` table). It already validates and stores `gdpr_consent` as a boolean. Email sending is not yet implemented — `InquiryService::store()` has a `// TODO` comment.

This spec covers:
1. Updating the existing privacy checkbox label/text/link per locale
2. Admin notification email with ALL submitted answers
3. Customer confirmation email in the visitor's locale
4. Mail exception handling with partial-success flash
5. Config, translations, and tests

---

## Decisions

| Decision | Choice |
|---|---|
| Privacy checkbox | Reuse existing `gdpr_consent` field. Update labels/text only. No migration. |
| Mail sending | Synchronous `Mail::to()->send()`. No queued mail. |
| Mail failure | Catch Throwable, log error, redirect with `mail_error` flash. Inquiry always saved first. |
| Admin email locale | Always Dutch/internal. |
| Customer email locale | Visitor locale via `->locale($inquiry->locale ?? 'nl')` on the Mailable. |
| Formatter approach | `InquiryFormatter::toRows(Inquiry)` — known fields get Dutch labels, unknown/dynamic fields get humanised fallback labels. Nothing dropped. |
| Architecture | Thin controller, `sendNotifications()` in `InquiryService`, Mailables + Blade views, static formatter helper. |

---

## Data Flow

```
POST /{locale}/contact
  → StoreInquiryRequest (validates gdpr_consent with `accepted` rule)
  → InquiryController::store()
      │
      ├─ honeypot check (existing, unchanged)
      │
      ├─ InquiryService::store() → Inquiry saved to DB  ← always happens first
      │
      ├─ try:
      │    InquiryService::sendNotifications(Inquiry $inquiry)
      │      ├─ Mail::to(admin)->send(new AdminRequestReceivedMail($inquiry))
      │      └─ Mail::to(visitor)->send(
      │             (new CustomerRequestConfirmationMail($inquiry))->locale($inquiry->locale ?? 'nl')
      │         )
      │
      ├─ catch \Throwable $e:
      │    Log::error('Mail failed for inquiry #{id} ({email}): ...', [...])
      │    redirect()->route($contactRoute)->with('mail_error', true)
      │
      └─ redirect()->route($contactRoute)->with('success', true)
```

---

## Files

### New files

| Path | Purpose |
|---|---|
| `app/Mail/AdminRequestReceivedMail.php` | Admin notification Mailable |
| `app/Mail/CustomerRequestConfirmationMail.php` | Customer confirmation Mailable |
| `app/Helpers/InquiryFormatter.php` | Static formatter: Inquiry → `[[label, value], ...]` |
| `resources/views/emails/admin/request-received.blade.php` | Admin email HTML view |
| `resources/views/emails/customer/request-confirmation.blade.php` | Customer confirmation HTML view |
| `tests/Feature/InquirySubmissionTest.php` | Feature tests |

### Modified files

| Path | Change |
|---|---|
| `app/Http/Controllers/InquiryController.php` | Add `sendNotifications` call + try/catch + `mail_error` flash |
| `app/Services/InquiryService.php` | Add `sendNotifications(Inquiry $inquiry): void` |
| `config/mail.php` | Add `contact_notification_email` key |
| `.env.example` | Add all required mail env vars + `CONTACT_NOTIFICATION_EMAIL` |
| `lang/nl/site.php` | Update `contact.gdpr_label`, `contact.validation.gdpr_accepted`, add `contact.mail_error`, add `mail.*` keys |
| `lang/fr/site.php` | Same structure, French text |
| `lang/en/site.php` | Same structure, English text |
| `lang/de/site.php` | Same structure, German text |
| `resources/views/pages/contact.blade.php` | Add `@if(session('mail_error'))` amber flash block; hide form on `mail_error` |

**No new migrations. No new model fields. No new routes.**

---

## Section 1 — Privacy Checkbox (Task 2)

The checkbox already exists in the form (`Step 5`, `gdpr_consent`). The `StoreInquiryRequest` already enforces `accepted`. The `Inquiry` model already stores it as a boolean.

**Only change:** update label text and validation error message in all 4 locale lang files.

### Updated translation keys

**NL (`lang/nl/site.php`):**
```php
'gdpr_label'  => 'Ik ga akkoord dat Van Malder Studio mijn gegevens gebruikt om mijn aanvraag te beantwoorden en heb de :link gelezen.',
'gdpr_link'   => 'privacyverklaring',   // anchor text — links to locale privacy route
// validation:
'gdpr_accepted' => 'Gelieve akkoord te gaan met de privacyverklaring voordat je je aanvraag verzendt.',
```

**FR (`lang/fr/site.php`):**
```php
'gdpr_label'  => "J'accepte que Van Malder Studio utilise mes données pour répondre à ma demande et j'ai lu la :link.",
'gdpr_link'   => 'politique de confidentialité',
'gdpr_accepted' => 'Veuillez accepter la politique de confidentialité avant d\'envoyer votre demande.',
```

**EN (`lang/en/site.php`):**
```php
'gdpr_label'  => 'I agree that Van Malder Studio may use my details to respond to my request and I have read the :link.',
'gdpr_link'   => 'privacy policy',
'gdpr_accepted' => 'Please accept the privacy policy before sending your request.',
```

**DE (`lang/de/site.php`):**
```php
'gdpr_label'  => 'Ich stimme zu, dass Van Malder Studio meine Daten verwendet, um meine Anfrage zu beantworten, und habe die :link gelesen.',
'gdpr_link'   => 'Datenschutzerklärung',
'gdpr_accepted' => 'Bitte akzeptieren Sie die Datenschutzerklärung, bevor Sie Ihre Anfrage senden.',
```

The Blade view already injects `$privacyHref` pointing to the correct locale's privacy route. The `:link` placeholder renders as a properly escaped anchor tag. No Blade change needed for the checkbox itself.

---

## Section 2 — InquiryFormatter (Task 3)

`app/Helpers/InquiryFormatter.php` — pure static class, no dependencies, independently testable.

### Method signature
```php
public static function toRows(Inquiry $inquiry): array
// Returns: [['label' => string, 'value' => string], ...]
```

### Field coverage

**Fixed known fields (Dutch labels, value mapped or humanised):**

| Field | Label | Value |
|---|---|---|
| `id` | `#Aanvraag` | `#{id}` |
| `created_at` | `Ontvangen` | `d/m/Y H:i` |
| `locale` | `Formuliertaal` | raw string |
| `name` | `Naam` | raw |
| `email` | `E-mail` | raw |
| `phone` | `Telefoon` | raw or `—` |
| `company_name` | `Bedrijf` | raw or `—` |
| `project_type` | `Projecttype` | mapped to NL label or raw key as fallback |
| `existing_website_url` | `Bestaande website` | raw or `—` |
| `multilingual_needs` | `Meertaligheid` | array joined with `, ` or `—` |
| `other_language` | `Andere taal` | raw (only shown if not null) |
| `content_admin_needs` | `Contentbeheer` | mapped to NL label or raw key |
| `needs` | `Extra behoeften` | each key mapped to NL label, joined with `, ` or `—` |
| `project_description` | `Projectomschrijving` | raw |
| `budget_range` | `Budget` | mapped to NL label or raw key |
| `timeline` | `Gewenste timing` | mapped to NL label or raw key |
| `gdpr_consent` | `Privacyverklaring` | `Ja` |
| `source` | `Aanvraagbron` | raw or `—` |
| `ip_hash` | `IP-hash` | raw or `—` |

**Completeness rules:**
- Null/empty values → `—` (never silently omitted for known fields)
- Arrays → joined with `, `; empty array → `—`
- Unknown keys in `needs[]` or `multilingual_needs[]` → humanised: `seo_visibility` → `Seo visibility`
- `other_language` is only included in the row list when non-null (avoid clutter for `—`)
- Any future DB column on `Inquiry` not in the known-fields list: included by computing `array_diff_key($inquiry->toArray(), $knownFields)`, label = `Str::title(str_replace('_', ' ', $key))`

### Value maps (hardcoded, Dutch, internal)

```php
private static array $projectTypeMap = [
    'new_website'   => 'Nieuwe website',
    'redesign'      => 'Website vernieuwen',
    'webshop'       => 'Webshop / online verkoop',
    'contact_form'  => 'Contact- of offerteformulier',
    'seo_local'     => 'SEO / lokale vindbaarheid',
    'app_tool'      => 'App, tool of webapplicatie',
    'maintenance'   => 'Onderhoud / aanpassingen',
    'audit'         => 'Website audit / advies',
    'other'         => 'Iets anders',
    'web_application' => 'Webapplicatie (legacy)',
    'app_idea'      => 'App-idee (legacy)',
];

private static array $needsMap = [
    'seo_visibility'          => 'Beter gevonden via Google',
    'seo_landing_pages'       => "SEO-landingspagina's",
    'custom_form'             => 'Formulier op maat',
    'products_online'         => 'Producten online tonen of verkopen',
    'multilingual'            => 'Meertaligheid',
    'post_launch_maintenance' => 'Onderhoud na lancering',
    'website_advice'          => 'Advies over huidige website',
    'ai_summary_support'      => 'AI-ondersteuning',
    'auto_followup'           => 'Automatische opvolging',
];

private static array $adminNeedsMap = [
    'static'     => 'Vaste website, geen beheer',
    'basic_edit' => "Zelf teksten/foto's aanpassen",
    'admin'      => 'Eenvoudige adminomgeving',
    'not_sure'   => 'Nog niet zeker',
];

private static array $budgetMap = [
    'not_sure'   => 'Nog niet zeker',
    '750_1250'   => '€750 – €1.250',
    '1250_2500'  => '€1.250 – €2.500',
    '2500_5000'  => '€2.500 – €5.000',
    '5000_plus'  => '€5.000+',
];

private static array $timelineMap = [
    'no_rush'           => 'Geen haast',
    'within_1_month'    => 'Binnen 1 maand',
    'within_2_3_months' => 'Binnen 2–3 maanden',
    'asap'              => 'Zo snel mogelijk',
    'not_sure'          => 'Nog niet zeker',
];
```

---

## Section 3 — Mailables

### AdminRequestReceivedMail

```php
namespace App\Mail;

class AdminRequestReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Inquiry $inquiry) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nieuwe aanvraag via Van Malder Studio — ' . $this->inquiry->name,
            replyTo: filter_var($this->inquiry->email, FILTER_VALIDATE_EMAIL)
                ? [new Address($this->inquiry->email, $this->inquiry->name)]
                : [],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.request-received',
            with: [
                'inquiry' => $this->inquiry,
                'rows'    => InquiryFormatter::toRows($this->inquiry),
            ],
        );
    }
}
```

- From: Laravel default (`MAIL_FROM_ADDRESS` / `MAIL_FROM_NAME`) — never the visitor's email
- Reply-To: visitor email+name if valid email, else no reply-to
- View passes `$rows` (label/value pairs) + `$inquiry` for any direct access needed

### CustomerRequestConfirmationMail

```php
namespace App\Mail;

class CustomerRequestConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Inquiry $inquiry) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('site.mail.confirmation_subject'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.customer.request-confirmation',
            with: ['inquiry' => $this->inquiry],
        );
    }
}
```

- Locale set at send time: `(new CustomerRequestConfirmationMail($inquiry))->locale($inquiry->locale ?? 'nl')`
- This means `__()` calls in the view + `envelope()` both resolve to the visitor's locale
- Greeting uses first word of visitor's name: `Str::before($inquiry->name, ' ') ?: $inquiry->name` — handles single-word names cleanly

---

## Section 4 — Translation additions (all 4 locales)

Keys added to `site.php` in each locale:

### `contact.mail_error` (partial-success flash)
- NL: `'Je aanvraag werd goed ontvangen, maar er was een probleem bij het verzenden van de bevestigingsmail. Ik neem alsnog zo snel mogelijk contact met je op.'`
- FR: `'Votre demande a bien été reçue, mais un problème est survenu lors de l\'envoi de l\'e-mail de confirmation. Je vous contacterai malgré tout dès que possible.'`
- EN: `'Your request was received, but there was a problem sending the confirmation email. I will still contact you as soon as possible.'`
- DE: `'Ihre Anfrage wurde erhalten, aber beim Senden der Bestätigungs-E-Mail ist ein Problem aufgetreten. Ich werde mich trotzdem so schnell wie möglich bei Ihnen melden.'`

### `mail.*` (customer confirmation email content)

**NL:**
```php
'mail' => [
    'confirmation_subject' => 'We hebben je aanvraag goed ontvangen',
    'confirmation_greeting' => 'Hallo :name,',
    'confirmation_body_1'   => 'Bedankt voor je aanvraag via Van Malder Studio. Ik heb je bericht goed ontvangen en bekijk het zo snel mogelijk.',
    'confirmation_body_2'   => 'Ik neem binnenkort contact met je op om je aanvraag verder te bespreken.',
    'confirmation_sign_off' => 'Met vriendelijke groeten,',
    'confirmation_sender'   => 'Xander',
    'confirmation_brand'    => 'Van Malder Studio',
],
```

**FR:**
```php
'mail' => [
    'confirmation_subject' => 'Nous avons bien reçu votre demande',
    'confirmation_greeting' => 'Bonjour :name,',
    'confirmation_body_1'   => 'Merci pour votre demande via Van Malder Studio. Je l\'ai bien reçue et je vais l\'examiner dans les plus brefs délais.',
    'confirmation_body_2'   => 'Je vous contacterai prochainement pour discuter de votre demande.',
    'confirmation_sign_off' => 'Cordialement,',
    'confirmation_sender'   => 'Xander',
    'confirmation_brand'    => 'Van Malder Studio',
],
```

**EN:**
```php
'mail' => [
    'confirmation_subject' => 'We have received your request',
    'confirmation_greeting' => 'Hello :name,',
    'confirmation_body_1'   => 'Thank you for your request via Van Malder Studio. I have received your message and will review it as soon as possible.',
    'confirmation_body_2'   => 'I will be in touch shortly to discuss your request further.',
    'confirmation_sign_off' => 'Kind regards,',
    'confirmation_sender'   => 'Xander',
    'confirmation_brand'    => 'Van Malder Studio',
],
```

**DE:**
```php
'mail' => [
    'confirmation_subject' => 'Wir haben Ihre Anfrage erhalten',
    'confirmation_greeting' => 'Hallo :name,',
    'confirmation_body_1'   => 'Vielen Dank für Ihre Anfrage über Van Malder Studio. Ich habe Ihre Nachricht erhalten und werde sie so schnell wie möglich prüfen.',
    'confirmation_body_2'   => 'Ich werde mich in Kürze bei Ihnen melden, um Ihre Anfrage weiter zu besprechen.',
    'confirmation_sign_off' => 'Mit freundlichen Grüßen,',
    'confirmation_sender'   => 'Xander',
    'confirmation_brand'    => 'Van Malder Studio',
],
```

---

## Section 5 — Config

Add to `config/mail.php` (at the end, before closing bracket):
```php
'contact_notification_email' => env('CONTACT_NOTIFICATION_EMAIL', env('MAIL_FROM_ADDRESS', 'info@vanmalderstudio.be')),
```

`.env.example` additions:

> **Note:** Laravel 12 uses `MAIL_SCHEME` (not `MAIL_ENCRYPTION`). The `config/mail.php` reads `env('MAIL_SCHEME')`. Use `MAIL_SCHEME=ssl` for port 465 SMTPS.

```
MAIL_MAILER=smtp
MAIL_HOST=mail.vanmalderstudio.be
MAIL_PORT=465
MAIL_SCHEME=ssl
MAIL_USERNAME=info@vanmalderstudio.be
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=info@vanmalderstudio.be
MAIL_FROM_NAME="Van Malder Studio"

CONTACT_NOTIFICATION_EMAIL=info@vanmalderstudio.be
```

---

## Section 6 — InquiryService changes

```php
// Add to InquiryService:

public function sendNotifications(Inquiry $inquiry): void
{
    $adminEmail = config('mail.contact_notification_email');

    Mail::to($adminEmail)
        ->send(new AdminRequestReceivedMail($inquiry));

    Mail::to($inquiry->email)
        ->send(
            (new CustomerRequestConfirmationMail($inquiry))
                ->locale($inquiry->locale ?? 'nl')
        );
}
```

---

## Section 7 — InquiryController changes

```php
// Modified store() method:

public function store(StoreInquiryRequest $request)
{
    $locale       = app()->getLocale() ?: 'nl';
    $contactRoute = Route::has($locale . '.contact') ? $locale . '.contact' : 'contact';

    if ($request->filled('website')) {
        return redirect()->route($contactRoute)->with('success', true);
    }

    $inquiry = $this->inquiryService->store($request->validated(), $request);

    try {
        $this->inquiryService->sendNotifications($inquiry);
    } catch (\Throwable $e) {
        \Log::error('Mail sending failed for inquiry #' . $inquiry->id . ' (' . $inquiry->email . '): ' . $e->getMessage(), [
            'inquiry_id' => $inquiry->id,
            'inquiry_email' => $inquiry->email,
            'exception'  => $e,
        ]);
        return redirect()->route($contactRoute)->with('mail_error', true);
    }

    return redirect()->route($contactRoute)->with('success', true);
}
```

---

## Section 8 — Flash message in contact.blade.php

Add after the existing `@if(session('success'))` block:

```blade
@if(session('mail_error'))
<div class="mb-8 rounded-xl bg-amber-50 border border-amber-200 p-6" role="alert" aria-live="polite">
    <h2 class="font-serif text-xl font-medium text-amber-900">{{ __('site.contact.success_heading') }}</h2>
    <p class="mt-2 text-sm text-amber-700 leading-relaxed">{{ __('site.contact.mail_error') }}</p>
</div>
@endif
```

Update `@unless(session('success'))` to `@unless(session('success') || session('mail_error'))` so the form is hidden in both states.

---

## Section 9 — Tests

`tests/Feature/InquirySubmissionTest.php`

```php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AdminRequestReceivedMail;
use App\Mail\CustomerRequestConfirmationMail;
use App\Models\Inquiry;

class InquirySubmissionTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array { ... }

    public function test_gdpr_consent_is_required() { ... }
    public function test_validation_fails_without_gdpr_consent() { ... }
    public function test_submission_succeeds_with_gdpr_consent() { ... }
    public function test_admin_notification_email_is_sent() { ... }
    public function test_customer_confirmation_email_is_sent() { ... }
    public function test_admin_email_reply_to_is_visitor_email() { ... }
    public function test_admin_email_contains_dynamic_answers() {
        // Submits with needs[] and multilingual_needs[], asserts
        // AdminRequestReceivedMail has $inquiry with non-empty needs
    }
    public function test_customer_confirmation_uses_correct_locale() {
        // Submit via FR route, assert mailable locale = 'fr'
    }
    public function test_inquiry_stored_even_if_mail_fails() {
        // Mail::shouldReceive(...)->andThrow(...)
        // Assert Inquiry::count() == 1
        // Assert redirect has 'mail_error' flash
    }
    public function test_mail_failure_is_logged() {
        // Assert Log::error was called with inquiry context
    }
    public function test_existing_request_storage_still_works() {
        // Assert Inquiry::count() increments on valid submission
    }
    public function test_no_queued_mail_is_used() {
        // Mail::assertNothingQueued() after submission
    }
}
```

---

## Local Testing

```env
MAIL_MAILER=log
```

Submit the form → check `storage/logs/laravel.log` for email output.

Or use `MAIL_MAILER=array` + `Mail::fake()` in tests.

Run tests:
```bash
php artisan test --filter InquirySubmission
```

---

## Production Deployment (after approval)

```bash
cd /var/www/vanmalderstudio
git pull
composer install --no-dev --optimize-autoloader
npm install && npm run build
php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Update `.env` with real SMTP values — use `MAIL_SCHEME=ssl` (not `MAIL_ENCRYPTION`), then:
```bash
php artisan config:clear && php artisan config:cache
```

## Safe Production Mail Test (Task 10)

```bash
php artisan tinker
```
```php
Mail::raw('Test van Van Malder Studio', function ($m) {
    $m->to('info@vanmalderstudio.be')->subject('Van Malder Studio — testmail');
});
```

This sends a plain text test email without touching any public routes.

---

## Queued Mail Migration Path (future, not in scope)

To switch to queued sending later, change two lines in `InquiryService::sendNotifications()`:
- `->send(...)` → `->queue(...)`

And ensure a persistent queue worker runs (`php artisan queue:work` via Supervisor/systemd).
