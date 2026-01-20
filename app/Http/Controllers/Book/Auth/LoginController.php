<?php

namespace App\Http\Controllers\Book\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Mail\EmailCustomerCode;
use App\Models\EventDate;
use Illuminate\Support\Facades\Mail;

use App\Models\Wallpaper;
use App\Book;
use App\Mail\ResetCode;

use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/book/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('book.guest:book', ['except' => 'logout']);
    }

    public function username()
    {
        return 'customer_number';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('book');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'book')->first();
        return  view('book.auth.login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows Audi Prospects Login Form
    public function showAudiEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'audi')->first();

        return  view('book.auth.audi-login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows Blackburn Audi Prospects Login Form
    public function showBlackburnAudiEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'blackburn-audi')->first();

        return  view('book.auth.blackburn-audi-login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows Carlisle Audi Prospects Login Form
    public function showCarlisleAudiEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'carlisle-audi')->first();

        return  view('book.auth.carlisle-audi-login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows Preston Audi Prospects Login Form
    public function showPrestonAudiEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'preston-audi')->first();

        return  view('book.auth.preston-audi-login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows Crewe Audi Prospects Login Form
    public function showCreweAudiEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'crewe-audi')->first();

        return  view('book.auth.crewe-audi-login')
                    ->with('wallpaper', $wallpaper);
    }


    //Shows Stafford Audi Prospects Login Form
    public function showStaffordAudiEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'stafford-audi')->first();

        return  view('book.auth.stafford-audi-login')
                    ->with('wallpaper', $wallpaper);
    }


    //Shows Stoke Audi Prospects Login Form
    public function showStokeAudiEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'stoke-audi')->first();

        return  view('book.auth.stoke-audi-login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows Volkswagen Prospects Login Form
    public function showVolkswagenEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'volkswagen')->first();

        return  view('book.auth.volkswagen-login')
                    ->with('wallpaper', $wallpaper);
    }


    //Shows Oldham Volkswagen Prospects Login Form
    public function showOldhamVolkswagenEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'oldham-volkswagen')->first();

        return  view('book.auth.oldham-volkswagen-login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows Crewe Volkswagen Prospects Login Form
    public function showCreweVolkswagenEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'crewe-volkswagen')->first();

        return  view('book.auth.crewe-volkswagen-login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows Crewe Volkswagen Prospects Login Form
    public function showWrexhamVolkswagenEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'wrexham-volkswagen')->first();

        return  view('book.auth.wrexham-volkswagen-login')
                    ->with('wallpaper', $wallpaper);
    }



    //Shows Volkswagen Commercials Prospects Login Form
    public function showVolkswagenCommercialsEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'volkswagen-van-centre')->first();

        return  view('book.auth.volkswagen-van-centre-login')
                    ->with('wallpaper', $wallpaper);
    }

    public function showVolkswagenCommercialBirminghamEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'volkswagen-van-centre-birmingham')->first();

        return  view('book.auth.volkswagen-van-centre-login')
                    ->with('wallpaper', $wallpaper);
    }

    public function showVolkswagenCommercialLancashireEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'volkswagen-van-centre-lancashire')->first();

        return  view('book.auth.volkswagen-van-centre-login')
                    ->with('wallpaper', $wallpaper);
    }

    public function showVolkswagenCommercialLiverpoolEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'volkswagen-van-centre-liverpool')->first();

        return  view('book.auth.volkswagen-van-centre-login')
                    ->with('wallpaper', $wallpaper);
    }

    public function showVolkswagenCommercialOldhamEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'volkswagen-van-centre-oldham')->first();

        return  view('book.auth.volkswagen-van-centre-login')
                    ->with('wallpaper', $wallpaper);
    }

    public function showVolkswagenCommercialWrexhamEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'volkswagen-van-centre-wrexham')->first();

        return  view('book.auth.volkswagen-van-centre-login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows Honda Prospects Login Form
    public function showHondaEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'honda')->first();

        return  view('book.auth.honda-login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows Land Rover Prospects Login Form
    public function showLandRoverEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'landrover')->first();

        return  view('book.auth.landrover-login')
                    ->with('wallpaper', $wallpaper);
    }


    //Shows Land Rover Defender Prospects Login Form
    public function showLandRoverDefenderLoginForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'defender')->first();

        return  view('book.auth.landrover-login')
                    ->with('wallpaper', $wallpaper);
    }


    //Shows Land Rover Discover Prospects Login Form
    public function showLandRoverDiscoveryLoginForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'discover')->first();

        return  view('book.auth.landrover-login')
                    ->with('wallpaper', $wallpaper);
    }


    //Shows Land Rover RageRover Prospects Login Form
    public function showLandRoverRangeRoverLoginForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'rangerover')->first();

        return  view('book.auth.landrover-login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows Land Rover Prospects Login Form
    public function showPeugeotEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'peugeot')->first();

        return  view('book.auth.peugeot-login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows SEAT Prospects Login Form
    public function showSeatEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'seat')->first();

        return  view('book.auth.seat-login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows CUPRA Prospects Login Form
    public function showCupraEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'cupra')->first();

        return  view('book.auth.cupra-login')
                    ->with('wallpaper', $wallpaper);
    }

    //Shows default reset form
    public function resetForm()
    {
        return  view('book.auth.reset-code');
    }

    //Shows Audi reset form
    public function resetAudiForm()
    {

        return  view('book.auth.reset-audi-code');
    }

    //Shows Audi reset form
    public function resetVolkswagenForm()
    {
        return  view('book.auth.reset-volkswagen-code');
    }


    //Shows Audi reset form
    public function resetVolkswagenCommercialForm()
    {
        return  view('book.auth.reset-volkswagen-commercial-code');
    }


    //Shows CUPRA Prospects Login Form
    public function resetUniqueCode(Request $request)
    {

        // return $request->all();

        $customer = Book::where('email', $request->email)->first();


        if(!$customer){
            Session::put('error_code', 'Email <strong>'. $request->email . '</strong> doesn\'t seem to exist in our system. Please try again or <a href="'.route('book.register').'" class="text-brand bold ms-1"> Register here <i class="fa fa-angle-double-right"></i></a>.');
           // return  view('book.auth.reset-code');
           return redirect()->back();
        }

        $length = 6;
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789?!><$%£)(!^/\|';
        $count = mb_strlen($chars);

        // Gets a 13 characters random password
        for ($i = 0, $value = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $value .= mb_substr($chars, $index, 1);
        }
        $customer->customer_number = $value ."_RESET";
        $customer->setRememberToken($token = Str::random(60));
        $customer->save();

        $customer_name = $customer->name . " " . $customer->surname;

        //Sends email to the user with the currect password
        Mail::to($customer->email, $customer_name)->queue(new ResetCode($customer->title ." " . $customer_name, $customer->customer_number));

        return redirect()->route('book.register.customerCode', [$customer->remember_token])->with('customer_number',  $customer->customer_number);


        // return $customer->customer_number;
        // return $request->all();

    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect($this->redirectTo);
    }

}
