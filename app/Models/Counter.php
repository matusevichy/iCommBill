<?php

namespace App\Models;

use App\Models\Dictionary\AccrualType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'abonent_id',
        'accrualtype_id',
        'date_begin'
    ];

    public function abonent(){
        return $this->belongsTo(Abonent::class);
    }

    public function countervalues(){
        return $this->hasMany(CounterValue::class);
    }

    public function accrualtype(){
        return $this->belongsTo(AccrualType::class);
    }
}
