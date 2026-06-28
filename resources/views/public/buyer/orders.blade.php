@extends('public.layout')
@section('title', 'Mes commandes - CoopAgricole')

@section('content')
@php
    $statusDescriptions = [
        'en_attente' => 'Votre commande a été reçue et attend la validation de la coopérative.',
        'confirmee' => 'La coopérative a confirmé la disponibilité de votre commande.',
        'preparee' => 'Votre commande est en préparation.',
        'livree' => 'Votre commande a été livrée ou récupérée.',
        'annulee' => 'Cette commande a été annulée.',
    ];
@endphp

<header class="page-hero">
    <div class="container">
        <div class="text-white-50 fw-bold text-uppercase small mb-2">Espace acheteur</div>
        <h1>Mes commandes</h1>
        <p class="text-white-50 mb-0">Consultez vos produits commandés et suivez l’état de traitement.</p>
    </div>
</header>

<main class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Historique des commandes</h2>
            <p class="text-muted mb-0">Chaque commande affiche son statut actuel et les produits concernés.</p>
        </div>
        <a href="{{ route('catalogue.index') }}" class="btn btn-leaf">
            <i class="bi bi-plus-lg me-1"></i> Nouvelle commande
        </a>
    </div>

    <div class="vstack gap-3">
        @forelse($commandes as $commande)
            <article class="shop-card p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
                    <div>
                        <div class="text-muted small">Référence</div>
                        <h4 class="fw-bold mb-1">{{ $commande->reference }}</h4>
                        <div class="text-muted small">
                            <i class="bi bi-calendar-event me-1"></i>{{ $commande->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <div class="text-lg-end">
                        <span class="badge text-bg-{{ $commande->statut_color }} px-3 py-2">{{ $commande->statut_label }}</span>
                        <div class="price fs-4 mt-2">{{ number_format($commande->montant_total, 0, ',', ' ') }} F</div>
                    </div>
                </div>

                <div class="alert alert-{{ $commande->statut_color === 'danger' ? 'danger' : ($commande->statut_color === 'success' ? 'success' : 'info') }} py-2 mb-3">
                    {{ $statusDescriptions[$commande->statut] ?? 'Statut en cours de mise à jour.' }}
                </div>

                <div class="row g-2 mb-3">
                    @foreach($commande->items as $item)
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <div class="fw-bold">{{ $item->nom_produit }}</div>
                                <div class="text-muted small">
                                    {{ number_format($item->quantite, 2, ',', ' ') }} {{ $item->unite }}
                                    x {{ number_format($item->prix_unitaire, 0, ',', ' ') }} F
                                </div>
                                <div class="fw-bold mt-1">{{ number_format($item->montant_total, 0, ',', ' ') }} F</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div class="text-muted small">
                        <i class="bi bi-geo-alt me-1"></i>{{ Str::limit($commande->adresse_livraison, 80) }}
                    </div>
                    <a href="{{ route('buyer.orders.show', $commande) }}" class="btn btn-ghost btn-sm">
                        <i class="bi bi-eye me-1"></i> Voir les détails
                    </a>
                </div>
            </article>
        @empty
            <div class="shop-card p-5 text-center">
                <i class="bi bi-bag-x text-accent" style="font-size:3.5rem;"></i>
                <h4 class="fw-bold mt-3">Aucune commande pour le moment</h4>
                <p class="text-muted">Ajoutez des produits au panier puis confirmez votre commande.</p>
                <a href="{{ route('catalogue.index') }}" class="btn btn-leaf">Voir le catalogue</a>
            </div>
        @endforelse
    </div>

    @if($commandes->hasPages())
        <div class="mt-4">{{ $commandes->links('pagination::bootstrap-5') }}</div>
    @endif
</main>
@endsection
