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
    $activities = Activity::all();

    $enrollments = Enrolled::with('activity')
      ->where('user_id', Auth::id())
      ->get();

    // Extra variable: oldActivities (activities that have ended)
    $oldActivities = $activities->where('starttime', '<', now());


    $enrolledActivities = $enrollments->pluck('activity')->where('starttime', '>=', now());
    $availableActivities = $activities->diff($enrolledActivities)->where('starttime', '>=', now());

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
        'name'         => 'required|string|max:255',
        'location'     => 'required|string|max:255',
        'food'         => 'boolean',
        'description'  => 'required|min:5|max:1000',
        'starttime'    => 'required|date',
        'endtime'      => 'required|date|after:starttime',
        'costs'        => 'required|numeric',
        'min'          => 'nullable|integer|min:0',
        'max_capacity' => 'required|integer|min:1',
        'visibility' => 'required',
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
    
     Log::info('Activity store request data:', $request->all());

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

    $amountOfEnrollments = $users->count() + $guests->count();

    $combined = $users->map(function ($user) {
      return [
        'type' => 'Medewerker',
        'name' => $user->name,
        'email' => $user->email,
      ];
    })->merge(
      $guests->map(function ($guest) {
        return [
          'type' => 'Gast',
          'name' => $guest->pivot->name,
          'email' => $guest->pivot->email,
        ];
      })
    );

    $page = request()->get('page', 1);
    $perPage = 10;
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
