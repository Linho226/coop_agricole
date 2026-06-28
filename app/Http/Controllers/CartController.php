<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('public.cart.index', $this->cartViewData());
    }

    public function store(Request $request, Produit $produit)
    {
        $data = $request->validate([
            'quantite' => ['required', 'numeric', 'min:0.001'],
        ]);

        if (! $produit->publie || (float) $produit->stock_disponible <= 0) {
            return back()->withErrors(['quantite' => 'Ce produit n’est pas disponible à la commande.']);
        }

        $quantite = min((float) $data['quantite'], (float) $produit->stock_disponible);
        $cart = session('cart', []);
        $cart[$produit->id] = min(($cart[$produit->id] ?? 0) + $quantite, (float) $produit->stock_disponible);

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier.');
    }

    public function update(Request $request, Produit $produit)
    {
        $data = $request->validate([
            'quantite' => ['required', 'numeric', 'min:0'],
        ]);

        $cart = session('cart', []);
        $quantite = min((float) $data['quantite'], (float) $produit->stock_disponible);

        if ($quantite <= 0) {
            unset($cart[$produit->id]);
        } else {
            $cart[$produit->id] = $quantite;
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Panier mis à jour.');
    }

    public function destroy(Produit $produit)
    {
        $cart = session('cart', []);
        unset($cart[$produit->id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Produit retiré du panier.');
    }

    private function cartViewData(): array
    {
        $cart = session('cart', []);
        $produits = Produit::whereIn('id', array_keys($cart))->get();
        $items = $produits->map(function (Produit $produit) use ($cart) {
            $quantite = min((float) ($cart[$produit->id] ?? 0), (float) $produit->stock_disponible);
            return [
                'produit' => $produit,
                'quantite' => $quantite,
                'montant' => $quantite * (float) $produit->prix_unitaire,
            ];
        })->filter(fn ($item) => $item['quantite'] > 0);

        return [
            'items' => $items,
            'total' => $items->sum('montant'),
        ];
    }
}
