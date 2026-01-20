<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Appointment;
use App\Models\EventTime;
use App\Models\Event;
use App\Models\Dealership;
use App\Exec;
use App\Book;
use DB;

class AppointmentController extends Controller
{
    //

    //Saves/Updates the Vehicle Model Selected by the Customer
    public function saveModel(Request $request){
        $dealership_id                  = $request->dealership_id;
        $appointment                    = Appointment::where('event_id', $request->event_id)->where('book_id', auth('book')->user()->id)->first();

        $appointment->model_interest    =   $request->interest;
        $appointment->vehicles          =   json_encode($request->vehicles);
        $appointment->save();

    }

    //Saves/Updates the Date available
    public function store(Request $request){

        // Get Execs that belongs to the Event dealership
        // Execs are saved with a dealership_code
        //$execs = "Exec Saved";

        $date               = $request->date;
        $time_id            = $request->time_id;
        $exec_id            = $request->exec_id;
        $appointment_id     = $request->appointment_id;

        $appointment    = Appointment::find($appointment_id);

        $appointment->date              =   $date;
        $appointment->event_time_id     =   $time_id;
        $appointment->exec_id           =   $exec_id;

        $appointment->save();

    }

    //Saves/Updates the Date available
    public function storeNoExec(Request $request){

        // Get Execs that belongs to the Event dealership
        // Execs are saved with a dealership_code
        //$execs = "Exec Saved";

        $date               = $request->date;
        $time_id            = $request->time_id;
        $appointment_id     = $request->appointment_id;

        $appointment    = Appointment::find($appointment_id);

        $appointment->date              =   $date;
        $appointment->event_time_id     =   $time_id;

        $appointment->save();


    }


    public function getTimes(Request $request){

        $event_id           =  $request->event_id;
        $date_id            =  $request->date_id;
        $dealership_id      =  $request->dealership_id;

        $event              =   Event::find($event_id);
        $slots              =   EventTime::where('event_date_id', $date_id)->orderBy('time', 'ASC')->get();

        return view('book._time-results')
                                ->with('dealership_id', $dealership_id)
                                ->with('event_id', $event_id)
                                ->with('date_id', $date_id)
                                ->with('event', $event)
                                ->with('slots', $slots);

    }

    //gets Execs based on Time selected
    public function getExecs(Request $request){

        $event = Event::find($request->event_id);
        $event_id =  $request->event_id;
        $date_id =  $request->date_id;
        $dealership_id  =  $request->dealership_id;
        $time_id =  $request->time_id;

        $dealership =   Dealership::find($dealership_id);
        //$execs              =   Exec::where('dealership_code', $dealership->code)->orderBy('name', 'ASC')->get();

        $execs =   Exec::select('execs.*')
                        ->join('event_time_exec', 'event_time_exec.exec_id', 'execs.id')
                        ->where('dealership_code', $dealership->code)
                        ->where('event_time_exec.event_time_id', $time_id)
                        ->groupBy('execs.name')
                        ->orderBy('name', 'ASC')->get();



        return view('book._exec-results')
                    ->with('dealership', $dealership)
                    ->with('event', $event)
                    ->with('event_id', $event_id)
                    ->with('date_id', $date_id)
                    ->with('time_id', $time_id)
                    ->with('execs', $execs);

    }


    //#################################
    //Customer Part Exchange
    //#################################

    //Saves Customer Part Exchange details
    function partExchangeDetails(Request $request){


        $appointment                =   Appointment::find($request->appointment_id);


        $appointment->registration      =   $request->registration_number;
        $appointment->make              =   $request->make;
        $appointment->colour            =   $request->colour;
        $appointment->fuel_type         =   $request->fuel_type;
        $appointment->mileage           =   $request->mileage;
        $appointment->part_exchange     =   1;
        $appointment->save();


        return response()->json("Success, Updated Part Exchange");

    }

    //Saves if theres no part exchange
    function noPartExchangeDetails(Request $request){

        $appointment                    =   Appointment::find($request->appointment_id);
        $appointment->registration      =   "";
        $appointment->make              =   "";
        $appointment->colour            =   "";
        $appointment->fuel_type         =   "";
        $appointment->mileage           =   "";
        $appointment->part_exchange     =   0;
        $appointment->save();

        return response()->json("Success, Updated No Part exchange");
    }

    //#################################
    //Customer personal Details
    //#################################

    //Saves Customer Personal Details
    public function savePersonalDetails(Request $request){

        $customer =  Book::find($request->id);
        $customer->name     =  $request->name;
        $customer->surname     =  $request->surname;
        $customer->email     =  $request->email;
        $customer->home_phone     =  $request->home_phone;
        $customer->mobile     =  $request->mobile;

        $customer->save();

        //Notifies CRM team that prospect has been updated
        notifyCRM($customer->id);

        //************** */
        //TODO DO
        //Send Email to CRM Team to notifying that Customer updated thier details
        //************** */

        return response()->json("<div class='text-success py-3'>Personal details have been saved</div>");

    }

    //Saves Customer Address Details
    public function saveAddressDetails(Request $request){

        $customer =  Book::find($request->id);
        $customer->address_1        =  $request->address_1;
        $customer->address_2        =  $request->address_2;
        $customer->address_3        =  $request->address_3;
        $customer->address_4        =  $request->address_4;
        $customer->address_5        =  $request->address_5;
        $customer->post_code        =  $request->post_code;

        $customer->save();

        //Notifies booking to Exec
        notifyCRM($customer->id);

        //************** */
        //TODO DO
        //Send Email to CRM Team to notifying that Customer updated thier details
        //************** */



        return response()->json("<div class='text-success py-3'>Address details have been saved</div>");
    }



}
