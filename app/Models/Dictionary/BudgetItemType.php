<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItemType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
}
