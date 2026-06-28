@extends('public.layout')
@section('title', 'Inscription acheteur - CoopAgricole')

@section('content')
<header class="page-hero">
    <div class="container">
        <div class="text-white-50 fw-bold text-uppercase small mb-2">Compte acheteur</div>
        <h1>Créer votre espace acheteur</h1>
        <p class="text-white-50 mb-0">Commandez les produits de la coopérative et suivez vos achats.</p>
    </div>
</header>

<main class="container py-5">
    <div class="shop-card p-4 mx-auto" style="max-width:560px;">
        <h4 class="fw-bold mb-3">Inscription</h4>
        <form method="POST" action="{{ route('buyer.register.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nom complet</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Adresse email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button class="btn btn-leaf w-100 py-2">Créer mon compte</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ route('buyer.login') }}" class="text-decoration-none text-accent fw-bold">J’ai déjà un compte</a>
        </div>
    </div>
</main>
@endsection
