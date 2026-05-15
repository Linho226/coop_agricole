@extends('layouts.app')
@section('title', 'Nouveau membre')
@section('page-title', 'Ajouter un membre')

@section('content')
<div class="card" style="max-width:700px;">
    <div class="card-header">
        <strong><i class="bi bi-person-plus-fill text-success me-1"></i> Nouveau membre</strong>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('membres.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                           value="{{ old('nom') }}" required>
                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prénom <span class="text-danger">*</span></label>
                    <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror"
                           value="{{ old('prenom') }}" required>
                    @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sexe <span class="text-danger">*</span></label>
                    <select name="sexe" class="form-select @error('sexe') is-invalid @enderror" required>
                        <option value="">-- Choisir --</option>
                        <option value="M" @selected(old('sexe')=='M')>Masculin</option>
                        <option value="F" @selected(old('sexe')=='F')>Féminin</option>
                    </select>
                    @error('sexe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date d'adhésion <span class="text-danger">*</span></label>
                    <input type="date" name="date_adhesion" class="form-control @error('date_adhesion') is-invalid @enderror"
                           value="{{ old('date_adhesion', date('Y-m-d')) }}" required>
                    @error('date_adhesion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Adresse</label>
                    <input type="text" name="adresse" class="form-control" value="{{ old('adresse') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Activité agricole</label>
                    <input type="text" name="activite_agricole" class="form-control" value="{{ old('activite_agricole') }}"
                           placeholder="Ex: Maraîchage">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Photo</label>
                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Enregistrer
                </button>
                <a href="{{ route('membres.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
