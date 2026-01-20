<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//use App\Helpers\Notification;

use App\Models\SiteConfiguration;
use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Support\Facades\Auth;

use App\Models\Vehicle;
use App\Models\Event;
use App\Models\EventTime;
use App\Models\EventDate;
use App\Models\Dealership;
use App\Models\Appointment;

use App\Book;
use App\Exec;
use App\Mail\ProspectAppointmentConfirmation;
use DB;


use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\Carbonite;
use Carbon\CarbonImmutable;
//use App\Http\Controllers\DateTime;

use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

    protected $redirectTo = '/book/login';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('book.auth:book');

    }

    /**
     * Show the Book dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        //redirects to confirmation page if already booked
        /*
        if($this->getAppointment() && $this->getAppointment()->confirm == 1){
           return redirect()->route('book.confirmation');
        }
        */

        // if($this->event()->inc_exec == 0){

        //     return redirect()->route('book.appointment');
        // }else{}
            // /dd($this->event()->id);
            if(!isset($this->event()->id)){
                return "Event has finished";
            }


            $book_id = $this->customer()->id;
            $dealership_id = $this->dealership()->id;
            $event_id = $this->event()->id;

            $appointment = Appointment::where('event_id', $event_id)->where('book_id', $book_id)->first();

            if(!$appointment){
                $appointment = new Appointment;
                $appointment->event_id = $event_id;
                $appointment->dealership_id = $dealership_id;
                $appointment->book_id = $book_id ;
                $appointment->save();
            }

            $vehicles = Vehicle::with('brand.dealership')->orderBy('order', 'ASC')->get();

            return view('book.index')
                    ->with('vehicles', $vehicles)
                    ->with('dealership', $this->dealerships())
                    ->with('appointment', $appointment)
                    ->with('book_id', $book_id)
                    ->with('event', $this->event());

    }

    public function appointment(){
        //redirects to confirmation page if already booked
        /*
        if($this->getAppointment() && $this->getAppointment()->confirm == 1){
           return redirect()->route('book.confirmation');
        }
        */
        //$appointment_slot   = new EventTime;
        $slots = new EventTime;

        if($this->event()->inc_exec == 1){
            //Goes to dashboard if is empty
            if(empty($this->getAppointment())){
                return redirect()->route('book.dashboard');
            }
        }else{

            $book_id                            =   $this->customer()->id;
            $dealership_id                      =   $this->dealership()->id;
            $event_id                           =   $this->event()->id;

            $appointment                        =   Appointment::where('event_id', $event_id)->where('book_id', $book_id)->first();

            if(!$appointment){
                $appointment                    =   new Appointment;
                $appointment->event_id          =   $event_id;
                $appointment->dealership_id     =   $dealership_id;
                $appointment->book_id           =   $book_id ;
                $appointment->save();
            }

        }


        $execs              =   Exec::select('execs.*')
                                    ->join('event_time_exec', 'event_time_exec.exec_id', 'execs.id')
                                    ->where('dealership_code', $this->dealership()->code)
                                    ->groupBy('execs.name')
                                    ->orderBy('name', 'ASC')->get();

        return view('book.appointment')
                ->with('appointment', $this->getAppointment())
                ->with('dealership', $this->dealership())
                ->with('event', $this->event())
                ->with('execs', $execs)
                ->with('dates', $this->dates())
                ->with('start_date', $this->startDate())
                ->with('end_date', $this->endDate())
                ->with('slots', $slots);

    }


    public function savePartExchange(Request $request){
        //redirects to confirmation page if already booked
        /*
        if($this->getAppointment() && $this->getAppointment()->confirm == 1){
           return redirect()->route('book.confirmation');
        }
        */


        $appointment = Appointment::find($request->appointment_id);
        if($request->friend_interest == 1) {
            $appointment->friend_name = $request->friend_name;
            $appointment->friend_model_interest = $request->friend_model_interest;
        }else{
            $appointment->friend_name = "";
            $appointment->friend_model_interest = "";
        }

        $appointment->friend_interest = $request->friend_interest;

        $appointment->save();

        return redirect()->route('book.part.exchange');
    }

    public function partExchange(){
        //redirects to confirmation page if already booked
        /*
        if($this->getAppointment() && $this->getAppointment()->confirm == 1){
           return redirect()->route('book.confirmation');
        }
        */

        // if($this->event()->inc_exec == 0){
        //     return redirect()->route('book.confirm-details');

        // }else{ }

            if($this->event()->show_part_exchange == 0) {
                // return $this->event()->show_part_exchange;
                return redirect()->route('book.confirmation');
            }

            if(empty($this->getAppointment())){
                return redirect()->route('book.dashboard');
            }

            return view('book.part-exchange')
                    ->with('customer', $this->customer())
                    ->with('appointment', $this->getAppointment());




    }

    // public function confirmDetails(){
    //     //redirects to confirmation page if already booked
    //     /*
    //     if($this->getAppointment() && $this->getAppointment()->confirm == 1){
    //        return redirect()->route('book.confirmation');
    //     }
    //     */

    //     if(empty($this->getAppointment())){
    //         return redirect()->route('book.dashboard');
    //     }

    //     $customer = $this->customer();
    //     return view('book.confirm-details')
    //         ->with('customer', $customer);
    // }



    public function bookingConfirmation(){

        //It redirects to the dashboard if no appointment under the user exists
        if(empty($this->getAppointment())){
            return redirect()->route('book.dashboard');
        }

        //Checks if the event doesn apply Execs
        if($this->event()->inc_exec == 0){
            //Redirects to the Book an Appointment page if Event Time is empty
            if(empty($this->getAppointment()->event_time_id)){
                return redirect()->route('book.appointment')->with('success', 'Date, Time  needs to be selected');
            }

        }else{
            //A date, time-slot and an exec need to be selected to be allowed to this page
            if(empty($this->getAppointment()->date) || empty($this->getAppointment()->event_time_id) || empty($this->getAppointment()->exec_id)){
                return redirect()->route('book.appointment')->with('success', 'Date, Time and Exec needs to be selected');
            }
        }


        if($this->getAppointment()->friend_interest == 1 && empty($this->getAppointment()->friend_name)){
            return redirect()->route('book.appointment')->with('success', 'You need to add your Friends name if you selectd yes.');
        }

        $vehicles       =   Vehicle::with('brand.dealership')->orderBy('order', 'ASC')->get();
         return view('book.booking-confirmation')
                    ->with('event', $this->event())
                    ->with('inc_exec', $this->event()->inc_exec)
                    ->with('vehicles', $vehicles)
                    ->with('dealership', $this->dealerships())
                    ->with('appointment', $this->getAppointment());
    }

    //confirm customer booking
    public function submitBooking(Request $request){


        $appointment = Appointment::find($request->appointment_id);
        $appointment->confirm =   1;
        $appointment->cancelled =   0;
        $appointment->not_interested =   0;

        $appointment->save();

        $dealership = Dealership::where('id', $appointment->dealership_id)->first();

        if($this->event()->inc_exec == 0){

            emailAdmins($appointment->id);

        }else{
            //Notifies booking to Exec
            emailExecAppointment($appointment->id);
        }

        //Notifies booking to Prospect
        emailProspect($appointment->id);



        session()->flash('success', 'An email confirmation with booking details have been sent to you.');
        //Send emails to the exec and the marketing team
        return redirect()->route('book.confirmation');

    }

    //Resends an email with booking details
    public function resendEmail(Request $request){

        $appointment = Appointment::find($request->appointment_id);

        // $dealership = Dealership::where('id', $appointment->dealership_id)->first();

        //Notifies booking to Exec
        emailProspect($appointment->id);

        session()->flash('success', 'An email with your booking details have been sent to your email.');
        //Send emails to the exec and the marketing team
        return redirect()->route('book.confirmation');

    }

    public function booked(){
        $vehicles = Vehicle::with('brand.dealership')->orderBy('order', 'ASC')->get();
        return view('book.booked')
                ->with('vehicles', $vehicles)
                ->with('dealership', $this->dealerships())
                ->with('appointment', $this->getAppointment());
    }

    //Returns Config
    public function config(){
        return  SiteConfiguration::from_cache();
    }

    //Return Used Event ID
    public function getAppointment(){
        return Appointment::where('book_id', auth('book')->user()->id)->where('event_id', auth('book')->user()->event_id)->first();
    }

    //Return logged customer
    public function customer(){
        $id = Auth::guard('book')->user()->id;
        return Book::find($id);
    }

    //Return Used Event ID
    public function event(){
       return Event::find(auth('book')->user()->event_id);
    }

    //Return all dealerships based on book/customer event_id
    public function dealerships(){
        foreach($this->event()->dealerships as $dealership){
            return  $dealership;
        }
    }

    //Returns the dealership customer as been invited by
    public function dealership(){
        return Dealership::where('code', $this->customer()->dealership_code)->first();
    }

    /**/
    //Return all dealerships based on book/customer event_id
    public function execs(){
        $execs = Exec::where('dealership_code', $this->customer()->dealership_code)->orderBy('name', 'ASC')->get();
        return $execs;
    }

    //Return Time Slots
    public function timeSlots(){


        $slots = EventTime::where('dealership_id', $this->dealership()->id)
                            ->where('event_date_id', $this->date()->id)
                            ->orderBy('time', 'ASC')->get();
        return $slots;
    }

    //Return date the first date
    public function date(){
        $date = EventDate::where('event_id', $this->event()->id)
                        ->where('dealership_id', $this->dealership()->id)
                        ->orderBy('date', 'ASC')->first();

        // /$date_time =  new DateTime;
        return  $date;
    }

    //Returns the first complete date to use on the Full Callendar
    public function startDate(){
        $date = EventDate::where('event_id', $this->event()->id)
                        ->where('dealership_id', $this->dealership()->id)
                        ->orderBy('date', 'ASC')->first();

        // /$date_time =  new DateTime;
        return  $date->date;
    }

    //Returns the last complete date to use on the Full Callendar
    public function endDate(){
        $date = EventDate::where('event_id', $this->event()->id)
                        ->where('dealership_id', $this->dealership()->id)
                        ->orderBy('date', 'DESC')->first();

        // /$date_time =  new DateTime;
        return Carbon::createFromFormat('Y-m-d', $date->date)->addDay()->format('Y-m-d');

    }


    //Return event and dealership dates associated with customer that login
    public function dates(){
        $dates = EventDate::where('event_id', $this->event()->id)
                        ->where('dealership_id', $this->dealership()->id)
                        ->orderBy('date', 'ASC')->get();
        return $dates;
    }

    public function isBooked(){
        //redirects to confirmation page if already booked
        if($this->getAppointment() && $this->getAppointment()->confirm == 1){
            return redirect()->route('book.confirmation');
        }
    }


    ########################################
    // Email Notification
    ########################################
    public function emailProspect($appointment_id) {

        $appointment = Appointment::find($appointment_id);
        $customer = Book::find($appointment->book_id);

        $dealership = Dealership::where('id', $appointment->dealership_id)->first();

        //Email Subject
        $subject =  'Your Booking Confirmation ';

        $appointment = Appointment::find($appointment_id);
        $event = Event::find($appointment->event_id);
        $book = Book::find($appointment->book_id);
        $exec = Exec::find($appointment->exec_id);
        $time = EventTime::find($appointment->event_time_id);
        $dealership = Dealership::find($appointment->dealership_id);
        $config = SiteConfiguration::from_cache();

        Mail::to($customer->email, $customer->name . " ". $customer->surname)
                ->queue(new ProspectAppointmentConfirmation(
                    $subject,
                    $appointment,
                    $event,
                    $book,
                    $exec,
                    $time,
                    $dealership,
                    $config
                ));



    }

}
