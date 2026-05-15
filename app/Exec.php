<?php

namespace App;

use App\Notifications\Exec\ExecResetPassword;
use App\Notifications\Exec\ExecVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Dealership;
use App\Models\EventDate;
use App\Models\EventTime;


use DB;

class Exec extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dealership_code',
        'password',
        'name',
        'email',
        'filename',
        'specialised',
        'description',
        'email_verified_at',
        'created_at',
        'updated_at',
        'password_changed_at',
        'mobile',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ExecResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new ExecVerifyEmail);
    }

    public function books()
    {
        return $this->belongsToMany("App\Book");
    }


    public function timeSlots()
    {
        return $this->belongsToMany('App\Models\EventTime');
    }

    public function exec($time_id)
    {

        return DB::table('execs')
                    ->join('event_time_exec', 'event_time_exec.exec_id', '=', 'execs.id')
                    ->select('execs.*', 'event_time_exec.id as e_id' )
                    ->where('event_time_id', $time_id)
                    ->get();

    }

    //Returns true if there's any execs to add on the time slot
    public function checkExec($time_slot, $dealership_id){

        // Get Execs that belongs to the Event dealership
        // Execs are saved with a dealership_code

        $time_id = $time_slot;
        $dealership_id = $dealership_id;

        $dealership = Dealership::find($dealership_id);

        $exec = Exec::whereDoesntHave('timeSlots', function ($query) use($time_id) {
                            $query->where('event_time_id', $time_id);
                        })
                        ->where('execs.dealership_code',   $dealership->code)
                        ->first();

                        if($exec){
                            return true;
                        }else{
                            return false;
                        }



    }

    //Returns true if there's any execs against the date
    public function dateExec($date_id, $dealership_id){

        $date_id            = $date_id;
        $dealership_id      = $dealership_id;

        return              DB::table('event_dates')
                                ->join('event_times', 'event_times.event_date_id', '=', 'event_dates.id')
                                ->join('event_time_exec', 'event_time_exec.event_time_id', '=', 'event_times.id')
                                ->where('event_times.event_date_id', $date_id)
                                ->where('event_times.dealership_id', $dealership_id)
                                ->first();

    }

    public function dealership($code) {
        return DB::table('dealerships')
                    ->where('code', $code)
                    ->first()->name;
    }

    public function execSelected($time_id, $exec_id, $appointment_id) {

        return DB::table('execs')
                    ->join('appointments', 'appointments.exec_id', '=', 'execs.id')
                    ->select('execs.*')
                    ->where('appointments.event_time_id', $time_id)
                    ->where('appointments.id', $appointment_id)
                    ->where('execs.id', $exec_id)
                    ->first();

    }


}
