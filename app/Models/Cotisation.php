<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cotisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'membre_id', 'montant', 'date_paiement', 'mode_paiement', 'observation', 'user_id',
    ];

    protected $casts = [
        'date_paiement' => 'date',
        'montant' => 'decimal:2',
    ];

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
