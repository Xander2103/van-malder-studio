<?php

namespace App\Services;

use App\Models\Inquiry;
use Illuminate\Http\Request;

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
        ]);

        // TODO: Send email notification to hello@vanmalderstudio.be once mail is configured.

        return $inquiry;
    }
}
