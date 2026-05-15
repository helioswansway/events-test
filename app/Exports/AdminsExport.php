<?php

namespace App\Exports;

use Bitfumes\Multiauth\Model\Admin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AdminsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        $admins = Admin::all();


        return view('admin.exports.admin', [
            'admins' => $admins
        ]);


    }
}
