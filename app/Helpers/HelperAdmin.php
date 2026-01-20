<?php
use App\Models\SiteConfiguration;
use App\Models\Dealership;
use App\Models\Appointment;
use App\Models\Brand;
use App\Models\Event;
use App\Models\EventTime;
use App\Models\EventDate;
use App\Models\Competition;
use App\Models\SaleLeague;
use App\Models\PotCampaign;
use App\Models\PotList;

use App\Book;
use App\Exec;
use App\Leaderboard;

    function prospectsCount($exec_id)
    {

        $count = DB::table('execs')
                    ->join('book_exec', 'book_exec.exec_id', '=', 'execs.id')
                    ->where('execs.id', $exec_id)
                    ->get();

        return   count($count);

    }

    //Prospects count archived per dealership
    function prospectsArchivedCount($dealership_code, $event_id){

        //return $date . " " . $dealership_id;
        $count    =   DB::table('books')
                                ->where('dealership_code', $dealership_code)
                                ->where('event_id', $event_id)
                                ->get();

        return   count($count);

    }

    //Confirmed appointments per dealership archived
    function appointmentsConfirmedArchivedCount($dealership_code, $event_id){

        $dealership = DB::table('dealerships')->where('code', $dealership_code)->first();
        //return $date . " " . $dealership_id;
        $count    =   DB::table('appointments')
                                ->where('dealership_id', $dealership->id)
                                ->where('event_id', $event_id)
                                ->where('confirm', 1)
                                ->get();

        return   count($count);

    }

    //Confirmed appointments per dealership archived
    function salesArchivedCount($dealership_code, $event_id){

        $dealership = DB::table('dealerships')->where('code', $dealership_code)->first();
        //return $date . " " . $dealership_id;
        $count    =   DB::table('appointments')
                                ->where('dealership_id', $dealership->id)
                                ->where('event_id', $event_id)
                                ->where('sale', 1)
                                ->get();

        return   count($count);

    }

    //returns the ammount of bookings based on date
    function adminNumbAppointment($date, $dealership_id){

        //return $date . " " . $dealership_id;

        $count    =   DB::table('appointments')
                                ->where('date', $date)
                                ->where('dealership_id', $dealership_id)
                                ->where('confirm', "=", 1)
                                //->whereNotNull('exec_id')
                                ->where('event_time_id', "!=", NULL)
                                ->get();

        return   count($count);

    }

    //returns the ammount of bookings per Dealership
    function dealershipNumbInProgress($dealership_id, $event_id){

        //return $date . " " . $dealership_id;

        $count    =   DB::table('appointments')
                                ->where('dealership_id', $dealership_id)
                                ->where('event_id', $event_id)
                                ->where('in_progress', 1)
                                ->get();

        return   count($count);

    }

    //returns the ammount of bookings per Dealership
    function dealershipNumbAppointment($dealership_id, $event_id){

        //return $date . " " . $dealership_id;
        $count    =   DB::table('appointments')
                                ->where('dealership_id', $dealership_id)
                                ->where('event_id', $event_id)
                                //->whereNotNull('exec_id')
                                ->where('confirm', "=", 1)
                                ->get();

        return   count($count);

    }

    //returns the ammount of bookings per Dealership
    function dealershipNumbNotInterested($dealership_id, $event_id){

        //return $date . " " . $dealership_id;

        $count    =   DB::table('appointments')
                                ->where('dealership_id', $dealership_id)
                                ->where('not_interested', "=", 1)
                                ->where('event_id', $event_id)
                                // ->where('event_time_id', "!=", NULL)
                                ->get();

        return   count($count);

    }

    //returns the ammount of bookings per Dealership
    function dealershipNumbSales($dealership_id, $event_id){

        //return $date . " " . $dealership_id;

        $count    =   DB::table('sales')
                                ->where('dealership_id', $dealership_id)
                                ->where('event_id', $event_id)
                                //->where('confirm', "=", 1)
                                // ->where('event_time_id', "!=", NULL)
                                ->get();

        return   count($count);

    }

    //returns the ammount of bookings per Dealership
    function eventNumbAppointment($event_id){

        //return $date . " " . $dealership_id;

        $count    =   DB::table('appointments')
                                ->where('event_id', $event_id)
                                ->where('confirm', "=", 1)
                                ->get();

        return   count($count);

    }

    //returns the ammount of bookings per Dealership
    function eventNumbInProgress ($event_id) {

        //return $date . " " . $dealership_id;

        $count    =   DB::table('appointments')
                                ->where('event_id', $event_id)
                                ->where('in_progress', 1)
                                ->get();

        return   count($count);

    }

    //returns the ammount hot Leads
    function eventNumbHotLeads($event_id){

        //return $date . " " . $dealership_id;

        $count = DB::table('appointments')
                        ->where('event_id', $event_id)
                        ->where('confirm', 0)
                        ->whereNull('booked_by')
                        ->whereNull('edited_by')
                        ->get();

        return   count($count);

    }

    //returns the ammount of bookings per Dealership
    function eventNumbNotInterested($event_id){

        //return $date . " " . $dealership_id;

        $count    =   DB::table('appointments')
                                ->where('event_id', $event_id)
                                ->where('not_interested', 1)
                                ->get();

        return   count($count);

    }

    //returns the ammount of bookings per Dealership
    function eventNumbSales($event_id){

        //return $date . " " . $dealership_id;

        $count    =   DB::table('sales')
                                ->where('event_id', $event_id)
                                //->where('confirm', "=", $confirm)
                                ->get();

        return   count($count);

    }

    //returns the ammount of bookings per Dealership
    function salesNumb($dealership_id, $event_id){

        //return $date . " " . $dealership_id;

        $count    =   DB::table('sales')
                                ->where('dealership_id', $dealership_id)
                                ->where('event_id', "=", $event_id)
                                ->get();

        return   count($count);

    }

    //returns the ammount of bookings per Dealership that's in Progress
    function inProgressNumb($dealership_id, $event_id){

        //return $date . " " . $dealership_id;

        $count    =   DB::table('appointments')
                                ->where('dealership_id', $dealership_id)
                                ->where('in_progress', 1)
                                ->where('event_id', $event_id)
                                ->get();

        return   count($count);

    }

    //returns the ammount of bookings based on date
    function hotLeadsNumb($dealership_id, $event_id){

        //return $date . " " . $dealership_id;

        $count    =   DB::table('appointments')
                                ->where('dealership_id', $dealership_id)
                                ->where('event_id', $event_id)
                                ->whereNull('booked_by')
                                ->whereNull('edited_by')
                                ->where('confirm', 0)
                                ->where('completed', 0)
                                ->where('not_interested', 0)
                                ->where('cancelled', 0)
                                ->where('in_progress', 0)
                                ->get();

        return   count($count);

    }

    //returns the ammount of bookings per Dealership
    function adminSale($appointment_id){

        $sale    =   DB::table('sales')
                        ->where('appointment_id', $appointment_id)
                        ->first();

        return $sale;

    }

    //########################################
    //Prospect Status on Admin Area
    //########################################

    //returns TRUE or FALSE if Call was made to Prospect
    function callMade($prospect_id){

        $prospect    =   DB::table('appointments')
                            ->where('book_id', $prospect_id)
                            ->where('call_made', 1)
                            ->first();

        return $prospect;

    }

    //returns TRUE or FALSE if Call was made to Prospect
    function callBack($prospect_id){

        $prospect    =   DB::table('appointments')
                            ->where('book_id', $prospect_id)
                            ->where('call_back', 1)
                            ->first();

        return $prospect;

    }

    //Checks if time slot has been taken
    function slotAdminAppointment($slot_id){
        $appointment    =   DB::table('appointments')
                                ->select('appointments.*')
                                ->where('event_time_id', $slot_id)
                                ->first();
        if(isset($appointment)){
            return $appointment;
        }else{

        }
    }

    //Checks if exec is booked on a time slot
    function execAdminAppointment($slot_id, $exec_id ){
        $appointment    =   DB::table('appointments')
                                ->select('appointments.*')
                                ->where('event_time_id', $slot_id)
                                ->where('exec_id', $exec_id)
                                ->where('confirm', "=", 1)
                                ->first();
        return $appointment;
    }

    //Checks if exec is booked on a time slot
    function execActiveAppointment($slot_id, $exec_id, $date){
        $appointment    =   DB::table('appointments')
                                ->select('appointments.*')
                                ->where('event_time_id', $slot_id)
                                ->where('exec_id', $exec_id)
                                ->where('date', $date)
                                ->first();

        return $appointment;
    }

    //Checks if exec is booked on a time slot
    function execBookedAppointment($slot_id, $exec_id, $date){
        $appointment    =   DB::table('appointments')
                                ->select('appointments.*')
                                ->where('event_time_id', $slot_id)
                                ->where('exec_id', $exec_id)
                                ->where('date', $date)
                                ->where('confirm', 1)
                                ->first();

        return $appointment;
    }

    //Checks if exec is booked on a time slot
    function prospectIsBooked($book_id) {
        $appointment    =   DB::table('appointments')
                                ->select('appointments.*')
                                ->where('book_id', $book_id)
                                ->first();
        return $appointment;
    }

    //Checks if exec is booked on a time slot
    function hasSale($book_id) {
        $sale    =   DB::table('sales')
                                ->select('sales.*')
                                ->where('book_id', $book_id)
                                ->first();
        return $sale;
    }

    //Checks if exec is booked on a time slot
    function prospectExec($book_id) {

        $exec = DB::table('book_exec')
                    ->join('execs', 'execs.id', 'book_exec.exec_id')
                    ->join('dealerships', 'dealerships.code', 'execs.dealership_code')
                    ->select('execs.*', 'dealerships.name as dealership_name')
                    ->where('book_exec.book_id', $book_id)
                    ->first();
        return $exec;

    }

    function prospectAppointmentStatus($book_id) {

        $appointment = DB::table('appointments')
                            ->select('appointments.*')
                            ->where('appointments.book_id', $book_id)
                            ->first();

        return $appointment;

    }

    function competitionSalesCount($competition_id, $leaderboard_id)
    {

        //return $competition_id . " - ". $leaderboard_id;
        $count  =   DB::table('sale_leagues')
                        ->join('competitions', 'competitions.id', 'sale_leagues.competition_id')
                        //->join('leaderboards', 'leaderboards.id', 'competition_leaderboard.leaderboard_id')
                        ->where('sale_leagues.competition_id', $competition_id)
                        ->where('sale_leagues.leaderboard_id', $leaderboard_id)
                        ->get();

        return   count($count);

    }

    function competitionLeaderboardCount($competition_id)
    {

        //return $competition_id . " - ". $leaderboard_id;
        $count  =  Leaderboard::select('leaderboards.id','leaderboards.dealership_code', 'leaderboards.job_title_id', 'leaderboards.name as exec_name', 'leaderboards.email')
                        ->join('competition_leaderboard', 'competition_leaderboard.leaderboard_id', 'leaderboards.id')
                        ->where('competition_leaderboard.competition_id', $competition_id)
                        ->groupBy('leaderboards.dealership_code')
                        ->get();

        return   count($count);

    }

    function competitionLeaderboard($competition_id, $leaderboard_id)
    {

        //return $competition_id . " - ". $leaderboard_id;
        $user  =   DB::table('competition_leaderboard')
                        ->where('competition_leaderboard.competition_id', $competition_id)
                        ->where('competition_leaderboard.leaderboard_id', $leaderboard_id)
                        ->first();

        return   $user;

    }

    function competitionImage($competition_id)
    {

        //return $competition_id . " - ". $leaderboard_id;
        $image  =   DB::table('competition_images')
                        ->join('competitions', 'competitions.id', 'competition_images.competition_id')
                        //->join('leaderboards', 'leaderboards.id', 'competition_leaderboard.leaderboard_id')
                        ->where('competition_images.competition_id', $competition_id)
                        ->first();

        return   $image;

    }

    function competition_single_sale_leagues($competition_id)
    {
        //
            $competition = Competition::find($competition_id);

            $sales  =   SaleLeague::select('sale_leagues.*', DB::raw('count(sale_leagues.leaderboard_id) as total'))
                                ->join('competition_leaderboard', 'competition_leaderboard.leaderboard_id', 'sale_leagues.leaderboard_id')
                                ->join('competitions', 'competitions.id', 'competition_leaderboard.competition_id')
                               // ->join('leaderboards', 'leaderboards.id', 'competition_leaderboard.leaderboard_id')
                                ->where('competition_leaderboard.competition_id', $competition->id)
                                ->groupBy('sale_leagues.leaderboard_id')
                                ->orderBy('total', 'DESC')
                                //->orderBy('sale_leagues.leaderboard_id', 'DESC')
                                ->get();

            $leaderboards = Leaderboard::select('leaderboards.*')
                                ->join('competition_leaderboard', 'competition_leaderboard.leaderboard_id', 'leaderboards.id')
                                ->join('competitions', 'competitions.id', 'competition_leaderboard.competition_id')
                                ->where('competition_leaderboard.competition_id', $competition->id)
                                ->get();

            // return $sales;

        return view('admin.leaderboard._show-single-competition-league')
                                            ->with('competition', $competition)
                                            ->with('leaderboards', $leaderboards);

    }

    function campaign_list($campaign_id)
    {
        //
            $campaign = PotCampaign::find($campaign_id);

            $pot_lists  =   PotList::select('pot_lists.*')
                                ->join('pot_campaigns', 'pot_campaigns.id', 'pot_lists.pot_campaign_id')
                                ->where('pot_campaigns.id', $campaign->id)
                                ->orderBy('pot_lists.called', 'DESC')
                                ->whereNotNull('phone')
                                ->get();

            return view('admin.call-pots._show-pot-list')
                            ->with('campaign', $campaign)
                            ->with('pot_lists', $pot_lists);

    }

    function brand_id($leaderboard_id) {
        $dealership = Dealership::select('dealerships.*')
                    ->join('leaderboards', 'leaderboards.dealership_code', 'dealerships.code')
                    ->where('leaderboards.id', $leaderboard_id)
                    ->first();

        return $dealership->brand_id;
    }

    function isPast($date) {
        $date = \Carbon\Carbon::parse($date);
        $todaysDate =  $date->toDateString();

        return $todaysDate; //\Carbon\Carbon::parse($date)->format('Y-M-d');
    }

    function isNow() {

        $date = \Carbon\Carbon::now();
        $todaysDate =  $date->toDateString();

        return $todaysDate; // date('d/M/Y', strtotime($date )); // ;
        //return \Carbon\Carbon::now()->format('d/M/Y');
    }

    function formatDate($date){
        return \Carbon\Carbon::parse($date)->format('d/M/Y');
    }

    function eventFirstDate($event_id = NULL ){
        $date = EventDate::where('event_id', $event_id)->orderBy('date', 'ASC')
                                ->first();

        if($date){
            return \Carbon\Carbon::parse($date->date)->format('d/M/Y');
        }

    }

    function eventLastDate($event_id = NULL){
        $date = EventDate::where('event_id', $event_id)->orderBy('date', 'DESC')
                                ->first();

        if($date){
            return \Carbon\Carbon::parse($date->date)->format('d/M/Y');
        }
    }

    function eventTime($time_id) {

        $time = EventTime::find($time_id);
        return $time;
    }
