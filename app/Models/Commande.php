<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commande extends Model
{
    protected $fillable = [
        'reference',
        'user_id',
        'nom_client',
        'telephone',
        'email',
        'adresse_livraison',
        'statut',
        'montant_total',
        'notes',
        'confirmee_at',
    ];

    protected $casts = [
        'montant_total' => 'decimal:2',
        'confirmee_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(CommandeItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatutLabelAttribute(): string
    {
        return match ($this->statut) {
            'en_attente' => 'En attente',
            'confirmee' => 'Confirmée',
            'preparee' => 'Préparée',
            'livree' => 'Livrée',
            'annulee' => 'Annulée',
            default => $this->statut,
        };
    }

    public function getStatutColorAttribute(): string
    {
        return match ($this->statut) {
            'en_attente' => 'warning',
            'confirmee' => 'info',
            'preparee' => 'primary',
            'livree' => 'success',
            'annulee' => 'danger',
            default => 'secondary',
        };
    }
}
