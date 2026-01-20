<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDate extends Model
{
    //

    public function appointment()
    {
        return $this->belongsTo("App\Models\Appointment");
    }

    protected $fillable = [
        'date',
        'day',
        'month',
        'year',
        'event_id',
        'dealership_id'
    ];
}
