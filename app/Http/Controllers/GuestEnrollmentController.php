<?php

namespace App\Http\Controllers;

use App\Models\GuestEnrollment;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\GuestEnrollmentVerification;
use App\Mail\GuestDeregistration;
use Illuminate\Http\RedirectResponse;

class GuestEnrollmentController extends Controller {
    public function store(Request $request) {
        $validated = $request->validate([
            'activity_id' => 'required|uuid|exists:activities,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $guest = GuestEnrollment::create([
            'activity_id' => $validated['activity_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'verified' => false,
        ]);

        Mail::to($guest->email)->send(new GuestEnrollmentVerification($guest));

        return redirect()->route('welcome')->with('success', 'Verificatie e-mail is verzonden!');
    }

    public function verify(Request $request): RedirectResponse {
        if (! $request->hasValidSignature()) {
            return redirect()->route('welcome')->with('error', 'Ongeldige of verlopen verificatielink.');
        }

        $id = $request->route('id');
        $guest = GuestEnrollment::find($id);
        if (! $guest) {
            return redirect()->route('welcome')->with('error', 'Inschrijving niet gevonden.');
        }

        $guest->verified = true;
        $guest->save();

        Mail::to($guest->email)->send(new GuestDeregistration($guest));

        return redirect()->route('welcome')->with('success', 'Je inschrijving is bevestigd.');
    }

    public function deregister(Request $request, $id): RedirectResponse {
        $signature = $request->query('signature');
        $expectedSignature = sha1($id . config('app.key'));

        if ($signature !== $expectedSignature) {
            return redirect()->route('welcome')->with('error', 'Ongeldige of verlopen afmeldlink.');
        }

        $guest = GuestEnrollment::find($id);
        if (! $guest) {
            return redirect()->route('welcome')->with('error', 'Inschrijving niet gevonden.');
        }

        $guest->delete();

        return redirect()->route('welcome')->with('success', 'Je bent uitgeschreven voor de activiteit.');
    }
}
