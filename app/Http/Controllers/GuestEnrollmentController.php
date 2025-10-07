<?php

namespace App\Http\Controllers;

use App\Models\GuestEnrollment;
use App\Models\Activity;
use Illuminate\Http\Request;

class GuestEnrollmentController extends Controller {
    public function store(Request $request) {
        $validated = $request->validate([
            'activity_id' => 'required|uuid|exists:activities,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        GuestEnrollment::create([
            'activity_id' => $validated['activity_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'verified' => false,
        ]);

        return redirect()->route('welcome')->with('success', 'Verificatie e-mail is verzonden!');
    }
}
