<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HealthyCare | @yield('title', 'Dashboard')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  @stack('styles')
  <style>
    /* ─── CSS VARIABLES ───────────────────────────── */
    :root {
      --white: #FEFCF9;
      --cream: #F5EFE6;
      --brown-light: #C8A882;
      --brown-mid: #8B6343;
      --brown-dark: #3E2011;
      --red: #C0392B;
      --red-light: #E74C3C;
      --text: #2C1A0E;
      --muted: #7D6555;
      --border: #DDD0C0;
      --card: #FFFFFF;
      --sidebar-w: 230px;
    }

    /* ─── RESET ───────────────────────────────────── */
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
    a { text-decoration: none; }

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
      letter-spacing: -0.5px; line-height: 1.1;
    }
    .logo-text span { color: var(--brown-light); }
    .logo-sub { font-size: 0.68rem; color: rgba(255,255,255,0.4); margin-top: 2px; letter-spacing: 1px; text-transform: uppercase; }

    .nav-section { padding: 1.2rem 1rem 0.5rem; }
    .nav-label { font-size: 0.62rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.3); padding: 0 0.5rem; margin-bottom: 0.5rem; }

    .nav-item {
      display: flex; align-items: center; gap: 0.75rem;
      padding: 0.7rem 0.8rem; border-radius: 10px;
      transition: all 0.2s;
      color: rgba(255,255,255,0.55);
      font-size: 0.88rem; font-weight: 500;
      margin-bottom: 2px;
    }
    .nav-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.85); }
    .nav-item.active {
      background: var(--red);
      color: white; font-weight: 600;
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
      transition: background 0.2s; margin-bottom: 0.5rem;
    }
    .user-chip:hover { background: rgba(255,255,255,0.07); }
    .avatar-sm {
      width: 34px; height: 34px; border-radius: 50%;
      background: linear-gradient(135deg, var(--brown-light), var(--red));
      display: flex; align-items: center; justify-content: center;
      font-size: 0.85rem; font-weight: 700; color: white; flex-shrink: 0;
    }
    .user-name { font-size: 0.82rem; font-weight: 600; color: rgba(255,255,255,0.8); }
    .user-role { font-size: 0.68rem; color: rgba(255,255,255,0.35); }
    .logout-btn {
      width: 100%; text-align: left; background: none; border: none; cursor: pointer;
      display: flex; align-items: center; gap: 0.75rem;
      padding: 0.6rem 0.8rem; border-radius: 10px;
      color: rgba(255,255,255,0.4); font-size: 0.82rem;
      font-family: inherit; transition: all 0.2s;
    }
    .logout-btn:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.7); }

    /* ─── MAIN ────────────────────────────────────── */
    .main { margin-left: var(--sidebar-w); flex: 1; min-height: 100vh; display: flex; flex-direction: column; }

    /* ─── TOPBAR ──────────────────────────────────── */
    .topbar {
      display: flex; align-items: center; justify-content: space-between;
      padding: 1.2rem 2rem;
      background: var(--white);
      border-bottom: 1px solid var(--border);
      position: sticky; top: 0; z-index: 100;
    }
    .topbar-left h1 { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; color: var(--brown-dark); }
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
      cursor: pointer; font-size: 1rem; transition: background 0.2s;
    }
    .notification-btn:hover { background: var(--border); }

    /* ─── PAGE WRAPPER ────────────────────────────── */
    .page-wrapper { padding: 2rem; flex: 1; }

    /* ─── CARD ────────────────────────────────────── */
    .card { background: var(--card); border-radius: 16px; border: 1px solid var(--border); padding: 1.4rem; }
    .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
    .card-title { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 700; color: var(--brown-dark); }
    .card-sub { font-size: 0.76rem; color: var(--muted); margin-top: 2px; }
    .divider { height: 1px; background: var(--border); margin: 1.2rem 0; }

    /* ─── BADGES ──────────────────────────────────── */
    .badge { padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.72rem; font-weight: 600; }
    .badge-red { background: rgba(192,57,43,0.1); color: var(--red); }
    .badge-brown { background: var(--cream); color: var(--brown-mid); }
    .badge-green { background: rgba(39,174,96,0.1); color: #27ae60; }

    /* ─── BUTTONS ─────────────────────────────────── */
    .btn {
      padding: 0.65rem 1.4rem; border-radius: 10px;
      font-family: inherit; font-size: 0.88rem; font-weight: 600;
      cursor: pointer; border: none; transition: all 0.2s;
      display: inline-flex; align-items: center; gap: 0.4rem;
    }
    .btn-primary { background: var(--red); color: white; box-shadow: 0 4px 12px rgba(192,57,43,0.3); }
    .btn-primary:hover { background: #a93226; transform: translateY(-1px); }
    .btn-outline { background: transparent; color: var(--brown-mid); border: 1.5px solid var(--border); }
    .btn-outline:hover { border-color: var(--brown-mid); background: var(--cream); }
    .btn-brown { background: var(--brown-dark); color: white; }
    .btn-brown:hover { background: #5a300f; transform: translateY(-1px); }
    .btn-sm { padding: 0.45rem 0.9rem; font-size: 0.8rem; border-radius: 8px; }

    /* ─── FORM ELEMENTS ───────────────────────────── */
    .form-group { margin-bottom: 1rem; }
    .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--brown-mid); margin-bottom: 0.4rem; }
    .form-input {
      width: 100%; padding: 0.65rem 0.9rem;
      border: 1.5px solid var(--border); border-radius: 10px;
      font-family: inherit; font-size: 0.88rem; color: var(--text);
      background: var(--white); transition: border-color 0.2s; outline: none;
    }
    .form-input:focus { border-color: var(--brown-mid); }
    .form-select { appearance: none; cursor: pointer; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; }
    .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.8rem; }

    /* ─── GRID HELPERS ────────────────────────────── */
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem; }
    .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem; }
    .grid-65 { display: grid; grid-template-columns: 1.8fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem; }

    /* ─── STAT CARDS ──────────────────────────────── */
    .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .stat-card {
      background: var(--card); border-radius: 16px; padding: 1.3rem 1.4rem;
      border: 1px solid var(--border); transition: transform 0.2s, box-shadow 0.2s;
      position: relative; overflow: hidden;
    }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--red); }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(62,32,17,0.1); }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; background: var(--cream); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 0.8rem; }
    .stat-val { font-family: 'Playfair Display', serif; font-size: 1.7rem; font-weight: 700; color: var(--brown-dark); line-height: 1; }
    .stat-lbl { font-size: 0.75rem; color: var(--muted); margin-top: 0.3rem; }
    .stat-change { font-size: 0.72rem; font-weight: 600; margin-top: 0.4rem; display: inline-flex; align-items: center; gap: 2px; }
    .stat-change.up { color: #27ae60; }
    .stat-change.down { color: var(--red); }

    /* ─── PROGRESS BARS ───────────────────────────── */
    .progress-item { margin-bottom: 0.9rem; }
    .progress-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.3rem; }
    .progress-name { font-size: 0.82rem; font-weight: 500; color: var(--text); }
    .progress-val { font-size: 0.78rem; font-weight: 600; color: var(--brown-mid); }
    .progress-bar { height: 8px; background: var(--cream); border-radius: 4px; overflow: hidden; }
    .progress-fill { height: 100%; border-radius: 4px; transition: width 1s ease; }

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

    /* ─── WORKOUT ─────────────────────────────────── */
    .workout-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.8rem; margin-bottom: 1rem; }
    .workout-item { border: 1.5px solid var(--border); border-radius: 12px; padding: 1rem; cursor: pointer; transition: all 0.2s; text-align: center; }
    .workout-item:hover, .workout-item.selected { border-color: var(--red); background: rgba(192,57,43,0.07); }
    .workout-emoji { font-size: 1.8rem; margin-bottom: 0.4rem; }
    .workout-name { font-size: 0.82rem; font-weight: 600; color: var(--brown-dark); }
    .workout-cal { font-size: 0.7rem; color: var(--muted); }

    /* ─── TIMER ───────────────────────────────────── */
    .timer-display { text-align: center; padding: 1.5rem; background: var(--brown-dark); border-radius: 16px; color: white; margin-bottom: 1rem; }
    .timer-time { font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 700; letter-spacing: 2px; color: white; line-height: 1; }
    .timer-label { font-size: 0.75rem; color: rgba(255,255,255,0.5); margin-top: 0.3rem; letter-spacing: 1px; text-transform: uppercase; }
    .timer-controls { display: flex; gap: 0.6rem; justify-content: center; margin-top: 1rem; }
    .timer-btn { padding: 0.45rem 0.9rem; border-radius: 8px; font-family: inherit; font-size: 0.8rem; font-weight: 600; cursor: pointer; border: none; background: rgba(255,255,255,0.15); color: white; transition: background 0.2s; }
    .timer-btn:hover { background: rgba(255,255,255,0.25); }

    /* ─── LIFESTYLE SCORE ─────────────────────────── */
    .score-ring-wrap { text-align: center; padding: 1rem 0; }
    .score-ring-svg { display: block; margin: 0 auto; }
    .score-status { display: inline-block; margin-top: 0.6rem; padding: 0.3rem 1rem; border-radius: 20px; font-size: 0.78rem; font-weight: 700; }
    .score-good { background: rgba(39,174,96,0.15); color: #27ae60; }
    .score-bad { background: rgba(192,57,43,0.15); color: var(--red); }
    .score-neutral { background: rgba(139,99,67,0.15); color: var(--brown-mid); }

    /* ─── REWARD PANEL ────────────────────────────── */
    .reward-panel { border-radius: 14px; padding: 1.2rem; text-align: center; margin-bottom: 1rem; }
    .reward-panel.good { background: linear-gradient(135deg, rgba(39,174,96,0.1), rgba(39,174,96,0.05)); border: 1px solid rgba(39,174,96,0.3); }
    .reward-panel.bad { background: linear-gradient(135deg, rgba(192,57,43,0.1), rgba(192,57,43,0.05)); border: 1px solid rgba(192,57,43,0.3); }
    .reward-emoji { font-size: 2.5rem; margin-bottom: 0.6rem; }
    .reward-title { font-size: 0.9rem; font-weight: 700; margin-bottom: 0.3rem; }
    .reward-desc { font-size: 0.78rem; color: var(--muted); }

    /* ─── ARTICLE CARDS ───────────────────────────── */
    .article-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
    .article-card { border: 1px solid var(--border); border-radius: 14px; overflow: hidden; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; background: var(--white); }
    .article-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(62,32,17,0.1); }
    .article-img { height: 130px; background: var(--cream); display: flex; align-items: center; justify-content: center; font-size: 3rem; }
    .article-body { padding: 1rem; }
    .article-cat { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--red); margin-bottom: 0.4rem; }
    .article-title { font-size: 0.88rem; font-weight: 700; color: var(--brown-dark); line-height: 1.35; margin-bottom: 0.4rem; }
    .article-date { font-size: 0.72rem; color: var(--muted); }

    /* ─── COMMUNITY POSTS ─────────────────────────── */
    .post-card { border: 1px solid var(--border); border-radius: 14px; padding: 1.1rem; background: var(--white); margin-bottom: 0.8rem; }
    .post-header { display: flex; align-items: center; gap: 0.7rem; margin-bottom: 0.7rem; }
    .post-avatar { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700; color: white; flex-shrink: 0; }
    .post-name { font-size: 0.85rem; font-weight: 600; color: var(--brown-dark); }
    .post-time { font-size: 0.7rem; color: var(--muted); }
    .post-text { font-size: 0.84rem; color: var(--text); line-height: 1.6; margin-bottom: 0.7rem; }
    .post-actions { display: flex; gap: 1rem; }
    .post-action { font-size: 0.75rem; color: var(--muted); cursor: pointer; display: flex; align-items: center; gap: 0.3rem; transition: color 0.2s; }
    .post-action:hover { color: var(--red); }

    /* ─── DOCTOR / CONSULTATION ───────────────────── */
    .doctor-card { display: flex; align-items: center; gap: 1rem; border: 1px solid var(--border); border-radius: 14px; padding: 1rem; cursor: pointer; transition: all 0.2s; background: var(--white); margin-bottom: 0.8rem; }
    .doctor-card:hover { border-color: var(--red); background: rgba(192,57,43,0.02); }
    .doctor-avatar { width: 50px; height: 50px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
    .doctor-name { font-size: 0.9rem; font-weight: 700; color: var(--brown-dark); }
    .doctor-spec { font-size: 0.75rem; color: var(--muted); }
    .doctor-avail { margin-left: auto; font-size: 0.72rem; font-weight: 600; color: #27ae60; background: rgba(39,174,96,0.1); padding: 0.2rem 0.6rem; border-radius: 20px; }

    /* ─── AI CHAT ─────────────────────────────────── */
    .chat-wrap { border: 1px solid var(--border); border-radius: 14px; overflow: hidden; background: var(--white); display: flex; flex-direction: column; height: 380px; }
    .chat-header { padding: 0.9rem 1.1rem; background: var(--brown-dark); color: white; display: flex; align-items: center; gap: 0.7rem; }
    .chat-ai-dot { width: 10px; height: 10px; border-radius: 50%; background: #2ecc71; animation: pulse 2s infinite; }
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
    .filter-tab { padding: 0.35rem 0.9rem; border-radius: 20px; font-size: 0.78rem; font-weight: 600; cursor: pointer; border: 1.5px solid var(--border); background: var(--white); color: var(--muted); transition: all 0.2s; }
    .filter-tab:hover, .filter-tab.active { border-color: var(--red); background: var(--red); color: white; }

    /* ─── BAR CHART ───────────────────────────────── */
    .bar-col { display: flex; flex-direction: column; align-items: center; gap: 3px; flex: 1; }
    .bar { width: 100%; border-radius: 6px 6px 0 0; transition: height 0.6s ease; cursor: pointer; }
    .bar:hover { filter: brightness(1.1); }
    .bar-lbl { font-size: 0.6rem; color: var(--muted); }

    /* ─── ANIMATIONS ──────────────────────────────── */
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
    .page-wrapper { animation: fadeIn 0.3s ease; }

    /* ─── SCROLLBAR ───────────────────────────────── */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

    /* ─── RESPONSIVE ──────────────────────────────── */
    @media (max-width: 1100px) {
      .stat-row { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 800px) {
      .sidebar { transform: translateX(-100%); }
      .main { margin-left: 0; }
      .grid-2, .grid-3, .grid-65 { grid-template-columns: 1fr; }
      .workout-grid { grid-template-columns: 1fr 1fr; }
      .article-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

{{-- ═══════════ SIDEBAR ═══════════ --}}
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-text">Healthy<span>Care</span></div>
    <div class="logo-sub">Health Tracker</div>
  </div>

  <nav class="nav-section">
    <div class="nav-label">Menu Utama</div>

    @hasSection('sidebar-nav')
      @yield('sidebar-nav')
    @else
      <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <span class="nav-icon">🏠</span> Dashboard
      </a>
      <a href="{{ route('life-tracker.index') }}" class="nav-item {{ request()->routeIs('life-tracker.*') ? 'active' : '' }}">
        <span class="nav-icon">📊</span> Life Tracker
      </a>
      <a href="{{ route('workout-planner.index') }}" class="nav-item {{ request()->routeIs('workout-planner.*') ? 'active' : '' }}">
        <span class="nav-icon">🏋️</span> Workout Planner
      </a>
      <a href="{{ route('lifestyle-score.index') }}" class="nav-item {{ request()->routeIs('lifestyle-score.*') ? 'active' : '' }}">
        <span class="nav-icon">⭐</span> Lifestyle Score
      </a>
      <a href="{{ route('articles.index') }}" class="nav-item {{ request()->routeIs('articles.*') ? 'active' : '' }}">
        <span class="nav-icon">📰</span> Artikel
      </a>
      <a href="{{ route('community.index') }}" class="nav-item {{ request()->routeIs('community.*') ? 'active' : '' }}">
        <span class="nav-icon">👥</span> Komunitas
      </a>
      <a href="{{ route('consultation.index') }}" class="nav-item {{ request()->routeIs('consultation.*') ? 'active' : '' }}">
        <span class="nav-icon">💬</span> Konsultasi AI
      </a>
    @endif
  </nav>

  <div class="sidebar-footer">
    <div class="user-chip">
      <div class="avatar-sm">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
      <div>
        <div class="user-name">{{ Auth::user()->name }}</div>
        <div class="user-role">{{ ucfirst(Auth::user()->goal ?? 'Member') }}</div>
      </div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout-btn">
        <span>🚪</span> Keluar
      </button>
    </form>
  </div>
</aside>

{{-- ═══════════ MAIN CONTENT ═══════════ --}}
<main class="main">
  {{-- Topbar --}}
  <div class="topbar">
    <div class="topbar-left">
      <h1 id="topbar-title">@yield('page-title', 'Dashboard')</h1>
      <p id="topbar-subtitle">@yield('page-subtitle', '')</p>
    </div>
    <div class="topbar-right">
      <span class="date-chip" id="today-date">—</span>
      <div class="notification-btn" title="Notifikasi">🔔</div>
    </div>
  </div>

  {{-- Page Content --}}
  <div class="page-wrapper">
    @yield('content')
  </div>
</main>

<script>
  // Set tanggal hari ini di topbar
  (function () {
    const opts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('today-date').textContent =
      new Date().toLocaleDateString('id-ID', opts);
  })();
</script>

@stack('scripts')
</body>
</html>
