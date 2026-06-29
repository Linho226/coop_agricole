<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Produit;
use App\Models\Membre;
use App\Models\Activite;
use App\Models\Cotisation;
use App\Models\Recolte;
use App\Models\Reunion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Compte administrateur
        User::updateOrCreate(['email' => 'admin@coop.local'], [
            'name' => 'Administrateur',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'actif' => true,
        ]);

        // Compte secrétaire
        User::updateOrCreate(['email' => 'secretaire@coop.local'], [
            'name' => 'Secrétaire',
            'password' => Hash::make('secretaire123'),
            'role' => 'secretaire',
            'actif' => true,
        ]);

        // Compte comptable
        User::updateOrCreate(['email' => 'comptable@coop.local'], [
            'name' => 'Comptable',
            'password' => Hash::make('comptable123'),
            'role' => 'comptable',
            'actif' => true,
        ]);

        // Produits de base
        $produits = [
            ['nom' => 'Maïs', 'unite' => 'kg', 'prix_unitaire' => 250, 'stock_disponible' => 500, 'publie' => true],
            ['nom' => 'Riz', 'unite' => 'kg', 'prix_unitaire' => 450, 'stock_disponible' => 350, 'publie' => true],
            ['nom' => 'Tomate', 'unite' => 'kg', 'prix_unitaire' => 600, 'stock_disponible' => 120, 'publie' => true],
            ['nom' => 'Oignon', 'unite' => 'kg', 'prix_unitaire' => 500, 'stock_disponible' => 180, 'publie' => true],
            ['nom' => 'Manioc', 'unite' => 'kg', 'prix_unitaire' => 300, 'stock_disponible' => 250, 'publie' => true],
            ['nom' => 'Arachide', 'unite' => 'kg', 'prix_unitaire' => 700, 'stock_disponible' => 90, 'publie' => true],
            ['nom' => 'Haricot', 'unite' => 'kg', 'prix_unitaire' => 650, 'stock_disponible' => 140, 'publie' => true],
            ['nom' => 'Banane plantain', 'unite' => 'botte', 'prix_unitaire' => 1000, 'stock_disponible' => 60, 'publie' => true],
        ];

        foreach ($produits as $p) {
            Produit::updateOrCreate(['nom' => $p['nom']], $p);
        }

        $admin = User::where('email', 'admin@coop.local')->first();
        $secretaire = User::where('email', 'secretaire@coop.local')->first();
        $comptable = User::where('email', 'comptable@coop.local')->first();

        // Membres de démonstration
        $membres = [
            [
                'nom' => 'GANSONRE',
                'prenom' => 'Alain',
                'sexe' => 'M',
                'telephone' => '70010001',
                'adresse' => 'Koudougou - Secteur 4',
                'date_adhesion' => '2024-01-15',
                'activite_agricole' => 'Maïs et arachide',
                'actif' => true,
                'user_id' => $secretaire?->id,
            ],
            [
                'nom' => 'OUEDRAOGO',
                'prenom' => 'Awa',
                'sexe' => 'F',
                'telephone' => '70010002',
                'adresse' => 'Sabou',
                'date_adhesion' => '2024-02-10',
                'activite_agricole' => 'Riz et légumes',
                'actif' => true,
                'user_id' => $secretaire?->id,
            ],
            [
                'nom' => 'KABORE',
                'prenom' => 'Moussa',
                'sexe' => 'M',
                'telephone' => '70010003',
                'adresse' => 'Réo',
                'date_adhesion' => '2024-03-05',
                'activite_agricole' => 'Manioc et haricot',
                'actif' => true,
                'user_id' => $secretaire?->id,
            ],
            [
                'nom' => 'ZONGO',
                'prenom' => 'Fatou',
                'sexe' => 'F',
                'telephone' => '70010004',
                'adresse' => 'Kokologho',
                'date_adhesion' => '2024-04-18',
                'activite_agricole' => 'Oignon et tomate',
                'actif' => true,
                'user_id' => $secretaire?->id,
            ],
            [
                'nom' => 'BARRY',
                'prenom' => 'Issa',
                'sexe' => 'M',
                'telephone' => '70010005',
                'adresse' => 'Dédougou',
                'date_adhesion' => '2024-05-22',
                'activite_agricole' => 'Banane plantain',
                'actif' => true,
                'user_id' => $secretaire?->id,
            ],
        ];

        foreach ($membres as $membre) {
            Membre::updateOrCreate(
                ['telephone' => $membre['telephone']],
                $membre
            );
        }

        $alain = Membre::where('telephone', '70010001')->first();
        $awa = Membre::where('telephone', '70010002')->first();
        $moussa = Membre::where('telephone', '70010003')->first();
        $fatou = Membre::where('telephone', '70010004')->first();
        $issa = Membre::where('telephone', '70010005')->first();

        // Activités agricoles
        $activites = [
            [
                'type_activite' => 'Préparation des parcelles',
                'responsable' => 'Alain GANSONRE',
                'date_debut' => now()->subDays(18)->toDateString(),
                'date_fin' => now()->subDays(10)->toDateString(),
                'description' => 'Nettoyage, labour et organisation des parcelles de production.',
                'statut' => 'termine',
                'user_id' => $secretaire?->id,
            ],
            [
                'type_activite' => 'Distribution des semences',
                'responsable' => 'Awa OUEDRAOGO',
                'date_debut' => now()->subDays(6)->toDateString(),
                'date_fin' => null,
                'description' => 'Distribution des semences améliorées aux membres actifs.',
                'statut' => 'en_cours',
                'user_id' => $secretaire?->id,
            ],
            [
                'type_activite' => 'Formation sur la conservation',
                'responsable' => 'Moussa KABORE',
                'date_debut' => now()->addDays(8)->toDateString(),
                'date_fin' => now()->addDays(8)->toDateString(),
                'description' => 'Session pratique sur le stockage et la réduction des pertes.',
                'statut' => 'planifie',
                'user_id' => $secretaire?->id,
            ],
        ];

        foreach ($activites as $activite) {
            Activite::updateOrCreate(
                ['type_activite' => $activite['type_activite'], 'date_debut' => $activite['date_debut']],
                $activite
            );
        }

        // Réunions avec participants
        $reunions = [
            [
                'titre' => 'Réunion mensuelle des producteurs',
                'type_reunion' => 'ordinaire',
                'date_reunion' => now()->addDays(5)->toDateString(),
                'heure' => '09:00',
                'lieu' => 'Salle de la coopérative',
                'ordre_du_jour' => 'Point sur les cotisations, calendrier des récoltes et besoins en intrants.',
                'compte_rendu' => null,
                'decisions' => null,
                'actions_suivi' => 'Préparer la liste des membres en retard de cotisation.',
                'statut' => 'planifie',
                'user_id' => $secretaire?->id,
                'participants' => [$alain?->id, $awa?->id, $moussa?->id, $fatou?->id],
            ],
            [
                'titre' => 'Bilan financier du trimestre',
                'type_reunion' => 'financiere',
                'date_reunion' => now()->subDays(12)->toDateString(),
                'heure' => '15:00',
                'lieu' => 'Bureau comptable',
                'ordre_du_jour' => 'Analyse des cotisations reçues et validation des dépenses prioritaires.',
                'compte_rendu' => 'Les membres ont validé le point financier et demandé un suivi régulier des paiements partiels.',
                'decisions' => 'Produire un état mensuel des cotisations par membre.',
                'actions_suivi' => 'Mettre à jour les reçus et relancer les membres avec reste à payer.',
                'statut' => 'tenu',
                'user_id' => $comptable?->id,
                'participants' => [$alain?->id, $awa?->id, $issa?->id],
            ],
        ];

        foreach ($reunions as $data) {
            $participants = array_values(array_filter($data['participants']));
            unset($data['participants']);

            $reunion = Reunion::updateOrCreate(
                ['titre' => $data['titre'], 'date_reunion' => $data['date_reunion']],
                $data
            );

            $reunion->participants()->sync(collect($participants)->mapWithKeys(fn ($id) => [
                $id => ['present' => true],
            ])->all());
        }

        // Cotisations : payée, partielle et en attente de complément
        $cotisations = [
            [
                'reference' => 'COT-20260628-ALAIN',
                'membre_id' => $alain?->id,
                'type_cotisation' => 'mensuelle',
                'periode_mois' => now()->month,
                'periode_annee' => now()->year,
                'montant_attendu' => 10000,
                'montant' => 10000,
                'date_paiement' => now()->subDays(3)->toDateString(),
                'mode_paiement' => 'mobile_money',
                'statut' => 'paye',
                'observation' => 'Cotisation mensuelle entièrement payée.',
                'user_id' => $comptable?->id,
            ],
            [
                'reference' => 'COT-20260628-AWA01',
                'membre_id' => $awa?->id,
                'type_cotisation' => 'mensuelle',
                'periode_mois' => now()->month,
                'periode_annee' => now()->year,
                'montant_attendu' => 10000,
                'montant' => 5000,
                'date_paiement' => now()->subDays(2)->toDateString(),
                'mode_paiement' => 'especes',
                'statut' => 'partiel',
                'observation' => 'Paiement partiel, reste à compléter.',
                'user_id' => $comptable?->id,
            ],
            [
                'reference' => 'COT-20260628-MOUS1',
                'membre_id' => $moussa?->id,
                'type_cotisation' => 'adhesion',
                'periode_mois' => null,
                'periode_annee' => now()->year,
                'montant_attendu' => 15000,
                'montant' => 15000,
                'date_paiement' => now()->subDays(8)->toDateString(),
                'mode_paiement' => 'virement',
                'statut' => 'paye',
                'observation' => 'Frais d’adhésion réglés.',
                'user_id' => $comptable?->id,
            ],
        ];

        foreach ($cotisations as $cotisation) {
            if (! $cotisation['membre_id']) {
                continue;
            }

            Cotisation::updateOrCreate(
                ['reference' => $cotisation['reference']],
                $cotisation
            );
        }

        // Récoltes par membre et par produit
        $recoltes = [
            [
                'produit' => 'Maïs',
                'membre_id' => $alain?->id,
                'quantite' => 280,
                'date_recolte' => now()->subDays(14)->toDateString(),
                'parcelle' => 'Parcelle A1',
                'observation' => 'Bonne qualité, récolte bien séchée.',
                'user_id' => $comptable?->id,
            ],
            [
                'produit' => 'Riz',
                'membre_id' => $awa?->id,
                'quantite' => 180,
                'date_recolte' => now()->subDays(11)->toDateString(),
                'parcelle' => 'Bas-fond B2',
                'observation' => 'Récolte humide à surveiller.',
                'user_id' => $comptable?->id,
            ],
            [
                'produit' => 'Haricot',
                'membre_id' => $moussa?->id,
                'quantite' => 95,
                'date_recolte' => now()->subDays(7)->toDateString(),
                'parcelle' => 'Champ C3',
                'observation' => 'Production conforme aux prévisions.',
                'user_id' => $comptable?->id,
            ],
            [
                'produit' => 'Oignon',
                'membre_id' => $fatou?->id,
                'quantite' => 120,
                'date_recolte' => now()->subDays(4)->toDateString(),
                'parcelle' => 'Périmètre maraîcher D1',
                'observation' => 'Tri recommandé avant vente.',
                'user_id' => $comptable?->id,
            ],
        ];

        foreach ($recoltes as $recolte) {
            $produit = Produit::where('nom', $recolte['produit'])->first();

            if (! $produit || ! $recolte['membre_id']) {
                continue;
            }

            unset($recolte['produit']);
            $recolte['produit_id'] = $produit->id;

            Recolte::updateOrCreate(
                [
                    'produit_id' => $recolte['produit_id'],
                    'membre_id' => $recolte['membre_id'],
                    'date_recolte' => $recolte['date_recolte'],
                    'parcelle' => $recolte['parcelle'],
                ],
                $recolte
            );
        }
    }
}