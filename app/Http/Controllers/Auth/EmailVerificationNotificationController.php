<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller {
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('activity.index', absolute: false))->with('success', 'Je e-mailadres is geverifieerd.');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent')->with('success', 'Verificatie e-mail is verzonden.');
    }
}
