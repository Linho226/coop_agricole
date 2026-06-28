<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reunion extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'type_reunion', 'date_reunion', 'heure', 'lieu', 'ordre_du_jour',
        'compte_rendu', 'decisions', 'actions_suivi', 'statut', 'user_id',
    ];

    protected $casts = [
        'date_reunion' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()
    {
        return $this->belongsToMany(Membre::class, 'membre_reunion')
            ->withPivot('present')
            ->withTimestamps();
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type_reunion) {
            'ordinaire' => 'Réunion ordinaire',
            'extraordinaire' => 'Réunion extraordinaire',
            'assemblee_generale' => 'Assemblée générale',
            'financiere' => 'Réunion financière',
            'production' => 'Réunion de production',
            default => $this->type_reunion,
        };
    }

    public function getStatutLabelAttribute(): string
    {
        return match($this->statut) {
            'planifie' => 'Planifiée',
            'tenu' => 'Tenue',
            'annule' => 'Annulée',
            default => $this->statut,
        };
    }

    public function getStatutColorAttribute(): string
    {
        return match($this->statut) {
            'planifie' => 'info',
            'tenu' => 'success',
            'annule' => 'danger',
            default => 'secondary',
        };
    }
}
