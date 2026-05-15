@extends('layouts.app')
@section('title','Modifier activité')
@section('page-title','Modifier une activité')

@section('content')
<div class="card" style="max-width:650px;">
    <div class="card-header"><strong><i class="bi bi-pencil text-warning me-1"></i> Modifier l'activité</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('activites.update', $activite) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Type d'activité <span class="text-danger">*</span></label>
                    <input type="text" name="type_activite" class="form-control"
                           value="{{ old('type_activite', $activite->type_activite) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Statut</label>
                    <select name="statut" class="form-select">
                        <option value="planifie" @selected($activite->statut=='planifie')>Planifié</option>
                        <option value="en_cours" @selected($activite->statut=='en_cours')>En cours</option>
                        <option value="termine" @selected($activite->statut=='termine')>Terminé</option>
                        <option value="annule" @selected($activite->statut=='annule')>Annulé</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Responsable <span class="text-danger">*</span></label>
                    <input type="text" name="responsable" class="form-control"
                           value="{{ old('responsable', $activite->responsable) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date début <span class="text-danger">*</span></label>
                    <input type="date" name="date_debut" class="form-control"
                           value="{{ old('date_debut', $activite->date_debut->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date fin</label>
                    <input type="date" name="date_fin" class="form-control"
                           value="{{ old('date_fin', $activite->date_fin?->format('Y-m-d')) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $activite->description) }}</textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg"></i> Mettre à jour</button>
                <a href="{{ route('activites.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
