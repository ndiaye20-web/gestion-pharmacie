<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordonnance extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'patient_id',
        'medecin',
        'date_prescription',
        'archive_path',
        'renouvellements',
        'statut'
    ];

    protected $casts = [
        'date_prescription' => 'date',
    ];

    public function lignes()
    {
        return $this->hasMany(LigneOrdonnance::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
