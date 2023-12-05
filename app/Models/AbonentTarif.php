<?php

namespace App\Models;

use App\Models\Dictionary\AccrualType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbonentTarif extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_begin',
        'date_end'
    ];

    public function abonent(){
        return $this->belongsTo(Abonent::class);
    }

    public function tarif(){
        return $this->belongsTo(Tarif::class);
    }

    public function accrualtype(){
        return $this->belongsTo(AccrualType::class);
    }

}
