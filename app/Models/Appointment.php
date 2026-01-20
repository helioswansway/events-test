<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //

    public function eventTime()
    {
        return $this->belongsTo(EventTime::class);
    }

    public function exec()
    {
        return $this->belongsTo("App\Exec");
    }

    public function book()
    {
        return $this->belongsTo("App\Book");
    }

    public function sale()
    {
        return $this->belongsTo("App\Models\Sale");
    }

    public function dealership()
    {
        return $this->belongsTo("App\Models\Dealership");
    }

    protected $casts = [
        'vehicles' => 'array'
    ];
}
