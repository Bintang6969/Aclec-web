{{-- ═══ LIFESTYLE SCORE SECTION ═══ --}}
@php
  $todayScore = $latestScore?->score ?? null;
  $rewardType = $latestScore?->reward_type ?? null;
  $rewardMsg  = $latestScore?->reward_message ?? null;

  // Score ring SVG parameters
  $circumference = 2 * M_PI * 18; // r=18 → ~113.1
  if ($todayScore !== null) {
    $dashArray  = round($todayScore / 100 * $circumference, 1) . ' ' . round($circumference - ($todayScore / 100 * $circumference), 1);
  } else {
    $dashArray  = '0 ' . round($circumference, 1);
  }
@endphp

<div class="grid-3">

  {{-- Score Ring --}}
  <div class="card" style="text-align:center">
    <div class="card-title" style="margin-bottom:0.5rem">Skor Kamu Hari Ini</div>
    <div class="score-ring-wrap">
      <svg width="160" height="160" viewBox="0 0 42 42" class="score-ring-svg">
        <circle cx="21" cy="21" r="18" fill="none" stroke="#f0e8dc" stroke-width="4"/>
        <circle cx="21" cy="21" r="18" fill="none" stroke="#C0392B" stroke-width="4"
          stroke-dasharray="{{ $dashArray }}" stroke-dashoffset="7"
          stroke-linecap="round" style="transition:stroke-dasharray 1s ease"/>
        <text x="21" y="19" text-anchor="middle" font-size="8" fill="#3E2011" font-weight="bold">
          {{ $todayScore ?? '—' }}
        </text>
        <text x="21" y="25" text-anchor="middle" font-size="4" fill="#7D6555">/ 100</text>
      </svg>

      @if($todayScore !== null)
        @if($todayScore >= 70)
          <div class="score-status score-good">🏆 SEHAT</div>
        @elseif($todayScore >= 40)
          <div class="score-status score-neutral">~ CUKUP</div>
        @else
          <div class="score-status score-bad">⚠ KURANG</div>
        @endif
      @else
        <div class="score-status score-neutral">Belum dihitung</div>
      @endif
    </div>

    @if($todayScore !== null)
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;margin-top:0.8rem;font-size:0.78rem">
        <div style="padding:0.5rem;background:var(--cream);border-radius:8px">
          <div style="font-weight:700">💧 Hidrasi</div>
          <div style="color:var(--muted)">25 poin</div>
        </div>
        <div style="padding:0.5rem;background:var(--cream);border-radius:8px">
          <div style="font-weight:700">🏃 Olahraga</div>
          <div style="color:var(--muted)">25 poin</div>
        </div>
        <div style="padding:0.5rem;background:var(--cream);border-radius:8px">
          <div style="font-weight:700">😴 Tidur</div>
          <div style="color:var(--muted)">25 poin</div>
        </div>
        <div style="padding:0.5rem;background:var(--cream);border-radius:8px">
          <div style="font-weight:700">🥗 Nutrisi</div>
          <div style="color:var(--muted)">25 poin</div>
        </div>
      </div>
    @else
      <div style="margin-top:1rem">
        <button class="btn btn-primary" style="width:100%" onclick="showPage('tracker', document.querySelectorAll('.nav-item')[1])">
          📊 Isi Life Tracker Dulu
        </button>
      </div>
    @endif
  </div>

  {{-- Reward/Penalty + 7-day chart --}}
  <div>
    @if($rewardMsg)
      <div class="reward-panel {{ $rewardType === 'reward' ? 'good' : 'bad' }}">
        <div class="reward-emoji">{{ $rewardType === 'reward' ? '🎉' : '⚠️' }}</div>
        <div class="reward-title" style="color:{{ $rewardType === 'reward' ? '#27ae60' : 'var(--red)' }}">
          {{ $rewardType === 'reward' ? 'Selamat! Kamu Mendapat Reward!' : 'Perlu Peningkatan!' }}
        </div>
        <div class="reward-desc">{{ $rewardMsg }}</div>
      </div>
    @else
      <div class="reward-panel" style="background:var(--cream);border:1px solid var(--border);margin-bottom:1rem">
        <div class="reward-emoji">💪</div>
        <div class="reward-title" style="color:var(--brown-dark)">Catat Aktivitas Hari Ini</div>
        <div class="reward-desc">Isi Life Tracker untuk mendapatkan skor dan reward harianmu.</div>
      </div>
    @endif

    <div class="card">
      <div class="card-title" style="margin-bottom:0.8rem">Skor 7 Hari Terakhir</div>
      {{-- Demo bar chart --}}
      <div style="display:flex;align-items:flex-end;gap:6px;height:70px">
        @foreach([['Sen',72],['Sel',80],['Rab',65],['Kam',78],['Jum',82],['Sab',85],['Min',87]] as [$day, $val])
          <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
            <div style="flex:{{ $val }};width:100%;border-radius:4px 4px 0 0;background:var(--brown-mid)" title="{{ $val }}"></div>
            <div style="font-size:0.6rem;color:var(--muted)">{{ $day }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Leaderboard --}}
  <div class="card">
    <div class="card-header">
      <div class="card-title">🏆 Leaderboard</div>
      <span class="badge badge-red">Top 5</span>
    </div>
    <table class="table">
      <thead>
        <tr><th>#</th><th>Nama</th><th>Skor</th></tr>
      </thead>
      <tbody>
        <tr>
          <td><span class="rank-badge rank-1">1</span></td>
          <td><strong>Rina P.</strong></td>
          <td><strong style="color:var(--red)">96</strong></td>
        </tr>
        <tr>
          <td><span class="rank-badge rank-2">2</span></td>
          <td><strong>Dika S.</strong></td>
          <td><strong style="color:var(--red)">93</strong></td>
        </tr>
        <tr>
          <td><span class="rank-badge rank-3">3</span></td>
          <td><strong>Syafa N.</strong></td>
          <td><strong style="color:var(--red)">91</strong></td>
        </tr>
        <tr>
          <td><span class="rank-badge" style="background:var(--cream);color:var(--muted)">4</span></td>
          <td>Maya R.</td>
          <td>89</td>
        </tr>
        <tr>
          <td><span class="rank-badge" style="background:rgba(192,57,43,0.15);color:var(--red)">5</span></td>
          <td><strong>{{ strtok(Auth::user()->name, ' ') }} 👤</strong></td>
          <td><strong style="color:var(--red)">{{ $todayScore ?? '—' }}</strong></td>
        </tr>
      </tbody>
    </table>
    <div style="font-size:0.75rem;color:var(--muted);text-align:center;margin-top:0.6rem">
      Tingkatkan skor harianmu untuk naik peringkat! 💪
    </div>
  </div>
</div>

{{-- Score Simulator --}}
<div class="card">
  <div class="card-header">
    <div class="card-title">Simulasi Skor</div>
    <div class="card-sub">Geser slider untuk melihat dampak pada skor</div>
  </div>
  <div class="form-row-3">
    <div class="form-group">
      <label class="form-label">💧 Air (ml)</label>
      <input type="range" class="form-input" min="0" max="3000" step="100" value="1800"
        id="sim-air" oninput="calcScore()" style="padding:0;border:none;background:transparent;cursor:pointer">
      <div style="font-size:0.78rem;color:var(--muted);text-align:center" id="sim-air-label">1800 ml</div>
    </div>
    <div class="form-group">
      <label class="form-label">🏃 Olahraga (menit)</label>
      <input type="range" class="form-input" min="0" max="120" step="5" value="45"
        id="sim-ex" oninput="calcScore()" style="padding:0;border:none;background:transparent;cursor:pointer">
      <div style="font-size:0.78rem;color:var(--muted);text-align:center" id="sim-ex-label">45 menit</div>
    </div>
    <div class="form-group">
      <label class="form-label">😴 Tidur (jam)</label>
      <input type="range" class="form-input" min="0" max="12" step="0.5" value="7.5"
        id="sim-sleep" oninput="calcScore()" style="padding:0;border:none;background:transparent;cursor:pointer">
      <div style="font-size:0.78rem;color:var(--muted);text-align:center" id="sim-sleep-label">7.5 jam</div>
    </div>
  </div>
  <div style="padding:1rem;background:var(--cream);border-radius:12px;display:flex;align-items:center;justify-content:space-between">
    <div style="font-size:0.85rem;color:var(--muted)">Perkiraan Skor:</div>
    <div id="sim-score" style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:800;color:var(--red)">82</div>
    <div id="sim-status" class="score-status score-good">✓ SEHAT</div>
  </div>
</div>
