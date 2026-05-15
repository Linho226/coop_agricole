@extends('layouts.app')
@section('title','Modifier dépense')
@section('page-title','Modifier une dépense')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header"><strong><i class="bi bi-pencil text-warning me-1"></i> Modifier la dépense</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('depenses.update', $depense) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Libellé <span class="text-danger">*</span></label>
                    <input type="text" name="libelle" class="form-control"
                           value="{{ old('libelle', $depense->libelle) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie" class="form-select">
                        <option value="engrais" @selected($depense->categorie=='engrais')>Engrais</option>
                        <option value="carburant" @selected($depense->categorie=='carburant')>Carburant</option>
                        <option value="materiel" @selected($depense->categorie=='materiel')>Matériel agricole</option>
                        <option value="transport" @selected($depense->categorie=='transport')>Transport</option>
                        <option value="salaire" @selected($depense->categorie=='salaire')>Salaire</option>
                        <option value="autre" @selected($depense->categorie=='autre')>Autre</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Montant (F) <span class="text-danger">*</span></label>
                    <input type="number" name="montant" class="form-control"
                           value="{{ old('montant', $depense->montant) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date_depense" class="form-control"
                           value="{{ old('date_depense', $depense->date_depense->format('Y-m-d')) }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description', $depense->description) }}</textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg"></i> Mettre à jour</button>
                <a href="{{ route('depenses.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
