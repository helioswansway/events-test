<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Bitfumes\Multiauth\Model\Admin;
use Bitfumes\Multiauth\Model\Role;

use App\Exports\AdminsExport;
use Illuminate\Support\Facades\Hash;

use App\Models\Dealership;
use App\Models\Appointment;
use App\Exec;
use App\Mail\NotifyAdminRegistration;
use Illuminate\Support\Facades\Mail;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelConst;

use Carbon\Carbon;
use DB;

class AdminController extends Controller
{
    //

    public function index(){

        $admins = Admin::where('id', '!=', auth()->id())
                    ->groupBy('admins.email')
                    ->orderBy('admins.name', 'ASC')
                    ->paginate(30);

        $roles = new Role;
        $message = "Customers data is currently empty!";
        //dd($admins);
        return view('admin.admins.index')
        //return view('multiauth::admin.show')
                    ->with('admins', $admins)
                    ->with('roles', $roles)
                    ->with('message', $message);

    }

    //Fetchs data of search results
    public function fetchData(Request $request){

            $roles = new Role;
            $terms = explode(' ', request('keyword'));
            $admins   = DB::table('admin_role')
                                ->join('roles', 'roles.id', '=', 'admin_role.role_id')
                                ->join('admins', 'admins.id', '=', 'admin_role.admin_id')
                                ->select('admins.active', 'admins.last_login_at', 'admins.name', 'admins.email', 'admins.id', 'admin_role.role_id', 'roles.name AS role_name')
                                ->where(function($query) use ($terms){
                                    foreach($terms as $term){
                                        $query->where('admins.name', 'LIKE', "%{$term}%")
                                                ->orWhere('admins.email', 'LIKE', '%' . $term . '%')
                                                ->orWhere('roles.name', 'LIKE', '%' . $term . '%');
                                    }
                                })
                                ->groupBy('admins.email')
                                ->orderBy('admins.name', 'ASC')
                                ->paginate(30);



            $message    = "<i class='far fa-meh fs-180'></i> We're Sorry but no results were found, please try again.";
            return view('admin.admins._results')
                            ->with('admins', $admins)
                            ->with('message', $message)
                            ->with('roles', $roles)
                            ->render();

    }


    public function create(){

        $dealerships = Dealership::orderBy('name', 'ASC')->get();
        $roles = Role::orderBy('name', 'ASC')->get();

        return view('admin.admins.create', compact('roles', 'dealerships'));

    }

    public function store(Request $request)
    {

        $check_email = Admin::where('email', $request['email'])->first();

        if($check_email){
            return redirect('/admin/show')->with('error', 'Admin ' .$check_email->email.' Already exits!');
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

        //Checks if cloned Checkbox was ticked
        if($request->clone_exec == 1) {

            //Finds Exec based on admin email
            $exec = Exec::where('email', strtolower($request->email))->first();
            $password = generate_password();
            //Saves exec if exists
            if(!$exec){
                $exec = new Exec;
                $exec->name = $request->name;
                $exec->email = strtolower($request->email);
                $exec->dealership_code = $request->cloned_dealership_code;
                $exec->password = Hash::make(generate_password());
                $exec->save();
            }
        }


        //Checks if cloned Checkbox was ticked
        if($request->clone_exec == 0) {
            //Finds Exec based on admin email
            $exec = Exec::where('email', strtolower($request->email))->first();
            //Saves exec if exists
            if($exec){
                $exec->delete();
            }
        }


        $admin = new Admin();
       // $fields = $this->tableFields();
        $password = generate_password();

        $admin->name = $request->input('name');
        $admin->email = strtolower($request->email);
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

    public function edit($admin)
    {

        $admin = Admin::find($admin);

        $exec = Exec::where('email', $admin->email)->first();

        $dealerships = Dealership::orderBy('name', 'ASC')->get();
        $roles = Role::orderBy('name', 'ASC')->get();

        return view('admin.admins.edit', compact('admin', 'roles', 'exec', 'dealerships'));

    }

    public function update(Request $request, $id)
    {
        // return $request->all();

        $admin = Admin::find($id);

        $request->validate([
            'dealership_id' => 'required',
            'role_id' => 'required',
        ],
        [
            'dealership_id.required' => 'You need to select minimum (1) Dealership',
            'role_id.required' => 'You need to select minimum (1) Role'
        ]);

        //$admin             = $this->adminModel::findOrFail($adminId);
        $request['active'] = request('activation') ?? 0;
        // unset($request['activation']);


        //Checks if cloned Checkbox was ticked
        if($request->clone_exec == 0) {
            //Finds Exec based on admin email
            $exec = Exec::where('email', strtolower($admin->email))->first();
            if($exec){
                //Saves exec if exists
                $appointment = Appointment::where('exec_id', $exec->id)->first();

                if($appointment){
                    return redirect()->route('admin.index')->with('warning', 'Exec ['. $exec->name . '], can\'t be deleted.  There\'s still Appointments booked with the Exec. You need to assign the appointments with another Exec.');
                }

                if($exec){
                    $exec->delete();
                }
            }

        }

        //Checks if cloned Checkbox was ticked
        if($request->clone_exec == 1) {

            //Finds Exec based on admin email
            $exec = Exec::where('email', strtolower($admin->email))->first();

            $password = generate_password();
            //Saves exec if exists
            if(!$exec){
                $exec = new Exec;
                $exec->name = $request->name;
                $exec->email = $request->email;
                $exec->dealership_code = $request->cloned_dealership_code;
                $exec->password = Hash::make(generate_password());
                $exec->save();
            }else{

                $exec->name = $request->name;
                $exec->email = $request->email;
                $exec->dealership_code = $request->cloned_dealership_code;
                $exec->save();

            }

        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->active = $request->activation;
        $admin->save();
        $admin->roles()->sync(request('role_id'));
        $admin->dealerships()->sync(request('dealership_id'));

        return redirect(route('admin.index'))->with('success', "{$admin->name} details are successfully updated");

    }


    public function export()
    {

        $date = Carbon::now()->format('YmdHms');
        return Excel::download(new AdminsExport, 'admins-export-'.$date.'.xlsx');
    }


    public function delete($id)
    {

        $admin = Admin::find($id);
        $pivot = DB::table('admin_dealership')->where('admin_id', $admin->id)->delete();
        $admin->delete();

        $exec = Exec::where('email', strtolower($admin->email))->first();
        //Deletes exec if exists
        if($exec){
            $exec->delete();
        }

        return redirect()->route('admin.index')->with('success', 'Admin [' .$admin->name. '] has been deleted!');

    }


}
