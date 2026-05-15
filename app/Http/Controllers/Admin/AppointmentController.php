<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Exec\EventController;

use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Dealership;
use App\Models\Vehicle;
use App\Models\Event;
use App\Models\Sale;
use App\Models\EventDate;
use App\Models\EventTime;
use App\Book;
use App\Exec;


use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use Carbon\CarbonImmutable;

use PHPMailer\PHPMailer\PHPMailer;

use DB;


class AppointmentController extends Controller
{
    //
    //Display all the events and dealerships admin has access toget-execs
    public function index() {

        $adminRole = new Admin; //Creates an Admin Method
        $dealerships = new Event; //Creates an Event Method
        $admin = auth('admin')->user(); //Grabs the current user that's logged in
        $exec = Exec::where('email', $admin->email)->first(); //Checks if Admin is an exec
        $role = $adminRole->adminRole($admin->id); //Checks logged in admin role

        if($role->name == 'super' || $role->name == 'super-admin'){
            //It display all events if admin has roles super and super admin
            $events = Event::select('events.*', 'dealerships.name as dealership_name', 'brands.filename')
                        ->join('dealership_event', 'dealership_event.event_id', 'events.id')
                        ->join('dealerships', 'dealerships.id', 'dealership_event.dealership_id')
                        ->join('brands', 'brands.id', 'dealerships.brand_id')
                        ->groupBy('events.name')
                        ->orderBy('events.active', 'DESC')
                        ->orderBy('events.created_at', 'DESC')
                        ->get();

        }else{

            $events = Event::select('events.*', 'dealerships.name as dealership_name', 'brands.filename')
                        ->join('dealership_event', 'dealership_event.event_id', 'events.id')
                        ->join('dealerships', 'dealerships.id', 'dealership_event.dealership_id')
                        ->join('admin_dealership', 'admin_dealership.dealership_id', '=', 'dealerships.id')
                        ->join('brands', 'brands.id', 'dealerships.brand_id')
                        ->where('admin_dealership.admin_id', auth('admin')->user()->id)
                        ->groupBy('events.name')
                        ->orderBy('events.active', 'DESC')
                        ->get();

        }

        return view('admin.appointments.index')
                    ->with('dealerships', $dealerships)
                    ->with('exec', $exec)
                    ->with('events', $events);

    }

    //Shows appointments where dealership_id = $id
    public function show($id) {

        $admin = auth('admin')->user();

        $dealership = Dealership::find($id);

        $dates = Event::join('event_dates', 'event_dates.event_id', '=', 'events.id')
                        ->select('event_dates.*', 'events.name')
                        ->orderBy('event_dates.date', 'ASC')
                        //->where('events.active', 1)
                        ->where('event_dates.dealership_id', $id)->get();

        $event = Event::join('event_dates', 'event_dates.event_id', '=', 'events.id')
                    ->select('events.*')
                    ->where('event_dates.dealership_id', $id)->first();

        if(empty($event)) {
            //Redirects back if Event has no dates
            return redirect()->back()->with('warning', 'Dates need to be added to the selected Event.');

        }

        return view('admin.appointments.show')
                    ->with('dates', $dates)
                    ->with('event', $event)
                    ->with('dealership', $dealership);


    }

    //Shows renewals Prospects
    public function prospectsRenewals($event_id, $dealership_id) {

        $adminRole = new Admin; //Creates an Admin Method
        $admin = auth('admin')->user();
        $role = $adminRole->adminRole($admin->id); //Checks logged in admin role

        $dealership = Dealership::find($dealership_id);

        $renewal = 'RENEW';

        $prospects = Book::select('books.*')
                        //->join('book_exec', 'book_exec.book_id', 'books.id')
                        ->leftJoin('appointments', 'appointments.book_id', 'books.id')
                        ->where('books.dealership_code', $dealership->code)
                        ->where('books.event_id', $event_id)
                        ->Where('books.customer_number', 'LIKE', "%{$renewal}%")
                        ->orderBy('books.name', 'ASC')
                        ->paginate(50);


        $dealerships    =   Dealership::select('dealerships.*')
                                ->join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                                ->join('admin_dealership', 'admin_dealership.dealership_id', 'dealerships.id')
                                ->where('dealership_event.event_id', $event_id)
                                ->groupBy('dealerships.name')
                                ->get();


        //return $dealerships;

        //return $prospects;
        return view('admin.appointments.prospects-renewals')
                ->with('dealerships', $dealerships)
                ->with('dealership', $dealership)
                ->with('event_id', $event_id)
                ->with('prospects', $prospects);


    }

    //Fetchs Renewals Prospects data of search results
    public function fetchRenewalsData(Request $request){

        $dealership = Dealership::where('code', request('dealership_code'))->first();
        $terms = explode(' ', request('keyword'));
        $renewal = 'RENEW';

        //return request('event_id');

        $prospects   = Book::select('books.*')
                            ->where('books.event_id', request('event_id'))
                            ->where('books.dealership_code', request('dealership_code'))
                            ->Where('books.customer_number', 'LIKE', "%{$renewal}%")
                            ->where(function($query) use ($terms){
                                foreach($terms as $term){
                                    $query->where('books.customer_number', 'LIKE', "%{$term}%")
                                        ->orWhere('books.name', 'LIKE', "%{$term}%")
                                        ->orWhere('books.surname', 'LIKE', "%{$term}%")
                                        ->orWhere('books.vehicle_reg', 'LIKE', "%{$term}%")
                                        ->orWhere('books.email', 'LIKE', "%{$term}%");
                                }
                            })
                            ->orderBy('books.name', 'ASC')
                            ->paginate(50);


        $message    = "<i class='far fa-meh fs-180'></i> We're Sorry but no results were found, please try again.";

        return view('admin.appointments._results')
                        ->with('prospects', $prospects)
                        ->with('dealership', $dealership)
                        ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }

    //Shows form for admin with permissions to make a prospect booking
    public function adminCreateAppointment($event_id, $dealership_id, $prospect_id){
        $prospect = Book::find($prospect_id);
        $dealership = Dealership::find($dealership_id);
        $vehicles = Vehicle::with('brand.dealership')->orderBy('order', 'ASC')->get();

        $dates = EventDate::where('dealership_id', $dealership->id)
                    ->where('event_id', $event_id)
                    ->orderBy('date', 'ASC')
                    ->get();

        $event = Event::find($event_id);

        if($event->inc_exec == 0){
            return view('admin.appointments.create-exc-exec-appointment')
                ->with('dealership_id', $dealership_id)
                ->with('dealership', $dealership)
                ->with('event_id', $event_id)
                ->with('vehicles', $vehicles)
                ->with('dates', $dates)
                ->with('prospect', $prospect);
        }else{
            return view('admin.appointments.create-appointment-with-registered-prospect')
                ->with('dealership_id', $dealership_id)
                ->with('dealership', $dealership)
                ->with('event_id', $event_id)
                ->with('vehicles', $vehicles)
                ->with('dates', $dates)
                ->with('prospect', $prospect);
        }
    }

    //Shows form for admin with permissions to make a prospect booking
    public function appointmentProspectsRegister($event_id, $dealership_id){

        $dealership = Dealership::find($dealership_id);
        $vehicles = Vehicle::with('brand.dealership')->orderBy('order', 'ASC')->get();

        $dates = EventDate::where('dealership_id', $dealership->id)
                    ->where('event_id', $event_id)
                    ->orderBy('date', 'ASC')
                    ->get();

        $event = Event::find($event_id);

        if($event->inc_exec == 0){
            return view('admin.appointments.no-exec-register-prospect')
                    ->with('dealership_id', $dealership_id)
                    ->with('dealership', $dealership)
                    ->with('event_id', $event_id)
                    ->with('vehicles', $vehicles)
                    ->with('dates', $dates);

        }else{
            return view('admin.appointments.create-appointment-and-register-prospect')
                    ->with('dealership_id', $dealership_id)
                    ->with('dealership', $dealership)
                    ->with('event_id', $event_id)
                    ->with('vehicles', $vehicles)
                    ->with('dates', $dates);
        }

    }

    //Stores appointment
    public function storesAppointment(Request $request){

        $booked_by = auth('admin')->user();

        if($request->confirm == 1){
            $this->validate($request, [

                'date_id' => 'required',
                'time_id' => 'required',
                'exec_id' => 'required',
            ],[

                'date_id.required' => 'A date is required',
                'time_id.required' => 'A time is required',
                'exec_id.required' => 'An Exec is required',
            ]);

        }


        //Checks if Prospect already exists
        //Redirects back if it does
        $book = Book::where('id', $request->prospect_id)->where('event_id', $request->event_id)->first();

        //Checks is Appointment with current Prospects exists
        //Redirects back if it does
        $appointment_exists = Appointment::where('book_id', $book->id)->where('event_id', $request->event_id)->first();
        if ($appointment_exists) {
            //return response()->json("exists");
            return redirect()->back()->with('success', 'It seems to an appointment with [' .$book->name. '] already in the system!');
        }

        $appointment = new Appointment;

        //Appointments Details
        $appointment->booked_by = $booked_by->id;
        $appointment->dealership_id = $request->dealership_id;
        $appointment->event_id = $request->event_id;
        $appointment->book_id = $request->prospect_id;
        $appointment->date = $request->date_id;
        $appointment->event_time_id = $request->time_id;

        $appointment->friend_interest = $request->friend_interest;
        $appointment->friend_name = $request->friend_name;
        $appointment->friend_model_interest = $request->friend_model_interest;

        $appointment->registration =   $request->registration;
        $appointment->make = $request->make;
        $appointment->colour = $request->colour;
        $appointment->fuel_type = $request->fuel_type;
        $appointment->mileage = $request->mileage;
        $appointment->part_exchange = $request->part_exchange;
        $appointment->model_interest = $request->model_interest;
        $appointment->drink = $request->drink;
        $appointment->preference = $request->preference;

        if ($request->has('vehicles_id')) {
            $appointment->vehicles = json_encode($request->vehicles_id);
        }else{
            $appointment->vehicles = '[]';
        }

        $appointment->notes = $request->notes;
        $appointment->cancelled = 0;

        $appointment->call_attempts = $request->call_attempts ;
        $appointment->call_made = $request->call_made;
        $appointment->call_back = $request->call_back;
        $appointment->message_left = $request->message_left;

        if ($request->confirm == 1) {

            $appointment->exec_id = $request->exec_id;

            $appointment->confirm = 1;
            $appointment->in_progress = 0;
            $appointment->not_interested = 0;

        }


        if ($request->in_progress == 1) {

            $appointment->confirm = 0;
            $appointment->in_progress = 1;
            $appointment->not_interested = 0;
        }


        if ($request->not_interested == 1) {
            $appointment->confirm = 0;
            $appointment->in_progress = 0;
            $appointment->not_interested = 1;
        }

        //return $request->all();
        $appointment->save();

        if($appointment->confirm == 1){

            //Send email notification to customer
            emailProspect($appointment->id);

            // //Sends email to  Brand manager and admins with notify-booking role
            emailExecAppointment($appointment->id);

        }

        $prospect = Book::find($appointment->book_id);

        DB::table('book_exec')->insert([
            'book_id' => $prospect->id,
            'exec_id' => $appointment->exec_id,
        ]);


        return redirect()
                ->route('admin.appointment.prospect', [$appointment->event_id, $appointment->dealership_id])
                ->with('success', 'Appointment for [' .$prospect->title. ' ' .$prospect->surname. '] has successfully been created!');


    }

    //Stores prospect and appointment
    public function storesProspectAndAppointment(Request $request){


        $booked_by = auth('admin')->user();

        if($request->friend_interest == 1){

            $this->validate($request, [
                'friend_name' => 'required',
            ],[
                'friend_name.required' => 'A Friend name is required!',
            ]);
        }


        $this->validate($request, [
            'title' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'date_id' => 'required',
            'time_id' => 'required',
            'exec_id' => 'required',


        ],[
            'title.required' => 'A title is required',
            'name.required' => 'A name is required',
            'surname.required' => 'A surname is required',
            'email.required' => 'An email is required',
            'email.email' => 'Email needs to be valid',
            'mobile.required' => 'A mobile is required',
            'date_id.required' => 'A date is required',
            'time_id.required' => 'A time is required',
            'exec_id.required' => 'An Exec is required',

        ]);

        //Checks if Prospect already exists
        //Redirects back if it does
        $prospect = Book::where('email', $request->email)->where('event_id', $request->event_id)->first();
        if ($prospect) {
            //return response()->json("exists");
            return redirect()->back()->with('success', 'Prospect [' .$prospect->name. '] already in the system!');

            //Checks is Appointment with current Prospects exists
            //Redirects back if it does
            $appointment_exists = Appointment::where('book_id', $prospect->id)->where('event_id', $request->event_id)->first();
            if ($appointment_exists) {
                //return response()->json("exists");
                return redirect()->back()->with('success', 'It seems to an appointment with [' .$prospect->name. '] already in the system!');
            }
        }

        $prospect = new Book;
        $appointment = new Appointment;
        $dealership = Dealership::find($request->dealership_id);

        $length = 6;
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789?!><$%£)(!^/\|';
        $count = mb_strlen($chars);

        // Gets a 13 characters random password
        for ($i = 0, $value = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $value .= mb_substr($chars, $index, 1);
        }

        //Prospect Details
        $prospect->customer_number = $value ."_".str_replace(' ', '-', $booked_by->name);
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

        //Appointments Details
        $appointment->booked_by = $booked_by->id;
        $appointment->dealership_id = $request->dealership_id;
        $appointment->event_id = $request->event_id;
        $appointment->book_id = $prospect->id;
        $appointment->date = $request->date_id;
        $appointment->event_time_id = $request->time_id;
        $appointment->exec_id = $request->exec_id;

        $appointment->friend_interest = $request->friend_interest;
        $appointment->friend_name = $request->friend_name;
        $appointment->friend_model_interest = $request->friend_model_interest;

        $appointment->registration =   $request->registration;
        $appointment->make = $request->make;
        $appointment->colour = $request->colour;
        $appointment->fuel_type = $request->fuel_type;
        $appointment->mileage = $request->mileage;
        $appointment->part_exchange = $request->part_exchange;
        $appointment->model_interest = $request->model_interest;
        $appointment->drink = $request->drink;
        $appointment->preference = $request->preference;

        if ($request->has('vehicles_id')) {
            $appointment->vehicles = json_encode($request->vehicles_id);
        }else{
            $appointment->vehicles = '[]';
        }



        $appointment->notes = $request->notes;
        $appointment->cancelled = 0;

        $appointment->call_attempts = $request->call_attempts ;
        $appointment->call_made = $request->call_made;
        $appointment->call_back = $request->call_back;
        $appointment->message_left = $request->message_left;

        if ($request->confirm == 1) {
            $appointment->confirm = 1;
            $appointment->in_progress = 0;
            $appointment->not_interested = 0;

        }

        if ($request->in_progress == 1) {
            $appointment->confirm = 0;
            $appointment->in_progress = 1;
            $appointment->not_interested = 0;
        }

        if ($request->not_interested == 1) {
            $appointment->confirm = 0;
            $appointment->in_progress = 0;
            $appointment->not_interested = 1;
        }

        $appointment->save();

        if($appointment->confirm = 1){
            //Send email notification to customer
            emailProspect($appointment->id);

            // //Sends email to  Brand manager and admins with notify-booking role
            emailExecAppointment($appointment->id);
        }

        DB::table('book_exec')->insert([
            'book_id' => $prospect->id,
            'exec_id' => $appointment->exec_id,
        ]);


        return redirect()
                ->route('admin.appointment.prospect', [$appointment->event_id, $appointment->dealership_id])
                ->with('success', 'Appointment for [' .$prospect->title. ' ' .$prospect->surname. '] has successfully been created!');

    }

    //Shows form for admin with permissions to make a prospect booking
    public function adminEditAppointment($event_id, $dealership_id, $prospect_id){

        //Checks if appointment exists
        //Returns to appointments page if there's no appointment
        $appointment = Appointment::where('book_id', $prospect_id)->first();
        if(empty($appointment)){
            return redirect()->route('admin.appointment.index');
        }

        $prospect = Book::find($prospect_id);
        $dealership = Dealership::find($dealership_id);
        $vehicles = Vehicle::with('brand.dealership')->orderBy('order', 'ASC')->get();

        $dates = EventDate::where('dealership_id', $dealership->id)
                    ->where('event_id', $event_id)
                    ->orderBy('date', 'ASC')
                    ->get();

        $slots = new EventTime;
        $event = Event::find($event_id);

        $execs = new Exec;

        if($event->inc_exec == 0){

            return view('admin.appointments.edit-exc-exec-appointment')
                        ->with('appointment', $appointment)
                        ->with('dealership_id', $dealership_id)
                        ->with('dealership', $dealership)
                        ->with('event_id', $event_id)
                        ->with('event', $event)
                        ->with('vehicles', $vehicles)
                        ->with('dates', $dates)
                        ->with('slots', $slots)
                        ->with('execs', $execs)
                        ->with('prospect', $prospect);
        }else{

            return view('admin.appointments.edit-appointment')
            ->with('appointment', $appointment)
            ->with('dealership_id', $dealership_id)
            ->with('dealership', $dealership)
            ->with('event_id', $event_id)
            ->with('event', $event)
            ->with('vehicles', $vehicles)
            ->with('dates', $dates)
            ->with('slots', $slots)
            ->with('execs', $execs)
            ->with('prospect', $prospect);
        }

    }

    //Shows Prospects that were Registered through Registration form
    public function prospectsRegistered($event_id, $dealership_id) {

        $adminRole = new Admin; //Creates an Admin Method
        $admin = auth('admin')->user();
        $role = $adminRole->adminRole($admin->id); //Checks logged in admin role

        $dealership = Dealership::find($dealership_id);

        $registered = 'CUST';

        if($role->name == 'super' || $role->name == 'super-admin'|| $role->name == 'brand-manager' || $role->name == 'renewals'|| $role->name == 'reception'){
                $prospects = Book::select('books.*')
                                ->join('appointments', 'appointments.book_id', 'books.id')
                                ->where('books.dealership_code', $dealership->code)
                                ->where('books.event_id', $event_id)
                                ->Where('books.customer_number', 'LIKE', "%{$registered}%")
                                ->orderBy('books.name', 'ASC')
                                ->paginate(50);


                $dealerships = Dealership::select('dealerships.*')
                                ->join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                                ->join('admin_dealership', 'admin_dealership.dealership_id', 'dealerships.id')
                                ->where('dealership_event.event_id', $event_id)
                                ->groupBy('dealerships.name')
                                ->get();


        }else{

                $prospects = Book::select('books.*', 'execs.name as exec_name')
                                ->join('appointments', 'appointments.book_id', 'books.id')
                                ->join('execs', 'execs.id', 'appointments.exec_id')
                                ->where('books.dealership_code', $dealership->code)
                                ->where('books.event_id', $event_id)
                                ->Where('books.customer_number', 'LIKE', "%{$registered}%")
                                ->orderBy('books.name', 'ASC')
                                ->paginate(50);


                $dealerships = Dealership::select('dealerships.*')
                                ->join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                                ->join('admin_dealership', 'admin_dealership.dealership_id', 'dealerships.id')
                                ->where('dealership_event.event_id', $event_id)
                                ->where('admin_dealership.dealership_id', $dealership_id)
                                ->groupBy('dealerships.name')
                                ->get();


        }



        return view('admin.appointments.prospects-registered')
                ->with('dealerships', $dealerships)
                ->with('dealership', $dealership)
                ->with('event_id', $event_id)
                ->with('prospects', $prospects);


    }

    //Shows appointments customer by dealership
    public function prospects($event_id, $dealership_id) {

        $adminRole = new Admin; //Creates an Admin Method
        $admin = auth('admin')->user();
        $exec = Exec::where('email', $admin->email)->first(); //Checks if Admin is an exec
        $role = $adminRole->adminRole($admin->id); //Checks logged in admin role

        $dealership = Dealership::find($dealership_id);

        if($role->name == 'super' || $role->name == 'super-admin' || $role->name == 'brand-manager' || $role->name == 'renewals' || $role->name == 'reception'){
                $prospects = Book::select('books.*')
                                ->where('books.dealership_code', $dealership->code)
                                ->where('books.event_id', $event_id)
                                //->Where('books.customer_number', 'NOT LIKE', "%{$renewal}%")
                                ->orderBy('books.name', 'ASC')
                                ->paginate(50);

                //return $$prospects;


        }elseif($exec){

           // return hasRole($admin->id, "brand-manager");

            if(isset(hasRole($admin->id, "brand-manager")->name) && hasRole($admin->id, "brand-manager")->name == 'brand-manager'){
                $prospects = Book::select('books.*')
                                ->where('books.dealership_code', $dealership->code)
                                ->where('books.event_id', $event_id)
                                //->Where('books.customer_number', 'NOT LIKE', "%{$renewal}%")
                                ->orderBy('books.name', 'ASC')
                                ->paginate(50);

                                //return $exec;

            }else{
                $prospects = Book::select('books.*')
                    ->join('book_exec', 'book_exec.book_id', 'books.id')
                    ->join('execs', 'execs.id', 'book_exec.exec_id')
                    ->where('books.dealership_code', $dealership->code)
                    ->where('books.event_id', $event_id)
                    ->where('execs.id', $exec->id)
                    ->orderBy('books.name', 'ASC')
                    ->paginate(50);
            }


        }else{

               $prospects = Book::select('books.*')
                                ->where('books.dealership_code', $dealership->code)
                                ->where('books.event_id', $event_id)
                                ->orderBy('books.name', 'ASC')
                                ->paginate(50);

        }

        return view('admin.appointments.prospects')
                ->with('dealership', $dealership)
                ->with('event_id', $event_id)
                ->with('prospects', $prospects);


    }

    //Shows appointments customer by dealership
    public function hotLeads($event_id, $dealership_id) {

        $adminRole = new Admin; //Creates an Admin Method
        $admin = auth('admin')->user();
        $role = $adminRole->adminRole($admin->id); //Checks logged in admin role

        $dealership = Dealership::find($dealership_id);

        $prospects = Book::select('books.*')
                        ->join('appointments', 'appointments.book_id', 'books.id')
                        ->where('appointments.confirm', 0)
                        ->where('appointments.completed', 0)
                        ->where('appointments.not_interested', 0)
                        ->where('appointments.cancelled', 0)
                        ->where('appointments.in_progress', 0)
                        ->where('appointments.dealership_id', $dealership->id)
                        ->where('books.event_id', $event_id)
                        ->whereNull('appointments.booked_by')
                        ->whereNull('appointments.edited_by')
                        ->orderBy('books.name', 'ASC')
                        ->paginate(50);


        //return $dealership;
        return view('admin.appointments.hot-leads')
                ->with('dealership', $dealership)
                ->with('event_id', $event_id)
                ->with('prospects', $prospects);


    }

    //Shows appointments customer by dealership
    public function showInProgress($event_id, $dealership_id) {

        $adminRole = new Admin; //Creates an Admin Method
        $admin = auth('admin')->user();
        $role = $adminRole->adminRole($admin->id); //Checks logged in admin role

        $dealership = Dealership::find($dealership_id);


        $prospects = Book::select('books.*')
                        ->join('appointments', 'appointments.book_id', 'books.id')
                        ->where('appointments.in_progress', 1)
                        ->where('appointments.dealership_id', $dealership->id)
                        ->where('books.event_id', $event_id)
                        // ->whereNull('appointments.booked_by')
                        // ->whereNull('appointments.edited_by')
                        ->orderBy('books.name', 'ASC')
                        //->get();
                        ->paginate(50);


        //return $prospects;
        return view('admin.appointments.in-progress')
                ->with('dealership', $dealership)
                ->with('event_id', $event_id)
                ->with('prospects', $prospects);


    }

    //Shows appointments customer by dealership
    public function showSales($event_id, $dealership_id) {

        $adminRole = new Admin; //Creates an Admin Method
        $admin =   auth('admin')->user();
        $role = $adminRole->adminRole($admin->id); //Checks logged in admin role

        $dealership = Dealership::find($dealership_id);

        $prospects = Book::select('books.*')
                        ->join('appointments', 'appointments.book_id', 'books.id')
                        ->where('appointments.in_progress', 1)
                        ->where('appointments.dealership_id', $dealership->id)
                        ->where('books.event_id', $event_id)
                        ->orderBy('books.name', 'ASC')
                        ->get();

        $sales = Sale::select('sales.*', 'books.customer_number')
                    ->join('appointments', 'appointments.id', 'sales.appointment_id')
                    ->join('books', 'books.id', 'appointments.book_id')
                    ->where('appointments.event_id', $event_id)
                    ->where('appointments.dealership_id', $dealership->id)
                    ->orderBy('appointments.dealership_id', 'ASC')
                    ->get();



        //return $sales;
        return view('admin.appointments.show-sales')
                ->with('dealership', $dealership)
                ->with('event_id', $event_id)
                ->with('sales', $sales)
                ->with('prospects', $prospects);


    }

    //Fetchs Prospects data of search results
    public function fetchData(Request $request){

        $adminRole = new Admin; //Creates an Admin Method
        $admin = auth('admin')->user();
        $exec = Exec::where('email', $admin->email)->first(); //Checks if Admin is an exec
        $role = $adminRole->adminRole($admin->id); //Checks logged in admin role

        $dealership = Dealership::where('code', request('dealership_code'))->first();
        $terms = explode(' ', request('keyword'));

        // if($role->name == 'super' || $role->name == 'super-admin'  || $role->name == 'renewals' || $role->name == 'reception'){

        //         $prospects = Book::select('books.*')

        //                     ->where('books.event_id', request('event_id'))
        //                     ->where('books.dealership_code', request('dealership_code'))
        //                     //->Where('books.customer_number', 'NOT LIKE', "%{$renewal}%")
        //                     ->where(function($query) use ($terms){
        //                         foreach($terms as $term){
        //                             $query->where('books.customer_number', 'LIKE', "%{$term}%")
        //                                     ->orWhere('books.name', 'LIKE', "%{$term}%")
        //                                     ->orWhere('books.surname', 'LIKE', "%{$term}%")
        //                                     ->orWhere('books.vehicle_reg', 'LIKE', "%{$term}%")
        //                                     ->orWhere('books.email', 'LIKE', "%{$term}%");
        //                         }
        //                     })
        //                     ->orderBy('books.name', 'ASC')
        //                     ->paginate(50);


        // }else
        if($exec){

            $prospects = Book::select('books.*')
                            ->join('book_exec', 'book_exec.book_id', 'books.id')
                            ->join('execs', 'execs.id', 'book_exec.exec_id')
                            ->where('books.event_id', request('event_id'))
                            ->where('books.dealership_code', request('dealership_code'))
                            ->where('execs.id', $exec->id)
                            ->where(function($query) use ($terms){
                                foreach($terms as $term){
                                    $query->where('books.customer_number', 'LIKE', "%{$term}%")
                                            ->orWhere('books.name', 'LIKE', "%{$term}%")
                                            ->orWhere('books.surname', 'LIKE', "%{$term}%")
                                            ->orWhere('books.vehicle_reg', 'LIKE', "%{$term}%")
                                            ->orWhere('books.email', 'LIKE', "%{$term}%");
                                }
                            })
                            ->orderBy('books.name', 'ASC')
                            ->paginate(50);

        }else{

            $prospects = Book::select('books.*')
                ->where('books.event_id', request('event_id'))
                ->where('books.dealership_code', request('dealership_code'))
                //->Where('books.customer_number', 'NOT LIKE', "%{$renewal}%")
                ->where(function($query) use ($terms){
                    foreach($terms as $term){
                        $query->where('books.customer_number', 'LIKE', "%{$term}%")
                                ->orWhere('books.name', 'LIKE', "%{$term}%")
                                ->orWhere('books.surname', 'LIKE', "%{$term}%")
                                ->orWhere('books.vehicle_reg', 'LIKE', "%{$term}%")
                                ->orWhere('books.email', 'LIKE', "%{$term}%");
                    }
                })
                ->orderBy('books.name', 'ASC')
                ->paginate(50);

            // $prospects = Book::select('books.*')
            //                 ->join('book_exec', 'book_exec.book_id', 'books.id')
            //                 ->join('execs', 'execs.id', 'book_exec.exec_id')
            //                 ->where('books.event_id', request('event_id'))
            //                 ->where('books.dealership_code', request('dealership_code'))
            //                 ->where(function($query) use ($terms){
            //                     foreach($terms as $term){
            //                         $query->where('books.customer_number', 'LIKE', "%{$term}%")
            //                                 ->orWhere('books.name', 'LIKE', "%{$term}%")
            //                                 ->orWhere('books.surname', 'LIKE', "%{$term}%")
            //                                 ->orWhere('books.vehicle_reg', 'LIKE', "%{$term}%")
            //                                 ->orWhere('books.email', 'LIKE', "%{$term}%");
            //                     }
            //                 })
            //                 ->orderBy('books.name', 'ASC')
            //                 ->paginate(50);
        }


        return view('admin.appointments._results')
                        ->with('prospects', $prospects)
                        ->with('dealership', $dealership)
                        ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();


    }

    //Fetchs Prospects that are confirmed for appointments
    public function fetchConfirmedData(Request $request){

        $dealership = Dealership::where('code', request('dealership_code'))->first();
        $admin = auth('admin')->user();
        $exec = Exec::where('email', $admin->email)->first(); //Checks if Admin is an exec

        if($exec){

            $prospects = Appointment::select('books.*', 'appointments.call_made', 'appointments.confirm', 'appointments.call_back')
                            ->join('books', 'books.id', 'appointments.book_id')
                            ->join('book_exec', 'book_exec.book_id', 'books.id')
                            ->where('appointments.dealership_id', $dealership->id)
                            ->where('books.event_id', $request->event_id)
                            ->where('book_exec.exec_id', $exec->id)
                            ->where('appointments.confirm', 1)
                            ->orderBy('books.name', 'ASC')
                            ->paginate(1000);


        }else{

            $prospects = Appointment::select('books.*', 'appointments.call_made', 'appointments.confirm', 'appointments.call_back')
                            ->join('books', 'books.id', 'appointments.book_id')
                            ->where('books.event_id', request('event_id'))
                            ->where('appointments.dealership_id', $dealership->id)
                            ->where('appointments.confirm', 1)
                            ->orderBy('books.name', 'ASC')
                            ->paginate(1000);
        }

        //return $prospects;

        $event = Event::find($request->event_id);

        return view('admin.appointments._results-confirmed')
                        ->with('prospects', $prospects)
                        ->with('event', $event)
                        ->with('dealership', $dealership)
                        ->render();

    }

    //Fetchs Prospects that are confirmed for appointments
    public function fetchInProgressData(Request $request){

        $dealership = Dealership::where('code', request('dealership_code'))->first();

        $admin = auth('admin')->user();
        $exec = Exec::where('email', $admin->email)->first(); //Checks if Admin is an exec

        if($exec){

            $prospects = Appointment::select('books.*', 'appointments.call_made', 'appointments.confirm', 'appointments.call_back')
                            ->join('books', 'books.id', 'appointments.book_id')
                            ->join('book_exec', 'book_exec.book_id', 'books.id')
                            ->where('appointments.dealership_id', $dealership->id)
                            ->where('books.event_id', $request->event_id)
                            ->where('book_exec.exec_id', $exec->id)
                            ->where('appointments.in_progress', 1)
                            ->orderBy('books.name', 'ASC')
                            ->paginate(1000);

        }else{



            $prospects = Appointment::select('books.*', 'appointments.call_made', 'appointments.confirm', 'appointments.call_back')
                            ->join('books', 'books.id', 'appointments.book_id')
                            ->where('books.event_id', request('event_id'))
                            ->where('appointments.dealership_id', $dealership->id)
                            ->where('appointments.in_progress', 1)
                            ->orderBy('books.name', 'ASC')
                            ->paginate(1000);



        }



        $event = Event::find($request->event_id);

        return view('admin.appointments._results-in-progress')
                        ->with('prospects', $prospects)
                        ->with('event', $event)
                        ->with('dealership', $dealership)
                        // ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }

    //Fetchs Prospects that are Require a call Back
    public function fetchRequireCallBack(Request $request){


        $dealership = Dealership::where('code', request('dealership_code'))->first();

        $admin = auth('admin')->user();
        $exec = Exec::where('email', $admin->email)->first(); //Checks if Admin is an exec

        if($exec){

            $prospects = Appointment::select('books.*', 'appointments.call_made',  'appointments.call_back')
                                ->join('books', 'books.id', 'appointments.book_id')
                                ->where('books.event_id', request('event_id'))
                                ->where('appointments.dealership_id', $dealership->id)
                                ->where('appointments.call_back', 1)
                                ->where('appointments.exec_id', $exec->id)
                                // ->whereNull('appointments.booked_by')
                                // ->whereNull('appointments.edited_by')
                                ->orderBy('books.name', 'ASC')
                                ->paginate(1000);



        }else{


            $prospects = Appointment::select('books.*', 'appointments.call_made',  'appointments.call_back')
                            ->join('books', 'books.id', 'appointments.book_id')
                            ->where('books.event_id', request('event_id'))
                            ->where('appointments.dealership_id', $dealership->id)
                            ->where('appointments.call_back', 1)
                            // ->whereNull('appointments.booked_by')
                            // ->whereNull('appointments.edited_by')
                            ->orderBy('books.name', 'ASC')
                            ->paginate(1000);
        }


        return view('admin.appointments._results-call-back')
                        ->with('prospects', $prospects)
                        ->with('dealership', $dealership)
                        // ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }

    //Fetchs Prospects that are confirmed for appointments
    public function fetchHotProspectData(Request $request){


        $dealership = Dealership::where('code', request('dealership_code'))->first();

        $admin = auth('admin')->user();
        $exec = Exec::where('email', $admin->email)->first(); //Checks if Admin is an exec

        if($exec){

            $prospects = Appointment::select('books.*', 'appointments.call_made', 'appointments.call_back')
                            ->join('books', 'books.id', 'appointments.book_id')
                            ->join('book_exec', 'book_exec.book_id', 'books.id')
                            ->where('appointments.dealership_id', $dealership->id)
                            ->where('books.event_id', $request->event_id)
                            ->where('book_exec.exec_id', $exec->id)
                            ->where('appointments.confirm', 0)
                            ->where('appointments.completed', 0)
                            ->where('appointments.not_interested', 0)
                            ->where('appointments.cancelled', 0)
                            ->where('appointments.in_progress', 0)
                            ->whereNull('appointments.booked_by')
                            ->whereNull('appointments.edited_by')
                            ->orderBy('books.name', 'ASC')
                            ->paginate(1000);

        }else{


            $prospects = Appointment::select('books.*', 'appointments.call_made',  'appointments.call_back')
                        ->join('books', 'books.id', 'appointments.book_id')
                        ->where('books.event_id', request('event_id'))
                        ->where('appointments.dealership_id', $dealership->id)
                        ->where('appointments.confirm', 0)
                        ->where('appointments.completed', 0)
                        ->where('appointments.not_interested', 0)
                        ->where('appointments.cancelled', 0)
                        ->where('appointments.in_progress', 0)
                        ->whereNull('appointments.booked_by')
                        ->whereNull('appointments.edited_by')
                        ->orderBy('books.name', 'ASC')
                        ->get();

        }

        //return $prospects->all();

        return view('admin.appointments._results-hot-leads')
                        ->with('prospects', $prospects)
                        ->with('dealership', $dealership)
                        // ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }

    //Fetchs Prospects that are confirmed for appointments
    public function fetchCompletedData(Request $request){


        $dealership = Dealership::where('code', request('dealership_code'))->first();

        $admin = auth('admin')->user();
        $exec = Exec::where('email', $admin->email)->first(); //Checks if Admin is an exec

        if($exec){

            $prospects = Appointment::select('books.*', 'appointments.call_made', 'appointments.confirm', 'appointments.call_back')
                            ->join('books', 'books.id', 'appointments.book_id')
                            ->where('appointments.dealership_id', $dealership->id)
                            ->where('books.event_id', request('event_id'))
                            ->where('appointments.exec_id', $exec->id)
                            ->where('appointments.completed', 1)
                            ->orderBy('books.name', 'ASC')
                            ->paginate(1000);


        }else{

            $prospects = Appointment::select('books.*', 'appointments.call_made', 'appointments.confirm', 'appointments.call_back')
                            ->join('books', 'books.id', 'appointments.book_id')
                            ->where('books.event_id', request('event_id'))
                            ->where('appointments.dealership_id', $dealership->id)
                            ->where('appointments.completed', 1)
                            ->orderBy('books.name', 'ASC')
                            ->paginate(1000);

        }


        return view('admin.appointments._results-completed')
                        ->with('prospects', $prospects)
                        ->with('dealership', $dealership)
                        // ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }


    //gets Time Slots based on date selected
    public function getTimes(Request $request){

        $event_id = $request->event_id;
        $date_id = $request->date_id;
        $dealership_id = $request->dealership_id;
        $event = Event::find($event_id);


        $slots = EventTime::where('event_date_id', $date_id)->orderBy('time', 'ASC')->get();

        return view('admin.appointments._time-results')
                    ->with('dealership_id', $dealership_id)
                    ->with('event', $event)
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

        $execs = new Exec;

        return view('admin.appointments._exec-results')
                    ->with('dealership', $dealership)
                    ->with('event_id', $event_id)
                    ->with('date_id', $date_id)
                    ->with('time_id', $time_id)
                    ->with('execs', $execs);

    }

    //gets Time Slots based on date selected
    public function getEditTimes(Request $request){

        $event_id = $request->event_id;
        $date_id = $request->date_id;
        $dealership_id = $request->dealership_id;
        $appointment_id = $request->appointment_id;

        $event = Event::find($event_id);
        $appointment = Appointment::find($appointment_id);

        $slots = EventTime::where('event_date_id', $date_id)->orderBy('time', 'ASC')->get();

        return view('admin.appointments._edit-time-results')
                    ->with('dealership_id', $dealership_id)
                    ->with('appointment', $appointment)
                    ->with('event_id', $event_id)
                    ->with('event', $event)
                    ->with('date_id', $date_id)
                    ->with('slots', $slots);

    }

    //gets Execs based on Time selected
    public function getEditExecs(Request $request){

        $event_id = $request->event_id;
        $date_id = $request->date_id;
        $dealership_id = $request->dealership_id;
        $time_id = $request->time_id;
        $book_id = $request->book_id;
        $appointment_id = $request->appointment_id;

        $dealership = Dealership::find($dealership_id);
        $execs = Exec::select('execs.*')
                    ->join('event_time_exec', 'event_time_exec.exec_id', 'execs.id')
                    ->where('dealership_code', $dealership->code)
                    ->where('event_time_exec.event_time_id', $time_id)
                    ->groupBy('execs.name')
                    ->orderBy('name', 'ASC')->get();

        $appointment = Appointment::find($appointment_id);
        $date = EventDate::find($date_id);
        //return $appointment_id ." ". $appointment->id;

        return view('admin.appointments._edit-exec-results')
                    ->with('dealership', $dealership)
                    ->with('appointment', $appointment)
                    ->with('appointment_id', $appointment_id)
                    ->with('event_id', $event_id)
                    ->with('date', $date)
                    ->with('date_id', $date_id)
                    ->with('time_id', $time_id)
                    ->with('execs', $execs);

    }

    //Returns log appointments
    public function logAppointment($date_id, $id){

        $dealership = Dealership::find($id);
        $date = EventDate::find($date_id);
        $times = EventTime::where('event_date_id', $date->id)->orderBy('time', 'ASC')->get();

        $appointments = Appointment::Select('appointments.*')
                            ->join('books', 'books.id', 'appointments.book_id')
                            ->where('confirm', "=", 1)
                            ->where('completed', "=", 0)
                            //->whereNotNull('exec_id')
                            ->where('date', $date->date)->get();

        $event = Event::join('event_dates', 'event_dates.event_id', '=', 'events.id')
                    ->select('events.*')
                    ->where('event_dates.dealership_id', $id)->first();


        $book = new Book;

        //dd($appointments);
        return view('admin.appointments.logs')
                    ->with('appointments', $appointments)
                    ->with('dealership', $dealership)
                    ->with('times', $times)
                    ->with('event', $event)
                    ->with('book', $book)
                    ->with('date', $date);
    }

    //Pulls all the event bookings information for all active days
    public function receptionLog($dealership_id) {


        $dealership = Dealership::find($dealership_id);
        $event = DB::table('dealership_event')->where('dealership_id', $dealership_id)->first();
        $confirm = Appointment::select('appointments.*')
                    ->join('event_times', 'event_times.id', 'appointments.event_time_id')
                    ->where('appointments.event_id', $event->event_id)
                    ->where('appointments.dealership_id', $dealership->id)
                    ->where('appointments.confirm', 1)
                    //->orWhere('appointments.cancelled', 2)
                    ->where('appointments.exec_id', '!=', NULL)
                    ->orderBy('appointments.date', 'ASC')
                    ->orderBy('event_times.time', 'ASC')
                    ->get();

        //return count($appointments);

        /* */
        $cancelled = Appointment::select('appointments.*')
                        ->join('event_times', 'event_times.id', 'appointments.event_time_id')
                        ->where('appointments.event_id', $event->id)
                        ->where('appointments.dealership_id', $dealership->id)
                        ->where('appointments.cancelled', 2)
                        ->where('appointments.exec_id', '!=', NULL)
                        //->orderBy('appointments.date', 'ASC')
                        ->orderBy('event_times.time', 'ASC')
                        ->get();


        $appointments = $confirm->merge($cancelled);

        $times = EventTime::join('event_dates', 'event_dates.id', 'event_times.event_date_id')
                    ->select('event_times.*')
                    ->where('event_dates.date', $this->todayDate())
                    // ->where('event_dates.date', '2021-08-05')
                    ->where('event_times.dealership_id', $dealership->id)
                    ->groupBy('event_times.time')
                    ->orderBy('time', 'ASC')
                    ->get();



        $execs = Exec::where('dealership_code', $dealership->code)->get();
        $vehicles = Vehicle::with('brand.dealership')->orderBy('order', 'ASC')->get();

        $date = EventDate::where('date', $this->todayDate())->first();
        $today_date = $this->todayDate(); //'2021-07-22'; ;

        //return count($appointments);
        return view('admin.appointments.reception-log')
                    ->with('times', $times)
                    ->with('execs', $execs)
                    ->with('vehicles', $vehicles)
                    ->with('event', $event)
                    ->with('date', $date)
                    ->with('today_date', $today_date)
                    ->with('dealership', $dealership)
                    ->with('appointments', $appointments);
    }

    public function updateNotes(Request $request, $id)
    {
        //
            $appointment = Appointment::find($id);
            $appointment->notes = $request->input('notes');

            $appointment->save();
            return redirect('/dashboard/appointments/reception/'. $appointment->dealership_id)->with('success', $appointment->exec->name . ' Appointment notes has been updated! ');

    }

    // //Stores not Interested
    // public function notInterested(Request $request){

    //     $booked_by = auth('admin')->user()->id;
    //     $appointment = new Appointment;
    //     $booked = Appointment::where('book_id', $request->book_id)
    //                 ->where('event_id', $request->event_id)
    //                 ->first();

    //     if($booked){
    //         $booked->edited_by = $booked_by;
    //         $booked->dealership_id = $request->dealership_id;
    //         $booked->event_id = $request->event_id;
    //         $booked->book_id = $request->book_id;
    //         $booked->exec_id = $request->exec_id;

    //         $booked->call_attempts = $request->call_attempts;
    //         $booked->call_made = $request->call_made;
    //         $booked->call_back = $request->call_back;
    //         $booked->message_left = $request->message_left;

    //         $booked->confirm = 0;
    //         $booked->cancelled = 0;
    //         $booked->in_progress = 0;
    //         $booked->not_interested = 1;

    //         $booked->notes = $request->notes;

    //         $booked->save();


    //         return response()->json("Success, Updated");


    //     }else{
    //         //return $request->all();
    //         $appointment->booked_by = $booked_by;
    //         $appointment->dealership_id = $request->dealership_id;
    //         $appointment->event_id = $request->event_id;
    //         $appointment->book_id = $request->book_id;
    //         //$appointment->exec_id               =   $request->exec_id;

    //         $appointment->call_attempts = $request->call_attempts;
    //         $appointment->call_made = $request->call_made;
    //         $appointment->call_back = $request->call_back;
    //         $appointment->message_left = $request->message_left;

    //         $appointment->confirm = 0;
    //         $appointment->cancelled = 0;
    //         $appointment->not_interested = 1;
    //         $appointment->in_progress = 0;

    //         $appointment->notes = $request->notes;

    //         $appointment->save();


    //     }

    // }

    //Stores call made
    // public function inProgress(Request $request){

    //     $booked_by = auth('admin')->user()->id;
    //     $appointment = new Appointment;

    //     $booked = Appointment::where('book_id', $request->book_id)
    //                 ->where('event_id', $request->event_id)
    //                 ->first();
    //         //return $request->all();
    //     //Checks if appointment has been made
    //     //Returns false if exists


    //     if($booked){

    //         $booked->edited_by = $booked_by;
    //         $booked->dealership_id = $request->dealership_id;
    //         $booked->event_id = $request->event_id;
    //         $booked->book_id = $request->book_id;
    //         //$appointment->exec_id           =   $request->exec_id;

    //         $booked->call_attempts = $request->call_attempts;
    //         $booked->call_made = $request->call_made;
    //         $booked->call_back = $request->call_back;
    //         $booked->message_left = $request->message_left;

    //         $booked->confirm = 0;
    //         $booked->cancelled = 0;
    //         $booked->not_interested = 0;
    //         $booked->in_progress = 1;

    //         $booked->notes = $request->notes;

    //         $booked->save();

    //         return response()->json("Success, Updated");


    //     }else{
    //        // return 2;
    //         $appointment->booked_by = $booked_by;
    //         $appointment->dealership_id = $request->dealership_id;
    //         $appointment->event_id = $request->event_id;
    //         $appointment->book_id = $request->book_id;
    //         //$appointment->exec_id               =   $request->exec_id;

    //         $appointment->call_attempts = $request->call_attempts;
    //         $appointment->call_made = $request->call_made;
    //         $appointment->call_back = $request->call_back;
    //         $appointment->message_left = $request->message_left;

    //         $appointment->confirm = 0;
    //         $appointment->cancelled = 0;
    //         $appointment->not_interested = 0;
    //         $appointment->in_progress = 1;

    //         $appointment->notes = $request->notes;

    //         $appointment->save();


    //     }

    // }

    //Stores Cancelled
    // public function cancelled(Request $request){

    //     $appointment = new Appointment;

    //     $booked = Appointment::where('book_id', $request->book_id)
    //                 ->where('event_id', $request->event_id)
    //                 ->first();

    //     if($booked){
    //         $booked->dealership_id = $request->dealership_id;
    //         $booked->event_id = $request->event_id;
    //         $booked->book_id = $request->book_id;
    //         $appointment->exec_id = $request->exec_id;

    //         $booked->call_attempts = $request->call_attempts;
    //         $booked->call_made = $request->call_made;
    //         $booked->call_back = $request->call_back;
    //         $booked->message_left = $request->message_left;

    //         $booked->confirm = 0;
    //         $booked->cancelled = 1;
    //         $booked->not_interested = 0;
    //         $booked->in_progress = 0;


    //         $booked->notes = $request->notes;

    //         $booked->save();

    //         return response()->json("Success, Updated");


    //     }else{

    //         $appointment->dealership_id = $request->dealership_id;
    //         $appointment->event_id = $request->event_id;
    //         $appointment->book_id = $request->book_id;
    //         $appointment->exec_id = $request->exec_id;

    //         $appointment->call_attempts = $request->call_attempts;
    //         $appointment->call_made = $request->call_made;
    //         $appointment->call_back = $request->call_back;
    //         $appointment->message_left = $request->message_left;

    //         $appointment->confirm = 0;
    //         $appointment->cancelled = 1;
    //         $appointment->not_interested = 0;
    //         $appointment->in_progress = 0;

    //         $appointment->notes = $request->notes;

    //         $appointment->save();


    //     }

    // }

    //Updates appointment
    public function updateAppointment(Request $request){

       //return $request->all();

        if($request->has('btn_submit_appointment')){


            $this->validate($request, [

                'date' => 'required',
                'event_time_id' => 'required',
                'exec_id' => 'required',
            ],[

                'date.required' => 'A date is required',
                'event_time_id.required' => 'A time is required',
                'exec_id.required' => 'An Exec is required',
            ]);

        }



        $edited_by = auth('admin')->user()->id;

        $appointment = Appointment::find($request->appointment_id);

        $appointment->edited_by = $edited_by;
        $appointment->dealership_id = $request->dealership_id;
        $appointment->event_id = $request->event_id;
        $appointment->book_id = $request->book_id;

        if($request->has('btn_submit_appointment')){
            $appointment->date = $request->date;
            $appointment->event_time_id = $request->event_time_id;
            $appointment->exec_id = $request->exec_id;

        }else{
            $appointment->date = NULL;
            $appointment->event_time_id = NULL;
            $appointment->exec_id = NULL;
        }



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

        if($request->has('btn_submit_appointment')){
            $appointment->confirm = 1;
            $appointment->cancelled = 0;
            $appointment->not_interested = 0;
            $appointment->in_progress = 0;

        }

        if($request->has('btn_in_progress')){
            $appointment->confirm = 0;
            $appointment->cancelled = 0;
            $appointment->not_interested = 0;
            $appointment->in_progress = 1;

        }

        if($request->has('btn_not_interested')){
            $appointment->confirm = 0;
            $appointment->cancelled = 0;
            $appointment->not_interested = 1;
            $appointment->in_progress = 0;

        }

        if($request->has('btn_cancelled')){
            $appointment->confirm = 0;
            $appointment->cancelled = 1;
            $appointment->not_interested = 0;
            $appointment->in_progress = 0;

        }

        $appointment->call_attempts = $request->call_attempts ;
        $appointment->call_made = $request->call_made;
        $appointment->call_back = $request->call_back;
        $appointment->message_left = $request->message_left;

        $appointment->notes = $request->notes;

        $appointment->save();

        if($request->has('send_prospect_email')){
            //Send email notification to customer
            emailProspect($appointment->id);

            // //Sends email to  Brand manager and admins with notify-booking role
            emailExecAppointment($appointment->id);

        }

        return redirect()->route('admin.appointment.prospect', [$appointment->event_id, $appointment->dealership_id])
                        ->with('success', 'Appointment have been successfully updated');



    }

    //Set's the appointment has arrived
    public function receptionLogArrived(Request $request) {

        $appointment                    =   Appointment::find($request->appointment_id);
        $appointment->arrived           =   1;
        $appointment->cancelled         =   0;
        $appointment->confirm           =   1;
        $appointment->save();

    }

    //Set's the appointment has Not
    public function receptionNoShow(Request $request) {

        $appointment                    =   Appointment::find($request->appointment_id);
        $appointment->arrived           =   0;
        $appointment->no_show           =   1;
        $appointment->cancelled         =   0;
        $appointment->confirm           =   1;
        $appointment->save();


    }

    //Set's the appointment has cancelled
    public function receptionLogCancelled(Request $request) {

        //return response()->json($request->appointment_id);

        $appointment = Appointment::find($request->appointment_id);
        $appointment->cancelled = 2;
        $appointment->arrived = 0;
        $appointment->confirm = 0;
        $appointment->save();


    }

    //Returns Event based on dealership ID
    public function event ($dealership_id) {

        $dealership = Dealership::find($dealership_id);

        $event = Event::join('dealership_event', 'dealership_event.event_id', 'events.id')
                    ->select('events.*')
                    ->where('dealership_event.dealership_id', $dealership->id)
                    ->where('events.active', 1)
                    ->first();
        return $event;

    }

    //Returns todays date
    public function todayDate(){

        $now    = CarbonImmutable::now()->locale('en_UK');

        return  Carbon::parse($now)->format('Y-m-d');
    }

    //#############################################
    //SALES
    //#############################################

    //Create a Sale
    public function createSale($appointment_id){

        $appointment = Appointment::find($appointment_id);
        $prospect = Book::find($appointment->book_id);
        $exec = Exec::find($appointment->exec_id);
        $dealership = Dealership::find($appointment->dealership_id);
        $event = Event::find($appointment->event_id);

        $execs = Exec::where('dealership_code', $dealership->code)
                        ->get();


        return view('admin.appointments.create-sale')
                    ->with('exec', $exec)
                    ->with('execs', $execs)
                    ->with('event', $event)
                    ->with('dealership', $dealership)
                    ->with('prospect', $prospect)
                    ->with('appointment', $appointment);

    }

    //Store a Sale
    public function storeSale(Request $request){

        $sale = new Sale;

        $appointment = Appointment::find($request->appointment_id);
        $appointment->sale = 1;
        $appointment->confirm = 0;
        $appointment->completed = 1;
        $appointment->save();


        $sale->dealership_id = $request->dealership_id;
        $sale->appointment_id = $request->appointment_id;
        $sale->event_id = $request->event_id;
        $sale->book_id = $request->book_id;
        $sale->exec_id = $request->exec_id;
        $sale->order_number = $request->order_number;
        $sale->from_appointment = $request->from_appointment;
        $sale->sale_type = $request->sale_type;
        $sale->sold_vehicle = $request->sold_vehicle;
        $sale->finance = $request->finance;
        $sale->paint_protection = $request->paint_protection;
        $sale->smart = $request->smart;
        $sale->gap = $request->gap;
        $sale->warranty = $request->warranty;
        $sale->alloy = $request->alloy;
        $sale->tyre = $request->tyre;
        $sale->registration = $request->registration;
        $sale->part_exchange = $request->part_exchange;


        $sale->save();
        return redirect()->route('admin.appointment.show', $sale->dealership_id)->with('success', 'Sale has been stored!');


    }

    public function deleteAppointment(Request $request){

        $appointment = Appointment::find($request->id);

        $appointment->delete();

        return redirect()->back()->with('success', 'Appointment have been deleted!');

    }


}
