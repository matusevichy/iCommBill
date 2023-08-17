<?php

namespace App\Models;

use App\Models\Dictionary\OrganizationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'user_limit',
        'accrual_date',
        'organizationtype_id'
    ];

    public function organizationtype(){
        return $this->belongsTo(OrganizationType::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function abonents(){
        return $this->hasMany(Abonent::class);
    }

    public function notices(){
        return $this->hasMany(Notice::class);
    }

    public function tarifs(){
        return $this->hasMany(Tarif::class);
    }
}
