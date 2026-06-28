@extends('public.layout')
@section('title', $produit->nom . ' - Catalogue')

@section('content')
<main class="container py-5">
    <a href="{{ route('catalogue.index') }}" class="btn btn-outline-secondary btn-sm mb-4">
        <i class="bi bi-arrow-left"></i> Retour au catalogue
    </a>

    <div class="row g-4 align-items-start">
        <div class="col-lg-6">
            <div class="shop-card overflow-hidden">
                <div style="height:420px;background:var(--field);">
                    @if($produit->image)
                        <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div class="h-100 d-flex align-items-center justify-content-center text-accent">
                            <i class="bi bi-basket-fill" style="font-size:5rem;"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="shop-card p-4">
                <span class="badge badge-accent mb-3">Disponible</span>
                <h1 class="fw-bold">{{ $produit->nom }}</h1>
                <p class="text-muted">{{ $produit->description ?: 'Produit agricole disponible auprès de la coopérative.' }}</p>
                <div class="row g-3 my-3">
                    <div class="col-6">
                        <div class="border rounded p-3">
                            <div class="text-muted small">Prix unitaire</div>
                            <div class="price fs-3">{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} F</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3">
                            <div class="text-muted small">Stock disponible</div>
                            <div class="fw-bold fs-3">{{ number_format($produit->stock_disponible, 2, ',', ' ') }} {{ $produit->unite }}</div>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('cart.store', $produit) }}" class="row g-2">
                    @csrf
                    <div class="col-sm-4">
                        <input type="number" name="quantite" class="form-control" min="0.001" step="0.001" value="1" max="{{ $produit->stock_disponible }}">
                    </div>
                    <div class="col-sm-8">
                        <button class="btn btn-leaf w-100">
                            <i class="bi bi-cart-plus me-1"></i> Ajouter au panier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($similaires->isNotEmpty())
        <section class="mt-5">
            <h3 class="fw-bold mb-3">Autres produits</h3>
            <div class="row g-3">
                @foreach($similaires as $item)
                    <div class="col-md-4">
                        <a href="{{ route('catalogue.show', $item) }}" class="shop-card d-block p-3 text-decoration-none text-body">
                            <div class="fw-bold">{{ $item->nom }}</div>
                            <div class="text-muted small">{{ number_format($item->prix_unitaire, 0, ',', ' ') }} F / {{ $item->unite }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</main>
@endsection
