<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    protected $fillable = [
        'nom_commercial',
        'dci',
        'code_cip13',
        'forme',
        'dosage',
        'classe',
        'laboratoire',
        'remboursable',
        'taux_remboursement',
        'prix_achat',
        'prix_vente'
    ];

    public function lots()
    {
    return $this->hasMany(Lot::class);
    }

    public function getCipAttribute()
    {
        return $this->code_cip13;
    }

    public function getEan13Attribute()
    {
        return $this->code_cip13;
    }
}
