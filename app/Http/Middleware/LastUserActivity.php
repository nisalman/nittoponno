<?php

namespace App\Http\Middleware;

use App\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LastUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        //Session::remove("LAST_ACTIVE_TIME");
        if (Session::has("LAST_ACTIVE_TIME")) {
            //dump("kkk");
            $updatedAt = Session::get('LAST_ACTIVE_TIME');
            if ($updatedAt->diffInMinutes(Carbon::now()) > 5) {
                Session::put("LAST_ACTIVE_TIME", Carbon::now());

                User::where('id', Auth::user()->id)->update([
                    'updated_at' => Carbon::now()
                ]);
            }
            //dump($updatedAt->diffInMinutes(Carbon::now()));

        } else {

            if (Auth::check()) {
                Session::put("LAST_ACTIVE_TIME", Carbon::now());
                User::where('id', Auth::user()->id)->update([
                    'updated_at' => Carbon::now()
                ]);

            }

        }


        return $next($request);
    }
}
