<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse {
        try {
            $request->authenticate();

            $request->session()->regenerate();

            return redirect()->intended(route('activity.index', absolute: false))->with('success', 'Je bent ingelogd!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->only('email'))
                ->with('error', 'Inloggen mislukt. Controleer uw gegevens en probeer het opnieuw.');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Je bent uitgelogd');
    }
}
