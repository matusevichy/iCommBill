<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccrualType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
}
