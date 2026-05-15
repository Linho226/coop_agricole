@extends('layouts.app')
@section('title','Modifier récolte')
@section('page-title','Modifier une récolte')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header"><strong><i class="bi bi-pencil text-warning me-1"></i> Modifier la récolte</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('recoltes.update', $recolte) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Produit <span class="text-danger">*</span></label>
                    <select name="produit_id" class="form-select" required>
                        @foreach($produits as $p)
                        <option value="{{ $p->id }}" @selected($recolte->produit_id==$p->id)>{{ $p->nom }} ({{ $p->unite }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Membre <span class="text-danger">*</span></label>
                    <select name="membre_id" class="form-select" required>
                        @foreach($membres as $m)
                        <option value="{{ $m->id }}" @selected($recolte->membre_id==$m->id)>{{ $m->nom_complet }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Quantité <span class="text-danger">*</span></label>
                    <input type="number" name="quantite" class="form-control" step="0.001"
                           value="{{ old('quantite', $recolte->quantite) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date_recolte" class="form-control"
                           value="{{ old('date_recolte', $recolte->date_recolte->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Parcelle</label>
                    <input type="text" name="parcelle" class="form-control"
                           value="{{ old('parcelle', $recolte->parcelle) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Observation</label>
                    <textarea name="observation" class="form-control" rows="2">{{ old('observation', $recolte->observation) }}</textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg"></i> Mettre à jour</button>
                <a href="{{ route('recoltes.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
