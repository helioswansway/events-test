<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesExport implements FromView
{

    protected $event_id;

    public function  __construct($event_id)
    {
        $this->event_id  = $event_id;
    }

            /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        $sales      =   Sale::select('sales.*', 'books.customer_number')
                                ->join('appointments', 'appointments.id', 'sales.appointment_id')
                                ->join('books', 'books.id', 'appointments.book_id')
                                ->where('appointments.event_id', $this->event_id)
                                ->orderBy('appointments.dealership_id', 'ASC')
                                ->get();

        return view('admin.exports.sales', [
            'sales' => $sales
        ]);
    }

}
