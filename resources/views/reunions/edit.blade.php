@extends('layouts.app')
@section('title','Modifier réunion')
@section('page-title','Modifier une réunion')

@section('content')
<div class="card" style="max-width:650px;">
    <div class="card-header"><strong><i class="bi bi-pencil text-warning me-1"></i> Modifier la réunion</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('reunions.update', $reunion) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Titre <span class="text-danger">*</span></label>
                    <input type="text" name="titre" class="form-control"
                           value="{{ old('titre', $reunion->titre) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date_reunion" class="form-control"
                           value="{{ old('date_reunion', $reunion->date_reunion->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Heure</label>
                    <input type="time" name="heure" class="form-control" value="{{ old('heure', $reunion->heure) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Statut</label>
                    <select name="statut" class="form-select">
                        <option value="planifie" @selected($reunion->statut=='planifie')>Planifiée</option>
                        <option value="tenu" @selected($reunion->statut=='tenu')>Tenue</option>
                        <option value="annule" @selected($reunion->statut=='annule')>Annulée</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Lieu</label>
                    <input type="text" name="lieu" class="form-control" value="{{ old('lieu', $reunion->lieu) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Ordre du jour</label>
                    <textarea name="ordre_du_jour" class="form-control" rows="3">{{ old('ordre_du_jour', $reunion->ordre_du_jour) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Compte rendu</label>
                    <textarea name="compte_rendu" class="form-control" rows="4">{{ old('compte_rendu', $reunion->compte_rendu) }}</textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg"></i> Mettre à jour</button>
                <a href="{{ route('reunions.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
