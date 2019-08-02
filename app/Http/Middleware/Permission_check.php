<?php

namespace App\Http\Middleware;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Closure;
use Auth;
use Session;
use App\User;

class Permission_check
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $slag)
    {
        if ($slag == 'learn_module') {
            $email = Session::get('master');
            $user = User::where('email', $email)->first();
            if ($user) {
                // $user = Auth::guard('admin')->user();
                $permissions = $user->getPermissionNames()->toArray();
                // print_r($permissions);
                // exit();
                if (in_array($slag, $permissions)) {
                    return $next($request);
                } else {
                    return redirect('errors');
                }
            } else {
                return redirect('errors');
            }
        }
        if (Auth::check()) {
            $user = Auth::user();
            $permissions = $user->getPermissionNames()->toArray();
            // print_r($permissions);
            // exit();
            if (in_array($slag, $permissions)) {
                return $next($request);
            } else {
                return redirect('errors');
            }
        } else {
            return redirect('errors');
        }
    }
}
