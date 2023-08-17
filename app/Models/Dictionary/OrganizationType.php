<?php

namespace App\Models\Dictionary;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function organizations(){
        return $this->hasMany(Organization::class);
    }
}
