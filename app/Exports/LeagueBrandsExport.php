<?php

namespace App\Exports;

use App\Models\SaleLeague;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;

class LeagueBrandsExport implements FromQuery
{

    //use Importable;
    protected $competition_id;
    protected $brand_id;
    public function  __construct($competition_id, $brand_id)
    {
        $this->brand_id         = $brand_id;
        $this->competition_id   = $competition_id;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {

        return  SaleLeague::query()
                            ->join('leaderboards', 'leaderboards.id', 'sale_leagues.leaderboard_id')
                            ->join('brands', 'brands.id', 'sale_leagues.brand_id')
                            ->join('dealerships', 'dealerships.code', 'leaderboards.dealership_code')
                            ->select('leaderboards.name as user', 'dealerships.name','sale_leagues.order_number', 'sale_leagues.customer')
                            ->groupBy('sale_leagues.id')
                            ->where('sale_leagues.competition_id', $this->competition_id)
                            ->where('dealerships.brand_id', $this->brand_id);


    }
}
