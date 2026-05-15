@extends('layouts.app')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')
<!-- Statistiques -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="border-color:#2e7d32;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="text-muted small">Membres actifs</div>
                    <div class="fs-3 fw-bold text-success">{{ $stats['total_membres'] }}</div>
                </div>
                <i class="bi bi-people-fill fs-2 text-success opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="border-color:#1565c0;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="text-muted small">Total cotisations</div>
                    <div class="fs-3 fw-bold text-primary">{{ number_format($stats['total_cotisations'], 0, ',', ' ') }} F</div>
                </div>
                <i class="bi bi-cash-coin fs-2 text-primary opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="border-color:#e65100;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="text-muted small">Total ventes</div>
                    <div class="fs-3 fw-bold text-warning">{{ number_format($stats['total_ventes'], 0, ',', ' ') }} F</div>
                </div>
                <i class="bi bi-cart-check-fill fs-2 text-warning opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="border-color:#c62828;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="text-muted small">Total dépenses</div>
                    <div class="fs-3 fw-bold text-danger">{{ number_format($stats['total_depenses'], 0, ',', ' ') }} F</div>
                </div>
                <i class="bi bi-receipt-cutoff fs-2 text-danger opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="border-color:#0288d1;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="text-muted small">Activités en cours</div>
                    <div class="fs-3 fw-bold text-info">{{ $stats['activites_en_cours'] }}</div>
                </div>
                <i class="bi bi-clipboard2-check-fill fs-2 text-info opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="border-color:#6a1b9a;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="text-muted small">Réunions planifiées</div>
                    <div class="fs-3 fw-bold" style="color:#6a1b9a;">{{ $stats['reunions_planifiees'] }}</div>
                </div>
                <i class="bi bi-calendar-event-fill fs-2 opacity-50" style="color:#6a1b9a;"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="border-color:#2e7d32;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="text-muted small">Solde net</div>
                    @php $solde = $stats['total_cotisations'] + $stats['total_ventes'] - $stats['total_depenses']; @endphp
                    <div class="fs-3 fw-bold {{ $solde >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ number_format($solde, 0, ',', ' ') }} F
                    </div>
                </div>
                <i class="bi bi-bank2 fs-2 text-success opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tableaux récents -->
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <strong><i class="bi bi-people-fill text-success me-1"></i> Derniers membres</strong>
                @if(auth()->user()->hasRole(['admin','secretaire']))
                <a href="{{ route('membres.index') }}" class="btn btn-sm btn-outline-success">Voir tout</a>
                @endif
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($derniers_membres as $m)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-semibold">{{ $m->nom_complet }}</span>
                            <br><small class="text-muted">{{ $m->date_adhesion->format('d/m/Y') }}</small>
                        </div>
                        <span class="badge bg-{{ $m->actif ? 'success' : 'secondary' }}">
                            {{ $m->actif ? 'Actif' : 'Inactif' }}
                        </span>
                    </li>
                    @empty
                    <li class="list-group-item text-muted text-center py-3">Aucun membre</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <strong><i class="bi bi-cash-coin text-primary me-1"></i> Dernières cotisations</strong>
                @if(auth()->user()->hasRole(['admin','comptable']))
                <a href="{{ route('cotisations.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                @endif
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($dernieres_cotisations as $c)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-semibold">{{ $c->membre->nom_complet ?? 'N/A' }}</span>
                            <br><small class="text-muted">{{ $c->date_paiement->format('d/m/Y') }}</small>
                        </div>
                        <span class="fw-bold text-primary">{{ number_format($c->montant, 0, ',', ' ') }} F</span>
                    </li>
                    @empty
                    <li class="list-group-item text-muted text-center py-3">Aucune cotisation</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <strong><i class="bi bi-clipboard2-check-fill text-info me-1"></i> Dernières activités</strong>
                @if(auth()->user()->hasRole(['admin','secretaire']))
                <a href="{{ route('activites.index') }}" class="btn btn-sm btn-outline-info">Voir tout</a>
                @endif
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($dernieres_activites as $a)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-semibold">{{ $a->type_activite }}</span>
                            <br><small class="text-muted">{{ $a->date_debut->format('d/m/Y') }}</small>
                        </div>
                        <span class="badge bg-{{ $a->statut_color }}">{{ $a->statut_label }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-muted text-center py-3">Aucune activité</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
