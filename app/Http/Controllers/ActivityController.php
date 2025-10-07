<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Enrolled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
  public function index()
  {
    $sortEnrolled = request('sort_enrolled', 'date_asc');
    $sortAvailable = request('sort_available', 'date_asc');
    $sortOld = request('sort_old', 'date_asc');

    function getOrder($sort)
    {
      return match ($sort) {
        'az' => ['name', 'asc'],
        'za' => ['name', 'desc'],
        'date_desc' => ['starttime', 'desc'],
        default => ['starttime', 'asc'],
      };
    }

    [$colE, $dirE] = getOrder($sortEnrolled);
    [$colA, $dirA] = getOrder($sortAvailable);
    [$colO, $dirO] = getOrder($sortOld);

    $enrolledIds = Enrolled::where('user_id', Auth::id())->pluck('activity_id');

    $enrolledActivities = Activity::whereIn('id', $enrolledIds)
      ->where('starttime', '>=', now())
      ->orderBy($colE, $dirE)
      ->paginate(3, ['*'], 'enrolled_page')
      ->appends(request()->query());

    $availableActivities = Activity::whereNotIn('id', $enrolledIds)
      ->where('starttime', '>=', now())
      ->orderBy($colA, $dirA)
      ->paginate(3, ['*'], 'available_page')
      ->appends(request()->query());

    $oldActivities = Activity::whereIn('id', $enrolledIds)
      ->where('endtime', '<', now())
      ->orderBy($colO, $dirO)
      ->paginate(3, ['*'], 'old_page')
      ->appends(request()->query());

    return view('activity.index', compact(
      'enrolledActivities',
      'availableActivities',
      'oldActivities'
    ));
  }

  public function create(Request $request)
  {
    return view('admin.createActivity');
  }

  public function store(Request $request)
  {
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

    return redirect()->route('dashboard')->with('success', 'Activiteit succesvol aangemaakt!');
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

  public function getActivitiesList()
  {
    $activitiesList = Activity::where('starttime', '>=', now())
      ->orderBy('starttime', 'asc')
      ->get();

    return view('welcome', compact('activitiesList'));
  }
}
