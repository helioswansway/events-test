<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\AdminPasswordExpiredRequest;

use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;


use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

use Auth;

class AdminExpiredPasswordController extends Controller
{
    //

    public function expired()
    {
        return view('multiauth::admin.passwords.expired');
    }


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

        //Logs user out
        //Auth::logout();

        //Redirects to login page
        return redirect()->route('admin')->with(['success' => 'Password changed successfully']);


    }


}
