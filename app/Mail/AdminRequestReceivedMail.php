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
            subject: 'Nieuwe aanvraag via Van Malder Studio — ' . \Illuminate\Support\Str::limit(strip_tags((string) $this->inquiry->name), 80),
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
