<?php

namespace App\Http\Controllers;
use App\Models\LifestyleScore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class leaderboard extends Controller
{
    public function index()
    {
        $leaderboard = LifestyleScore::with('user')
            ->orderByDesc('score')
            ->take(10)
            ->get();

        return view('lifestyle-score.leaderboard', compact('lifestyleScores'));
    }
}