<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use Illuminate\Http\Request;

class ActiviteController extends Controller
{
    public function index(Request $request)
    {
        $query = Activite::query();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $query->where('type_activite', 'like', '%' . $request->search . '%');
        }

        $activites = $query->latest('date_debut')->paginate(15)->withQueryString();
        return view('activites.index', compact('activites'));
    }

    public function create()
    {
        return view('activites.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type_activite' => 'required|string|max:150',
            'responsable' => 'required|string|max:150',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'description' => 'nullable|string',
            'statut' => 'required|in:planifie,en_cours,termine,annule',
        ]);

        $data['user_id'] = auth()->id();
        Activite::create($data);

        return redirect()->route('activites.index')->with('success', 'Activité enregistrée.');
    }

    public function show(Activite $activite)
    {
        return view('activites.show', compact('activite'));
    }

    public function edit(Activite $activite)
    {
        return view('activites.edit', compact('activite'));
    }

    public function update(Request $request, Activite $activite)
    {
        $data = $request->validate([
            'type_activite' => 'required|string|max:150',
            'responsable' => 'required|string|max:150',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'description' => 'nullable|string',
            'statut' => 'required|in:planifie,en_cours,termine,annule',
        ]);

        $activite->update($data);
        return redirect()->route('activites.index')->with('success', 'Activité modifiée.');
    }

    public function destroy(Activite $activite)
    {
        $activite->delete();
        return redirect()->route('activites.index')->with('success', 'Activité supprimée.');
    }
}
