<?php

namespace App\Exports;

use App\Models\SaleLeague;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

class LeaderboardExport implements FromView
{

    protected $competition_id;
    public function  __construct($competition_id)
    {
        $this->competition_id   = $competition_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $sales = SaleLeague::where('sale_leagues.competition_id', $this->competition_id)->get();

        // $sales  =   DB::table('competition_leaderboard')
        //                 ->join('competitions', 'competitions.id', 'competition_leaderboard.competition_id')
        //                 ->join('leaderboards', 'leaderboards.id', 'competition_leaderboard.leaderboard_id')
        //                 ->join('sale_leagues', 'sale_leagues.leaderboard_id', 'leaderboards.id')
        //                 ->where('sale_leagues.competition_id', $this->competition_id)
        //                 ->select('leaderboards.name', 'leaderboards.id as leaderboard_id', 'sale_leagues.order_number', 'sale_leagues.sale_types_id', 'sale_leagues.customer' , 'sale_leagues.created_at')
        //                 ->get();

        //return $sales;
        return view('admin.exports.leaderboard', [
            'sales' => $sales
        ]);

    }


    // public function query()
    // {

    //     return  SaleLeague::query()
    //                         ->join('leaderboards', 'leaderboards.id', 'sale_leagues.leaderboard_id')
    //                         ->join('brands', 'brands.id', 'sale_leagues.brand_id')
    //                         ->join('dealerships', 'dealerships.code', 'leaderboards.dealership_code')
    //                         ->select('leaderboards.name as user', 'dealerships.name','sale_leagues.order_number', 'sale_leagues.customer')
    //                         ->groupBy('sale_leagues.id')
    //                         ->where('dealerships.brand_id', $this->brand_id);


    // }

}
