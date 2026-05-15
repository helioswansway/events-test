<?php

namespace App\Http\Controllers\Leaderboard;

use App\Http\Controllers\Controller;
use App\Models\Dealership;
use App\Models\Brand;
use App\Models\SaleLeague;

use App\Models\Competition;
use App\Models\CompetitionImage;

use Carbon\Carbon;

use App\Leaderboard;
use DB;

class HomeController extends Controller
{

    protected $redirectTo = '/leaderboard/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('leaderboard.auth:leaderboard');
    }

    /**
     * Show the Leaderboard dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $exec               =   auth('leaderboard')->user();

        //return $exec;

        $competitions       =   Competition::select('competitions.*')
                                    ->join('competition_leaderboard', 'competition_leaderboard.competition_id', 'competitions.id')
                                    ->where('competition_leaderboard.leaderboard_id', $exec->id)
                                    ->where('competitions.active', 1)
                                    ->where('competitions.archived', 0)
                                    ->orderBy('name', 'ASC')
                                    ->get();



        $competition        =   Competition::select('competitions.*')
                                    ->join('competition_leaderboard', 'competition_leaderboard.competition_id', 'competitions.id')
                                    ->where('competition_leaderboard.leaderboard_id', $exec->id)
                                    ->where('competitions.archived', 0)
                                    ->orderBy('name', 'ASC')
                                    ->where('competitions.active', 1)->first();

        if(!$competition) {
            return redirect()->route('leaderboard.contacts')->with('warning', 'There\'s no competition assigned to you at the moment. Please get in touch with the contacts below for further assistance!');
        }

        $image              =   DB::table('competition_images')
                                    ->where('competition_images.competition_id', $competition->id)
                                    ->first();

        $sales              =   SaleLeague::select('sale_leagues.*', DB::raw('count(sale_leagues.leaderboard_id) as total'))
                                    ->join('competition_leaderboard', 'competition_leaderboard.leaderboard_id', 'sale_leagues.leaderboard_id')
                                    ->join('competitions', 'competitions.id', 'competition_leaderboard.competition_id')
                                    ->where('competition_leaderboard.competition_id', $competition->id)
                                    ->groupBy('sale_leagues.leaderboard_id')
                                    ->orderBy('total', 'DESC')
                                    //->orderBy('sale_leagues.leaderboard_id', 'DESC')
                                    ->get();



        $dealership         =   Dealership::where('code', $exec->dealership_code)->first();

        $brand              =   Brand::join('dealerships', 'dealerships.brand_id', 'brands.id')
                                    ->select('brands.*', 'dealerships.id as dealership_id')
                                    ->where('dealerships.id', $dealership->id)->first();



        $total_sales        =   SaleLeague::where('brand_id', $brand->id)->get();

        //return $total_sales;
        //return $competition;

        return view('leaderboard.dashboard')
                    ->with('exec', $exec)
                    ->with('brand', $brand)
                    ->with('image', $image)
                    ->with('competitions', $competitions)
                    ->with('competition', $competition)
                    ->with('sales', $sales)
                    ->with('total_sales', $total_sales)
                    ->with('dealership', $dealership);
    }

    public function contacts() {
        return view('leaderboard.contacts');
    }

}
