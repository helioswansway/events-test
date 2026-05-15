<?php

namespace App\Http\Controllers\Exec\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Wallpaper;

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
    protected $redirectTo = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('exec.guest:exec', ['except' => 'logout']);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('exec');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return redirect()->route('admin.login');
        $wallpaper  =   Wallpaper::where('name', 'exec')->first();

        return  view('exec.auth.login')
                    ->with('wallpaper', $wallpaper);
    }

    public function showAudiEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'exec-audi')->first();

        return  view('exec.auth.audi-login')
                    ->with('wallpaper', $wallpaper);
    }

    public function showVolkswagenEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'exec-volkswagen')->first();

        return  view('exec.auth.volkswagen-login')
                    ->with('wallpaper', $wallpaper);
    }

    public function showOldhamVolkswagenEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'exec-oldham-volkswagen')->first();

        return  view('exec.auth.oldham-volkswagen-login')
                    ->with('wallpaper', $wallpaper);
    }

    public function showHondaEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'exec-honda')->first();

        return  view('exec.auth.honda-login')
                    ->with('wallpaper', $wallpaper);
    }

    public function showLandRoverEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'exec-landrover')->first();

        return  view('exec.auth.landrover-login')
                    ->with('wallpaper', $wallpaper);
    }

    public function showPeugeotEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'exec-peugeot')->first();

        return  view('exec.auth.peugeot-login')
                    ->with('wallpaper', $wallpaper);
    }

    public function showSeatEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'exec-seat')->first();

        return  view('exec.auth.seat-login')
                    ->with('wallpaper', $wallpaper);
    }

    public function showCupraEventForm()
    {
        $wallpaper  =   Wallpaper::where('name', 'exec-cupra')->first();

        return  view('exec.auth.cupra-login')
                    ->with('wallpaper', $wallpaper);
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
