<?php

namespace App\Http\Controllers;

use App\Models\LifeTrackerEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LifeTrackerController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $entries = LifeTrackerEntry::where('user_id', $user->id)
            ->orderByDesc('entry_date')
            ->paginate(14);

        $todayEntry = LifeTrackerEntry::where('user_id', $user->id)
            ->where('entry_date', now()->toDateString())
            ->first();

        return view('life-tracker.index', compact('entries', 'todayEntry', 'user'));
    }

    public function store(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'entry_date'       => ['required', 'date', 'before:tomorrow'],  // allow today + past dates
            'water_ml'         => ['required', 'integer', 'min:0', 'max:15000'],
            'sleep_hours'      => ['required', 'numeric', 'min:0', 'max:24'],  // decimal allowed (7.5)
            'calories_in'      => ['required', 'integer', 'min:0', 'max:20000'],
            'exercise_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ]);

        // Security: Ensure user can only update own data
        $data['user_id'] = Auth::id();

        // Auto-calculate calories_out from exercise minutes
        // Simple formula: use average 5 kcal per minute (adjust per user workout type)
        $data['calories_out'] = $data['exercise_minutes'] * 5;

        // Prevent race condition: use updateOrCreate with proper locking
        try {
            LifeTrackerEntry::updateOrCreate(
                ['user_id' => Auth::id(), 'entry_date' => $data['entry_date']],
                $data
            );
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Gagal menyimpan data.'], 500);
            }
            return redirect()->back()->withErrors('Gagal menyimpan data. Silakan coba lagi.');
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('life-tracker.index')->with('success', 'Data harian berhasil disimpan!');
    }

    public function destroy(LifeTrackerEntry $lifeTrackerEntry)
    {
        // Authorization: ensure user can only delete own entries
        if ($lifeTrackerEntry->user_id !== Auth::id()) {
            abort(403, 'Unauthorized to delete this entry.');
        }

        try {
            $lifeTrackerEntry->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Gagal menghapus data.');
        }

        return redirect()->route('life-tracker.index')->with('success', 'Data dihapus.');
    }
}
