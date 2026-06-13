<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminQuickMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly array $data,
        public readonly string $msgLocale = 'nl',
    ) {}

    public function envelope(): Envelope
    {
        $replyTo = filter_var($this->data['qc_email'] ?? '', FILTER_VALIDATE_EMAIL)
            ? [new Address($this->data['qc_email'], $this->data['qc_name'] ?? '')]
            : [];

        return new Envelope(
            subject: 'Snel bericht via Van Malder Studio — ' . \Illuminate\Support\Str::limit(strip_tags((string) ($this->data['qc_name'] ?? '')), 60),
            replyTo: $replyTo,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.quick-message',
            with: [
                'name'           => e($this->data['qc_name'] ?? ''),
                'email'          => e($this->data['qc_email'] ?? ''),
                'contactMessage' => e($this->data['qc_message'] ?? ''),
                'msgLocale'      => $this->msgLocale,
            ],
        );
    }
}
