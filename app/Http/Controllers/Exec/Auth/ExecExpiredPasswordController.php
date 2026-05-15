<?php

namespace App\Http\Controllers\Exec\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\ExecPasswordExpiredRequest;

use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;


use Bitfumes\Multiauth\Model\Exec;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

use Auth;

class ExecExpiredPasswordController extends Controller
{
    //

    //Returns View when Password expired
    public function expired()
    {
        return view('exec.auth.passwords.expired');
    }

    //Updates Password
    public function passwordUpdated(Request $request)
    {


        $this->validate($request, [
            'password' => [
                    'required',
                    Password::min(10)
                        ->mixedCase() // allows both uppercase and lowercase
                        ->letters() //accepts letter
                        ->numbers() //accepts numbers
                        ->symbols() //accepts special character
                        ->uncompromised(),//check to be sure that there is no data leak
                ],
            'password_confirmation' => 'required|same:password'
        ],
        [
            'password.required' => 'A Password is required',
            'password.min' => 'Password needs a minimum of 10 characters',
            'password_confirmation.required' => 'Confirmation Password is required',
            'password_confirmation.same' => 'Passwords need to match'
        ]);


        //Updates Password
        $request->user()->update([
            'password' => bcrypt($request->input('password')),
            'password_changed_at' => Carbon::now()->toDateTimeString()
        ]);


        //Redirects to login page
        return redirect()->route('exec.dashboard')->with(['success' => 'Password changed successfully']);


    }


}
