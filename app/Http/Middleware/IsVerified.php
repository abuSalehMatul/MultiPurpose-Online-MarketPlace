<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
               
            $auth = Auth::user();    

            if ($auth->confirmed == 1) {
                
                return $next($request);

            } else {

                // flash('Please verify your email to proceed ahead')->error()->important();

                // return back();
                return $next($request);

            }

        } else {

            return redirect('/');

        }
    }
}
