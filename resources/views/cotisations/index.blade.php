@extends('layouts.app')
@section('title','Cotisations')
@section('page-title','Gestion des cotisations')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
        <h1 class="h4 mb-1">Cotisations</h1>
        <div class="text-muted small">Suivi des paiements, périodes, références et restes à payer.</div>
    </div>
    <a href="{{ route('cotisations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nouvelle cotisation
    </a>
</div>

<div class="row g-3 mb-3">
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 stat-card border-primary">
            <div class="card-body">
                <div class="text-muted small">Montant payé</div>
                <div class="h3 mb-0 text-primary">{{ number_format($total, 0, ',', ' ') }} F</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 stat-card border-success">
            <div class="card-body">
                <div class="text-muted small">Montant attendu</div>
                <div class="h3 mb-0 text-success">{{ number_format($totalAttendu, 0, ',', ' ') }} F</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 stat-card border-warning">
            <div class="card-body">
                <div class="text-muted small">Reste à payer</div>
                <div class="h3 mb-0 text-warning">{{ number_format($resteTotal, 0, ',', ' ') }} F</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 stat-card border-info">
            <div class="card-body">
                <div class="text-muted small">Dossiers suivis</div>
                <div class="h3 mb-0 text-info">{{ $cotisationsCount }}</div>
                <div class="small text-muted">{{ $partiellesCount }} paiement(s) partiel(s)</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong><i class="bi bi-cash-coin text-primary me-1"></i> Registre des cotisations</strong>
        <span class="text-muted small">Références et reçus disponibles pour chaque paiement</span>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-muted">Membre</label>
                <select name="membre_id" class="form-select form-select-sm">
                    <option value="">Tous les membres</option>
                    @foreach($membres as $m)
                    <option value="{{ $m->id }}" @selected(request('membre_id')==$m->id)>{{ $m->nom_complet }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Mois paiement</label>
                <input type="month" name="mois" class="form-control form-control-sm" value="{{ request('mois') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Année période</label>
                <select name="annee" class="form-select form-select-sm">
                    <option value="">Toutes</option>
                    @foreach($annees as $annee)
                    <option value="{{ $annee }}" @selected(request('annee')==$annee)>{{ $annee }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Type</label>
                <select name="type_cotisation" class="form-select form-select-sm">
                    <option value="">Tous</option>
                    @foreach($typeOptions as $value => $label)
                    <option value="{{ $value }}" @selected(request('type_cotisation')==$value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Statut</label>
                <select name="statut" class="form-select form-select-sm">
                    <option value="">Tous</option>
                    @foreach($statutOptions as $value => $label)
                    <option value="{{ $value }}" @selected(request('statut')==$value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-search"></i></button>
            </div>
            <div class="col-12">
                <a href="{{ route('cotisations.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Réinitialiser
                </a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Membre</th>
                        <th>Type / période</th>
                        <th>Payé</th>
                        <th>Attendu / reste</th>
                        <th>Date</th>
                        <th>Mode</th>
                        <th>Statut</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cotisations as $c)
                    <tr>
                        <td>
                            <a href="{{ route('cotisations.show', $c) }}" class="fw-semibold text-decoration-none">
                                {{ $c->reference_label }}
                            </a>
                        </td>
                        <td class="fw-semibold">{{ $c->membre->nom_complet ?? 'N/A' }}</td>
                        <td>
                            <div class="fw-semibold">{{ $c->type_label }}</div>
                            <div class="small text-muted">{{ $c->periode_label }}</div>
                        </td>
                        <td class="fw-bold text-primary">{{ number_format($c->montant, 0, ',', ' ') }} F</td>
                        <td>
                            <div>{{ number_format($c->montant_attendu, 0, ',', ' ') }} F</div>
                            <div class="small {{ $c->reste_a_payer > 0 ? 'text-warning fw-semibold' : 'text-muted' }}">
                                Reste : {{ number_format($c->reste_a_payer, 0, ',', ' ') }} F
                            </div>
                        </td>
                        <td>{{ $c->date_paiement->format('d/m/Y') }}</td>
                        <td><span class="badge text-bg-light border">{{ $c->mode_label }}</span></td>
                        <td><span class="badge {{ $c->statut_badge_class }}">{{ $c->statut_label }}</span></td>
                        <td>
                            <div class="table-actions justify-content-end">
                                <a href="{{ route('cotisations.show', $c) }}" class="btn btn-sm btn-outline-primary" title="Voir le reçu"><i class="bi bi-receipt"></i></a>
                                <a href="{{ route('cotisations.edit', $c) }}" class="btn btn-sm btn-outline-warning" title="Modifier"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('cotisations.destroy', $c) }}" class="d-inline"
                                      onsubmit="return confirm('Supprimer cette cotisation ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">Aucune cotisation trouvée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($cotisations->hasPages())
    <div class="card-footer">{{ $cotisations->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
