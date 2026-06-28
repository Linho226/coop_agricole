@extends('public.layout')
@section('title', 'Commande - CoopAgricole')

@section('content')
<header class="page-hero">
    <div class="container">
        <div class="text-white-50 fw-bold text-uppercase small mb-2">Commande</div>
        <h1>Confirmer votre commande</h1>
        <p class="text-white-50 mb-0">Renseignez vos coordonnées pour que la coopérative vous contacte.</p>
    </div>
</header>

<main class="container py-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="shop-card p-4">
                <h4 class="fw-bold mb-3">Informations de l’acheteur</h4>
                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom complet *</label>
                            <input type="text" name="nom_client" value="{{ old('nom_client') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Téléphone *</label>
                            <input type="text" name="telephone" value="{{ old('telephone') }}" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Adresse de livraison *</label>
                            <textarea name="adresse_livraison" rows="3" class="form-control" required>{{ old('adresse_livraison') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                    <button class="btn btn-leaf w-100 mt-4 py-2">
                        <i class="bi bi-check-circle me-1"></i> Valider la commande
                    </button>
                </form>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="shop-card p-4">
                <h4 class="fw-bold mb-3">Résumé</h4>
                <div class="vstack gap-3">
                    @foreach($items as $item)
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <div class="fw-bold">{{ $item['produit']->nom }}</div>
                                <div class="text-muted small">{{ number_format($item['quantite'], 2, ',', ' ') }} {{ $item['produit']->unite }}</div>
                            </div>
                            <div class="fw-bold">{{ number_format($item['montant'], 0, ',', ' ') }} F</div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-between border-top pt-3 mt-3">
                    <span>Total</span>
                    <strong class="price fs-4">{{ number_format($total, 0, ',', ' ') }} F</strong>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
