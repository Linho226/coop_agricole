<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Membre;
use App\Models\Produit;
use App\Models\Recolte;
use App\Models\Reunion;
use App\Models\Vente;
use Illuminate\Support\Facades\Schema;

class PublicController extends Controller
{
    public function home()
    {
        return view('public.home', [
            'stats' => [
                'membres' => $this->hasTable('membres') ? Membre::where('actif', true)->count() : 0,
                'produits' => $this->hasTable('produits') ? Produit::count() : 0,
                'recoltes' => $this->hasTable('recoltes') ? (float) Recolte::sum('quantite') : 0,
                'revenus' => $this->hasTable('ventes') ? (float) Vente::sum('montant_total') : 0,
            ],
            'produits' => $this->hasTable('produits')
                ? Produit::where('publie', true)
                    ->where('stock_disponible', '>', 0)
                    ->orderByDesc('stock_disponible')
                    ->orderBy('nom')
                    ->take(6)
                    ->get()
                : collect(),
            'activites' => $this->hasTable('activites')
                ? Activite::orderByRaw("CASE WHEN statut = 'en_cours' THEN 0 WHEN statut = 'planifie' THEN 1 ELSE 2 END")
                ->orderByDesc('date_debut')
                ->take(3)
                ->get()
                : collect(),
            'reunions' => $this->hasTable('reunions')
                ? Reunion::whereIn('statut', ['planifie', 'tenu'])
                ->orderByDesc('date_reunion')
                ->take(3)
                ->get()
                : collect(),
        ]);
    }

    private function hasTable(string $table): bool
    {
        return Schema::hasTable($table);
    }
}
