<?php

namespace App\Models;

use App\Models\Dictionary\BudgetItemType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationExpence extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'date',
        'organization_id',
        'budgetitemtype_id'
    ];

    public function budgetitemtype(){
        return $this->belongsTo(BudgetItemType::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}
