<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LifeTrackerController;
use App\Http\Controllers\LifestyleScoreController;
use App\Http\Controllers\WorkoutPlannerController;
use Illuminate\Support\Facades\Route;

// Welcome / Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Guest-only routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Auth-protected routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/life-tracker', [LifeTrackerController::class, 'index'])->name('life-tracker.index');
    Route::post('/life-tracker', [LifeTrackerController::class, 'store'])->name('life-tracker.store');
    Route::delete('/life-tracker/{lifeTrackerEntry}', [LifeTrackerController::class, 'destroy'])->name('life-tracker.destroy');

    Route::get('/workout-planner', [WorkoutPlannerController::class, 'index'])->name('workout-planner.index');
    Route::post('/workout-planner', [WorkoutPlannerController::class, 'store'])->name('workout-planner.store');
    Route::delete('/workout-planner/{workoutSession}', [WorkoutPlannerController::class, 'destroy'])->name('workout-planner.destroy');

    Route::get('/lifestyle-score', [LifestyleScoreController::class, 'index'])->name('lifestyle-score.index');

    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

    Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
    Route::post('/community', [CommunityController::class, 'store'])->name('community.store');
    Route::delete('/community/{communityPost}', [CommunityController::class, 'destroy'])->name('community.destroy');

    Route::get('/consultation', [ConsultationController::class, 'index'])->name('consultation.index');
    Route::post('/consultation', [ConsultationController::class, 'send'])->name('consultation.send');
    Route::delete('/consultation/clear', [ConsultationController::class, 'clear'])->name('consultation.clear');
});

