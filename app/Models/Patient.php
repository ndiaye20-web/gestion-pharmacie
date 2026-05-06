<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'date_naissance',
        'numero_secu',
        'mutuelle',
        'allergies',
        'historique',
        'telephone',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function ordonnances()
    {
        return $this->hasMany(Ordonnance::class);
    }

    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
