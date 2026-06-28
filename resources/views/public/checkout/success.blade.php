@extends('public.layout')
@section('title', 'Commande confirmée - CoopAgricole')

@section('content')
<main class="container py-5">
    <div class="shop-card p-5 text-center mx-auto" style="max-width:760px;">
        <i class="bi bi-check-circle-fill text-accent" style="font-size:4rem;"></i>
        <h1 class="fw-bold mt-3">Commande reçue</h1>
        <p class="text-muted">Votre commande a été transmise à la coopérative.</p>
        <div class="border rounded p-3 my-4">
            <div class="text-muted small">Référence</div>
            <div class="fs-3 fw-bold">{{ $commande->reference }}</div>
            <div class="mt-2">Total: <strong>{{ number_format($commande->montant_total, 0, ',', ' ') }} F</strong></div>
        </div>
        <p class="text-muted">Un responsable vous contactera pour confirmer la disponibilité, le retrait ou la livraison.</p>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="{{ route('catalogue.index') }}" class="btn btn-leaf">Retour au catalogue</a>
            <a href="{{ route('public.home') }}" class="btn btn-outline-secondary">Accueil</a>
        </div>
    </div>
</main>
@endsection
