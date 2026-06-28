<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CoopAgricole')</title>
    <script src="{{ asset('js/system-theme.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --leaf: #b56f24;
            --leaf-dark: #8f5518;
            --navy: #172033;
            --navy-soft: #25324a;
            --field: #f7f4ef;
            --line: #e5ded3;
            --ink: #172033;
            --muted: #667085;
            --surface: #fff;
            --page-bg: #fbfaf8;
            --nav-bg: rgba(251,250,248,.78);
            --shell-bg: rgba(255,255,255,.94);
            --ghost-bg: #fff;
            --ghost-hover-bg: #fff8ef;
            --active-bg: #f4e8d9;
            --product-img-start: #f8f2e8;
            --product-img-end: #eef1f7;
            --badge-color: #7a4612;
            --badge-bg: #f6e4cc;
            --badge-border: #ebcfaa;
            --alert-bg: #fff3df;
            --card-shadow: rgba(23,32,51,.08);
            --radius: 20px;
        }
        [data-bs-theme="dark"] {
            --leaf: #d3944a;
            --leaf-dark: #f0b76c;
            --navy: #101827;
            --navy-soft: #1f2937;
            --field: #151c27;
            --line: #2c3545;
            --ink: #f3f4f6;
            --muted: #aeb7c5;
            --surface: #111827;
            --page-bg: #0b111c;
            --nav-bg: rgba(11,17,28,.84);
            --shell-bg: rgba(17,24,39,.94);
            --ghost-bg: #111827;
            --ghost-hover-bg: #1b2638;
            --active-bg: #2a2118;
            --product-img-start: #1c2635;
            --product-img-end: #171f2c;
            --badge-color: #ffd29a;
            --badge-bg: #332313;
            --badge-border: #5b3a18;
            --alert-bg: #2d2114;
            --card-shadow: rgba(0,0,0,.28);
        }
        body { color: var(--ink); background: var(--page-bg); font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        .shop-nav { position: sticky; top: 0; z-index: 30; padding: .85rem 0; background: var(--nav-bg); backdrop-filter: blur(14px); }
        .nav-shell { background: var(--shell-bg); border: 1px solid var(--line); border-radius: 999px; padding: .65rem .85rem; box-shadow: 0 18px 45px var(--card-shadow); }
        .brand-mark { width: 42px; height: 42px; border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; color: #fff; background: linear-gradient(135deg, var(--navy), var(--navy-soft)); box-shadow: 0 12px 24px rgba(23,32,51,.18); }
        .nav-link { color: var(--muted); font-weight: 750; font-size: .92rem; border-radius: 999px; padding: .55rem .8rem !important; }
        .nav-link:hover, .nav-link.active { color: var(--leaf); }
        .nav-link.active { background: var(--active-bg); }
        .btn-leaf { background: var(--leaf); border-color: var(--leaf); color: #fff; font-weight: 800; border-radius: 14px; box-shadow: 0 12px 24px rgba(181,111,36,.22); }
        .btn-leaf:hover { background: var(--leaf-dark); border-color: var(--leaf-dark); color: #fff; }
        .btn-ghost { border-color: var(--line); color: var(--ink); background: var(--ghost-bg); font-weight: 750; border-radius: 14px; }
        .btn-ghost:hover { border-color: var(--leaf); color: var(--leaf-dark); background: var(--ghost-hover-bg); }
        .user-menu-btn { min-width: 168px; justify-content: space-between; text-transform: none; }
        .user-avatar { width: 28px; height: 28px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; background: rgba(255,255,255,.18); color: #fff; }
        .account-menu { border: 1px solid var(--line); background: var(--surface); border-radius: 16px; padding: .45rem; box-shadow: 0 18px 40px var(--card-shadow); min-width: 230px; }
        .account-menu .dropdown-item { border-radius: 11px; padding: .6rem .7rem; font-weight: 700; color: var(--ink); }
        .account-menu .dropdown-item:hover { background: var(--ghost-hover-bg); color: var(--leaf-dark); }
        .page-hero { background: radial-gradient(circle at 85% 20%, rgba(181,111,36,.35), transparent 34%), linear-gradient(135deg, var(--navy), #26334e); color: #fff; padding: 4.5rem 0 3.5rem; }
        .page-hero h1 { font-weight: 850; letter-spacing: 0; }
        .shop-card { border: 1px solid var(--line); border-radius: var(--radius); background: var(--surface); box-shadow: 0 18px 40px var(--card-shadow); overflow: hidden; color: var(--ink); }
        .product-img { height: 210px; background: linear-gradient(135deg, var(--product-img-start), var(--product-img-end)); border-radius: var(--radius) var(--radius) 0 0; overflow: hidden; }
        .product-img img { width: 100%; height: 100%; object-fit: cover; }
        .price { color: var(--leaf-dark); font-weight: 850; }
        .soft-section { background: var(--field); border-top: 1px solid var(--line); }
        .badge-accent { color: var(--badge-color); background: var(--badge-bg); border: 1px solid var(--badge-border); }
        .text-accent { color: var(--leaf-dark) !important; }
        .footer { color: rgba(255,255,255,.78); background: radial-gradient(circle at 88% 10%, rgba(181,111,36,.28), transparent 28%), linear-gradient(135deg, var(--navy), var(--navy-soft)); padding: 3.5rem 0 1.4rem; margin-top: 4rem; }
        .footer-brand { color: #fff; font-weight: 850; font-size: 1.15rem; }
        .footer-title { color: #fff; font-size: .78rem; text-transform: uppercase; letter-spacing: .12em; font-weight: 850; margin-bottom: .9rem; }
        .footer-link { display: block; color: rgba(255,255,255,.72); text-decoration: none; margin-bottom: .52rem; font-weight: 650; }
        .footer-link:hover { color: #fff; }
        .footer-mark { width: 42px; height: 42px; border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; background: rgba(255,255,255,.12); color: #fff; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.14); margin-top: 2rem; padding-top: 1rem; font-size: .88rem; }
        .table > :not(caption) > * > * { vertical-align: middle; }
        .alert-success { color: var(--badge-color); background: var(--alert-bg); border-color: var(--badge-border); border-radius: 16px; }
        @media (max-width: 991.98px) {
            .shop-nav { padding: .6rem 0; }
            .nav-shell { border-radius: 26px; padding: .7rem; }
            .mobile-menu { margin-top: .75rem; padding-top: .75rem; border-top: 1px solid var(--line); }
            .mobile-menu .nav-link { display: block; padding: .7rem .85rem !important; }
            .nav-actions { width: 100%; display: grid !important; grid-template-columns: 1fr 1fr; gap: .5rem !important; margin-top: .75rem; }
            .nav-actions .btn { width: 100%; }
            .page-hero { padding: 3rem 0 2.5rem; }
            .page-hero h1 { font-size: 2rem; }
            .product-img { height: 180px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    @php $cartCount = collect(session('cart', []))->sum(); @endphp
    <nav class="shop-nav">
        <div class="container">
            <div class="nav-shell">
            <div class="d-flex align-items-center justify-content-between gap-3">
                <a href="{{ route('public.home') }}" class="d-flex align-items-center gap-2 text-decoration-none text-body fw-bold">
                    <span class="brand-mark"><i class="bi bi-tree-fill"></i></span>
                    <span>CoopAgricole</span>
                </a>
                <button class="btn btn-ghost d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar" aria-controls="publicNavbar" aria-expanded="false" aria-label="Menu">
                    <i class="bi bi-list"></i>
                </button>
                <div class="d-none d-lg-flex align-items-center gap-2">
                    <a class="nav-link {{ request()->routeIs('public.home') ? 'active' : '' }}" href="{{ route('public.home') }}">Accueil</a>
                    <a class="nav-link {{ request()->routeIs('catalogue.*') ? 'active' : '' }}" href="{{ route('catalogue.index') }}">Catalogue</a>
                    <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">Panier</a>
                    @auth
                        @if(auth()->user()->role === 'membre')
                            <a class="nav-link {{ request()->routeIs('buyer.orders*') ? 'active' : '' }}" href="{{ route('buyer.orders') }}">Mes commandes</a>
                        @else
                            <a class="nav-link {{ request()->routeIs('checkout.*') ? 'active' : '' }}" href="{{ route('checkout.create') }}">Commande</a>
                        @endif
                    @else
                        <a class="nav-link {{ request()->routeIs('checkout.*') ? 'active' : '' }}" href="{{ route('checkout.create') }}">Commande</a>
                    @endauth
                </div>
                <div class="nav-actions d-none d-lg-flex align-items-center gap-2">
                    <a href="{{ route('cart.index') }}" class="btn btn-ghost btn-sm px-3">
                        <i class="bi bi-cart3 me-1"></i> Panier
                        @if($cartCount > 0)
                            <span class="badge badge-accent ms-1">{{ number_format($cartCount, 0, ',', ' ') }}</span>
                        @endif
                    </a>
                    @auth
                        @if(auth()->user()->role === 'membre')
                            <div class="dropdown">
                                <button class="btn btn-leaf btn-sm px-3 d-flex align-items-center gap-2 user-menu-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="d-flex align-items-center gap-2">
                                        <span class="user-avatar"><i class="bi bi-person-fill"></i></span>
                                        <span>{{ Str::limit(auth()->user()->name, 14) }}</span>
                                    </span>
                                    <i class="bi bi-chevron-down small"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end account-menu">
                                    <li class="px-2 py-2 border-bottom mb-1">
                                        <div class="fw-bold">{{ auth()->user()->name }}</div>
                                        <small class="text-muted">{{ auth()->user()->email }}</small>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('buyer.orders') }}"><i class="bi bi-bag-check me-2"></i>Mes commandes</a></li>
                                    <li><a class="dropdown-item" href="{{ route('catalogue.index') }}"><i class="bi bi-grid me-2"></i>Catalogue</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('buyer.logout') }}">
                                            @csrf
                                            <button class="dropdown-item text-danger" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <span class="btn btn-leaf btn-sm px-3"><i class="bi bi-person-check me-1"></i> Connecté</span>
                        @endif
                    @else
                        <a href="{{ route('buyer.login') }}" class="btn btn-ghost btn-sm px-3">Connexion</a>
                        <a href="{{ route('buyer.register') }}" class="btn btn-leaf btn-sm px-3">Inscription</a>
                    @endauth
                </div>
            </div>
            <div class="collapse mobile-menu d-lg-none" id="publicNavbar">
                <a class="nav-link {{ request()->routeIs('public.home') ? 'active' : '' }}" href="{{ route('public.home') }}">Accueil</a>
                <a class="nav-link {{ request()->routeIs('catalogue.*') ? 'active' : '' }}" href="{{ route('catalogue.index') }}">Catalogue</a>
                <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">Panier</a>
                @auth
                    @if(auth()->user()->role === 'membre')
                        <a class="nav-link {{ request()->routeIs('buyer.orders*') ? 'active' : '' }}" href="{{ route('buyer.orders') }}">Mes commandes</a>
                    @else
                        <a class="nav-link {{ request()->routeIs('checkout.*') ? 'active' : '' }}" href="{{ route('checkout.create') }}">Commande</a>
                    @endif
                @else
                    <a class="nav-link {{ request()->routeIs('checkout.*') ? 'active' : '' }}" href="{{ route('checkout.create') }}">Commande</a>
                @endauth
                <div class="nav-actions d-flex align-items-center gap-2">
                    <a href="{{ route('cart.index') }}" class="btn btn-ghost btn-sm px-3">
                        <i class="bi bi-cart3 me-1"></i> Panier
                    </a>
                    @auth
                        <a href="{{ route('buyer.orders') }}" class="btn btn-ghost btn-sm px-3">Mes commandes</a>
                        <form method="POST" action="{{ route('buyer.logout') }}">
                            @csrf
                            <button class="btn btn-leaf btn-sm px-3" type="submit">Déconnexion</button>
                        </form>
                    @else
                        <a href="{{ route('buyer.login') }}" class="btn btn-ghost btn-sm px-3">Connexion</a>
                        <a href="{{ route('buyer.register') }}" class="btn btn-leaf btn-sm px-3">Inscription</a>
                    @endauth
                </div>
            </div>
            </div>
        </div>
    </nav>

    @if(session('success') || $errors->any())
        <div class="container mt-3">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
        </div>
    @endif

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="footer-mark"><i class="bi bi-tree-fill"></i></span>
                        <span class="footer-brand">CoopAgricole</span>
                    </div>
                    <p class="mb-0">Plateforme de gestion et de valorisation des produits de la coopérative agricole.</p>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="footer-title">Navigation</div>
                    <a class="footer-link" href="{{ route('public.home') }}">Accueil</a>
                    <a class="footer-link" href="{{ route('catalogue.index') }}">Catalogue</a>
                    <a class="footer-link" href="{{ route('cart.index') }}">Panier</a>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="footer-title">Services</div>
                    <a class="footer-link" href="{{ route('checkout.create') }}">Passer une commande</a>
                    <a class="footer-link" href="{{ auth()->check() && auth()->user()->role === 'membre' ? route('buyer.orders') : route('buyer.login') }}">Suivi des commandes</a>
                    <span class="footer-link">Membres, récoltes et ventes</span>
                </div>
                <div class="col-lg-3">
                    <div class="footer-title">Coopérative</div>
                    <p class="mb-2">Gestion centralisée des membres, cotisations, réunions, stocks et revenus.</p>
                    <span class="badge badge-accent"><i class="bi bi-shield-check me-1"></i>Espace sécurisé</span>
                </div>
            </div>
            <div class="footer-bottom d-flex flex-wrap justify-content-between gap-2">
                <div>&copy; {{ date('Y') }} CoopAgricole. Tous droits réservés.</div>
                <div>Application web de gestion coopérative.</div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
