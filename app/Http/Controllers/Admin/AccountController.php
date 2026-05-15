<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Password;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bitfumes\Multiauth\Model\Admin;
use App\Mail\ResetPassword;
use App\Mail\NotifyAdminRegistration;
use Illuminate\Support\Facades\Mail;
use Bitfumes\Multiauth\Notifications\RegistrationNotification;
use DB;
use Image;
use Carbon\Carbon;

class AccountController extends Controller
{
    //

    public function index()
    {

        //$dealerships = Dealership::all();
        $admin =    Admin::find(auth('admin')->user()->id);
        return view('admin.account.index')
            ->with('admin', $admin);
       //->with('user', $user);
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

        $admin = Admin::find($id);


        if(!empty($request->input('password'))){
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
                'job_title' => 'required',
                'password' => 'required',
                'repassword' => 'required|same:password'

            ]);
        }else{

            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
            ]);
        }


        $admin->name    = $request->input('name');
        if(!empty($request->input('password'))){
            $admin->password = bcrypt($request->input('password'));
        }

        $admin->job_title = $request->input('job_title');
        $admin->email = $request->input('email');
        $admin->dealership_id = $request->input('dealership_id');


        $admin->save();

        return redirect('/dashboard/account')->with('success', 'Account details successfully updated!');

    }


            /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return Admin
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        return $request->all();
        $check_email = Admin::where('email', $request['email'])->first();

        if($check_email){
            return redirect()->route('admin.index')->with('error', 'Admin ' .$check_email->email.' Already exits!');
        }

        $this->validate($request, [

            'dealership_id' => 'required',
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'sometimes|required|email',

        ],
        [
            'dealership_id.required' => 'You need to select minimum (1) Dealership',
            'role_id.required' => 'You need to select minimum (1) Role',
            'name.required' => 'Name is required',
            'email.required' => 'An email is required',
        ]);

        //return $request->all();

        $admin = new Admin();
        $fields = $this->tableFields();
        $password = generate_password();

        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->phone = $request->input('phone');
        $admin->mobile = $request->input('mobile');
        $admin->password = bcrypt($password);
        $admin->active = $request['active'] = request('activation') ?? 0;
        $admin->save();
        $admin->roles()->sync(request('role_id'));
        $admin->dealerships()->sync(request('dealership_id'));

        //Sends email to the user with information to reset password
        Mail::to($admin->email)->queue(new NotifyAdminRegistration());

        /*################################################################*/
        /* Need to make it so it sends email notification to admin once his registered with the details*/
        //$this->sendConfirmationNotification($admin, request('password'));
        /*################################################################*/

        return redirect()->route('admin.index')->with('success', 'Admin ' .$admin->name.' successfully Created!');

    }

    public function updateAccount(Request $request, $id)
    {

        //return  $request->all();

        $admin = Admin::find($id);

        $this->validate($request, [
            'name' => 'required',
            'email' => 'email:rfc,dns',
            'mobile' => 'required|digits:11',
        ],
        [

            'mobile.required' => 'A Mobile number is required',

            //'mobile.digits' => 'Mobile needs a minimum of 11 numbers',
        ]);



        //return $request->all();

        $admin->name    = $request->input('name');

        $admin->job_title = $request->input('job_title');
        $admin->email = $request->input('email');
        $admin->phone = str_replace(' ', '', $request->input('phone'));
        $admin->mobile = $request->input('mobile');
        $admin->save();

        if($request->has('update_mobile')){
            return redirect()->back()->with('success', 'Your mobile as been added to your account!');
        }

        return redirect('/dashboard/account')->with('success', 'Details successfully updated!');

    }


    public function resendsPassword($id)
    {

        $admin = Admin::find($id);



        // Characters Length
        $password = generate_password();

        //Sends email to the user with the currect password
        Mail::to($admin->email)->queue(new NotifyAdminRegistration());

        $admin->password = bcrypt($password);
        $admin->password_changed_at = Carbon::now();
        $admin->save();

        return redirect('/admin/show')->with('success', 'Email with instruction to reset password has been sent to admin ' .$admin->name.'!');

    }


    protected function tableFields()
    {
        return collect(\Schema::getColumnListing('admins'));
    }

    protected function sendConfirmationNotification($admin, $password)
    {
        if (config('multiauth.registration_notification_email')) {
            try {
                $admin->notify(new RegistrationNotification($password));
            } catch (\Exception $e) {
                return request()->session()->flash('message', 'Email not sent properly, Please check your mail configurations');
            }
        }
    }
}
