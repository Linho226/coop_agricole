<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Depense extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle', 'montant', 'date_depense', 'categorie', 'description', 'user_id',
    ];

    protected $casts = [
        'date_depense' => 'date',
        'montant' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCategorieLabelAttribute(): string
    {
        return match($this->categorie) {
            'engrais' => 'Engrais',
            'carburant' => 'Carburant',
            'materiel' => 'Matériel agricole',
            'transport' => 'Transport',
            'salaire' => 'Salaire',
            'autre' => 'Autre',
            default => $this->categorie,
        };
    }
}
