<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\AdminValidation;
use Illuminate\Http\Request;

class Master_access
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
        $ip = \Request::ip();
        $sess = Session::get('master');
        if (isset($sess)) {
            $master = AdminValidation::where('primary_email', Session::get('master'))->first();
            Session::forget('master');
            if ($master) {
                if ($master->ip != $ip) {
                    Session::flush();
                    return redirect('master_backend_26');
                } else {
                    Session::put('master', $master->primary_email);
                    return $next($request);
                }
            } else {
                Session::flush();
                return redirect('master_backend_26');
            }
        }else{
            return redirect('master_backend_26');
        }
       
    }
}
