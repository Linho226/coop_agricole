@extends('layouts.app')
@section('title','Nouvelle vente')
@section('page-title','Enregistrer une vente')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header"><strong><i class="bi bi-cart-plus-fill text-success me-1"></i> Nouvelle vente</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('ventes.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Produit <span class="text-danger">*</span></label>
                    <select name="produit_id" class="form-select @error('produit_id') is-invalid @enderror" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($produits as $p)
                        <option value="{{ $p->id }}" @selected(old('produit_id')==$p->id)>{{ $p->nom }} ({{ $p->unite }})</option>
                        @endforeach
                    </select>
                    @error('produit_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date_vente" class="form-control"
                           value="{{ old('date_vente', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Quantité <span class="text-danger">*</span></label>
                    <input type="number" name="quantite" id="quantite" class="form-control" step="0.001"
                           value="{{ old('quantite') }}" min="0.001" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prix unitaire (F) <span class="text-danger">*</span></label>
                    <input type="number" name="prix_unitaire" id="prix_unitaire" class="form-control" step="1"
                           value="{{ old('prix_unitaire') }}" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Montant total (F)</label>
                    <input type="text" id="montant_total" class="form-control bg-light" readonly placeholder="Calculé auto.">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Client</label>
                    <input type="text" name="client" class="form-control" value="{{ old('client') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Observation</label>
                    <textarea name="observation" class="form-control" rows="2">{{ old('observation') }}</textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i> Enregistrer</button>
                <a href="{{ route('ventes.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function calcMontant() {
    const q = parseFloat(document.getElementById('quantite').value) || 0;
    const p = parseFloat(document.getElementById('prix_unitaire').value) || 0;
    document.getElementById('montant_total').value = (q * p).toLocaleString('fr-FR') + ' F';
}
document.getElementById('quantite').addEventListener('input', calcMontant);
document.getElementById('prix_unitaire').addEventListener('input', calcMontant);
</script>
@endpush
