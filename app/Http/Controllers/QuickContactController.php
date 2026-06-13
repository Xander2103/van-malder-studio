<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuickContactRequest;
use App\Mail\AdminQuickMessageMail;
use App\Mail\CustomerQuickConfirmationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class QuickContactController extends Controller
{
    public function store(QuickContactRequest $request)
    {
        $locale    = app()->getLocale() ?: 'nl';
        $routeName = Route::has($locale . '.contact') ? $locale . '.contact' : 'contact';

        // Honeypot: if the hidden field is filled, silently appear to succeed
        if ($request->filled('qc_hp')) {
            return redirect()->route($routeName)
                ->with('quick_success', true)
                ->withFragment('snel-bericht');
        }

        // Time-based bot check: reject submissions faster than 3 seconds
        $formTime = (int) $request->input('qc_form_time', 0);
        if ($formTime > 0 && (time() - $formTime) < 3) {
            return redirect()->route($routeName)
                ->with('quick_success', true)
                ->withFragment('snel-bericht');
        }

        $data = $request->validated();

        try {
            $adminEmail = config('mail.contact_notification_email');

            Mail::to($adminEmail)
                ->send(new AdminQuickMessageMail($data, $locale)); // $locale → $msgLocale in Mailable

            $visitorEmail = $data['qc_email'];
            if (filter_var($visitorEmail, FILTER_VALIDATE_EMAIL)) {
                Mail::to($visitorEmail)
                    ->send((new CustomerQuickConfirmationMail($data))->locale($locale));
            }
        } catch (\Throwable $e) {
            Log::error('[QuickContact] Mail sending failed', [
                'exception' => $e->getMessage(),
            ]);

            return redirect()->route($routeName)
                ->with('quick_error', true)
                ->withFragment('snel-bericht');
        }

        return redirect()->route($routeName)
            ->with('quick_success', true)
            ->withFragment('snel-bericht');
    }
}
