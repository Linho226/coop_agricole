@extends('layouts.app')
@section('title', 'Commande ' . $commande->reference)
@section('page-title', 'Détail commande')

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><strong>{{ $commande->reference }}</strong></div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="text-muted small">Client</div>
                    <div class="fw-semibold">{{ $commande->nom_client }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small">Téléphone</div>
                    <div>{{ $commande->telephone }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small">Email</div>
                    <div>{{ $commande->email ?: '—' }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small">Adresse</div>
                    <div>{{ $commande->adresse_livraison }}</div>
                </div>
                @if($commande->notes)
                    <div class="mb-3">
                        <div class="text-muted small">Notes</div>
                        <div>{{ $commande->notes }}</div>
                    </div>
                @endif
                <form method="POST" action="{{ route('commandes.status', $commande) }}">
                    @csrf @method('PATCH')
                    <label class="form-label">Statut</label>
                    <select name="statut" class="form-select mb-2">
                        @foreach(['en_attente' => 'En attente', 'confirmee' => 'Confirmée', 'preparee' => 'Préparée', 'livree' => 'Livrée', 'annulee' => 'Annulée'] as $value => $label)
                            <option value="{{ $value }}" @selected($commande->statut === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-success w-100"><i class="bi bi-check-lg"></i> Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Produits commandés</strong>
                <span class="badge bg-{{ $commande->statut_color }}">{{ $commande->statut_label }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix unit.</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commande->items as $item)
                                <tr>
                                    <td class="fw-semibold">{{ $item->nom_produit }}</td>
                                    <td>{{ number_format($item->quantite, 2, ',', ' ') }} {{ $item->unite }}</td>
                                    <td>{{ number_format($item->prix_unitaire, 0, ',', ' ') }} F</td>
                                    <td class="fw-bold text-success">{{ number_format($item->montant_total, 0, ',', ' ') }} F</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th class="text-success">{{ number_format($commande->montant_total, 0, ',', ' ') }} F</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <a href="{{ route('commandes.index') }}" class="btn btn-outline-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Retour aux commandes
        </a>
    </div>
</div>
@endsection
