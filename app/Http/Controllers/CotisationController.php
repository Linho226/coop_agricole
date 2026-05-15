<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Membre;
use Illuminate\Http\Request;

class CotisationController extends Controller
{
    public function index(Request $request)
    {
        $query = Cotisation::with('membre');

        if ($request->filled('membre_id')) {
            $query->where('membre_id', $request->membre_id);
        }

        if ($request->filled('mois')) {
            $query->whereMonth('date_paiement', date('m', strtotime($request->mois)))
                  ->whereYear('date_paiement', date('Y', strtotime($request->mois)));
        }

        $total = $query->sum('montant');
        $cotisations = $query->latest('date_paiement')->paginate(15)->withQueryString();
        $membres = Membre::where('actif', true)->orderBy('nom')->get();

        return view('cotisations.index', compact('cotisations', 'membres', 'total'));
    }

    public function create()
    {
        $membres = Membre::where('actif', true)->orderBy('nom')->get();
        return view('cotisations.create', compact('membres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'membre_id' => 'required|exists:membres,id',
            'montant' => 'required|numeric|min:1',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|in:especes,mobile_money,virement,autre',
            'observation' => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id();
        Cotisation::create($data);

        return redirect()->route('cotisations.index')->with('success', 'Cotisation enregistrée.');
    }

    public function edit(Cotisation $cotisation)
    {
        $membres = Membre::where('actif', true)->orderBy('nom')->get();
        return view('cotisations.edit', compact('cotisation', 'membres'));
    }

    public function update(Request $request, Cotisation $cotisation)
    {
        $data = $request->validate([
            'membre_id' => 'required|exists:membres,id',
            'montant' => 'required|numeric|min:1',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|in:especes,mobile_money,virement,autre',
            'observation' => 'nullable|string',
        ]);

        $cotisation->update($data);
        return redirect()->route('cotisations.index')->with('success', 'Cotisation modifiée.');
    }

    public function destroy(Cotisation $cotisation)
    {
        $cotisation->delete();
        return redirect()->route('cotisations.index')->with('success', 'Cotisation supprimée.');
    }
}
