@extends('layouts.app')
@section('title', 'Fiche membre')
@section('page-title', 'Fiche du membre')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-center p-3">
            @if($membre->photo)
                <img src="{{ Storage::url($membre->photo) }}" class="rounded-circle mx-auto mb-3"
                     style="width:100px;height:100px;object-fit:cover;">
            @else
                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center text-white fw-bold mx-auto mb-3"
                     style="width:100px;height:100px;font-size:2rem;">
                    {{ strtoupper(substr($membre->prenom,0,1).substr($membre->nom,0,1)) }}
                </div>
            @endif
            <h5 class="mb-0">{{ $membre->nom_complet }}</h5>
            <span class="badge bg-{{ $membre->actif ? 'success' : 'secondary' }} mt-1">
                {{ $membre->actif ? 'Actif' : 'Inactif' }}
            </span>
            <hr>
            <table class="table table-sm text-start">
                <tr><td class="text-muted">Sexe</td><td>{{ $membre->sexe === 'M' ? 'Masculin' : 'Féminin' }}</td></tr>
                <tr><td class="text-muted">Téléphone</td><td>{{ $membre->telephone ?? '—' }}</td></tr>
                <tr><td class="text-muted">Adresse</td><td>{{ $membre->adresse ?? '—' }}</td></tr>
                <tr><td class="text-muted">Adhésion</td><td>{{ $membre->date_adhesion->format('d/m/Y') }}</td></tr>
                <tr><td class="text-muted">Activité</td><td>{{ $membre->activite_agricole ?? '—' }}</td></tr>
            </table>
            <a href="{{ route('membres.edit', $membre) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Modifier
            </a>
        </div>
    </div>
    <div class="col-md-8">
        <!-- Cotisations -->
        <div class="card mb-3">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <strong><i class="bi bi-cash-coin text-primary me-1"></i> Cotisations</strong>
                <span class="badge bg-primary">Total : {{ number_format($membre->cotisations->sum('montant'), 0, ',', ' ') }} F</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr><th>Date</th><th>Montant</th><th>Mode</th></tr>
                    </thead>
                    <tbody>
                        @forelse($membre->cotisations->sortByDesc('date_paiement') as $c)
                        <tr>
                            <td>{{ $c->date_paiement->format('d/m/Y') }}</td>
                            <td class="fw-bold">{{ number_format($c->montant, 0, ',', ' ') }} F</td>
                            <td>{{ ucfirst(str_replace('_',' ',$c->mode_paiement)) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-muted text-center py-2">Aucune cotisation</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Récoltes -->
        <div class="card">
            <div class="card-header">
                <strong><i class="bi bi-basket-fill text-warning me-1"></i> Récoltes</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr><th>Date</th><th>Produit</th><th>Quantité</th><th>Parcelle</th></tr>
                    </thead>
                    <tbody>
                        @forelse($membre->recoltes->sortByDesc('date_recolte') as $r)
                        <tr>
                            <td>{{ $r->date_recolte->format('d/m/Y') }}</td>
                            <td>{{ $r->produit->nom ?? '—' }}</td>
                            <td>{{ $r->quantite }} {{ $r->produit->unite ?? '' }}</td>
                            <td>{{ $r->parcelle ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-muted text-center py-2">Aucune récolte</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="mt-3">
    <a href="{{ route('membres.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>
@endsection
