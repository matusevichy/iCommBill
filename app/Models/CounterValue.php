<?php

namespace App\Models;

use App\Models\Dictionary\CounterZoneType;
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

    public function counterzonetype(){
        return $this->belongsTo(CounterZoneType::class);
    }
}
