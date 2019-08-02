<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use DB;
use App\User;
use Schema;
use Session;
use View;

/**
 * Class LoginController
 *
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @param string $request request attributes
     *
     * @return authenticated users
     */
    protected function authenticated(Request $request, $user)
    {
        if (Schema::hasTable('users')) {
            if (!empty($user->verification_code)) {
                Session::flash('not_verified', trans('lang.verification_code_not_verified'));
                Auth::logout();
            }elseif($user->hasRole('admin')){
                Auth::logout();
                return redirect()->back();
            } 
            else {
                $user_id = Auth::user()->id;
                if(isset($request->user_role)){
                   
                    if (!empty($user_id) && is_numeric($user_id)) {
                        
                       
                        if( $user->hasRole($request->user_role)){
                            $user->syncRoles([$request->user_role]);
                            if ($request->user_role === 'freelancer') {
                                return Redirect::to('freelancer/dashboard');                         
                            } elseif ($request->user_role === 'employer') {
                                return Redirect::to('employer/dashboard');
                            }elseif( $request->user_role === 'pro'){
                                return Redirect::to('Pro/freelancer/dashboard');
                            }elseif( $request->user_role === 'candidate'){
                                return Redirect::to('Job/freelancer/dashboard');
                            }
                            else {
                                return Redirect::to(url()->previous());
                            } 
                        }else{
                            // Auth::logout();
                            // return 'please Active you '.$request->user_role.' account before access';
                            return Redirect::to('freelancer/dashboard');       
                        }
                    }else{
                        Auth::logout();
                        return 'something is wrong!!!!!!!!!!!!!!!!!!!!!!...';
                    }                
                }else{
                    $user->syncRoles(['freelancer']);
                    return Redirect::to('/');       
                }
               
               
               
            }
        }
    }


    public function logout(Request $request)
    {
        if(Auth::guard('admin')->check() || Auth::check()){
            $request->session()->invalidate();
            return $this->loggedOut($request) ?: redirect('/');
        }
    }
    protected function loggedOut(Request $request)
    {
        $request->session()->flush();
    }
    public function __construct()
    {
        if (Schema::hasTable('users')) {
            $this->middleware('guest')->except('logout');
        }
    }
}
