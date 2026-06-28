<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoopAgricole - Coopérative agricole</title>
    <script src="{{ asset('js/system-theme.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --ink: #172033;
            --muted: #667085;
            --leaf: #b56f24;
            --leaf-dark: #8f5518;
            --navy: #172033;
            --navy-soft: #25324a;
            --field: #f7f4ef;
            --line: #e5ded3;
            --gold: #d99b28;
            --surface: #fff;
            --page-bg: #fbfaf8;
            --nav-bg: rgba(251,250,248,.78);
            --shell-bg: rgba(255,255,255,.94);
            --ghost-bg: #fff;
            --ghost-hover-bg: #fff8ef;
            --feature-bg: #f6e4cc;
            --product-icon-bg: #fff4db;
            --product-media-bg: #f7efe1;
            --card-shadow: rgba(23,32,51,.08);
            --radius: 20px;
        }

        [data-bs-theme="dark"] {
            --ink: #f3f4f6;
            --muted: #aeb7c5;
            --leaf: #d3944a;
            --leaf-dark: #f0b76c;
            --navy: #101827;
            --navy-soft: #1f2937;
            --field: #151c27;
            --line: #2c3545;
            --gold: #e7af48;
            --surface: #111827;
            --page-bg: #0b111c;
            --nav-bg: rgba(11,17,28,.84);
            --shell-bg: rgba(17,24,39,.94);
            --ghost-bg: #111827;
            --ghost-hover-bg: #1b2638;
            --feature-bg: #312313;
            --product-icon-bg: #2c2414;
            --product-media-bg: #172033;
            --card-shadow: rgba(0,0,0,.3);
        }

        body {
            color: var(--ink);
            background: var(--page-bg);
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .public-nav {
            position: sticky;
            top: 0;
            z-index: 20;
            padding: .85rem 0;
            background: var(--nav-bg);
            backdrop-filter: blur(14px);
        }

        .nav-shell {
            background: var(--shell-bg);
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: .65rem .85rem;
            box-shadow: 0 18px 45px var(--card-shadow);
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: linear-gradient(135deg, var(--navy), var(--navy-soft));
            box-shadow: 0 12px 24px rgba(23,32,51,.18);
        }

        .nav-link {
            color: var(--muted);
            font-weight: 750;
            font-size: .92rem;
            border-radius: 999px;
            padding: .55rem .8rem !important;
        }

        .nav-link:hover { color: var(--leaf); }

        .btn-leaf {
            background: var(--leaf);
            border-color: var(--leaf);
            color: #fff;
            font-weight: 800;
            border-radius: 14px;
            box-shadow: 0 12px 24px rgba(181,111,36,.22);
        }

        .btn-leaf:hover {
            background: var(--leaf-dark);
            border-color: var(--leaf-dark);
            color: #fff;
        }

        .btn-ghost {
            border-color: var(--line);
            color: var(--ink);
            background: var(--ghost-bg);
            font-weight: 750;
            border-radius: 14px;
        }

        .btn-ghost:hover {
            border-color: var(--leaf);
            color: var(--leaf-dark);
            background: var(--ghost-hover-bg);
        }

        .user-menu-btn {
            min-width: 168px;
            justify-content: space-between;
            text-transform: none;
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.18);
            color: #fff;
        }

        .account-menu {
            border: 1px solid var(--line);
            background: var(--surface);
            border-radius: 16px;
            padding: .45rem;
            box-shadow: 0 18px 40px var(--card-shadow);
            min-width: 230px;
        }

        .account-menu .dropdown-item {
            border-radius: 11px;
            padding: .6rem .7rem;
            font-weight: 700;
            color: var(--ink);
        }

        .account-menu .dropdown-item:hover {
            background: var(--ghost-hover-bg);
            color: var(--leaf-dark);
        }

        .hero {
            min-height: 650px;
            color: #fff;
            background:
                linear-gradient(90deg, rgba(23, 32, 51, .94), rgba(37, 50, 74, .72), rgba(181, 111, 36, .22)),
                url("https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1800&q=80") center / cover;
            display: flex;
            align-items: center;
        }

        .hero h1 {
            max-width: 780px;
            font-size: clamp(2.35rem, 5vw, 4.8rem);
            line-height: 1.02;
            font-weight: 850;
            letter-spacing: 0;
        }

        .hero-copy {
            max-width: 650px;
            color: rgba(255,255,255,.86);
            font-size: 1.08rem;
        }

        .hero-chip {
            display: inline-flex;
            gap: .5rem;
            align-items: center;
            padding: .48rem .75rem;
            border: 1px solid rgba(255,255,255,.22);
            border-radius: 999px;
            background: rgba(255,255,255,.12);
            font-size: .86rem;
            font-weight: 700;
        }

        .stat-strip {
            margin-top: -58px;
            position: relative;
            z-index: 5;
        }

        .stat-item {
            min-height: 116px;
            border: 1px solid var(--line);
            background: var(--surface);
            border-radius: var(--radius);
            padding: 1.2rem;
            box-shadow: 0 18px 40px var(--card-shadow);
        }

        .stat-item .value {
            font-size: 1.9rem;
            font-weight: 850;
            color: var(--leaf-dark);
        }

        .section {
            padding: 5rem 0;
        }

        .section-soft {
            background: var(--field);
            border-block: 1px solid var(--line);
        }

        .section-title {
            font-weight: 850;
            letter-spacing: 0;
            color: var(--ink);
        }

        .section-kicker {
            color: var(--leaf);
            font-size: .78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .12em;
        }

        .feature-card,
        .product-card,
        .timeline-card {
            height: 100%;
            border: 1px solid var(--line);
            border-radius: var(--radius);
            background: var(--surface);
            padding: 1.25rem;
            box-shadow: 0 18px 40px var(--card-shadow);
        }

        .feature-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--leaf);
            background: var(--feature-bg);
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .product-card {
            display: flex;
            flex-direction: column;
            overflow: hidden;
            padding: 0;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .product-card:hover {
            transform: translateY(-3px);
            border-color: rgba(181,111,36,.45);
            box-shadow: 0 24px 50px var(--card-shadow);
        }

        .product-media {
            position: relative;
            height: 210px;
            background: linear-gradient(135deg, var(--product-media-bg), var(--field));
            overflow: hidden;
        }

        .product-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .product-media-empty {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--leaf);
            font-size: 3rem;
        }

        .product-ribbon {
            position: absolute;
            top: .85rem;
            left: .85rem;
            border-radius: 999px;
            padding: .38rem .65rem;
            background: rgba(23,32,51,.84);
            color: #fff;
            font-size: .72rem;
            font-weight: 850;
            backdrop-filter: blur(8px);
        }

        .product-stock {
            position: absolute;
            right: .85rem;
            bottom: .85rem;
            border-radius: 999px;
            padding: .38rem .65rem;
            background: rgba(255,255,255,.9);
            color: var(--navy);
            font-size: .74rem;
            font-weight: 850;
        }

        [data-bs-theme="dark"] .product-stock {
            background: rgba(17,24,39,.9);
            color: var(--ink);
        }

        .product-body {
            padding: 1rem;
        }

        .timeline-card .date {
            color: var(--leaf);
            font-size: .82rem;
            font-weight: 800;
        }

        .cta-band {
            color: #fff;
            background: radial-gradient(circle at 88% 18%, rgba(217,155,40,.34), transparent 30%), linear-gradient(135deg, var(--navy), var(--navy-soft));
            border-radius: var(--radius);
            padding: 2rem;
        }

        .footer {
            color: rgba(255,255,255,.78);
            background: radial-gradient(circle at 88% 10%, rgba(181,111,36,.28), transparent 28%), linear-gradient(135deg, var(--navy), var(--navy-soft));
            padding: 3.5rem 0 1.4rem;
        }

        .footer-brand {
            color: #fff;
            font-weight: 850;
            font-size: 1.15rem;
        }

        .footer-title {
            color: #fff;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .12em;
            font-weight: 850;
            margin-bottom: .9rem;
        }

        .footer-link {
            display: block;
            color: rgba(255,255,255,.72);
            text-decoration: none;
            margin-bottom: .52rem;
            font-weight: 650;
        }

        .footer-link:hover {
            color: #fff;
        }

        .footer-mark {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.12);
            color: #fff;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,.14);
            margin-top: 2rem;
            padding-top: 1rem;
            font-size: .88rem;
        }

        @media (max-width: 991.98px) {
            .public-nav { padding: .6rem 0; }
            .nav-shell { border-radius: 26px; padding: .7rem; }
            .mobile-menu { margin-top: .75rem; padding-top: .75rem; border-top: 1px solid var(--line); }
            .mobile-menu .nav-link { display: block; padding: .7rem .85rem !important; }
            .nav-actions { width: 100%; display: grid !important; grid-template-columns: 1fr 1fr; gap: .5rem !important; margin-top: .75rem; }
            .nav-actions .btn { width: 100%; }
        }

        @media (max-width: 767.98px) {
            .hero { min-height: 610px; }
            .hero h1 { font-size: 2.4rem; }
            .hero-copy { font-size: 1rem; }
            .stat-strip { margin-top: 0; padding-top: 1rem; background: var(--field); }
            .section { padding: 3.5rem 0; }
            .cta-band { padding: 1.5rem; }
        }
    </style>
</head>
<body>
    <nav class="public-nav">
        <div class="container">
            <div class="nav-shell">
            <div class="d-flex align-items-center justify-content-between gap-3">
                <a href="{{ route('public.home') }}" class="d-flex align-items-center gap-2 text-decoration-none text-body fw-bold">
                    <span class="brand-mark"><i class="bi bi-tree-fill"></i></span>
                    <span>CoopAgricole</span>
                </a>
                <button class="btn btn-ghost d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#homeNavbar" aria-controls="homeNavbar" aria-expanded="false" aria-label="Menu">
                    <i class="bi bi-list"></i>
                </button>
                <div class="d-none d-lg-flex align-items-center gap-2">
                    <a class="nav-link" href="{{ route('public.home') }}">Accueil</a>
                    <a class="nav-link" href="{{ route('catalogue.index') }}">Catalogue</a>
                    <a class="nav-link" href="{{ route('cart.index') }}">Panier</a>
                    @auth
                        @if(auth()->user()->role === 'membre')
                            <a class="nav-link" href="{{ route('buyer.orders') }}">Mes commandes</a>
                        @else
                            <a class="nav-link" href="{{ route('checkout.create') }}">Commande</a>
                        @endif
                    @else
                        <a class="nav-link" href="{{ route('checkout.create') }}">Commande</a>
                    @endauth
                </div>
                <div class="nav-actions d-none d-lg-flex align-items-center gap-2">
                    <a href="{{ route('cart.index') }}" class="btn btn-ghost btn-sm px-3">
                        <i class="bi bi-cart3 me-1"></i> Panier
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
                        @endif
                    @else
                        <a href="{{ route('buyer.login') }}" class="btn btn-ghost btn-sm px-3">Connexion</a>
                        <a href="{{ route('buyer.register') }}" class="btn btn-leaf btn-sm px-3">Inscription</a>
                    @endauth
                </div>
            </div>
            <div class="collapse mobile-menu d-lg-none" id="homeNavbar">
                <a class="nav-link" href="{{ route('public.home') }}">Accueil</a>
                <a class="nav-link" href="{{ route('catalogue.index') }}">Catalogue</a>
                <a class="nav-link" href="{{ route('cart.index') }}">Panier</a>
                @auth
                    @if(auth()->user()->role === 'membre')
                        <a class="nav-link" href="{{ route('buyer.orders') }}">Mes commandes</a>
                    @else
                        <a class="nav-link" href="{{ route('checkout.create') }}">Commande</a>
                    @endif
                @else
                    <a class="nav-link" href="{{ route('checkout.create') }}">Commande</a>
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

    <header class="hero">
        <div class="container">
            <div class="hero-chip mb-3">
                <i class="bi bi-shield-check"></i>
                Gestion centralisée des activités agricoles
            </div>
            <h1>CoopAgricole accompagne les producteurs de la coopérative.</h1>
            <p class="hero-copy mt-3 mb-4">
                Une plateforme web pour présenter la coopérative, valoriser les productions
                et donner accès à un espace de gestion sécurisé pour les membres autorisés.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('catalogue.index') }}" class="btn btn-light fw-bold px-4 py-2">Voir le catalogue</a>
                <a href="{{ route('buyer.register') }}" class="btn btn-outline-light fw-bold px-4 py-2">Créer un compte acheteur</a>
            </div>
        </div>
    </header>

    <section class="stat-strip">
        <div class="container">
            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <div class="stat-item">
                        <div class="value">{{ number_format($stats['membres']) }}</div>
                        <div class="text-muted fw-semibold">Membres actifs</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-item">
                        <div class="value">{{ number_format($stats['produits']) }}</div>
                        <div class="text-muted fw-semibold">Produits suivis</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-item">
                        <div class="value">{{ number_format($stats['recoltes'], 0, ',', ' ') }}</div>
                        <div class="text-muted fw-semibold">Quantités récoltées</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-item">
                        <div class="value">{{ number_format($stats['revenus'], 0, ',', ' ') }}</div>
                        <div class="text-muted fw-semibold">Revenus enregistrés</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="presentation">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="section-kicker mb-2">Présentation</div>
                    <h2 class="section-title mb-3">Une organisation agricole construite autour de la production, de l’entraide et de la transparence.</h2>
                    <p class="text-muted mb-3">
                        La coopérative regroupe des producteurs agricoles qui mutualisent leurs ressources,
                        coordonnent leurs activités, suivent les récoltes et facilitent la commercialisation
                        des produits.
                    </p>
                    <p class="text-muted mb-0">
                        La partie publique informe les visiteurs, tandis que l’espace de gestion permet aux
                        responsables de suivre les membres, les cotisations, les ventes, les dépenses et les réunions.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="feature-card">
                                <div class="feature-icon"><i class="bi bi-people-fill"></i></div>
                                <h5 class="fw-bold">Membres</h5>
                                <p class="text-muted mb-0">Suivi des adhérents, activités agricoles, contacts et statut.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-card">
                                <div class="feature-icon"><i class="bi bi-cash-coin"></i></div>
                                <h5 class="fw-bold">Finances</h5>
                                <p class="text-muted mb-0">Cotisations, dépenses et revenus centralisés pour limiter les erreurs.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-card">
                                <div class="feature-icon"><i class="bi bi-basket-fill"></i></div>
                                <h5 class="fw-bold">Récoltes</h5>
                                <p class="text-muted mb-0">Quantités produites, parcelles et produits agricoles suivis.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-card">
                                <div class="feature-icon"><i class="bi bi-calendar-event-fill"></i></div>
                                <h5 class="fw-bold">Réunions</h5>
                                <p class="text-muted mb-0">Planification, ordre du jour et comptes rendus de coordination.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-soft" id="services">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-7">
                    <div class="section-kicker mb-2">Activités</div>
                    <h2 class="section-title">Ce que la coopérative organise</h2>
                </div>
            </div>
            <div class="row g-3">
                @foreach([
                    ['Culture agricole', 'Organisation des travaux, suivi des campagnes et coordination des producteurs.', 'bi-flower1'],
                    ['Commercialisation', 'Valorisation des récoltes, suivi des ventes et relation avec les clients.', 'bi-shop'],
                    ['Gestion financière', 'Suivi des cotisations, dépenses, revenus et rapports pour la prise de décision.', 'bi-graph-up-arrow'],
                ] as [$title, $text, $icon])
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon"><i class="bi {{ $icon }}"></i></div>
                            <h5 class="fw-bold">{{ $title }}</h5>
                            <p class="text-muted mb-0">{{ $text }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" id="produits">
        <div class="container">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
                <div>
                    <div class="section-kicker mb-2">Produits</div>
                    <h2 class="section-title mb-0">Meilleurs produits du moment</h2>
                </div>
                <div class="text-muted">Produits publiés, disponibles à la commande</div>
            </div>
            <div class="row g-4">
                @forelse($produits as $produit)
                    <div class="col-sm-6 col-lg-4">
                        <div class="product-card">
                            <a href="{{ route('catalogue.show', $produit) }}" class="product-media d-block text-decoration-none">
                                @if($loop->iteration <= 3)
                                    <span class="product-ribbon">
                                        <i class="bi bi-stars me-1"></i> Meilleur produit
                                    </span>
                                @endif
                                @if($produit->image)
                                    <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}">
                                @else
                                    <div class="product-media-empty">
                                        <i class="bi bi-basket-fill"></i>
                                    </div>
                                @endif
                                <span class="product-stock">
                                    Stock {{ number_format($produit->stock_disponible, 0, ',', ' ') }} {{ $produit->unite }}
                                </span>
                            </a>
                            <div class="product-body">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <div>
                                        <h5 class="fw-bold mb-1">{{ $produit->nom }}</h5>
                                        <div class="text-muted small">{{ Str::limit($produit->description ?: 'Produit agricole de la coopérative.', 72) }}</div>
                                    </div>
                                    <span class="badge badge-accent">{{ $produit->unite }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center gap-2 mt-3">
                                    <div class="price fs-4">{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} F</div>
                                    <form method="POST" action="{{ route('cart.store', $produit) }}">
                                        @csrf
                                        <input type="hidden" name="quantite" value="1">
                                        <button class="btn btn-leaf btn-sm">
                                            <i class="bi bi-cart-plus me-1"></i> Ajouter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="feature-card text-muted">Aucun produit n’est encore publié.</div>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('catalogue.index') }}" class="btn btn-ghost px-4">
                    Voir tous les produits <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="section section-soft" id="actualites">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="section-kicker mb-2">Activités récentes</div>
                    <h2 class="section-title mb-4">Suivi agricole</h2>
                    <div class="vstack gap-3">
                        @forelse($activites as $activite)
                            <div class="timeline-card">
                                <div class="date">{{ optional($activite->date_debut)->format('d/m/Y') ?? 'Date à préciser' }}</div>
                                <h5 class="fw-bold mb-1">{{ $activite->type_activite }}</h5>
                                <p class="text-muted mb-0">{{ $activite->description ?: 'Activité agricole enregistrée dans le système.' }}</p>
                            </div>
                        @empty
                            <div class="timeline-card text-muted">Les activités agricoles seront affichées ici après leur enregistrement.</div>
                        @endforelse
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-kicker mb-2">Réunions</div>
                    <h2 class="section-title mb-4">Coordination</h2>
                    <div class="vstack gap-3">
                        @forelse($reunions as $reunion)
                            <div class="timeline-card">
                                <div class="date">{{ optional($reunion->date_reunion)->format('d/m/Y') ?? 'Date à préciser' }}</div>
                                <h5 class="fw-bold mb-1">{{ $reunion->titre }}</h5>
                                <p class="text-muted mb-0">{{ $reunion->ordre_du_jour ?: 'Réunion de coordination de la coopérative.' }}</p>
                            </div>
                        @empty
                            <div class="timeline-card text-muted">Les réunions planifiées seront affichées ici.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="contact">
        <div class="container">
            <div class="cta-band">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <div class="section-kicker text-white-50 mb-2">Espace acheteur</div>
                        <h2 class="fw-bold mb-2">Commandez les produits de la coopérative en quelques étapes.</h2>
                        <p class="mb-0 text-white-50">
                            Créez votre compte, ajoutez les produits au panier et suivez vos commandes depuis votre espace personnel.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('catalogue.index') }}" class="btn btn-light fw-bold px-4 py-2">
                            <i class="bi bi-bag-check me-1"></i> Acheter maintenant
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="footer-mark"><i class="bi bi-tree-fill"></i></span>
                        <span class="footer-brand">CoopAgricole</span>
                    </div>
                    <p class="mb-0">Plateforme de gestion, de suivi et de commercialisation des produits de la coopérative agricole.</p>
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
                    <span class="footer-link">Membres, récoltes et réunions</span>
                </div>
                <div class="col-lg-3">
                    <div class="footer-title">Coopérative</div>
                    <p class="mb-2">Centralisation des cotisations, productions, ventes, dépenses et décisions de réunion.</p>
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
</body>
</html>
