<?php

namespace App\Http\Controllers\Leaderboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Dealership;
use App\Models\Brand;
use App\Models\SaleLeague;
use App\Models\SaleType;
use App\Models\Competition;


use App\Leaderboard;
use DB;

class SaleLeagueController extends Controller
{
    //


    public function index() {


        $exec           =   auth('leaderboard')->user();

        $dealership     =   Dealership::where('code', $exec->dealership_code)->first();

        $brand          =   Brand::join('dealerships', 'dealerships.brand_id', 'brands.id')
                                ->select('brands.*', 'dealerships.id as dealership_id')
                                ->where('dealerships.id', $dealership->id)->first();


        if($brand->name == 'Volkswagen' || $brand->name == 'SEAT'){
            $sales      =       SaleLeague::join('brands', 'brands.id', ('sale_leagues.brand_id'))
                                        ->select('sale_leagues.*', DB::raw('count(sale_leagues.leaderboard_id) as total'))
                                        //->where('sale_leagues.brand_id', $brand->id)
                                        ->where('brands.name', 'Volkswagen')
                                        ->orWhere('brands.name', 'SEAT')
                                        ->groupBy('sale_leagues.leaderboard_id')
                                        ->orderBy('total', 'DESC')
                                        ->paginate(15);

        }else{
            $sales          =   SaleLeague::select('sale_leagues.*', DB::raw('count(sale_leagues.leaderboard_id) as total'))
                                        ->where('brand_id', $brand->id)
                                        ->groupBy('leaderboard_id')
                                        ->orderBy('total', 'DESC')
                                        ->paginate(15);
        }



       //return $brand;

        $total_sales    =   SaleLeague::where('brand_id', $brand->id)->get();

        return view('leaderboard.sales-league.index')
                    ->with('exec', $exec)
                    ->with('brand', $brand)
                    ->with('sales', $sales)
                    ->with('total_sales', $total_sales)
                    ->with('dealership', $dealership);
    }

    public function showCompetitionLeague(Request $request)
    {
        //

        $exec               =   auth('leaderboard')->user();
        $competition        =   Competition::find($request->competition_id);

        $dealership         =   Dealership::find($request->dealership_id);

        //return $competition->id;

        $sales              =   SaleLeague::select('sale_leagues.*', DB::raw('count(sale_leagues.leaderboard_id) as total'))
                                    ->join('competition_leaderboard', 'competition_leaderboard.leaderboard_id', 'sale_leagues.leaderboard_id')
                                    ->join('competitions', 'competitions.id', 'competition_leaderboard.competition_id')
                                    ->where('competition_leaderboard.competition_id', $competition->id)
                                    ->groupBy('sale_leagues.leaderboard_id')
                                    ->orderBy('total', 'DESC')
                                    // ->orderBy('sale_leagues.leaderboard_id', 'DESC')
                                    ->get();





        return view('leaderboard.sales-league._show-competition-league')
                ->with('competition', $competition)
                ->with('exec', $exec)
                ->with('dealership', $dealership)
                ->with('sales', $sales);

    }

    public function showCompetitionFilename(Request $request)
    {

        //Checks if there's more than one competition


            //Gets the first competition
            $competition       =   Competition::select('competitions.*')
                                        ->join('competition_leaderboard', 'competition_leaderboard.competition_id', 'competitions.id')
                                        ->where('competition_leaderboard.leaderboard_id', $request->exec_id)
                                        ->where('competition_leaderboard.competition_id', $request->competition_id)
                                        ->where('competitions.active', 1)->first();

            //Gets the image matching $competition->id
            $image              =   DB::table('competition_images')
                                        ->where('competition_images.competition_id', $competition->id)
                                        ->first();

            if($image){
                //Sets the new image $path
                $path               =   asset('assets/images/public/general/') ."/".$image->filename;

                //Echo's image
                return '<img src="'.$path.'" alt="" class="block mb-4 border border-white shadow ">';
            }



    }



    public function salesLog(Request $request){

        if($request->ajax()){

            $leaderboard_id                 =   $request->leaderboard_id;
            $competition_id                 =   $request->competition_id;
            //$logs               =   SaleLeague::where('leaderboard_id', $id)->get();
            $logs               =   DB::table('sale_leagues')
                                        ->join('sale_types', 'sale_types.id', 'sale_leagues.sale_types_id')
                                        ->where('sale_leagues.leaderboard_id', $leaderboard_id)
                                        ->where('sale_leagues.competition_id', $competition_id)
                                        ->select('sale_leagues.id', 'sale_leagues.customer', 'sale_leagues.order_number', 'sale_types.name', 'sale_leagues.created_at')
                                        ->orderBy('sale_leagues.created_at', 'DESC')
                                        ->get();


            //return $logs;

            $leaderboard        =   Leaderboard::find($leaderboard_id);
            $competition_id     =   $request->competition_id;
            return view('leaderboard.sales-league._sales-log')
                        ->with('leaderboard', $leaderboard)
                        ->with('competition_id', $competition_id)
                        ->with('logs', $logs);

        }

    }


    public function logSale(Request $request){


        if($request->ajax()){

            $exec_id            =   $request->exec_id;
            $dealership_id      =   $request->dealership_id;

            $exec               =   Leaderboard::find($exec_id);
            $dealership         =   Dealership::find($dealership_id);
            $sales_type         =   SaleType::all();


            return view('leaderboard.sales-league._log-sale')
                        ->with('exec', $exec)
                        ->with('dealership', $dealership)
                        ->with('sales_type', $sales_type);

        }

    }


    public function store(Request $request){



        $exec           =   auth('leaderboard')->user();

        $dealership     =   Dealership::where('code', $exec->dealership_code)->first();

        $brand          =   Brand::join('dealerships', 'dealerships.brand_id', 'brands.id')
                                ->select('brands.*', 'dealerships.id as dealership_id')
                                ->where('dealerships.id', $dealership->id)->first();

        $sale                           =   new SaleLeague;
        $sale->customer                 =   $request->customer;
        $sale->leaderboard_id           =   $request->exec_id;
        $sale->competition_id           =   $request->competition_id;
        $sale->brand_id                 =   $brand->id;
        $sale->order_number             =   $request->order_number;
        $sale->sale_types_id            =   $request->sale_types_id;

        $sale->save();

    }


    public function salesType(Request $request){


        if($request->ajax()){

            $leaderboard_id      =   $request->leaderboard_id;
            $competition_id      =   $request->competition_id;


            //$sales_type         =   SaleType::all();

            $sales_type         =   DB::table('sale_leagues')
                                        ->join('sale_types', 'sale_types.id', 'sale_leagues.sale_types_id')
                                        ->where('sale_leagues.leaderboard_id', $leaderboard_id)
                                        ->where('sale_leagues.competition_id', $competition_id)
                                        ->select('sale_leagues.customer', 'sale_leagues.order_number', 'sale_types.name', 'sale_leagues.created_at')
                                        ->orderBy('sale_leagues.created_at', 'DESC')
                                        ->get();


            return view('leaderboard.sales-league._sales-type')
                        ->with('sales_type', $sales_type);

        }

    }
}
