@extends('layouts.app')
@section('title','Nouveau produit')
@section('page-title','Nouveau produit')

@section('content')
<div class="card" style="max-width:540px;">
    <div class="card-header"><strong><i class="bi bi-box-seam me-1"></i> Nouveau produit</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('produits.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nom du produit <span class="text-danger">*</span></label>
                <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                       value="{{ old('nom') }}" placeholder="Ex: Maïs, Tomate, Riz..." required>
                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Unité de mesure <span class="text-danger">*</span></label>
                <select name="unite" class="form-select">
                    <option value="kg"    @selected(old('unite','kg')=='kg')>Kilogramme (kg)</option>
                    <option value="t"     @selected(old('unite')=='t')>Tonne (t)</option>
                    <option value="L"     @selected(old('unite')=='L')>Litre (L)</option>
                    <option value="unité" @selected(old('unite')=='unité')>Unité</option>
                    <option value="sac"   @selected(old('unite')=='sac')>Sac</option>
                    <option value="botte" @selected(old('unite')=='botte')>Botte</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Image du produit</label>
                <input type="file" name="image" id="imageInput"
                       class="form-control @error('image') is-invalid @enderror"
                       accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div id="preview" class="mt-2 d-none">
                    <img id="previewImg" src="" class="rounded"
                         style="max-height:160px;max-width:100%;object-fit:contain;">
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-check-lg"></i> Enregistrer
                </button>
                <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('imageInput').addEventListener('change', function () {
        const preview = document.getElementById('preview');
        const img     = document.getElementById('previewImg');
        if (this.files && this.files[0]) {
            img.src = URL.createObjectURL(this.files[0]);
            preview.classList.remove('d-none');
        } else {
            preview.classList.add('d-none');
        }
    });
</script>
@endpush
