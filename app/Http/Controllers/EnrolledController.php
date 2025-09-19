<?php

namespace App\Http\Controllers;

use App\Models\Enrolled;
use Illuminate\Http\Request;

class EnrolledController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();

        $enrollments = Enrolled::with('activity')
            ->where('user_id', $userId)
            ->get();

        $activities = $enrollments->pluck('activity');

        return view('enrolled.index', compact('activities'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($activityId)
    {
        $userId = auth()->id();

        $alreadyEnrolled = Enrolled::where('user_id', $userId)
            ->where('activity_id', $activityId)
            ->exists();

        if (!$alreadyEnrolled) {
            Enrolled::create([
                'user_id' => $userId,
                'activity_id' => $activityId,
                // 'status' => '',
            ]);
        }

        return redirect()->route('activity.enrolled');

    }

    /**
     * Display the specified resource.
     */
    public function show(enrolled $enrolled)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(enrolled $enrolled)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, enrolled $enrolled)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($activityId)
    {
        $userId = auth()->id();

        Enrolled::where('user_id', $userId)
            ->where('activity_id', $activityId)
            ->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Je bent afgemeld voor deze activiteit.');
    }
}
