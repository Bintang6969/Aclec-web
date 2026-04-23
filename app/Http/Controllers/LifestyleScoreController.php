<?php

namespace App\Http\Controllers;

use App\Models\LifeTrackerEntry;
use App\Models\LifestyleScore;
use Illuminate\Support\Facades\Auth;

class LifestyleScoreController extends Controller
{
    private const HEALTHY_THRESHOLD = 70;

    public function index()
    {
        $user = Auth::user();

        $today = now()->toDateString();

        $todayScore = $this->calculateAndSave($user, $today);

        $topScores = LifestyleScore::with('user:id,name,avatar')
            ->whereDate('score_date', $today)
            ->orderByDesc('score')
            ->take(10)
            ->get();

        $history = LifestyleScore::where('user_id', $user->id)
            ->orderByDesc('score_date')
            ->take(30)
            ->get();

        return view('lifestyle-score.index', compact('user', 'todayScore', 'topScores', 'history'));
    }

    private function calculateAndSave($user, string $date): LifestyleScore
    {
        $entry = LifeTrackerEntry::where('user_id', $user->id)
            ->where('entry_date', $date)
            ->first();

        $score = 0;
        if ($entry) {
            // Water: max 25 pts (2000ml target)
            $score += min(25, round(($entry->water_ml / 2000) * 25));
            // Sleep: max 25 pts (7-9h ideal)
            $sleepScore = $entry->sleep_hours >= 7 && $entry->sleep_hours <= 9 ? 25 : max(0, 25 - abs($entry->sleep_hours - 8) * 5);
            $score += $sleepScore;
            // Exercise: max 25 pts (30min target)
            $score += min(25, round(($entry->exercise_minutes / 30) * 25));
            // Calorie balance: max 25 pts
            $tdee = $user->tdee ?: 2000;
            $balance = abs($entry->calories_in - $tdee);
            $score += max(0, 25 - round(($balance / $tdee) * 25));
        }

        $rewardType = 'neutral';
        $message    = null;

        if ($score >= self::HEALTHY_THRESHOLD) {
            $rewardType = 'reward';
            $message    = 'Kerja bagus! Kamu berhak menikmati makanan favoritmu hari ini. 🎉';
        } elseif ($score < 40 && $entry) {
            $rewardType = 'punishment';
            $message    = 'Yuk semangat! Lakukan workout 30 menit ekstra hari ini untuk mengejar target. 💪';
        }

        return LifestyleScore::updateOrCreate(
            ['user_id' => $user->id, 'score_date' => $date],
            ['score' => $score, 'reward_type' => $rewardType, 'reward_message' => $message]
        );
    }
}
