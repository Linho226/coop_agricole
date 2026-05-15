<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recolte extends Model
{
    use HasFactory;

    protected $fillable = [
        'produit_id', 'membre_id', 'quantite', 'date_recolte', 'parcelle', 'observation', 'user_id',
    ];

    protected $casts = [
        'date_recolte' => 'date',
        'quantite' => 'decimal:3',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
