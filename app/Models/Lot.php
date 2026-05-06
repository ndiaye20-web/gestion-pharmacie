<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'medicament_id',
        'fournisseur_id',
        'numero_lot',
        'quantite',
        'date_expiration',
        'date_fabrication',
        'statut'

    ];

    protected $casts = [
        'date_expiration' => 'date',
        'date_fabrication' => 'date',
    ];

    public function medicament()
    {
        return $this->belongsTo(Medicament::class);
    }
}
