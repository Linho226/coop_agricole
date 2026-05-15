<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — CoopAgricole</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64,">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --accent: #070439; --accent-light: #ede9fe; }
        [data-bs-theme="dark"] { --accent-light: rgba(79,70,229,.18); }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bs-body-bg);
        }

        /* Panneau gauche décoratif */
        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 860px;
            min-height: 520px;
            border-radius: 1.2rem;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,.12);
        }
        .login-left {
            flex: 1;
            background: linear-gradient(145deg, var(--accent) 0%, #7c3aed 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 2rem;
            color: #fff;
            gap: 1rem;
        }
        .login-left .logo-circle {
            width: 72px; height: 72px;
            background: rgba(255,255,255,.15);
            border-radius: 1rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem;
            backdrop-filter: blur(6px);
        }
        .login-left h2 { font-size: 1.6rem; font-weight: 800; margin: 0; letter-spacing: -.5px; }
        .login-left p  { font-size: .85rem; opacity: .8; text-align: center; margin: 0; }
        .login-left .feature {
            display: flex; align-items: center; gap: .6rem;
            background: rgba(255,255,255,.12); border-radius: .5rem;
            padding: .5rem .85rem; font-size: .8rem; width: 100%;
        }

        /* Formulaire droite */
        .login-right {
            flex: 1;
            background-color: var(--bs-body-bg);
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-right h4 { font-size: 1.35rem; font-weight: 700; letter-spacing: -.3px; }

        .form-control, .input-group-text {
            border-color: var(--bs-border-color);
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
        }
        .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 .2rem rgba(79,70,229,.15); }

        .btn-accent {
            background-color: var(--accent);
            border-color: var(--accent);
            color: #fff;
            font-weight: 600;
        }
        .btn-accent:hover { background-color: #1b1748; border-color: #4338ca; color: #fff; }

        /* Toggle thème */
        #themeToggle {
            position: fixed; top: 1rem; right: 1rem;
            width: 38px; height: 38px; padding: 0;
            display: flex; align-items: center; justify-content: center;
            border-radius: .5rem; font-size: 1.05rem;
            z-index: 999;
        }

        @media (max-width: 640px) {
            .login-left { display: none; }
            .login-wrapper { max-width: 420px; border-radius: .8rem; }
        }
    </style>
</head>
<body>

    <!-- Toggle thème -->
    <button id="themeToggle" class="btn btn-outline-secondary">
        <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
    </button>

    <div class="login-wrapper">
        <!-- Panneau gauche -->
        <div class="login-left">
            <div class="logo-circle"><i class="bi bi-tree-fill"></i></div>
            <h2>CoopAgricole</h2>
            <p>Système de Gestion<br>Coopérative Agricole</p>
            <div style="width:100%;margin-top:.5rem;display:flex;flex-direction:column;gap:.5rem;">
                <div class="feature"><i class="bi bi-people-fill"></i> Gestion des membres</div>
                <div class="feature"><i class="bi bi-cash-coin"></i> Suivi financier</div>
                <div class="feature"><i class="bi bi-basket-fill"></i> Récoltes & ventes</div>
                <div class="feature"><i class="bi bi-calendar-event-fill"></i> Réunions & activités</div>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="login-right">
            <h4 class="mb-1">Bon retour 👋</h4>
            <p class="text-muted mb-4" style="font-size:.85rem;">Connectez-vous à votre espace</p>

            @if($errors->any())
                <div class="alert alert-danger d-flex align-items-center gap-2 py-2 mb-3">
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Adresse email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="exemple@email.com" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:.85rem;">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control"
                               placeholder="••••••••" required>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check mb-0">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember" style="font-size:.85rem;">Se souvenir de moi</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-accent w-100 py-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Se connecter
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const html    = document.documentElement;
        const btn     = document.getElementById('themeToggle');
        const icon    = document.getElementById('themeIcon');
        const STORAGE = 'coop-theme';

        function applyTheme(theme) {
            html.setAttribute('data-bs-theme', theme);
            localStorage.setItem(STORAGE, theme);
            icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
        }

        const saved = localStorage.getItem(STORAGE)
            || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        applyTheme(saved);
        btn.addEventListener('click', () =>
            applyTheme(html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark')
        );
    </script>
</body>
</html>
