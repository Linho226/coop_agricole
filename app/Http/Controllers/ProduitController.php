<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::orderBy('nom')->paginate(15);
        return view('produits.index', compact('produits'));
    }

    public function create()
    {
        return view('produits.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:150|unique:produits,nom',
            'unite'       => 'required|string|max:20',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        Produit::create($data);
        return redirect()->route('produits.index')->with('success', 'Produit créé.');
    }

    public function show(Produit $produit)
    {
        $produit->load(['recoltes.membre', 'ventes']);
        $stats = [
            'total_recoltes'    => $produit->recoltes->sum('quantite'),
            'nb_recoltes'       => $produit->recoltes->count(),
            'total_ventes_qte'  => $produit->ventes->sum('quantite'),
            'total_ventes_montant' => $produit->ventes->sum('montant_total'),
            'nb_ventes'         => $produit->ventes->count(),
        ];
        $dernieres_recoltes = $produit->recoltes()->with('membre')->latest('date_recolte')->take(5)->get();
        $dernieres_ventes   = $produit->ventes()->latest('date_vente')->take(5)->get();
        return view('produits.show', compact('produit', 'stats', 'dernieres_recoltes', 'dernieres_ventes'));
    }

    public function edit(Produit $produit)
    {
        return view('produits.edit', compact('produit'));
    }

    public function update(Request $request, Produit $produit)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:150|unique:produits,nom,' . $produit->id,
            'unite'       => 'required|string|max:20',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($produit->image) Storage::disk('public')->delete($produit->image);
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        if ($request->boolean('supprimer_image') && $produit->image) {
            Storage::disk('public')->delete($produit->image);
            $data['image'] = null;
        }

        $produit->update($data);
        return redirect()->route('produits.show', $produit)->with('success', 'Produit modifié.');
    }

    public function destroy(Produit $produit)
    {
        if ($produit->image) Storage::disk('public')->delete($produit->image);
        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'Produit supprimé.');
    }
}
