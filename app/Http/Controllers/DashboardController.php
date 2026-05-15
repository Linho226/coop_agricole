<?php

namespace App\Http\Controllers;

use App\Models\Membre;
use App\Models\Cotisation;
use App\Models\Activite;
use App\Models\Vente;
use App\Models\Depense;
use App\Models\Reunion;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_membres' => Membre::where('actif', true)->count(),
            'total_cotisations' => Cotisation::sum('montant'),
            'total_ventes' => Vente::sum('montant_total'),
            'total_depenses' => Depense::sum('montant'),
            'activites_en_cours' => Activite::where('statut', 'en_cours')->count(),
            'reunions_planifiees' => Reunion::where('statut', 'planifie')->count(),
        ];

        $derniers_membres = Membre::latest()->take(5)->get();
        $dernieres_cotisations = Cotisation::with('membre')->latest()->take(5)->get();
        $dernieres_activites = Activite::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'derniers_membres', 'dernieres_cotisations', 'dernieres_activites'));
    }
}