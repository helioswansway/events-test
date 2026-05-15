<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Dealership;
use App\Models\Brand;
use App\Models\SaleType;
use App\Models\SaleLeague;
use App\Models\Competition;
use App\Models\JobTitle;

use App\Imports\LeaderboardImport;
use App\Exports\LeaderboardExport;
use App\Exports\LeagueBrandsExport;
use App\Exports\LeagueTotalExport;

use Carbon\Carbon;
use Excel;
use Validator;
use App\Leaderboard;
use DB;

class LeaderboardController extends Controller
{
    //

    public function index() {

        $competitions = Competition::select('competitions.*')
                            //->join('sale_leagues', 'sale_leagues.competition_id', 'competitions.id')

                            ->orderBy('competitions.end_date', 'DESC')
                            ->groupBy('competitions.id')
                            ->where('active', 1)
                            ->where('archived', 0)->get();

        return view('admin.leaderboard.index')
                ->with('competitions', $competitions);


    }

    //Gets Leaderboard Execs
    public function getExecs()
    {


        $execs = Leaderboard::select('id','dealership_code', 'job_title_id', 'name as exec_name', 'email')
                    // ->groupBy('dealership_code')
                    ->orderBY('name', 'ASC')->get();

        $dealership = new Dealership;
        $job_titles = JobTitle::all();
        $brands = Brand::all();
        $competitions = Competition::where('active', 1)->get();

        return view('admin.leaderboard.get-execs')
                    ->with('dealership', $dealership)
                    ->with('job_titles', $job_titles)
                    ->with('competitions', $competitions)
                    ->with('brands', $brands)
                    ->with('execs', $execs);

    }

    public function getExecsByCompetition($id){

        $execs = Leaderboard::select('leaderboards.id','leaderboards.dealership_code', 'leaderboards.job_title_id', 'leaderboards.name as exec_name', 'leaderboards.email')
                        ->join('competition_leaderboard', 'competition_leaderboard.leaderboard_id', 'leaderboards.id')
                        ->where('competition_leaderboard.competition_id', $id)
                        //->groupBy('leaderboards.dealership_code')
                        ->orderBY('leaderboards.dealership_code', 'ASC')->get();



        $competition = Competition::find($id);
        $dealership = new Dealership;
        $job_titles = JobTitle::all();
        $brands = Brand::all();
        $competitions = Competition::where('active', 1)->get();

        return view('admin.leaderboard.get-execs-by-competition')
                    ->with('dealership', $dealership)
                    ->with('brands', $brands)
                    ->with('job_titles', $job_titles)
                    ->with('competitions', $competitions)
                    ->with('competition', $competition)
                    ->with('execs', $execs);
    }

    //Fetchs execs search results data
    public function fetchData(){

            $terms = explode(' ', request('keyword'));
            $execs = Leaderboard::select('leaderboards.id','leaderboards.dealership_code', 'leaderboards.job_title_id', 'leaderboards.name as exec_name',  'leaderboards.email')
                        ->where(function($query) use ($terms){
                            foreach($terms as $term){
                                $query->where('leaderboards.dealership_code', 'LIKE', "%{$term}%")
                                        ->orWhere('leaderboards.name', 'LIKE', "%{$term}%")
                                        ->orWhere('leaderboards.email', 'LIKE', "%{$term}%");
                            }
                        })
                        ->orderBY('leaderboards.dealership_code', 'ASC')
                        ->paginate(30);


            $dealership = new Dealership;
            $job_titles = JobTitle::all();

            return view('admin.leaderboard._results')
                            ->with('execs', $execs)
                            ->with('job_titles', $job_titles)
                            ->with('dealership', $dealership)
                            ->with('success', 'We\'re Sorry but no results were found, please try again.')
                            ->render();

    }

    //Fetchs Execs by Brand
    public function fetchExecsByBrand(){


        $brand_id = request('brand_id');

        $dealerships = Dealership::select('id')->where('brand_id', $brand_id)->get();

        if($brand_id == 'all'){
            $execs = Leaderboard::select('id','dealership_code', 'job_title_id', 'name as exec_name', 'email')
                        // ->groupBy('dealership_code')
                        ->orderBY('name', 'ASC')->get();
        }else{
            $execs = Leaderboard::select('leaderboards.id','leaderboards.dealership_code', 'leaderboards.job_title_id', 'leaderboards.name as exec_name',  'leaderboards.email')
                        ->join('dealerships', 'dealerships.code', 'leaderboards.dealership_code')
                        ->whereIn('dealerships.id',$dealerships)
                        ->get();

        }





        $dealership = new Dealership;
        $job_titles = JobTitle::all();

        return view('admin.leaderboard._results-by-brand')
                        ->with('execs', $execs)
                        ->with('dealership', $dealership)
                        ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }

    //Fetchs Execs by Job Title or all
    public function fetchExecsByJobTitle(){

        $job_title_id = request('job_title_id');
        $brand_id = request('brand_id');
        $dealerships = Dealership::select('id')->where('brand_id', $brand_id)->get();

        if($brand_id == 'all'){
            $execs = Leaderboard::select('leaderboards.id','leaderboards.dealership_code', 'leaderboards.job_title_id', 'leaderboards.name as exec_name', 'leaderboards.email')
                        ->join('job_titles', 'job_titles.id', 'leaderboards.job_title_id')
                        ->where('leaderboards.job_title_id', $job_title_id)
                        ->orderBY('leaderboards.name', 'ASC')->get();

        }else{

            if($job_title_id  == 'all'){
                $execs  =   Leaderboard::select('leaderboards.id','leaderboards.dealership_code', 'leaderboards.job_title_id', 'leaderboards.name as exec_name',  'leaderboards.email')
                ->join('dealerships', 'dealerships.code', 'leaderboards.dealership_code')
                ->whereIn('dealerships.id',$dealerships)
                ->get();
            }else{
                $execs = Leaderboard::select('leaderboards.id','leaderboards.dealership_code', 'leaderboards.job_title_id', 'leaderboards.name as exec_name',  'leaderboards.email')
                            ->join('job_titles', 'job_titles.id', 'leaderboards.job_title_id')
                            ->join('dealerships', 'dealerships.code', 'leaderboards.dealership_code')
                            ->where('leaderboards.job_title_id', $job_title_id)
                            ->where(function ($query) use ($dealerships) {
                                $query->whereIn('dealerships.id',$dealerships);
                            })
                            ->orderBY('leaderboards.dealership_code', 'ASC')
                            ->get();

            }
        }


        $dealership = new Dealership;
        $job_titles = JobTitle::all();

        return view('admin.leaderboard._results-by-job-title')
                        ->with('execs', $execs)
                        //->with('competition_id', $competition_id)
                        ->with('job_title_id', $job_title_id)
                        ->with('dealership', $dealership)
                        ->with('job_titles', $job_titles)
                        ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }

    //Fetchs Execs by Job Title or all
    public function fetchExecsByCompetition(){

        $job_title_id = request('job_title_id');
        $brand_id = request('brand_id');
        $competition_id = request('competition_id');

        $dealerships = Dealership::select('id')->where('brand_id', $brand_id)->get();

        if($brand_id == 'all'){
            $execs = Leaderboard::select('leaderboards.id','leaderboards.dealership_code', 'leaderboards.job_title_id', 'leaderboards.name as exec_name', 'leaderboards.email')
                        ->join('job_titles', 'job_titles.id', 'leaderboards.job_title_id')
                        ->where('leaderboards.job_title_id', $job_title_id)
                        ->orderBY('leaderboards.name', 'ASC')->get();

        }else{
            $execs = Leaderboard::select('leaderboards.id','leaderboards.dealership_code', 'leaderboards.job_title_id', 'leaderboards.name as exec_name',  'leaderboards.email')
                        ->join('job_titles', 'job_titles.id', 'leaderboards.job_title_id')
                        ->join('dealerships', 'dealerships.code', 'leaderboards.dealership_code')
                        ->where('leaderboards.job_title_id', $job_title_id)
                        ->where(function ($query) use ($dealerships) {
                            $query->whereIn('dealerships.id',$dealerships);
                        })

                        ->orderBY('leaderboards.dealership_code', 'ASC')
                        ->get();
        }

        $dealership = new Dealership;
        $job_titles = JobTitle::all();

        return view('admin.leaderboard._results-by-competition')
                        ->with('execs', $execs)
                        ->with('competition_id', $competition_id)
                        ->with('job_title_id', $job_title_id)
                        ->with('dealership', $dealership)
                        ->with('job_titles', $job_titles)
                        ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }


    public function create()
    {
        $competitions = Competition::where('active', 1)->get();
        $dealerships = Dealership::all();
        $job_titles = JobTitle::all();

        return view('admin.leaderboard.create')
            ->with('competitions', $competitions)
            ->with('job_titles', $job_titles)
            ->with('dealerships', $dealerships);

    }

    public function edit($id)
    {
        $exec = Leaderboard::find($id);
        $competitions = Competition::where('active', 1)->get();
        $dealerships = Dealership::all();
        $job_titles = JobTitle::all();

        $competition_checked = DB::table('leaderboards')
                                ->join('competition_leaderboard', 'competition_leaderboard.leaderboard_id', 'leaderboards.id')
                                ->join('competitions', 'competitions.id', 'competition_leaderboard.competition_id')
                                ->where('leaderboards.id', $id)
                                ->select('competitions.*')
                                ->get();

        return view('admin.leaderboard.edit')
            ->with('dealerships', $dealerships)
            ->with('job_titles', $job_titles)
            ->with('competitions', $competitions)
            ->with('competition_checked', $competition_checked)
            ->with('exec', $exec);

    }

    public function editLog($id, $competition_id)
    {
        $log = SaleLeague::find($id);
        $sales_type = SaleType::all();

        return view('admin.leaderboard.edit-sales-log')
                ->with('competition_id', $competition_id)
                ->with('sales_type', $sales_type)
                ->with('log', $log);

    }

    public function update(Request $request, $id)
    {
        //
            $exec = Leaderboard::find($id);

            //Handles Form validation
            if(!empty($request->input('password'))){
                $this->validate($request, [
                    'name' => 'required',
                    'email' => 'required',
                    'dealership_code' => 'required',
                    'password' => 'required',
                    'repassword' => 'required|same:password'

                ],
                [

                    'name.required' => 'A name is required.',
                    'email.required' => 'An email is required.',
                    'dealership_code.required' => 'A Dealership must be selected.',
                    'password.required' => 'A password is required.',
                    'repassword.required' => 'A confirmation password is required.',
                    'repassword.same' => 'Password need to match.',
                ]);
            }else{

                $this->validate($request, [
                    'name' => 'required',
                    'email' => 'required',
                    'dealership_code' => 'required',
                ],
                [

                    'name.required' => 'A name is required.',
                    'email.required' => 'An email is required.',
                    'dealership_code.required' => 'A Dealership must be selected.',

                ]);
            }


            if(!empty($request->input('password'))){
                $exec->password = bcrypt($request->input('password'));
            }
            $exec->job_title_id = $request->input('job_title_id');
            $exec->name = $request->input('name');
            $exec->email = $request->input('email');
            $exec->dealership_code = $request->input('dealership_code');
            $exec->competitions()->sync(request('competition_id'));
            $exec->save();

            return redirect()->back()->with('success', '['. $exec->name . '] has been successfully updated.');


    }

    public function addUsersToCompetiton(Request $request)
    {

        $competition_id = $request->competition_id;
        $execs_checked = $request->exec_id;
        $job_title_id = $request->job_title_id;

        $competition = Competition::find($competition_id);

        $competition->leaderboards()->attach($execs_checked);

        return redirect()->route('admin.leaderboard.get.execs.by.competition', [$competition_id])->with('success', 'Competition been succesfully added to Users/Execs.');

    }

    public function updateLog(Request $request, $id)
    {
        //
            $log = SaleLeague::find($id);
            //Handles Form validation
            $this->validate($request, [
                'sale_types_id' => 'required',
                'order_number' => 'required',
                'customer' => 'required',
            ]);

            //return $request->all();

            $log->sale_types_id = $request->input('sale_types_id');
            $log->competition_id = $request->input('competition_id');
            $log->order_number = $request->input('order_number');
            $log->customer = $request->input('customer');

            $log->save();

            return redirect()->route('admin.leaderboard.index')->with('success', '['. $log->customer . '] has been successfully updated.');


    }

    public function salesLog(Request $request){

        if($request->ajax()){

            $leaderboard_id = $request->leaderboard_id;
            $competition_id = $request->competition_id;
            //$logs               =   SaleLeague::where('leaderboard_id', $id)->get();
            $logs = DB::table('sale_leagues')
                        ->join('sale_types', 'sale_types.id', 'sale_leagues.sale_types_id')
                        ->where('sale_leagues.leaderboard_id', $leaderboard_id)
                        ->where('sale_leagues.competition_id', $competition_id)
                        ->select('sale_leagues.id', 'sale_leagues.customer', 'sale_leagues.order_number', 'sale_types.name', 'sale_leagues.created_at')
                        ->orderBy('sale_leagues.created_at', 'DESC')
                        ->get();


            //return $logs;

            $leaderboard = Leaderboard::find($leaderboard_id);
            $competition_id = $request->competition_id;
            return view('admin.leaderboard._sales-log')
                        ->with('leaderboard', $leaderboard)
                        ->with('competition_id', $competition_id)
                        ->with('logs', $logs);

        }


    }


    public function reset()
    {
        SaleLeague::truncate();
    }


    public function storeExec(Request $request)
    {
        //Fields validation
        $request->validate([
            //'competition_id' => 'required',
            'job_title_id' => 'required'
        ]);

        //Checks if Leaderboard exists
        $exists = Leaderboard::where('email', $request->email)->first();
        $exists = Leaderboard::join('competition_leaderboard', 'competition_leaderboard.leaderboard_id', 'leaderboards.id')
                    ->where('leaderboards.email', $request->email)
                    ->first();

        if($exists){
            return redirect()->route('admin.leaderboard.index')->with('warning', '['. $request->name . '] already in this competition!');
        }else{

            $exec = new Leaderboard;
            //Handles Form validation
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
                'dealership_code' => 'required',
                //'competition_id'        => 'required',
                'job_title_id' => 'required'
            ]);

            //$exec->competition_id       =   $request->input('competition_id');
            $exec->name = $request->input('name');
            $exec->email = $request->input('email');
            $exec->job_title_id = $request->input('job_title_id');
            $exec->dealership_code = $request->input('dealership_code');
            $exec->password = Hash::make('123456');
            $exec->save();

            if($request->input('competition_id') != ""){
               $exec->competitions()->attach($request->input('competition_id'));
            }
            return redirect()->route('admin.leaderboard.get.execs')->with('success', '['. $exec->name . '] has been successfully updated.');

        }

    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        $users = Leaderboard::all();
        $competitions = Competition::where('active', 1)->get();

        return view('admin.leaderboard.upload')
                    ->with('competitions', $competitions)
                    ->with('users', $users);
    }

    //Stores and updates all Customers from a spreadsheet
    public function store(Request $request)
    {

            //Validates File extention
            $validator = Validator::make($request->all(), [
                'filename' => 'required|mimes:xlsx,xls,csv,txt'
            ]);


            //Only returns true if file extention matches requirements
            if($validator->passes()){

                Leaderboard::truncate();

                //Imports all new Booking Customers
                $competition_id = $request->competition_id;
                $data = Excel::import(new LeaderboardImport($competition_id), $request->file('filename'));
                //Returns an error if extention not meet.

                return redirect('/dashboard/leaderboard')
                ->with('success', 'Leaderboard Account users been inserted successfully.');
            }else{
                //Returns an error if extention not meet.
                return redirect('/dashboard/leaderboard/upload')
                ->with('error', 'File format must be xlsx,xls or csv.');
            }

    }

    //Exports all updated registrations into a CSV file save in the database
    public function export($competition_id){
        $date = Carbon::now()->format('d-M-Y');

        return Excel::download(new LeaderboardExport($competition_id), 'all-leaderboard'.$date.'.csv');
    }

    //Exports all updated registrations into a CSV file save in the database
    public function exportBrand($competition_id, $brand_id){

        $date = Carbon::now()->format('d-M-Y');
        return Excel::download(new LeagueBrandsExport($competition_id, $brand_id), 'leaderboard-by-brand'.$date.'.csv');
    }

    //Exports all updated registrations into a CSV file save in the database
    public function exportTotal(){
        $date = Carbon::now()->format('d-M-Y');

        return Excel::download(new LeagueTotalExport, 'totals-leaderboard'.$date.'.csv');
    }

    public function delete($id)
    {
        $exec = Leaderboard::find($id);
        $exec->competitions()->detach();
        $exec->delete();
        return redirect()->route('admin.leaderboard.get.execs')->with('success', '['. $exec->name . '] has been successfully deleted');
    }

    public function deleteLog($id)
    {
        //
        $log = SaleLeague::find($id);
        $log->delete();
        return redirect()->route('admin.leaderboard.index')->with('success', '['. $log->sale_type . '] has been successfully deleted');

    }

}
