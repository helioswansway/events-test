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
use DB;

class LeagueTotalExport implements FromQuery
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {

        return  SaleLeague::query()
                            ->join('leaderboards', 'leaderboards.id', 'sale_leagues.leaderboard_id')
                            ->join('brands', 'brands.id', 'sale_leagues.brand_id')
                            ->join('dealerships', 'dealerships.code', 'leaderboards.dealership_code')
                            ->select('leaderboards.name as user', 'dealerships.name', DB::raw('count(sale_leagues.leaderboard_id) as total'))
                            ->groupBy('leaderboards.id')
                            ->orderBy('total', 'DESC');

                            /*
                                    ->select('sale_leagues.*', DB::raw('count(sale_leagues.leaderboard_id) as total'))
                                        ->groupBy('leaderboard_id')
                                        ->orderBy('total', 'DESC')
                                        ->orderBy('created_at', 'ASC');

                            */

    }
}
