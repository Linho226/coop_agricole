<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $produits = $this->produitQuery()
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('nom', 'like', '%' . $request->q . '%');
            })
            ->orderBy('nom')
            ->paginate(9)
            ->withQueryString();

        return view('public.catalogue.index', compact('produits'));
    }

    public function show(Produit $produit)
    {
        abort_unless($this->isPublished($produit), 404);

        $similaires = $this->produitQuery()
            ->whereKeyNot($produit->id)
            ->orderBy('nom')
            ->take(3)
            ->get();

        return view('public.catalogue.show', compact('produit', 'similaires'));
    }

    private function produitQuery()
    {
        $query = Produit::query();

        if (Schema::hasColumn('produits', 'publie')) {
            $query->where('publie', true);
        }

        if (Schema::hasColumn('produits', 'stock_disponible')) {
            $query->where('stock_disponible', '>', 0);
        }

        return $query;
    }

    private function isPublished(Produit $produit): bool
    {
        if (Schema::hasColumn('produits', 'publie') && ! $produit->publie) {
            return false;
        }

        return ! Schema::hasColumn('produits', 'stock_disponible') || (float) $produit->stock_disponible > 0;
    }
}
