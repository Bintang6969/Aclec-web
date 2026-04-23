<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FitLife') — FitLife</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --fitlife-green: #2ecc71;
            --fitlife-dark:  #1a1a2e;
            --fitlife-mid:   #16213e;
            --fitlife-accent:#0f3460;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--fitlife-dark);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .sidebar-brand .brand-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--fitlife-green);
            text-decoration: none;
        }

        .sidebar-brand .brand-tagline {
            font-size: .72rem;
            color: rgba(255,255,255,.45);
            margin-top: 2px;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,.65);
            padding: .65rem 1.25rem;
            border-radius: 8px;
            margin: 2px .75rem;
            display: flex;
            align-items: center;
            gap: .65rem;
            font-size: .9rem;
            transition: all .2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(46, 204, 113, .15);
        }

        .sidebar .nav-link.active {
            color: var(--fitlife-green);
            font-weight: 600;
        }

        .sidebar .nav-link i { font-size: 1.05rem; width: 20px; }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,.08);
            padding: 1rem;
        }

        /* Main content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: .75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .page-content {
            padding: 1.75rem 1.5rem;
        }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
        }

        .stat-card .icon-box {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
        }

        /* Goal badge */
        .goal-badge {
            font-size: .75rem;
            padding: 3px 10px;
            border-radius: 20px;
        }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

@auth
<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-name d-block">
            <i class="bi bi-activity"></i> FitLife
        </a>
        <div class="brand-tagline">Your Personal Health Assistant</div>
    </div>

    <ul class="nav flex-column pt-2">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('life-tracker.index') }}" class="nav-link {{ request()->routeIs('life-tracker.*') ? 'active' : '' }}">
                <i class="bi bi-journal-check"></i> Life Tracker
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('workout-planner.index') }}" class="nav-link {{ request()->routeIs('workout-planner.*') ? 'active' : '' }}">
                <i class="bi bi-lightning-charge"></i> Workout Planner
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('lifestyle-score.index') }}" class="nav-link {{ request()->routeIs('lifestyle-score.*') ? 'active' : '' }}">
                <i class="bi bi-trophy"></i> Lifestyle Score
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i> Artikel
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('community.index') }}" class="nav-link {{ request()->routeIs('community.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Komunitas
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('consultation.index') }}" class="nav-link {{ request()->routeIs('consultation.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots"></i> Konsultasi AI
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                 style="width:36px;height:36px;font-size:.85rem;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="text-white fw-semibold" style="font-size:.85rem;">{{ Auth::user()->name }}</div>
                <div class="text-muted" style="font-size:.72rem;">
                    @php $goal = Auth::user()->goal; @endphp
                    <span class="badge {{ $goal === 'bulking' ? 'bg-warning text-dark' : ($goal === 'diet' ? 'bg-info text-dark' : 'bg-secondary') }}">
                        {{ ucfirst($goal) }}
                    </span>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</nav>

<!-- Main content -->
<div class="main-content">
    <!-- Topbar -->
    <div class="topbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <h6 class="mb-0 fw-semibold text-dark">@yield('page-title', 'Dashboard')</h6>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small d-none d-sm-block">{{ now()->translatedFormat('l, d F Y') }}</span>
            <a href="{{ route('consultation.index') }}" class="btn btn-sm" style="background:var(--fitlife-green);color:#fff;">
                <i class="bi bi-robot"></i> FitBot
            </a>
        </div>
    </div>

    <!-- Flash messages -->
    <div class="page-content pb-0">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <main class="page-content">
        @yield('content')
    </main>
</div>

@else
<!-- Guest layout topbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background:var(--fitlife-dark, #1a1a2e);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}" style="color:var(--fitlife-green,#2ecc71);">
            <i class="bi bi-activity"></i> FitLife
        </a>
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-success btn-sm">Daftar</a>
        </div>
    </div>
</nav>
<main>
    @yield('content')
</main>
@endauth

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Sidebar mobile toggle
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    if (toggle && sidebar) {
        toggle.addEventListener('click', () => sidebar.classList.toggle('show'));
        document.addEventListener('click', e => {
            if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    }
</script>

@stack('scripts')
</body>
</html>
