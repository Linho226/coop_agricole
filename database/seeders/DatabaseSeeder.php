<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Compte administrateur
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@coop.local',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'actif' => true,
        ]);

        // Compte secrétaire
        User::create([
            'name' => 'Secrétaire',
            'email' => 'secretaire@coop.local',
            'password' => Hash::make('secretaire123'),
            'role' => 'secretaire',
            'actif' => true,
        ]);

        // Compte comptable
        User::create([
            'name' => 'Comptable',
            'email' => 'comptable@coop.local',
            'password' => Hash::make('comptable123'),
            'role' => 'comptable',
            'actif' => true,
        ]);

        // Produits de base
        $produits = [
            ['nom' => 'Maïs', 'unite' => 'kg'],
            ['nom' => 'Riz', 'unite' => 'kg'],
            ['nom' => 'Tomate', 'unite' => 'kg'],
            ['nom' => 'Oignon', 'unite' => 'kg'],
            ['nom' => 'Manioc', 'unite' => 'kg'],
            ['nom' => 'Arachide', 'unite' => 'kg'],
            ['nom' => 'Haricot', 'unite' => 'kg'],
            ['nom' => 'Banane plantain', 'unite' => 'botte'],
        ];

        foreach ($produits as $p) {
            Produit::create($p);
        }
    }
}