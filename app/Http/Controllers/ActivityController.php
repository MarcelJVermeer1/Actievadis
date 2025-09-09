<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
  public function index()
  {
    $activities = Activity::all();

    return view('activity.index', compact('activities'));
  }
  public function store()
  {
    $user = Auth::user()->isAdmin;
    return $user ? view('admin.create-activity') : view('dashboard');
    // return view('admin.create-activity');
  }
  public function create(Request $request)
  {
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
}
