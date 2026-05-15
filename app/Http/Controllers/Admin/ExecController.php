<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\EventTime;

use App\Models\Dealership;
use App\Models\Appointment;


use App\Exec;
use App\Imports\ExecsImport;
use App\Exports\ExecsExport;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Book;
use App\Exports\ExecProspectsExport;
use App\Exports\DealershipExecsExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelConst;

use Carbon\Carbon;

use Validator;
//use Excel;
use DB;


class ExecController extends Controller
{
    //

    public function index() {

        $adminRole = new Admin; //Creates an Admin Method
        $admin = auth('admin')->user(); //Grabs the current user that's logged in
        $role = $adminRole->adminRole($admin->id); //Checks logged in admin role



        if($role->name == 'super' || $role->name == 'super-admin'){
            //It display all Execs if admin has roles super and super admin
            $execs = Exec::select('execs.id','execs.dealership_code', 'execs.name as exec_name', 'execs.email')
                            ->join('dealerships', 'dealerships.code', 'execs.dealership_code')
                            ->orderBY('dealerships.name', 'ASC')
                            ->orderBY('execs.name', 'ASC')
                            ->paginate(50);


        }else{

            $execs = Exec::select('execs.id','execs.dealership_code', 'execs.name as exec_name', 'execs.email')
                            ->join('dealerships', 'dealerships.code', 'execs.dealership_code')
                            ->join('admin_dealership', 'admin_dealership.dealership_id', '=', 'dealerships.id')
                            ->where('admin_dealership.admin_id', auth('admin')->user()->id)
                            ->orderBY('dealerships.name', 'ASC')
                            ->orderBY('execs.name', 'ASC')
                            ->paginate(50);


        }

        $dealership     = new Dealership;

        return view('admin.execs.index')
            ->with('dealership', $dealership)
            ->with('execs', $execs);


    }

    //Fetchs data of search results
    public function fetchData(){

        $adminRole = new Admin; //Creates an Admin Method
        $admin = auth('admin')->user(); //Grabs the current user that's logged in
        $role = $adminRole->adminRole($admin->id); //Checks logged in admin role
        $terms = explode(' ', request('keyword'));


        if($role->name == 'super' || $role->name == 'super-admin'){
            //It display all Execs if admin has roles super and super admin
            $execs = Exec::select('execs.id','execs.dealership_code', 'execs.name as exec_name', 'execs.email')
                    ->join('dealerships', 'dealerships.code', 'execs.dealership_code')
                    ->where(function($query) use ($terms){
                        foreach($terms as $term){
                            $query->where('execs.dealership_code', 'LIKE', "%{$term}%")
                                    ->orWhere('execs.name', 'LIKE', "%{$term}%")
                                    ->orWhere('execs.email', 'LIKE', "%{$term}%");
                        }
                    })
                    ->orderBY('dealerships.name', 'ASC')
                    ->orderBY('execs.name', 'ASC')
                    ->paginate(50);


        }else{

            $execs = Exec::select('execs.id','execs.dealership_code', 'execs.name as exec_name', 'execs.email')
                            ->join('dealerships', 'dealerships.code', 'execs.dealership_code')
                            ->join('admin_dealership', 'admin_dealership.dealership_id', '=', 'dealerships.id')
                            ->where('admin_dealership.admin_id', auth('admin')->user()->id)
                            ->where(function($query) use ($terms){
                                foreach($terms as $term){
                                    $query->where('execs.dealership_code', 'LIKE', "%{$term}%")
                                            ->orWhere('execs.name', 'LIKE', "%{$term}%")
                                            ->orWhere('execs.email', 'LIKE', "%{$term}%");
                                }
                            })
                            ->orderBY('dealerships.name', 'ASC')
                            ->orderBY('execs.name', 'ASC')
                            ->paginate(50);


        }

        $dealership     = new Dealership;

        // $message    = "<i class='far fa-meh fs-180'></i> We're Sorry but no results were found, please try again.";
        return view('admin.execs._results')
                        ->with('execs', $execs)
                        ->with('dealership', $dealership)
                        ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }

    public function execProspects($exec_id){

        $exec = Exec::find($exec_id);
        $customers  = Book::join('book_exec', 'book_exec.book_id', 'books.id')
                                ->where('book_exec.exec_id', $exec_id)
                                ->select('books.*')
                                ->orderBY('name', 'ASC')
                                ->paginate(60);


        return view('admin.execs.exec-prospects')
                    ->with('exec', $exec)
                    ->with('customers', $customers);

    }

    //Fetchs prospects that belongs to the selected exec
    public function fetchProspectsData(){

        $exec = Exec::find(request('exec_id'));
        $terms = explode(' ', request('keyword'));

        //It display all Execs if admin has roles super and super admin
        $customers  = Book::join('book_exec', 'book_exec.book_id', 'books.id')
                                ->where('book_exec.exec_id', $exec->id)
                                ->where(function($query) use ($terms){
                                    foreach($terms as $term){
                                        $query->where('books.customer_number', 'LIKE', "%{$term}%")
                                                ->orWhere('books.name', 'LIKE', "%{$term}%")
                                                ->orWhere('books.surname', 'LIKE', "%{$term}%")
                                                ->orWhere('books.id', 'LIKE', "%{$term}%")
                                                ->orWhere('books.email', 'LIKE', "%{$term}%");
                                    }
                                })
                                ->select('books.*')
                                ->orderBY('books.name', 'ASC')
                                ->paginate(60);




        return view('admin.execs._prospects-results')
                    ->with('exec', $exec)
                    ->with('customers', $customers);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        $events = Event::where('active', 1)->get();
        $exec_count = Exec::all()->count();
        return view('admin.execs.upload')
            ->with('exec_count', $exec_count)
            ->with('events', $events);

    }


    //Stores and updates all Customers from a spreadsheet
    public function store(Request $request)
    {
            //Validates File extention
            $validator = Validator::make($request->all(), [
                'filename' => 'required|mimes:xlsx,xls,csv,txt'
            ]);


            //Only returns true if file extention matches requirements
            if($validator->passes()){
                //Imports all new Booking Customers
                $event_id = $request->event_id;
                $data = Excel::import(new ExecsImport($event_id), $request->file('filename'));
                //Returns an error if extention not meet.
                return redirect('/dashboard/execs')
                ->with('success', 'Execs been inserted successfully.');
            }else{
                //Returns an error if extention not meet.
                return redirect('/dashboard/execs/create')
                ->with('error', 'File format must be xlsx,xls or csv.');
            }

    }


        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events         = Event::where('active', 1)->get();
        $dealerships    = Dealership::all();
        return view('admin.execs.create')
            ->with('dealerships', $dealerships)
            ->with('events', $events);

    }

    public function storeExec(Request $request)
    {
        //
            $exists  = Exec::where('email', $request->email)->first();

            if($exists){
                return redirect()->route('exec.index')->with('warning', '['. $request->email . '] already on the system. Users have to be Unique.');
            }


            $exec = new Exec;
            //Handles Form validation
            $this->validate($request, [
                'name'                  => 'required',
                'email'                 => 'required',
                'dealership_code'       => 'required',
            ]);


            $exec->name                 =   $request->input('name');
            $exec->email                =   $request->input('email');
            $exec->dealership_code      =   $request->input('dealership_code');
            $exec->specialised          =   $request->input('specialised');
            $exec->description          =   $request->input('description');
            $exec->password             =   Hash::make('RreDF*$REen5&N84?he');
            $exec->save();


            return redirect()->route('exec.index')->with('success', '['. $exec->name . '] has been successfully updated.');

    }


        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exec = Exec::find($id);

        if(!$exec){
            return redirect()->route('exec.index')->with('The Exec your looking for doesn\'t exist anymore.');

        }

        $dealerships = Dealership::all();
        return view('admin.execs.edit')
            ->with('dealerships', $dealerships)
            ->with('exec', $exec);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
            $exec = Exec::find($id);

            if(!empty($request->input('password'))){
                $this->validate($request, [
                    'name'          => 'required',
                    'email'         => 'required',
                    'password'      => 'required',
                    'repassword'    => 'required|same:password'

                ],
                [

                    'name.required' => 'A name is required.',
                    'email.required' => 'An email is required.',
                    'password.required' => 'A password is required.',
                    'repassword.required' => 'A confirmation password is required.',
                    'repassword.same' => 'Password need to match.',
                ]);
            }else{
                //Handles Form validation
                $this->validate($request, [
                    'name' => 'required',
                    'email' => 'required',

                ],
                [
                    'name.required' => 'A name is required.',
                    'email.required' => 'An email is required.',
                ]);
            }


            if(!empty($request->input('password'))){
                $exec->password    = bcrypt($request->input('password'));
            }

            $exec->name = $request->input('name');
            $exec->dealership_code = $request->input('dealership_code');
            $exec->email = $request->input('email');
            $exec->specialised = $request->input('specialised');
            $exec->description = $request->input('description');
            $exec->save();

            return redirect()->route('exec.index')->with('success', '['. $exec->name . '] has been successfully updated.');

    }

    public function export()
    {
        $date = Carbon::now()->format('Y-M-d-h.i.s');


        return Excel::download(new ExecsExport, 'execs-event-export-'.$date.'.xlsx');
    }

    public function prospectExport($exec_id)
    {

        $date = Carbon::now()->format('Y-M-d-h.i.s');
        return Excel::download(new ExecProspectsExport($exec_id), 'execs-prospect-export-'.$date.'.xlsx');

    }


    public function execDealershipExport($dealership_id)
    {

        $date = Carbon::now()->format('Y-M-d-h.i.s');
        return Excel::download(new DealershipExecsExport($dealership_id), 'execs-dealership-export-'.$date.'.xlsx');

    }


    public function prospectRemove($exec_id) {

        $exec = Exec::find($exec_id);
        $exec_book = DB::table('book_exec')->where('exec_id', $exec->id)->delete();

        return redirect()->route('exec.index')->with('success', '['. $exec->name . '] have been detached from prospects successfully');
    }



    public function execAppointments($exec_id) {


        $appointments = Appointment::select('appointments.*', 'books.title', 'books.name', 'books.surname', 'books.email')
                                ->join('books', 'books.id', 'appointments.book_id')
                                ->where('exec_id', $exec_id)->get();

        $exec = Exec::find($exec_id);
        $dealership = Dealership::where('code', $exec->dealership_code)->first();

        return view('admin.execs.appointments')
            ->with('dealership', $dealership)
            ->with('appointments', $appointments)
            ->with('exec', $exec);

    }



    public function delete($id)
    {
        $exec = Exec::find($id);

        $appointment = Appointment::where('exec_id', $exec->id)->first();

        if($appointment){
            return redirect()->route('exec.index')->with('warning', 'Exec ['. $exec->name . '], can\'t be deleted.  There\'s still Appointments booked with the Exec. You need to update the appointment with another Exec.');
        }

        $exec_book = DB::table('book_exec')->where('exec_id', $exec->id)->delete();
        $exec->delete();
        return redirect()->route('exec.index')->with('success', '['. $exec->name . '] has been successfully deleted');
    }



}
