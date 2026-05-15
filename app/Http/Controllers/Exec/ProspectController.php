<?php

namespace App\Http\Controllers\Exec;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Appointment;
use App\Models\Event;
use App\Models\EventDate;
use App\Models\EventTime;
use App\Models\Dealership;
use App\Models\Vehicle;
use App\Models\Sale;
use App\Book;
use App\Exec;
use DB;

use Illuminate\Support\Facades\Hash;


class ProspectController extends Controller
{
    //

    public function index() {

        // return Hash::check(request('password'), '$2y$10$YCaErJoEkN4K5wcVmy1NE.BFpstXtdlz3CCxFA4wUjiL878wduUZ.');

        //gets the current exec
        $exec = auth('exec')->user();

        //Gets the dealership that the exec belongs to
        $dealership = Dealership::where('code', $exec->dealership_code)->first();

        //Gets all the prospects tha belongs to the exec
        $prospects = Book::select('books.*')
                        ->join('book_exec', 'book_exec.book_id', 'books.id')
                        //->leftJoin('appointments', 'appointments.book_id', 'books.id')
                        ->where('book_exec.exec_id', $exec->id)
                        ->where('books.event_id', $this->event()->id)
                        ->where('books.dealership_code', $exec->dealership_code)
                        //->orderBy('appointments.confirm', 'DESC')
                        ->orderBy('books.name', 'ASC')
                        ->paginate(50);


        //return $prospects;
        //return $this->event()->id;
        return view('exec.prospects.index')
                    ->with('exec', $exec)
                    ->with('event_id', $this->event()->id)
                    ->with('dealership', $dealership)
                    ->with('prospects', $prospects);

    }

    //Fetchs Prospects data of search results
    public function fetchData(Request $request){

            $dealership = Dealership::where('code', request('dealership_code'))->first();
            $terms = explode(' ', request('keyword'));

            $exec = auth('exec')->user();
            $prospects = Book::select('books.*')
                            ->join('book_exec', 'book_exec.book_id', 'books.id')
                            //->leftJoin('appointments', 'appointments.book_id', 'books.id')
                            ->where('book_exec.exec_id', $exec->id)
                            ->where('books.event_id', request('event_id'))
                            ->where('books.dealership_code', request('dealership_code'))
                            ->where(function($query) use ($terms){
                                foreach($terms as $term){
                                    $query->where('books.customer_number', 'LIKE', "%{$term}%")
                                            ->orWhere('books.name', 'LIKE', "%{$term}%")
                                            ->orWhere('books.surname', 'LIKE', "%{$term}%")
                                            ->orWhere('books.vehicle_reg', 'LIKE', "%{$term}%")
                                            ->orWhere('books.email', 'LIKE', "%{$term}%");
                                }
                            })
                            //->orderBy('appointments.confirm', 'DESC')
                            ->orderBy('books.name', 'ASC')
                            ->paginate(50);


            return view('exec.prospects._results')
                            ->with('prospects', $prospects)
                            ->with('dealership', $dealership)
                           // ->with('success', 'We\'re Sorry but no results were found, please try again.')
                            ->render();

    }

    //Fetchs Prospects that are confirmed for appointments
    public function fetchConfirmedData(Request $request){
        $exec = auth('exec')->user();
        $dealership = Dealership::where('code', $exec->dealership_code)->first();

        $prospects = Appointment::select('books.*', 'appointments.call_made', 'appointments.call_back')
                        ->join('books', 'books.id', 'appointments.book_id')
                        ->where('appointments.exec_id', $exec->id)
                        ->where('books.event_id', $this->event()->id)
                        //->where('books.dealership_code', $exec->dealership_code)
                        ->where('appointments.confirm', 1)
                        ->orderBy('books.name', 'ASC')
                        ->paginate(50);


        return view('exec.prospects._results-confirmed')
                        ->with('exec', $exec)
                        ->with('event_id', $this->event()->id)
                        ->with('prospects', $prospects)
                        ->with('dealership', $dealership)
                       // ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }

    //Fetchs Prospects that have completed appointments
    public function fetchCompletedData(Request $request){
        $exec = auth('exec')->user();
        $dealership = Dealership::where('code', $exec->dealership_code)->first();


        $prospects = Appointment::select('books.*', 'appointments.call_made', 'appointments.call_back')
                        ->join('books', 'books.id', 'appointments.book_id')
                        ->where('appointments.exec_id', $exec->id)
                        ->where('books.event_id', $this->event()->id)
                        //->where('books.dealership_code', $exec->dealership_code)
                        ->where('appointments.completed', 1)
                        ->orderBy('books.name', 'ASC')
                        ->paginate(50);


        return view('exec.prospects._results-completed')
                        ->with('exec', $exec)
                        ->with('event_id', $this->event()->id)
                        ->with('prospects', $prospects)
                        ->with('dealership', $dealership)
                        // ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }

    //Fetchs Prospects that are confirmed for appointments
    public function fetchHotProspectdData(Request $request){
        $exec = auth('exec')->user();
        $dealership = Dealership::where('code', $exec->dealership_code)->first();

        //return $exec->id ." - ". $this->event()->id;

        $prospects = Appointment::select('books.*', 'appointments.call_made', 'appointments.confirm', 'appointments.booked_by', 'appointments.call_back')
                        ->join('books', 'books.id', 'appointments.book_id')
                        ->join('book_exec', 'book_exec.book_id', 'books.id')
                        //->leftJoin('appointments', 'appointments.book_id', 'books.id')
                        ->where('book_exec.exec_id', $exec->id)
                        //->where('appointments.exec_id', $exec->id)
                        ->where('books.event_id', $this->event()->id)
                        ->where('appointments.confirm', 0)
                        ->where('appointments.completed', 0)
                        ->where('appointments.not_interested', 0)
                        ->where('appointments.cancelled', 0)
                        ->whereNull('appointments.booked_by')
                        ->where('appointments.dealership_id', $dealership->id)
                        ->orderBy('books.name', 'ASC')
                        ->get();

        //return $prospects;
        return view('exec.prospects._results-hot-leads')
                        ->with('exec', $exec)
                        ->with('event_id', $this->event()->id)
                        ->with('prospects', $prospects)
                        ->with('dealership', $dealership)
                       // ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }

    //Fetchs Prospects that are confirmed for appointments
    public function fetchInProgressData(){

        $exec = auth('exec')->user();

        $dealership = Dealership::where('code', $exec->dealership_code)->first();


        $prospects = Appointment::select('books.*', 'appointments.call_made', 'appointments.confirm', 'appointments.call_back')
                        ->join('books', 'books.id', 'appointments.book_id')
                        ->where('books.event_id', $this->event()->id)
                        ->where('appointments.dealership_id', $dealership->id)
                        ->where('appointments.in_progress', 1)
                        ->orderBy('books.name', 'ASC')
                        ->paginate(1000);


        return view('exec.prospects._results-in-progress')
                        ->with('exec', $exec)
                        ->with('event_id', $this->event()->id)
                        ->with('prospects', $prospects)
                        ->with('dealership', $dealership)
                        // ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }


    //Creates appointment
    public function createAppointment($event_id, $dealership_id, $prospect_id){

        $prospect = Book::find($prospect_id);
        $dealership = Dealership::find($dealership_id);
        $vehicles = Vehicle::with('brand.dealership')->orderBy('order', 'ASC')->get();

        $dates = EventDate::where('dealership_id', $dealership->id)
                    ->where('event_id', $event_id)
                    ->orderBy('date', 'ASC')
                    ->get();

        return view('exec.prospects.create-appointment')
                    ->with('dealership_id', $dealership_id)
                    ->with('dealership', $dealership)
                    ->with('event_id', $event_id)
                    ->with('vehicles', $vehicles)
                    ->with('dates', $dates)
                    ->with('prospect', $prospect);

    }

    //Shows edit form for appointment
    public function editAppointment($event_id, $dealership_id, $prospect_id){
        $appointment = Appointment::where('book_id', $prospect_id)->first();
        $prospect = Book::find($prospect_id);
        $dealership = Dealership::find($dealership_id);
        $vehicles = Vehicle::with('brand.dealership')->orderBy('order', 'ASC')->get();

        $dates = EventDate::where('dealership_id', $dealership->id)
                    ->where('event_id', $event_id)
                    ->orderBy('date', 'ASC')
                    ->get();

        $slots = new EventTime;

        $execs = Exec::where('dealership_code', $dealership->code)->orderBy('name', 'ASC')->get();

        return view('exec.prospects.edit-appointment')
                    ->with('appointment', $appointment)
                    ->with('dealership_id', $dealership_id)
                    ->with('dealership', $dealership)
                    ->with('event_id', $event_id)
                    ->with('vehicles', $vehicles)
                    ->with('dates', $dates)
                    ->with('slots', $slots)
                    ->with('execs', $execs)
                    ->with('prospect', $prospect);
    }

    //Displays form to register prospect
    public function prospectsRegister($event_id, $dealership_id){

        $dealership = Dealership::find($dealership_id);
        $vehicles = Vehicle::with('brand.dealership')->orderBy('order', 'ASC')->get();

        $dates = EventDate::where('dealership_id', $dealership->id)
                    ->where('event_id', $event_id)
                    ->orderBy('date', 'ASC')
                    ->get();

        return view('exec.prospects.register-prospect')
                    ->with('dealership_id', $dealership_id)
                    ->with('dealership', $dealership)
                    ->with('event_id', $event_id)
                    ->with('vehicles', $vehicles)
                    ->with('dates', $dates);
    }


    //Stores prospect registration
    public function store(Request $request){

        $exists = Book::where('email', $request->email)->where('event_id', $request->event_id)->first();

        if($exists){
            return response()->json("exists");
        }else{

            $prospect = new Book;
            $appointment = new Appointment;
            $dealership = Dealership::find($request->dealership_id);

            //Prospect Details
            $code = rand( 10000, 99999 );
            $prospect->customer_number = $code ."_ECUST";
            $prospect->dealership_code = $dealership->code;
            $prospect->event_id = $request->event_id;
            $prospect->title = $request->title;
            $prospect->name = $request->name;
            $prospect->surname = $request->surname;
            $prospect->address_1 = $request->address_1;
            $prospect->address_2 = $request->address_2;
            $prospect->address_3 = $request->address_3;
            $prospect->address_4 = $request->address_4;
            $prospect->address_5 = $request->address_5;
            $prospect->post_code = $request->post_code;
            $prospect->home_phone = str_replace(' ', '', $request->home_phone);
            $prospect->mobile = str_replace(' ', '', $request->mobile);
            $prospect->email = $request->email;
            $prospect->password = Hash::make('Rreenn84?he');

            $prospect->save();


            $booked = Appointment::where('book_id', $prospect->id )
                            ->where('event_id', $prospect->event_id )
                            ->first();


            //Checks if appointment has been made
            //Returns false if exists
            if($booked){
                return response()->json("Already booked");
            }else{

                //Appointments Details
                //
                $appointment->dealership_id = $request->dealership_id;
                $appointment->event_id = $request->event_id;
                $appointment->book_id = $prospect->id;
                $appointment->date = $request->date;
                $appointment->event_time_id = $request->time_id;
                $appointment->exec_id = auth('exec')->user()->id;

                $appointment->friend_interest = $request->friend_interest;
                $appointment->friend_name = $request->friend_name;
                $appointment->friend_model_interest = $request->friend_model_interest;

                $appointment->registration = $request->registration;
                $appointment->make = $request->make;
                $appointment->colour = $request->colour;
                $appointment->fuel_type = $request->fuel_type;
                $appointment->mileage = $request->mileage;
                $appointment->part_exchange = $request->part_exchange;
                $appointment->model_interest = $request->model_interest;
                $appointment->drink = $request->drink;
                $appointment->preference = $request->preference;
                $appointment->vehicles = json_encode($request->vehicles);
                $appointment->notes = $request->notes;
                $appointment->confirm = 1;

                $appointment->save();

                DB::table('book_exec')->insert([
                    'book_id' => $prospect->id,
                    'exec_id' => $appointment->exec_id,
                ]);

                //Sends email to  Brand manager and admins with notify-booking role
                notifyExecAppointment($appointment->id);

                //Send email notification to customer
                notifyProspect($appointment->id);

            }
        }

    }

    //gets Time Slots based on date selected
    public function getTimes(Request $request){

        $event_id = $request->event_id;
        $date_id = $request->date_id;
        $dealership_id = $request->dealership_id;

        $slots = EventTime::where('event_date_id', $date_id)->orderBy('time', 'ASC')->get();

        return view('exec.prospects._time-results')
                ->with('dealership_id', $dealership_id)
                ->with('event_id', $event_id)
                ->with('date_id', $date_id)
                ->with('slots', $slots);

    }

    //gets Execs based on Time selected
    public function getExecs(Request $request){

        $event_id = $request->event_id;
        $date_id = $request->date_id;
        $dealership_id = $request->dealership_id;
        $time_id = $request->time_id;

        $dealership = Dealership::find($dealership_id);
        $execs = Exec::where('dealership_code', $dealership->code)->orderBy('name', 'ASC')->get();

        //return $execs;
        return view('exec.prospects._exec-results')
                ->with('dealership', $dealership)
                ->with('event_id', $event_id)
                ->with('date_id', $date_id)
                ->with('time_id', $time_id)
                ->with('execs', $execs);

    }


    public function show($id) {
        $appointment = Appointment::where('book_id', $id)->first();

        if(!$appointment){
            return redirect()->route('exec.prospect.index')->with('success', 'Appointment Doesn\'t seem to exist!');
        }

        $prospect = Book::find($id);
        $vehicles = Vehicle::with('brand.dealership')->orderBy('order', 'ASC')->get();
        $dealership = Dealership::where('code', $prospect->dealership_code)->first();
        $exec = auth('exec')->user();
        $sale = Sale::where('appointment_id', $appointment->id)->first();

        return view('exec.prospects.show')
                    ->with('appointment', $appointment)
                    ->with('dealership', $dealership)
                    ->with('vehicles', $vehicles)
                    ->with('exec', $exec)
                    ->with('sale', $sale)
                    ->with('prospect', $prospect);
    }

    public function event(){
        $exec = auth('exec')->user();
        $dealership = Dealership::where('code' , $exec->dealership_code)->first();
        $event = Event::join('dealership_event', 'dealership_event.event_id', 'events.id')
                ->select('events.*')
                ->where('dealership_event.dealership_id', $dealership->id)
                //->where('events.active', 1)
                ->first();

        return $event;

    }


    public function createSale(Request $request){

        if($request->ajax()){

            $exec_id = $request->exec_id;
            $book_id = $request->book_id;
            $dealership_id = $request->dealership_id;
            $appointment_id = $request->appointment_id;

            $prospect = Book::find($book_id);
            $exec = Exec::find($exec_id);
            $dealership = Dealership::find($dealership_id);
            $appointment = Appointment::find($appointment_id);

            return view('exec.prospects._create-sale')
                        ->with('exec', $exec)
                        ->with('dealership', $dealership)
                        ->with('appointment', $appointment)
                        ->with('event_id', $this->event()->id)
                        ->with('prospect', $prospect);

        }

    }


    public function showSale(Request $request){

        if($request->ajax()){

            $sale = Sale::find($request->sale_id);
            $dealership = Dealership::find($sale->dealership_id);
            $prospect = Book::find($sale->book_id);
            $exec = Exec::find($sale->exec_id);

            return view('exec.prospects._show-sale')
                        ->with('dealership', $dealership)
                        ->with('exec', $exec)
                        ->with('prospect', $prospect)
                        ->with('sale', $sale);

        }

    }

    public function showDateTime(Request $request){

        if($request->ajax()){

            $appointment = Appointment::find($request->appointment_id);
            $dates = EventDate::all();
            $slots = EventTime::all();

            return view('exec.prospects._show-date-time')
                        ->with('appointment', $appointment)
                        ->with('slots', $slots)
                        ->with('dates', $dates);

        }

    }

    public function updateDateTime(Request $request){


        $appointment = Appointment::find($request->appointment_id);


        $appointment->date = $request->date;
        $appointment->event_time_id = $request->time_id;

        $appointment->save();

    }


    //Show call log
    public function log($id) {

        $exec = auth('exec')->user();
        $prospect = Book::find($id);
        $dealership = Dealership::where('code', $prospect->dealership_code)->first();

        //Registers appointment
        $appointment = new Appointment;
        $appointment->event_id = $prospect->event_id;
        $appointment->dealership_id = $dealership->id;
        $appointment->book_id = $prospect->id;
        $appointment->exec_id = $exec->id;
        $appointment->save();


        $prospect = Book::find($id);
        $vehicles = Vehicle::with('brand.dealership')->orderBy('order', 'ASC')->get();
        $dealership = Dealership::find($dealership->id);
        $sale =   Sale::where('appointment_id', $appointment->id)->first();

        return view('exec.prospects.create-log')
                    ->with('appointment', $appointment)
                    ->with('dealership', $dealership)
                    ->with('vehicles', $vehicles)
                    ->with('exec', $exec)
                    ->with('sale', $sale)
                    ->with('prospect', $prospect);
    }


        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateLog(Request $request, $id)
    {
        //
       // return $request->all();

        $prospect = Book::find($id);
        $appointment = Appointment::where('book_id',$id)->first();


        $appointment->call_attempts = $request->input('call_attempts');
        $appointment->call_made = $request->input('call_made');
        $appointment->call_back = $request->input('call_back');
        $appointment->message_left = $request->input('message_left');
        $appointment->notes = $request->input('notes');

        $appointment->save();

        return redirect()->route('exec.prospect.index')->with('success', '['.$prospect->name.' '.$prospect->surname.'] has been logged! ');

    }


}
