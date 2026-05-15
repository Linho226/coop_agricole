<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $type_activite
 * @property string $responsable
 * @property \Illuminate\Support\Carbon $date_debut
 * @property \Illuminate\Support\Carbon|null $date_fin
 * @property string|null $description
 * @property string $statut
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $statut_color
 * @property-read string $statut_label
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activite whereDateDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activite whereDateFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activite whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activite whereResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activite whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activite whereTypeActivite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activite whereUserId($value)
 */
	class Activite extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $membre_id
 * @property numeric $montant
 * @property \Illuminate\Support\Carbon $date_paiement
 * @property string $mode_paiement
 * @property string|null $observation
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Membre $membre
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cotisation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cotisation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cotisation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cotisation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cotisation whereDatePaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cotisation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cotisation whereMembreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cotisation whereModePaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cotisation whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cotisation whereObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cotisation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cotisation whereUserId($value)
 */
	class Cotisation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $libelle
 * @property numeric $montant
 * @property \Illuminate\Support\Carbon $date_depense
 * @property string $categorie
 * @property string|null $description
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $categorie_label
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereDateDepense($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereUserId($value)
 */
	class Depense extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $sexe
 * @property string|null $telephone
 * @property string|null $adresse
 * @property \Illuminate\Support\Carbon $date_adhesion
 * @property string|null $activite_agricole
 * @property string|null $photo
 * @property bool $actif
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cotisation> $cotisations
 * @property-read int|null $cotisations_count
 * @property-read string $nom_complet
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recolte> $recoltes
 * @property-read int|null $recoltes_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre whereActif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre whereActiviteAgricole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre whereDateAdhesion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membre whereUserId($value)
 */
	class Membre extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nom
 * @property string $unite
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recolte> $recoltes
 * @property-read int|null $recoltes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vente> $ventes
 * @property-read int|null $ventes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereUnite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereUpdatedAt($value)
 */
	class Produit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $produit_id
 * @property int $membre_id
 * @property numeric $quantite
 * @property \Illuminate\Support\Carbon $date_recolte
 * @property string|null $parcelle
 * @property string|null $observation
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Membre $membre
 * @property-read \App\Models\Produit $produit
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recolte newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recolte newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recolte query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recolte whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recolte whereDateRecolte($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recolte whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recolte whereMembreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recolte whereObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recolte whereParcelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recolte whereProduitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recolte whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recolte whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recolte whereUserId($value)
 */
	class Recolte extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $titre
 * @property \Illuminate\Support\Carbon $date_reunion
 * @property string|null $heure
 * @property string|null $lieu
 * @property string|null $ordre_du_jour
 * @property string|null $compte_rendu
 * @property string $statut
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $statut_color
 * @property-read string $statut_label
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion whereCompteRendu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion whereDateReunion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion whereHeure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion whereLieu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion whereOrdreDuJour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion whereTitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reunion whereUserId($value)
 */
	class Reunion extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $role
 * @property bool $actif
 * @property-read \App\Models\Membre|null $membre
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereActif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $produit_id
 * @property numeric $quantite
 * @property numeric $prix_unitaire
 * @property numeric $montant_total
 * @property string|null $client
 * @property \Illuminate\Support\Carbon $date_vente
 * @property string|null $observation
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Produit $produit
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereDateVente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereMontantTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente wherePrixUnitaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereProduitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereUserId($value)
 */
	class Vente extends \Eloquent {}
}

