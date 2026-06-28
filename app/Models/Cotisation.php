<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cotisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'membre_id',
        'type_cotisation',
        'periode_mois',
        'periode_annee',
        'montant_attendu',
        'montant',
        'date_paiement',
        'mode_paiement',
        'statut',
        'observation',
        'user_id',
    ];

    protected $casts = [
        'date_paiement' => 'date',
        'montant' => 'decimal:2',
        'montant_attendu' => 'decimal:2',
        'periode_mois' => 'integer',
        'periode_annee' => 'integer',
    ];

    public static function typeOptions(): array
    {
        return [
            'mensuelle' => 'Cotisation mensuelle',
            'annuelle' => 'Cotisation annuelle',
            'adhesion' => 'Adhésion',
            'penalite' => 'Pénalité',
            'contribution_speciale' => 'Contribution spéciale',
        ];
    }

    public static function statutOptions(): array
    {
        return [
            'paye' => 'Payée',
            'partiel' => 'Partielle',
            'annule' => 'Annulée',
        ];
    }

    public static function modeOptions(): array
    {
        return [
            'especes' => 'Espèces',
            'mobile_money' => 'Mobile Money',
            'virement' => 'Virement',
            'autre' => 'Autre',
        ];
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getReferenceLabelAttribute(): string
    {
        return $this->reference ?: 'COT-' . str_pad((string) $this->id, 5, '0', STR_PAD_LEFT);
    }

    public function getTypeLabelAttribute(): string
    {
        return self::typeOptions()[$this->type_cotisation] ?? 'Cotisation';
    }

    public function getStatutLabelAttribute(): string
    {
        return self::statutOptions()[$this->statut] ?? 'Payée';
    }

    public function getStatutBadgeClassAttribute(): string
    {
        return match ($this->statut) {
            'partiel' => 'bg-warning text-dark',
            'annule' => 'bg-secondary',
            default => 'bg-success',
        };
    }

    public function getModeLabelAttribute(): string
    {
        return self::modeOptions()[$this->mode_paiement] ?? ucfirst(str_replace('_', ' ', (string) $this->mode_paiement));
    }

    public function getPeriodeLabelAttribute(): string
    {
        if (! $this->periode_annee && ! $this->periode_mois) {
            return 'Non précisée';
        }

        if (! $this->periode_mois) {
            return (string) $this->periode_annee;
        }

        $mois = [
            1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Août',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre',
        ][$this->periode_mois] ?? 'Mois';

        return trim($mois . ' ' . $this->periode_annee);
    }

    public function getResteAPayerAttribute(): float
    {
        $attendu = (float) $this->montant_attendu;

        if ($attendu <= 0 || $this->statut === 'annule') {
            return 0;
        }

        return max(0, $attendu - (float) $this->montant);
    }
}
