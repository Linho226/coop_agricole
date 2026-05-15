@extends('layouts.app')
@section('title','Ventes')
@section('page-title','Gestion des ventes')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong><i class="bi bi-cart-check-fill text-success me-1"></i> Ventes</strong>
        <a href="{{ route('ventes.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg"></i> Nouvelle vente
        </a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="produit_id" class="form-select form-select-sm">
                    <option value="">-- Tous les produits --</option>
                    @foreach($produits as $p)
                    <option value="{{ $p->id }}" @selected(request('produit_id')==$p->id)>{{ $p->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i> Filtrer</button>
                <a href="{{ route('ventes.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
            <div class="col-auto ms-auto">
                <span class="fw-bold text-success">Total : {{ number_format($total, 0, ',', ' ') }} F</span>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>#</th><th>Produit</th><th>Quantité</th><th>Prix unit.</th><th>Montant</th><th>Client</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($ventes as $v)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $v->produit->nom ?? '—' }}</td>
                    <td>{{ $v->quantite }} <small class="text-muted">{{ $v->produit->unite ?? '' }}</small></td>
                    <td>{{ number_format($v->prix_unitaire, 0, ',', ' ') }} F</td>
                    <td class="fw-bold text-success">{{ number_format($v->montant_total, 0, ',', ' ') }} F</td>
                    <td>{{ $v->client ?? '—' }}</td>
                    <td>{{ $v->date_vente->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('ventes.edit', $v) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('ventes.destroy', $v) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Aucune vente.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($ventes->hasPages())
    <div class="card-footer">{{ $ventes->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
