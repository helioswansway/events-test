<?php

namespace App\Imports;

use App\Exec;
use Maatwebsite\Excel\Concerns\ToModel;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Response;
use Carbon\Carbon;

class ExecsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Exec::updateOrCreate([
            'email' => $row[0],
            ],[
            //
            'email'                     => $row[0],
            'dealership_code'           => $row[1],
            'name'                      => $row[2],
            'password'                  => Hash::make('RreDF*$REen5&N84?he'),

        ]);
    }
}
