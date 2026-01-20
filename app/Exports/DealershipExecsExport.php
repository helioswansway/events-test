<?php

namespace App\Exports;

use App\Book;
use App\Exec;
use App\Models\Dealership;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DealershipExecsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $dealership_id;

    public function  __construct($dealership_id)
    {
        $this->dealership_id  = $dealership_id;
    }


    public function view(): View
    {


        $dealership = Dealership::find($this->dealership_id);
        $execs = Exec::where('dealership_code', $dealership->code)->get();

        return view('admin.exports.exec-dealership', [
            'dealership' => $dealership,
            'execs' => $execs
        ]);

    }
}
