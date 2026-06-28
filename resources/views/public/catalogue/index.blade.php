@extends('public.layout')
@section('title', 'Catalogue - CoopAgricole')

@section('content')
<header class="page-hero">
    <div class="container">
        <div class="row align-items-end g-3">
            <div class="col-lg-7">
                <div class="text-white-50 fw-bold text-uppercase small mb-2">Catalogue public</div>
                <h1>Produits agricoles disponibles à la commande</h1>
                <p class="text-white-50 mb-0">Consultez les stocks publiés par la coopérative et préparez votre panier.</p>
            </div>
            <div class="col-lg-5">
                <form method="GET" class="d-flex gap-2">
                    <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Rechercher un produit">
                    <button class="btn btn-light fw-bold"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>
    </div>
</header>

<main class="container py-5">
    <div class="row g-4">
        @forelse($produits as $produit)
            <div class="col-md-6 col-xl-4">
                <article class="shop-card h-100">
                    <a href="{{ route('catalogue.show', $produit) }}" class="product-img d-block">
                        @if($produit->image)
                            <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}">
                        @else
                            <div class="h-100 d-flex align-items-center justify-content-center text-accent">
                                <i class="bi bi-basket-fill" style="font-size:3rem;"></i>
                            </div>
                        @endif
                    </a>
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <h5 class="fw-bold mb-0">{{ $produit->nom }}</h5>
                            <span class="badge badge-accent">{{ $produit->unite }}</span>
                        </div>
                        <p class="text-muted small mb-3">{{ Str::limit($produit->description ?: 'Produit agricole de la coopérative.', 95) }}</p>
                        <div class="d-flex justify-content-between align-items-end gap-2">
                            <div>
                                <div class="price fs-4">{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} F</div>
                                <div class="text-muted small">Stock: {{ number_format($produit->stock_disponible, 2, ',', ' ') }} {{ $produit->unite }}</div>
                            </div>
                            <form method="POST" action="{{ route('cart.store', $produit) }}" class="d-flex gap-2">
                                @csrf
                                <input type="hidden" name="quantite" value="1">
                                <button class="btn btn-leaf btn-sm"><i class="bi bi-cart-plus me-1"></i> Ajouter</button>
                            </form>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="shop-card p-5 text-center">
                    <i class="bi bi-basket text-accent" style="font-size:3rem;"></i>
                    <h4 class="fw-bold mt-3">Aucun produit disponible</h4>
                    <p class="text-muted mb-0">L’administrateur doit publier des produits avec prix et stock.</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($produits->hasPages())
        <div class="mt-4">{{ $produits->links('pagination::bootstrap-5') }}</div>
    @endif
</main>
@endsection
