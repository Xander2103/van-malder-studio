<?php

namespace Tests\Feature;

use App\Mail\AdminQuickMessageMail;
use App\Mail\CustomerQuickConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class QuickContactTest extends TestCase
{
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'qc_name'      => 'Marie Janssen',
            'qc_email'     => 'marie@example.com',
            'qc_message'   => 'Ik wil graag meer info over jullie diensten.',
            'qc_privacy'   => '1',
            'qc_hp'        => '',
            'qc_form_time' => time() - 5,
        ], $overrides);
    }

    // ── GET contact page ─────────────────────────────────────────────────────

    public function test_contact_page_returns_200(): void
    {
        $response = $this->get(route('nl.contact'));
        $response->assertStatus(200);
    }

    public function test_contact_page_contains_quick_form(): void
    {
        $response = $this->get(route('nl.contact'));
        $response->assertSee('snel-bericht', false);
        $response->assertSee('qc_name', false);
    }

    // ── Valid submission ─────────────────────────────────────────────────────

    public function test_valid_quick_submission_redirects_with_success(): void
    {
        Mail::fake();

        $response = $this->post(route('nl.quick_message.store'), $this->validPayload());

        $response->assertRedirect();
        $response->assertSessionHas('quick_success', true);
    }

    public function test_valid_submission_sends_admin_email(): void
    {
        Mail::fake();

        $this->post(route('nl.quick_message.store'), $this->validPayload());

        Mail::assertSent(AdminQuickMessageMail::class);
    }

    public function test_admin_email_goes_to_configured_address(): void
    {
        Mail::fake();

        $this->post(route('nl.quick_message.store'), $this->validPayload());

        Mail::assertSent(AdminQuickMessageMail::class, fn ($m) =>
            $m->hasTo(config('mail.contact_notification_email'))
        );
    }

    public function test_admin_email_reply_to_is_visitor(): void
    {
        Mail::fake();

        $this->post(route('nl.quick_message.store'), $this->validPayload([
            'qc_email' => 'marie@example.com',
        ]));

        Mail::assertSent(AdminQuickMessageMail::class, fn ($m) =>
            $m->hasReplyTo('marie@example.com')
        );
    }

    public function test_valid_submission_sends_customer_confirmation(): void
    {
        Mail::fake();

        $this->post(route('nl.quick_message.store'), $this->validPayload([
            'qc_email' => 'marie@example.com',
        ]));

        Mail::assertSent(CustomerQuickConfirmationMail::class, fn ($m) =>
            $m->hasTo('marie@example.com')
        );
    }

    public function test_customer_confirmation_uses_nl_locale(): void
    {
        Mail::fake();

        $this->post(route('nl.quick_message.store'), $this->validPayload());

        Mail::assertSent(CustomerQuickConfirmationMail::class);
    }

    public function test_customer_confirmation_uses_fr_locale(): void
    {
        Mail::fake();

        $this->post(route('fr.quick_message.store'), $this->validPayload());

        Mail::assertSent(CustomerQuickConfirmationMail::class);
    }

    public function test_customer_confirmation_renders_without_raw_keys(): void
    {
        $html = (new CustomerQuickConfirmationMail($this->validPayload()))
            ->locale('nl')
            ->render();

        $this->assertStringNotContainsString('site.quick_contact.', $html);
        $this->assertStringContainsString('Van Malder Studio', $html);
    }

    public function test_confirmation_renders_for_each_locale(): void
    {
        foreach (['nl', 'fr', 'en', 'de'] as $locale) {
            $html = (new CustomerQuickConfirmationMail($this->validPayload()))
                ->locale($locale)
                ->render();

            $this->assertStringNotContainsString('site.quick_contact.', $html,
                "Confirmation email contains raw translation key for locale '{$locale}'");
        }
    }

    // ── Validation failures ──────────────────────────────────────────────────

    public function test_missing_privacy_consent_fails(): void
    {
        Mail::fake();

        $response = $this->post(route('nl.quick_message.store'),
            $this->validPayload(['qc_privacy' => ''])
        );

        $response->assertSessionHasErrors('qc_privacy');
        Mail::assertNothingSent();
    }

    public function test_missing_name_fails(): void
    {
        Mail::fake();

        $response = $this->post(route('nl.quick_message.store'),
            $this->validPayload(['qc_name' => ''])
        );

        $response->assertSessionHasErrors('qc_name');
    }

    public function test_invalid_email_fails(): void
    {
        Mail::fake();

        $response = $this->post(route('nl.quick_message.store'),
            $this->validPayload(['qc_email' => 'not-an-email'])
        );

        $response->assertSessionHasErrors('qc_email');
    }

    public function test_empty_message_fails(): void
    {
        Mail::fake();

        $response = $this->post(route('nl.quick_message.store'),
            $this->validPayload(['qc_message' => ''])
        );

        $response->assertSessionHasErrors('qc_message');
    }

    public function test_message_too_long_fails(): void
    {
        Mail::fake();

        $response = $this->post(route('nl.quick_message.store'),
            $this->validPayload(['qc_message' => str_repeat('a', 2001)])
        );

        $response->assertSessionHasErrors('qc_message');
    }

    // ── Honeypot ─────────────────────────────────────────────────────────────

    public function test_honeypot_filled_silently_succeeds(): void
    {
        Mail::fake();

        $response = $this->post(route('nl.quick_message.store'),
            $this->validPayload(['qc_hp' => 'bot-filled-this'])
        );

        $response->assertSessionHas('quick_success');
        Mail::assertNothingSent();
    }

    // ── Portrait image reference ─────────────────────────────────────────────

    public function test_homepage_references_xander_portrait(): void
    {
        $response = $this->get(route('nl.home'));
        $response->assertStatus(200);
        $response->assertSee('Xander.webp', false);
    }
}
