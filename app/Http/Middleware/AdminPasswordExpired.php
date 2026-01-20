<?php

namespace App\Http\Middleware;

//use App\Models\Admin\Admin;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Auth;

class AdminPasswordExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $password_changed_at = new Carbon(($user->password_changed_at) ? $user->password_changed_at : $user->created_at);

        if (Carbon::now()->diffInDays($password_changed_at) >= config('auth.password_expires_days') || $user->password_changed_at === NULL) {
            return redirect()->route('admin.password.expired');
        }

        return $next($request);
    }


}
