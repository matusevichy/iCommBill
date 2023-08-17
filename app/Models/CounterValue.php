<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'date',
        'counter_id'
    ];
    protected $dates = ['date'];

    public function counter(){
        return $this->belongsTo(Counter::class);
    }
}
