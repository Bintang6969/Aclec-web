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
        $data = $request->validate([
            'entry_date'       => ['required', 'date', 'before_or_equal:today'],
            'water_ml'         => ['required', 'integer', 'min:0', 'max:10000'],
            'sleep_hours'      => ['required', 'integer', 'min:0', 'max:24'],
            'calories_in'      => ['required', 'integer', 'min:0', 'max:20000'],
            'calories_out'     => ['required', 'integer', 'min:0', 'max:20000'],
            'exercise_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ]);

        $data['user_id'] = Auth::id();

        LifeTrackerEntry::updateOrCreate(
            ['user_id' => Auth::id(), 'entry_date' => $data['entry_date']],
            $data
        );

        return redirect()->route('life-tracker.index')->with('success', 'Data harian berhasil disimpan!');
    }

    public function destroy(LifeTrackerEntry $lifeTrackerEntry)
    {
        if ($lifeTrackerEntry->user_id !== Auth::id()) {
            abort(403);
        }
        $lifeTrackerEntry->delete();
        return redirect()->route('life-tracker.index')->with('success', 'Data dihapus.');
    }
}
