<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Enrolled;
use App\Models\ActivityGuest;

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
    public function store(Request $request, $activityId)
    {
        $userId = auth()->id();
        $status = $request->input('status', 'attending'); // default aanwezig

        $activity = Activity::with(['users', 'guests'])->findOrFail($activityId);

        // capaciteit check → telt users en guests met status=attending
        $totalAttending = $activity->users()->wherePivot('status','attending')->count()
            + $activity->guests()->where('status','attending')->count();

        if ($status === 'attending' 
            && $activity->max_participants 
            && $totalAttending >= $activity->max_participants) 
        {
            return back()->with('error', 'Deze activiteit is vol. Je kunt je niet meer als aanwezig inschrijven.');
        }

        // create of update inschrijving
        Enrolled::updateOrCreate(
            ['user_id' => $userId, 'activity_id' => $activityId],
            ['status'  => $status]
        );

        return redirect()->route('activity.show', $activityId)
            ->with('success', 'Je inschrijving is opgeslagen.');

    }

    public function storeGuest(Request $request,$activityId)
    {
        $activity = Activity::with(['users', 'guests'])->findOrFail($activityId);
        
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:30',
            'status'=> 'in:attending,maybe'
        ]);

        $status = $validated['status'] ?? 'attending';

        // capaciteit check
        $totalAttending = $activity-users()->wherePivot('status','attending')->count
            + $activity->guests()->where('status','attending')->count();

        if ($status === 'attending' 
            && $activity->max_participants 
            && $totalAttending >= $activity->max_participants) 
        {
            return back()->with('error', 'Deze activiteit is vol. Je kunt je niet meer als aanwezig inschrijven.');
        }
         // nieuwe guest inschrijven
        $activity->guests()->create([
            'name'   => $validated['name'],
            'email'  => $validated['email'],
            'phone'  => $validated['phone'] ?? null,
            'status' => $status,
        ]);

        return redirect()->route('activity.show', $activityId)
            ->with('success', 'Je bent ingeschreven als gast.');
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

        return redirect()->route('activity.index')
            ->with('success', 'Je bent afgemeld voor deze activiteit.');
    }

    /**
     * Gast uitschrijven
     */
    public function destroyGuest($activityId, Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        ActivityGuest::where('activity_id', $activityId)
            ->where('email', $request->input('email'))
            ->delete();

        return redirect()->route('activity.show', $activityId)
            ->with('success', 'De gast is afgemeld.');
    }
}
