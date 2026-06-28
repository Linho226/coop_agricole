<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VenteController extends Controller
{
    public function index(Request $request)
    {
        $query = Vente::with('produit');

        if ($request->filled('produit_id')) {
            $query->where('produit_id', $request->produit_id);
        }

        $total = $query->sum('montant_total');
        $ventes = $query->latest('date_vente')->paginate(15)->withQueryString();
        $produits = Produit::orderBy('nom')->get();

        return view('ventes.index', compact('ventes', 'produits', 'total'));
    }

    public function create()
    {
        $produits = Produit::orderBy('nom')->get();
        return view('ventes.create', compact('produits'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|numeric|min:0.001',
            'prix_unitaire' => 'required|numeric|min:0',
            'client' => 'nullable|string|max:150',
            'date_vente' => 'required|date',
            'observation' => 'nullable|string',
        ]);

        DB::transaction(function () use ($data) {
            $produit = Produit::whereKey($data['produit_id'])->lockForUpdate()->firstOrFail();
            $this->ensureStock($produit, (float) $data['quantite']);

            $produit->decrement('stock_disponible', $data['quantite']);

            $data['montant_total'] = $data['quantite'] * $data['prix_unitaire'];
            $data['user_id'] = auth()->id();
            Vente::create($data);
        });

        return redirect()->route('ventes.index')->with('success', 'Vente enregistrée.');
    }

    public function edit(Vente $vente)
    {
        $produits = Produit::orderBy('nom')->get();
        return view('ventes.edit', compact('vente', 'produits'));
    }

    public function update(Request $request, Vente $vente)
    {
        $data = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|numeric|min:0.001',
            'prix_unitaire' => 'required|numeric|min:0',
            'client' => 'nullable|string|max:150',
            'date_vente' => 'required|date',
            'observation' => 'nullable|string',
        ]);

        DB::transaction(function () use ($vente, $data) {
            $vente->refresh();

            if ((int) $vente->produit_id === (int) $data['produit_id']) {
                $produit = Produit::whereKey($vente->produit_id)->lockForUpdate()->firstOrFail();
                $difference = (float) $data['quantite'] - (float) $vente->quantite;

                if ($difference > 0) {
                    $this->ensureStock($produit, $difference);
                    $produit->decrement('stock_disponible', $difference);
                } elseif ($difference < 0) {
                    $produit->increment('stock_disponible', abs($difference));
                }
            } else {
                $ancienProduit = Produit::whereKey($vente->produit_id)->lockForUpdate()->firstOrFail();
                $nouveauProduit = Produit::whereKey($data['produit_id'])->lockForUpdate()->firstOrFail();

                $ancienProduit->increment('stock_disponible', $vente->quantite);
                $this->ensureStock($nouveauProduit, (float) $data['quantite']);
                $nouveauProduit->decrement('stock_disponible', $data['quantite']);
            }

            $data['montant_total'] = $data['quantite'] * $data['prix_unitaire'];
            $vente->update($data);
        });

        return redirect()->route('ventes.index')->with('success', 'Vente modifiée.');
    }

    public function destroy(Vente $vente)
    {
        DB::transaction(function () use ($vente) {
            $vente->refresh();
            $produit = Produit::whereKey($vente->produit_id)->lockForUpdate()->firstOrFail();
            $produit->increment('stock_disponible', $vente->quantite);
            $vente->delete();
        });

        return redirect()->route('ventes.index')->with('success', 'Vente supprimée.');
    }

    private function ensureStock(Produit $produit, float $quantite): void
    {
        if ((float) $produit->stock_disponible < $quantite) {
            throw ValidationException::withMessages([
                'quantite' => "Stock insuffisant pour {$produit->nom}. Stock disponible : {$produit->stock_disponible} {$produit->unite}.",
            ]);
        }
    }
}
