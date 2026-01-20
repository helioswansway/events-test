<?php

namespace App\Http\Controllers\Exec;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Book\HomeController;

use PHPMailer\PHPMailer\PHPMailer;
use Mail;
use App\Helpers\Helper;

use App\Models\Appointment;
use App\Models\Dealership;
use App\Models\Event;
use App\Models\EventDate;
use App\Models\EventTime;
use App\Models\Vehicle;
use App\Book;
use App\Exec;
use DB;

class AppointmentController extends Controller
{
    //

    public function index() {


        $exec = auth('exec')->user();
        $dealership = Dealership::where('code', $exec->dealership_code)->first();


        $dates = Event::join('event_dates', 'event_dates.event_id', '=', 'events.id')
                        ->select('event_dates.*', 'events.name')
                        ->orderBy('event_dates.date', 'ASC')
                        ->where('events.active', 1)
                        ->where('event_dates.dealership_id', $dealership->id)->get();


        $appointments = Appointment::where('exec_id', $exec->id)->get();

        return view('exec.appointments.index')
                    ->with('exec', $exec)
                    ->with('dates', $dates)
                    ->with('dealership', $dealership)
                    ->with('appointments', $appointments);

    }

    //current Event
    public function currentEvent(){
        $exec           =   auth('exec')->user();
        $dealership     =   Dealership::where('code' , $exec->dealership_code)->first();
        $event          =   Event::join('dealership_event', 'dealership_event.event_id', 'events.id')
                                    ->select('events.*')
                                    ->where('dealership_event.dealership_id', $dealership->id)
                                    ->where('events.active', 1)
                                    ->first();

        return $event;

    }

    //gets
    public function event(){
        $exec = auth('exec')->user();

        $dealership = Dealership::where('code', $exec->dealership_code)->first();

        $event = Event::join('dealership_event', 'dealership_event.event_id', '=', 'events.id')
                        ->select('events.*')
                        ->where('events.active', 1)
                        ->where('dealership_event.dealership_id', $dealership->id)->first();

        return view('exec.appointments._event')
                        ->with('event', $event);


    }

    public function dates(Request $request){

        $exec = auth('exec')->user();
        $dealership = Dealership::where('code', $exec->dealership_code)->first();
        $dates = EventDate::where('dealership_id', $dealership->id)
                            ->where('event_id', $request->event_id)
                            ->orderBy('date', 'ASC')
                            ->get();

        return view('exec.appointments._date-results')
                  //  ->with('slots', $slots)
                    ->with('dates', $dates);

    }


    public function slots(Request $request){

        if($request->ajax()){
            $slots = EventTime::where('event_date_id', $request->date_id)->orderBy('time', 'ASC')->get();

            return view('exec.appointments._time-results')
                                    ->with('slots', $slots);
        }

    }

    //Stores appointment
    public function storeAppointment(Request $request){


        $appointment = new Appointment;

        $booked = Appointment::where('book_id', $request->book_id)
                        ->where('event_id', $request->event_id)
                        ->first();
         //return $request->all();
        //Checks if appointment has been made
        //Returns false if exists
        if(isset($booked)){
            return response()->json("Already booked");
        }else{

            $appointment->dealership_id =   $request->dealership_id;
            $appointment->event_id =   $request->event_id;
            $appointment->book_id =   $request->book_id;
            $appointment->date =   $request->date;
            $appointment->event_time_id =   $request->time_id;
            $appointment->exec_id =   auth('exec')->user()->id;
            $appointment->booked_by =   auth('exec')->user()->name;

            $appointment->friend_interest =   $request->friend_interest;
            $appointment->friend_name =   $request->friend_name;
            $appointment->friend_model_interest =   $request->friend_model_interest;

            $appointment->registration =   $request->registration;
            $appointment->make =   $request->make;
            $appointment->colour =   $request->colour;
            $appointment->fuel_type =   $request->fuel_type;
            $appointment->mileage =   $request->mileage;
            $appointment->part_exchange =   $request->part_exchange;
            $appointment->model_interest =   $request->model_interest;
            $appointment->drink =   $request->drink;
            $appointment->preference =   $request->preference;
            $appointment->vehicles =   json_encode($request->vehicles);

            $appointment->confirm =   1;
            $appointment->cancelled =   0;
            $appointment->not_interested =   0;
            $appointment->in_progress =   0;

            $appointment->call_attempts =   $request->call_attempts ;
            $appointment->call_made =   $request->call_made;
            $appointment->call_back =   $request->call_back;
            $appointment->message_left =   $request->message_left;

            $appointment->notes =   $request->notes;

            $appointment->save();

           // return response()->json("Success");
            //Sends email to  Brand manager and admins with notify-booking role
            notifyExecAppointment($appointment->id);

            //Send email notification to customer
            notifyProspect($appointment->id);

        }

    }

    //Stores not Interested
    public function notInterested(Request $request){


        $appointment =   new Appointment;
        $booked =   Appointment::where('book_id', $request->book_id)
                                            ->where('event_id', $request->event_id)
                                            ->first();
        //return $request->all();
        //Checks if appointment has been made
        //Returns false if exists

        if($booked){

            $booked->dealership_id =   $request->dealership_id;
            $booked->event_id =   $request->event_id;
            $booked->book_id =   $request->book_id;
            $booked->exec_id =   auth('exec')->user()->id;
            $booked->booked_by =   auth('exec')->user()->name;

            $booked->confirm =   0;
            $booked->cancelled =   0;
            $booked->not_interested =   1;
            $booked->in_progress =   0;

            $booked->notes =   $request->notes;

            $booked->save();
            return response()->json("Already booked");

        }else{

            $appointment->dealership_id =   $request->dealership_id;
            $appointment->event_id =   $request->event_id;
            $appointment->book_id =   $request->book_id;
            $appointment->exec_id =   auth('exec')->user()->id;
            $appointment->booked_by =   auth('exec')->user()->name;

            $appointment->confirm =   0;
            $appointment->cancelled =   0;
            $appointment->not_interested =   1;
            $appointment->in_progress =   0;

            $appointment->notes =   $request->notes;

            $appointment->save();


        }

    }

    //Stores Cancelled
    public function cancelled(Request $request){

        $appointment =   new Appointment;
        $booked =   Appointment::where('book_id', $request->book_id)
                            ->where('event_id', $request->event_id)
                            ->first();

        //return $request->all();
        //Checks if appointment has been made
        //Returns false if exists

        if($booked){
            $booked->dealership_id =   $request->dealership_id;
            $booked->event_id =   $request->event_id;
            $booked->book_id =   $request->book_id;
            $booked->edited_by =   auth('exec')->user()->name;

            $booked->call_attempts =   $request->call_attempts;
            $booked->call_made =   $request->call_made;
            $booked->call_back =   $request->call_back;
            $booked->message_left =   $request->message_left;

            $booked->confirm =   0;
            $booked->cancelled =   1;
            $booked->not_interested =   0;
            $booked->in_progress =   0;


            $booked->notes                  =   $request->notes;

            $booked->save();

            return response()->json("Success, Updated ");


        }else{

            $appointment->dealership_id =   $request->dealership_id;
            $appointment->event_id =   $request->event_id;
            $appointment->book_id =   $request->book_id;
            $appointment->exec_id =   $request->exec_id;

            $appointment->call_attempts =   $request->call_attempts;
            $appointment->call_made =   $request->call_made;
            $appointment->call_back =   $request->call_back;
            $appointment->message_left =   $request->message_left;

            $appointment->confirm =   0;
            $appointment->cancelled =   1;
            $appointment->not_interested =   0;
            $appointment->in_progress =   0;

            $appointment->notes =   $request->notes;

            $appointment->save();

        }

    }

    //Stores In Progress
    public function inProgress(Request $request){

        $booked_by =   auth('exec')->user()->name;
        $appointment =   new Appointment;

        $booked =   Appointment::where('book_id', $request->book_id)
                                            ->where('event_id', $request->event_id)
                                            ->first();
        //return $request->all();
        //Checks if appointment has been made
        //Returns false if exists


        if($booked){
            $booked->booked_by =   $booked_by;
            $booked->dealership_id =   $request->dealership_id;
            $booked->event_id =   $request->event_id;
            $booked->book_id =   $request->book_id;
            $booked->exec_id =   auth('exec')->user()->id;

            $booked->call_attempts =   $request->call_attempts;
            $booked->call_made =   $request->call_made;
            $booked->call_back =   $request->call_back;
            $booked->message_left =   $request->message_left;

            $booked->confirm =   0;
            $booked->cancelled =   0;
            $booked->not_interested =   0;
            $booked->in_progress =   1;

            $booked->notes =   $request->notes;

            $booked->save();
            return response()->json("Already booked");


        }else{
            $appointment->booked_by =   $booked_by;
            $appointment->dealership_id =   $request->dealership_id;
            $appointment->event_id =   $request->event_id;
            $appointment->book_id =   $request->book_id;
            $appointment->exec_id =   auth('exec')->user()->id;

            $appointment->call_attempts =   $request->call_attempts;
            $appointment->call_made =   $request->call_made;
            $appointment->call_back =   $request->call_back;
            $appointment->message_left =   $request->message_left;

            $appointment->confirm =   0;
            $appointment->cancelled =   0;
            $appointment->not_interested =   0;
            $appointment->in_progress =   1;

            $appointment->notes =   $request->notes;

            $appointment->save();


        }

    }

    //Saves Notes and calls status
    public function saveNotes(Request $request){


        $appointment =   new Appointment;

        $booked =   Appointment::where('book_id', $request->book_id)
                                            ->where('event_id', $request->event_id)
                                            ->first();
        //return $request->all();
        //Checks if appointment has been made
        //Returns false if exists

        if($booked){
            return response()->json("Already booked");
        }else{

            $appointment->dealership_id =   $request->dealership_id;
            $appointment->event_id =   $request->event_id;
            $appointment->book_id =   $request->book_id;
            $appointment->exec_id =   auth('exec')->user()->id;
            $appointment->edited_by =   auth('exec')->user()->name;

            $appointment->confirm =   0;

            $appointment->call_attempts =   $request->call_attempts ;
            $appointment->call_made =   $request->call_made;
            $appointment->call_back =   $request->call_back;
            $appointment->message_left =   $request->message_left;

            $appointment->notes =   $request->notes;

            $appointment->save();


        }

    }

    //Updates appointment
    public function updateAppointment(Request $request){


        $appointment                        =   Appointment::find($request->appointment_id);



        $appointment->dealership_id         =   $request->dealership_id;
        $appointment->event_id              =   $request->event_id;
        $appointment->book_id               =   $request->book_id;
        $appointment->date                  =   $request->date;
        $appointment->event_time_id         =   $request->time_id;
        $appointment->exec_id               =   auth('exec')->user()->id;
        $appointment->edited_by             =   auth('exec')->user()->name;


        $appointment->friend_interest       =   $request->friend_interest;
        $appointment->friend_name           =   $request->friend_name;
        $appointment->friend_model_interest =   $request->friend_model_interest;

        $appointment->registration          =   $request->registration;
        $appointment->make                  =   $request->make;
        $appointment->colour                =   $request->colour;
        $appointment->fuel_type             =   $request->fuel_type;
        $appointment->mileage               =   $request->mileage;
        $appointment->part_exchange         =   $request->part_exchange;
        $appointment->model_interest        =   $request->model_interest;
        $appointment->drink                 =   $request->drink;
        $appointment->preference            =   $request->preference;
        $appointment->vehicles              =   json_encode($request->vehicles);

        $appointment->confirm               =   1;
        $appointment->cancelled             =   0;
        $appointment->not_interested        =   0;
        $appointment->in_progress           =   0;

        $appointment->call_attempts         =   $request->call_attempts ;
        $appointment->call_made             =   $request->call_made;
        $appointment->call_back             =   $request->call_back;
        $appointment->message_left          =   $request->message_left;

        $appointment->notes                 =   $request->notes;

        $appointment->save();

    }

    public function deleteAppointment(Request $request){

        if($request->ajax()){

            $appointment            =   Appointment::find($request->id);

            $appointment->delete();

        }

    }

    public function logAppointment(Request $request){

        //return $request->exec_id . " " . $request->date_id;

        $exec               =   auth('exec')->user();
        $dealership         =   Dealership::where('code', $exec->dealership_code)->first();

        $date               =   EventDate::find($request->date_id);
        $times              =   EventTime::where('event_date_id', $request->date_id)->orderBy('time', 'ASC')->get();

        $appointments       =   Appointment::where('date', $date->date)->where('exec_id',$exec->id)->where('confirm', 1)->get();

        $book               =   new Book;

        //dd($appointments);
        return view('exec.appointments.logs')
                    ->with('appointments', $appointments)
                    ->with('times', $times)
                    ->with('book', $book)
                    ->with('date', $date);
    }

}
