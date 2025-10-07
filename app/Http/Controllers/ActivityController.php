<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Enrolled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ActivityController extends Controller {
  public function index() {
    $activities = Activity::all();

    $enrollments = Enrolled::with('activity')
      ->where('user_id', Auth::id())
      ->get();

    // Extra variable: oldActivities (activities that have ended)
    $oldActivities = $activities->where('starttime', '<', now());


    $enrolledActivities = $enrollments->pluck('activity')->where('starttime', '>=', now());
    $availableActivities = $activities->diff($enrolledActivities)->where('starttime', '>=', now());

    return view('activity.index', compact('activities', 'enrolledActivities', 'availableActivities', 'oldActivities'));
  }

  public function create(Request $request) {
    return view('admin.createActivity');
  }

public function store(Request $request)
{
    // Replace comma with dot for numeric consistency
    $request->merge(['costs' => str_replace(',', '.', $request->input('costs'))]);

    // Validate all inputs
    $validated = $request->validate([
        'name'         => 'required|string|max:255',
        'location'     => 'required|string|max:255',
        'food'         => 'boolean',
        'description'  => 'required|min:5|max:1000',
        'starttime'    => 'required|date',
        'endtime'      => 'required|date|after:starttime',
        'costs'        => 'required|numeric',
        'min'          => 'nullable|integer|min:0',
        'necessities'  => 'nullable|string|max:255',
        'image'        => 'nullable|image|max:16384', // 16 MB max
    ]);

    // ✅ Create an image manager with the GD driver (v3 syntax)
    $manager = new ImageManager(new Driver());

    // Handle and compress the image if uploaded
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $img = $manager->read($request->file('image')->getRealPath())
            ->scaleDown(1200)     // Resize while maintaining aspect ratio
            ->toJpeg(75);         // Compress to ~75% quality

        // Store binary data (for MEDIUMBLOB or LONGBLOB)
        $validated['image'] = $img->toString();
    }

    // Save the activity
    Activity::create($validated);

    return redirect()->route('dashboard')
        ->with('success', 'Activiteit succesvol aangemaakt!');
}

  public function enrolled()
  {
    $enrolledActivities = auth()->user()->enrolledActivities;

    return view('enrolled.index', compact('enrolledActivities'));
  }

  public function show($id) {
    $activity = Activity::findOrFail($id);
    return view('activity.show', compact('activity'));
  }

  public function getActivitiesList() {
    $activitiesList = Activity::where('starttime', '>=', now())
      ->orderBy('starttime', 'asc')
      ->get();

    return view('welcome', compact('activitiesList'));
  }
}
