<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Vente extends Model
{
    protected $fillable = [
        'patient_id',
        'pharmacien_id',
        'remboursement',
        'mode_paiement',
        'ticket_numero',
        'date',
        'total',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function ligneVentes()
    {
        return $this->hasMany(LigneVente::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function pharmacien()
    {
        return $this->belongsTo(User::class, 'pharmacien_id');
    }
}
