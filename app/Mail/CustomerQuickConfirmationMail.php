<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerQuickConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('site.quick_contact.confirmation_subject'),
        );
    }

    public function content(): Content
    {
        $firstName = explode(' ', trim((string) ($this->data['qc_name'] ?? '')), 2)[0]
            ?: ($this->data['qc_name'] ?? 'daar');

        return new Content(
            view: 'emails.customer.quick-confirmation',
            with: [
                'firstName'   => $firstName,
                'userMessage' => e($this->data['qc_message'] ?? ''),
            ],
        );
    }
}
