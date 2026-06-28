<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function create()
    {
        if (! Auth::check() || Auth::user()->role !== 'membre') {
            return redirect()->route('buyer.login')->withErrors(['email' => 'Connectez-vous à votre espace acheteur pour confirmer la commande.']);
        }

        $cartData = $this->cartData();

        if ($cartData['items']->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Votre panier est vide.']);
        }

        return view('public.checkout.create', $cartData);
    }

    public function store(Request $request)
    {
        if (! Auth::check() || Auth::user()->role !== 'membre') {
            return redirect()->route('buyer.login')->withErrors(['email' => 'Connectez-vous à votre espace acheteur pour confirmer la commande.']);
        }

        $cartData = $this->cartData();

        if ($cartData['items']->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Votre panier est vide.']);
        }

        $data = $request->validate([
            'nom_client' => ['required', 'string', 'max:150'],
            'telephone' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:150'],
            'adresse_livraison' => ['required', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $commande = DB::transaction(function () use ($data) {
            $cartData = $this->cartData(lockForUpdate: true, strictStock: true);

            if ($cartData['items']->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Votre panier est vide ou les produits ne sont plus disponibles.',
                ]);
            }

            $commande = Commande::create([
                ...$data,
                'reference' => $this->makeReference(),
                'user_id' => Auth::id(),
                'statut' => 'en_attente',
                'montant_total' => $cartData['total'],
                'confirmee_at' => now(),
            ]);

            foreach ($cartData['items'] as $item) {
                $produit = $item['produit'];
                $commande->items()->create([
                    'produit_id' => $produit->id,
                    'nom_produit' => $produit->nom,
                    'unite' => $produit->unite,
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $produit->prix_unitaire,
                    'montant_total' => $item['montant'],
                ]);

                $produit->decrement('stock_disponible', $item['quantite']);
            }

            return $commande;
        });

        session()->forget('cart');

        return redirect()->route('checkout.success', $commande)->with('success', 'Commande confirmée.');
    }

    public function success(Commande $commande)
    {
        abort_unless(Auth::check() && $commande->user_id === Auth::id(), 403);

        $commande->load('items');

        return view('public.checkout.success', compact('commande'));
    }

    private function cartData(bool $lockForUpdate = false, bool $strictStock = false): array
    {
        $cart = session('cart', []);
        $query = Produit::whereIn('id', array_keys($cart))
            ->where('publie', true)
            ->where('stock_disponible', '>', 0);

        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        $produits = $query->get();

        $items = $produits->map(function (Produit $produit) use ($cart, $strictStock) {
            $quantiteDemandee = (float) ($cart[$produit->id] ?? 0);

            if ($strictStock && $quantiteDemandee > (float) $produit->stock_disponible) {
                throw ValidationException::withMessages([
                    'cart' => "Stock insuffisant pour {$produit->nom}. Stock disponible : {$produit->stock_disponible} {$produit->unite}.",
                ]);
            }

            $quantite = min($quantiteDemandee, (float) $produit->stock_disponible);
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

    private function makeReference(): string
    {
        do {
            $reference = 'CMD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (Commande::where('reference', $reference)->exists());

        return $reference;
    }
}
