<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Excel;

use PHPMailer\PHPMailer\PHPMailer;

use App\Models\Event;
use App\Models\ArchiveAppointment;

use App\Exports\AppointmentExport;
use App\Exports\AppointmentsArchivedExport;
use App\Exports\SalesExport;
use App\Exports\ProspectExport;
use App\Exports\ArchivedAppointmentsExport;
use App\Exports\ProspectAppointmentExport;
use DB;

class ExportController extends Controller
{
    //

    //Exports all updated registrations into a CSV file save in the database
    public function exportAppointment($event_id){

        ini_set('max_execution_time', 5000);
        $event = Event::find($event_id);

        $date = Carbon::now()->format('d-M-Y-H.i.s');
        return Excel::download(new AppointmentExport($event_id), str_replace(" ", "-", strtolower($event->name)).'-'.'appointments-'.$date.'.csv');
    }

            //Exports all updated registrations into a CSV file save in the database
    public function exportSales($event_id){

        $event = Event::find($event_id);
        $date = Carbon::now()->format('d-M-Y-H.i.s');
        return Excel::download(new SalesExport($event_id), str_replace(" ", "-", strtolower($event->name)).'-'.'sales-'.$date.'.csv');
    }

    //Exports all updated registrations into a CSV file save in the database
    public function exportProspects($event_id){

        $event = Event::find($event_id);
        $date = Carbon::now()->format('d-M-Y-H.i.s');
        return Excel::download(new ProspectExport($event_id), str_replace(" ", "-", strtolower($event->name)).'-'.'prospects-'.$date.'.csv');
    }

     //Exports all updated registrations into a CSV file save in the database
     public function exportProspectAppointments($event_id){

        $event = Event::find($event_id);
        $date = Carbon::now()->format('d-M-Y-H.i.s');
        return Excel::download(new ProspectAppointmentExport($event_id), str_replace(" ", "-", strtolower($event->name)).'-'.'prospect-appointments'.$date.'.csv');
    }

    //Exports Appointments Conversions
    public function exportConversions($event_id){

        $event = Event::find($event_id);
        $date = Carbon::now()->format('d-M-Y-H.i.s');
        return Excel::download(new AppointmentsArchivedExport($event_id), str_replace(" ", "-", strtolower($event->name)).'-'.'convertions-'.$date.'.csv');
    }


}
