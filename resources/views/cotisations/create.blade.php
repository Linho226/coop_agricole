@extends('layouts.app')
@section('title','Nouvelle cotisation')
@section('page-title','Enregistrer une cotisation')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header"><strong><i class="bi bi-cash-coin text-primary me-1"></i> Nouvelle cotisation</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('cotisations.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Membre <span class="text-danger">*</span></label>
                <select name="membre_id" class="form-select @error('membre_id') is-invalid @enderror" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($membres as $m)
                    <option value="{{ $m->id }}" @selected(old('membre_id')==$m->id)>{{ $m->nom_complet }}</option>
                    @endforeach
                </select>
                @error('membre_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Montant (F) <span class="text-danger">*</span></label>
                    <input type="number" name="montant" class="form-control @error('montant') is-invalid @enderror"
                           value="{{ old('montant') }}" min="1" required>
                    @error('montant')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date de paiement <span class="text-danger">*</span></label>
                    <input type="date" name="date_paiement" class="form-control"
                           value="{{ old('date_paiement', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mode de paiement <span class="text-danger">*</span></label>
                    <select name="mode_paiement" class="form-select" required>
                        <option value="especes" @selected(old('mode_paiement','especes')=='especes')>Espèces</option>
                        <option value="mobile_money" @selected(old('mode_paiement')=='mobile_money')>Mobile Money</option>
                        <option value="virement" @selected(old('mode_paiement')=='virement')>Virement</option>
                        <option value="autre" @selected(old('mode_paiement')=='autre')>Autre</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <label class="form-label">Observation</label>
                <textarea name="observation" class="form-control" rows="2">{{ old('observation') }}</textarea>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Enregistrer</button>
                <a href="{{ route('cotisations.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
