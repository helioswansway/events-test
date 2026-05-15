<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class EventTime extends Model
{
    //

    protected $fillable = [
        'time',
        'dealership_id',
        'event_date_id'
    ];

    public function execs()
    {
        return $this->belongsToMany(Exec::class);
    }

    public function dealership()
    {
        return $this->belongsTo(Dealership::class);
    }

    public function appointment()
    {
        return $this->hasOne("App\Models\Appointment");
    }

    public function event_date()
    {
        return $this->belongsTo("App\Models\EventDate");
    }


    //Returns Event object based on loggged user (Booking Customer)
    public static function slots($date, $dealership)
    {
        $slots = EventTime::join('event_dates', 'event_dates.id', '=', 'event_times.event_date_id')
                            ->select('event_times.id', 'event_times.time', 'event_times.event_date_id', 'event_times.dealership_id')
                            ->where('event_times.dealership_id', $dealership)
                            ->where('event_dates.date', $date)
                            ->orderBy('time', 'ASC')->get();
        return $slots;
    }




}
