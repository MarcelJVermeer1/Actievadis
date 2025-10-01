<?php

namespace App\Http\Controllers;

use App\Models\GuestEnrollment;
use App\Models\Activity;
use Illuminate\Http\Request;

class GuestEnrollmentController extends Controller {
    public function store(Request $request, $activityId) {
        $activity = Activity::findOrFail($activityId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        GuestEnrollment::create([
            'activity_id' => $activity->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'verified' => false,
        ]);

        return redirect()->back()->with('success', "Je hebt je geregistreerd voor {$activity->name}.");
    }
}
