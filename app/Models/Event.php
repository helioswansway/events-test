<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Event extends Model
{
    //


    public function dealershipAppointments()
    {
        return $this->hasMany('App\Models\DealershipAppointment');
    }

    public function eventDates()
    {
        return $this->hasMany('App\Models\EventDate');
    }

    public function dealerships()
    {
        return $this->belongsToMany("App\Models\Dealership");
    }

    public function event_dealerships($event_id)
    {
        $adminRole = new Admin;
        $admin = auth('admin')->user();
        $role = $adminRole->adminRole($admin->id);

        if($role->name == 'super' || $role->name == 'super-admin'){
            $dealerships = DB::table('events')->select('dealerships.*')
                                    ->join('dealership_event', 'dealership_event.event_id', 'events.id')
                                    ->join('dealerships', 'dealerships.id', 'dealership_event.dealership_id')
                                   // ->join('admin_dealership', 'admin_dealership.dealership_id', '=', 'dealerships.id')
                                    ->groupBy('dealerships.name')
                                    ->orderBy('dealerships.name', 'ASC')
                                    ->where('events.id', $event_id)
                                    ->get();

            return  $dealerships;

        }else{
            $dealerships = DB::table('events')->select('dealerships.*')
                        ->join('dealership_event', 'dealership_event.event_id', 'events.id')
                        ->join('dealerships', 'dealerships.id', 'dealership_event.dealership_id')
                        ->join('admin_dealership', 'admin_dealership.dealership_id', '=', 'dealerships.id')
                        ->join('admins', 'admins.id', '=', 'admin_dealership.admin_id')
                        ->groupBy('dealerships.name')
                        ->where('events.id', $event_id)
                        ->where('admins.id', $admin->id)
                        ->get();

            return  $dealerships;

        }

    }

    //Returns Event object based on loggged user (Booking Customer)
    public static function event()
    {
        $book = DB::table('books')
                ->join('events', 'events.id', '=', 'books.event_id')
                ->select('events.*')
                ->where('events.id',  auth('book')->user()->event_id)
                ->first();

        return  $book;
    }
}
