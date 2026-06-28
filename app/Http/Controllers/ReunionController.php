<?php

namespace App\Http\Controllers;

use App\Models\Membre;
use App\Models\Reunion;
use Illuminate\Http\Request;

class ReunionController extends Controller
{
    public function index(Request $request)
    {
        $query = Reunion::withCount('participants');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('type_reunion')) {
            $query->where('type_reunion', $request->type_reunion);
        }

        $reunions = $query->latest('date_reunion')->paginate(15)->withQueryString();
        return view('reunions.index', compact('reunions'));
    }

    public function create()
    {
        $membres = Membre::where('actif', true)->orderBy('nom')->get();

        return view('reunions.create', compact('membres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:200',
            'type_reunion' => 'required|in:ordinaire,extraordinaire,assemblee_generale,financiere,production',
            'date_reunion' => 'required|date',
            'heure' => 'nullable|date_format:H:i',
            'lieu' => 'nullable|string|max:200',
            'ordre_du_jour' => 'nullable|string',
            'compte_rendu' => 'nullable|string',
            'decisions' => 'nullable|string',
            'actions_suivi' => 'nullable|string',
            'statut' => 'required|in:planifie,tenu,annule',
            'participants' => 'nullable|array',
            'participants.*' => 'exists:membres,id',
        ]);

        $participants = $data['participants'] ?? [];
        unset($data['participants']);

        $data['user_id'] = auth()->id();
        $reunion = Reunion::create($data);
        $this->syncParticipants($reunion, $participants);

        return redirect()->route('reunions.index')->with('success', 'Réunion enregistrée.');
    }

    public function show(Reunion $reunion)
    {
        $reunion->load('participants');

        return view('reunions.show', compact('reunion'));
    }

    public function edit(Reunion $reunion)
    {
        $reunion->load('participants');
        $membres = Membre::where('actif', true)->orderBy('nom')->get();

        return view('reunions.edit', compact('reunion', 'membres'));
    }

    public function update(Request $request, Reunion $reunion)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:200',
            'type_reunion' => 'required|in:ordinaire,extraordinaire,assemblee_generale,financiere,production',
            'date_reunion' => 'required|date',
            'heure' => 'nullable|date_format:H:i',
            'lieu' => 'nullable|string|max:200',
            'ordre_du_jour' => 'nullable|string',
            'compte_rendu' => 'nullable|string',
            'decisions' => 'nullable|string',
            'actions_suivi' => 'nullable|string',
            'statut' => 'required|in:planifie,tenu,annule',
            'participants' => 'nullable|array',
            'participants.*' => 'exists:membres,id',
        ]);

        $participants = $data['participants'] ?? [];
        unset($data['participants']);

        $reunion->update($data);
        $this->syncParticipants($reunion, $participants);

        return redirect()->route('reunions.index')->with('success', 'Réunion modifiée.');
    }

    public function destroy(Reunion $reunion)
    {
        $reunion->delete();
        return redirect()->route('reunions.index')->with('success', 'Réunion supprimée.');
    }

    private function syncParticipants(Reunion $reunion, array $participants): void
    {
        $syncData = collect($participants)
            ->mapWithKeys(fn ($membreId) => [(int) $membreId => ['present' => true]])
            ->all();

        $reunion->participants()->sync($syncData);
    }
}
