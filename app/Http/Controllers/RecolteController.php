<?php

namespace App\Http\Controllers;

use App\Models\Recolte;
use App\Models\Membre;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RecolteController extends Controller
{
    public function index(Request $request)
    {
        $query = Recolte::with(['produit', 'membre']);

        if ($request->filled('produit_id')) {
            $query->where('produit_id', $request->produit_id);
        }

        if ($request->filled('membre_id')) {
            $query->where('membre_id', $request->membre_id);
        }

        $recoltes = $query->latest('date_recolte')->paginate(15)->withQueryString();
        $produits = Produit::orderBy('nom')->get();
        $membres = Membre::where('actif', true)->orderBy('nom')->get();

        return view('recoltes.index', compact('recoltes', 'produits', 'membres'));
    }

    public function create()
    {
        $produits = Produit::orderBy('nom')->get();
        $membres = Membre::where('actif', true)->orderBy('nom')->get();
        return view('recoltes.create', compact('produits', 'membres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'membre_id' => 'required|exists:membres,id',
            'quantite' => 'required|numeric|min:0.001',
            'date_recolte' => 'required|date',
            'parcelle' => 'nullable|string|max:100',
            'observation' => 'nullable|string',
        ]);

        DB::transaction(function () use ($data) {
            $produit = Produit::whereKey($data['produit_id'])->lockForUpdate()->firstOrFail();
            $produit->increment('stock_disponible', $data['quantite']);

            $data['user_id'] = auth()->id();
            Recolte::create($data);
        });

        return redirect()->route('recoltes.index')->with('success', 'Récolte enregistrée.');
    }

    public function edit(Recolte $recolte)
    {
        $produits = Produit::orderBy('nom')->get();
        $membres = Membre::where('actif', true)->orderBy('nom')->get();
        return view('recoltes.edit', compact('recolte', 'produits', 'membres'));
    }

    public function update(Request $request, Recolte $recolte)
    {
        $data = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'membre_id' => 'required|exists:membres,id',
            'quantite' => 'required|numeric|min:0.001',
            'date_recolte' => 'required|date',
            'parcelle' => 'nullable|string|max:100',
            'observation' => 'nullable|string',
        ]);

        DB::transaction(function () use ($recolte, $data) {
            $recolte->refresh();

            if ((int) $recolte->produit_id === (int) $data['produit_id']) {
                $produit = Produit::whereKey($recolte->produit_id)->lockForUpdate()->firstOrFail();
                $difference = (float) $data['quantite'] - (float) $recolte->quantite;
                $this->adjustStock($produit, $difference);
            } else {
                $ancienProduit = Produit::whereKey($recolte->produit_id)->lockForUpdate()->firstOrFail();
                $nouveauProduit = Produit::whereKey($data['produit_id'])->lockForUpdate()->firstOrFail();

                $this->adjustStock($ancienProduit, - (float) $recolte->quantite);
                $this->adjustStock($nouveauProduit, (float) $data['quantite']);
            }

            $recolte->update($data);
        });

        return redirect()->route('recoltes.index')->with('success', 'Récolte modifiée.');
    }

    public function destroy(Recolte $recolte)
    {
        DB::transaction(function () use ($recolte) {
            $recolte->refresh();
            $produit = Produit::whereKey($recolte->produit_id)->lockForUpdate()->firstOrFail();

            $this->adjustStock($produit, - (float) $recolte->quantite);
            $recolte->delete();
        });

        return redirect()->route('recoltes.index')->with('success', 'Récolte supprimée.');
    }

    private function adjustStock(Produit $produit, float $quantite): void
    {
        $nouveauStock = (float) $produit->stock_disponible + $quantite;

        if ($nouveauStock < 0) {
            throw ValidationException::withMessages([
                'quantite' => "Impossible de retirer cette récolte : le stock de {$produit->nom} deviendrait négatif.",
            ]);
        }

        $produit->update(['stock_disponible' => $nouveauStock]);
    }
}
