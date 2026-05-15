<?php
use App\Models\SiteConfiguration;
use App\Models\Dealership;
use App\Models\Appointment;
use App\Models\Brand;
use App\Models\Event;
use App\Models\EventTime;
use App\Models\Sale;
use App\Models\SaleType;
use App\Models\Competition;
use App\Models\JobTitle;

use App\Book;
use App\Exec;
use App\Leaderboard;
use App\Models\PotCampaign;
use App\Models\PotList;

    function bookedSlot($slot_id, $date){

        /**/
        $execs          = DB::table('execs')
                            ->where('dealership_code', Auth::guard('book')->user()->dealership_code)
                            ->get();

        $appointments   = DB::table('execs')
                            ->join('appointments', 'appointments.exec_id', 'execs.id')
                            ->where('execs.dealership_code', Auth::guard('book')->user()->dealership_code)
                            ->where('appointments.date', $date)
                            ->where('appointments.event_time_id', $slot_id ) //1379
                            ->get();


        //dd($appointments);

        if($execs->count() == $appointments->count()){
            return true; //All booked
        }else{
            return false; //time slots available
        }


    }

    function execsCount(){
        /**/
        $execs          = DB::table('execs')
                            ->where('dealership_code', Auth::guard('book')->user()->dealership_code)
                            ->get();

        $appointments   = DB::table('execs')
                            ->join('appointments', 'appointments.exec_id', 'execs.id')
                            ->where('execs.dealership_code', Auth::guard('book')->user()->dealership_code)
                            ->where('appointments.date', $date)
                            ->where('appointments.event_time_id', 1379)
                            ->get();

        //dd($appointments);

        if($execs->count() == $appointments->count()){
            return true; //All booked
        }else{
            return false; //time slots available
        }
    }

    //Returns the User Time Slot
    function userSlot($slot_id, $date){
        $slot =  DB::table('appointments')
                    ->join('event_times', 'event_times.id', '=', 'appointments.event_time_id')
                    ->where('appointments.event_time_id', $slot_id)
                    ->where('appointments.date', $date)
                    ->where('appointments.book_id', auth('book')->user()->id)
                    ->first();

        if(!empty($slot)){
            return $slot->event_time_id;
        }

    }

    //Returns the User Time Slot
    function execSlot($slot_id, $date){
        $slot =  DB::table('appointments')
                    ->join('event_times', 'event_times.id', '=', 'appointments.event_time_id')
                    ->where('appointments.event_time_id', $slot_id)
                    ->where('appointments.date', $date)
                    ->where('appointments.book_id', auth('book')->user()->id)
                    ->first();

        if(!empty($slot)){
            return $slot->event_time_id;
        }

    }

    //Return Appointment ID
    function appointmentId($event_id, $date){
        $appointment =  DB::table('appointments')
                    ->where('event_id', $event_id)
                    ->where('date', $date)
                    ->where('book_id', auth('book')->user()->id)
                    ->first()->id;

        if(!empty($appointment)){
            return $appointment;
        }

    }

    //Check if Prospect is booked
    function prospectBooked($id){
        $appointment =  DB::table('appointments')
                            ->where('book_id', $id)
                            ->first();
        return $appointment;
    }

    //Return Appointment ID
    function appointmentValue($time_id, $value){
        $appointment =  DB::table('appointments')
                    ->where('event_time_id', $time_id)
                    ->first();

        if(!empty($appointment)){
            return $appointment->$value;
        }

    }

    //Return Appointment ID
    function appointmentTimeId($time_id){
        $time_id =  DB::table('appointments')
                            ->where('event_time_id', $time_id)
                            ->first();

        if(!empty($time_id)){
            return $time_id->event_time_id;
        }

    }

    //##########################################
    //
    //##########################################

    //Checks if Slot has been taken
    function slotAppointment($slot_id){
        $appointment    =   DB::table('appointments')
                                ->select('appointments.*')
                                ->where('event_time_id', $slot_id)
                                ->where('exec_id', auth('exec')->user()->id)
                                ->first();

        if(isset($appointment)){
            return $appointment;
        }else{

        }

    }

    //Checks if exec is booked on a time slot
    function execAppointment($slot_id, $exec_id){

        $appointment = DB::table('appointments')
                            ->select('appointments.*')
                            ->where('event_time_id', $slot_id)
                            ->where('exec_id', $exec_id)
                            ->where('confirm', "=", 1)
                            ->first();
        return $appointment;

    }

    //Checks if Customer has made an appointment
    function customerAppointment($book_id, $event_id) {

        $customer = DB::table('appointments')
                        ->where('book_id', $book_id)
                        ->where('event_id', $event_id)
                        ->where('confirm', "=", 1)
                        ->where('event_time_id', "!=", NULL)
                        ->first();

        return $customer;

    }

       //Checks if Customer has made an appointment
    function customerExec($book_id) {

        $exec = DB::table('book_exec')
                        ->select('execs.*')
                        ->join('execs', 'execs.id', 'book_exec.exec_id')
                        ->where('book_exec.book_id', $book_id)
                        ->first();

        return $exec;

    }

    //returns the ammount of bookings based on date
    function numbAppointment($date){
        $count    =   DB::table('appointments')
                                ->where('date', $date)
                                ->where('confirm', "=", 1)
                                ->where('event_time_id', "!=", NULL)
                                ->where('exec_id', auth('exec')->user()->id)
                                ->get();

        return   count($count);
    }

    //returns the ammount of bookings based on date
    function totalAppointment($event_id){
        $count    =   DB::table('appointments')
                                ->where('event_id', $event_id)
                                ->where('exec_id', auth('exec')->user()->id)
                                ->get();

        return count($count);
    }

    //returns the event brand logo
    function brandLogo(){
        $cust = auth('book')->user();
        $dealership = Dealership::where('code', $cust->dealership_code)->first();
        $brand = Brand::where('id', $dealership->brand_id)->first();

        return $brand->filename;
    }

    //returns the brand logo
    function brandCampaignLogo($id){
        $campaign = PotCampaign::find($id);
        return $campaign;
        $pot_list = PotList::where('pot_campaign_id', $campaign->id)->first();

        if(!$pot_list){
            $dealership = Dealership::where('code', 'SWA')->first();
            $brand = Brand::where('id', $dealership->brand_id)->first();
        }else{
            $dealership = Dealership::where('id', $pot_list->dealership_id)->first();
            $brand = Brand::where('id', $dealership->brand_id)->first();
        }

        return $brand->filename;
    }

    //returns the ammount of bookings based on date
    function eventAppointment(){

        $exec = auth('exec')->user();
        $dealership = Dealership::where('code', $exec->dealership_code)->first();

        $event = Event::join('dealership_event', 'dealership_event.event_id', '=', 'events.id')
                    ->select('events.*')
                    ->where('events.active', 1)
                    ->where('dealership_event.dealership_id', $dealership->id)->first();

        return $event;

    }

    //returns the exec
    function currentExec(){
      return $exec = auth('exec')->user();
    }

    //returns the exec Dealership
    function currentDealership(){
        $exec = auth('exec')->user();
        $dealership = Dealership::where('code', $exec->dealership_code)->first();

        return $dealership;
    }

    //Returns the number of execs booked in the time slot
    function numberOfExecs($time_id){
        $count    =   DB::table('appointments')
                                ->where('event_time_id', $time_id)
                                ->where('confirm', "=", 1)
                                ->get();

        return count($count);

    }

    //returns the Leaderboard/User Dealership
    function dealership($leaderboard_id){
        $exec   =   Leaderboard::find($leaderboard_id);
        $dealership =   Dealership::where('code', $exec->dealership_code)->first();

        return $dealership;
    }

    //returns the Leaderboard/User Brand
    function brand($leaderboard_id){
        $exec   =   Leaderboard::find($leaderboard_id);
        $dealership =   Dealership::where('code', $exec->dealership_code)->first();
        $brand  =   Brand::find($dealership->brand_id);

        return $brand;
    }


    //returns the Sale Type
    function sale_type($sale_type_id){

        $sale_type = SaleType::find($sale_type_id);

        return $sale_type;
    }

    //returns the exec Dealership
    function dealershipByCode($code){

        $dealership = Dealership::where('code', $code)->first();
        return $dealership;
    }

    //returns the person that booked the appointment
    function bookedBy($id){

        $admin         =   DB::table('admins')
                            ->where('id', $id)->first();

        if($admin){
           return $admin->name;
        }else{
            return "NULL";
        }

    }

    //returns the person that booked the appointment
    function editedBy($id){

        $admin         =   DB::table('admins')
                            ->where('id', $id)->first();

        if($admin){
            return $admin->name;
        }else{
            return "NULL";
        }

    }

    //returns the exec Dealership
    function execSale($book_id, $event_id){

        $sale         =   Sale::where('book_id', $book_id)->where('event_id', $event_id)->first();

        return $sale;
    }

    //returns the exec competitions
    function execCompetitions($exec_id){

        $competitions         =   Competition::select('competitions.*')
                                        ->join('competition_leaderboard', 'competition_leaderboard.competition_id', 'competitions.id')
                                        ->where('competition_leaderboard.leaderboard_id', $exec_id)->get();

        return $competitions;
    }

    function adminRole($admin_id) {
        $role       =  DB::table('admins')
                            ->select('roles.*')
                            ->join('admin_role', 'admin_role.admin_id', 'admins.id')
                            ->join('roles', 'roles.id', 'admin_role.role_id')
                            ->where('admins.id', $admin_id)
                            ->first();

        return $role;

    }

    function hasRole($admin_id, $role_name) {
        $role       =  DB::table('admins')
                            ->select('roles.*')
                            ->join('admin_role', 'admin_role.admin_id', 'admins.id')
                            ->join('roles', 'roles.id', 'admin_role.role_id')
                            ->where('admins.id', $admin_id)
                            ->where('roles.name', $role_name)
                            ->first();

        return $role;

    }

    function prospectsAmount($dealership_code, $event_id){

        $renewal = 'RENEW';
        $prospects = Book::select('books.*')
                            ->where('books.dealership_code', $dealership_code)
                            ->where('books.event_id', $event_id)
                            ->Where('books.customer_number', 'NOT LIKE', "%{$renewal}%")
                            ->orderBy('books.name', 'ASC')
                            ->get()->count();

        return $prospects;

    }

    function prospectsRenewalAmount($dealership_code, $event_id){

        $renewal = 'RENEW';

        $prospects = Book::select('books.*')
                            ->where('books.dealership_code', $dealership_code)
                            ->where('books.event_id', $event_id)
                            ->Where('books.customer_number', 'LIKE', "%{$renewal}%")
                            ->orderBy('books.name', 'ASC')
                            ->get()->count();

        return $prospects;

    }


    function prospectsExecAmount($dealership_code, $event_id, $exec_id){

        $prospects = Book::select('books.*')
                        ->join('book_exec', 'book_exec.book_id', 'books.id')
                        ->where('book_exec.exec_id', $exec_id)
                        ->where('books.event_id', $event_id)
                        ->where('books.dealership_code', $dealership_code)
                        ->orderBy('books.name', 'ASC')
                        ->count();

        return $prospects;

    }

    function prospectsExecCount($exec_id){

        $prospects = Book::select('books.*')
                        ->join('book_exec', 'book_exec.book_id', 'books.id')
                        ->where('book_exec.exec_id', $exec_id)
                        ->orderBy('books.name', 'ASC')
                        ->count();
        return $prospects;
    }

    function generate_password(){

        // Characters Length
        $length = 13;
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789?!><$%£)(!-^_/\|';
        $count = mb_strlen($chars);

        // Gets a 13 characters random password
        for ($i = 0, $value = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $value .= mb_substr($chars, $index, 1);
        }

        return $value;

    }




