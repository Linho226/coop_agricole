<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index(Request $request)
    {
        $commandes = Commande::query()
            ->when($request->filled('statut'), fn ($query) => $query->where('statut', $request->statut))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $total = Commande::when($request->filled('statut'), fn ($query) => $query->where('statut', $request->statut))
            ->sum('montant_total');

        return view('commandes.index', compact('commandes', 'total'));
    }

    public function show(Commande $commande)
    {
        $commande->load('items.produit');

        return view('commandes.show', compact('commande'));
    }

    public function updateStatus(Request $request, Commande $commande)
    {
        $data = $request->validate([
            'statut' => ['required', 'in:en_attente,confirmee,preparee,livree,annulee'],
        ]);

        $commande->update($data);

        return back()->with('success', 'Statut de la commande mis à jour.');
    }
}
