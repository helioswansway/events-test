<?php

namespace App\Exports;

use App\Exec;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExecsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        $execs = Exec::all();


        return view('admin.exports.execs', [
            'execs' => $execs
        ]);


    }
}
