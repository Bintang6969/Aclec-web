{{-- ═══ LIFE TRACKER SECTION ═══ --}}
<div class="grid-65">

  {{-- Input Form --}}
  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title">Catat Aktivitas Harian</div>
        <div class="card-sub">Input data kesehatan Anda hari ini</div>
      </div>
      <span class="badge badge-brown" id="tracker-date-badge">—</span>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">📅 Tanggal</label>
        <input type="date" class="form-input" id="tracker-date">
      </div>
      <div class="form-group">
        <label class="form-label">⏰ Waktu Input</label>
        <input type="time" class="form-input" id="tracker-time">
      </div>
    </div>

    <div class="form-row-3">
      <div class="form-group">
        <label class="form-label">💧 Air Minum (ml)</label>
        <input type="number" class="form-input" placeholder="1800" id="t-air">
      </div>
      <div class="form-group">
        <label class="form-label">🔥 Kalori Masuk</label>
        <input type="number" class="form-input" placeholder="2000" id="t-kal-in">
      </div>
      <div class="form-group">
        <label class="form-label">💪 Kalori Keluar</label>
        <input type="number" class="form-input" placeholder="—" id="t-kal-out" readonly
          style="background:var(--cream);color:var(--muted)" title="Otomatis dari Workout Planner">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">🏃 Olahraga (menit)</label>
        <input type="number" class="form-input" placeholder="45" id="t-olahraga">
      </div>
      <div class="form-group">
        <label class="form-label">😴 Waktu Tidur (jam)</label>
        <input type="number" class="form-input" placeholder="7.5" id="t-tidur" step="0.5">
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">📝 Catatan (opsional)</label>
      <input type="text" class="form-input" placeholder="Tambahkan catatan..." id="t-note">
    </div>

    <div style="display:flex;gap:0.7rem">
      <button class="btn btn-primary" onclick="saveTracker()">💾 Simpan Data</button>
      <button class="btn btn-outline" onclick="resetTracker()">🔄 Reset</button>
    </div>

    <div id="tracker-success" style="display:none;margin-top:0.8rem;padding:0.7rem;background:rgba(39,174,96,0.1);border:1px solid rgba(39,174,96,0.3);border-radius:10px;font-size:0.82rem;color:#27ae60;font-weight:600">
      ✅ Data berhasil disimpan!
    </div>
  </div>

  {{-- Summary --}}
  <div>
    <div class="card" style="margin-bottom:1rem">
      <div class="card-title" style="margin-bottom:1rem">Ringkasan Hari Ini</div>
      <div id="summary-kalori-net" style="text-align:center;padding:1rem;background:var(--cream);border-radius:12px;margin-bottom:0.8rem">
        <div style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:800;color:var(--brown-dark)">0</div>
        <div style="font-size:0.75rem;color:var(--muted)">Kalori Net (Masuk - Keluar)</div>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;font-size:0.8rem">
        <div style="padding:0.6rem;background:var(--cream);border-radius:10px;text-align:center">
          <div style="font-weight:700;color:var(--brown-dark)" id="s-air">— ml</div>
          <div style="color:var(--muted)">Air</div>
        </div>
        <div style="padding:0.6rem;background:var(--cream);border-radius:10px;text-align:center">
          <div style="font-weight:700;color:var(--brown-dark)" id="s-tidur">— jam</div>
          <div style="color:var(--muted)">Tidur</div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-title" style="margin-bottom:0.8rem">Status Target</div>
      <div id="status-list" style="display:flex;flex-direction:column;gap:0.5rem;font-size:0.82rem">
        <div>💧 Air: <strong style="color:var(--muted)">Isi form dahulu</strong></div>
        <div>🔥 Kalori: <strong style="color:var(--muted)">Isi form dahulu</strong></div>
        <div>🏃 Olahraga: <strong style="color:var(--muted)">Isi form dahulu</strong></div>
        <div>😴 Tidur: <strong style="color:var(--muted)">Isi form dahulu</strong></div>
      </div>
    </div>
  </div>
</div>

{{-- Weekly Bar Chart --}}
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Grafik Kalori Terbakar — 7 Hari Terakhir</div>
      <div class="card-sub">Kalori keluar dari olahraga</div>
    </div>
    <span class="badge badge-red">Mingguan</span>
  </div>
  <div style="display:flex;align-items:flex-end;gap:8px;height:120px;margin-top:0.5rem">
    @php
      $bars = [
        ['Sen', 65], ['Sel', 80], ['Rab', 55], ['Kam', 90],
        ['Jum', 70], ['Sab', 85], ['Min', 75],
      ];
    @endphp
    @foreach($bars as [$label, $pct])
      <div class="bar-col">
        <div class="bar" style="height:{{ $pct }}%;background:linear-gradient(to top,#8B6343,#C8A882)"></div>
        <div class="bar-lbl">{{ $label }}</div>
      </div>
    @endforeach
  </div>
  <div style="display:flex;gap:1.5rem;margin-top:0.8rem;font-size:0.75rem;color:var(--muted)">
    <span>📊 Rata-rata: <strong style="color:var(--brown-dark)">487 kal/hari</strong></span>
    <span>📈 Tertinggi: <strong style="color:var(--red)">Kamis — 580 kal</strong></span>
    <span>📉 Terendah: <strong style="color:var(--brown-mid)">Rabu — 380 kal</strong></span>
  </div>
</div>
