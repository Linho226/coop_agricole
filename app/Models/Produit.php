<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'unite',
        'prix_unitaire',
        'stock_disponible',
        'publie',
        'description',
        'image',
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
        'stock_disponible' => 'decimal:3',
        'publie' => 'boolean',
    ];

    public function recoltes()
    {
        return $this->hasMany(Recolte::class);
    }

    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }

    public function commandeItems()
    {
        return $this->hasMany(CommandeItem::class);
    }
}
