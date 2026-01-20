<?php

namespace App\Http\Controllers\Exec;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Exec\EventController;

use App\Models\Dealership;
use App\Models\Appointment;
use App\Models\Sale;
use App\Book;

class SaleController extends Controller
{
    //

    public function index(){



        $exec =   auth('exec')->user();
        $dealership =   Dealership::where('code', $exec->dealership_code)->first();

        $event =   new EventController;

        if(empty($event->event()->id)){
            return redirect()->route('exec.dashboard')->with('success', ' It seems to be an issue, please contact the person responsible for the Events System!');
        }

        $sales =   Sale::where('exec_id', $exec->id)
                        ->where('event_id', $event->event()->id)
                        ->get();

        return view('exec.sales.index')
                ->with('dealership', $dealership)
                ->with('sales', $sales);

    }



    public function create($book_id){

        $exec               =   auth('exec')->user();

        $prospect           =   Book::find($book_id);
        $appointment        =   Appointment::where('book_id', $prospect->id)->first();


        if(!$appointment){
           return  redirect()->route('exec.prospect.index')->with('warning', 'You can\'t create a sale, there\'s no appointment assigned to this prospect!');
        }

        $dealership         =   Dealership::find($appointment->dealership_id);


        return view('exec.sales.create')
                    ->with('exec', $exec)
                    ->with('dealership', $dealership)
                    ->with('prospect', $prospect)
                    ->with('appointment', $appointment);

    }

    public function edit($id){

        $sale               =   Sale::find($id);


        return view('exec.sales.edit')
                    ->with('sale', $sale);

    }



    public function store(Request $request){

        $sale                           =   new Sale;

        $appointment                    =   Appointment::find($request->appointment_id);
        $appointment->sale              =   1;
        $appointment->confirm           =   0;
        $appointment->completed         =   1;
        $appointment->save();


        $sale->dealership_id            =   $request->dealership_id;
        $sale->appointment_id           =   $request->appointment_id;
        $sale->event_id                 =   $request->event_id;
        $sale->book_id                  =   $request->book_id;
        $sale->exec_id                  =   $request->exec_id;
        $sale->order_number             =   $request->order_number;
        $sale->from_appointment         =   $request->from_appointment;
        $sale->sale_type                =   $request->sale_type;
        $sale->sold_vehicle             =   $request->sold_vehicle;
        $sale->finance                  =   $request->finance;
        $sale->paint_protection         =   $request->paint_protection;
        $sale->smart                    =   $request->smart;
        $sale->gap                      =   $request->gap;
        $sale->warranty                 =   $request->warranty;
        $sale->registration             =   $request->registration;
        $sale->part_exchange            =   $request->part_exchange;


        $sale->save();
        return redirect()->route("exec.prospect.index")->with('success', 'Sale has been stored!');


    }

    public function update(Request $request, $id){

        $sale                           =   Sale::find($id);

        $sale->order_number             =   $request->input('order_number');
        $sale->from_appointment         =   $request->input('from_appointment');
        $sale->sale_type                =   $request->input('sale_type');
        $sale->sold_vehicle             =   $request->input('sold_vehicle');
        $sale->finance                  =   $request->input('finance');
        $sale->paint_protection         =   $request->input('paint_protection');
        $sale->smart                    =   $request->input('smart');
        $sale->gap                      =   $request->input('gap');
        $sale->warranty                 =   $request->input('warranty');
        $sale->alloy                    =   $request->input('alloy');
        $sale->tyre                     =   $request->input('tyre');
        $sale->part_exchange            =   $request->input('part_exchange');

        if($request->input('part_exchange') == 1){
            $sale->registration             =   $request->input('registration');
        }else{
            $sale->registration             =   "";
        }


        $sale->save();
        return redirect()->route("exec.sale.index")->with('success', 'Sale has been Updated!');

    }

    /*
        public function show($id){

            $exec               =   auth('exec')->user();
            $sale               =   Sale::find($id);

            return view('exec.sales.show')
                        ->with('sale', $sale);

        }
    */


}
