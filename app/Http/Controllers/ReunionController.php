<?php

namespace App\Http\Controllers;

use App\Models\Reunion;
use Illuminate\Http\Request;

class ReunionController extends Controller
{
    public function index(Request $request)
    {
        $query = Reunion::query();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $reunions = $query->latest('date_reunion')->paginate(15)->withQueryString();
        return view('reunions.index', compact('reunions'));
    }

    public function create()
    {
        return view('reunions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:200',
            'date_reunion' => 'required|date',
            'heure' => 'nullable|date_format:H:i',
            'lieu' => 'nullable|string|max:200',
            'ordre_du_jour' => 'nullable|string',
            'compte_rendu' => 'nullable|string',
            'statut' => 'required|in:planifie,tenu,annule',
        ]);

        $data['user_id'] = auth()->id();
        Reunion::create($data);

        return redirect()->route('reunions.index')->with('success', 'Réunion enregistrée.');
    }

    public function show(Reunion $reunion)
    {
        return view('reunions.show', compact('reunion'));
    }

    public function edit(Reunion $reunion)
    {
        return view('reunions.edit', compact('reunion'));
    }

    public function update(Request $request, Reunion $reunion)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:200',
            'date_reunion' => 'required|date',
            'heure' => 'nullable|date_format:H:i',
            'lieu' => 'nullable|string|max:200',
            'ordre_du_jour' => 'nullable|string',
            'compte_rendu' => 'nullable|string',
            'statut' => 'required|in:planifie,tenu,annule',
        ]);

        $reunion->update($data);
        return redirect()->route('reunions.index')->with('success', 'Réunion modifiée.');
    }

    public function destroy(Reunion $reunion)
    {
        $reunion->delete();
        return redirect()->route('reunions.index')->with('success', 'Réunion supprimée.');
    }
}
