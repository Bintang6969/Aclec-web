<?php

namespace App\Http\Controllers;

use App\Models\LifeTrackerEntry;
use App\Models\WorkoutSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutPlannerController extends Controller
{
    public function index()
    {
        $user     = Auth::user();
        $sessions = WorkoutSession::where('user_id', $user->id)
            ->orderByDesc('session_date')
            ->paginate(10);

        $workoutTypes = WorkoutSession::workoutTypes();

        return view('workout-planner.index', compact('sessions', 'workoutTypes', 'user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'session_date'     => ['required', 'date', 'before_or_equal:today'],
            'workout_type'     => ['required', 'in:' . implode(',', array_keys(WorkoutSession::workoutTypes()))],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:600'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ]);

        $cpm = WorkoutSession::caloriesPerMinute()[$data['workout_type']] ?? 5;
        $data['calories_burned'] = $data['duration_minutes'] * $cpm;
        $data['user_id'] = Auth::id();

        $session = WorkoutSession::create($data);

        // Sync calories_out to LifeTracker for that day
        $entry = LifeTrackerEntry::firstOrCreate(
            ['user_id' => Auth::id(), 'entry_date' => $data['session_date']],
            ['water_ml' => 0, 'sleep_hours' => 0, 'calories_in' => 0, 'calories_out' => 0, 'exercise_minutes' => 0]
        );

        $totalCaloriesBurned = WorkoutSession::where('user_id', Auth::id())
            ->where('session_date', $data['session_date'])
            ->sum('calories_burned');

        $totalMinutes = WorkoutSession::where('user_id', Auth::id())
            ->where('session_date', $data['session_date'])
            ->sum('duration_minutes');

        $entry->update([
            'calories_out'     => $totalCaloriesBurned,
            'exercise_minutes' => $totalMinutes,
        ]);

        return redirect()->route('workout-planner.index')->with('success', 'Sesi workout berhasil dicatat! ' . $session->calories_burned . ' kkal terbakar.');
    }

    public function destroy(WorkoutSession $workoutSession)
    {
        if ($workoutSession->user_id !== Auth::id()) {
            abort(403);
        }
        $workoutSession->delete();
        return redirect()->route('workout-planner.index')->with('success', 'Sesi workout dihapus.');
    }
}
