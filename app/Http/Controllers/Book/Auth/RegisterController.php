<?php

namespace App\Http\Controllers\Book\Auth;

use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Dealership;
use App\Models\Event;

use App\Mail\EmailCustomerCode;
use App\Models\EventDate;
use Illuminate\Support\Facades\Mail;

use App\Models\Wallpaper;

use DB;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new admins as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/book';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('book.guest:book');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:books',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Book
     */
    protected function create(array $data)
    {
        return Book::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    //Shows General Customer/Prospect registration Form
    public function showRegistrationForm()
    {

        $dealerships    =   Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                                    ->join('events', 'events.id', 'dealership_event.event_id')
                                    ->select('dealerships.*')
                                    ->where('events.active', 1)
                                    ->distinct()
                                    ->get();

        $wallpaper  =   Wallpaper::where('name', 'register')->first();

        return view('book.register')
                ->with('wallpaper', $wallpaper)
                ->with('dealerships', $dealerships);

    }

    //Shows Audi registration Form
    public function showAudiRegistrationForm()
    {
        $dealerships    =   Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                                    ->join('events', 'events.id', 'dealership_event.event_id')
                                    ->join('brands', 'brands.id', 'dealerships.brand_id')
                                    ->select('dealerships.*')
                                    ->where('events.active', 1)
                                    ->where('brands.name', 'audi')
                                    ->distinct()
                                    ->get();

        $wallpaper  =   Wallpaper::where('name', 'register-audi')->first();

        return view('book.register-audi')
                ->with('wallpaper', $wallpaper)
                ->with('dealerships', $dealerships);

    }

    //Shows Volkswagen registration Form
    public function showVolkswagenRegistrationForm()
    {

        $dealerships    =   Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                                    ->join('events', 'events.id', 'dealership_event.event_id')
                                    ->join('brands', 'brands.id', 'dealerships.brand_id')
                                    ->select('dealerships.*')
                                    ->where('events.active', 1)
                                    ->where('brands.name', 'volkswagen')
                                    ->distinct()
                                    ->get();

        $wallpaper  =   Wallpaper::where('name', 'register-volkswagen')->first();

        return view('book.register-volkswagen')
                ->with('wallpaper', $wallpaper)
                ->with('dealerships', $dealerships);

    }

    //Shows Oldham Volkswagen registration Form
    public function showOldhamVolkswagenRegistrationForm()
    {
        $dealerships    =   Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                                    ->join('events', 'events.id', 'dealership_event.event_id')
                                    ->join('brands', 'brands.id', 'dealerships.brand_id')
                                    ->select('dealerships.*')
                                    ->where('events.active', 1)
                                    ->where('brands.name', 'volkswagen')
                                    ->where('dealerships.code', '=', '052')
                                    ->distinct()
                                    ->get();


        $wallpaper  =   Wallpaper::where('name', 'register-oldham-volkswagen')->first();

        return view('book.register-oldham-volkswagen')
                ->with('wallpaper', $wallpaper)
                ->with('dealerships', $dealerships);

    }

    //Shows Oldham Volkswagen registration Form
    public function showVolkswagenCommercialsRegistrationForm()
    {
        $dealerships    =   Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                                    ->join('events', 'events.id', 'dealership_event.event_id')
                                    ->join('brands', 'brands.id', 'dealerships.brand_id')
                                    ->select('dealerships.*')
                                    ->where('events.active', 1)
                                    ->where('dealerships.brand_id', 9)
                                    ->distinct()
                                    ->get();


        $wallpaper  =   Wallpaper::where('name', 'register-volkswagen-van-centre')->first();

        return view('book.register-volkswagen')
                ->with('wallpaper', $wallpaper)
                ->with('dealerships', $dealerships);

    }


    //Shows Honda registration Form
    public function showHondaRegistrationForm()
    {
        $dealerships = Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                            ->join('events', 'events.id', 'dealership_event.event_id')
                            ->join('brands', 'brands.id', 'dealerships.brand_id')
                            ->select('dealerships.*')
                            ->where('events.active', 1)
                            ->where('brands.name', 'honda')
                            ->distinct()
                            ->get();

        $wallpaper = Wallpaper::where('name', 'register-honda')->first();

        return view('book.register-honda')
                ->with('wallpaper', $wallpaper)
                ->with('dealerships', $dealerships);

    }

    //Shows Land Rover registration Form
    public function showLandRoverRegistrationForm()
    {
        $dealerships = Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                            ->join('events', 'events.id', 'dealership_event.event_id')
                            ->join('brands', 'brands.id', 'dealerships.brand_id')
                            ->select('dealerships.*')
                            ->where('events.active', 1)
                            ->where('brands.id', 10)
                            ->distinct()
                            ->get();

        $wallpaper = Wallpaper::where('name', 'register-landrover')->first();

        return view('book.register-landrover')
                ->with('wallpaper', $wallpaper)
                ->with('dealerships', $dealerships);

    }


    //Shows Land Rover Defender registration Form
    public function showDefenderRegistrationForm()
    {
        $dealerships = Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                            ->join('events', 'events.id', 'dealership_event.event_id')
                            ->join('brands', 'brands.id', 'dealerships.brand_id')
                            ->select('dealerships.*')
                            ->where('events.active', 1)
                            ->where('brands.id', 10)
                            ->distinct()
                            ->get();

        $wallpaper = Wallpaper::where('name', 'register-defender')->first();

        return view('book.register-landrover')
                ->with('wallpaper', $wallpaper)
                ->with('dealerships', $dealerships);

    }

    //Shows Land Rover Discover registration Form
    public function showDiscoveryRegistrationForm()
    {
        $dealerships = Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                            ->join('events', 'events.id', 'dealership_event.event_id')
                            ->join('brands', 'brands.id', 'dealerships.brand_id')
                            ->select('dealerships.*')
                            ->where('events.active', 1)
                            ->where('brands.id', 10)
                            ->distinct()
                            ->get();

        $wallpaper = Wallpaper::where('name', 'register-discover')->first();

        return view('book.register-landrover')
                ->with('wallpaper', $wallpaper)
                ->with('dealerships', $dealerships);

    }

    //Shows Land Rover RangeRover registration Form
    public function showRangeRoverRegistrationForm()
    {
        $dealerships = Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                            ->join('events', 'events.id', 'dealership_event.event_id')
                            ->join('brands', 'brands.id', 'dealerships.brand_id')
                            ->select('dealerships.*')
                            ->where('events.active', 1)
                            ->where('brands.id', 10)
                            ->distinct()
                            ->get();

        $wallpaper = Wallpaper::where('name', 'register-rangerover')->first();

        return view('book.register-landrover')
                ->with('wallpaper', $wallpaper)
                ->with('dealerships', $dealerships);

    }


    //Shows peugeot registration Form
    public function showPeugeotRegistrationForm()
    {
        $dealerships = Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                            ->join('events', 'events.id', 'dealership_event.event_id')
                            ->join('brands', 'brands.id', 'dealerships.brand_id')
                            ->select('dealerships.*')
                            ->where('events.active', 1)
                            ->where('brands.id', 12)
                            ->distinct()
                            ->get();

        $wallpaper = Wallpaper::where('name', 'register-peugeot')->first();

        return view('book.register-peugeot')
                ->with('wallpaper', $wallpaper)
                ->with('dealerships', $dealerships);

    }


    //Shows SEAT registration Form
    public function showSeatRegistrationForm()
    {
        $dealerships = Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                            ->join('events', 'events.id', 'dealership_event.event_id')
                            ->join('brands', 'brands.id', 'dealerships.brand_id')
                            ->select('dealerships.*')
                            ->where('events.active', 1)
                            ->where('brands.id', 2)
                            ->distinct()
                            ->get();

        $wallpaper = Wallpaper::where('name', 'register-seat')->first();

        return view('book.register-seat')
                ->with('wallpaper', $wallpaper)
                ->with('dealerships', $dealerships);

    }

    //Shows SEAT registration Form
    public function showCupraRegistrationForm()
    {
        $dealerships = Dealership::join('dealership_event', 'dealership_event.dealership_id', 'dealerships.id')
                            ->join('events', 'events.id', 'dealership_event.event_id')
                            ->join('brands', 'brands.id', 'dealerships.brand_id')
                            ->select('dealerships.*')
                            ->where('events.active', 1)
                            ->where('brands.id', 17)
                            ->distinct()
                            ->get();

        $wallpaper = Wallpaper::where('name', 'register-cupra')->first();

        return view('book.register-cupra')
                ->with('wallpaper', $wallpaper)
                ->with('dealerships', $dealerships);

    }


    //Grabs Events  based on Dealership selected
    public function fetchEvents(Request $request){

        if($request->ajax()){
            $dealership = Dealership::where('code', $request->dealership_code)->first();

            $events = Event::join('dealership_event', 'dealership_event.event_id', 'events.id')
                        ->join('dealerships', 'dealerships.id', 'dealership_event.dealership_id')
                        ->select('events.*')
                        ->where('dealership_event.dealership_id', $dealership->id)
                        ->where('events.active', 1)
                        ->get();

            // $message    = "<i class='far fa-meh fs-180'></i> We're Sorry but no results were found, please try again.";
            return view('book._events')
                        ->with('events', $events);

        }
    }

    public function registerCustomer(Request $request){

        $customer = Book::where('email', $request->input('email'))->first();

        $dealership_event = DB::table('dealership_event')
                            ->join('dealerships', 'dealerships.id', 'dealership_event.dealership_id')
                            ->join('events', 'events.id', 'dealership_event.event_id')
                            ->select('dealerships.id', 'dealerships.phone',  'dealerships.email',  'dealerships.website', 'dealerships.name as dealership_name', 'events.name as event_name')
                            ->where('dealership_event.event_id', $request->input('event_id'))
                            ->first();

        $event_dates = EventDate::join('dealerships', 'dealerships.id', 'event_dates.dealership_id')
                                ->select('event_dates.*', 'dealerships.name as dealership_name')
                                ->where('event_dates.event_id', $request->input('event_id'))->get();


        if($customer){
            return redirect()->route('book.register')->with('warning', '['.$customer->email . '] details already within the system!');
        }else{

            $length = 6;
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789?!><$%£)(!^/\|';
            $count = mb_strlen($chars);

            // Gets a 13 characters random password
            for ($i = 0, $value = ''; $i < $length; $i++) {
                $index = rand(0, $count - 1);
                $value .= mb_substr($chars, $index, 1);
            }

            $customer = new Book;
            $code = rand( 10000 , 99999 );
            $customer->utm_url = $request->input('utm_url');
            $customer->customer_number = $value ."CUST";
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
            $customer->password =   Hash::make('Rreenn84?he');
            $customer->remember_token =   Str::random(60);

            $customer->save();

            $customer_name = $customer->name . " " . $customer->surname;

            //Sends email to the user with the currect password
            Mail::to($customer->email, $customer_name)->queue(new EmailCustomerCode($customer->title ." " . $customer_name, $customer->customer_number, $dealership_event, $event_dates));

            return redirect()->route('book.register.customerCode', [$customer->remember_token])->with('customer_number',  $customer->customer_number);

        }

    }

    public function registerCustomerCode($id){

        $customer = Book::where('remember_token', $id)->first();

        $wallpaper  =   Wallpaper::where('name', 'book')->first();

        if(!$customer){
            return redirect()->route('book.register')
                            ->with('wallpaper', $wallpaper);
        }else{

            return view('book.customer-number')
                        ->with('wallpaper', $wallpaper)
                        ->with('customer', $customer);
        }


    }




    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('book');
    }

}
