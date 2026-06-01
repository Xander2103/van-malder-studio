<?php

namespace App\Console\Commands;

use App\Mail\CustomerRequestConfirmationMail;
use App\Models\Inquiry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestCustomerMailCommand extends Command
{
    protected $signature = 'inquiry:test-customer-mail
                            {email : Recipient address for the test confirmation}';

    protected $description = 'Send a test customer confirmation email using the latest inquiry (CLI/VPS debugging only)';

    public function handle(): int
    {
        $email = $this->argument('email');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error("Invalid email address: {$email}");
            return self::FAILURE;
        }

        $inquiry = Inquiry::latest()->first();

        if (! $inquiry) {
            $this->error('No inquiries found. Submit a test form first, then re-run this command.');
            return self::FAILURE;
        }

        $locale = $inquiry->locale ?? 'nl';

        $this->info("Using inquiry #{$inquiry->id}");
        $this->line("  name:   {$inquiry->name}");
        $this->line("  locale: {$locale}");
        $this->info("Sending customer confirmation to: {$email}");

        try {
            Mail::to($email)->send(
                (new CustomerRequestConfirmationMail($inquiry))->locale($locale)
            );
            $this->info("✓ Mail sent successfully to {$email}");
            $this->line('  Check inbox (and spam) for subject: '
                . __('site.mail.confirmation_subject'));
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('✗ Mail send failed: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
