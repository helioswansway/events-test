<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Dealership;
use App\Models\Brand;
use App\Models\Appointment;

use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;
use App\Exec;
use App\Book;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelConst;
use App\Imports\BooksImport;

use Carbon\Carbon;

use Validator;
//use Excel;
use DB;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    //
    public function index()
    {

        $adminRole = new Admin; //Creates an Admin Method
        $admin = auth('admin')->user(); //Grabs the current user that's logged in
        $role = $adminRole->adminRole($admin->id); //Checks logged in admin role

        $dealership = Dealership::where('code', $admin->dealership_code)->first();

        if($role->name == 'super' || $role->name == 'super-admin'){
            //It display all events if admin has roles super and super admin
            $customers  = Book::orderBY('name', 'ASC')->paginate(30);

        }else{

            $customers = Book::select('books.*')
                            ->join('dealerships', 'dealerships.code', 'books.dealership_code')
                            ->join('admin_dealership', 'admin_dealership.dealership_id', 'dealerships.id')
                            ->join('admins', 'admins.id', 'admin_dealership.admin_id')
                            ->where('admins.id', $admin->id)
                            ->orderBy('books.name', 'ASC')
                            ->paginate(30);

        }


        return view('admin.customers.index')
                    ->with('customers', $customers);

    }


    //Fetchs data of search results
    public function fetchData(Request $request){

        $terms = explode(' ', request('keyword'));
        $customers   = Book::select('books.*')
                            ->where(function($query) use ($terms){
                                foreach($terms as $term){
                                    $query->where('books.customer_number', 'LIKE', "%{$term}%")
                                            ->orWhere('books.name', 'LIKE', "%{$term}%")
                                            ->orWhere('books.surname', 'LIKE', "%{$term}%")
                                            ->orWhere('books.id', 'LIKE', "%{$term}%")
                                            ->orWhere('books.email', 'LIKE', "%{$term}%");
                                }
                            })
                            ->orderBY('books.name', 'ASC')
                            ->paginate(30);

        //dd($customers);

        // $message    = "<i class='far fa-meh fs-180'></i> We're Sorry but no results were found, please try again.";
        return view('admin.customers._results')
                        ->with('customers', $customers)
                        ->with('success', 'We\'re Sorry but no results were found, please try again.')
                        ->render();

    }


    public function show($id){

        $customer = Book::where('id', $id)->first();
        return view('admin.customers.show')
            ->with('customer', $customer);

    }

    public function edit($id){

        $customer = Book::where('id', $id)->first();
        $dealership = Dealership::where('code', $customer->dealership_code)->first();
        $brand = Brand::where('id', $dealership->brand_id)->first();
        $dealerships = Dealership::all();
        $execs = Exec::where('dealership_code', $dealership->code)->get();

        return view('admin.customers.edit')
            ->with('execs', $execs)
            ->with('dealerships', $dealerships)
            ->with('customer', $customer);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cust_count = Book::all()->count();
        $events = Event::where('in_progress', 0)->get();

        //return $events;
        return view('admin.customers.create')
                    ->with('events', $events)
                    ->with('cust_count', $cust_count);

    }

    // Assigns/Updates Prospect dealership and exec
    public function execUpdate(Request $request, $customer_id) {

        $dealership_id = $request->dealership_id;
        $exec_id = $request->exec_id;

        // return $dealership_id . " - " . $exec_id . " - " . $customer_id;

        $prospect = Book::find($customer_id);
        $dealership = Dealership::find($dealership_id);

        $check_prospect = DB::table('book_exec')->where('book_id', $customer_id)->first();

        if($check_prospect){

            $book_exec = DB::table('book_exec')
                            ->where('book_id', $customer_id)
                            ->update(['exec_id' => $exec_id]);


        }else{

            $book_exec = DB::table('book_exec')
                        ->insert(
                            ['book_id' => $customer_id, 'exec_id' => $exec_id]
                        );
        }


        $prospect->dealership_code = $dealership->code;
        $prospect->save();

        return redirect()->route('customer.edit', $prospect->id)->with('success', $prospect->name. 'Dealership/Exec has been successfully updated.');


    }



    // Located on /dashboard/customers/register
    // It pulls the event based on the selected dealership
    public function fetchEvents(Request $request){
        //return $request->dealership_code;
        if($request->ajax()){
            $dealership     = Dealership::where('code', $request->dealership_code)->first();

            $events    =   Event::join('dealership_event', 'dealership_event.event_id', 'events.id')
                                ->join('dealerships', 'dealerships.id', 'dealership_event.dealership_id')
                                ->select('events.*')
                                ->where('dealership_event.dealership_id', $dealership->id)
                                ->get();

            //return $events;
            // $message    = "<i class='far fa-meh fs-180'></i> We're Sorry but no results were found, please try again.";
            return view('admin.customers._events')
                            ->with('events', $events);

        }
    }

    public function register(){


        $dealerships = Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                            ->join('events', 'events.id', 'dealership_event.event_id')
                            ->select('dealerships.*')
                            ->where('events.active', 1)
                            ->orWhere('events.in_progress', 1)
                            ->get();


        $events = Event::where('active', 1)->orWhere('in_progress', 1)->get();

        return view('admin.customers.register')
                    ->with('events', $events)
                    ->with('dealerships', $dealerships);

    }

    public function registerCustomer(Request $request){

        $customer = Book::where('email', $request->input('email'))->first();



        if($customer){
            return redirect()->route('customer.register')->with('warning', '['.$customer->name . '] Customer already exists!');

        }else{

            $customer = new Book;
            $code = rand( 10000 , 99999 );
            $customer->customer_number = $code ."PROS_ADMIN";
            $customer->dealership_code = $request->input('dealership_code');
            $customer->event_id = $request->input('event_id');
            $customer->title = $request->input('title');
            $customer->name = $request->input('name');
            $customer->surname = $request->input('surname');
            $customer->address_1 = $request->input('address_1');
            $customer->address_2 = $request->input('address_2');
            $customer->address_3 = $request->input('address_3');
            $customer->address_4 = $request->input('address_4');
            $customer->address_5 = $request->input('address_5');
            $customer->post_code = $request->input('post_code');
            $customer->home_phone = str_replace(' ','',$request->input('home_phone'));
            $customer->mobile = str_replace(' ','',$request->input('mobile'));
            $customer->email = $request->input('email');
            $customer->password = Hash::make('Rreenn84?he');

            $customer->save();
            return redirect()->route('customer.index')->with('success', '['.$customer->name . '] was successfully updated.');

        }

        return $request->all();


    }

    //Stores and updates all Customers from a spreadsheet
    // public function store(Request $request)
    // {

    //     //Validates File extention
    //         $validator = Validator::make($request->all(), [
    //            'filename' => 'required|mimes:xlsx,xls,csv,txt'
    //         ]);

    //         $files = glob(public_path("csv/*")); // get all file names
    //         foreach($files as $file){ // iterate files
    //             if(is_file($file)) {
    //                 unlink($file); // delete file
    //             }
    //         }


    //         //Only returns true if file extention matches requirements
    //         if($validator->passes()){

    //             //Gets random string to name the document
    //             $str1 = Str::random(6);
    //             $str2 = Str::random(6);

    //             //Sets path to null
    //             $file_path = null;

    //             if (request()->filename) {

    //                 $filename = $_FILES['filename']['name'];
    //                 $fileTmpName = $_FILES['filename']['tmp_name'];
    //                 $fileError = $_FILES['filename']['error'];

    //                  $file = "file-". strtolower($str1 . '-' . $str2).'.'. request()->filename->getClientOriginalExtension();
    //                  if(is_dir(public_path("csv"))){
    //                     $file_location = public_path("csv/" . $file);
    //                  }else{
    //                     mkdir("csv");
    //                     $file_location = public_path("csv/" . $file);
    //                  }

    //                  move_uploaded_file($fileTmpName, $file_location);

    //              }


    //             $rows = SimpleExcelReader::create($file_location)
    //                                     ->noHeaderRow()
    //                                     ->getRows();

    //             $rows->each(function(array $row){
    //                 Book::updateOrCreate(
    //                     ['customer_number' => $row[0]], //$row['customer_number'],
    //                     [
    //                         'title' => $row[1], //$row['title'],
    //                         'name' => $row[2], //$row['name'],
    //                         'surname' => $row[3], //$row['surname'],
    //                         'address_1' => $row[4], //$row['address_1'],
    //                         'address_2' => $row[5], //$row['address_2'],
    //                         'address_3' => $row[6], //$row['address_3'],
    //                         'address_4' => $row[7], //$row['address_4'],
    //                         'address_5' => $row[8], //$row['address_5'],
    //                         'post_code' => $row[9], //$row['post_code'],
    //                         'vehicle_reg' => $row[10], //$row['vehicle_reg'],
    //                         'vehicle_description' => $row[11], //$row['vehicle_description'],
    //                         'home_phone' => $row[12], //$row['home_phone'],
    //                         'mobile' => $row[13], //$row['mobile'],
    //                         'email' => $row[14], //$row['email'],
    //                         'password' => Hash::make('Rreenn84?he'), //$row['vehicle_number'],
    //                         'event_id' => request('event_id'),
    //                         'dealership_code' => request('dealership_code'),
    //                     ]);
    //         });



    //         File::deleteDirectory(public_path("csv/"));
    //         //rmdir(public_path("csv"));

    //         return redirect('/dashboard/customers')
    //                         ->with('success', 'Customers been inserted successfully.');

    //         }else{
    //             //Returns an error if extention not meet.
    //             return redirect('/dashboard/customers/create')
    //             ->with('error', 'File format must be xlsx,xls or csv.');
    //         }

    // }


    public function store(Request $request)
    {
            //Validates File extention
            $validator = Validator::make($request->all(), [
               'filename' => 'required|mimes:xlsx,xls,csv,txt'
            ]);

           //return $request->all();

            //Only returns true if file extention matches requirements
            if($validator->passes()){
                //Imports all new Booking Customers
                $event_id = $request->event_id;
                $dealership_code = $request->dealership_code;

                $data = Excel::import(new BooksImport($event_id, $dealership_code), $request->file('filename'));

                //Returns an error if extention not meet.

                $execs = Exec::where('dealership_code', $dealership_code )->get();

                //return   $dealership_code . " - " .count($execs);

                return redirect('/dashboard/customers')
                                ->with('success', 'Customers been inserted successfully.');

            }else{
                //Returns an error if extention not meet.
                return redirect('/dashboard/customers/create')
                ->with('error', 'File format must be xlsx,xls or csv.');
            }

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
        $customer = Book::find($id);

        if($request->input('dealership_id') != NULL){
           $dealership = Dealership::find($request->input('dealership_id'));

           $customer->dealership_code = $dealership->code;

        }else{
            $customer->dealership_code = $request->input('dealership_code');
        }

        //return $request->all();
       // dd($customer);

        $customer->title = $request->input('title');
        $customer->name = $request->input('name');
        $customer->surname = $request->input('surname');
        $customer->address_1 = $request->input('address_1');
        $customer->address_2 = $request->input('address_2');
        $customer->address_3 = $request->input('address_3');
        $customer->address_4 = $request->input('address_4');
        $customer->address_5 = $request->input('address_5');
        $customer->post_code = $request->input('post_code');
        $customer->vehicle_reg = $request->input('vehicle_reg');
        $customer->vehicle_description = $request->input('vehicle_description');
        $customer->home_phone = str_replace(' ','',$request->input('home_phone'));
        $customer->mobile = str_replace(' ','',$request->input('mobile'));
        $customer->email = $request->input('email');

        $customer->save();

        //notifyCRM($customer->id);

        return redirect()->route('customer.index')->with('success', '['. $customer->title. ' ' .$customer->surname . '] was successfully updated.');
    }


    //Updates prospect from create an appointment
    public function updateProspect(Request $request){


        $prospect = Book::find($request->book_id);
        //return $request->all();
        $prospect->title = $request->title;
        $prospect->name = $request->name;
        $prospect->surname = $request->surname;

        $prospect->address_1 = $request->address_1;
        $prospect->address_2 = $request->address_2;
        $prospect->address_3 = $request->address_3;
        $prospect->address_4 = $request->address_4;
        $prospect->address_5 = $request->address_5;
        $prospect->post_code = $request->post_code;

        $prospect->home_phone = $request->home_phone;
        $prospect->mobile = $request->mobile;
        $prospect->email = $request->email;
        $prospect->vehicle_reg = $request->vehicle_reg;
        $prospect->vehicle_description = $request->vehicle_description;

        $prospect->save();

        notifyCRM($prospect->id);
        return redirect()->back()->with('success', 'Propects details have been saved!');

    }

    //Updates prospect from create an appointment
    // public function editDealership(Request $request){

    //     $prospect = Book::find($request->customer_id);
    //     $dealership = Dealership::find($request->dealership_id);

    //     $check_prospect = DB::table('book_exec')->where('book_id', $request->customer_id)->first();

    //     if($check_prospect){
    //         $book_exec = DB::table('book_exec')
    //                         ->where('book_id', $request->customer_id)
    //                         ->update(['exec_id' => $request->exec_id]);
    //     }else{

    //         $book_exec = DB::table('book_exec')
    //                     ->insert(
    //                         ['book_id' => $request->customer_id, 'exec_id' => $request->exec_id]
    //                     );
    //     }


    //     $prospect->dealership_code = $dealership->code;
    //     $prospect->save();

    // }

    //Updates prospect from create an appointment
    public function getExecs(Request $request){

            $customer = Book::find($request->customer_id);
            $dealership = Dealership::find($request->dealership_id);
            $execs = Exec::where('dealership_code', $dealership->code)->get();

            return response()->json([
                'html' => view('admin.customers._execs', compact('execs', 'customer'))->render()
            ]);

    }

    //Updates prospect from create an appointment
    public function getDealerships(Request $request){
            $event = Event::find($request->event_id);
           // return $event->name;

            $dealerships = DB::table('dealership_event')
                            ->join('dealerships', 'dealerships.id', 'dealership_event.dealership_id')
                            ->select('dealerships.*')
                            ->where('dealership_event.event_id', $event->id)
                            ->get();

            return view('admin.customers._dealerships')
                            ->with('dealerships', $dealerships);


    }


    public function delete($id){
        $customer = Book::find($id);

        $appointment    = Appointment::where('book_id', $customer->id)->first();

        if($appointment){
            $appointment->delete();
            $booked = DB::table('book_exec')->where('book_id', $customer->id)->delete();
        }

        $customer->delete();
        return redirect()->route('customer.index')->with('success', $customer->name. ' with customer number: ' .$customer->customer_number . ' has been delete successfully.');

    }

}

