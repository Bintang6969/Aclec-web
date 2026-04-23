{{-- ═══ WORKOUT PLANNER SECTION ═══ --}}
<div class="grid-65">

  {{-- Left: Workout Selection + Guide --}}
  <div>
    <div class="card" style="margin-bottom:1.2rem">
      <div class="card-header">
        <div class="card-title">Pilih Jenis Workout</div>
        <span class="badge badge-brown">Pilih satu</span>
      </div>

      <div class="workout-grid" id="workout-grid">
        <div class="workout-item selected" onclick="selectWorkout(this,'Lari',8,'🏃','cardio')">
          <div class="workout-emoji">🏃</div>
          <div class="workout-name">Lari</div>
          <div class="workout-cal">~8 kal/menit</div>
        </div>
        <div class="workout-item" onclick="selectWorkout(this,'Bersepeda',6,'🚴','cycling')">
          <div class="workout-emoji">🚴</div>
          <div class="workout-name">Bersepeda</div>
          <div class="workout-cal">~6 kal/menit</div>
        </div>
        <div class="workout-item" onclick="selectWorkout(this,'Berenang',9,'🏊','swimming')">
          <div class="workout-emoji">🏊</div>
          <div class="workout-name">Berenang</div>
          <div class="workout-cal">~9 kal/menit</div>
        </div>
        <div class="workout-item" onclick="selectWorkout(this,'Angkat Beban',5,'🏋️','strength')">
          <div class="workout-emoji">🏋️</div>
          <div class="workout-name">Angkat Beban</div>
          <div class="workout-cal">~5 kal/menit</div>
        </div>
        <div class="workout-item" onclick="selectWorkout(this,'Yoga',3,'🧘','yoga')">
          <div class="workout-emoji">🧘</div>
          <div class="workout-name">Yoga</div>
          <div class="workout-cal">~3 kal/menit</div>
        </div>
        <div class="workout-item" onclick="selectWorkout(this,'HIIT',10,'⚡','hiit')">
          <div class="workout-emoji">⚡</div>
          <div class="workout-name">HIIT</div>
          <div class="workout-cal">~10 kal/menit</div>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">⏱ Durasi (menit)</label>
        <input type="range" class="form-input" min="5" max="120" step="5" value="30"
          id="workout-duration" oninput="updateDuration(this.value)"
          style="padding:0;border:none;background:transparent;cursor:pointer">
        <div style="display:flex;justify-content:space-between;font-size:0.8rem;color:var(--muted)">
          <span>5 mnt</span>
          <strong id="duration-label" style="color:var(--brown-dark)">30 menit</strong>
          <span>120 mnt</span>
        </div>
      </div>

      <div style="background:var(--cream);border-radius:12px;padding:0.9rem;display:flex;align-items:center;justify-content:space-between">
        <span style="font-size:0.85rem;color:var(--muted)">Estimasi Kalori Terbakar:</span>
        <span id="est-cal" style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--red)">240 kal</span>
      </div>
    </div>

    {{-- Workout Guide --}}
    <div class="card">
      <div class="card-title" style="margin-bottom:0.8rem">📋 Panduan Workout</div>
      <div id="workout-guide" style="font-size:0.85rem;line-height:1.7;color:var(--text)">
        <strong>🏃 Lari:</strong><br>
        1. Pemanasan 5 menit jalan cepat<br>
        2. Lari 65–75% denyut jantung maks<br>
        3. Postur tegak, pandangan depan<br>
        4. Pendinginan 5 menit<br>
        <em style="color:var(--muted)">💡 Minum air tiap 15 menit</em>
      </div>
    </div>
  </div>

  {{-- Right: Timer + Result + History --}}
  <div>
    <div class="card" style="margin-bottom:1.2rem">
      <div class="card-title" style="margin-bottom:1rem">⏱ Timer Workout</div>
      <div class="timer-display">
        <div class="timer-time" id="timer-display">30:00</div>
        <div class="timer-label" id="timer-workout-name">🏃 LARI</div>
        <div class="timer-controls">
          <button class="timer-btn" onclick="startTimer()">▶ Mulai</button>
          <button class="timer-btn" onclick="pauseTimer()">⏸ Pause</button>
          <button class="timer-btn" onclick="resetTimer()">↺ Reset</button>
        </div>
      </div>
      <button class="btn btn-primary" style="width:100%" onclick="finishWorkout()">
        ✅ Selesai &amp; Kirim ke Tracker
      </button>
    </div>

    {{-- Workout Result (hidden until finish) --}}
    <div class="card" id="workout-result" style="display:none;margin-bottom:1.2rem">
      <div class="card-title" style="margin-bottom:0.8rem;color:var(--red)">🎉 Workout Selesai!</div>
      <div style="text-align:center;padding:0.8rem;background:var(--cream);border-radius:12px">
        <div style="font-size:2rem;margin-bottom:0.3rem">🔥</div>
        <div style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:800;color:var(--red)" id="final-cal">240</div>
        <div style="font-size:0.75rem;color:var(--muted)">kalori terbakar</div>
        <div style="font-size:0.78rem;color:#27ae60;margin-top:0.4rem;font-weight:600">✓ Data dikirim ke Life Tracker</div>
      </div>
    </div>

    {{-- Workout History --}}
    <div class="card">
      <div class="card-title" style="margin-bottom:0.8rem">Riwayat Workout Hari Ini</div>
      <table class="table">
        <thead>
          <tr><th>Workout</th><th>Durasi</th><th>Kal</th></tr>
        </thead>
        <tbody>
          @forelse($todayWorkouts as $session)
            <tr>
              <td>{{ $session->workout_type }}</td>
              <td>{{ $session->duration_minutes }} mnt</td>
              <td style="color:var(--red);font-weight:600">{{ $session->calories_burned }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="3" style="text-align:center;color:var(--muted);font-style:italic">
                Belum ada workout hari ini
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
