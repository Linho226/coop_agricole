<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Membre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CotisationController extends Controller
{
    public function index(Request $request)
    {
        $query = Cotisation::with('membre')->latest('date_paiement')->latest('id');

        if ($request->filled('membre_id')) {
            $query->where('membre_id', $request->membre_id);
        }

        if ($request->filled('mois')) {
            $query->whereMonth('date_paiement', date('m', strtotime($request->mois)))
                  ->whereYear('date_paiement', date('Y', strtotime($request->mois)));
        }

        if ($request->filled('type_cotisation')) {
            $query->where('type_cotisation', $request->type_cotisation);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('annee')) {
            $query->where('periode_annee', $request->annee);
        }

        $statsQuery = (clone $query)->where('statut', '!=', 'annule');
        $total = (clone $statsQuery)->sum('montant');
        $totalAttendu = (clone $statsQuery)->sum('montant_attendu');
        $cotisationsCount = (clone $statsQuery)->count();
        $partiellesCount = (clone $statsQuery)->where('statut', 'partiel')->count();
        $resteTotal = max(0, $totalAttendu - $total);

        $cotisations = $query->paginate(15)->withQueryString();
        $membres = Membre::where('actif', true)->orderBy('nom')->get();
        $typeOptions = Cotisation::typeOptions();
        $statutOptions = Cotisation::statutOptions();
        $modeOptions = Cotisation::modeOptions();
        $annees = range((int) now()->year + 1, (int) now()->year - 5);

        return view('cotisations.index', compact(
            'cotisations',
            'membres',
            'total',
            'totalAttendu',
            'resteTotal',
            'cotisationsCount',
            'partiellesCount',
            'typeOptions',
            'statutOptions',
            'modeOptions',
            'annees'
        ));
    }

    public function create()
    {
        $membres = Membre::where('actif', true)->orderBy('nom')->get();
        $typeOptions = Cotisation::typeOptions();
        $statutOptions = Cotisation::statutOptions();
        $modeOptions = Cotisation::modeOptions();
        $annees = range((int) now()->year + 1, (int) now()->year - 5);

        return view('cotisations.create', compact('membres', 'typeOptions', 'statutOptions', 'modeOptions', 'annees'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $data['reference'] = $this->generateReference();
        $data['user_id'] = auth()->id();
        $cotisation = Cotisation::create($data);

        return redirect()->route('cotisations.show', $cotisation)->with('success', 'Cotisation enregistrée.');
    }

    public function show(Cotisation $cotisation)
    {
        $cotisation->load(['membre', 'user']);

        return view('cotisations.show', compact('cotisation'));
    }

    public function edit(Cotisation $cotisation)
    {
        $membres = Membre::where('actif', true)->orderBy('nom')->get();
        $typeOptions = Cotisation::typeOptions();
        $statutOptions = Cotisation::statutOptions();
        $modeOptions = Cotisation::modeOptions();
        $annees = range((int) now()->year + 1, (int) now()->year - 5);

        return view('cotisations.edit', compact('cotisation', 'membres', 'typeOptions', 'statutOptions', 'modeOptions', 'annees'));
    }

    public function update(Request $request, Cotisation $cotisation)
    {
        $data = $this->validatedData($request);

        $cotisation->update($data);

        return redirect()->route('cotisations.show', $cotisation)->with('success', 'Cotisation modifiée.');
    }

    public function destroy(Cotisation $cotisation)
    {
        $cotisation->delete();
        return redirect()->route('cotisations.index')->with('success', 'Cotisation supprimée.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'membre_id' => 'required|exists:membres,id',
            'type_cotisation' => 'required|in:mensuelle,annuelle,adhesion,penalite,contribution_speciale',
            'periode_mois' => 'nullable|integer|min:1|max:12',
            'periode_annee' => 'nullable|integer|min:2020|max:2100',
            'montant_attendu' => 'nullable|numeric|min:0',
            'montant' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|in:especes,mobile_money,virement,autre',
            'statut' => 'nullable|in:paye,partiel,annule',
            'observation' => 'nullable|string',
        ]);

        $data['montant_attendu'] = $data['montant_attendu'] ?? 0;
        $data['statut'] = $this->resolveStatut($data);

        return $data;
    }

    private function resolveStatut(array $data): string
    {
        if (($data['statut'] ?? null) === 'annule') {
            return 'annule';
        }

        $attendu = (float) ($data['montant_attendu'] ?? 0);
        $paye = (float) ($data['montant'] ?? 0);

        if ($attendu > 0 && $paye < $attendu) {
            return 'partiel';
        }

        return 'paye';
    }

    private function generateReference(): string
    {
        do {
            $reference = 'COT-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5));
        } while (Cotisation::where('reference', $reference)->exists());

        return $reference;
    }
}
