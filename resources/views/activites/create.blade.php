@extends('layouts.app')
@section('title','Nouvelle activité')
@section('page-title','Nouvelle activité agricole')

@section('content')
<div class="card" style="max-width:650px;">
    <div class="card-header"><strong><i class="bi bi-clipboard2-plus-fill text-info me-1"></i> Nouvelle activité</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('activites.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Type d'activité <span class="text-danger">*</span></label>
                    <input type="text" name="type_activite" class="form-control @error('type_activite') is-invalid @enderror"
                           value="{{ old('type_activite') }}" placeholder="Ex: Labour, Semis, Récolte..." required>
                    @error('type_activite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Statut <span class="text-danger">*</span></label>
                    <select name="statut" class="form-select" required>
                        <option value="planifie" @selected(old('statut','planifie')=='planifie')>Planifié</option>
                        <option value="en_cours" @selected(old('statut')=='en_cours')>En cours</option>
                        <option value="termine" @selected(old('statut')=='termine')>Terminé</option>
                        <option value="annule" @selected(old('statut')=='annule')>Annulé</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Responsable <span class="text-danger">*</span></label>
                    <input type="text" name="responsable" class="form-control"
                           value="{{ old('responsable') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date début <span class="text-danger">*</span></label>
                    <input type="date" name="date_debut" class="form-control"
                           value="{{ old('date_debut', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date fin</label>
                    <input type="date" name="date_fin" class="form-control" value="{{ old('date_fin') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-info text-white"><i class="bi bi-check-lg"></i> Enregistrer</button>
                <a href="{{ route('activites.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
