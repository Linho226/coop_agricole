<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'unite', 'description', 'image'];

    public function recoltes()
    {
        return $this->hasMany(Recolte::class);
    }

    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }
}