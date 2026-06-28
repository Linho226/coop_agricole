@extends('public.layout')
@section('title', $commande->reference . ' - CoopAgricole')

@section('content')
@php
    $statusDescriptions = [
        'en_attente' => 'Commande reçue, en attente de validation.',
        'confirmee' => 'Commande approuvée par la coopérative.',
        'preparee' => 'Commande en préparation.',
        'livree' => 'Commande livrée ou récupérée.',
        'annulee' => 'Commande annulée.',
    ];
@endphp

<main class="container py-5">
    <a href="{{ route('buyer.orders') }}" class="btn btn-ghost btn-sm mb-4">
        <i class="bi bi-arrow-left"></i> Mes commandes
    </a>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="shop-card p-4 h-100">
                <div class="text-muted small">Référence</div>
                <h2 class="fw-bold">{{ $commande->reference }}</h2>
                <span class="badge text-bg-{{ $commande->statut_color }} px-3 py-2 mb-3">{{ $commande->statut_label }}</span>
                <p class="text-muted">{{ $statusDescriptions[$commande->statut] ?? 'Statut en cours de mise à jour.' }}</p>

                <div class="border-top pt-3">
                    <div class="text-muted small">Client</div>
                    <div class="fw-semibold">{{ $commande->nom_client }}</div>
                    <div class="text-muted small">{{ $commande->telephone }}</div>
                </div>

                <div class="border-top pt-3 mt-3">
                    <div class="text-muted small">Adresse</div>
                    <div>{{ $commande->adresse_livraison }}</div>
                </div>

                @if($commande->notes)
                    <div class="border-top pt-3 mt-3">
                        <div class="text-muted small">Notes</div>
                        <div>{{ $commande->notes }}</div>
                    </div>
                @endif

                <div class="border-top pt-3 mt-3">
                    <div class="text-muted small">Total</div>
                    <div class="price fs-3">{{ number_format($commande->montant_total, 0, ',', ' ') }} F</div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="shop-card overflow-hidden">
                <div class="p-4 border-bottom">
                    <h4 class="fw-bold mb-1">Produits commandés</h4>
                    <p class="text-muted mb-0">Détail des quantités, prix unitaires et montants.</p>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commande->items as $item)
                                <tr>
                                    <td class="fw-bold">{{ $item->nom_produit }}</td>
                                    <td>{{ number_format($item->quantite, 2, ',', ' ') }} {{ $item->unite }}</td>
                                    <td>{{ number_format($item->prix_unitaire, 0, ',', ' ') }} F</td>
                                    <td class="fw-bold">{{ number_format($item->montant_total, 0, ',', ' ') }} F</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th class="price">{{ number_format($commande->montant_total, 0, ',', ' ') }} F</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
