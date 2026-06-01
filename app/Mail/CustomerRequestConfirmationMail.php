<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

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
        $firstName = explode(' ', trim((string) $this->inquiry->name), 2)[0] ?: $this->inquiry->name;

        return new Content(
            view: 'emails.customer.request-confirmation',
            with: [
                'inquiry'   => $this->inquiry,
                'firstName' => $firstName,
            ],
        );
    }
}
