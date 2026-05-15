<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Book;

class ReportController extends Controller
{
    //

    public function index($id){

        $event = Event::find($id);

        //Redirects to appointments page if there's no events
        if(empty($event)){
            return redirect()->route('admin.appointment.index');
        }

        $prospectCount = Book::where('event_id', $event->id)->get();

        //return count($prospectCount);
        return view('admin.reports.index')
                    ->with('event', $event);

    }

}
