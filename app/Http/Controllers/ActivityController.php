<?php

namespace App\Http\Controllers;

use App\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        // Dummy data
        $activities = Activity::all();

        return view('activity.index', compact('activities'));
    }

    public function enrolled()
    {
        $enrolledActivities = auth()->user()->enrolledActivities;

        return view('enrolled.index', compact('enrolledActivities'));
    }

    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        return view('activity.show', compact('activity'));
    }
}
