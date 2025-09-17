<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
  public function index()
  {
    $activities = Activity::all();

    return view('activity.index', compact('activities'));
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
      'food' => 'nullable|boolean',
      'description' => 'required|min:5|max:1000',
      'starttime' => 'required|date',
      'endtime' => 'required|date',
      'costs' => 'required|numeric'
    ]);

    Activity::create($validated);

    return redirect()->route('dashboard');
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
