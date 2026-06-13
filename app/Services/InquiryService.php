<?php

namespace App\Services;

use App\Mail\AdminRequestReceivedMail;
use App\Mail\CustomerRequestConfirmationMail;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InquiryService
{
    public function store(array $validated, Request $request): Inquiry
    {
        $inquiry = Inquiry::create([
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

        return $inquiry;
    }

    public function sendNotifications(Inquiry $inquiry): void
    {
        $adminEmail = config('mail.contact_notification_email');

        Log::info('[InquiryService] Sending admin notification', [
            'inquiry_id' => $inquiry->id,
            'to'         => $adminEmail,
        ]);
        Mail::to($adminEmail)
            ->send(new AdminRequestReceivedMail($inquiry));
        Log::info('[InquiryService] Admin notification sent', ['inquiry_id' => $inquiry->id]);

        $customerEmail = $inquiry->email;

        if (! filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            Log::warning('[InquiryService] Skipping customer confirmation — invalid or missing email', [
                'inquiry_id'    => $inquiry->id,
                'email_present' => ! empty($customerEmail),
            ]);
            return;
        }

        Log::info('[InquiryService] Sending customer confirmation', [
            'inquiry_id' => $inquiry->id,
        ]);
        Mail::to($customerEmail)
            ->send(
                (new CustomerRequestConfirmationMail($inquiry))
                    ->locale($inquiry->locale ?? 'nl')
            );
        Log::info('[InquiryService] Customer confirmation sent', ['inquiry_id' => $inquiry->id]);
    }
}
