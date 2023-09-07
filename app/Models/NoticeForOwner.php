<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeForOwner extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'date',
    ];

    public function abonent(){
        return $this->belongsTo(Abonent::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }

}
