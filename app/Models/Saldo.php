<?php

namespace App\Models;

use App\Models\Dictionary\AccrualType;
use App\Models\Dictionary\OrganizationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'date',
        'abonent_id',
        'accrualtype_id'
    ];

    public function accrualtype(){
        return $this->belongsTo(AccrualType::class);
    }

    public function abonent(){
        return $this->belongsTo(Abonent::class);
    }
}
