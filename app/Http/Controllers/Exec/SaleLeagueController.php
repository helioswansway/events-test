<?php

namespace App\Http\Controllers\Exec;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dealership;
use App\Models\Brand;
use App\Models\SaleLeague;

use App\Exec;
use DB;

class SaleLeagueController extends Controller
{
    //

    public function index() {

        $exec           =   auth('exec')->user();

        $dealership     =   Dealership::where('code', $exec->dealership_code)->first();

        $brand          =   Brand::join('dealerships', 'dealerships.brand_id', 'brands.id')
                                ->select('brands.*', 'dealerships.id as dealership_id')
                                ->where('dealerships.id', $dealership->id)->first();

        $sales          =   SaleLeague::select('sale_leagues.*', DB::raw('count(sale_leagues.exec_id) as total'))
                                        ->where('brand_id', $brand->id)
                                        ->groupBy('exec_id')
                                        ->orderBy('total', 'DESC')
                                        ->paginate(15);

       //return $brand;

        $total_sales    =   SaleLeague::where('brand_id', $brand->id)->get();

        return view('exec.sales-league.index')
                    ->with('exec', $exec)
                    ->with('brand', $brand)
                    ->with('sales', $sales)
                    ->with('total_sales', $total_sales)
                    ->with('dealership', $dealership);
    }


    public function logSale(Request $request){

        if($request->ajax()){

            $exec_id            =   $request->exec_id;
            $dealership_id      =   $request->dealership_id;

            $exec               =   Exec::find($exec_id);
            $dealership         =   Dealership::find($dealership_id);


            return view('exec.sales-league._log-sale')
                        ->with('exec', $exec)
                        ->with('dealership', $dealership);

        }

    }


    public function store(Request $request){

        $exec           =   auth('exec')->user();

        $dealership     =   Dealership::where('code', $exec->dealership_code)->first();

        $brand          =   Brand::join('dealerships', 'dealerships.brand_id', 'brands.id')
                                ->select('brands.*', 'dealerships.id as dealership_id')
                                ->where('dealerships.id', $dealership->id)->first();

        $sale                           =   new SaleLeague;
        $sale->customer                 =   $request->customer;
        $sale->exec_id                  =   $request->exec_id;
        $sale->brand_id                 =   $brand->id;
        $sale->order_number             =   $request->order_number;


        $sale->save();

    }

}
