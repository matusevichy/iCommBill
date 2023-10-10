<?php

namespace App\Models;

use App\Models\Dictionary\AccrualType;
use App\Models\Dictionary\CounterZoneType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'date_begin',
        'date_end',
        'organization_id',
        'accrualtype_id',
        'counterzonetype_id',
        'by_square'
    ];

    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function accrualtype(){
        return $this->belongsTo(AccrualType::class);
    }

    public function counterzonetype(){
        return $this->belongsTo(CounterZoneType::class);
    }
}
