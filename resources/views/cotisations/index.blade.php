@extends('layouts.app')
@section('title','Cotisations')
@section('page-title','Gestion des cotisations')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong><i class="bi bi-cash-coin text-primary me-1"></i> Cotisations</strong>
        <a href="{{ route('cotisations.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Nouvelle cotisation
        </a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="membre_id" class="form-select form-select-sm">
                    <option value="">-- Tous les membres --</option>
                    @foreach($membres as $m)
                    <option value="{{ $m->id }}" @selected(request('membre_id')==$m->id)>{{ $m->nom_complet }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="month" name="mois" class="form-control form-control-sm" value="{{ request('mois') }}">
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i> Filtrer</button>
                <a href="{{ route('cotisations.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
            <div class="col-auto ms-auto">
                <span class="fw-bold text-primary">Total : {{ number_format($total, 0, ',', ' ') }} F</span>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>#</th><th>Membre</th><th>Montant</th><th>Date</th><th>Mode</th><th>Observation</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($cotisations as $c)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $c->membre->nom_complet ?? 'N/A' }}</td>
                    <td class="fw-bold text-primary">{{ number_format($c->montant, 0, ',', ' ') }} F</td>
                    <td>{{ $c->date_paiement->format('d/m/Y') }}</td>
                    <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_',' ',$c->mode_paiement)) }}</span></td>
                    <td>{{ Str::limit($c->observation, 40) ?? '—' }}</td>
                    <td>
                        <a href="{{ route('cotisations.edit', $c) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('cotisations.destroy', $c) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer cette cotisation ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucune cotisation.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($cotisations->hasPages())
    <div class="card-footer">{{ $cotisations->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
