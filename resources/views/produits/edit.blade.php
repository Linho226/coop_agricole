@extends('layouts.app')
@section('title','Modifier produit')
@section('page-title','Modifier un produit')

@section('content')
<div class="card" style="max-width:540px;">
    <div class="card-header"><strong><i class="bi bi-pencil text-warning me-1"></i> Modifier : {{ $produit->nom }}</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('produits.update', $produit) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nom du produit <span class="text-danger">*</span></label>
                <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                       value="{{ old('nom', $produit->nom) }}" required>
                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Unité de mesure</label>
                <select name="unite" class="form-select">
                    <option value="kg"    @selected($produit->unite=='kg')>Kilogramme (kg)</option>
                    <option value="t"     @selected($produit->unite=='t')>Tonne (t)</option>
                    <option value="L"     @selected($produit->unite=='L')>Litre (L)</option>
                    <option value="unité" @selected($produit->unite=='unité')>Unité</option>
                    <option value="sac"   @selected($produit->unite=='sac')>Sac</option>
                    <option value="botte" @selected($produit->unite=='botte')>Botte</option>
                </select>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Prix unitaire</label>
                    <input type="number" name="prix_unitaire" class="form-control @error('prix_unitaire') is-invalid @enderror"
                           value="{{ old('prix_unitaire', $produit->prix_unitaire) }}" min="0" step="1" required>
                    @error('prix_unitaire')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stock disponible</label>
                    <input type="number" name="stock_disponible" class="form-control @error('stock_disponible') is-invalid @enderror"
                           value="{{ old('stock_disponible', $produit->stock_disponible) }}" min="0" step="0.001" required>
                    @error('stock_disponible')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-check form-switch my-3">
                <input class="form-check-input" type="checkbox" name="publie" value="1" id="publie" @checked(old('publie', $produit->publie))>
                <label class="form-check-label" for="publie">Publier dans le catalogue public</label>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $produit->description) }}</textarea>
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label class="form-label">Image du produit</label>

                @if($produit->image)
                <div class="mb-2 d-flex align-items-start gap-3">
                    <img src="{{ Storage::url($produit->image) }}" class="rounded"
                         style="width:100px;height:100px;object-fit:cover;" id="previewImg">
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="supprimer_image" value="1" id="supprimerImg">
                            <label class="form-check-label text-danger" for="supprimerImg">
                                <i class="bi bi-trash me-1"></i>Supprimer l'image actuelle
                            </label>
                        </div>
                    </div>
                </div>
                @else
                <img id="previewImg" src="" class="rounded mb-2 d-none" style="max-height:100px;max-width:100%;object-fit:contain;">
                @endif

                <input type="file" name="image" id="imageInput"
                       class="form-control @error('image') is-invalid @enderror"
                       accept="image/*">
                <div class="form-text">Laissez vide pour conserver l'image actuelle.</div>
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg"></i> Mettre à jour</button>
                <a href="{{ route('produits.show', $produit) }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('imageInput').addEventListener('change', function () {
        const img = document.getElementById('previewImg');
        if (this.files && this.files[0]) {
            img.src = URL.createObjectURL(this.files[0]);
            img.classList.remove('d-none');
        }
    });
</script>
@endpush
