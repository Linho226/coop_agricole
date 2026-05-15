@extends('layouts.app')
@section('title','Dépenses')
@section('page-title','Gestion des dépenses')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong><i class="bi bi-receipt-cutoff text-danger me-1"></i> Dépenses</strong>
        <a href="{{ route('depenses.create') }}" class="btn btn-danger btn-sm">
            <i class="bi bi-plus-lg"></i> Nouvelle dépense
        </a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Libellé..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="categorie" class="form-select form-select-sm">
                    <option value="">-- Toutes catégories --</option>
                    <option value="engrais" @selected(request('categorie')=='engrais')>Engrais</option>
                    <option value="carburant" @selected(request('categorie')=='carburant')>Carburant</option>
                    <option value="materiel" @selected(request('categorie')=='materiel')>Matériel agricole</option>
                    <option value="transport" @selected(request('categorie')=='transport')>Transport</option>
                    <option value="salaire" @selected(request('categorie')=='salaire')>Salaire</option>
                    <option value="autre" @selected(request('categorie')=='autre')>Autre</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i> Filtrer</button>
                <a href="{{ route('depenses.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
            <div class="col-auto ms-auto">
                <span class="fw-bold text-danger">Total : {{ number_format($total, 0, ',', ' ') }} F</span>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>#</th><th>Libellé</th><th>Catégorie</th><th>Montant</th><th>Date</th><th>Description</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($depenses as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $d->libelle }}</td>
                    <td><span class="badge bg-secondary">{{ $d->categorie_label }}</span></td>
                    <td class="fw-bold text-danger">{{ number_format($d->montant, 0, ',', ' ') }} F</td>
                    <td>{{ $d->date_depense->format('d/m/Y') }}</td>
                    <td>{{ Str::limit($d->description, 40) ?? '—' }}</td>
                    <td>
                        <a href="{{ route('depenses.edit', $d) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('depenses.destroy', $d) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucune dépense.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($depenses->hasPages())
    <div class="card-footer">{{ $depenses->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
