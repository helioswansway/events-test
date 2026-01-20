<?php

namespace App\Exports;

use App\Models\Appointment;
use App\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\Queue\ShouldQueue;



class ProspectExport implements FromView, ShouldQueue
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

        $prospects = Book::select('books.*', 'events.name as event_name', 'dealerships.name as dealership_name')
                            ->join('dealerships', 'dealerships.code', 'books.dealership_code')
                            ->join('events', 'events.id', 'books.event_id')
                            ->where('books.event_id', $this->event_id)
                            ->orderBy('dealerships.name', 'ASC')
                            ->get();

        return view('admin.exports.prospects', [
            'prospects' => $prospects
        ]);


    }
}
