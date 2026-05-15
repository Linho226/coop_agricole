<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reunion extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'date_reunion', 'heure', 'lieu', 'ordre_du_jour', 'compte_rendu', 'statut', 'user_id',
    ];

    protected $casts = [
        'date_reunion' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
