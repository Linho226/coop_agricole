<?php

namespace App\Http\Controllers;

use App\Models\Membre;
use App\Models\Cotisation;
use App\Models\Activite;
use App\Models\Commande;
use App\Models\Vente;
use App\Models\Depense;
use App\Models\Produit;
use App\Models\Recolte;
use App\Models\Reunion;

class DashboardController extends Controller
{
    public function index()
    {
        $debutMois = now()->startOfMonth();
        $finMois = now()->endOfMonth();
        $totalCotisations = (float) Cotisation::sum('montant');
        $totalVentes = (float) Vente::sum('montant_total');
        $totalDepenses = (float) Depense::sum('montant');
        $totalCommandes = (float) Commande::where('statut', '!=', 'annulee')->sum('montant_total');
        $revenus = $totalCotisations + $totalVentes + $totalCommandes;
        $solde = $revenus - $totalDepenses;

        $stats = [
            'total_membres' => Membre::where('actif', true)->count(),
            'membres_inactifs' => Membre::where('actif', false)->count(),
            'total_cotisations' => $totalCotisations,
            'total_ventes' => $totalVentes,
            'total_commandes' => $totalCommandes,
            'total_depenses' => $totalDepenses,
            'revenus' => $revenus,
            'solde' => $solde,
            'cotisations_mois' => (float) Cotisation::whereBetween('date_paiement', [$debutMois, $finMois])->sum('montant'),
            'ventes_mois' => (float) Vente::whereBetween('date_vente', [$debutMois, $finMois])->sum('montant_total'),
            'depenses_mois' => (float) Depense::whereBetween('date_depense', [$debutMois, $finMois])->sum('montant'),
            'commandes_en_attente' => Commande::where('statut', 'en_attente')->count(),
            'commandes_livrees' => Commande::where('statut', 'livree')->count(),
            'produits_publies' => Produit::where('publie', true)->count(),
            'stock_total' => (float) Produit::sum('stock_disponible'),
            'stock_faible' => Produit::where('stock_disponible', '<=', 10)->count(),
            'activites_en_cours' => Activite::where('statut', 'en_cours')->count(),
            'reunions_planifiees' => Reunion::where('statut', 'planifie')->count(),
        ];

        $derniers_membres = Membre::latest()->take(5)->get();
        $dernieres_cotisations = Cotisation::with('membre')->latest()->take(5)->get();
        $dernieres_activites = Activite::latest()->take(5)->get();
        $dernieres_commandes = Commande::latest()->take(5)->get();
        $produits_stock_faible = Produit::where('stock_disponible', '<=', 10)->orderBy('stock_disponible')->take(6)->get();

        $series = $this->monthlySeries();
        $charts = [
            'finance' => [
                'labels' => $series['labels'],
                'cotisations' => $series['cotisations'],
                'ventes' => $series['ventes'],
                'depenses' => $series['depenses'],
            ],
            'recoltes' => Recolte::query()
                ->selectRaw('produits.nom as label, SUM(recoltes.quantite) as value')
                ->join('produits', 'produits.id', '=', 'recoltes.produit_id')
                ->groupBy('produits.id', 'produits.nom')
                ->orderByDesc('value')
                ->take(6)
                ->get(),
            'ventes_produits' => Vente::query()
                ->selectRaw('produits.nom as label, SUM(ventes.montant_total) as value')
                ->join('produits', 'produits.id', '=', 'ventes.produit_id')
                ->groupBy('produits.id', 'produits.nom')
                ->orderByDesc('value')
                ->take(6)
                ->get(),
            'depenses_categories' => Depense::query()
                ->selectRaw('categorie as label, SUM(montant) as value')
                ->groupBy('categorie')
                ->orderByDesc('value')
                ->get()
                ->map(fn ($item) => [
                    'label' => ucfirst(str_replace('_', ' ', $item->label)),
                    'value' => (float) $item->value,
                ]),
            'commandes_statuts' => Commande::query()
                ->selectRaw('statut as label, COUNT(*) as value')
                ->groupBy('statut')
                ->get()
                ->map(fn ($item) => [
                    'label' => str_replace('_', ' ', ucfirst($item->label)),
                    'value' => (int) $item->value,
                ]),
            'activites_statuts' => Activite::query()
                ->selectRaw('statut as label, COUNT(*) as value')
                ->groupBy('statut')
                ->get()
                ->map(fn ($item) => [
                    'label' => str_replace('_', ' ', ucfirst($item->label)),
                    'value' => (int) $item->value,
                ]),
        ];

        return view('dashboard', compact(
            'stats',
            'charts',
            'derniers_membres',
            'dernieres_cotisations',
            'dernieres_activites',
            'dernieres_commandes',
            'produits_stock_faible'
        ));
    }

    private function monthlySeries(): array
    {
        $labels = [];
        $cotisations = [];
        $ventes = [];
        $depenses = [];

        for ($i = 5; $i >= 0; $i--) {
            $start = now()->startOfMonth()->subMonths($i);
            $end = $start->copy()->endOfMonth();

            $labels[] = ucfirst($start->translatedFormat('M'));
            $cotisations[] = (float) Cotisation::whereBetween('date_paiement', [$start, $end])->sum('montant');
            $ventes[] = (float) Vente::whereBetween('date_vente', [$start, $end])->sum('montant_total');
            $depenses[] = (float) Depense::whereBetween('date_depense', [$start, $end])->sum('montant');
        }

        return compact('labels', 'cotisations', 'ventes', 'depenses');
    }
}
