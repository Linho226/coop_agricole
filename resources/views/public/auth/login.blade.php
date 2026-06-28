@extends('public.layout')
@section('title', 'Connexion acheteur - CoopAgricole')

@section('content')
<header class="page-hero">
    <div class="container">
        <div class="text-white-50 fw-bold text-uppercase small mb-2">Espace acheteur</div>
        <h1>Connexion acheteur</h1>
        <p class="text-white-50 mb-0">Accédez à votre panier, confirmez vos commandes et consultez votre historique.</p>
    </div>
</header>

<main class="container py-5">
    <div class="shop-card p-4 mx-auto" style="max-width:520px;">
        <h4 class="fw-bold mb-3">Se connecter</h4>
        <form method="POST" action="{{ route('buyer.login.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Adresse email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-check mb-4">
                <input type="checkbox" name="remember" class="form-check-input" id="rememberBuyer">
                <label class="form-check-label" for="rememberBuyer">Se souvenir de moi</label>
            </div>
            <button class="btn btn-leaf w-100 py-2">Connexion</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ route('buyer.register') }}" class="text-decoration-none text-accent fw-bold">Créer un compte acheteur</a>
        </div>
    </div>
</main>
@endsection
