<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CoopAgricole')</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64,">
    <script src="{{ asset('js/system-theme.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @stack('styles')
</head>
<body>

<!-- ══════════ SIDEBAR ══════════ -->
<nav class="sidebar">
    <a class="sidebar-brand" href="{{ route('dashboard') }}">
        <span class="brand-icon"><i class="bi bi-tree-fill"></i></span>
        CoopAgricole
    </a>

    <div class="py-2 flex-grow-1">
        <div class="sidebar-section">Principal</div>
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Tableau de bord
        </a>

        @if(auth()->user()->hasRole(['admin','secretaire']))
        <div class="sidebar-section">Membres & Org.</div>
        <a href="{{ route('membres.index') }}"
           class="nav-link {{ request()->routeIs('membres.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Membres
        </a>
        <a href="{{ route('activites.index') }}"
           class="nav-link {{ request()->routeIs('activites.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard2-check-fill"></i> Activités
        </a>
        <a href="{{ route('reunions.index') }}"
           class="nav-link {{ request()->routeIs('reunions.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-event-fill"></i> Réunions
        </a>
        @endif

        @if(auth()->user()->hasRole(['admin','comptable']))
        <div class="sidebar-section">Finance & Production</div>
        <a href="{{ route('cotisations.index') }}"
           class="nav-link {{ request()->routeIs('cotisations.*') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i> Cotisations
        </a>
        <a href="{{ route('recoltes.index') }}"
           class="nav-link {{ request()->routeIs('recoltes.*') ? 'active' : '' }}">
            <i class="bi bi-basket-fill"></i> Récoltes
        </a>
        <a href="{{ route('ventes.index') }}"
           class="nav-link {{ request()->routeIs('ventes.*') ? 'active' : '' }}">
            <i class="bi bi-cart-check-fill"></i> Ventes
        </a>
        <a href="{{ route('commandes.index') }}"
           class="nav-link {{ request()->routeIs('commandes.*') ? 'active' : '' }}">
            <i class="bi bi-bag-check-fill"></i> Commandes
        </a>
        <a href="{{ route('depenses.index') }}"
           class="nav-link {{ request()->routeIs('depenses.*') ? 'active' : '' }}">
            <i class="bi bi-receipt-cutoff"></i> Dépenses
        </a>
        @endif

        @if(auth()->user()->isAdmin())
        <div class="sidebar-section">Administration</div>
        <a href="{{ route('produits.index') }}"
           class="nav-link {{ request()->routeIs('produits.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam-fill"></i> Produits
        </a>
        <a href="{{ route('users.index') }}"
           class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-person-lock"></i> Utilisateurs
        </a>
        @endif
    </div>

    <!-- Profil bas de sidebar -->
    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div style="width:34px;height:34px;border-radius:.45rem;background:var(--accent-light);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--accent);">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="overflow-hidden flex-grow-1">
                <div class="fw-semibold text-truncate" style="font-size:.82rem;">{{ auth()->user()->name }}</div>
                <div style="font-size:.72rem;color:var(--bs-secondary-color);">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
    </div>
</nav>

<!-- Overlay mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ══════════ MAIN ══════════ -->
<div class="main-content">

    <!-- Topbar -->
    <div class="topbar">
        <div class="d-flex align-items-center gap-2">
            <!-- Hamburger (mobile only) -->
            <button id="sidebarToggle" class="btn btn-outline-secondary" title="Menu">
                <i class="bi bi-list"></i>
            </button>
            <span class="topbar-title">
                @yield('page-title', 'Tableau de bord')
            </span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- Toggle clair / sombre -->
            <button id="themeToggle" class="btn btn-outline-secondary" title="Thème système">
                <i class="bi bi-brightness-high-fill" id="themeIcon"></i>
            </button>
            <!-- Menu utilisateur -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                        style="font-size:.85rem;" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle" style="font-size:1rem;"></i>
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="min-width:190px;">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-semibold" style="font-size:.85rem;">{{ auth()->user()->name }}</div>
                        <div class="text-muted" style="font-size:.75rem;">{{ auth()->user()->email }}</div>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2">
                                <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    <div class="px-4 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 py-2" role="alert">
                <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show py-2">
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-1"></i>
                    <ul class="mb-0 ps-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Contenu -->
    <div class="page-content">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ── Sidebar mobile toggle ────────────────────────
    const sidebar  = document.querySelector('.sidebar');
    const overlay  = document.getElementById('sidebarOverlay');
    const toggler  = document.getElementById('sidebarToggle');

    function openSidebar()  { sidebar.classList.add('sidebar-open');    overlay.classList.add('show'); }
    function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); }

    toggler.addEventListener('click', () =>
        sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar()
    );
    overlay.addEventListener('click', closeSidebar);

    // Fermer auto après clic sur un lien (mobile)
    sidebar.querySelectorAll('.nav-link').forEach(link =>
        link.addEventListener('click', () => { if (window.innerWidth < 992) closeSidebar(); })
    );

    // Fermer si on agrandit la fenêtre
    window.addEventListener('resize', () => { if (window.innerWidth >= 992) closeSidebar(); });
</script>
@stack('scripts')
</body>
</html>
