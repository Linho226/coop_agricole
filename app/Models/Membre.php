<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membre extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'prenom', 'sexe', 'telephone', 'adresse',
        'date_adhesion', 'activite_agricole', 'photo', 'actif', 'user_id',
    ];

    protected $casts = [
        'date_adhesion' => 'date',
        'actif' => 'boolean',
    ];

    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cotisations()
    {
        return $this->hasMany(Cotisation::class);
    }

    public function recoltes()
    {
        return $this->hasMany(Recolte::class);
    }

    public function reunions()
    {
        return $this->belongsToMany(Reunion::class, 'membre_reunion')
            ->withPivot('present')
            ->withTimestamps();
    }
}
