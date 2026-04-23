<?php

namespace App\Http\Controllers;

use App\Models\LifeTrackerEntry;
use App\Models\LifestyleScore;
use App\Models\WorkoutSession;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $today = now()->toDateString();

        $todayEntry = LifeTrackerEntry::where('user_id', $user->id)
            ->where('entry_date', $today)
            ->first();

        $todayWorkouts = WorkoutSession::where('user_id', $user->id)
            ->where('session_date', $today)
            ->get();

        $latestScore = LifestyleScore::where('user_id', $user->id)
            ->orderByDesc('score_date')
            ->first();

        $weeklyCalories = LifeTrackerEntry::where('user_id', $user->id)
            ->where('entry_date', '>=', now()->subDays(6)->toDateString())
            ->orderBy('entry_date')
            ->get(['entry_date', 'calories_in', 'calories_out']);

        return view('dashboard2', compact('user', 'todayEntry', 'todayWorkouts', 'latestScore', 'weeklyCalories'));
    }
}
