<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArchiveAppointment;

use DB;

class ArchiveAppointmentController extends Controller
{
    //

    public function index() {

        $archives   = ArchiveAppointment::all();

        return view('admin.events.archive.index')
                    ->with('archives', $archives);

    }


    public function delete($id) {
        $archive   = ArchiveAppointment::find($id);


        if(file_exists(public_path() . '/assets/archived/'.$archive->file_path)){
            unlink('assets/archived/'.$archive->file_path);
        }


        $archive->delete();
        return redirect()->route('archive.index')->with('success', 'Archive has been deleted successfully.');
    }
}
