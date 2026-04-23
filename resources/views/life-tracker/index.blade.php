@extends('layouts.app')
@section('title', 'Life Tracker')

@section('content')
<div class="container-fluid py-4">
    <h4 class="fw-bold mb-1">Life Tracker</h4>
    <p class="text-muted small mb-4">Catat aktivitas harian kesehatan kamu</p>

    <div class="row g-4">
        <!-- Form -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h6 class="fw-semibold mb-0">Catat Hari Ini</h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success py-2 small">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('life-tracker.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Tanggal</label>
                            <input type="date" name="entry_date" value="{{ old('entry_date', date('Y-m-d')) }}" required class="form-control form-control-sm">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Air Minum (ml)</label>
                            <input type="number" name="water_ml" value="{{ old('water_ml', 0) }}" min="0" class="form-control form-control-sm" placeholder="cth: 2000">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Durasi Tidur (jam)</label>
                            <input type="number" step="0.5" name="sleep_hours" value="{{ old('sleep_hours', 0) }}" min="0" max="24" class="form-control form-control-sm" placeholder="cth: 7.5">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Kalori Masuk (kcal)</label>
                            <input type="number" name="calories_in" value="{{ old('calories_in', 0) }}" min="0" class="form-control form-control-sm">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Menit Olahraga</label>
                            <input type="number" name="exercise_minutes" value="{{ old('exercise_minutes', 0) }}" min="0" class="form-control form-control-sm">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Catatan (opsional)</label>
                            <textarea name="notes" rows="2" class="form-control form-control-sm" placeholder="Apa yang kamu rasakan hari ini?">{{ old('notes') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100 btn-sm">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- History Table -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h6 class="fw-semibold mb-0">Riwayat Entri</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-3">Tanggal</th>
                                    <th>Air (ml)</th>
                                    <th>Tidur (h)</th>
                                    <th>Kal. Masuk</th>
                                    <th>Kal. Keluar</th>
                                    <th>Olahraga</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($entries as $e)
                                <tr>
                                    <td class="px-3 fw-medium">{{ \Carbon\Carbon::parse($e->entry_date)->format('d M Y') }}</td>
                                    <td>{{ number_format($e->water_ml) }}</td>
                                    <td>{{ $e->sleep_hours }}h</td>
                                    <td class="text-success">+{{ number_format($e->calories_in) }}</td>
                                    <td class="text-danger">-{{ number_format($e->calories_out) }}</td>
                                    <td>{{ $e->exercise_minutes }} min</td>
                                    <td>
                                        <form method="POST" action="{{ route('life-tracker.destroy', $e->id) }}" onsubmit="return confirm('Hapus entri ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger py-0 px-2"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($entries->hasPages())
                    <div class="px-3 py-2">{{ $entries->links('pagination::bootstrap-5') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
