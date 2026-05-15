<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Dealership;

use DB;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'password_changed_at', 'mobile', 'last_login_at'
    ];

    //Selects the admin logged in and passes the role required
    public function adminRole($admin_id){
        $role = DB::table('admin_role')
                ->join('roles', 'roles.id', '=', 'admin_role.role_id')
                ->join('admins', 'admins.id', '=', 'admin_role.admin_id')
                ->select('roles.name')
                ->where('admin_role.admin_id',  $admin_id)
                ->first();
        return $role;
    }


    //Gets the Admin based on the ID
    public function admin($id){
        $admin = DB::table('admins')
                ->where('id',  $id)
                ->first();

        return $admin;
    }
}
