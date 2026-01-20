<?php

namespace App\Exports;

use App\Models\Appointment;
use App\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AppointmentsArchivedExport implements FromView
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

        $appointments      =   Appointment::select('appointments.*', 'books.customer_number', 'books.title', 'books.name', 'books.surname', 'books.dealership_code')
                                    ->join('books', 'books.id', 'appointments.book_id')
                                    ->where('books.event_id', $this->event_id)
                                    ->groupBy('appointments.dealership_id')
                                    ->orderBy('appointments.created_at', 'DESC')
                                    ->get();

        $customers = Book::where('books.event_id', $this->event_id)->get();


        return view('admin.exports.appointment-archived', [
            'appointments' => $appointments,
            'customers' => $customers
        ]);


    }
}
