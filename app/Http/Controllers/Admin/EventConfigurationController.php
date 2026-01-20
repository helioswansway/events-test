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
use App\Book;

use Image;
use DB;


use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\Carbonite;
use Carbon\CarbonImmutable;
//use App\Http\Controllers\DateTime;

use DateTime;
use DateInterval;

class EventConfigurationController extends Controller
{
    //

    public function configureDates($event_id, $dealership_id){

        $event = Event::find($event_id);
        $all_dealerships = Dealership::orderBy('name', 'ASC')->get();

        $dates = EventDate::where('dealership_id', $dealership_id)->where('event_id', $event_id)->get();//orderBy('date', 'ASC')->

        $dates = $dates->sortBy(function($a){
            return DateTime::createFromFormat('Y-m-d',$a['date']);
        });
       // return $dates;
        $execs = new Exec;
        $dealership = new Dealership;
        //dd($dates);
         return view('admin.events.configure-dates')
            ->with('event', $event)
            ->with('dates', $dates)
            ->with('execs', $execs)
            ->with('dealership', $dealership)
            ->with('all_dealerships', $all_dealerships);

    }


    public function configureTimes($event_id, $dealership_id, $date_id){

        $event = Event::find($event_id);
        $all_dealerships = Dealership::orderBy('name', 'ASC')->get();
        $dates = EventDate::where('dealership_id', $dealership_id)->where('event_id', $event_id)->get();//orderBy('date', 'ASC')->

        $dates = $dates->sortBy(function($a){
            return DateTime::createFromFormat('Y-m-d',$a['date']);
        });

        $times = EventTime::where('event_date_id', $date_id)->orderBy('time', 'ASC')->get();
        $execs = new Exec;
        $dealership = new Dealership;

         return view('admin.events.configure-times')
            ->with('event', $event)
            ->with('dates', $dates)
            ->with('date', $date_id)
            ->with('times', $times)
            ->with('execs', $execs)
            ->with('dealership', $dealership)
            ->with('all_dealerships', $all_dealerships);

    }

    //Gets the last date on the database and inserts a plus day
    public function plusDate(Request $request){

        $event_date = EventDate::where('dealership_id', $request->dealership_id)
                                    ->where('event_id', $request->event_id)
                                    ->orderBy('date', 'DESC')->first();

        $date = Carbon::createFromFormat('Y-m-d', $event_date->date)->addDay()->format('Y-m-d');
        $new_date = new Eventdate;
        $new_date->dealership_id = $request->dealership_id;
        $new_date->event_id = $request->event_id;
        $new_date->date = $date;

        $new_date->save();

    }

    //Gets the Fist date on the database and inserts a plus day
    public function minusDate(Request $request){

        $event_date = EventDate::where('dealership_id', $request->dealership_id)
                                    ->where('event_id', $request->event_id)
                                    ->orderBy('date', 'ASC')->first();

        $date = Carbon::createFromFormat('Y-m-d', $event_date->date)->subDay()->format('Y-m-d');

        $new_date = new Eventdate;
        $new_date->dealership_id = $request->dealership_id;
        $new_date->event_id = $request->event_id;
        $new_date->date = $date;

        $new_date->save();

    }

    public function addDate(Request $request){

        $event_dates = EventDate::where('dealership_id', $request->dealership_id)->where('event_id', $request->event_id)->get();
        $event_date = EventDate::where('dealership_id', $request->dealership_id)->where('event_id', $request->event_id)->delete();

        foreach($event_dates as $dates){
            $event_time = EventTime::where('dealership_id', $request->dealership_id)
                            ->where('event_date_id', $date->id)->delete();
        }



        $from = str_replace('/', '-', $request->from);
        $to = str_replace('/', '-', $request->to);
        $period = CarbonPeriod::between($from, $to);

       // $dates = $period->toArray();

         foreach ($period as $d) {
            $dates[] = $d->format('Y/m/d');
            $event_date = new EventDate([
                'date' => $d->format('Y-m-d'),
                'event_id' => $request->event_id,
                'dealership_id' => $request->dealership_id
            ]);
            $event_date->save();
         }

    }

    //Creates the time slots
    public function addTime(Request $request){

        //Find the dealership code
        $dealership = Dealership::find($request->dealership_id);

        //Get the Exces from the current Dealership
        $execs = Exec::where('dealership_code', $dealership->code)->get();
        //dd($execs);
        //return  $execs;

        //Deletes Time Slots based on Event Date selected
        $event_date_id = EventTime::where('event_date_id', $request->event_date_id)->delete();

        //gets the open, interval and close times so it can calculate
        $open = $request->openTime;
        $interval = $request->interval;
        $close = $request->closeTime;

        //Set days as an Array
        $days = array(
                        'Day'  =>
                            array(
                                'open' => $open,
                                'close' => $close
                                )
                    );

        // Saves the first Slot
        $time = new DateTime($open); //Sets a new Open Time
        $event_time = new EventTime; //Sets a new Event Time
        $event_time->time = $time->format('H:i'); //Formats the Date time to (Hour:minutes)
        $event_time->event_date_id = $request->event_date_id;
        $event_time->dealership_id = $request->dealership_id;

        $event_time->save();
        foreach ($execs as $exec) {
            $exec = Exec::find($exec->id);
            $exec->timeSlots()->attach($event_time->id);
        }

        //END

        // Continues to save from the first time slot
            foreach ($days as &$day) {
                $time = new DateTime($day['open']);
                $close = new DateTime($day['close']);
                while ($time < $close) {
                    $day[] = $time->format('H:i');
                    $time->modify('+'.$interval.' minutes');

                    $event_time = new EventTime([
                        'time' => $day[] = $time->format('H:i'),
                        'event_date_id' => $request->event_date_id,
                        'dealership_id' => $request->dealership_id
                    ]);
                    $event_time->save();

                    foreach ($execs as $exec) {
                        $exec = Exec::find($exec->id);
                        $exec->timeSlots()->attach($event_time->id);
                    }
                }
            }
        //END
    }

    //gets Execs to the time slots
    public function fetchExec(Request $request){

        // Get Execs that belongs to the Event dealership
        // Execs are saved with a dealership_code

        $time_id = $request->time_slot;
        $dealership_id = $request->dealership_id;

        $dealership = Dealership::find($dealership_id);

        $execs = Exec::whereDoesntHave('timeSlots', function ($query) use($time_id) {
                            $query->where('event_time_id', $time_id);
                        })
                        ->where('execs.dealership_code',   $dealership->code)
                        ->get();

        return response()->json($execs);

    }

    //Adds Execs to the time slots
    public function addExecToTimeSlot(Request $request){

        // Get Execs that belongs to the Event dealership
        // Execs are saved with a dealership_code
        //$execs = "Exec Saved";

       $execs = $request->execs;

        foreach ($execs as $exec) {
            //return response()->json($request->execs);
            $exec = Exec::find($exec);
            $exec->timeSlots()->attach($request->time_slot);
        }


    }

    //Deletes a single exec from the time slot
    public function deleteExecFromTimeSlot($exec_id)
    {

        $exec = DB::table('event_time_exec')->where('id', $exec_id)->delete();

        return redirect()->back()->with('success', 'Exec has been successfully deleted');

    }

    //Deletes a single exec from the time slot
    public function deleteExecFromEvent($exec_id)
    {


        //$exec                       =   DB::table('event_time_exec')->where('exec_id', $exec_id)->first();

        $delete_exec = Exec::find($exec_id);
        $execs = Exec::where('dealership_code', $delete_exec->dealership_code)->whereNotIn('id', [$delete_exec->id])->get();
        $dealership = Dealership::where('code', $delete_exec->dealership_code)->first();
        $prospects = DB::table('book_exec')
                    ->where('exec_id', $delete_exec->id)
                    ->orderBy('id', 'ASC')->get();

        if(count($prospects) > 0){
            $prosp_count = count($prospects);
            $exec_count = count($execs);
            $chunk = round(($prosp_count / $exec_count));

            $collection = collect($prospects);
            $books = $collection->chunk($chunk);

            //return $delete_exec;

            foreach ($execs as $i => $exec) {
                foreach ($books[$i] as $book) {
                    DB::table('book_exec')->insert(
                        array(
                            'book_id'   =>   $book->id,
                            'exec_id'   =>   $exec->id
                        )
                    );
                }
            }

        }

         DB::table('book_exec')->where('exec_id', $exec_id)->delete();
         DB::table('event_time_exec')->where('exec_id', $exec_id)->delete();

         return redirect()->back()->with('success', 'Exec been removed from Event and Prospects distributed equally through the remaining Execs.');


    }



    //Splits Customers through execs that are
    public function splitCustomers(Request $request){

        //Gets Selected Event
        $event = Event::find($request->event_id);

        //Gets Selected Dealership
        $dealership = Dealership::find($request->dealership_id);

        //Gets all execs that belong to the dealership->code
        $execIds = Exec::select('execs.id')
                    ->join('event_time_exec', 'event_time_exec.exec_id', 'execs.id')
                    ->groupBY('execs.id')
                    ->orderBy('event_time_exec.exec_id', 'ASC')
                    ->where('execs.dealership_code', $dealership->code)->get();

        $book_Ids = Exec::select('execs.id')
                    ->join('book_exec', 'book_exec.exec_id', "=", 'execs.id')
                    ->groupBY('execs.id')
                    ->orderBy('book_exec.exec_id', 'ASC')
                    ->whereNotIn('execs.id', $execIds)
                    ->where('execs.dealership_code', $dealership->code)->get();

        //Deletes all the execs from book_exec where exec_id has $book_ids
        $delete_book_execs = DB::table('book_exec')
                                ->select('book_exec.exec_id')
                                ->whereIn('book_exec.exec_id', $book_Ids)->delete();


        //Execs that are currently selected in the time slots
        $execs = Exec::has('timeSlots')
                        ->where('execs.dealership_code',   $dealership->code)
                        ->get();

        //Gets all Prospects that doesn't belong to Renewals
        $renewal = 'RENEW';
        $prospects = Book::where('dealership_code', $dealership->code)
                            ->where('event_id', $event->id)
                            ->Where('books.customer_number', 'NOT LIKE', "%{$renewal}%")
                            ->orderBy('id', 'ASC')->get();

        foreach($execs as $exec){
            DB::table('book_exec')->where('exec_id', $exec->id)->delete();
        }

        if(count($prospects) > 0){
            $prosp_count = count($prospects);
            $exec_count = count($execs);
            $chunk = round(($prosp_count / $exec_count));

            $collection = collect($prospects);
            $books = $collection->chunk($chunk);
            //return          $chunks->toArray();

            foreach ($execs as $i => $exec) {
                foreach ($books[$i] as $book) {
                    DB::table('book_exec')->insert(
                        array(
                            'book_id'   =>   $book->id,
                            'exec_id'   =>   $exec->id
                        )
                    );
                }
            }

        }

    }

     //Deletes a single date and everything attached to it
    public function deleteDate(Request $request){

        $d = DB::table('event_dates')->where('id', $request->date_id)->first();
        $times = DB::table('event_times')->where('event_date_id', $request->date_id)->get();

        $date = DB::table('event_dates')->where('id', $request->date_id)->delete();

        foreach($times as $time){
            $time_exec = DB::table('event_time_exec')->where('event_time_id', $time->id)->delete();
        }

        DB::table('event_times')->where('event_date_id', $request->date_id)->delete();

    }

    //Deletes al times slots and execs attached to it
    public function resetTimeSlots(Request $request){

        $d = DB::table('event_dates')->where('id', $request->date_id)->first();
        $times = DB::table('event_times')->where('event_date_id', $request->date_id)->get();

        //Deletes times assigned to the exec
        foreach($times as $time){
            $time_exec = DB::table('event_time_exec')->where('event_time_id', $time->id)->delete();
        }

        //Gets the Dealership and Exec Assigned to the Event Date
        $dealership = Dealership::find($d->dealership_id);
        $execs = Exec::where('dealership_code', $dealership->code)->get();
        //Deletes all the books/prospects assing to the execs
        foreach($execs as $exec){
            DB::table('book_exec')->where('exec_id', $exec->id)->delete();
        }

        //Deletes all times assigned to the event based on the selected date
        DB::table('event_times')->where('event_date_id', $request->date_id)->delete();

    }

}
