@extends('layouts.app')
@section('title','Nouvelle dépense')
@section('page-title','Enregistrer une dépense')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header"><strong><i class="bi bi-receipt-cutoff text-danger me-1"></i> Nouvelle dépense</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('depenses.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Libellé <span class="text-danger">*</span></label>
                    <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror"
                           value="{{ old('libelle') }}" required>
                    @error('libelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Catégorie <span class="text-danger">*</span></label>
                    <select name="categorie" class="form-select" required>
                        <option value="engrais" @selected(old('categorie')=='engrais')>Engrais</option>
                        <option value="carburant" @selected(old('categorie')=='carburant')>Carburant</option>
                        <option value="materiel" @selected(old('categorie')=='materiel')>Matériel agricole</option>
                        <option value="transport" @selected(old('categorie')=='transport')>Transport</option>
                        <option value="salaire" @selected(old('categorie')=='salaire')>Salaire</option>
                        <option value="autre" @selected(old('categorie','autre')=='autre')>Autre</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Montant (F) <span class="text-danger">*</span></label>
                    <input type="number" name="montant" class="form-control"
                           value="{{ old('montant') }}" min="0" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date_depense" class="form-control"
                           value="{{ old('date_depense', date('Y-m-d')) }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-danger"><i class="bi bi-check-lg"></i> Enregistrer</button>
                <a href="{{ route('depenses.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
