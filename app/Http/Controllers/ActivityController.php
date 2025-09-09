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
}
