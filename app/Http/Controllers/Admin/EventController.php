<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Event;
use App\Models\EventDate;
use App\Models\Dealership;
use App\Models\Appointment;
use App\Models\ArchiveAppointment;
//use App\Models\DealershipAppointment;

use App\Book;

use Image;
use DB;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\Carbonite;
use Carbon\CarbonImmutable;
use App\Http\Controllers\DateTime;

use Excel;

use App\Exports\AppointmentExport;
use App\Exports\AppointmentsArchivedExport;
use App\Exports\SalesExport;
use App\Exports\ProspectExport;
use App\Exports\ArchivedAppointmentsExport;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $events = Event::orderBy('active', 'DESC')
                        ->orderBy('created_at', 'DESC')->paginate(10);


        return view('admin.events.index')
            ->with('events', $events);

    }

    public function manage()
    {

        $events = Event::where('active', 1)->orderBy('name', 'ASC')->get();

        //dd($events);
        return view('admin.events.manage')
            ->with('events', $events);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $all_dealerships    =   Dealership::orderBy('brand_id', 'asc')->orderBy('name', 'ASC')->get();

        return view('admin.events.create')
                ->with('all_dealerships', $all_dealerships);


    }

    //Show form for creating Date, Time Slots and Admin towards the event selected
    public function createConfiguration($id)
    {
        //Gets the event ID
        $event          = Event::find($id);

        //Returns only Dealerships that belong to events
        $dealerships    = Dealership::whereHas('events', function($query) use($id) {
                                $query->where('events.id', $id);
                            })->get();

        /**/
        $admins = DB::table('admin_role')
                ->join('roles', 'roles.id', '=', 'admin_role.role_id')
                ->join('admins', 'admins.id', '=', 'admin_role.admin_id')
                ->select('admins.*')
                ->where('roles.name',  'appointments')
                ->get();


        return view('admin.events.configure')
                ->with('event', $event)
                ->with('admins', $admins)
                ->with('dealerships', $dealerships);

    }

    //Stores Date, Time Slots and Admin into the selected event
    public function storeConfiguration(Request $request)
    {

        $event = new Event;

        //Gets and formats dates $from and $to
        $from   =  Carbon::createFromFormat('d/m/Y', $request->input('from'));
        $to     =  Carbon::createFromFormat('d/m/Y', $request->input('to'));
        $days = array(); // Creates an array
        while ($from->lte($to)){
            $days[] = $from->toDateString();
            $from->addDay();
        }

        echo "<hr>";
        foreach($request->input('dealership_id') as $dealership){
            echo "<br> Event: " . $request->input('event') ."<br>";
            echo "Dealership: " . $dealership ."<br>";
            //Loops trough the days
            echo "Date <br>";
            foreach($days as $day){
                $dt = Carbon::parse($day);
                echo $dealership ." - ".   $request->input('event') . " - " . $dt->format('d/m/Y') . "<br>";
            }
        }


        exit;

        return $request->all();


        //Handles Form validation
        $this->validate($request, [
            //'name'          => 'required',
            'dealership_id' => 'required',

        ],
        [
            'dealership_id.required' => 'You need to select a minimum of (1) Dealership'
        ]);

        return "Hello";

        $event->name = $request->input('name');
        $event->active = $request->input('active');
        $event->save();
        $event->dealerships()->sync(request('dealership_id'));

        return redirect()->route('event.time.slots', ['id' => $event->id])->with('succes', 'Add dates and Time Slots');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $event = new Event;
        //Handles Form validation
        $this->validate($request, [
            'name'          => 'required',
            'dealership_id' => 'required',
        ],
        [
            'dealership_id.required' => 'You need to select minimum (1) Dealership'
        ]);

        if($request->hasfile('filename')){

            //prev_filename Stored
            $image = $request->file('filename');
            $filename = rand() . '.' .$image->getClientOriginalExtension();
            $location = public_path("assets/images/public/general/" . $filename);
            $img = Image::make($image);
            $img->fit(1800, 422)->save($location);

            $event->filename         = $filename;

        }else{
            $event->filename         = $event->filename;

        }

        $event->name = $request->input('name');
        $event->friendly_name = $request->input('name');
        $event->active = $request->input('active');
        $event->inc_exec = $request->input('inc_exec');
        $event->show_vehicles = $request->input('show_vehicles');
        $event->show_part_exchange = $request->input('show_part_exchange');
        $event->send_confirmation_email = $request->input('send_confirmation_email');

        $event->save();
        $event->dealerships()->sync(request('dealership_id'));

        return redirect()->route('event.index')->with('succes', $event->name . ' has been created!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        $all_dealerships = Dealership::orderBy('brand_id', 'asc')->orderBy('name', 'ASC')->get();

        return view('admin.events.edit')
            ->with('all_dealerships', $all_dealerships)
            ->with('event', $event);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
            //return $request->all();
            $event = Event::find($id);
            //Handles Form validation
            $this->validate($request, [
                'name'          => 'required',
            ]);

            if($request->hasfile('filename')){
                //return asset('/assets/images/properties/'.$property->default_filename);
                if($event->filename != ""){
                    if(file_exists(public_path() . '/assets/images/public/general/'.$event->filename)){
                        unlink('assets/images/public/general/'.$event->filename);
                    }
                }

                    $image = $request->file('filename');
                    $filename = rand() . '.' .$image->getClientOriginalExtension();
                    $location = public_path("assets/images/public/general/" . $filename);

                    //$location = public_path("assets/images/properties/" . $filename);
                    $img = Image::make($image);
                    $img->fit(1800, 422)->save($location);
                    //$path = $request->file('filename')->move('assets/images/admin/general', $filenameToStore);

                    $event->filename          = $filename;

            }else{

                $event->filename          = $event->filename  ;
            }


            $event->name            =   $request->input('name');
            $event->friendly_name   =   $request->input('name');

            $event->active          =   $request->input('active');
            if($request->input('active') == 1) {
                $event->in_progress          =   0;
            }else{
                $event->in_progress          =   1;
            }

            $event->finished        =   $request->input('finished');
            if($request->input('finished') == 1) {
                $event->in_progress          =   0;
                $event->active          =   0;
            }

            $event->test_mode = $request->input('test_mode');
            $event->inc_exec = $request->input('inc_exec');
            $event->show_vehicles = $request->input('show_vehicles');
            $event->show_part_exchange = $request->input('show_part_exchange');
            $event->send_confirmation_email = $request->input('send_confirmation_email');
            $event->save();
            $detached  = $event->dealerships()->sync(request('dealership_id'));
           //dd($ids);
            foreach($detached['detached'] as $dealership_id){
                $dates     = EventDate::where('dealership_id', $dealership_id)->where('event_id', $id)->get();

                foreach($dates as $date){
                    $times  =   DB::table('event_times')->where('event_date_id', $date->id)->get();

                    foreach($times as $time){
                        $time_exec = DB::table('event_time_exec')->where('event_time_id', $time->id)->delete();
                    }

                    DB::table('event_times')->where('event_date_id', $date->id)->delete();
                }

                EventDate::where('dealership_id', $dealership_id)->where('event_id', $id)->delete();
            }

            return redirect()->route('event.index')->with('success', '['. $event->name . '] has been successfully updated.');
    }


    //Deletes The event
    public function delete($id)
    {
        $event = Event::where('id', $id)->first();

        $date = Carbon::now()->format('d-M-Y');
        $file_path = str_replace(" ", "-", strtolower($event->name)).'-'.'appointments-archived-'.$date.'.csv';
        Excel::store(new AppointmentsArchivedExport($event->id), $file_path, 'archive');


        $first_date = EventDate::where('event_id', $event->id)->orderBy('date', 'ASC')->first();
        $last_date = EventDate::where('event_id', $event->id)->orderBy('date', 'DESC')->first();
        $appointments = Appointment::where('event_id', $event->id)->get();

        $archive = new ArchiveAppointment;

        $archive->event_name = $event->name;
        $archive->file_path = $file_path;

        if($first_date){
            $archive->event_dates = str_replace("-", "/", $first_date->date) . " ". " - " . " ". str_replace("-", "/",$last_date->date);
        }

        $archive->count = $appointments->count();
        $archive->save();

        $this->emptyEvent($event->id);

        return $this->redirectTo("delete", $event->name);

    }


    //Empties the event
    public function emptyEvent($id)
    {


        //Gets the event
        $event = Event::where('id', $id)->first();

        //Deletes the filename attached to the selected Event
        if($event->filename != ""){
            if(file_exists(public_path() . '/assets/images/public/general/'.$event->filename)){
                unlink('assets/images/public/general/'.$event->filename);
            }
        }

        //Gets all the prospects/Books based on $event-id
        $prospectIds = Book::select('books.id')->where('event_id', $event->id)->get();

        //Deletes all prospects assign to the dealerships execs $id
        DB::table('book_exec')->whereIn('book_id', $prospectIds)->delete();

        //Gets event dates based on $event->id
        $dateIDs = DB::table('event_dates')->where('event_id', $event->id)->get();

        //Get event times
        foreach($dateIDs as $date){
            $event_timeIDs = DB::table('event_times')->select('event_times.id')->where('event_date_id',$date->id)->get();

            if($event_timeIDs){
                //Deletes execs in event_time_exec
                foreach($event_timeIDs as $time){
                    $exec_times = DB::table('event_time_exec')->where('event_time_id',$time->id)->delete();
                }
            }
        }


        //Deletes event times
        foreach($dateIDs as $date){
            $exec_times = DB::table('event_times')->where('event_date_id',$date->id)->delete();
        }

        //Deletes all appointments based on $event->id
        $appointments = Appointment::where('event_id', $event->id)->delete();

        //Deletes all prospects
        $prospects = Book::where('event_id', $id)->delete();

        //Deletes event dates based on $event->id
        DB::table('event_dates')->where('event_id', $event->id)->delete();

        //Deletes/Detaches all delearships
        $event->dealerships()->detach();

        //Deletes the event
        $event->delete();

    }



    public function redirectTo($send, $name)
    {
        if($send == "delete"){
           return redirect()->route('event.index')->with('success', '['. $name . '] have been successfully deleted');
        }

        if($send == "archive"){
            return redirect()->route('event.index')->with('success', '['. $name . '] have been successfully archived');
         }

    }


    public function deleteEventDealership($event_id, $dealership_id)
    {

        $event = DB::table('dealership_event')->where('event_id', $event_id)->where('dealership_id', $dealership_id)->delete();
        return redirect('dashboard/events/configure/'.$event_id)->with('success', 'Dealership/s have been successfully deleted');
    }

}
