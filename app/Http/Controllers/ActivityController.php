<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Enrolled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

  public function store(Request $request) {
    $request->merge(['costs' => str_replace(',', '.', $request->input('costs'))]);

    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'location' => 'required|string|max:255',
      'food' => 'boolean',
      'description' => 'required|min:5|max:1000',
      'starttime' => 'required|date',
      'endtime' => 'required|date|after:starttime',
      'costs' => 'required|numeric'
    ]);

    Activity::create($validated);

    return redirect()->route('dashboard');
  }

  public function enrolled() {
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
