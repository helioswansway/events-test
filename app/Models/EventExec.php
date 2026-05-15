<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventExec extends Model
{
    //

    protected $fillable = [
        'dealership_id',
        'event_time_id',
        'exec_id',
    ];

    public function exec()
    {
        return $this->belongsTo('App\Models\Exec');
    }


}
