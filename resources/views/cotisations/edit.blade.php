@extends('layouts.app')
@section('title','Modifier cotisation')
@section('page-title','Modifier une cotisation')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header"><strong><i class="bi bi-pencil text-warning me-1"></i> Modifier la cotisation</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('cotisations.update', $cotisation) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Membre <span class="text-danger">*</span></label>
                <select name="membre_id" class="form-select" required>
                    @foreach($membres as $m)
                    <option value="{{ $m->id }}" @selected($cotisation->membre_id==$m->id)>{{ $m->nom_complet }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Montant (F) <span class="text-danger">*</span></label>
                    <input type="number" name="montant" class="form-control"
                           value="{{ old('montant', $cotisation->montant) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date de paiement <span class="text-danger">*</span></label>
                    <input type="date" name="date_paiement" class="form-control"
                           value="{{ old('date_paiement', $cotisation->date_paiement->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mode de paiement</label>
                    <select name="mode_paiement" class="form-select">
                        <option value="especes" @selected($cotisation->mode_paiement=='especes')>Espèces</option>
                        <option value="mobile_money" @selected($cotisation->mode_paiement=='mobile_money')>Mobile Money</option>
                        <option value="virement" @selected($cotisation->mode_paiement=='virement')>Virement</option>
                        <option value="autre" @selected($cotisation->mode_paiement=='autre')>Autre</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <label class="form-label">Observation</label>
                <textarea name="observation" class="form-control" rows="2">{{ old('observation', $cotisation->observation) }}</textarea>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg"></i> Mettre à jour</button>
                <a href="{{ route('cotisations.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
