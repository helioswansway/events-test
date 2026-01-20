<?php

namespace App\Exports;

use App\Book;
use App\Exec;


use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExecProspectsExport implements FromView
{

    protected $exec_id;

    public function  __construct($exec_id)
    {
        $this->exec_id  = $exec_id;
    }

    public function view(): View
    {

        $exec = Exec::find($this->exec_id);
        $dealership = new Exec;

        $prospects = Book::select('books.*')
                        ->join('book_exec', 'book_exec.book_id', 'books.id')
                        ->where('book_exec.exec_id', $this->exec_id)
                        ->orderBy('books.name', 'ASC')
                        ->get();

        return view('admin.exports.exec-prospects', [
            'prospects' => $prospects,
            'dealership' => $dealership,
            'exec' => $exec
        ]);


    }

}
