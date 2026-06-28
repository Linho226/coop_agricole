@extends('layouts.app')
@section('title', $produit->nom)
@section('page-title', 'Détail du produit')

@section('content')
<div class="row g-3">

    {{-- ── Colonne gauche : carte produit ── --}}
    <div class="col-lg-4">
        <div class="card h-100">
            {{-- Image --}}
            <div style="height:220px;overflow:hidden;border-radius:.6rem .6rem 0 0;background:var(--bs-tertiary-bg);">
                @if($produit->image)
                    <img src="{{ Storage::url($produit->image) }}" alt="{{ $produit->nom }}"
                         style="width:100%;height:100%;object-fit:cover;">
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-secondary">
                        <i class="bi bi-image" style="font-size:3.5rem;opacity:.3;"></i>
                        <small class="mt-2 opacity-50">Aucune image</small>
                    </div>
                @endif
            </div>

            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between gap-2 mb-3">
                    <h5 class="mb-0 fw-bold">{{ $produit->nom }}</h5>
                    <span class="badge bg-secondary fs-6">{{ $produit->unite }}</span>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <div class="text-muted small">Prix public</div>
                            <div class="fw-bold text-success">{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} F</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <div class="text-muted small">Stock public</div>
                            <div class="fw-bold">{{ number_format($produit->stock_disponible, 2, ',', ' ') }} {{ $produit->unite }}</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <span class="badge bg-{{ $produit->publie ? 'success' : 'secondary' }}">
                            {{ $produit->publie ? 'Visible dans le catalogue' : 'Masqué du catalogue' }}
                        </span>
                    </div>
                </div>

                @if($produit->description)
                <p class="text-muted mb-3" style="font-size:.88rem;">{{ $produit->description }}</p>
                @else
                <p class="text-muted mb-3 fst-italic" style="font-size:.85rem;">Aucune description.</p>
                @endif

                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('produits.edit', $produit) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i> Modifier
                    </a>
                    <form method="POST" action="{{ route('produits.destroy', $produit) }}"
                          onsubmit="return confirm('Supprimer ce produit définitivement ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-1"></i> Supprimer
                        </button>
                    </form>
                    <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Colonne droite : statistiques + historique ── --}}
    <div class="col-lg-8">

        {{-- Cartes stats --}}
        <div class="row g-3 mb-3">
            <div class="col-6 col-md-3">
                <div class="card stat-card h-100 text-center" style="border-color:#0288d1;">
                    <div class="card-body py-3">
                        <div class="fs-2 fw-bold text-info">{{ number_format($stats['total_recoltes'], 2, ',', ' ') }}</div>
                        <div class="small text-muted">{{ $produit->unite }} récoltés</div>
                        <div class="text-muted" style="font-size:.7rem;">{{ $stats['nb_recoltes'] }} récolte(s)</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card stat-card h-100 text-center" style="border-color:#2e7d32;">
                    <div class="card-body py-3">
                        <div class="fs-2 fw-bold text-success">{{ number_format($stats['total_ventes_qte'], 2, ',', ' ') }}</div>
                        <div class="small text-muted">{{ $produit->unite }} vendus</div>
                        <div class="text-muted" style="font-size:.7rem;">{{ $stats['nb_ventes'] }} vente(s)</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card stat-card h-100 text-center" style="border-color:#e65100;">
                    <div class="card-body py-3">
                        <div class="fs-2 fw-bold text-warning">{{ number_format($stats['total_ventes_montant'], 0, ',', ' ') }}</div>
                        <div class="small text-muted">Recettes (F)</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                @php $stock = $stats['total_recoltes'] - $stats['total_ventes_qte']; @endphp
                <div class="card stat-card h-100 text-center" style="border-color:{{ $stock < 0 ? '#c62828' : '#4f46e5' }};">
                    <div class="card-body py-3">
                        <div class="fs-2 fw-bold" style="color:{{ $stock < 0 ? '#c62828' : '#4f46e5' }};">
                            {{ number_format($stock, 2, ',', ' ') }}
                        </div>
                        <div class="small text-muted">{{ $produit->unite }} en stock</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dernières récoltes --}}
        <div class="card mb-3">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <strong><i class="bi bi-basket-fill text-info me-1"></i> Dernières récoltes</strong>
                @if(auth()->user()->hasRole(['admin','comptable']))
                <a href="{{ route('recoltes.index', ['produit_id' => $produit->id]) }}" class="btn btn-sm btn-outline-info">
                    Voir tout
                </a>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Membre</th>
                                <th>Quantité</th>
                                <th>Parcelle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dernieres_recoltes as $r)
                            <tr>
                                <td>{{ $r->date_recolte->format('d/m/Y') }}</td>
                                <td>{{ $r->membre->nom_complet ?? '—' }}</td>
                                <td class="fw-semibold">{{ number_format($r->quantite, 2, ',', ' ') }} {{ $produit->unite }}</td>
                                <td>{{ $r->parcelle ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Aucune récolte enregistrée.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Dernières ventes --}}
        <div class="card">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <strong><i class="bi bi-cart-check-fill text-success me-1"></i> Dernières ventes</strong>
                @if(auth()->user()->hasRole(['admin','comptable']))
                <a href="{{ route('ventes.index', ['produit_id' => $produit->id]) }}" class="btn btn-sm btn-outline-success">
                    Voir tout
                </a>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Qté</th>
                                <th>Prix unit.</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dernieres_ventes as $v)
                            <tr>
                                <td>{{ $v->date_vente->format('d/m/Y') }}</td>
                                <td>{{ $v->client ?? '—' }}</td>
                                <td>{{ number_format($v->quantite, 2, ',', ' ') }} {{ $produit->unite }}</td>
                                <td>{{ number_format($v->prix_unitaire, 0, ',', ' ') }} F</td>
                                <td class="fw-semibold text-success">{{ number_format($v->montant_total, 0, ',', ' ') }} F</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">Aucune vente enregistrée.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
