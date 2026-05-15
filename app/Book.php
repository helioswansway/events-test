<?php

namespace App;

use App\Notifications\Book\BookResetPassword;
use App\Notifications\Book\BookVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Book extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password',
        'customer_number',
        'dealership_code',
        'title',
        'name',
        'surname',
        'address_1',
        'address_2',
        'address_3',
        'address_4',
        'address_5',
        'post_code',
        'vehicle_reg',
        'vehicle_description',
        'home_phone',
        'mobile',
        'email',
        'event_id',
        'last_login_at',
        'created_at',
        'updated_at'
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
        $this->notify(new BookResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new BookVerifyEmail);
    }


    public function execs()
    {
        return $this->belongsToMany("App\Exec");
    }


    public function appointment()
    {
        return $this->hasOne("App\Models\Appointment");
    }

    public function sale()
    {
        return $this->hasOne("App\Models\Sale");
    }

    public function customer($id)
    {
        return self::find($id);
    }

}
