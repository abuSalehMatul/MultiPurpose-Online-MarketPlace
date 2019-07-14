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
                        // $user_role_id = DB::table('roles')->select('id')->where('name', $request->user_role)->first();
                       
                        // if ($user_role_id) {
                        //     $role_id = DB::table('model_has_roles')->where('model_id', $user_id)
                        //                                             ->where('role_id',$user_role_id)    
                        //                                             ->first();
                        // } 
                        // $roles=array();
                        // print_r($role_id);
                        // print_r($user_role_name);
                        // exit();
                        // foreach($role_id as $role){
                        //     array_push($roles,$role->role_id);
                        // }
                       
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
                    return Redirect::to('freelancer/dashboard');       
                }
               
               
               
            }
        }
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (Schema::hasTable('users')) {
            $this->middleware('guest')->except('logout');
        }
    }
}
