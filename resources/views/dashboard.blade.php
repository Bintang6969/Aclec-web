@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">

    <!-- Greeting -->
    <div class="mb-4">
        <h4 class="fw-bold mb-0">Halo, {{ Auth::user()->name }}! 👋</h4>
        <p class="text-muted small">TDEE kamu: <strong>{{ number_format(Auth::user()->tdee) }} kcal/hari</strong> &bull; Target: <span class="badge bg-success">{{ ucfirst(Auth::user()->goal) }}</span></p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        @php
            $water   = $todayEntry?->water_ml ?? 0;
            $sleep   = $todayEntry?->sleep_hours ?? 0;
            $calIn   = $todayEntry?->calories_in ?? 0;
            $calOut  = $todayEntry?->calories_out ?? 0;
            $exMin   = $todayEntry?->exercise_minutes ?? 0;
            $tdee    = Auth::user()->tdee;
        @endphp
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center py-3">
                    <div class="text-primary fs-4 mb-1"><i class="bi bi-fire"></i></div>
                    <div class="fw-bold fs-5">{{ number_format($calIn) }}</div>
                    <div class="text-muted small">Kalori Masuk</div>
                    <div class="small text-danger">-{{ number_format($calOut) }} kcal keluar</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center py-3">
                    <div class="text-info fs-4 mb-1"><i class="bi bi-droplet-fill"></i></div>
                    <div class="fw-bold fs-5">{{ number_format($water) }}</div>
                    <div class="text-muted small">Air (ml)</div>
                    <div class="small {{ $water >= 2000 ? 'text-success' : 'text-warning' }}">
                        Target 2000 ml {{ $water >= 2000 ? '✓' : '' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center py-3">
                    <div class="text-warning fs-4 mb-1"><i class="bi bi-moon-stars-fill"></i></div>
                    <div class="fw-bold fs-5">{{ $sleep }}h</div>
                    <div class="text-muted small">Durasi Tidur</div>
                    <div class="small {{ ($sleep >= 7 && $sleep <= 9) ? 'text-success' : 'text-warning' }}">
                        Ideal 7-9 jam {{ ($sleep >= 7 && $sleep <= 9) ? '✓' : '' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center py-3">
                    <div class="text-success fs-4 mb-1"><i class="bi bi-lightning-charge-fill"></i></div>
                    <div class="fw-bold fs-5">{{ $exMin }} min</div>
                    <div class="text-muted small">Olahraga</div>
                    <div class="small {{ $exMin >= 30 ? 'text-success' : 'text-muted' }}">
                        Target 30 min {{ $exMin >= 30 ? '✓' : '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Weekly Calorie Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h6 class="fw-semibold mb-0">Kalori 7 Hari Terakhir</h6>
                </div>
                <div class="card-body">
                    <canvas id="calChart" height="90"></canvas>
                </div>
            </div>
        </div>

        <!-- Lifestyle Score + Quick Links -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body text-center py-4">
                    @if($latestScore)
                        <div class="display-5 fw-bold {{ $latestScore->score >= 70 ? 'text-success' : ($latestScore->score < 40 ? 'text-danger' : 'text-warning') }}">
                            {{ $latestScore->score }}
                        </div>
                        <div class="text-muted small mb-2">Lifestyle Score Hari Ini</div>
                        <span class="badge {{ $latestScore->reward_type=='reward' ? 'bg-success' : ($latestScore->reward_type=='punishment' ? 'bg-danger' : 'bg-secondary') }}">
                            {{ $latestScore->reward_message ?? 'Pertahankan!' }}
                        </span>
                    @else
                        <div class="text-muted py-2">
                            <i class="bi bi-bar-chart fs-2 d-block mb-2 opacity-25"></i>
                            Belum ada score hari ini
                        </div>
                        <a href="{{ route('lifestyle-score.index') }}" class="btn btn-sm btn-outline-success">Hitung Score</a>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h6 class="fw-semibold mb-0">Akses Cepat</h6>
                </div>
                <div class="card-body pt-2 pb-3">
                    @foreach([
                        [route('life-tracker.index'),'bi-journal-check','success','Life Tracker'],
                        [route('workout-planner.index'),'bi-lightning-charge','warning','Workout'],
                        [route('consultation.index'),'bi-chat-dots','secondary','FitBot AI'],
                        [route('community.index'),'bi-people','primary','Komunitas'],
                    ] as [$url,$icon,$color,$label])
                    <a href="{{ $url }}" class="d-flex align-items-center gap-2 py-2 text-decoration-none text-dark border-bottom">
                        <i class="bi {{ $icon }} text-{{ $color }}"></i>
                        <span class="small">{{ $label }}</span>
                        <i class="bi bi-chevron-right ms-auto text-muted" style="font-size:.7rem;"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
const labels = @json($weeklyCalories->pluck('date'));
const calIn  = @json($weeklyCalories->pluck('total_in'));
const calOut = @json($weeklyCalories->pluck('total_out'));
new Chart(document.getElementById('calChart'), {
    type: 'bar',
    data: {
        labels,
        datasets: [
            { label: 'Kalori Masuk', data: calIn, backgroundColor: 'rgba(46,204,113,.7)', borderRadius: 6 },
            { label: 'Kalori Keluar', data: calOut, backgroundColor: 'rgba(231,76,60,.55)', borderRadius: 6 },
        ]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true } } }
});
</script>
@endpush
