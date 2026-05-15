@extends('layouts.app')
@section('title','Modifier vente')
@section('page-title','Modifier une vente')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header"><strong><i class="bi bi-pencil text-warning me-1"></i> Modifier la vente</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('ventes.update', $vente) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Produit <span class="text-danger">*</span></label>
                    <select name="produit_id" class="form-select" required>
                        @foreach($produits as $p)
                        <option value="{{ $p->id }}" @selected($vente->produit_id==$p->id)>{{ $p->nom }} ({{ $p->unite }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date_vente" class="form-control"
                           value="{{ old('date_vente', $vente->date_vente->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Quantité <span class="text-danger">*</span></label>
                    <input type="number" name="quantite" class="form-control" step="0.001"
                           value="{{ old('quantite', $vente->quantite) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prix unitaire (F) <span class="text-danger">*</span></label>
                    <input type="number" name="prix_unitaire" class="form-control"
                           value="{{ old('prix_unitaire', $vente->prix_unitaire) }}" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Client</label>
                    <input type="text" name="client" class="form-control" value="{{ old('client', $vente->client) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Observation</label>
                    <textarea name="observation" class="form-control" rows="2">{{ old('observation', $vente->observation) }}</textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg"></i> Mettre à jour</button>
                <a href="{{ route('ventes.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
