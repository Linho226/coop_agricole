<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Support\Facades\Auth;

class BuyerOrderController extends Controller
{
    public function index()
    {
        if (! Auth::check() || Auth::user()->role !== 'membre') {
            return redirect()->route('buyer.login');
        }

        $commandes = Commande::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('public.buyer.orders', compact('commandes'));
    }

    public function show(Commande $commande)
    {
        if (! Auth::check() || Auth::user()->role !== 'membre') {
            return redirect()->route('buyer.login');
        }

        abort_unless($commande->user_id === Auth::id(), 403);

        $commande->load('items');

        return view('public.buyer.order-show', compact('commande'));
    }
}
