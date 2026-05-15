<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Produit;
use Illuminate\Http\Request;

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

        $data['montant_total'] = $data['quantite'] * $data['prix_unitaire'];
        $data['user_id'] = auth()->id();
        Vente::create($data);

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

        $data['montant_total'] = $data['quantite'] * $data['prix_unitaire'];
        $vente->update($data);
        return redirect()->route('ventes.index')->with('success', 'Vente modifiée.');
    }

    public function destroy(Vente $vente)
    {
        $vente->delete();
        return redirect()->route('ventes.index')->with('success', 'Vente supprimée.');
    }
}