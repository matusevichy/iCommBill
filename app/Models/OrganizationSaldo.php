<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationSaldo extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'date',
        'organization_id',
    ];

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}
