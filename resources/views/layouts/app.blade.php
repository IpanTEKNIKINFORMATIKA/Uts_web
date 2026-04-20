<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIAKAD - Sistem Informasi Akademik Universitas Teknologi Bandung">
    <title>@yield('title', 'Sistem Akademik') | SIAKAD UTB</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo"><i class="bi bi-mortarboard-fill"></i></div>
            <div class="brand-info">
                <h5>SIAKAD</h5>
                <span>Universitas Teknologi Bandung</span>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section-title">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill nav-icon"></i><span>Dashboard</span>
            </a>
            <div class="nav-section-title">Master Data</div>
            <a href="{{ route('jurusan.index') }}" class="nav-link {{ request()->routeIs('jurusan.*') ? 'active' : '' }}">
                <i class="bi bi-building nav-icon"></i><span>Jurusan</span>
            </a>
            <a href="{{ route('mahasiswa.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill nav-icon"></i><span>Mahasiswa</span>
            </a>
            <a href="{{ route('matakuliah.index') }}" class="nav-link {{ request()->routeIs('matakuliah.*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark-fill nav-icon"></i><span>Mata Kuliah</span>
            </a>
        </nav>
        <div class="sidebar-user">
            <div class="user-card">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-meta">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">Administrator</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-left"></i> Keluar</button>
            </form>
        </div>
    </aside>

    <main class="main-wrapper">
        <header class="topbar">
            <div class="d-flex align-items-center gap-2">
                <button class="btn-toggle-sidebar" id="toggleSidebar"><i class="bi bi-list"></i></button>
                <div>
                    <div class="page-title">@yield('page-title', 'Dashboard')</div>
                    <div class="page-subtitle">@yield('page-subtitle', '')</div>
                </div>
            </div>
            <div class="topbar-date"><i class="bi bi-calendar3"></i> {{ now()->translatedFormat('l, d F Y') }}</div>
        </header>
        <div class="page-body">
            @if(session('success'))
                <div class="alert alert-toast alert-success alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" style="font-size:.65rem;"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-toast alert-danger alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" style="font-size:.65rem;"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleSidebar')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        });
        document.getElementById('sidebarOverlay')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.remove('show');
            document.getElementById('sidebarOverlay').classList.remove('show');
        });
        setTimeout(() => { document.querySelectorAll('.alert-toast').forEach(el => bootstrap.Alert.getOrCreateInstance(el)?.close()); }, 4500);
    </script>
    @stack('scripts')
</body>
</html>
