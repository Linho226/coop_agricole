<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\RecolteController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\ReunionController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\BuyerAuthController;
use App\Http\Controllers\BuyerOrderController;

// Authentification
Route::get('/', [PublicController::class, 'home'])->name('public.home');
Route::get('/catalogue', [CatalogueController::class, 'index'])->name('catalogue.index');
Route::get('/catalogue/{produit}', [CatalogueController::class, 'show'])->name('catalogue.show');
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/{produit}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/panier/{produit}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/panier/{produit}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/commande', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/commande', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/commande/{commande}/confirmation', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/inscription', [BuyerAuthController::class, 'showRegister'])->name('buyer.register');
Route::post('/inscription', [BuyerAuthController::class, 'register'])->name('buyer.register.store');
Route::get('/connexion', [BuyerAuthController::class, 'showLogin'])->name('buyer.login');
Route::post('/connexion', [BuyerAuthController::class, 'login'])->name('buyer.login.store');
Route::post('/deconnexion-acheteur', [BuyerAuthController::class, 'logout'])->name('buyer.logout');
Route::get('/mes-commandes', [BuyerOrderController::class, 'index'])->name('buyer.orders');
Route::get('/mes-commandes/{commande}', [BuyerOrderController::class, 'show'])->name('buyer.orders.show');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées (tous les utilisateurs connectés)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role:admin,secretaire,comptable');

    // Membres — admin, secretaire
    Route::resource('membres', MembreController::class)->middleware('role:admin,secretaire');

    // Cotisations — admin, comptable
    Route::resource('cotisations', CotisationController::class)->middleware('role:admin,comptable');

    // Activités — admin, secretaire
    Route::resource('activites', ActiviteController::class)->middleware('role:admin,secretaire');

    // Récoltes — admin, comptable
    Route::resource('recoltes', RecolteController::class)->except(['show'])->middleware('role:admin,comptable');

    // Ventes — admin, comptable
    Route::resource('ventes', VenteController::class)->except(['show'])->middleware('role:admin,comptable');

    // Commandes publiques — admin, comptable
    Route::get('commandes', [CommandeController::class, 'index'])->name('commandes.index')->middleware('role:admin,comptable');
    Route::get('commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show')->middleware('role:admin,comptable');
    Route::patch('commandes/{commande}/statut', [CommandeController::class, 'updateStatus'])->name('commandes.status')->middleware('role:admin,comptable');

    // Dépenses — admin, comptable
    Route::resource('depenses', DepenseController::class)->except(['show'])->middleware('role:admin,comptable');

    // Réunions — admin, secretaire
    Route::resource('reunions', ReunionController::class)->middleware('role:admin,secretaire');

    // Produits — admin uniquement
    Route::resource('produits', ProduitController::class)->middleware('role:admin');

    // Utilisateurs — admin uniquement
    Route::resource('users', UserController::class)->except(['show'])->middleware('role:admin');
});
