@extends('layouts.app')
@section('title','Récoltes')
@section('page-title','Gestion des récoltes')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong><i class="bi bi-basket-fill text-warning me-1"></i> Récoltes</strong>
        <a href="{{ route('recoltes.create') }}" class="btn btn-warning btn-sm">
            <i class="bi bi-plus-lg"></i> Nouvelle récolte
        </a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <select name="produit_id" class="form-select form-select-sm">
                    <option value="">-- Tous les produits --</option>
                    @foreach($produits as $p)
                    <option value="{{ $p->id }}" @selected(request('produit_id')==$p->id)>{{ $p->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="membre_id" class="form-select form-select-sm">
                    <option value="">-- Tous les membres --</option>
                    @foreach($membres as $m)
                    <option value="{{ $m->id }}" @selected(request('membre_id')==$m->id)>{{ $m->nom_complet }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i> Filtrer</button>
                <a href="{{ route('recoltes.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>#</th><th>Produit</th><th>Membre</th><th>Quantité</th><th>Date</th><th>Parcelle</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($recoltes as $r)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $r->produit->nom ?? '—' }}</td>
                    <td>{{ $r->membre->nom_complet ?? '—' }}</td>
                    <td>{{ $r->quantite }} <small class="text-muted">{{ $r->produit->unite ?? '' }}</small></td>
                    <td>{{ $r->date_recolte->format('d/m/Y') }}</td>
                    <td>{{ $r->parcelle ?? '—' }}</td>
                    <td>
                        <a href="{{ route('recoltes.edit', $r) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('recoltes.destroy', $r) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucune récolte.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($recoltes->hasPages())
    <div class="card-footer">{{ $recoltes->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
