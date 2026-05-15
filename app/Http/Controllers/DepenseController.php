<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Depense::query();

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        if ($request->filled('search')) {
            $query->where('libelle', 'like', '%' . $request->search . '%');
        }

        $total = $query->sum('montant');
        $depenses = $query->latest('date_depense')->paginate(15)->withQueryString();

        return view('depenses.index', compact('depenses', 'total'));
    }

    public function create()
    {
        return view('depenses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:200',
            'montant' => 'required|numeric|min:0',
            'date_depense' => 'required|date',
            'categorie' => 'required|in:engrais,carburant,materiel,transport,salaire,autre',
            'description' => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id();
        Depense::create($data);

        return redirect()->route('depenses.index')->with('success', 'Dépense enregistrée.');
    }

    public function edit(Depense $depense)
    {
        return view('depenses.edit', compact('depense'));
    }

    public function update(Request $request, Depense $depense)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:200',
            'montant' => 'required|numeric|min:0',
            'date_depense' => 'required|date',
            'categorie' => 'required|in:engrais,carburant,materiel,transport,salaire,autre',
            'description' => 'nullable|string',
        ]);

        $depense->update($data);
        return redirect()->route('depenses.index')->with('success', 'Dépense modifiée.');
    }

    public function destroy(Depense $depense)
    {
        $depense->delete();
        return redirect()->route('depenses.index')->with('success', 'Dépense supprimée.');
    }
}
