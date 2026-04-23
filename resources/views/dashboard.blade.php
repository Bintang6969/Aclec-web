<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Healthy-Care | Platform Manajemen Kesehatan</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
:root {
  --white: #FEFCF9;
  --cream: #F5EFE6;
  --brown-light: #C8A882;
  --brown-mid: #8B6343;
  --brown-dark: #3E2011;
  --red: #C0392B;
  --red-light: #E74C3C;
  --black: #1A0F07;
  --text: #2C1A0E;
  --muted: #7D6555;
  --border: #DDD0C0;
  --card: #FFFFFF;
  --sidebar-w: 230px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background: var(--cream);
  color: var(--text);
  display: flex;
  min-height: 100vh;
  overflow-x: hidden;
}

/* ─── SIDEBAR ─────────────────────────────────── */
.sidebar {
  width: var(--sidebar-w);
  background: var(--brown-dark);
  min-height: 100vh;
  position: fixed; left: 0; top: 0; bottom: 0;
  display: flex; flex-direction: column;
  z-index: 200;
  box-shadow: 4px 0 20px rgba(0,0,0,0.3);
}
.sidebar-logo {
  padding: 1.8rem 1.5rem 1.2rem;
  border-bottom: 1px solid rgba(255,255,255,0.08);
}
.logo-text {
  font-family: 'Playfair Display', serif;
  font-size: 1.4rem; font-weight: 800;
  color: var(--white);
  letter-spacing: -0.5px;
  line-height: 1.1;
}
.logo-text span { color: var(--brown-light); }
.logo-sub { font-size: 0.68rem; color: rgba(255,255,255,0.4); margin-top: 2px; letter-spacing: 1px; text-transform: uppercase; }

.nav-section { padding: 1.2rem 1rem 0.5rem; }
.nav-label { font-size: 0.62rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.3); padding: 0 0.5rem; margin-bottom: 0.5rem; }

.nav-item {
  display: flex; align-items: center; gap: 0.75rem;
  padding: 0.7rem 0.8rem; border-radius: 10px;
  cursor: pointer; transition: all 0.2s;
  color: rgba(255,255,255,0.55);
  font-size: 0.88rem; font-weight: 500;
  margin-bottom: 2px;
  position: relative;
  user-select: none;
}
.nav-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.85); }
.nav-item.active {
  background: var(--red);
  color: white;
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(192,57,43,0.4);
}
.nav-icon { font-size: 1.1rem; width: 22px; text-align: center; flex-shrink: 0; }
.nav-badge {
  margin-left: auto; background: var(--brown-light);
  color: var(--brown-dark); font-size: 0.62rem; font-weight: 700;
  padding: 1px 6px; border-radius: 20px;
}

.sidebar-footer {
  margin-top: auto; padding: 1rem 1.2rem;
  border-top: 1px solid rgba(255,255,255,0.08);
}
.user-chip {
  display: flex; align-items: center; gap: 0.6rem;
  padding: 0.6rem 0.5rem; border-radius: 10px;
  cursor: pointer; transition: background 0.2s;
}
.user-chip:hover { background: rgba(255,255,255,0.07); }
.avatar-sm {
  width: 34px; height: 34px; border-radius: 50%;
  background: linear-gradient(135deg, var(--brown-light), var(--red));
  display: flex; align-items: center; justify-content: center;
  font-size: 0.85rem; font-weight: 700; color: white;
  flex-shrink: 0;
}
.user-name { font-size: 0.82rem; font-weight: 600; color: rgba(255,255,255,0.8); }
.user-role { font-size: 0.68rem; color: rgba(255,255,255,0.35); }

/* ─── MAIN ─────────────────────────────────────── */
.main {
  margin-left: var(--sidebar-w);
  flex: 1; min-height: 100vh;
  display: flex; flex-direction: column;
}

/* ─── TOPBAR ─────────────────────────────────── */
.topbar {
  display: flex; align-items: center; justify-content: space-between;
  padding: 1.2rem 2rem;
  background: var(--white);
  border-bottom: 1px solid var(--border);
  position: sticky; top: 0; z-index: 100;
}
.topbar-left h1 {
  font-family: 'Playfair Display', serif;
  font-size: 1.4rem; font-weight: 700;
  color: var(--brown-dark);
}
.topbar-left p { font-size: 0.8rem; color: var(--muted); }
.topbar-right { display: flex; align-items: center; gap: 1rem; }
.date-chip {
  background: var(--cream); border: 1px solid var(--border);
  padding: 0.4rem 0.9rem; border-radius: 20px;
  font-size: 0.8rem; color: var(--brown-mid); font-weight: 500;
}
.notification-btn {
  width: 36px; height: 36px; border-radius: 50%;
  background: var(--cream); border: 1px solid var(--border);
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; font-size: 1rem;
  transition: background 0.2s;
}
.notification-btn:hover { background: var(--border); }

/* ─── PAGE CONTENT ────────────────────────────── */
.page { display: none; padding: 2rem; }
.page.active { display: block; }

/* ─── STAT CARDS ──────────────────────────────── */
.stat-row {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1rem; margin-bottom: 1.5rem;
}
.stat-card {
  background: var(--card); border-radius: 16px;
  padding: 1.3rem 1.4rem;
  border: 1px solid var(--border);
  transition: transform 0.2s, box-shadow 0.2s;
  position: relative; overflow: hidden;
}
.stat-card::before {
  content: ''; position: absolute;
  top: 0; left: 0; right: 0; height: 3px;
  background: var(--red);
}
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(62,32,17,0.1); }
.stat-icon {
  width: 40px; height: 40px; border-radius: 10px;
  background: var(--cream); display: flex; align-items: center;
  justify-content: center; font-size: 1.2rem; margin-bottom: 0.8rem;
}
.stat-val {
  font-family: 'Playfair Display', serif;
  font-size: 1.7rem; font-weight: 700;
  color: var(--brown-dark); line-height: 1;
}
.stat-lbl { font-size: 0.75rem; color: var(--muted); margin-top: 0.3rem; }
.stat-change {
  font-size: 0.72rem; font-weight: 600;
  margin-top: 0.4rem; display: inline-flex; align-items: center; gap: 2px;
}
.stat-change.up { color: #27ae60; }
.stat-change.down { color: var(--red); }

/* ─── GRID LAYOUTS ────────────────────────────── */
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem; }
.grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem; }
.grid-65 { display: grid; grid-template-columns: 1.8fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem; }

/* ─── CARD ────────────────────────────────────── */
.card {
  background: var(--card); border-radius: 16px;
  border: 1px solid var(--border); padding: 1.4rem;
}
.card-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 1.2rem;
}
.card-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.05rem; font-weight: 700; color: var(--brown-dark);
}
.card-sub { font-size: 0.76rem; color: var(--muted); margin-top: 2px; }
.badge {
  padding: 0.3rem 0.8rem; border-radius: 20px;
  font-size: 0.72rem; font-weight: 600;
}
.badge-red { background: rgba(192,57,43,0.1); color: var(--red); }
.badge-brown { background: var(--cream); color: var(--brown-mid); }
.badge-green { background: rgba(39,174,96,0.1); color: #27ae60; }

/* ─── DONUT CHART ─────────────────────────────── */
.donut-wrap { display: flex; align-items: center; gap: 1.2rem; }
.donut-svg { flex-shrink: 0; }
.donut-legend { flex: 1; }
.legend-item {
  display: flex; align-items: center; gap: 0.5rem;
  font-size: 0.8rem; margin-bottom: 0.45rem; color: var(--text);
}
.legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.legend-pct { margin-left: auto; font-weight: 600; color: var(--brown-dark); }

/* ─── BAR CHART ───────────────────────────────── */
.bar-chart { display: flex; align-items: flex-end; gap: 6px; height: 100px; }
.bar-col { display: flex; flex-direction: column; align-items: center; gap: 3px; flex: 1; }
.bar {
  width: 100%; border-radius: 6px 6px 0 0;
  transition: height 0.6s ease;
  cursor: pointer; position: relative;
}
.bar:hover { filter: brightness(1.1); }
.bar-lbl { font-size: 0.6rem; color: var(--muted); }
.bar-highlight {
  outline: 2px solid var(--red);
  outline-offset: 2px;
}

/* ─── LINE CHART ──────────────────────────────── */
.line-chart-wrap { position: relative; height: 130px; }
.line-chart-svg { width: 100%; height: 100%; }

/* ─── PROGRESS BARS ───────────────────────────── */
.progress-item { margin-bottom: 0.9rem; }
.progress-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.3rem; }
.progress-name { font-size: 0.82rem; font-weight: 500; color: var(--text); }
.progress-val { font-size: 0.78rem; font-weight: 600; color: var(--brown-mid); }
.progress-bar { height: 8px; background: var(--cream); border-radius: 4px; overflow: hidden; }
.progress-fill { height: 100%; border-radius: 4px; transition: width 1s ease; }

/* ─── FORM ELEMENTS ───────────────────────────── */
.form-group { margin-bottom: 1rem; }
.form-label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--brown-mid); margin-bottom: 0.4rem; }
.form-input {
  width: 100%; padding: 0.65rem 0.9rem;
  border: 1.5px solid var(--border); border-radius: 10px;
  font-family: inherit; font-size: 0.88rem; color: var(--text);
  background: var(--white); transition: border-color 0.2s;
  outline: none;
}
.form-input:focus { border-color: var(--brown-mid); }
.form-select { appearance: none; cursor: pointer; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; }
.form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.8rem; }

/* ─── BUTTONS ─────────────────────────────────── */
.btn {
  padding: 0.65rem 1.4rem; border-radius: 10px;
  font-family: inherit; font-size: 0.88rem; font-weight: 600;
  cursor: pointer; border: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.4rem;
}
.btn-primary { background: var(--red); color: white; box-shadow: 0 4px 12px rgba(192,57,43,0.3); }
.btn-primary:hover { background: #a93226; transform: translateY(-1px); }
.btn-outline { background: transparent; color: var(--brown-mid); border: 1.5px solid var(--border); }
.btn-outline:hover { border-color: var(--brown-mid); background: var(--cream); }
.btn-sm { padding: 0.45rem 0.9rem; font-size: 0.8rem; border-radius: 8px; }
.btn-brown { background: var(--brown-dark); color: white; }
.btn-brown:hover { background: #5a300f; transform: translateY(-1px); }

/* ─── TABLE ───────────────────────────────────── */
.table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
.table th { text-align: left; padding: 0.6rem 0.8rem; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--muted); border-bottom: 1px solid var(--border); }
.table td { padding: 0.7rem 0.8rem; border-bottom: 1px solid rgba(0,0,0,0.04); color: var(--text); }
.table tr:last-child td { border-bottom: none; }
.table tr:hover td { background: var(--cream); }
.rank-badge { width: 24px; height: 24px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem; font-weight: 700; }
.rank-1 { background: #FFD700; color: #7a5900; }
.rank-2 { background: #C0C0C0; color: #444; }
.rank-3 { background: #CD7F32; color: white; }

/* ─── WORKOUT CARD ────────────────────────────── */
.workout-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.8rem; margin-bottom: 1rem; }
.workout-item {
  border: 1.5px solid var(--border); border-radius: 12px;
  padding: 1rem; cursor: pointer; transition: all 0.2s;
  text-align: center;
}
.workout-item:hover { border-color: var(--red); background: rgba(192,57,43,0.03); }
.workout-item.selected { border-color: var(--red); background: rgba(192,57,43,0.07); }
.workout-emoji { font-size: 1.8rem; margin-bottom: 0.4rem; }
.workout-name { font-size: 0.82rem; font-weight: 600; color: var(--brown-dark); }
.workout-cal { font-size: 0.7rem; color: var(--muted); }

/* ─── TIMER ───────────────────────────────────── */
.timer-display {
  text-align: center; padding: 1.5rem;
  background: var(--brown-dark); border-radius: 16px; color: white;
  margin-bottom: 1rem;
}
.timer-time {
  font-family: 'Playfair Display', serif;
  font-size: 3.5rem; font-weight: 700; letter-spacing: 2px;
  color: white; line-height: 1;
}
.timer-label { font-size: 0.75rem; color: rgba(255,255,255,0.5); margin-top: 0.3rem; letter-spacing: 1px; text-transform: uppercase; }
.timer-controls { display: flex; gap: 0.6rem; justify-content: center; margin-top: 1rem; }

/* ─── SCORE RING ──────────────────────────────── */
.score-ring-wrap { text-align: center; padding: 1rem 0; }
.score-ring-svg { display: block; margin: 0 auto; }
.score-val {
  font-family: 'Playfair Display', serif;
  font-size: 2.5rem; font-weight: 800; color: var(--brown-dark);
}
.score-label { font-size: 0.8rem; color: var(--muted); }
.score-status {
  display: inline-block; margin-top: 0.6rem;
  padding: 0.3rem 1rem; border-radius: 20px;
  font-size: 0.78rem; font-weight: 700;
}
.score-good { background: rgba(39,174,96,0.15); color: #27ae60; }
.score-bad { background: rgba(192,57,43,0.15); color: var(--red); }

/* ─── ARTICLE CARD ────────────────────────────── */
.article-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
.article-card {
  border: 1px solid var(--border); border-radius: 14px; overflow: hidden;
  cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;
  background: var(--white);
}
.article-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(62,32,17,0.1); }
.article-img {
  height: 130px; background: var(--cream);
  display: flex; align-items: center; justify-content: center;
  font-size: 3rem;
  position: relative; overflow: hidden;
}
.article-body { padding: 1rem; }
.article-cat {
  font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: 0.8px; color: var(--red); margin-bottom: 0.4rem;
}
.article-title { font-size: 0.88rem; font-weight: 700; color: var(--brown-dark); line-height: 1.35; margin-bottom: 0.4rem; }
.article-date { font-size: 0.72rem; color: var(--muted); }

/* ─── COMMUNITY POST ──────────────────────────── */
.post-card { border: 1px solid var(--border); border-radius: 14px; padding: 1.1rem; background: var(--white); margin-bottom: 0.8rem; }
.post-header { display: flex; align-items: center; gap: 0.7rem; margin-bottom: 0.7rem; }
.post-avatar { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700; color: white; flex-shrink: 0; }
.post-name { font-size: 0.85rem; font-weight: 600; color: var(--brown-dark); }
.post-time { font-size: 0.7rem; color: var(--muted); }
.post-text { font-size: 0.84rem; color: var(--text); line-height: 1.6; margin-bottom: 0.7rem; }
.post-actions { display: flex; gap: 1rem; }
.post-action { font-size: 0.75rem; color: var(--muted); cursor: pointer; display: flex; align-items: center; gap: 0.3rem; transition: color 0.2s; }
.post-action:hover { color: var(--red); }

/* ─── CONSULTATION ────────────────────────────── */
.doctor-card {
  display: flex; align-items: center; gap: 1rem;
  border: 1px solid var(--border); border-radius: 14px; padding: 1rem;
  cursor: pointer; transition: all 0.2s; background: var(--white);
  margin-bottom: 0.8rem;
}
.doctor-card:hover { border-color: var(--red); background: rgba(192,57,43,0.02); }
.doctor-avatar { width: 50px; height: 50px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
.doctor-name { font-size: 0.9rem; font-weight: 700; color: var(--brown-dark); }
.doctor-spec { font-size: 0.75rem; color: var(--muted); }
.doctor-avail { margin-left: auto; font-size: 0.72rem; font-weight: 600; color: #27ae60; background: rgba(39,174,96,0.1); padding: 0.2rem 0.6rem; border-radius: 20px; }

/* ─── AI CHAT ─────────────────────────────────── */
.chat-wrap {
  border: 1px solid var(--border); border-radius: 14px;
  overflow: hidden; background: var(--white);
  display: flex; flex-direction: column; height: 380px;
}
.chat-header { padding: 0.9rem 1.1rem; background: var(--brown-dark); color: white; display: flex; align-items: center; gap: 0.7rem; }
.chat-ai-dot { width: 10px; height: 10px; border-radius: 50%; background: #2ecc71; animation: pulse 2s infinite; }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
.chat-body { flex: 1; overflow-y: auto; padding: 1rem; display: flex; flex-direction: column; gap: 0.8rem; }
.chat-msg { display: flex; gap: 0.6rem; align-items: flex-start; }
.chat-msg.user { flex-direction: row-reverse; }
.msg-avatar { width: 28px; height: 28px; border-radius: 50%; background: var(--brown-light); display: flex; align-items: center; justify-content: center; font-size: 0.7rem; flex-shrink: 0; color: white; font-weight: 700; }
.msg-avatar.ai-av { background: var(--brown-dark); }
.msg-bubble { max-width: 75%; padding: 0.6rem 0.9rem; border-radius: 12px; font-size: 0.82rem; line-height: 1.5; }
.msg-bubble.ai { background: var(--cream); color: var(--text); border-radius: 4px 12px 12px 12px; }
.msg-bubble.user { background: var(--red); color: white; border-radius: 12px 4px 12px 12px; }
.chat-input-wrap { padding: 0.8rem; border-top: 1px solid var(--border); display: flex; gap: 0.6rem; }
.chat-input { flex: 1; padding: 0.6rem 0.9rem; border: 1.5px solid var(--border); border-radius: 20px; font-family: inherit; font-size: 0.84rem; outline: none; background: var(--cream); }
.chat-input:focus { border-color: var(--brown-mid); }
.chat-send { width: 36px; height: 36px; border-radius: 50%; background: var(--red); color: white; border: none; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; transition: background 0.2s; flex-shrink: 0; }
.chat-send:hover { background: #a93226; }

/* ─── FILTER TABS ─────────────────────────────── */
.filter-tabs { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1rem; }
.filter-tab {
  padding: 0.35rem 0.9rem; border-radius: 20px;
  font-size: 0.78rem; font-weight: 600; cursor: pointer;
  border: 1.5px solid var(--border); background: var(--white); color: var(--muted);
  transition: all 0.2s;
}
.filter-tab:hover, .filter-tab.active { border-color: var(--red); background: var(--red); color: white; }

/* ─── REWARD / PENALTY PANEL ──────────────────── */
.reward-panel { border-radius: 14px; padding: 1.2rem; text-align: center; margin-bottom: 1rem; }
.reward-panel.good { background: linear-gradient(135deg, rgba(39,174,96,0.1), rgba(39,174,96,0.05)); border: 1px solid rgba(39,174,96,0.3); }
.reward-panel.bad { background: linear-gradient(135deg, rgba(192,57,43,0.1), rgba(192,57,43,0.05)); border: 1px solid rgba(192,57,43,0.3); }
.reward-emoji { font-size: 2.5rem; margin-bottom: 0.6rem; }
.reward-title { font-size: 0.9rem; font-weight: 700; margin-bottom: 0.3rem; }
.reward-desc { font-size: 0.78rem; color: var(--muted); }

/* ─── ANIMATIONS ──────────────────────────────── */
@keyframes fadeIn { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
.page.active { animation: fadeIn 0.3s ease; }

/* ─── SCROLLBAR ───────────────────────────────── */
::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

/* ─── RESPONSIVE ──────────────────────────────── */
@media (max-width: 1100px) { .stat-row { grid-template-columns: 1fr 1fr; } }
@media (max-width: 800px) {
  .sidebar { transform: translateX(-100%); }
  .main { margin-left: 0; }
  .grid-2, .grid-3, .grid-65 { grid-template-columns: 1fr; }
  .workout-grid { grid-template-columns: 1fr 1fr; }
  .article-grid { grid-template-columns: 1fr; }
}

/* ─── DASHBOARD SPECIFIC ──────────────────────── */
.quick-actions { display: flex; gap: 0.8rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
.divider { height: 1px; background: var(--border); margin: 1.2rem 0; }
</style>
</head>
<body>

<!-- ═══════════ SIDEBAR ═══════════ -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-text">Healthy<span>Care</span></div>
    <div class="logo-sub">Health Tracker</div>
  </div>

  <div class="nav-section">
    <div class="nav-label">Menu Utama</div>
    <div class="nav-item active" onclick="showPage('dashboard', this)">
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
      <span class="nav-badge">87</span>
    </div>
    <div class="nav-item" onclick="showPage('article', this)">
      <span class="nav-icon">📰</span> Article & Community
    </div>
    <div class="nav-item" onclick="showPage('consultation', this)">
      <span class="nav-icon">💬</span> Consultation
    </div>
  </div>

  <div class="sidebar-footer">
    <div class="user-chip">
      <div class="avatar-sm">BA</div>
      <div>
        <div class="user-name">
          A.</div>
        <div class="user-role">Member Aktif</div>
      </div>
    </div>
  </div>
</aside>

<!-- ═══════════ MAIN ═══════════ -->
<main class="main">
  <!-- TOPBAR -->
  <div class="topbar">
    <div class="topbar-left">
      <h1 id="page-title">Dashboard</h1>
      <p id="page-sub">Selamat datang kembali, Bintang! 👋</p>
    </div>
    <div class="topbar-right">
      <div class="date-chip" id="today-date">—</div>
      <div class="notification-btn">🔔</div>
    </div>
  </div>

  <!-- ═══ DASHBOARD ═══ -->
  <div class="page active" id="page-dashboard">
    <div style="padding:2rem">
      <!-- STAT CARDS -->
      <div class="stat-row">
        <div class="stat-card">
          <div class="stat-icon">🔥</div>
          <div class="stat-val">1,847</div>
          <div class="stat-lbl">Kalori Terbakar Hari Ini</div>
          <div class="stat-change up">▲ 12% dari kemarin</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">💧</div>
          <div class="stat-val">1.8L</div>
          <div class="stat-lbl">Air Diminum</div>
          <div class="stat-change up">▲ 90% target</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">😴</div>
          <div class="stat-val">7.5h</div>
          <div class="stat-lbl">Tidur Semalam</div>
          <div class="stat-change up">▲ Cukup</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">⭐</div>
          <div class="stat-val">87</div>
          <div class="stat-lbl">Lifestyle Score</div>
          <div class="stat-change up">▲ Sehat</div>
        </div>
      </div>

      <div class="grid-65">
        <!-- KALORI CHART -->
        <div class="card">
          <div class="card-header">
            <div>
              <div class="card-title">Kalori Mingguan</div>
              <div class="card-sub">Dibandingkan minggu lalu</div>
            </div>
            <span class="badge badge-brown">7 Hari</span>
          </div>
          <!-- SVG Line Chart -->
          <svg width="100%" height="130" viewBox="0 0 500 130" class="line-chart-svg">
            <defs>
              <linearGradient id="areaGrad" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#C0392B" stop-opacity="0.2"/>
                <stop offset="100%" stop-color="#C0392B" stop-opacity="0"/>
              </linearGradient>
            </defs>
            <!-- Grid lines -->
            <line x1="0" y1="30" x2="500" y2="30" stroke="#f0e8dc" stroke-width="1"/>
            <line x1="0" y1="65" x2="500" y2="65" stroke="#f0e8dc" stroke-width="1"/>
            <line x1="0" y1="100" x2="500" y2="100" stroke="#f0e8dc" stroke-width="1"/>
            <!-- Area fill -->
            <path d="M20,90 L90,60 L160,75 L230,40 L300,55 L370,30 L440,45 L440,110 L20,110 Z" fill="url(#areaGrad)"/>
            <!-- Line -->
            <path d="M20,90 L90,60 L160,75 L230,40 L300,55 L370,30 L440,45" fill="none" stroke="#C0392B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <!-- Dots -->
            <circle cx="230" cy="40" r="5" fill="#C0392B" stroke="white" stroke-width="2"/>
            <circle cx="370" cy="30" r="5" fill="#C0392B" stroke="white" stroke-width="2"/>
            <!-- Labels -->
            <text x="20" y="125" font-size="10" fill="#7D6555" text-anchor="middle">Sen</text>
            <text x="90" y="125" font-size="10" fill="#7D6555" text-anchor="middle">Sel</text>
            <text x="160" y="125" font-size="10" fill="#7D6555" text-anchor="middle">Rab</text>
            <text x="230" y="125" font-size="10" fill="#7D6555" text-anchor="middle">Kam</text>
            <text x="300" y="125" font-size="10" fill="#7D6555" text-anchor="middle">Jum</text>
            <text x="370" y="125" font-size="10" fill="#7D6555" text-anchor="middle">Sab</text>
            <text x="440" y="125" font-size="10" fill="#7D6555" text-anchor="middle">Min</text>
            <!-- Tooltip -->
            <rect x="340" y="8" width="70" height="26" rx="5" fill="#3E2011"/>
            <text x="375" y="25" font-size="11" fill="white" font-weight="bold" text-anchor="middle">2,100 kal</text>
          </svg>
        </div>

        <!-- NUTRITION DONUT -->
        <div class="card">
          <div class="card-header">
            <div>
              <div class="card-title">Nutrisi Hari Ini</div>
              <div class="card-sub">Distribusi makronutrien</div>
            </div>
          </div>
          <div class="donut-wrap">
            <svg width="100" height="100" class="donut-svg" viewBox="0 0 36 36">
              <circle cx="18" cy="18" r="15.9" fill="none" stroke="#f0e8dc" stroke-width="4"/>
              <circle cx="18" cy="18" r="15.9" fill="none" stroke="#C0392B" stroke-width="4" stroke-dasharray="40 60" stroke-dashoffset="25"/>
              <circle cx="18" cy="18" r="15.9" fill="none" stroke="#8B6343" stroke-width="4" stroke-dasharray="35 65" stroke-dashoffset="-15"/>
              <circle cx="18" cy="18" r="15.9" fill="none" stroke="#C8A882" stroke-width="4" stroke-dasharray="25 75" stroke-dashoffset="-50"/>
              <text x="18" y="20" text-anchor="middle" font-size="6" fill="#3E2011" font-weight="bold">1,847</text>
              <text x="18" y="25" text-anchor="middle" font-size="4" fill="#7D6555">kal</text>
            </svg>
            <div class="donut-legend">
              <div class="legend-item"><div class="legend-dot" style="background:#C0392B"></div>Karbo<span class="legend-pct">40%</span></div>
              <div class="legend-item"><div class="legend-dot" style="background:#8B6343"></div>Protein<span class="legend-pct">35%</span></div>
              <div class="legend-item"><div class="legend-dot" style="background:#C8A882"></div>Lemak<span class="legend-pct">25%</span></div>
            </div>
          </div>
        </div>
      </div>

      <div class="grid-2">
        <!-- PROGRESS TARGETS -->
        <div class="card">
          <div class="card-header">
            <div class="card-title">Target Harian</div>
            <span class="badge badge-green">Hari Ini</span>
          </div>
          <div class="progress-item">
            <div class="progress-top"><span class="progress-name">💧 Air Minum</span><span class="progress-val">1.8 / 2L</span></div>
            <div class="progress-bar"><div class="progress-fill" style="width:90%;background:#3498db"></div></div>
          </div>
          <div class="progress-item">
            <div class="progress-top"><span class="progress-name">🔥 Kalori Masuk</span><span class="progress-val">1847 / 2200 kal</span></div>
            <div class="progress-bar"><div class="progress-fill" style="width:84%;background:#C0392B"></div></div>
          </div>
          <div class="progress-item">
            <div class="progress-top"><span class="progress-name">🏃 Olahraga</span><span class="progress-val">45 / 60 menit</span></div>
            <div class="progress-bar"><div class="progress-fill" style="width:75%;background:#8B6343"></div></div>
          </div>
          <div class="progress-item">
            <div class="progress-top"><span class="progress-name">😴 Tidur</span><span class="progress-val">7.5 / 8 jam</span></div>
            <div class="progress-bar"><div class="progress-fill" style="width:94%;background:#C8A882"></div></div>
          </div>
        </div>

        <!-- QUICK ACTIONS -->
        <div class="card">
          <div class="card-header">
            <div class="card-title">Aksi Cepat</div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.7rem">
            <button class="btn btn-primary" onclick="showPage('tracker', document.querySelectorAll('.nav-item')[1])">📊 Catat Hari Ini</button>
            <button class="btn btn-brown" onclick="showPage('workout', document.querySelectorAll('.nav-item')[2])">🏋️ Mulai Workout</button>
            <button class="btn btn-outline" onclick="showPage('lifestyle', document.querySelectorAll('.nav-item')[3])">⭐ Cek Skor</button>
            <button class="btn btn-outline" onclick="showPage('consultation', document.querySelectorAll('.nav-item')[5])">💬 Konsultasi AI</button>
          </div>
          <div class="divider"></div>
          <div style="font-size:0.78rem;color:var(--muted);text-align:center">
            💡 <em>Tip: Minum segelas air sebelum makan besar untuk mengontrol porsi makan</em>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ═══ LIFE TRACKER ═══ -->
  <div class="page" id="page-tracker">
    <div style="padding:2rem">
      <div class="grid-65">
        <!-- INPUT FORM -->
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
              <input type="number" class="form-input" placeholder="1800" id="t-air" value="1800">
            </div>
            <div class="form-group">
              <label class="form-label">🔥 Kalori Masuk</label>
              <input type="number" class="form-input" placeholder="2000" id="t-kal-in" value="1847">
            </div>
            <div class="form-group">
              <label class="form-label">💪 Kalori Keluar</label>
              <input type="number" class="form-input" placeholder="500" id="t-kal-out" value="450" readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">🏃 Olahraga (menit)</label>
              <input type="number" class="form-input" placeholder="45" id="t-olahraga" value="45">
            </div>
            <div class="form-group">
              <label class="form-label">😴 Waktu Tidur (jam)</label>
              <input type="number" class="form-input" placeholder="7.5" id="t-tidur" value="7.5" step="0.5">
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

        <!-- SUMMARY -->
        <div>
          <div class="card" style="margin-bottom:1rem">
            <div class="card-title" style="margin-bottom:1rem">Ringkasan Hari Ini</div>
            <div id="summary-kalori-net" style="text-align:center;padding:1rem;background:var(--cream);border-radius:12px;margin-bottom:0.8rem">
              <div style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:800;color:var(--brown-dark)">1,397</div>
              <div style="font-size:0.75rem;color:var(--muted)">Kalori Net (Masuk - Keluar)</div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;font-size:0.8rem">
              <div style="padding:0.6rem;background:var(--cream);border-radius:10px;text-align:center">
                <div style="font-weight:700;color:var(--brown-dark)" id="s-air">1,800 ml</div>
                <div style="color:var(--muted)">Air</div>
              </div>
              <div style="padding:0.6rem;background:var(--cream);border-radius:10px;text-align:center">
                <div style="font-weight:700;color:var(--brown-dark)" id="s-tidur">7.5 jam</div>
                <div style="color:var(--muted)">Tidur</div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-title" style="margin-bottom:0.8rem">Status Target</div>
            <div id="status-list" style="display:flex;flex-direction:column;gap:0.5rem;font-size:0.82rem">
              <div>💧 Air: <strong style="color:#27ae60">✓ Cukup</strong></div>
              <div>🔥 Kalori: <strong style="color:#27ae60">✓ Sesuai</strong></div>
              <div>🏃 Olahraga: <strong style="color:#27ae60">✓ Cukup</strong></div>
              <div>😴 Tidur: <strong style="color:#27ae60">✓ Baik</strong></div>
            </div>
          </div>
        </div>
      </div>

      <!-- GRAFIK MINGGUAN -->
      <div class="card">
        <div class="card-header">
          <div>
            <div class="card-title">Grafik Kalori Terbakar — 7 Hari Terakhir</div>
            <div class="card-sub">Kalori keluar (olahraga + aktivitas dasar)</div>
          </div>
          <span class="badge badge-red">Mingguan</span>
        </div>
        <div style="display:flex;align-items:flex-end;gap:8px;height:120px;margin-top:0.5rem">
          <div class="bar-col">
            <div class="bar" style="height:65%;background:linear-gradient(to top,#8B6343,#C8A882)" title="Senin"></div>
            <div class="bar-lbl">Sen</div>
          </div>
          <div class="bar-col">
            <div class="bar" style="height:80%;background:linear-gradient(to top,#8B6343,#C8A882)" title="Selasa"></div>
            <div class="bar-lbl">Sel</div>
          </div>
          <div class="bar-col">
            <div class="bar" style="height:55%;background:linear-gradient(to top,#8B6343,#C8A882)"></div>
            <div class="bar-lbl">Rab</div>
          </div>
          <div class="bar-col">
            <div class="bar" style="height:90%;background:linear-gradient(to top,#C0392B,#E74C3C)" class="bar-highlight"></div>
            <div class="bar-lbl">Kam</div>
          </div>
          <div class="bar-col">
            <div class="bar" style="height:70%;background:linear-gradient(to top,#8B6343,#C8A882)"></div>
            <div class="bar-lbl">Jum</div>
          </div>
          <div class="bar-col">
            <div class="bar" style="height:85%;background:linear-gradient(to top,#8B6343,#C8A882)"></div>
            <div class="bar-lbl">Sab</div>
          </div>
          <div class="bar-col">
            <div class="bar" style="height:75%;background:linear-gradient(to top,#C8A882,#F5EFE6)"></div>
            <div class="bar-lbl">Min</div>
          </div>
        </div>
        <div style="display:flex;gap:1.5rem;margin-top:0.8rem;font-size:0.75rem;color:var(--muted)">
          <span>📊 Rata-rata: <strong style="color:var(--brown-dark)">487 kal/hari</strong></span>
          <span>📈 Tertinggi: <strong style="color:var(--red)">Kamis — 580 kal</strong></span>
          <span>📉 Terendah: <strong style="color:var(--brown-mid)">Rabu — 380 kal</strong></span>
        </div>
      </div>
    </div>
  </div>

  <!-- ═══ WORKOUT PLANNER ═══ -->
  <div class="page" id="page-workout">
    <div style="padding:2rem">
      <div class="grid-65">
        <div>
          <!-- PILIH WORKOUT -->
          <div class="card" style="margin-bottom:1.2rem">
            <div class="card-header">
              <div class="card-title">Pilih Jenis Workout</div>
              <span class="badge badge-brown">Pilih satu</span>
            </div>
            <div class="workout-grid" id="workout-grid">
              <div class="workout-item selected" onclick="selectWorkout(this,'Lari',8,'🏃')">
                <div class="workout-emoji">🏃</div>
                <div class="workout-name">Lari</div>
                <div class="workout-cal">~8 kal/menit</div>
              </div>
              <div class="workout-item" onclick="selectWorkout(this,'Bersepeda',6,'🚴')">
                <div class="workout-emoji">🚴</div>
                <div class="workout-name">Bersepeda</div>
                <div class="workout-cal">~6 kal/menit</div>
              </div>
              <div class="workout-item" onclick="selectWorkout(this,'Berenang',9,'🏊')">
                <div class="workout-emoji">🏊</div>
                <div class="workout-name">Berenang</div>
                <div class="workout-cal">~9 kal/menit</div>
              </div>
              <div class="workout-item" onclick="selectWorkout(this,'Angkat Beban',5,'🏋️')">
                <div class="workout-emoji">🏋️</div>
                <div class="workout-name">Angkat Beban</div>
                <div class="workout-cal">~5 kal/menit</div>
              </div>
              <div class="workout-item" onclick="selectWorkout(this,'Yoga',3,'🧘')">
                <div class="workout-emoji">🧘</div>
                <div class="workout-name">Yoga</div>
                <div class="workout-cal">~3 kal/menit</div>
              </div>
              <div class="workout-item" onclick="selectWorkout(this,'HIIT',10,'⚡')">
                <div class="workout-emoji">⚡</div>
                <div class="workout-name">HIIT</div>
                <div class="workout-cal">~10 kal/menit</div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">⏱ Durasi (menit)</label>
              <input type="range" class="form-input" min="5" max="120" step="5" value="30" id="workout-duration" oninput="updateDuration(this.value)" style="padding:0;border:none;background:transparent;cursor:pointer">
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

          <!-- PANDUAN -->
          <div class="card">
            <div class="card-title" style="margin-bottom:0.8rem">📋 Panduan Workout</div>
            <div id="workout-guide" style="font-size:0.85rem;line-height:1.7;color:var(--text)">
              <strong>🏃 Lari — Panduan:</strong><br>
              1. Pemanasan 5 menit dengan jalan cepat<br>
              2. Lari dengan kecepatan sedang 65-75% denyut jantung maks<br>
              3. Jaga postur tubuh tegak, pandangan ke depan<br>
              4. Pendinginan 5 menit jalan santai<br>
              <em style="color:var(--muted)">💡 Tip: Minum air setiap 15 menit</em>
            </div>
          </div>
        </div>

        <!-- TIMER -->
        <div>
          <div class="card" style="margin-bottom:1.2rem">
            <div class="card-title" style="margin-bottom:1rem">⏱ Timer Workout</div>
            <div class="timer-display">
              <div class="timer-time" id="timer-display">30:00</div>
              <div class="timer-label" id="timer-workout-name">🏃 LARI</div>
              <div class="timer-controls">
                <button class="btn btn-sm" style="background:rgba(255,255,255,0.15);color:white;border:none" onclick="startTimer()">▶ Mulai</button>
                <button class="btn btn-sm" style="background:rgba(255,255,255,0.15);color:white;border:none" onclick="pauseTimer()">⏸ Pause</button>
                <button class="btn btn-sm" style="background:rgba(255,255,255,0.15);color:white;border:none" onclick="resetTimer()">↺ Reset</button>
              </div>
            </div>
            <button class="btn btn-primary" style="width:100%" onclick="finishWorkout()">✅ Selesai & Kirim ke Tracker</button>
          </div>

          <div class="card" id="workout-result" style="display:none">
            <div class="card-title" style="margin-bottom:0.8rem;color:var(--red)">🎉 Workout Selesai!</div>
            <div style="text-align:center;padding:0.8rem;background:var(--cream);border-radius:12px">
              <div style="font-size:2rem;margin-bottom:0.3rem">🔥</div>
              <div style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:800;color:var(--red)" id="final-cal">240</div>
              <div style="font-size:0.75rem;color:var(--muted)">kalori terbakar</div>
              <div style="font-size:0.78rem;color:#27ae60;margin-top:0.4rem;font-weight:600">✓ Data dikirim ke Life Tracker</div>
            </div>
          </div>

          <!-- RIWAYAT WORKOUT -->
          <div class="card" style="margin-top:1rem">
            <div class="card-title" style="margin-bottom:0.8rem">Riwayat Workout</div>
            <table class="table">
              <thead><tr><th>Workout</th><th>Durasi</th><th>Kal</th></tr></thead>
              <tbody>
                <tr><td>🏃 Lari</td><td>30 mnt</td><td style="color:var(--red);font-weight:600">240</td></tr>
                <tr><td>🏋️ Beban</td><td>45 mnt</td><td style="color:var(--red);font-weight:600">225</td></tr>
                <tr><td>🚴 Sepeda</td><td>60 mnt</td><td style="color:var(--red);font-weight:600">360</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ═══ LIFESTYLE SCORE ═══ -->
  <div class="page" id="page-lifestyle">
    <div style="padding:2rem">
      <div class="grid-3">
        <!-- SCORE RING -->
        <div class="card" style="text-align:center">
          <div class="card-title" style="margin-bottom:0.5rem">Skor Kamu Hari Ini</div>
          <div class="score-ring-wrap">
            <svg width="160" height="160" viewBox="0 0 42 42" class="score-ring-svg">
              <circle cx="21" cy="21" r="18" fill="none" stroke="#f0e8dc" stroke-width="4"/>
              <circle cx="21" cy="21" r="18" fill="none" stroke="#C0392B" stroke-width="4"
                stroke-dasharray="98 14" stroke-dashoffset="7"
                stroke-linecap="round"
                style="transition:stroke-dasharray 1s ease"/>
              <text x="21" y="19" text-anchor="middle" font-size="8" fill="#3E2011" font-weight="bold">87</text>
              <text x="21" y="25" text-anchor="middle" font-size="4" fill="#7D6555">/ 100</text>
            </svg>
            <div class="score-status score-good">🏆 SEHAT</div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;margin-top:0.8rem;font-size:0.78rem">
            <div style="padding:0.5rem;background:var(--cream);border-radius:8px"><div style="font-weight:700">💧 25/25</div><div style="color:var(--muted)">Hidrasi</div></div>
            <div style="padding:0.5rem;background:var(--cream);border-radius:8px"><div style="font-weight:700">🏃 22/25</div><div style="color:var(--muted)">Olahraga</div></div>
            <div style="padding:0.5rem;background:var(--cream);border-radius:8px"><div style="font-weight:700">😴 20/25</div><div style="color:var(--muted)">Tidur</div></div>
            <div style="padding:0.5rem;background:var(--cream);border-radius:8px"><div style="font-weight:700">🥗 20/25</div><div style="color:var(--muted)">Nutrisi</div></div>
          </div>
        </div>

        <!-- REWARD/PENALTY + SKOR HARIAN -->
        <div>
          <div class="reward-panel good">
            <div class="reward-emoji">🎉</div>
            <div class="reward-title" style="color:#27ae60">Selamat! Kamu Mendapat Reward!</div>
            <div class="reward-desc">Skor kamu 87/100 — kamu boleh makan <strong>1 makanan favorit</strong> hari ini sebagai hadiah konsistensi!</div>
          </div>
          <div class="card">
            <div class="card-title" style="margin-bottom:0.8rem">Skor 7 Hari Terakhir</div>
            <div style="display:flex;align-items:flex-end;gap:6px;height:70px">
              <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
                <div style="flex:1;width:100%;border-radius:4px 4px 0 0;background:#C8A882" title="72"></div>
                <div style="font-size:0.6rem;color:var(--muted)">Sen</div>
              </div>
              <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
                <div style="flex:1;width:100%;border-radius:4px 4px 0 0;background:#8B6343" title="80"></div>
                <div style="font-size:0.6rem;color:var(--muted)">Sel</div>
              </div>
              <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
                <div style="flex:1;width:100%;border-radius:4px 4px 0 0;background:#C0392B" title="65"></div>
                <div style="font-size:0.6rem;color:var(--muted)">Rab</div>
              </div>
              <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
                <div style="flex:1;width:100%;border-radius:4px 4px 0 0;background:#8B6343" title="78"></div>
                <div style="font-size:0.6rem;color:var(--muted)">Kam</div>
              </div>
              <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
                <div style="flex:1;width:100%;border-radius:4px 4px 0 0;background:#C8A882" title="82"></div>
                <div style="font-size:0.6rem;color:var(--muted)">Jum</div>
              </div>
              <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
                <div style="flex:1;width:100%;border-radius:4px 4px 0 0;background:#8B6343" title="85"></div>
                <div style="font-size:0.6rem;color:var(--muted)">Sab</div>
              </div>
              <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
                <div style="flex:1;width:100%;border-radius:4px 4px 0 0;background:#C0392B" title="87"></div>
                <div style="font-size:0.6rem;color:var(--muted)">Min</div>
              </div>
            </div>
          </div>
        </div>

        <!-- LEADERBOARD -->
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
                <td><strong>A. 👤</strong></td>
                <td><strong style="color:var(--red)">87</strong></td>
              </tr>
            </tbody>
          </table>
          <div style="font-size:0.75rem;color:var(--muted);text-align:center;margin-top:0.6rem">Kamu di posisi ke-5. Naikkan skor untuk overtake Maya! 💪</div>
        </div>
      </div>

      <!-- SIMULASI SKOR -->
      <div class="card">
        <div class="card-header">
          <div class="card-title">Simulasi Skor Anda</div>
          <div class="card-sub">Ubah nilai untuk melihat dampak skor</div>
        </div>
        <div class="form-row-3">
          <div class="form-group">
            <label class="form-label">💧 Air (ml)</label>
            <input type="range" class="form-input" min="0" max="3000" step="100" value="1800" id="sim-air" oninput="calcScore()" style="padding:0;border:none;background:transparent;cursor:pointer">
            <div style="font-size:0.78rem;color:var(--muted);text-align:center" id="sim-air-label">1800 ml</div>
          </div>
          <div class="form-group">
            <label class="form-label">🏃 Olahraga (menit)</label>
            <input type="range" class="form-input" min="0" max="120" step="5" value="45" id="sim-ex" oninput="calcScore()" style="padding:0;border:none;background:transparent;cursor:pointer">
            <div style="font-size:0.78rem;color:var(--muted);text-align:center" id="sim-ex-label">45 menit</div>
          </div>
          <div class="form-group">
            <label class="form-label">😴 Tidur (jam)</label>
            <input type="range" class="form-input" min="0" max="12" step="0.5" value="7.5" id="sim-sleep" oninput="calcScore()" style="padding:0;border:none;background:transparent;cursor:pointer">
            <div style="font-size:0.78rem;color:var(--muted);text-align:center" id="sim-sleep-label">7.5 jam</div>
          </div>
        </div>
        <div id="sim-result" style="padding:1rem;background:var(--cream);border-radius:12px;display:flex;align-items:center;justify-content:space-between">
          <div style="font-size:0.85rem;color:var(--muted)">Perkiraan Skor:</div>
          <div id="sim-score" style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:800;color:var(--red)">87</div>
          <div id="sim-status" class="score-status score-good">✓ SEHAT</div>
        </div>
      </div>
    </div>
  </div>

  <!-- ═══ ARTICLE & COMMUNITY ═══ -->
  <div class="page" id="page-article">
    <div style="padding:2rem">
      <!-- TABS -->
      <div class="filter-tabs" id="article-tabs">
        <div class="filter-tab active" onclick="switchTab(this,'articles-section')">📰 Artikel</div>
        <div class="filter-tab" onclick="switchTab(this,'community-section')">👥 Community</div>
      </div>

      <!-- ARTICLES -->
      <div id="articles-section">
        <div class="filter-tabs">
          <div class="filter-tab active">Semua</div>
          <div class="filter-tab">Nutrisi</div>
          <div class="filter-tab">Olahraga</div>
          <div class="filter-tab">Mental Health</div>
          <div class="filter-tab">Diet</div>
          <div class="filter-tab">Bulking</div>
        </div>
        <div class="article-grid">
          <div class="article-card">
            <div class="aricle-img" style="background:linear-gradient(135deg,#f5efe6,#ddd0c0)">🥗</div>
            <div class="article-body">
              <div class="article-cat">Nutrisi</div> 
              <a class="article-title" href="https://www.alodokter.com/cermat-memilih-makanan-yang-mengandung-protein">5 Resep Salad Sehat yang Mudah Dibuat di Rumah</a>
              <div class="article-date"><p><a class="link-opacity-10" href="https://www.alodokter.com/cermat-memilih-makanan-yang-mengandung-protein">Link opacity 10</a></p></div>
            </div>
          </div>
          <div class="article-card">
            <div class="article-img" style="background:linear-gradient(135deg,#fce4dc,#e8d5cc)">🧠</div>
            <div class="article-body">
              <div class="article-cat">Mental Health</div>
              <div class="article-title">Mengatasi Emotional Eating: Strategi Mindful Eating yang Efektif</div>
              <div class="article-date">📅 21 April 2026 · 7 menit baca</div>
            </div>
          </div>
          <div class="article-card">
            <div class="article-img" style="background:linear-gradient(135deg,#e0ede6,#c8dbd0)">🏃</div>
            <div class="article-body">
              <div class="article-cat">Olahraga</div>
              <div class="article-title">HIIT vs Cardio Steady-State: Mana yang Lebih Efektif untuk Lemak?</div>
              <div class="article-date">📅 20 April 2026 · 6 menit baca</div>
            </div>
          </div>
          <div class="article-card">
            <div class="article-img" style="background:linear-gradient(135deg,#f5efe6,#e8d5cc)">😴</div>
            <div class="article-body">
              <div class="article-cat">Recovery</div>
              <div class="article-title">Kenapa Tidur Berkualitas Sama Pentingnya dengan Olahraga</div>
              <div class="article-date">📅 19 April 2026 · 4 menit baca</div>
            </div>
          </div>
        </div>
      </div>

      <!-- COMMUNITY -->
      <div id="community-section" style="display:none">
        <!-- POST INPUT -->
        <div class="card" style="margin-bottom:1rem">
          <div class="form-group" style="margin-bottom:0.7rem">
            <textarea class="form-input" id="post-input" rows="3" placeholder="Bagikan cerita, pengalaman, atau tips kesehatan kamu..."></textarea>
          </div>
          <div style="display:flex;justify-content:flex-end">
            <button class="btn btn-primary btn-sm" onclick="addPost()">📤 Posting</button>
          </div>
        </div>
        <!-- POSTS -->
        <div id="posts-list">
          <div class="post-card">
            <div class="post-header">
              <div class="post-avatar" style="background:linear-gradient(135deg,#C0392B,#8B6343)">RP</div>
              <div><div class="post-name">Rina P.</div><div class="post-time">2 jam lalu</div></div>
            </div>
            <div class="post-text">Hari ini berhasil lari 5km tanpa berhenti! Bulan lalu saya bahkan tidak bisa lari 1km. Konsistensi itu kuncinya teman-teman. Mulai dari yang kecil dan jangan bandingkan diri dengan orang lain. 💪🔥</div>
            <div class="post-actions"><div class="post-action">❤️ 24 Suka</div><div class="post-action">💬 8 Komentar</div></div>
          </div>
          <div class="post-card">
            <div class="post-header">
              <div class="post-avatar" style="background:linear-gradient(135deg,#8B6343,#C8A882)">DS</div>
              <div><div class="post-name">Dika S.</div><div class="post-time">5 jam lalu</div></div>
            </div>
            <div class="post-text">Tips untuk teman-teman yang lagi bulking: jangan lupa makan dalam porsi kecil tapi sering! Saya biasa makan 5-6 kali sehari dengan protein tinggi. Sudah 3 bulan dan naik 4kg massa otot. Senang banget progress-nya keliatan di grafik Healthy-Care 📊</div>
            <div class="post-actions"><div class="post-action">❤️ 31 Suka</div><div class="post-action">💬 12 Komentar</div></div>
          </div>
          <div class="post-card">
            <div class="post-header">
              <div class="post-avatar" style="background:linear-gradient(135deg,#C8A882,#3E2011)">SN</div>
              <div><div class="post-name">Syafa N.</div><div class="post-time">1 hari lalu</div></div>
            </div>
            <div class="post-text">Minggu ini berhasil maintain Lifestyle Score di atas 90 selama 5 hari berturut-turut! Reward dari sistem — boleh makan es krim favorit besok 🍦 Motivasi banget fitur ini. Sekarang jadi lebih semangat jaga pola hidup sehat.</div>
            <div class="post-actions"><div class="post-action">❤️ 47 Suka</div><div class="post-action">💬 19 Komentar</div></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ═══ CONSULTATION ═══ -->
  <div class="page" id="page-consultation">
    <div style="padding:2rem">
      <div class="grid-2">
        <!-- DOKTER LIST -->
        <div>
          <div class="card" style="margin-bottom:1rem">
            <div class="card-header">
              <div class="card-title">Konsultasi Dokter</div>
              <span class="badge badge-green">3 Online</span>
            </div>
            <div class="doctor-card">
              <div class="doctor-avatar" style="background:rgba(192,57,43,0.1)">👨‍⚕️</div>
              <div>
                <div class="doctor-name">dr. Ahmad Fauzi, Sp.GK</div>
                <div class="doctor-spec">Gizi Klinik · Nutrisi Olahraga</div>
              </div>
              <div class="doctor-avail">Online</div>
            </div>
            <div class="doctor-card">
              <div class="doctor-avatar" style="background:rgba(139,99,67,0.1)">👩‍⚕️</div>
              <div>
                <div class="doctor-name">dr. Sari Dewi, M.Kes</div>
                <div class="doctor-spec">Kedokteran Olahraga · Fisioterapi</div>
              </div>
              <div class="doctor-avail">Online</div>
            </div>
            <div class="doctor-card">
              <div class="doctor-avatar" style="background:rgba(200,168,130,0.2)">👨‍⚕️</div>
              <div>
                <div class="doctor-name">dr. Budi Santoso, Sp.KJ</div>
                <div class="doctor-spec">Psikiatri · Kesehatan Mental</div>
              </div>
              <div class="doctor-avail">Online</div>
            </div>
            <div class="doctor-card" style="opacity:0.6">
              <div class="doctor-avatar" style="background:rgba(0,0,0,0.05)">👩‍⚕️</div>
              <div>
                <div class="doctor-name">dr. Lia Permata, M.Gizi</div>
                <div class="doctor-spec">Dietisien · Meal Planning</div>
              </div>
              <div style="margin-left:auto;font-size:0.72rem;color:var(--muted)">Besok 09:00</div>
            </div>
          </div>

          <!-- JADWAL -->
          <div class="card">
            <div class="card-title" style="margin-bottom:0.8rem">Buat Janji Konsultasi</div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">📅 Tanggal</label>
                <input type="date" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">⏰ Jam</label>
                <select class="form-input form-select">
                  <option>09:00</option><option>10:00</option>
                  <option>13:00</option><option>14:00</option><option>15:00</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">📝 Keluhan / Topik</label>
              <input type="text" class="form-input" placeholder="Contoh: Program diet defisit kalori untuk pemula">
            </div>
            <button class="btn btn-primary">📅 Buat Janji</button>
          </div>
        </div>

        <!-- AI CHAT -->
        <div>
          <div class="card-title" style="margin-bottom:0.8rem;font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:700;color:var(--brown-dark)">🤖 AI Mental Support</div>
          <div class="chat-wrap">
            <div class="chat-header">
              <div class="chat-ai-dot"></div>
              <div>
                <div style="font-weight:600;font-size:0.88rem">HealthyBot AI</div>
                <div style="font-size:0.7rem;opacity:0.6">Asisten kesehatan & mental Anda</div>
              </div>
            </div>
            <div class="chat-body" id="chat-body">
              <div class="chat-msg">
                <div class="msg-avatar ai-av">🤖</div>
                <div class="msg-bubble ai">Halo! Saya HealthyBot 👋 Saya siap membantu perjalanan kesehatan kamu. Mau cerita soal apa hari ini? Bisa soal nutrisi, workout, atau kalau kamu lagi butuh teman curhat juga boleh 😊</div>
              </div>
              <div class="chat-msg user">
                <div class="msg-avatar">BA</div>
                <div class="msg-bubble user">Aku lagi stres dan pengen banyak makan terus haha</div>
              </div>
              <div class="chat-msg">
                <div class="msg-avatar ai-av">🤖</div>
                <div class="msg-bubble ai">Wajar banget kok! Emotional eating itu sangat umum terjadi saat stres 🧠 Yang penting kamu menyadarinya. Coba dulu tarik napas dalam 4 detik, tahan 4 detik, keluarkan 6 detik. Mau cerita stres-nya karena apa? Kita atasi bareng yuk 💪</div>
              </div>
            </div>
            <div class="chat-input-wrap">
              <input type="text" class="chat-input" id="chat-input" placeholder="Ketik pesan..." onkeypress="if(event.key==='Enter')sendChat()">
              <button class="chat-send" onclick="sendChat()">➤</button>
            </div>
          </div>

          <!-- QUICK TOPICS -->
          <div style="margin-top:0.8rem">
            <div style="font-size:0.75rem;color:var(--muted);margin-bottom:0.5rem;font-weight:600">💡 Topik cepat:</div>
            <div style="display:flex;gap:0.4rem;flex-wrap:wrap">
              <button class="btn btn-outline btn-sm" onclick="quickChat('Tips mengatasi stress eating')">😰 Stress eating</button>
              <button class="btn btn-outline btn-sm" onclick="quickChat('Motivasi workout hari ini')">💪 Motivasi</button>
              <button class="btn btn-outline btn-sm" onclick="quickChat('Saya sedang bingung program diet')">🥗 Diet</button>
              <button class="btn btn-outline btn-sm" onclick="quickChat('Susah tidur nyenyak')">😴 Tidur</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>

<script>
// ─── PAGE NAVIGATION ───────────────────────────
const pageTitles = {
  dashboard: ['Dashboard', 'Selamat datang kembali, Bintang! 👋'],
  tracker:   ['Life Tracker', 'Catat aktivitas kesehatan harian Anda'],
  workout:   ['Workout Planner', 'Rencanakan dan lacak sesi latihan Anda'],
  lifestyle: ['Lifestyle Score', 'Pantau skor gaya hidup sehat Anda'],
  article:   ['Article & Community', 'Edukasi dan berbagi bersama komunitas'],
  consultation: ['Consultation', 'Konsultasi dokter & dukungan mental AI'],
};
function showPage(id, el) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  document.getElementById('page-' + id).classList.add('active');
  el.classList.add('active');
  document.getElementById('page-title').textContent = pageTitles[id][0];
  document.getElementById('page-sub').textContent = pageTitles[id][1];
}

// ─── DATE ──────────────────────────────────────
function initDate() {
  const now = new Date();
  const opts = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
  document.getElementById('today-date').textContent = now.toLocaleDateString('id-ID', opts);
  const dateInput = document.getElementById('tracker-date');
  if (dateInput) dateInput.value = now.toISOString().slice(0,10);
  const timeInput = document.getElementById('tracker-time');
  if (timeInput) timeInput.value = now.toTimeString().slice(0,5);
}
initDate();

// ─── LIFE TRACKER ──────────────────────────────
function saveTracker() {
  const air = +document.getElementById('t-air').value;
  const kalIn = +document.getElementById('t-kal-in').value;
  const kalOut = +document.getElementById('t-kal-out').value;
  const tidur = +document.getElementById('t-tidur').value;
  const net = kalIn - kalOut;
  document.getElementById('summary-kalori-net').querySelector('div').textContent = net.toLocaleString();
  document.getElementById('s-air').textContent = air + ' ml';
  document.getElementById('s-tidur').textContent = tidur + ' jam';
  document.getElementById('tracker-success').style.display = 'block';
  setTimeout(() => document.getElementById('tracker-success').style.display = 'none', 3000);
}
function resetTracker() {
  ['t-air','t-kal-in','t-olahraga','t-tidur','t-note'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.value = '';
  });
}

// ─── WORKOUT PLANNER ──────────────────────────
let selectedWorkout = { name:'Lari', cal:8, emoji:'🏃' };
let timerInterval = null, timerSeconds = 1800, timerRunning = false;

function selectWorkout(el, name, cal, emoji) {
  document.querySelectorAll('.workout-item').forEach(i => i.classList.remove('selected'));
  el.classList.add('selected');
  selectedWorkout = { name, cal, emoji };
  document.getElementById('timer-workout-name').textContent = emoji + ' ' + name.toUpperCase();
  updateDuration(document.getElementById('workout-duration').value);
  const guides = {
    'Lari': '<strong>🏃 Lari:</strong><br>1. Pemanasan 5 menit jalan cepat<br>2. Lari 65-75% denyut jantung maks<br>3. Jaga postur tegak, pandangan depan<br>4. Pendinginan 5 menit<br><em style="color:var(--muted)">💡 Minum air tiap 15 menit</em>',
    'Bersepeda': '<strong>🚴 Bersepeda:</strong><br>1. Setel ketinggian sadel dengan benar<br>2. Kayuh ritme konsisten 80-100 rpm<br>3. Jaga punggung tetap lurus<br>4. Sesi cooling down 5 menit<br><em style="color:var(--muted)">💡 Pakai helm & pelindung lutut</em>',
    'Berenang': '<strong>🏊 Berenang:</strong><br>1. Pemanasan renang pelan 2 lap<br>2. Fokus teknik napas yang benar<br>3. Ganti gaya tiap 4 lap untuk variasi<br>4. Cooling down dengan renang santai<br><em style="color:var(--muted)">💡 Istirahat 30 detik tiap 100m</em>',
    'Angkat Beban': '<strong>🏋️ Angkat Beban:</strong><br>1. Lakukan 3-4 set per latihan<br>2. Rep range 8-12 untuk hipertrofi<br>3. Istirahat 60-90 detik antar set<br>4. Prioritaskan form daripada beban<br><em style="color:var(--muted)">💡 Progressive overload kuncinya</em>',
    'Yoga': '<strong>🧘 Yoga:</strong><br>1. Mulai dengan Child\'s Pose 2 menit<br>2. Ikuti urutan: duduk → berdiri → lantai<br>3. Fokus pada napas, jangan paksakan<br>4. Tutup dengan Savasana 5 menit<br><em style="color:var(--muted)">💡 Konsistensi lebih penting dari fleksibilitas</em>',
    'HIIT': '<strong>⚡ HIIT:</strong><br>1. Pemanasan 5 menit wajib!<br>2. Interval: 20 detik intense, 10 detik rest<br>3. Lakukan 8 putaran (4 menit total)<br>4. Istirahat 2 menit antar sirkuit<br><em style="color:var(--muted)">💡 Jangan HIIT lebih dari 3x/minggu</em>',
  };
  document.getElementById('workout-guide').innerHTML = guides[name] || '';
}

function updateDuration(val) {
  document.getElementById('duration-label').textContent = val + ' menit';
  timerSeconds = val * 60;
  if (!timerRunning) updateTimerDisplay();
  const estCal = Math.round(val * selectedWorkout.cal);
  document.getElementById('est-cal').textContent = estCal + ' kal';
}

function updateTimerDisplay() {
  const m = Math.floor(timerSeconds / 60).toString().padStart(2,'0');
  const s = (timerSeconds % 60).toString().padStart(2,'0');
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
function pauseTimer() { clearInterval(timerInterval); timerRunning = false; }
function resetTimer() {
  clearInterval(timerInterval); timerRunning = false;
  timerSeconds = +document.getElementById('workout-duration').value * 60;
  updateTimerDisplay();
}
function finishWorkout() {
  pauseTimer();
  const dur = document.getElementById('workout-duration').value;
  const cal = Math.round(dur * selectedWorkout.cal);
  document.getElementById('final-cal').textContent = cal;
  document.getElementById('workout-result').style.display = 'block';
  document.getElementById('t-kal-out').value = cal;
}

// ─── LIFESTYLE SCORE ──────────────────────────
function calcScore() {
  const air = +document.getElementById('sim-air').value;
  const ex = +document.getElementById('sim-ex').value;
  const sleep = +document.getElementById('sim-sleep').value;
  document.getElementById('sim-air-label').textContent = air + ' ml';
  document.getElementById('sim-ex-label').textContent = ex + ' menit';
  document.getElementById('sim-sleep-label').textContent = sleep + ' jam';
  const airScore  = Math.min(25, (air / 2000) * 25);
  const exScore   = Math.min(25, (ex / 60) * 25);
  const sleepScore = Math.min(25, (sleep >= 7 ? 25 : (sleep/7)*25));
  const total = Math.round(airScore + exScore + sleepScore + 20);
  document.getElementById('sim-score').textContent = Math.min(100, total);
  const isGood = total >= 70;
  const statusEl = document.getElementById('sim-status');
  statusEl.textContent = isGood ? '✓ SEHAT' : '⚠ KURANG';
  statusEl.className = 'score-status ' + (isGood ? 'score-good' : 'score-bad');
}

// ─── ARTICLE TABS ─────────────────────────────
function switchTab(el, sectionId) {
  document.querySelectorAll('#article-tabs .filter-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  ['articles-section','community-section'].forEach(id => {
    document.getElementById(id).style.display = id === sectionId ? 'block' : 'none';
  });
}

// ─── COMMUNITY ─────────────────────────────────
function addPost() {
  const input = document.getElementById('post-input');
  const text = input.value.trim();
  if (!text) return;
  const html = `<div class="post-card">
    <div class="post-header">
      <div class="post-avatar" style="background:linear-gradient(135deg,#C0392B,#3E2011)">BA</div>
      <div><div class="post-name">A. (Kamu)</div><div class="post-time">Baru saja</div></div>
    </div>
    <div class="post-text">${text}</div>
    <div class="post-actions"><div class="post-action">❤️ 0 Suka</div><div class="post-action">💬 0 Komentar</div></div>
  </div>`;
  document.getElementById('posts-list').insertAdjacentHTML('afterbegin', html);
  input.value = '';
}

// ─── AI CHAT ──────────────────────────────────
async function sendChat() {
    const input = document.getElementById('chat-input');
    const body = document.getElementById('chat-body');
    const text = input.value.trim();

    if (!text) return;

    // 1. Tampilkan pesan user
    body.insertAdjacentHTML('beforeend', `
        <div class="chat-msg user">
            <div class="msg-avatar">BA</div>
            <div class="msg-bubble user">${text}</div>
        </div>
    `);
    
    input.value = ''; // Bersihkan input
    body.scrollTop = body.scrollHeight;

    // 2. Indikator Loading
    const loadingId = 'loading-msg-' + Date.now();
    body.insertAdjacentHTML('beforeend', `
        <div id="${loadingId}" class="chat-msg">
            <div class="msg-avatar ai-av">🤖</div>
            <div class="msg-bubble ai">...</div>
        </div>
    `);
    body.scrollTop = body.scrollHeight;

    // 3. Kirim ke API
    try {
        const response = await fetch('/ask-gemini', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ prompt: text })
        });

        const data = await response.json();
        
        // 4. Hapus loading dan tampilkan jawaban
        document.getElementById(loadingId).remove();
        
        body.insertAdjacentHTML('beforeend', `
            <div class="chat-msg">
                <div class="msg-avatar ai-av">🤖</div>
                <div class="msg-bubble ai">${data.answer}</div>
            </div>
        `);

    } catch (error) {
        document.getElementById(loadingId).remove();
        alert("Terjadi kesalahan koneksi.");
        console.error(error);
    }
    
    body.scrollTop = body.scrollHeight;
}

</script>
</body>
</html>@extends('layouts.app')
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
