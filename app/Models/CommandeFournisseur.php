<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeFournisseur extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'fournisseur_id',
        'date_commande',
        'date_reception',
        'total',
        'bon_livraison',
        'statut'
    ];

    protected $casts = [
        'date_commande' => 'date',
        'date_reception' => 'date',
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function lignes()
    {
    return $this->hasMany(LigneCommande::class);
    }
}
