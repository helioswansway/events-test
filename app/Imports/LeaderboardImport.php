<?php

namespace App\Imports;

use App\Leaderboard;
use Maatwebsite\Excel\Concerns\ToModel;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Response;
use Carbon\Carbon;
use DB;

class LeaderboardImport implements ToModel
{

    protected $competition_id;

    public function  __construct($competition_id)
    {
        $this->competition_id                 = $competition_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $leaderboards = new Leaderboard([
            //
            'dealership_code'           => $row[0],
            'email'                     => $row[1],
            'name'                      => $row[2],
            'password'                  => Hash::make('RreDF*$REen5&N84?he'),
        ]);

        $execs = array_map('intval', explode(',', $leaderboards));

        DB::table('competition_leaderboard')->insert([$leaderboards => $this->competition_id ]);
        //$leaderboards->competitions()->attach($this->competition_id);
        return $leaderboards;
    }
}
