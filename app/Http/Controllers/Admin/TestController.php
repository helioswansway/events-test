<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\EventDate;
use App\Models\EventTime;
use App\Models\EventExec;
use App\Models\Dealership;
use App\Exec;

use Image;
use DB;


use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\Carbonite;
use Carbon\CarbonImmutable;
//use App\Http\Controllers\DateTime;

use DateTime;
use DateInterval;

class TestController extends Controller
{
    //
    public function query(){

            $appointment =  DB::table('appointments')
                            ->where('id', 7892)->delete();
            return $appointment;

    }

}
