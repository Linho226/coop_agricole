@extends('layouts.app')
@section('title','Nouvelle réunion')
@section('page-title','Planifier une réunion')

@section('content')
<div class="card" style="max-width:650px;">
    <div class="card-header"><strong><i class="bi bi-calendar-plus-fill me-1" style="color:#6a1b9a;"></i> Nouvelle réunion</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('reunions.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Titre <span class="text-danger">*</span></label>
                    <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror"
                           value="{{ old('titre') }}" required>
                    @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date_reunion" class="form-control"
                           value="{{ old('date_reunion', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Heure</label>
                    <input type="time" name="heure" class="form-control" value="{{ old('heure') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Statut</label>
                    <select name="statut" class="form-select">
                        <option value="planifie" @selected(old('statut','planifie')=='planifie')>Planifiée</option>
                        <option value="tenu" @selected(old('statut')=='tenu')>Tenue</option>
                        <option value="annule" @selected(old('statut')=='annule')>Annulée</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Lieu</label>
                    <input type="text" name="lieu" class="form-control" value="{{ old('lieu') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Ordre du jour</label>
                    <textarea name="ordre_du_jour" class="form-control" rows="3">{{ old('ordre_du_jour') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Compte rendu</label>
                    <textarea name="compte_rendu" class="form-control" rows="4">{{ old('compte_rendu') }}</textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn" style="background:#6a1b9a;color:#fff;">
                    <i class="bi bi-check-lg"></i> Enregistrer
                </button>
                <a href="{{ route('reunions.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
