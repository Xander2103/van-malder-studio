<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Services\InquiryService;
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

        $this->inquiryService->store($request->validated(), $request);

        return redirect()->route($contactRoute)->with('success', true);
    }
}
