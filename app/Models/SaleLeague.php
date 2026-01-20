<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleLeague extends Model
{
    use HasFactory;

    public function leaderboard()
    {
        return $this->belongsTo("App\Leaderboard");
    }

    public function dealership()
    {
        return $this->belongsTo("App\Models\Dealership");
    }


    public function table_league($competition_id){


        $sales      =   SaleLeague::select('sale_leagues.*')
                        ->where('sale_leagues.competition_id', $competition_id)
                        ->groupBy('sale_leagues.leaderboard_id')
                        ->get();

        return $sales;
    }



}
