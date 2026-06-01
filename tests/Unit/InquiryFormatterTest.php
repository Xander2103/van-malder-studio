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

    public function test_gdpr_consent_shown_as_nee_when_false(): void
    {
        $row = collect(InquiryFormatter::toRows($this->makeInquiry(['gdpr_consent' => false])))
            ->firstWhere('label', 'Privacyverklaring');

        $this->assertSame('Nee', $row['value']);
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

    public function test_unknown_future_fields_are_included_with_humanised_labels(): void
    {
        // Simulate an unknown future field by directly adding a column value
        // that is not in InquiryFormatter's known-keys list.
        // We achieve this by creating a real inquiry and using DB::table to add
        // a value for a column that exists on the model but is excluded from display,
        // OR by verifying that source (a known but non-standard field) is included.
        // Since we cannot add real DB columns in a test, we verify the mechanism
        // by checking that 'source' (in known keys) is correctly excluded from
        // the unknown-fields path, and that a value set via ->forceFill() with an
        // attribute name not in the known list WOULD be included.

        // The safest test: create an inquiry, manually inject an unknown attribute
        // via forceFill, and assert it appears in the rows.
        $inquiry = $this->makeInquiry();
        $inquiry->forceFill(['future_custom_field' => 'some value']);

        $rows = InquiryFormatter::toRows($inquiry);
        $labels = array_column($rows, 'label');

        $this->assertContains('Future Custom Field', $labels);

        $row = collect($rows)->firstWhere('label', 'Future Custom Field');
        $this->assertSame('some value', $row['value']);
    }
}
