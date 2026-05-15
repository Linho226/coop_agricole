# CoopAgricole — Gestion de coopérative agricole

Application web de gestion d'une coopérative agricole développée avec **Laravel 12** et **Bootstrap 5.3**.

## Modules

- Membres, Cotisations, Récoltes, Ventes, Dépenses
- Produits (avec image et page de détail)
- Activités, Réunions
- Tableau de bord synthétique
- Gestion des utilisateurs avec rôles

## Stack

- **Backend** : Laravel 12 / PHP 8.2+
- **Frontend** : Bootstrap 5.3.3 + Bootstrap Icons (CDN)
- **Base de données** : SQLite
- **Thème** : Mode clair / sombre

## Installation

\\\ash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
\\\

## Comptes par défaut

| Email | Mot de passe | Rôle |
|---|---|---|
| \dmin@coop.mg\ | \password\ | Admin |
| \secretaire@coop.mg\ | \password\ | Secrétaire |
| \comptable@coop.mg\ | \password\ | Comptable |

## Rôles

| Rôle | Accès |
|---|---|
| \dmin\ | Tout |
| \secretaire\ | Membres, Activités, Réunions |
| \comptable\ | Cotisations, Récoltes, Ventes, Dépenses |
| \membre\ | Tableau de bord |
