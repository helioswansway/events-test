<?php

namespace App\Http\Controllers\Exec;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Exec\EventController;

use App\Models\Dealership;
use App\Models\Appointment;
use App\Models\Event;
use App\Models\Vehicle;
use App\Models\Sale;
use App\Models\EventDate;
use App\Models\EventTime;

use Carbon\Carbon;
use Carbon\CarbonImmutable;

use App\Exec;

class HomeController extends Controller
{

    protected $redirectTo = '/exec/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('exec.auth:exec');
    }

    /**
     * Show the Exec dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $exec = auth('exec')->user();
        $dealership = Dealership::where('code', $exec->dealership_code)->first();

        $event = new EventController;

        if(isset($event->event()->id)){
            $sales = Sale::where('exec_id', $exec->id)
                        ->where('event_id', $event->event()->id)
                        ->get();
        }else{
            $sales = [];
        }
        // $sales              =   Sale::where('exec_id', $exec->id)
        //                             ->where('event_id', $event->event()->id)
        //                             ->get();

        return view('exec.dashboard')
                ->with('dealership', $dealership)
                ->with('sales', $sales);

    }

    //Pulls all the event bookings information for all active days
    public function receptionLog() {



        $exec = auth('exec')->user();
        $dealership = Dealership::where('code' , $exec->dealership_code)->first();

        $event = new EventController;

        if(empty($event->event()->id)){
            return redirect()->route('exec.dashboard')->with('success', ' It seems to be an issue, please contact the person responsible for the Events System!');
        }

        $appointments = Appointment::where('event_id', $event->event()->id)
                                            ->where('dealership_id', $dealership->id)
                                            ->where('exec_id', $exec->id)
                                            ->orderBy('date', 'ASC')
                                            ->orderBy('event_time_id', 'ASC')
                                            ->get();

        $times = EventTime::join('event_dates', 'event_dates.id', 'event_times.event_date_id')
                            ->select('event_times.*')
                            ->where('event_dates.date', $this->todayDate())
                            ->where('event_times.dealership_id', $dealership->id)
                            ->groupBy('event_times.time')
                            ->orderBy('time', 'ASC')
                            ->get();

        $execs =   Exec::where('dealership_code', $exec->dealership_code)->get();
        $vehicles =   Vehicle::with('brand.dealership')->orderBy('order', 'ASC')->get();
        $date =   EventDate::where('date', $this->todayDate())->first();
        $today_date =   $this->todayDate();

        //return $appointments;
        return view('exec.reception-log')
                    ->with('times', $times)
                    ->with('execs', $execs)
                    ->with('vehicles', $vehicles)
                    ->with('event', $event)
                    ->with('date', $date)
                    ->with('today_date', $today_date)
                    ->with('dealership', $dealership)
                    ->with('appointments', $appointments);


    }

    //Updates Notes
        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateNotes(Request $request, $id)
    {
        //

            $appointment            =   Appointment::find($id);
            $appointment->notes      =   $request->input('notes');

            $appointment->save();
            return redirect('/exec/reception-log')->with('success', ' Notes has been updated! ');

    }

    //It will save customer as arrived
    public function receptionLogArrived(Request $request){

        $appointment                    =   Appointment::find($request->appointment_id);

        $appointment->arrived           =   1;
        $appointment->cancelled         =   0;
        $appointment->confirm           =   1;
        $appointment->save();

    }

    //When Customer makes a cancellation
    public function receptionLogCancelled(Request $request){

        $appointment                    =   Appointment::find($request->appointment_id);

        $appointment->cancelled         =   1;
        $appointment->arrived           =   0;
        $appointment->confirm           =   0;

        $appointment->save();


    }


    public function contacts() {
        return view('exec.contacts');
    }

    public function todayDate(){

        $now    = CarbonImmutable::now()->locale('en_UK');

        return  Carbon::parse($now)->format('Y-m-d');
    }


}
