<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Services\InquiryService;

class InquiryController extends Controller
{
    public function __construct(private InquiryService $inquiryService) {}

    public function store(StoreInquiryRequest $request)
    {
        // Honeypot: if the hidden "website" field is filled, silently pass
        if ($request->filled('website')) {
            return redirect()->route('contact')->with('success', true);
        }

        $this->inquiryService->store($request->validated(), $request);

        return redirect()->route('contact')->with('success', true);
    }
}
