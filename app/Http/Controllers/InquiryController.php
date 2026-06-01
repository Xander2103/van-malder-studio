<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Services\InquiryService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class InquiryController extends Controller
{
    public function __construct(private InquiryService $inquiryService) {}

    public function store(StoreInquiryRequest $request)
    {
        $locale       = app()->getLocale() ?: 'nl';
        $contactRoute = Route::has($locale . '.contact') ? $locale . '.contact' : 'contact';

        // Honeypot: if the hidden "website" field is filled, silently pass
        if ($request->filled('website')) {
            return redirect()->route($contactRoute)->with('success', true);
        }

        $inquiry = $this->inquiryService->store($request->validated(), $request);

        try {
            $this->inquiryService->sendNotifications($inquiry);
        } catch (\Throwable $e) {
            Log::error('Mail sending failed for inquiry', [
                'inquiry_id'     => $inquiry->id,
                'inquiry_email'  => $inquiry->email,
                'inquiry_locale' => $inquiry->locale,
                'exception'      => $e,
            ]);

            return redirect()->route($contactRoute)->with('mail_error', true);
        }

        return redirect()->route($contactRoute)->with('success', true);
    }
}
