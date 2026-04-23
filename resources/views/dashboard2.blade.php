@extends('layouts.app2')

@section('title', 'HealthyCare')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . Auth::user()->name . '! 👋')

{{-- ═══ SIDEBAR NAV — SPA mode (JS showPage) ═══ --}}
@section('sidebar-nav')
  <div class="nav-item active" onclick="showPage('overview', this)">
    <span class="nav-icon">🏠</span> Dashboard
  </div>
  <div class="nav-item" onclick="showPage('tracker', this)">
    <span class="nav-icon">📊</span> Life Tracker
  </div>
  <div class="nav-item" onclick="showPage('workout', this)">
    <span class="nav-icon">🏋️</span> Workout Planner
  </div>
  <div class="nav-item" onclick="showPage('lifestyle', this)">
    <span class="nav-icon">⭐</span> Lifestyle Score
  </div>
  <div class="nav-item" onclick="showPage('article', this)">
    <span class="nav-icon">📰</span> Artikel & Komunitas
  </div>
  <div class="nav-item" onclick="showPage('consultation', this)">
    <span class="nav-icon">💬</span> Konsultasi AI
  </div>
@endsection

{{-- ═══ SPA STYLES ═══ --}}
@push('styles')
<style>
  .spa-page { display: none; }
  .spa-page.active { display: block; animation: spaFadeIn 0.25s ease; }
  @keyframes spaFadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

{{-- ═══ SECTION INCLUDES ═══ --}}
@section('content')
  <div class="spa-page active" id="page-overview">
    @include('dashboard.overview2')
  </div>
  <div class="spa-page" id="page-tracker">
    @include('dashboard.tracker2')
  </div>
  <div class="spa-page" id="page-workout">
    @include('dashboard.workout2')
  </div>
  <div class="spa-page" id="page-lifestyle">
    @include('dashboard.lifestyle2')
  </div>
  <div class="spa-page" id="page-article">
    @include('dashboard.article2')
  </div>
  <div class="spa-page" id="page-consultation">
    @include('dashboard.consultation2')
  </div>
@endsection

{{-- ═══ ALL JAVASCRIPT ═══ --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
// ─── CONSTANTS (injected from PHP) ─────────────
const USER_INITIALS = '{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}';
const USER_NAME     = '{{ e(Auth::user()->name) }}';
const CSRF          = document.querySelector('meta[name="csrf-token"]').content;

// ─── HELPERS ───────────────────────────────────
function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, c => (
    {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#x27;'}[c]
  ));
}

async function postForm(url, fields) {
  const body = new URLSearchParams({ _token: CSRF, ...fields });
  return fetch(url, {
    method:  'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
    body,
  });
}

// ─── SPA NAVIGATION ────────────────────────────
const PAGE_META = {
  overview:     ['Dashboard',          'Selamat datang, {{ e(Auth::user()->name) }}! 👋'],
  tracker:      ['Life Tracker',       'Catat aktivitas kesehatan harian Anda'],
  workout:      ['Workout Planner',    'Rencanakan dan lacak sesi latihan Anda'],
  lifestyle:    ['Lifestyle Score',    'Pantau skor gaya hidup sehat Anda'],
  article:      ['Artikel & Komunitas','Edukasi dan berbagi bersama komunitas'],
  consultation: ['Konsultasi AI',      'Konsultasi dokter & dukungan mental AI'],
};

function showPage(id, el) {
  document.querySelectorAll('.spa-page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  document.getElementById('page-' + id).classList.add('active');
  el.classList.add('active');
  const [title, sub] = PAGE_META[id] ?? ['Dashboard', ''];
  document.getElementById('topbar-title').textContent    = title;
  document.getElementById('topbar-subtitle').textContent = sub;
  // Auto-calculate lifestyle score when switching to that page
  if (id === 'lifestyle') fetchLifestyleScore();
}

// ─── WEEKLY CALORIE CHART (overview) ───────────
const chartLabels = @json($weeklyCalories->map(fn($e) => \Carbon\Carbon::parse($e->entry_date)->locale('id')->isoFormat('D MMM')));
const chartCalIn  = @json($weeklyCalories->pluck('calories_in'));
const chartCalOut = @json($weeklyCalories->pluck('calories_out'));

new Chart(document.getElementById('calChart'), {
  type: 'bar',
  data: {
    labels: chartLabels,
    datasets: [
      { label: 'Kalori Masuk',  data: chartCalIn,  backgroundColor: 'rgba(192,57,43,0.75)', borderRadius: 6 },
      { label: 'Kalori Keluar', data: chartCalOut, backgroundColor: 'rgba(139,99,67,0.55)',  borderRadius: 6 },
    ],
  },
  options: {
    responsive: true,
    plugins: { legend: { position: 'bottom' } },
    scales: { y: { beginAtZero: true } },
  },
});

// ─── TRACKER — date init ────────────────────────
(function () {
  const now = new Date();
  const dateEl  = document.getElementById('tracker-date');
  const timeEl  = document.getElementById('tracker-time');
  const badgeEl = document.getElementById('tracker-date-badge');
  if (dateEl)  dateEl.value  = now.toISOString().slice(0, 10);
  if (timeEl)  timeEl.value  = now.toTimeString().slice(0, 5);
  if (badgeEl) badgeEl.textContent = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long' });
})();

// ─── TRACKER — form actions ─────────────────────
async function saveTracker() {
  const date   = document.getElementById('tracker-date').value;
  const air    = document.getElementById('t-air').value;
  const kalIn  = document.getElementById('t-kal-in').value;
  const exMin  = document.getElementById('t-olahraga').value;
  const tidur  = document.getElementById('t-tidur').value;
  const note   = document.getElementById('t-note').value;

  if (!date || !air || !kalIn || !exMin || !tidur) {
    alert('Harap isi semua kolom yang diperlukan.');
    return;
  }

  try {
    const res = await postForm('/life-tracker', {
      entry_date:       date,
      water_ml:         air,
      calories_in:      kalIn,
      exercise_minutes: exMin,
      sleep_hours:      tidur,
      notes:            note,
    });

    if (res.ok) {
      const kalOut = +document.getElementById('t-kal-out').value || 0;
      document.getElementById('summary-kalori-net').querySelector('div').textContent =
        (+kalIn - kalOut).toLocaleString('id-ID');
      document.getElementById('s-air').textContent   = air + ' ml';
      document.getElementById('s-tidur').textContent = tidur + ' jam';
      const msg = document.getElementById('tracker-success');
      msg.style.display = 'block';
      setTimeout(() => msg.style.display = 'none', 3000);
    } else {
      const err = await res.json().catch(() => ({}));
      alert('Gagal menyimpan: ' + (err.message || 'Periksa kembali isian form.'));
    }
  } catch (e) {
    alert('Terjadi kesalahan koneksi. Coba lagi.');
  }
}

function resetTracker() {
  ['t-air', 't-kal-in', 't-olahraga', 't-tidur', 't-note'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.value = '';
  });
  const kalOut = document.getElementById('t-kal-out');
  if (kalOut) kalOut.value = '';
}

// ─── WORKOUT ────────────────────────────────────
let selectedWorkout = { name: 'Lari', cal: 8, emoji: '🏃', key: 'cardio' };
let timerSeconds    = 1800, timerInterval = null, timerRunning = false;

const WORKOUT_GUIDES = {
  'Lari':         '<strong>🏃 Lari:</strong><br>1. Pemanasan 5 menit jalan cepat<br>2. Lari 65–75% denyut jantung maks<br>3. Postur tegak, pandangan depan<br>4. Pendinginan 5 menit<br><em style="color:var(--muted)">💡 Minum air tiap 15 menit</em>',
  'Bersepeda':    '<strong>🚴 Bersepeda:</strong><br>1. Setel ketinggian sadel dengan benar<br>2. Kayuh ritme 80–100 rpm<br>3. Jaga punggung tetap lurus<br>4. Cooling down 5 menit<br><em style="color:var(--muted)">💡 Pakai helm &amp; pelindung lutut</em>',
  'Berenang':     '<strong>🏊 Berenang:</strong><br>1. Pemanasan renang pelan 2 lap<br>2. Fokus teknik napas yang benar<br>3. Ganti gaya tiap 4 lap<br>4. Cooling down renang santai<br><em style="color:var(--muted)">💡 Istirahat 30 detik tiap 100m</em>',
  'Angkat Beban': '<strong>🏋️ Angkat Beban:</strong><br>1. Lakukan 3–4 set per latihan<br>2. Rep range 8–12 untuk hipertrofi<br>3. Istirahat 60–90 detik antar set<br>4. Prioritaskan form daripada beban<br><em style="color:var(--muted)">💡 Progressive overload kuncinya</em>',
  'Yoga':         '<strong>🧘 Yoga:</strong><br>1. Mulai dengan Child\'s Pose 2 menit<br>2. Ikuti urutan: duduk → berdiri → lantai<br>3. Fokus napas, jangan dipaksakan<br>4. Tutup dengan Savasana 5 menit<br><em style="color:var(--muted)">💡 Konsistensi lebih penting dari fleksibilitas</em>',
  'HIIT':         '<strong>⚡ HIIT:</strong><br>1. Pemanasan 5 menit wajib!<br>2. Interval: 20 detik intense, 10 detik rest<br>3. Lakukan 8 putaran (4 menit)<br>4. Istirahat 2 menit antar sirkuit<br><em style="color:var(--muted)">💡 Jangan HIIT lebih dari 3x/minggu</em>',
};

function selectWorkout(el, name, cal, emoji, key) {
  document.querySelectorAll('.workout-item').forEach(i => i.classList.remove('selected'));
  el.classList.add('selected');
  selectedWorkout = { name, cal, emoji, key };
  document.getElementById('timer-workout-name').textContent = emoji + ' ' + name.toUpperCase();
  document.getElementById('workout-guide').innerHTML = WORKOUT_GUIDES[name] ?? '';
  updateDuration(document.getElementById('workout-duration').value);
}

function updateDuration(val) {
  document.getElementById('duration-label').textContent = val + ' menit';
  timerSeconds = val * 60;
  if (!timerRunning) updateTimerDisplay();
  document.getElementById('est-cal').textContent = Math.round(val * selectedWorkout.cal) + ' kal';
}

function updateTimerDisplay() {
  const m = String(Math.floor(timerSeconds / 60)).padStart(2, '0');
  const s = String(timerSeconds % 60).padStart(2, '0');
  document.getElementById('timer-display').textContent = m + ':' + s;
}

function startTimer() {
  if (timerRunning) return;
  timerRunning = true;
  timerInterval = setInterval(() => {
    if (timerSeconds > 0) { timerSeconds--; updateTimerDisplay(); }
    else { clearInterval(timerInterval); timerRunning = false; finishWorkout(); }
  }, 1000);
}

function pauseTimer()  { clearInterval(timerInterval); timerRunning = false; }

function resetTimer() {
  clearInterval(timerInterval);
  timerRunning = false;
  timerSeconds = +document.getElementById('workout-duration').value * 60;
  updateTimerDisplay();
}

async function finishWorkout() {
  pauseTimer();
  const dur = +document.getElementById('workout-duration').value;
  const cal = Math.round(dur * selectedWorkout.cal);
  document.getElementById('final-cal').textContent = cal;
  document.getElementById('workout-result').style.display = 'block';

  try {
    const res = await postForm('/workout-planner', {
      session_date:     new Date().toISOString().slice(0, 10),
      workout_type:     selectedWorkout.key,
      duration_minutes: dur,
      notes:            '',
    });

    if (res.ok) {
      const data = await res.json();
      // Sync total calories burned to tracker
      const kalOutEl = document.getElementById('t-kal-out');
      if (kalOutEl) kalOutEl.value = data.total_calories ?? cal;
    } else {
      console.warn('Workout save failed', res.status);
    }
  } catch (e) {
    console.error('Workout save error', e);
  }
}

// ─── LIFESTYLE SCORE ────────────────────────────
async function fetchLifestyleScore() {
  try {
    const res  = await fetch('/lifestyle-score/calculate', { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } });
    const data = await res.json();
    // Update score ring text
    const ringText = document.querySelector('#page-lifestyle .score-ring-svg text');
    if (ringText) ringText.textContent = data.score;
  } catch (e) {
    console.warn('Score fetch error', e);
  }
}

// ─── LIFESTYLE SCORE SIMULATOR ──────────────────
function calcScore() {
  const air   = +document.getElementById('sim-air').value;
  const ex    = +document.getElementById('sim-ex').value;
  const sleep = +document.getElementById('sim-sleep').value;
  document.getElementById('sim-air-label').textContent   = air   + ' ml';
  document.getElementById('sim-ex-label').textContent    = ex    + ' menit';
  document.getElementById('sim-sleep-label').textContent = sleep + ' jam';
  const total = Math.min(100, Math.round(
    Math.min(25, (air / 2000) * 25) +
    Math.min(25, (ex / 60) * 25) +
    Math.min(25, sleep >= 7 ? 25 : (sleep / 7) * 25) +
    20
  ));
  document.getElementById('sim-score').textContent = total;
  const statusEl = document.getElementById('sim-status');
  if (total >= 70) { statusEl.textContent = '✓ SEHAT'; statusEl.className = 'score-status score-good'; }
  else             { statusEl.textContent = '⚠ KURANG'; statusEl.className = 'score-status score-bad'; }
}

// ─── ARTICLE TABS ───────────────────────────────
function switchTab(el, sectionId) {
  document.querySelectorAll('#article-tabs .filter-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  ['articles-section', 'community-section'].forEach(id => {
    document.getElementById(id).style.display = id === sectionId ? 'block' : 'none';
  });
}

// ─── COMMUNITY POST ─────────────────────────────
async function addPost() {
  const input = document.getElementById('post-input');
  const text  = input.value.trim();
  if (text.length < 10) { alert('Post minimal 10 karakter.'); return; }

  try {
    const res = await postForm('/community', { content: text });
    if (!res.ok) { alert('Gagal memposting. Coba lagi.'); return; }
  } catch (e) {
    alert('Terjadi kesalahan koneksi.');
    return;
  }

  // Optimistically add to DOM
  const card = document.createElement('div');
  card.className = 'post-card';
  card.innerHTML = `
    <div class="post-header">
      <div class="post-avatar" style="background:linear-gradient(135deg,#C0392B,#3E2011)">${USER_INITIALS}</div>
      <div>
        <div class="post-name">${escapeHtml(USER_NAME)}</div>
        <div class="post-time">Baru saja</div>
      </div>
    </div>`;

  const textEl = document.createElement('div');
  textEl.className = 'post-text';
  textEl.textContent = text;

  const actions = document.createElement('div');
  actions.className = 'post-actions';
  actions.innerHTML = '<div class="post-action">❤️ 0 Suka</div><div class="post-action">💬 0 Komentar</div>';

  card.appendChild(textEl);
  card.appendChild(actions);
  document.getElementById('posts-list').prepend(card);
  input.value = '';
}

// ─── AI CHAT ────────────────────────────────────
async function sendChat() {
    const chatInput = document.getElementById('chat-input');
    const chatBody = document.getElementById('chat-body');
    const message = chatInput.value.trim();

    if (message === "") return;

    // 1. Tambahkan pesan user dengan class yang sama persis
    chatBody.innerHTML += `
        <div class="chat-msg user">
            <div class="msg-avatar">BA</div>
            <div class="msg-bubble user">${message}</div>
        </div>`;
    
    chatInput.value = ''; // Kosongkan input
    chatBody.scrollTop = chatBody.scrollHeight; // Auto scroll ke bawah

    // 2. Tambahkan indikator "loading" dengan style yang sama
    const loadingId = 'loading-msg';
    chatBody.innerHTML += `
        <div class="chat-msg" id="${loadingId}">
            <div class="msg-avatar ai-av">🤖</div>
            <div class="msg-bubble ai">...</div>
        </div>`;

    // 3. Kirim ke Laravel
    try {
        const response = await fetch('/ask-gemini', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ prompt: message })
        });

        const data = await response.json();
        
        // 4. Hapus loading, ganti dengan jawaban AI
        document.getElementById(loadingId).remove();
        chatBody.innerHTML += `
            <div class="chat-msg">
                <div class="msg-avatar ai-av">🤖</div>
                <div class="msg-bubble ai">${data.answer}</div>
            </div>`;
            
    } catch (error) {
        document.getElementById(loadingId).remove();
        chatBody.innerHTML += `
            <div class="chat-msg">
                <div class="msg-bubble ai" style="color:red">Maaf, terjadi error.</div>
            </div>`;
    }
    
    chatBody.scrollTop = chatBody.scrollHeight;
}
</script>
@endpush
