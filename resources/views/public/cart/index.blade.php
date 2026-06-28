@extends('public.layout')
@section('title', 'Panier - CoopAgricole')

@section('content')
<header class="page-hero">
    <div class="container">
        <div class="text-white-50 fw-bold text-uppercase small mb-2">Panier</div>
        <h1>Votre sélection de produits agricoles</h1>
        <p class="text-white-50 mb-0">Vérifiez les quantités avant de confirmer votre commande.</p>
    </div>
</header>

<main class="container py-5">
    @if($items->isEmpty())
        <div class="shop-card p-5 text-center">
            <i class="bi bi-cart3 text-accent" style="font-size:3rem;"></i>
            <h4 class="fw-bold mt-3">Votre panier est vide</h4>
            <p class="text-muted">Ajoutez des produits depuis le catalogue.</p>
            <a href="{{ route('catalogue.index') }}" class="btn btn-leaf">Voir le catalogue</a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="shop-card p-0 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix</th>
                                    <th style="width:190px;">Quantité</th>
                                    <th>Montant</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    @php $produit = $item['produit']; @endphp
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $produit->nom }}</div>
                                            <div class="text-muted small">Stock: {{ number_format($produit->stock_disponible, 2, ',', ' ') }} {{ $produit->unite }}</div>
                                        </td>
                                        <td>{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} F</td>
                                        <td>
                                            <form method="POST" action="{{ route('cart.update', $produit) }}" class="d-flex gap-2">
                                                @csrf @method('PATCH')
                                                <input type="number" name="quantite" value="{{ $item['quantite'] }}" min="0" step="0.001" max="{{ $produit->stock_disponible }}" class="form-control form-control-sm">
                                                <button class="btn btn-sm btn-ghost"><i class="bi bi-check"></i></button>
                                            </form>
                                        </td>
                                        <td class="fw-bold">{{ number_format($item['montant'], 0, ',', ' ') }} F</td>
                                        <td>
                                            <form method="POST" action="{{ route('cart.destroy', $produit) }}">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="shop-card p-4">
                    <h4 class="fw-bold">Résumé</h4>
                    <div class="d-flex justify-content-between border-top border-bottom py-3 my-3">
                        <span>Total</span>
                        <strong class="price">{{ number_format($total, 0, ',', ' ') }} F</strong>
                    </div>
                    <a href="{{ route('checkout.create') }}" class="btn btn-leaf w-100 py-2">
                        Confirmer la commande
                    </a>
                    <a href="{{ route('catalogue.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                        Continuer les achats
                    </a>
                </div>
            </div>
        </div>
    @endif
</main>
@endsection
