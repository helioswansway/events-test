<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    protected function rules()
    {


        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                Rules\Password::min(10)
                    ->mixedCase() // allows both uppercase and lowercase
                    ->letters() //accepts letter
                    ->numbers() //accepts numbers
                    ->symbols() //accepts special character
                    ->uncompromised(),//check to be sure that there is no data leak
            ],
            'password_confirmation' => 'required|same:password'
        ];
    }

    protected function validationErrorMessages()
    {

        return [
            'password.required' => 'A Password is required',
            'password.min' => 'Password needs a minimum of 10 characters',
            'password_confirmation.required' => 'Confirmation Password is required',
            'password_confirmation.same' => 'Passwords need to match',
        ];

    }

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));
        $user->password_changed_at = Carbon::now()->toDateTimeString();
        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }


}
