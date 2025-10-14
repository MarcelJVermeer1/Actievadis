<?php

namespace App\Http\Controllers;

use App\EnrollmentVisibility;
use App\Models\Activity;
use App\Models\Enrolled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

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

    $enrolledActivities = Activity::withCount('enrolled')
      ->whereIn('id', $enrolledIds)
      ->where('starttime', '>=', now())
      ->orderBy($colE, $dirE)
      ->paginate(3, ['*'], 'enrolled_page')
      ->appends(request()->query());

    $availableActivities = Activity::withCount('enrolled') // ✅ ADDED
      ->whereNotIn('id', $enrolledIds)
      ->where('starttime', '>=', now())
      ->orderBy($colA, $dirA)
      ->paginate(3, ['*'], 'available_page')
      ->appends(request()->query());

    $oldActivities = Activity::withCount('enrolled') // ✅ ADDED
      ->whereIn('id', $enrolledIds)
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
    // Replace comma with dot for numeric consistency
    $request->merge(['costs' => str_replace(',', '.', $request->input('costs'))]);

    // Validate all inputs
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'location' => 'required|string|max:255',
      'food' => 'boolean',
      'description' => 'required|min:5|max:1000',
      'starttime' => 'required|date',
      'endtime' => 'required|date|after:starttime',
      'costs' => 'required|numeric',
      'min' => 'nullable|integer|min:0',
      'max_capacity' => 'required|integer|min:1',
      'visibility' => 'required',
      'necessities' => 'nullable|string|max:255',
      'image' => 'nullable|image|max:16384', // 16 MB max
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

    Log::info('Activity store request data:', $request->all());

    // Save the activity
    Activity::create($validated);

    return redirect()->route('activity.index')
        ->with('success', 'Activiteit succesvol aangemaakt!');
}

  public function enrolled()
  {
    $enrolledActivities = auth()->user()->enrolledActivities;

    return view('enrolled.index', compact('enrolledActivities'));
  }

  public function show($id)
  {
    $activity = Activity::findOrFail($id);
    $user = Auth::user();

    $canViewEnrollments = false;

    if ($activity->visibility === EnrollmentVisibility::Admin->value) {
      $canViewEnrollments = $user && $user->is_admin;
    } elseif ($activity->visibility === EnrollmentVisibility::User->value) {
      $canViewEnrollments = $user !== null;
    } elseif ($activity->visibility === EnrollmentVisibility::Full->value) {
      $canViewEnrollments = true;
    }

    $users = $canViewEnrollments ? $activity->users : collect();
    $guests = $canViewEnrollments ? $activity->guestUsers : collect();

    // Convert to plain collections
    $users = collect($users->all());
    $guests = collect($guests->all());

    $combined = $users->map(function ($user) {
      return (object) [
        'type' => 'Medewerker',
        'name' => $user->name,
        'email' => $user->email,
      ];
    })->merge(
      $guests->map(function ($guest) {
        return (object) [
          'type' => 'Gast',
          'name' => $guest->pivot->name,
          'email' => $guest->pivot->email,
        ];
      })
    );
    
    $page = request()->get('page', 1);
    $perPage = 10;

    $amountOfEnrollments = $users->count() + $guests->count();

    $paginator = new LengthAwarePaginator(
      $combined->forPage($page, $perPage),
      $combined->count(),
      $perPage,
      $page,
      ['path' => request()->url(), 'query' => request()->query()]
    );

    return view('activity.show', compact(
      'activity',
      'paginator',
      'amountOfEnrollments',
      'canViewEnrollments'
    ));
  }

  public function getActivitiesList()
  {
    $activitiesList = Activity::where('starttime', '>=', now())
      ->orderBy('starttime', 'asc')
      ->get();


    return view('welcome', compact('activitiesList'));
  }
}
