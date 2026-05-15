@extends('layouts.app')
@section('title', 'Modifier membre')
@section('page-title', 'Modifier un membre')

@section('content')
<div class="card" style="max-width:700px;">
    <div class="card-header">
        <strong><i class="bi bi-pencil-fill text-warning me-1"></i> Modifier : {{ $membre->nom_complet }}</strong>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('membres.update', $membre) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                           value="{{ old('nom', $membre->nom) }}" required>
                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prénom <span class="text-danger">*</span></label>
                    <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror"
                           value="{{ old('prenom', $membre->prenom) }}" required>
                    @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sexe <span class="text-danger">*</span></label>
                    <select name="sexe" class="form-select" required>
                        <option value="M" @selected($membre->sexe=='M')>Masculin</option>
                        <option value="F" @selected($membre->sexe=='F')>Féminin</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $membre->telephone) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date d'adhésion <span class="text-danger">*</span></label>
                    <input type="date" name="date_adhesion" class="form-control"
                           value="{{ old('date_adhesion', $membre->date_adhesion->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Adresse</label>
                    <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $membre->adresse) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Activité agricole</label>
                    <input type="text" name="activite_agricole" class="form-control"
                           value="{{ old('activite_agricole', $membre->activite_agricole) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nouvelle photo</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    @if($membre->photo)
                        <small class="text-muted">Photo actuelle conservée si aucun fichier choisi.</small>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Statut</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="actif" value="1"
                               id="actif" @checked($membre->actif)>
                        <label class="form-check-label" for="actif">Membre actif</label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-lg"></i> Mettre à jour
                </button>
                <a href="{{ route('membres.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
