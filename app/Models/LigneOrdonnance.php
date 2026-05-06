<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneOrdonnance extends Model
{
    protected $fillable = [
        'ordonnance_id',
        'medicament_id',
        'quantite',
        'posologie'
    ];

    public function ordonnance()
{
    return $this->belongsTo(Ordonnance::class);
}

public function medicament()
{
    return $this->belongsTo(Medicament::class);
}
}
