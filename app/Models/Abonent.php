<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonent extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_number',
        'location_number',
        'square',
        'cadastral_number',
        'user_id',
        'organization_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function accruals(){
        return $this->hasMany(Accrual::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function saldos(){
        return $this->hasMany(Saldo::class);
    }

    public function abonenttarifs(){
        return $this->hasMany(AbonentTarif::class);
    }
}
