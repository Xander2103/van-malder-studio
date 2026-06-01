# Mail & Privacy Acknowledgement Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add admin notification email, visitor confirmation email, and updated privacy checkbox labels to the existing Van Malder Studio contact form — without changing the database schema, routes, or form structure.

**Architecture:** `InquiryService::sendNotifications()` sends both emails synchronously after the inquiry is stored; the controller wraps that call in try/catch and sets a `mail_error` flash on failure. A static `InquiryFormatter` helper flattens all inquiry fields into Dutch-labelled rows for the admin email. Two Mailables with dedicated Blade views handle rendering.

**Tech Stack:** Laravel 12, PHP 8.2+, Laravel Mail (SMTP/log transport), Blade, PHPUnit via `php artisan test`

---

## File Map

| Action | Path | Responsibility |
|--------|------|----------------|
| Modify | `config/mail.php` | Add `contact_notification_email` config key |
| Modify | `.env.example` | Add all required mail env vars with MAIL_SCHEME |
| Modify | `lang/nl/site.php` | Update gdpr_label/gdpr_accepted, add mail_error + mail.* |
| Modify | `lang/fr/site.php` | Same, French |
| Modify | `lang/en/site.php` | Same, English |
| Modify | `lang/de/site.php` | Same, German |
| Create | `app/Helpers/InquiryFormatter.php` | Static formatter: Inquiry → `[['label','value'],…]` |
| Create | `app/Mail/AdminRequestReceivedMail.php` | Admin notification Mailable |
| Create | `app/Mail/CustomerRequestConfirmationMail.php` | Visitor confirmation Mailable |
| Create | `resources/views/emails/admin/request-received.blade.php` | Admin email HTML |
| Create | `resources/views/emails/customer/request-confirmation.blade.php` | Visitor confirmation HTML |
| Modify | `app/Services/InquiryService.php` | Add `sendNotifications(Inquiry): void` |
| Modify | `app/Http/Controllers/InquiryController.php` | Thin try/catch + mail_error flash |
| Modify | `resources/views/pages/contact.blade.php` | Add amber mail_error flash block |
| Create | `tests/Unit/InquiryFormatterTest.php` | Unit tests for formatter |
| Create | `tests/Feature/InquirySubmissionTest.php` | Feature tests for form + mail |

---

## Task 1: Config & .env.example

**Files:**
- Modify: `config/mail.php`
- Modify: `.env.example`

- [ ] **Step 1.1 — Add `contact_notification_email` to config/mail.php**

  Open `config/mail.php`. At the very end, just before the closing `];`, add:

  ```php
      /*
      |--------------------------------------------------------------------------
      | Contact Notification Email
      |--------------------------------------------------------------------------
      | The address that receives admin notifications for every new inquiry.
      */
      'contact_notification_email' => env('CONTACT_NOTIFICATION_EMAIL', env('MAIL_FROM_ADDRESS', 'info@vanmalderstudio.be')),
  ```

  Full closing of the file should look like:
  ```php
      ],

      'contact_notification_email' => env('CONTACT_NOTIFICATION_EMAIL', env('MAIL_FROM_ADDRESS', 'info@vanmalderstudio.be')),

  ];
  ```

- [ ] **Step 1.2 — Update .env.example**

  Replace the existing mail block in `.env.example` (the `MAIL_MAILER=log` lines) with:

  ```
  MAIL_MAILER=log
  MAIL_HOST=mail.vanmalderstudio.be
  MAIL_PORT=465
  MAIL_SCHEME=ssl
  MAIL_USERNAME=info@vanmalderstudio.be
  MAIL_PASSWORD=
  MAIL_FROM_ADDRESS=info@vanmalderstudio.be
  MAIL_FROM_NAME="Van Malder Studio"

  CONTACT_NOTIFICATION_EMAIL=info@vanmalderstudio.be
  ```

  > **Important:** This project uses `MAIL_SCHEME` (not `MAIL_ENCRYPTION`). The `config/mail.php` reads `env('MAIL_SCHEME')`. Using `MAIL_ENCRYPTION=ssl` would be silently ignored and the SSL connection would fail.

- [ ] **Step 1.3 — Verify config loads**

  ```bash
  php artisan config:clear && php artisan tinker --execute="echo config('mail.contact_notification_email');"
  ```

  Expected output: `info@vanmalderstudio.be`

- [ ] **Step 1.4 — Commit**

  ```bash
  git add config/mail.php .env.example
  git commit -m "config: add contact_notification_email, update env.example for MAIL_SCHEME"
  ```

---

## Task 2: Translation updates (all 4 locales)

**Files:**
- Modify: `lang/nl/site.php`
- Modify: `lang/fr/site.php`
- Modify: `lang/en/site.php`
- Modify: `lang/de/site.php`

### NL (`lang/nl/site.php`)

- [ ] **Step 2.1 — Update gdpr_label**

  Find:
  ```php
          'gdpr_label'         => 'Ik ga akkoord met de :link en geef toestemming om mijn gegevens te gebruiken voor het behandelen van deze aanvraag.',
  ```
  Replace with:
  ```php
          'gdpr_label'         => 'Ik ga akkoord dat Van Malder Studio mijn gegevens gebruikt om mijn aanvraag te beantwoorden en heb de :link gelezen.',
  ```

- [ ] **Step 2.2 — Update gdpr_accepted validation message**

  Find:
  ```php
              'gdpr_accepted'         => 'Je moet akkoord gaan met de privacyverklaring.',
  ```
  Replace with:
  ```php
              'gdpr_accepted'         => 'Gelieve akkoord te gaan met de privacyverklaring voordat je je aanvraag verzendt.',
  ```

- [ ] **Step 2.3 — Add mail_error to the contact array**

  Find:
  ```php
          'success_body'     => 'Bedankt voor je bericht. Ik neem zo snel mogelijk contact met je op, doorgaans binnen 1 à 2 werkdagen.',
  ```
  Replace with:
  ```php
          'success_body'     => 'Bedankt voor je bericht. Ik neem zo snel mogelijk contact met je op, doorgaans binnen 1 à 2 werkdagen.',
          'mail_error'       => 'Je aanvraag werd goed ontvangen, maar er was een probleem bij het verzenden van de bevestigingsmail. Ik neem alsnog zo snel mogelijk contact met je op.',
  ```

- [ ] **Step 2.4 — Add mail section at end of NL file**

  Find:
  ```php
      'landing_pages' => [
  ```
  (the last top-level section before `];`)

  Insert after the closing `],` of the `landing_pages` array and before the final `];`:

  ```php
      // ── Mail ─────────────────────────────────────────────────────────────────
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

  The end of the file should now look like:
  ```php
      'landing_pages' => [
          ...
      ],

      // ── Mail ─────────────────────────────────────────────────────────────────
      'mail' => [
          'confirmation_subject' => 'We hebben je aanvraag goed ontvangen',
          'confirmation_greeting' => 'Hallo :name,',
          'confirmation_body_1'   => 'Bedankt voor je aanvraag via Van Malder Studio. Ik heb je bericht goed ontvangen en bekijk het zo snel mogelijk.',
          'confirmation_body_2'   => 'Ik neem binnenkort contact met je op om je aanvraag verder te bespreken.',
          'confirmation_sign_off' => 'Met vriendelijke groeten,',
          'confirmation_sender'   => 'Xander',
          'confirmation_brand'    => 'Van Malder Studio',
      ],

  ];
  ```

### FR (`lang/fr/site.php`)

- [ ] **Step 2.5 — Update gdpr_label (FR)**

  Find:
  ```php
          'gdpr_label'         => 'J\'accepte la :link et donne mon consentement pour que mes données soient utilisées pour traiter cette demande.',
  ```
  Replace with:
  ```php
          'gdpr_label'         => 'J\'accepte que Van Malder Studio utilise mes données pour répondre à ma demande et j\'ai lu la :link.',
  ```

- [ ] **Step 2.6 — Update gdpr_accepted (FR)**

  Find:
  ```php
              'gdpr_accepted'         => 'Vous devez accepter la politique de confidentialité.',
  ```
  Replace with:
  ```php
              'gdpr_accepted'         => 'Veuillez accepter la politique de confidentialité avant d\'envoyer votre demande.',
  ```

- [ ] **Step 2.7 — Add mail_error (FR)**

  Find:
  ```php
          'success_body'     => 'Merci pour votre message. Je vous répondrai dans les meilleurs délais, généralement dans les 1 à 2 jours ouvrables.',
  ```
  Replace with:
  ```php
          'success_body'     => 'Merci pour votre message. Je vous répondrai dans les meilleurs délais, généralement dans les 1 à 2 jours ouvrables.',
          'mail_error'       => 'Votre demande a bien été reçue, mais un problème est survenu lors de l\'envoi de l\'e-mail de confirmation. Je vous contacterai malgré tout dès que possible.',
  ```

- [ ] **Step 2.8 — Add mail section (FR)**

  Find the `landing_pages` closing `],` at the end of `lang/fr/site.php` and add before the final `];`:
  ```php
      // ── Mail ─────────────────────────────────────────────────────────────────
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

### EN (`lang/en/site.php`)

- [ ] **Step 2.9 — Update gdpr_label (EN)**

  Find:
  ```php
          'gdpr_label'         => 'I agree to the :link and consent to my data being used to handle this enquiry.',
  ```
  Replace with:
  ```php
          'gdpr_label'         => 'I agree that Van Malder Studio may use my details to respond to my request and I have read the :link.',
  ```

- [ ] **Step 2.10 — Update gdpr_accepted (EN)**

  Find:
  ```php
              'gdpr_accepted'         => 'You must agree to the privacy policy.',
  ```
  Replace with:
  ```php
              'gdpr_accepted'         => 'Please accept the privacy policy before sending your request.',
  ```

- [ ] **Step 2.11 — Add mail_error (EN)**

  Find:
  ```php
          'success_body'     => 'Thank you for your message. I\'ll get back to you as soon as possible, typically within 1 to 2 working days.',
  ```
  Replace with:
  ```php
          'success_body'     => 'Thank you for your message. I\'ll get back to you as soon as possible, typically within 1 to 2 working days.',
          'mail_error'       => 'Your request was received, but there was a problem sending the confirmation email. I will still contact you as soon as possible.',
  ```

- [ ] **Step 2.12 — Add mail section (EN)**

  Find the `landing_pages` closing `],` at the end of `lang/en/site.php` and add before the final `];`:
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

### DE (`lang/de/site.php`)

- [ ] **Step 2.13 — Update gdpr_label (DE)**

  Find:
  ```php
          'gdpr_label'         => 'Ich stimme der :link zu und gebe mein Einverständnis, dass meine Daten zur Bearbeitung dieser Anfrage verwendet werden.',
  ```
  Replace with:
  ```php
          'gdpr_label'         => 'Ich stimme zu, dass Van Malder Studio meine Daten verwendet, um meine Anfrage zu beantworten, und habe die :link gelesen.',
  ```

- [ ] **Step 2.14 — Update gdpr_accepted (DE)**

  Find:
  ```php
              'gdpr_accepted'         => 'Sie müssen der Datenschutzerklärung zustimmen.',
  ```
  Replace with:
  ```php
              'gdpr_accepted'         => 'Bitte akzeptieren Sie die Datenschutzerklärung, bevor Sie Ihre Anfrage senden.',
  ```

- [ ] **Step 2.15 — Add mail_error (DE)**

  Find:
  ```php
          'success_body'     => 'Vielen Dank für Ihre Nachricht. Ich melde mich so schnell wie möglich, in der Regel innerhalb von 1 bis 2 Werktagen.',
  ```
  Replace with:
  ```php
          'success_body'     => 'Vielen Dank für Ihre Nachricht. Ich melde mich so schnell wie möglich, in der Regel innerhalb von 1 bis 2 Werktagen.',
          'mail_error'       => 'Ihre Anfrage wurde erhalten, aber beim Senden der Bestätigungs-E-Mail ist ein Problem aufgetreten. Ich werde mich trotzdem so schnell wie möglich bei Ihnen melden.',
  ```

- [ ] **Step 2.16 — Add mail section (DE)**

  Find the `landing_pages` closing `],` at the end of `lang/de/site.php` and add before the final `];`:
  ```php
      // ── Mail ─────────────────────────────────────────────────────────────────
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

- [ ] **Step 2.17 — Verify all lang files parse**

  ```bash
  php artisan config:clear && php artisan tinker --execute="echo __('site.mail.confirmation_subject');"
  ```
  Expected: `We hebben je aanvraag goed ontvangen` (NL is app default locale)

  ```bash
  php artisan tinker --execute="app()->setLocale('fr'); echo __('site.mail.confirmation_subject');"
  ```
  Expected: `Nous avons bien reçu votre demande`

- [ ] **Step 2.18 — Commit**

  ```bash
  git add lang/nl/site.php lang/fr/site.php lang/en/site.php lang/de/site.php
  git commit -m "i18n: update gdpr_label wording, add mail_error flash and mail confirmation keys (all 4 locales)"
  ```

---

## Task 3: InquiryFormatter — TDD

**Files:**
- Create: `tests/Unit/InquiryFormatterTest.php`
- Create: `app/Helpers/InquiryFormatter.php`

- [ ] **Step 3.1 — Write failing unit tests**

  Create `tests/Unit/InquiryFormatterTest.php`:

  ```php
  <?php

  namespace Tests\Unit;

  use App\Helpers\InquiryFormatter;
  use App\Models\Inquiry;
  use Illuminate\Foundation\Testing\RefreshDatabase;
  use Tests\TestCase;

  class InquiryFormatterTest extends TestCase
  {
      use RefreshDatabase;

      private function makeInquiry(array $attrs = []): Inquiry
      {
          return Inquiry::create(array_merge([
              'name'                 => 'Jan Peeters',
              'email'                => 'jan@example.com',
              'phone'                => '+32 499 11 22 33',
              'company_name'         => 'Test BV',
              'project_type'         => 'new_website',
              'existing_website_url' => 'https://janpeeters.be',
              'multilingual_needs'   => ['Nederlands', 'Frans'],
              'other_language'       => null,
              'content_admin_needs'  => 'basic_edit',
              'needs'                => ['seo_visibility', 'multilingual'],
              'project_description'  => 'Test omschrijving voor de bakkerij.',
              'budget_range'         => '750_1250',
              'timeline'             => 'within_2_3_months',
              'gdpr_consent'         => true,
              'locale'               => 'nl',
          ], $attrs));
      }

      public function test_to_rows_returns_array(): void
      {
          $rows = InquiryFormatter::toRows($this->makeInquiry());

          $this->assertIsArray($rows);
          $this->assertNotEmpty($rows);
          $this->assertArrayHasKey('label', $rows[0]);
          $this->assertArrayHasKey('value', $rows[0]);
      }

      public function test_known_fields_have_dutch_labels(): void
      {
          $labels = array_column(InquiryFormatter::toRows($this->makeInquiry()), 'label');

          $this->assertContains('Naam', $labels);
          $this->assertContains('E-mail', $labels);
          $this->assertContains('Projecttype', $labels);
          $this->assertContains('Projectomschrijving', $labels);
          $this->assertContains('Privacyverklaring', $labels);
          $this->assertContains('#Aanvraag', $labels);
          $this->assertContains('Ontvangen', $labels);
      }

      public function test_project_type_mapped_to_dutch_label(): void
      {
          $row = collect(InquiryFormatter::toRows($this->makeInquiry(['project_type' => 'new_website'])))
              ->firstWhere('label', 'Projecttype');

          $this->assertSame('Nieuwe website', $row['value']);
      }

      public function test_unknown_project_type_falls_back_to_raw_key(): void
      {
          $row = collect(InquiryFormatter::toRows($this->makeInquiry(['project_type' => 'future_type_xyz'])))
              ->firstWhere('label', 'Projecttype');

          $this->assertSame('future_type_xyz', $row['value']);
      }

      public function test_needs_mapped_to_dutch_labels(): void
      {
          $row = collect(InquiryFormatter::toRows($this->makeInquiry(['needs' => ['seo_visibility', 'multilingual']])))
              ->firstWhere('label', 'Extra behoeften');

          $this->assertStringContainsString('Beter gevonden via Google', $row['value']);
          $this->assertStringContainsString('Meertaligheid', $row['value']);
      }

      public function test_unknown_need_key_falls_back_to_humanised_label(): void
      {
          $row = collect(InquiryFormatter::toRows($this->makeInquiry(['needs' => ['future_feature_xyz']])))
              ->firstWhere('label', 'Extra behoeften');

          $this->assertStringContainsString('Future Feature Xyz', $row['value']);
      }

      public function test_null_optional_fields_show_dash(): void
      {
          $rows = collect(InquiryFormatter::toRows($this->makeInquiry(['phone' => null, 'company_name' => null])));

          $this->assertSame('—', $rows->firstWhere('label', 'Telefoon')['value']);
          $this->assertSame('—', $rows->firstWhere('label', 'Bedrijf')['value']);
      }

      public function test_gdpr_consent_shown_as_ja(): void
      {
          $row = collect(InquiryFormatter::toRows($this->makeInquiry(['gdpr_consent' => true])))
              ->firstWhere('label', 'Privacyverklaring');

          $this->assertSame('Ja', $row['value']);
      }

      public function test_budget_mapped_to_dutch_label(): void
      {
          $row = collect(InquiryFormatter::toRows($this->makeInquiry(['budget_range' => '750_1250'])))
              ->firstWhere('label', 'Budget');

          $this->assertSame('€750 – €1.250', $row['value']);
      }

      public function test_multilingual_needs_joined(): void
      {
          $row = collect(InquiryFormatter::toRows($this->makeInquiry(['multilingual_needs' => ['Nederlands', 'Frans', 'Engels']])))
              ->firstWhere('label', 'Meertaligheid');

          $this->assertSame('Nederlands, Frans, Engels', $row['value']);
      }

      public function test_other_language_included_when_set(): void
      {
          $labels = array_column(InquiryFormatter::toRows($this->makeInquiry(['other_language' => 'Italiaans'])), 'label');

          $this->assertContains('Andere taal', $labels);
      }

      public function test_other_language_omitted_when_null(): void
      {
          $labels = array_column(InquiryFormatter::toRows($this->makeInquiry(['other_language' => null])), 'label');

          $this->assertNotContains('Andere taal', $labels);
      }
  }
  ```

- [ ] **Step 3.2 — Run tests to verify they fail**

  ```bash
  php artisan test tests/Unit/InquiryFormatterTest.php
  ```
  Expected: `FAIL` — `App\Helpers\InquiryFormatter not found`

- [ ] **Step 3.3 — Create InquiryFormatter**

  Create `app/Helpers/InquiryFormatter.php`:

  ```php
  <?php

  namespace App\Helpers;

  use App\Models\Inquiry;
  use Carbon\Carbon;
  use Illuminate\Support\Str;

  class InquiryFormatter
  {
      private static array $projectTypeMap = [
          'new_website'     => 'Nieuwe website',
          'redesign'        => 'Website vernieuwen',
          'webshop'         => 'Webshop / online verkoop',
          'contact_form'    => 'Contact- of offerteformulier',
          'seo_local'       => 'SEO / lokale vindbaarheid',
          'app_tool'        => 'App, tool of webapplicatie',
          'maintenance'     => 'Onderhoud / aanpassingen',
          'audit'           => 'Website audit / advies',
          'other'           => 'Iets anders',
          'web_application' => 'Webapplicatie (legacy)',
          'app_idea'        => 'App-idee (legacy)',
      ];

      private static array $needsMap = [
          'seo_visibility'          => 'Beter gevonden via Google',
          'seo_landing_pages'       => "SEO-landingpagina's",
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

      public static function toRows(Inquiry $inquiry): array
      {
          $rows = [];

          // Meta
          $rows[] = ['label' => '#Aanvraag',     'value' => '#' . $inquiry->id];
          $rows[] = ['label' => 'Ontvangen',     'value' => Carbon::parse($inquiry->created_at)->format('d/m/Y H:i')];
          $rows[] = ['label' => 'Formuliertaal', 'value' => $inquiry->locale ?? '—'];

          // Contact
          $rows[] = ['label' => 'Naam',     'value' => $inquiry->name     ?: '—'];
          $rows[] = ['label' => 'E-mail',   'value' => $inquiry->email    ?: '—'];
          $rows[] = ['label' => 'Telefoon', 'value' => $inquiry->phone    ?: '—'];
          $rows[] = ['label' => 'Bedrijf',  'value' => $inquiry->company_name ?: '—'];

          // Project
          $rows[] = [
              'label' => 'Projecttype',
              'value' => self::$projectTypeMap[$inquiry->project_type] ?? $inquiry->project_type,
          ];
          $rows[] = ['label' => 'Bestaande website', 'value' => $inquiry->existing_website_url ?: '—'];

          // Multilingual needs (stored as JSON array)
          $multiRaw = $inquiry->multilingual_needs;
          $multi    = is_array($multiRaw) ? $multiRaw
              : (is_string($multiRaw) ? (json_decode($multiRaw, true) ?? [$multiRaw]) : []);
          $rows[] = ['label' => 'Meertaligheid', 'value' => $multi ? implode(', ', $multi) : '—'];

          if ($inquiry->other_language) {
              $rows[] = ['label' => 'Andere taal', 'value' => $inquiry->other_language];
          }

          $rows[] = [
              'label' => 'Contentbeheer',
              'value' => self::$adminNeedsMap[$inquiry->content_admin_needs] ?? ($inquiry->content_admin_needs ?: '—'),
          ];

          // Extra needs (JSON array of string keys)
          $needsRaw    = $inquiry->needs;
          $needs       = is_array($needsRaw) ? $needsRaw : [];
          $needsLabels = array_map(
              fn($k) => self::$needsMap[$k] ?? Str::title(str_replace('_', ' ', $k)),
              $needs
          );
          $rows[] = ['label' => 'Extra behoeften', 'value' => $needsLabels ? implode(', ', $needsLabels) : '—'];

          $rows[] = ['label' => 'Projectomschrijving', 'value' => $inquiry->project_description ?: '—'];

          $rows[] = [
              'label' => 'Budget',
              'value' => self::$budgetMap[$inquiry->budget_range] ?? ($inquiry->budget_range ?: '—'),
          ];
          $rows[] = [
              'label' => 'Gewenste timing',
              'value' => self::$timelineMap[$inquiry->timeline] ?? ($inquiry->timeline ?: '—'),
          ];

          // Consent & tracking
          $rows[] = ['label' => 'Privacyverklaring', 'value' => $inquiry->gdpr_consent ? 'Ja' : 'Nee'];
          $rows[] = ['label' => 'Aanvraagbron',      'value' => $inquiry->source   ?: '—'];
          $rows[] = ['label' => 'IP-hash',           'value' => $inquiry->ip_hash  ?: '—'];

          // Unknown/future fields — nothing dropped
          $knownKeys = [
              'id', 'created_at', 'updated_at', 'locale',
              'name', 'email', 'phone', 'company_name',
              'project_type', 'existing_website_url',
              'multilingual_needs', 'other_language', 'content_admin_needs', 'needs',
              'project_description', 'budget_range', 'timeline',
              'gdpr_consent', 'source', 'ip_hash', 'user_agent',
          ];

          $unknownFields = array_diff_key($inquiry->toArray(), array_flip($knownKeys));
          foreach ($unknownFields as $key => $value) {
              $rows[] = [
                  'label' => Str::title(str_replace('_', ' ', $key)),
                  'value' => self::formatUnknownValue($value),
              ];
          }

          return $rows;
      }

      private static function formatUnknownValue(mixed $value): string
      {
          if (is_null($value))              return '—';
          if (is_bool($value))              return $value ? 'Ja' : 'Nee';
          if (is_string($value) && $value === '') return '—';
          if (is_array($value)) {
              $parts = array_map([self::class, 'formatUnknownValue'], $value);
              return implode(', ', $parts) ?: '—';
          }
          return (string) $value;
      }
  }
  ```

- [ ] **Step 3.4 — Run tests to verify they pass**

  ```bash
  php artisan test tests/Unit/InquiryFormatterTest.php
  ```
  Expected: all tests `PASS`

- [ ] **Step 3.5 — Commit**

  ```bash
  git add app/Helpers/InquiryFormatter.php tests/Unit/InquiryFormatterTest.php
  git commit -m "feat: add InquiryFormatter helper with full field coverage (TDD)"
  ```

---

## Task 4: Feature test file (write failing tests)

**Files:**
- Create: `tests/Feature/InquirySubmissionTest.php`

Write the complete feature test file now. These tests will fail until Tasks 5–7 are complete. That is intentional — we write the spec first.

- [ ] **Step 4.1 — Create InquirySubmissionTest.php**

  Create `tests/Feature/InquirySubmissionTest.php`:

  ```php
  <?php

  namespace Tests\Feature;

  use App\Mail\AdminRequestReceivedMail;
  use App\Mail\CustomerRequestConfirmationMail;
  use App\Models\Inquiry;
  use App\Services\InquiryService;
  use Illuminate\Foundation\Testing\RefreshDatabase;
  use Illuminate\Support\Facades\Log;
  use Illuminate\Support\Facades\Mail;
  use Mockery\MockInterface;
  use Tests\TestCase;

  class InquirySubmissionTest extends TestCase
  {
      use RefreshDatabase;

      private function validPayload(array $overrides = []): array
      {
          return array_merge([
              'name'                 => 'Jan Peeters',
              'email'                => 'jan@example.com',
              'phone'                => '+32 499 00 00 00',
              'company_name'         => 'Test BV',
              'project_type'         => 'new_website',
              'existing_website_url' => null,
              'multilingual_needs'   => ['Nederlands', 'Frans'],
              'other_language'       => null,
              'content_admin_needs'  => 'basic_edit',
              'needs'                => ['seo_visibility', 'multilingual'],
              'project_description'  => 'Een professionele website voor mijn bakkerij in Tervuren. Klanten moeten onze openingsuren, producten en contactinfo makkelijk vinden.',
              'budget_range'         => '750_1250',
              'timeline'             => 'within_2_3_months',
              'gdpr_consent'         => '1',
              'website'              => '',
          ], $overrides);
      }

      // ── Existing behaviour — must still pass ─────────────────────────────────

      public function test_existing_request_storage_still_works(): void
      {
          Mail::fake();

          $this->assertDatabaseCount('inquiries', 0);
          $this->post(route('inquiries.store'), $this->validPayload());
          $this->assertDatabaseCount('inquiries', 1);
      }

      // ── Privacy checkbox ─────────────────────────────────────────────────────

      public function test_gdpr_consent_is_required(): void
      {
          Mail::fake();

          $response = $this->post(route('inquiries.store'), $this->validPayload(['gdpr_consent' => '']));

          $response->assertSessionHasErrors('gdpr_consent');
          $this->assertDatabaseCount('inquiries', 0);
      }

      public function test_validation_fails_without_gdpr_consent(): void
      {
          Mail::fake();

          $response = $this->post(route('inquiries.store'), $this->validPayload(['gdpr_consent' => '']));

          $response->assertStatus(302);
          $errors = session('errors')->getBag('default');
          $this->assertTrue($errors->has('gdpr_consent'));
      }

      public function test_submission_succeeds_with_gdpr_consent(): void
      {
          Mail::fake();

          $response = $this->post(route('inquiries.store'), $this->validPayload());

          $response->assertRedirect();
          $response->assertSessionHas('success');
          $this->assertDatabaseCount('inquiries', 1);
      }

      // ── Admin notification email ─────────────────────────────────────────────

      public function test_admin_notification_email_is_sent(): void
      {
          Mail::fake();

          $this->post(route('inquiries.store'), $this->validPayload());

          Mail::assertSent(AdminRequestReceivedMail::class);
      }

      public function test_admin_email_reply_to_is_visitor_email(): void
      {
          Mail::fake();

          $this->post(route('inquiries.store'), $this->validPayload(['email' => 'jan@example.com']));

          Mail::assertSent(AdminRequestReceivedMail::class, function ($mail) {
              return $mail->hasReplyTo('jan@example.com');
          });
      }

      public function test_admin_email_contains_dynamic_answers(): void
      {
          Mail::fake();

          $this->post(route('inquiries.store'), $this->validPayload([
              'needs'              => ['seo_visibility', 'custom_form', 'multilingual'],
              'multilingual_needs' => ['Nederlands', 'Frans', 'Engels'],
          ]));

          Mail::assertSent(AdminRequestReceivedMail::class, function ($mail) {
              $needs = $mail->inquiry->needs;
              return is_array($needs) && count($needs) >= 3;
          });
      }

      // ── Customer confirmation email ──────────────────────────────────────────

      public function test_customer_confirmation_email_is_sent(): void
      {
          Mail::fake();

          $this->post(route('inquiries.store'), $this->validPayload(['email' => 'jan@example.com']));

          Mail::assertSent(CustomerRequestConfirmationMail::class, function ($mail) {
              return $mail->hasTo('jan@example.com');
          });
      }

      public function test_customer_confirmation_uses_correct_locale(): void
      {
          Mail::fake();

          $this->post(route('fr.inquiries.store'), $this->validPayload());

          Mail::assertSent(CustomerRequestConfirmationMail::class, function ($mail) {
              return $mail->inquiry->locale === 'fr';
          });
      }

      // ── Mail failure handling ────────────────────────────────────────────────

      public function test_inquiry_stored_even_if_mail_fails(): void
      {
          $this->partialMock(InquiryService::class, function (MockInterface $mock) {
              $mock->shouldReceive('sendNotifications')
                  ->once()
                  ->andThrow(new \Exception('SMTP connection refused'));
          });

          $response = $this->post(route('inquiries.store'), $this->validPayload());

          $this->assertDatabaseCount('inquiries', 1);
          $response->assertRedirect();
          $response->assertSessionHas('mail_error');
      }

      public function test_mail_failure_is_logged(): void
      {
          Log::spy();

          $this->partialMock(InquiryService::class, function (MockInterface $mock) {
              $mock->shouldReceive('sendNotifications')
                  ->once()
                  ->andThrow(new \Exception('SMTP error'));
          });

          $this->post(route('inquiries.store'), $this->validPayload());

          Log::shouldHaveReceived('error')->once();
      }

      // ── Queued mail guard ────────────────────────────────────────────────────

      public function test_no_queued_mail_is_used(): void
      {
          Mail::fake();

          $this->post(route('inquiries.store'), $this->validPayload());

          Mail::assertNothingQueued();
      }
  }
  ```

- [ ] **Step 4.2 — Run tests to verify they fail as expected**

  ```bash
  php artisan test tests/Feature/InquirySubmissionTest.php
  ```

  Expected failures:
  - `test_admin_notification_email_is_sent` — `AdminRequestReceivedMail not found`
  - `test_customer_confirmation_email_is_sent` — `CustomerRequestConfirmationMail not found`
  - Other mail-related tests — same reason

  Expected passes:
  - `test_existing_request_storage_still_works`
  - `test_gdpr_consent_is_required`
  - `test_validation_fails_without_gdpr_consent`
  - `test_submission_succeeds_with_gdpr_consent` (mail_error or success — depends on whether sendNotifications exists yet)

- [ ] **Step 4.3 — Commit test file**

  ```bash
  git add tests/Feature/InquirySubmissionTest.php
  git commit -m "test: add InquirySubmissionTest (failing — implementation follows)"
  ```

---

## Task 5: Create Mailables and email views

**Files:**
- Create: `app/Mail/AdminRequestReceivedMail.php`
- Create: `app/Mail/CustomerRequestConfirmationMail.php`
- Create: `resources/views/emails/admin/request-received.blade.php`
- Create: `resources/views/emails/customer/request-confirmation.blade.php`

- [ ] **Step 5.1 — Create AdminRequestReceivedMail**

  Create `app/Mail/AdminRequestReceivedMail.php`:

  ```php
  <?php

  namespace App\Mail;

  use App\Helpers\InquiryFormatter;
  use App\Models\Inquiry;
  use Illuminate\Bus\Queueable;
  use Illuminate\Mail\Mailable;
  use Illuminate\Mail\Mailables\Address;
  use Illuminate\Mail\Mailables\Content;
  use Illuminate\Mail\Mailables\Envelope;
  use Illuminate\Queue\SerializesModels;

  class AdminRequestReceivedMail extends Mailable
  {
      use Queueable, SerializesModels;

      public function __construct(public readonly Inquiry $inquiry) {}

      public function envelope(): Envelope
      {
          $replyTo = filter_var($this->inquiry->email, FILTER_VALIDATE_EMAIL)
              ? [new Address($this->inquiry->email, $this->inquiry->name ?: '')]
              : [];

          return new Envelope(
              subject: 'Nieuwe aanvraag via Van Malder Studio — ' . $this->inquiry->name,
              replyTo: $replyTo,
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

- [ ] **Step 5.2 — Create CustomerRequestConfirmationMail**

  Create `app/Mail/CustomerRequestConfirmationMail.php`:

  ```php
  <?php

  namespace App\Mail;

  use App\Models\Inquiry;
  use Illuminate\Bus\Queueable;
  use Illuminate\Mail\Mailable;
  use Illuminate\Mail\Mailables\Content;
  use Illuminate\Mail\Mailables\Envelope;
  use Illuminate\Queue\SerializesModels;
  use Illuminate\Support\Str;

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
          $nameParts = explode(' ', trim($this->inquiry->name), 2);
          $firstName = $nameParts[0] ?: $this->inquiry->name;

          return new Content(
              view: 'emails.customer.request-confirmation',
              with: [
                  'inquiry'   => $this->inquiry,
                  'firstName' => $firstName,
              ],
          );
      }
  }
  ```

- [ ] **Step 5.3 — Create the admin email view directory**

  ```bash
  mkdir -p resources/views/emails/admin resources/views/emails/customer
  ```

- [ ] **Step 5.4 — Create admin email view**

  Create `resources/views/emails/admin/request-received.blade.php`:

  ```html
  <!DOCTYPE html>
  <html lang="nl">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Nieuwe aanvraag — Van Malder Studio</title>
  </head>
  <body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: #0f172a; line-height: 1.6; margin: 0; padding: 0; background: #f8fafc;">
      <div style="max-width: 640px; margin: 24px auto; background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden;">

          <div style="background: #0f172a; padding: 24px 32px;">
              <h1 style="color: #ffffff; font-size: 18px; font-weight: 600; margin: 0;">Van Malder Studio</h1>
              <p style="color: #94a3b8; font-size: 13px; margin: 4px 0 0;">Nieuwe aanvraag ontvangen</p>
          </div>

          <div style="padding: 32px;">
              <table style="width: 100%; border-collapse: collapse;">
                  @foreach ($rows as $row)
                  <tr style="border-bottom: 1px solid #f1f5f9;">
                      <td style="padding: 8px 0; width: 180px; vertical-align: top; color: #64748b; font-size: 13px; font-weight: 500; padding-right: 12px;">{{ $row['label'] }}</td>
                      <td style="padding: 8px 0 8px 0; vertical-align: top; color: #0f172a; font-size: 14px; word-break: break-word;">
                          @if ($row['label'] === 'Projectomschrijving')
                              <span style="white-space: pre-wrap;">{{ $row['value'] }}</span>
                          @else
                              {{ $row['value'] }}
                          @endif
                      </td>
                  </tr>
                  @endforeach
              </table>
          </div>

          <div style="background: #f8fafc; padding: 16px 32px; border-top: 1px solid #e2e8f0;">
              <p style="color: #94a3b8; font-size: 12px; margin: 0;">
                  Van Malder Studio — automatisch gegenereerde notificatie. Antwoord op deze e-mail gaat rechtstreeks naar de aanvrager.
              </p>
          </div>

      </div>
  </body>
  </html>
  ```

- [ ] **Step 5.5 — Create customer confirmation view**

  Create `resources/views/emails/customer/request-confirmation.blade.php`:

  ```html
  <!DOCTYPE html>
  <html lang="{{ $inquiry->locale ?? 'nl' }}">
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
  ```

- [ ] **Step 5.6 — Run the feature tests (still failing — sendNotifications not wired yet)**

  ```bash
  php artisan test tests/Feature/InquirySubmissionTest.php
  ```

  Expected: mail tests still fail because `sendNotifications` is not called by the controller yet. The Mailable class errors should now be gone — tests fail with "0 mails sent" assertions instead.

- [ ] **Step 5.7 — Commit**

  ```bash
  git add app/Mail/AdminRequestReceivedMail.php app/Mail/CustomerRequestConfirmationMail.php resources/views/emails/
  git commit -m "feat: add AdminRequestReceivedMail, CustomerRequestConfirmationMail, and email views"
  ```

---

## Task 6: InquiryService — add sendNotifications()

**Files:**
- Modify: `app/Services/InquiryService.php`

- [ ] **Step 6.1 — Add sendNotifications to InquiryService**

  Open `app/Services/InquiryService.php`. Add imports and the new method. Replace the full file contents:

  ```php
  <?php

  namespace App\Services;

  use App\Mail\AdminRequestReceivedMail;
  use App\Mail\CustomerRequestConfirmationMail;
  use App\Models\Inquiry;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Mail;

  class InquiryService
  {
      public function store(array $validated, Request $request): Inquiry
      {
          return Inquiry::create([
              'name'                 => $validated['name'],
              'company_name'         => $validated['company_name'] ?? null,
              'email'                => $validated['email'],
              'phone'                => $validated['phone'] ?? null,
              'existing_website_url' => $validated['existing_website_url'] ?? null,
              'project_type'         => $validated['project_type'],
              'timeline'             => $validated['timeline'] ?? null,
              'budget_range'         => $validated['budget_range'] ?? null,
              'multilingual_needs'   => $validated['multilingual_needs'] ?? null,
              'other_language'       => $validated['other_language'] ?? null,
              'content_admin_needs'  => $validated['content_admin_needs'] ?? null,
              'needs'                => $validated['needs'] ?? null,
              'project_description'  => $validated['project_description'],
              'gdpr_consent'         => true,
              'source'               => $request->headers->get('referer'),
              'ip_hash'              => hash('sha256', $request->ip()),
              'user_agent'           => substr($request->userAgent() ?? '', 0, 255),
              'locale'               => app()->getLocale() ?: 'nl',
          ]);
      }

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
  }
  ```

- [ ] **Step 6.2 — Run feature tests (still failing — controller not updated yet)**

  ```bash
  php artisan test tests/Feature/InquirySubmissionTest.php
  ```

  Expected: tests that check for `success` flash or mail assertions may still fail because the controller doesn't call `sendNotifications` yet. Tests for `mail_error` flash also still fail. The inquiry storage tests should pass.

- [ ] **Step 6.3 — Commit**

  ```bash
  git add app/Services/InquiryService.php
  git commit -m "feat: add InquiryService::sendNotifications() — sends admin + customer emails synchronously"
  ```

---

## Task 7: InquiryController — wire sendNotifications with try/catch

**Files:**
- Modify: `app/Http/Controllers/InquiryController.php`

- [ ] **Step 7.1 — Update InquiryController::store()**

  Replace the full contents of `app/Http/Controllers/InquiryController.php`:

  ```php
  <?php

  namespace App\Http\Controllers;

  use App\Http\Requests\StoreInquiryRequest;
  use App\Services\InquiryService;
  use Illuminate\Support\Facades\Log;
  use Illuminate\Support\Facades\Route;

  class InquiryController extends Controller
  {
      public function __construct(private InquiryService $inquiryService) {}

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
              Log::error('Mail sending failed for inquiry #' . $inquiry->id . ' (' . $inquiry->email . '): ' . $e->getMessage(), [
                  'inquiry_id'    => $inquiry->id,
                  'inquiry_email' => $inquiry->email,
                  'exception'     => $e,
              ]);

              return redirect()->route($contactRoute)->with('mail_error', true);
          }

          return redirect()->route($contactRoute)->with('success', true);
      }
  }
  ```

- [ ] **Step 7.2 — Run all feature tests — expect all to pass**

  ```bash
  php artisan test tests/Feature/InquirySubmissionTest.php
  ```

  Expected: **ALL PASS**

  If any test fails, diagnose before continuing. Common issues:
  - `MAIL_MAILER` not set to `log` or `array` locally → the test uses `Mail::fake()` which bypasses transport, so this shouldn't matter for tests
  - Route name mismatch: check `route('inquiries.store')` and `route('fr.inquiries.store')` exist with `php artisan route:list | grep inquiries`

- [ ] **Step 7.3 — Run full test suite to check for regressions**

  ```bash
  php artisan test
  ```

  Expected: all tests pass, including the existing `ExampleTest` tests.

- [ ] **Step 7.4 — Commit**

  ```bash
  git add app/Http/Controllers/InquiryController.php
  git commit -m "feat: wire sendNotifications in InquiryController with try/catch and mail_error flash"
  ```

---

## Task 8: contact.blade.php — add mail_error flash

**Files:**
- Modify: `resources/views/pages/contact.blade.php`

- [ ] **Step 8.1 — Add amber mail_error flash block**

  In `resources/views/pages/contact.blade.php`, find:

  ```blade
                  @if(session('success'))
                  <div class="mb-8 rounded-xl bg-green-50 border border-green-200 p-6" role="alert" aria-live="polite">
                      <h2 class="font-serif text-xl font-medium text-green-900">{{ __('site.contact.success_heading') }}</h2>
                      <p class="mt-2 text-sm text-green-700 leading-relaxed">{{ __('site.contact.success_body') }}</p>
                  </div>
                  @endif
  ```

  Replace with:

  ```blade
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
  ```

- [ ] **Step 8.2 — Hide the form on mail_error (same as success)**

  Find:

  ```blade
                  @unless(session('success'))
  ```

  Replace with:

  ```blade
                  @unless(session('success') || session('mail_error'))
  ```

- [ ] **Step 8.3 — Run full test suite to confirm no regressions**

  ```bash
  php artisan test
  ```

  Expected: all tests pass.

- [ ] **Step 8.4 — Commit**

  ```bash
  git add resources/views/pages/contact.blade.php
  git commit -m "feat: add amber mail_error flash block and hide form on partial-success"
  ```

---

## Task 9: Local end-to-end test

- [ ] **Step 9.1 — Set MAIL_MAILER=log in .env**

  In your local `.env` (not `.env.example`):
  ```
  MAIL_MAILER=log
  ```

- [ ] **Step 9.2 — Submit the form manually**

  Start the dev server (`php artisan serve` or your usual setup), open `http://localhost/nl/contact`, fill in all steps including the privacy checkbox, and submit.

- [ ] **Step 9.3 — Verify in laravel.log**

  ```bash
  tail -100 storage/logs/laravel.log
  ```

  Expected: two `Message-ID:` entries — one for the admin notification, one for the customer confirmation. Both email bodies should be visible in the log.

- [ ] **Step 9.4 — Run full test suite one final time**

  ```bash
  php artisan test
  ```

  Expected: **ALL PASS**

---

## Task 10: Production deployment (run after user approves and pushes)

- [ ] **Step 10.1 — On the VPS, pull and rebuild**

  ```bash
  cd /var/www/vanmalderstudio
  git pull
  composer install --no-dev --optimize-autoloader
  npm install && npm run build
  php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear
  php artisan config:cache && php artisan route:cache && php artisan view:cache
  ```

- [ ] **Step 10.2 — Update .env on VPS**

  Add/update these values in `/var/www/vanmalderstudio/.env`:

  ```
  MAIL_MAILER=smtp
  MAIL_HOST=mail.vanmalderstudio.be
  MAIL_PORT=465
  MAIL_SCHEME=ssl
  MAIL_USERNAME=info@vanmalderstudio.be
  MAIL_PASSWORD=<the_real_mailbox_password>
  MAIL_FROM_ADDRESS=info@vanmalderstudio.be
  MAIL_FROM_NAME="Van Malder Studio"

  CONTACT_NOTIFICATION_EMAIL=info@vanmalderstudio.be
  ```

  > **Use `MAIL_SCHEME=ssl`** (not `MAIL_ENCRYPTION`). The `config/mail.php` reads `env('MAIL_SCHEME')`.

- [ ] **Step 10.3 — Recache config**

  ```bash
  php artisan config:clear && php artisan config:cache
  ```

- [ ] **Step 10.4 — Safe production mail test (Tinker)**

  ```bash
  php artisan tinker
  ```
  Inside Tinker:
  ```php
  Mail::raw('Testmail van Van Malder Studio — configuratie OK.', function ($m) {
      $m->to('info@vanmalderstudio.be')->subject('Van Malder Studio — SMTP test');
  });
  ```

  Expected: no exception. Check `info@vanmalderstudio.be` inbox for the test email within ~30 seconds.

  > This test sends via the real SMTP server. It does NOT use any public route. Safe to run on production.

- [ ] **Step 10.5 — Submit the live form once**

  Go to `https://vanmalderstudio.be/nl/contact`, fill in all steps including the privacy checkbox, and submit with a test email you can check.

  Expected:
  - Redirect with green success banner
  - Admin notification arrives at `info@vanmalderstudio.be` with all submitted answers
  - Customer confirmation arrives at the email address you submitted, in the correct language

---

## Future: switching to queued mail

If you later add a persistent queue worker (Supervisor/systemd), change two lines in `InquiryService::sendNotifications()`:

```php
// Before (synchronous):
Mail::to($adminEmail)->send(new AdminRequestReceivedMail($inquiry));
Mail::to($inquiry->email)->send((new CustomerRequestConfirmationMail($inquiry))->locale(...));

// After (queued):
Mail::to($adminEmail)->queue(new AdminRequestReceivedMail($inquiry));
Mail::to($inquiry->email)->queue((new CustomerRequestConfirmationMail($inquiry))->locale(...));
```

No other changes needed — the Mailables use `Queueable` trait and are already serializable.
