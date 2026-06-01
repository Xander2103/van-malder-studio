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

    private function makeInquiry(array $attrs = []): Inquiry
    {
        return Inquiry::create(array_merge([
            'name'                => 'Jan Peeters',
            'email'               => 'jan@example.com',
            'project_type'        => 'new_website',
            'project_description' => 'Test omschrijving voor de bakkerij.',
            'gdpr_consent'        => true,
            'locale'              => 'nl',
        ], $attrs));
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

    public function test_customer_confirmation_uses_inquiry_email_field(): void
    {
        Mail::fake();

        $this->post(route('inquiries.store'), $this->validPayload(['email' => 'visitor@example.com']));

        // The To: address must come from the inquiry's own email field
        Mail::assertSent(CustomerRequestConfirmationMail::class, function ($mail) {
            return $mail->hasTo('visitor@example.com')
                && $mail->inquiry->email === 'visitor@example.com';
        });
    }

    public function test_both_admin_and_customer_mails_sent_in_same_request(): void
    {
        Mail::fake();

        $this->post(route('inquiries.store'), $this->validPayload(['email' => 'visitor@example.com']));

        Mail::assertSent(AdminRequestReceivedMail::class, fn ($m) =>
            $m->hasTo(config('mail.contact_notification_email'))
        );
        Mail::assertSent(CustomerRequestConfirmationMail::class, fn ($m) =>
            $m->hasTo('visitor@example.com')
        );
    }

    public function test_customer_confirmation_uses_correct_locale(): void
    {
        Mail::fake();

        $this->post(route('fr.inquiries.store'), $this->validPayload());

        Mail::assertSent(CustomerRequestConfirmationMail::class, function ($mail) {
            return $mail->inquiry->locale === 'fr';
        });
    }

    /**
     * Renders the mailable HTML to catch view/translation errors that Mail::fake() hides.
     * If the site.mail.* keys are missing, this would contain raw key strings and fail.
     */
    public function test_customer_confirmation_mail_renders_without_raw_translation_keys(): void
    {
        $inquiry = $this->makeInquiry(['name' => 'Jan Peeters', 'locale' => 'nl']);

        $html = (new CustomerRequestConfirmationMail($inquiry))
            ->locale('nl')
            ->render();

        $this->assertStringNotContainsString('site.mail.', $html,
            'Email HTML contains a raw translation key — add the missing site.mail.* entries to lang/nl/site.php');
        $this->assertStringContainsString('Jan', $html);
        $this->assertStringContainsString('Van Malder Studio', $html);
    }

    public function test_customer_confirmation_mail_renders_for_each_locale(): void
    {
        foreach (['nl', 'en', 'fr', 'de'] as $locale) {
            $inquiry = $this->makeInquiry(['locale' => $locale]);

            $html = (new CustomerRequestConfirmationMail($inquiry))
                ->locale($locale)
                ->render();

            $this->assertStringNotContainsString('site.mail.', $html,
                "Email HTML contains a raw translation key for locale '{$locale}'");
        }
    }

    // ── Customer email guard ─────────────────────────────────────────────────

    public function test_customer_confirmation_skipped_and_warning_logged_when_email_invalid(): void
    {
        Mail::fake();
        Log::spy();

        $inquiry = $this->makeInquiry(['email' => 'not-a-valid-email']);

        app(InquiryService::class)->sendNotifications($inquiry);

        // Admin mail is still attempted
        Mail::assertSent(AdminRequestReceivedMail::class);
        // Customer mail is silently skipped
        Mail::assertNotSent(CustomerRequestConfirmationMail::class);
        // A warning is logged so it's not invisible
        Log::shouldHaveReceived('warning')->once();
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

    // ── Artisan test command ─────────────────────────────────────────────────

    public function test_artisan_command_sends_confirmation_to_given_email(): void
    {
        Mail::fake();

        $this->makeInquiry();

        $this->artisan('inquiry:test-customer-mail', ['email' => 'debug@example.com'])
             ->assertExitCode(0);

        Mail::assertSent(CustomerRequestConfirmationMail::class, fn ($m) =>
            $m->hasTo('debug@example.com')
        );
    }

    public function test_artisan_command_fails_with_invalid_email_argument(): void
    {
        $this->artisan('inquiry:test-customer-mail', ['email' => 'not-valid'])
             ->assertExitCode(1);
    }

    public function test_artisan_command_fails_when_no_inquiries_exist(): void
    {
        $this->artisan('inquiry:test-customer-mail', ['email' => 'debug@example.com'])
             ->assertExitCode(1);
    }
}
