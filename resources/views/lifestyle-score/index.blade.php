@extends('layouts.app')
@section('title', 'Lifestyle Score')

@section('content')
<div class="container-fluid py-4">
    <h4 class="fw-bold mb-1">Lifestyle Score</h4>
    <p class="text-muted small mb-4">Nilai kesehatanmu hari ini berdasarkan aktivitas harian</p>

    <div class="row g-4">
        <!-- Today's Score -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center">
                <div class="card-body py-5">
                    @if($todayScore)
                        @php
                            $scoreClass = $todayScore->score >= 70 ? 'success' : ($todayScore->score < 40 ? 'danger' : 'warning');
                            $emoji = $todayScore->reward_type == 'reward' ? '🏆' : ($todayScore->reward_type == 'punishment' ? '⚠️' : '💪');
                        @endphp
                        <div style="font-size:4rem;" class="text-{{ $scoreClass }} fw-bold lh-1">{{ $todayScore->score }}</div>
                        <div class="text-muted mt-1 mb-3">/ 100</div>
                        <span class="badge bg-{{ $scoreClass }} fs-6 px-3 py-2">{{ $emoji }} {{ $todayScore->reward_message }}</span>
                        <div class="mt-3 text-muted small">{{ \Carbon\Carbon::parse($todayScore->score_date)->translatedFormat('d F Y') }}</div>
                    @else
                        <div class="text-muted mb-3">
                            <i class="bi bi-bar-chart-fill" style="font-size:3rem; opacity:.25;"></i>
                        </div>
                        <p class="text-muted">Belum ada score hari ini.<br>Pastikan kamu sudah mengisi Life Tracker!</p>
                        <a href="{{ route('lifestyle-score.index') }}" class="btn btn-success btn-sm px-4">Hitung Sekarang</a>
                    @endif
                </div>
            </div>

            <!-- Score Breakdown Info -->
            <div class="card border-0 shadow-sm rounded-4 mt-3">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h6 class="fw-semibold mb-0 small">Komponen Penilaian</h6>
                </div>
                <div class="card-body pt-2 pb-3 small">
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <span><i class="bi bi-droplet text-info"></i> Air Minum</span>
                        <span class="text-muted">maks. 25 poin</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <span><i class="bi bi-moon text-warning"></i> Tidur</span>
                        <span class="text-muted">maks. 25 poin</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <span><i class="bi bi-lightning text-success"></i> Olahraga</span>
                        <span class="text-muted">maks. 25 poin</span>
                    </div>
                    <div class="d-flex justify-content-between py-1">
                        <span><i class="bi bi-fire text-danger"></i> Kalori vs TDEE</span>
                        <span class="text-muted">maks. 25 poin</span>
                    </div>
                    <hr class="my-2">
                    <div class="text-muted" style="font-size:.75rem;">
                        <span class="badge bg-success me-1">≥70</span> Reward &nbsp;
                        <span class="badge bg-warning me-1">40-69</span> Netral &nbsp;
                        <span class="badge bg-danger">≤39</span> Punishment
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Leaderboard -->
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h6 class="fw-semibold mb-0">🏆 Leaderboard Hari Ini</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-3 text-center" style="width:60px;">#</th>
                                    <th>Pengguna</th>
                                    <th>Score</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topScores as $i => $ls)
                                <tr class="{{ $ls->user_id == auth()->id() ? 'table-success' : '' }}">
                                    <td class="px-3 text-center fw-bold">
                                        @if($i==0) 🥇 @elseif($i==1) 🥈 @elseif($i==2) 🥉 @else {{ $i+1 }} @endif
                                    </td>
                                    <td>{{ $ls->user->name }}</td>
                                    <td class="fw-bold {{ $ls->score >= 70 ? 'text-success' : ($ls->score < 40 ? 'text-danger' : 'text-warning') }}">
                                        {{ $ls->score }}
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $ls->reward_type=='reward' ? 'success' : ($ls->reward_type=='punishment' ? 'danger' : 'secondary') }}">
                                            {{ ucfirst($ls->reward_type) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data leaderboard</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 30-day History -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h6 class="fw-semibold mb-0">Histori 30 Hari</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-3">Tanggal</th>
                                    <th>Score</th>
                                    <th>Status</th>
                                    <th>Pesan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $h)
                                <tr>
                                    <td class="px-3">{{ \Carbon\Carbon::parse($h->score_date)->format('d M Y') }}</td>
                                    <td class="fw-bold {{ $h->score >= 70 ? 'text-success' : ($h->score < 40 ? 'text-danger' : 'text-warning') }}">
                                        {{ $h->score }}
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $h->reward_type=='reward' ? 'success' : ($h->reward_type=='punishment' ? 'danger' : 'secondary') }}">
                                            {{ ucfirst($h->reward_type) }}
                                        </span>
                                    </td>
                                    <td class="text-muted">{{ $h->reward_message }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Belum ada histori</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
