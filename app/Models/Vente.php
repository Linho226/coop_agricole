<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vente extends Model
{
    use HasFactory;

    protected $fillable = [
        'produit_id', 'quantite', 'prix_unitaire', 'montant_total', 'client', 'date_vente', 'observation', 'user_id',
    ];

    protected $casts = [
        'date_vente' => 'date',
        'quantite' => 'decimal:3',
        'prix_unitaire' => 'decimal:2',
        'montant_total' => 'decimal:2',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
