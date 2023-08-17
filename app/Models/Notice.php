<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'date_begin',
        'date_end',
        'organization_id'
    ];

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}
