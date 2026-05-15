<?php

namespace App\Http\Controllers\Exec;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Dealership;
use App\Models\Event;

class EventController extends Controller
{
    //

    public function event(){
        $exec           =   auth('exec')->user();
        $dealership     =   Dealership::where('code' , $exec->dealership_code)->first();
        $event          =   Event::join('dealership_event', 'dealership_event.event_id', 'events.id')
                                    ->select('events.*')
                                    ->where('dealership_event.dealership_id', $dealership->id)
                                    //->where('events.active', 1)
                                    ->first();

        return $event;

    }


}
