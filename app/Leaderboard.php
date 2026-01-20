<?php

namespace App;

use App\Notifications\Leaderboard\LeaderboardResetPassword;
use App\Notifications\Leaderboard\LeaderboardVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Leaderboard extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dealership_code', 'name', 'email', 'password',
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
        $this->notify(new LeaderboardResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new LeaderboardVerifyEmail);
    }

    public function job_title()
    {
        return $this->belongsTo('App\Models\JobTitle');
    }

    public function competitions()
    {
        return $this->belongsToMany("App\Models\Competition");
    }

    // public function competition()
    // {
    //     return $this->belongsTo("App\Models\Competition");
    // }

}
