{{-- ═══ DASHBOARD OVERVIEW SECTION ═══ --}}
@php
  $water   = $todayEntry?->water_ml         ?? 0;
  $sleep   = $todayEntry?->sleep_hours      ?? 0;
  $calIn   = $todayEntry?->calories_in      ?? 0;
  $calOut  = $todayEntry?->calories_out     ?? 0;
  $exMin   = $todayEntry?->exercise_minutes ?? 0;
  $tdee    = Auth::user()->tdee             ?? 2000;
  $waterPct = min(100, $tdee > 0 ? $water / 2000 * 100 : 0);
  $calPct   = $tdee > 0 ? min(100, $calIn / $tdee * 100) : 0;
  $exPct    = min(100, $exMin / 60 * 100);
  $sleepPct = min(100, $sleep / 9 * 100);
@endphp

{{-- Stat Cards --}}
<div class="stat-row">
  <div class="stat-card">
    <div class="stat-icon">🔥</div>
    <div class="stat-val">{{ number_format($calIn) }}</div>
    <div class="stat-lbl">Kalori Masuk (kcal)</div>
    @if($calOut > 0)
      <span class="stat-change down">-{{ number_format($calOut) }} keluar</span>
    @else
      <span class="stat-change" style="color:var(--muted)">Belum dicatat</span>
    @endif
  </div>

  <div class="stat-card">
    <div class="stat-icon">💧</div>
    <div class="stat-val">{{ number_format($water) }}</div>
    <div class="stat-lbl">Air Minum (ml)</div>
    <span class="stat-change {{ $water >= 2000 ? 'up' : 'down' }}">
      {{ $water >= 2000 ? '✓ Target terpenuhi' : 'Target 2.000 ml' }}
    </span>
  </div>

  <div class="stat-card">
    <div class="stat-icon">😴</div>
    <div class="stat-val">{{ $sleep }}<span style="font-size:1rem;font-weight:500">h</span></div>
    <div class="stat-lbl">Durasi Tidur</div>
    <span class="stat-change {{ ($sleep >= 7 && $sleep <= 9) ? 'up' : 'down' }}">
      {{ ($sleep >= 7 && $sleep <= 9) ? '✓ Ideal (7–9 jam)' : 'Ideal 7–9 jam' }}
    </span>
  </div>

  <div class="stat-card">
    <div class="stat-icon">🏃</div>
    <div class="stat-val">{{ $exMin }}<span style="font-size:1rem;font-weight:500"> mnt</span></div>
    <div class="stat-lbl">Durasi Olahraga</div>
    <span class="stat-change {{ $exMin >= 30 ? 'up' : 'down' }}">
      {{ $exMin >= 30 ? '✓ Target terpenuhi' : 'Target 30 menit' }}
    </span>
  </div>
</div>

{{-- Weekly Chart + Lifestyle Score --}}
<div class="grid-2" style="grid-template-columns:1.8fr 1fr">

  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title">Kalori 7 Hari Terakhir</div>
        <div class="card-sub">Kalori masuk vs kalori keluar</div>
      </div>
      <span class="badge badge-red">Mingguan</span>
    </div>
    <canvas id="calChart" height="100"></canvas>
  </div>

  <div class="card" style="display:flex;flex-direction:column;justify-content:space-between">
    <div class="card-header" style="margin-bottom:0.5rem">
      <div class="card-title">⭐ Lifestyle Score</div>
      <span class="badge badge-brown">Hari Ini</span>
    </div>

    @if($latestScore)
      @php
        $score       = $latestScore->score;
        $statusClass = $score >= 70 ? 'score-good' : ($score < 40 ? 'score-bad' : 'score-neutral');
        $statusText  = $score >= 70 ? '🏆 SEHAT' : ($score < 40 ? '⚠ KURANG' : '~ CUKUP');
        $rewardClass = $latestScore->reward_type === 'reward' ? 'good' : 'bad';
        $rewardEmoji = $latestScore->reward_type === 'reward' ? '🎉' : '⚠️';
      @endphp
      <div style="text-align:center;padding:1rem 0">
        <div style="font-family:'Playfair Display',serif;font-size:3.5rem;font-weight:800;color:var(--brown-dark);line-height:1">
          {{ $score }}
        </div>
        <div style="font-size:0.78rem;color:var(--muted);margin-bottom:0.5rem">/ 100 poin</div>
        <span class="score-status {{ $statusClass }}">{{ $statusText }}</span>
      </div>
      @if($latestScore->reward_message)
        <div class="reward-panel {{ $rewardClass }}" style="margin-bottom:0">
          <div class="reward-emoji">{{ $rewardEmoji }}</div>
          <div class="reward-desc">{{ $latestScore->reward_message }}</div>
        </div>
      @endif
    @else
      <div style="text-align:center;padding:2rem 0;color:var(--muted)">
        <div style="font-size:2.5rem;margin-bottom:0.5rem;opacity:0.3">⭐</div>
        <div style="font-size:0.85rem">Belum ada skor hari ini</div>
      </div>
      <button onclick="showPage('lifestyle', document.querySelectorAll('.nav-item')[3])" class="btn btn-primary" style="width:100%;justify-content:center">
        Hitung Skor Sekarang
      </button>
    @endif
  </div>
</div>

{{-- Daily Progress + Quick Actions --}}
<div class="grid-2">
  <div class="card">
    <div class="card-header">
      <div class="card-title">Target Harian</div>
      <span class="badge badge-green">Hari Ini</span>
    </div>

    <div class="progress-item">
      <div class="progress-top">
        <span class="progress-name">💧 Air Minum</span>
        <span class="progress-val">{{ number_format($water) }} / 2.000 ml</span>
      </div>
      <div class="progress-bar">
        <div class="progress-fill" style="width:{{ $waterPct }}%;background:#3498db"></div>
      </div>
    </div>

    <div class="progress-item">
      <div class="progress-top">
        <span class="progress-name">🔥 Kalori Masuk</span>
        <span class="progress-val">{{ number_format($calIn) }} / {{ number_format($tdee) }} kal</span>
      </div>
      <div class="progress-bar">
        <div class="progress-fill" style="width:{{ $calPct }}%;background:var(--red)"></div>
      </div>
    </div>

    <div class="progress-item">
      <div class="progress-top">
        <span class="progress-name">🏃 Olahraga</span>
        <span class="progress-val">{{ $exMin }} / 60 menit</span>
      </div>
      <div class="progress-bar">
        <div class="progress-fill" style="width:{{ $exPct }}%;background:var(--brown-mid)"></div>
      </div>
    </div>

    <div class="progress-item">
      <div class="progress-top">
        <span class="progress-name">😴 Tidur</span>
        <span class="progress-val">{{ $sleep }} / 9 jam</span>
      </div>
      <div class="progress-bar">
        <div class="progress-fill" style="width:{{ $sleepPct }}%;background:var(--brown-light)"></div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <div class="card-title">Aksi Cepat</div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.7rem">
      <button onclick="showPage('tracker', document.querySelectorAll('.nav-item')[1])" class="btn btn-primary">📊 Catat Hari Ini</button>
      <button onclick="showPage('workout', document.querySelectorAll('.nav-item')[2])" class="btn btn-brown">🏋️ Mulai Workout</button>
      <button onclick="showPage('lifestyle', document.querySelectorAll('.nav-item')[3])" class="btn btn-outline">⭐ Cek Skor</button>
      <button onclick="showPage('consultation', document.querySelectorAll('.nav-item')[5])" class="btn btn-outline">💬 Konsultasi AI</button>
    </div>
    <div class="divider"></div>
    <div style="font-size:0.78rem;color:var(--muted);text-align:center">
      💡 <em>Tip: Minum segelas air sebelum makan besar untuk mengontrol porsi makan</em>
    </div>
  </div>
</div>
