<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    protected $fillable = [
        'commande_fournisseur_id',
        'medicament_id',
        'quantite',
        'prix_achat'
    ];

    public function commande()
    {
    return $this->belongsTo(CommandeFournisseur::class);
    }

    public function medicament()
    {
    return $this->belongsTo(Medicament::class);
    }
}
