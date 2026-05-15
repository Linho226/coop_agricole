<?php

namespace App\Http\Controllers;

use App\Models\Membre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MembreController extends Controller
{
    public function index(Request $request)
    {
        $query = Membre::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('prenom', 'like', "%$search%")
                  ->orWhere('telephone', 'like', "%$search%");
            });
        }

        if ($request->filled('sexe')) {
            $query->where('sexe', $request->sexe);
        }

        $membres = $query->orderBy('nom')->paginate(15)->withQueryString();

        return view('membres.index', compact('membres'));
    }

    public function create()
    {
        return view('membres.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'sexe' => 'required|in:M,F',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'date_adhesion' => 'required|date',
            'activite_agricole' => 'nullable|string|max:150',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('membres', 'public');
        }

        Membre::create($data);

        return redirect()->route('membres.index')->with('success', 'Membre ajouté avec succès.');
    }

    public function show(Membre $membre)
    {
        $membre->load(['cotisations', 'recoltes.produit']);
        return view('membres.show', compact('membre'));
    }

    public function edit(Membre $membre)
    {
        return view('membres.edit', compact('membre'));
    }

    public function update(Request $request, Membre $membre)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'sexe' => 'required|in:M,F',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'date_adhesion' => 'required|date',
            'activite_agricole' => 'nullable|string|max:150',
            'photo' => 'nullable|image|max:2048',
            'actif' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($membre->photo) {
                Storage::disk('public')->delete($membre->photo);
            }
            $data['photo'] = $request->file('photo')->store('membres', 'public');
        }

        $data['actif'] = $request->boolean('actif', true);
        $membre->update($data);

        return redirect()->route('membres.index')->with('success', 'Membre modifié avec succès.');
    }

    public function destroy(Membre $membre)
    {
        if ($membre->photo) {
            Storage::disk('public')->delete($membre->photo);
        }
        $membre->delete();
        return redirect()->route('membres.index')->with('success', 'Membre supprimé.');
    }
}
