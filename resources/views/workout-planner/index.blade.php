@extends('layouts.app')
@section('title', 'Workout Planner')

@section('content')
<div class="container-fluid py-4">
    <h4 class="fw-bold mb-1">Workout Planner</h4>
    <p class="text-muted small mb-4">Catat sesi latihan dan lacak kalori terbakar</p>

    <div class="row g-4">
        <!-- Form -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h6 class="fw-semibold mb-0">Tambah Sesi Latihan</h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success py-2 small">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('workout-planner.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Tanggal</label>
                            <input type="date" name="session_date" value="{{ old('session_date', date('Y-m-d')) }}" required class="form-control form-control-sm">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Jenis Olahraga</label>
                            <select name="workout_type" required class="form-select form-select-sm">
                                <option value="">Pilih jenis...</option>
                                @foreach(\App\Models\WorkoutSession::workoutTypes() as $val => $label)
                                    <option value="{{ $val }}" {{ old('workout_type')==$val?'selected':'' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Durasi (menit)</label>
                            <input type="number" name="duration_minutes" value="{{ old('duration_minutes', 30) }}" min="1" required class="form-control form-control-sm">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Catatan (opsional)</label>
                            <textarea name="notes" rows="2" class="form-control form-control-sm">{{ old('notes') }}</textarea>
                        </div>
                        <div class="alert alert-info py-2 small mb-3">
                            <i class="bi bi-info-circle"></i> Kalori terbakar dihitung otomatis berdasarkan jenis & durasi olahraga.
                        </div>
                        <button type="submit" class="btn btn-warning w-100 btn-sm fw-semibold">Catat Latihan</button>
                    </form>
                </div>
            </div>

            <!-- Calorie Reference -->
            <div class="card border-0 shadow-sm rounded-4 mt-3">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h6 class="fw-semibold mb-0 small">Referensi Kalori/Menit</h6>
                </div>
                <div class="card-body pt-2 pb-3">
                    @foreach(\App\Models\WorkoutSession::caloriesPerMinute() as $type => $cpm)
                    <div class="d-flex justify-content-between small border-bottom py-1">
                        <span>{{ \App\Models\WorkoutSession::workoutTypes()[$type] ?? ucfirst($type) }}</span>
                        <span class="fw-medium text-warning">{{ $cpm }} kcal/min</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- History Table -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h6 class="fw-semibold mb-0">Riwayat Latihan</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-3">Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Durasi</th>
                                    <th>Kalori Terbakar</th>
                                    <th>Catatan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sessions as $s)
                                <tr>
                                    <td class="px-3 fw-medium">{{ \Carbon\Carbon::parse($s->session_date)->format('d M Y') }}</td>
                                    <td>{{ \App\Models\WorkoutSession::workoutTypes()[$s->workout_type] ?? ucfirst($s->workout_type) }}</td>
                                    <td>{{ $s->duration_minutes }} min</td>
                                    <td class="text-danger fw-medium">{{ number_format($s->calories_burned) }} kcal</td>
                                    <td class="text-muted">{{ Str::limit($s->notes, 30) }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('workout-planner.destroy', $s->id) }}" onsubmit="return confirm('Hapus sesi ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger py-0 px-2"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada sesi latihan</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($sessions->hasPages())
                    <div class="px-3 py-2">{{ $sessions->links('pagination::bootstrap-5') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
