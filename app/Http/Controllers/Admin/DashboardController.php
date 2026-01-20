<?php

namespace App\Http\Controllers\Admin;

use Rap2hpoutre\Controllers\LogViewerController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Leaderboard;
use App\Models\SaleLeague;
use App\Models\Dealership;
use App\Models\Competition;

use App\Models\Admin;
use App\Models\Event;

use App\Book;

use App\Exec;

use DB;

use App\Charts\LeaguesChart;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    //

    public function index(){
        ###############################################################
        //APPOINTMENTS
        ###############################################################

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


        ###############################################################
        //SALES LEAGUE
        ###############################################################
        // $sales = SaleLeague::join('leaderboards', 'leaderboards.id', 'sale_leagues.leaderboard_id')
        //                 ->join('competitions', 'competitions.id', 'sale_leagues.competition_id')
        //                 ->where('competitions.active', 1)
        //                 ->groupBy('sale_leagues.leaderboard_id')
        //                 ->orderBy('total', 'DESC')
        //                 ->orderBy('created_at', 'ASC')
        //                 ->select('leaderboards.name','sale_leagues.*', DB::raw('count(sale_leagues.leaderboard_id) as total'))
        //                 ->pluck('sale_leagues.total', 'leaderboards.name');


        // //return $sales;

        // $competitions = Competition::select('competitions.end_date', 'competitions.name', DB::raw('count(competitions.end_date) as total'))
        //                     ->where('competitions.active', 1)
        //                     ->where('competitions.archived', 0)
        //                     ->groupBy('competitions.name')
        //                     ->orderBy('competitions.end_date', 'DESC')
        //                     ->pluck('competitions.total', 'competitions.name');



        //return $competitions;

        // $total_sales = SaleLeague::join('competitions', 'competitions.id', 'sale_leagues.competition_id')
        //                 ->where('competitions.active', 1)
        //                 ->get();

        // $chart = new LeaguesChart;
        // $chart->labels($sales->keys());
        // $chart->dataset('Leaderboard All-in League', 'bar', $sales->values())->backgroundColor('rgb(33 86 250 / 40%)');

        // $competition = new LeaguesChart;
        // $competition->labels($competitions->keys());
        // $competition->dataset('Competitions', 'doughnut', $competitions->values())->backgroundColor('rgb(185 12 75 / 40%)');


        // return view('admin.dashboard', compact('chart', 'competition', 'total_sales', 'events', 'exec', 'dealerships'));

        return view('admin.dashboard', compact('events', 'exec', 'dealerships'));

    }


    //Forces migration on production environment
    public function migrate(){

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        return "<h1 style='text-align:center; margin-top: 50px; font-family: arial; font-size: 2.5rem; color: #f36e35;'>Migration Completed!</h1>";
    }

    //Forces migration on production environment
    public function dbDump(){

        Artisan::call('backup:run --only-db');

        session()->flash('success', 'Database was successful backed up.');
        return redirect()->route('admin.index');

    }

    //Forces migration on production environment
    public function queueWork(){
        Artisan::call('queue:work --stop-when-empty');

        session()->flash('success', 'Queue work was successful.');
        return redirect()->route('admin.index');

    }

    //Forces migration on production environment
    public function filesDump(){

        Artisan::call('backup:run --only-files');

        session()->flash('success', 'Project files were successful backed up.');
        return redirect()->route('admin.index');

    }

    //Full Project backed up
    public function backupAll(){

        // Artisan::call('backup:run');
         Artisan::call('backup:run --only-db');
         Artisan::call('backup:run --only-files');

         session()->flash('success', 'Full project was successful backed up.');
         return redirect()->route('admin.index');

     }

}
