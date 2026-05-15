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

// Authentification
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées (tous les utilisateurs connectés)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Membres — admin, secretaire
    Route::resource('membres', MembreController::class)->middleware('role:admin,secretaire');

    // Cotisations — admin, comptable
    Route::resource('cotisations', CotisationController::class)->middleware('role:admin,comptable');

    // Activités — admin, secretaire
    Route::resource('activites', ActiviteController::class)->middleware('role:admin,secretaire');

    // Récoltes — admin, comptable
    Route::resource('recoltes', RecolteController::class)->middleware('role:admin,comptable');

    // Ventes — admin, comptable
    Route::resource('ventes', VenteController::class)->middleware('role:admin,comptable');

    // Dépenses — admin, comptable
    Route::resource('depenses', DepenseController::class)->middleware('role:admin,comptable');

    // Réunions — admin, secretaire
    Route::resource('reunions', ReunionController::class)->middleware('role:admin,secretaire');

    // Produits — admin uniquement
    Route::resource('produits', ProduitController::class)->middleware('role:admin');

    // Utilisateurs — admin uniquement
    Route::resource('users', UserController::class)->except(['show'])->middleware('role:admin');
});