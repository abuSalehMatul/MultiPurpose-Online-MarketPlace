<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Mail;
use Auth;
use App\User;
use App\Admin;
use App\Mail\SENDMAIL;
use App\AdminValidation;
use DB;
use Session;

class MasterBackendController extends Controller
{
    public function __construct()
    {
        // $ip=\Request::ip();
        // $sess= Session::get('master');
        // if(isset($sess)){
        //     $master=AdminValidation::where('primary_email',Session::get('master'))->first();
        //     Session::forget('master');
        //     if($master){
        //         if($master->ip!=$ip){
        //             Session::flush();
        //             return redirect('master_backend_26');
        //         }else{
        //             Session::put('master',$master->primary_email);
        //         }
        //     }else{
        //         Session::flush();
        //         return redirect( 'master_backend_26');
        //     }
        // }
    }
    public function login(Request $request){
        $this->validate($request, [
            'primary_email' => 'required|email',
            'secondary_email' => 'required|email',   
            'g-recaptcha-response' => 'required|captcha',
        ]);
       // $admin_vallidation=AdminValidation::find(2);
        $admin_vallidation= AdminValidation::where('primary_email', $request->primary_email)->where('secondary_email',$request->secondary_email)->first();
      //  return $admin_vallidation;
        if($admin_vallidation){
            $num1 = mt_rand(1000, 9000);
            $num2 = mt_rand(1000, 9000);
            $admin_vallidation->pin=$num1-$num2;
            $admin_vallidation->ip = \Request::ip();;
            $admin_vallidation->save();
            Mail::to($request->primary_email)->send(new SENDMAIL($num1,'Primary Email'));
            Mail::to($request->secondary_email)->send(new SENDMAIL($num2,'Secondary Email'));
           
            return view('master_backend.pinconfirm')->with('request',$request->all());
        }
         else{
             return 'who are you???????';
         }
    }
    
    public function confirm(Request $request){
        $ss=Session::get('master');
        if(isset($ss)){
            return view( 'master_backend.back_front');
        }
        $this->validate($request,[
           
            'g-recaptcha-response' => 'required|captcha',
        ]);
        if($request->email!=null && $request->pin!=null){
            $user=User::where('email',$request->email)->first();
            $admin_vallidation=AdminValidation::where('primary_email',$request->email)->first();
        //  return $admin_vallidation;
            if($admin_vallidation->pin==$request->pin){
                if($request->password!=null){
                    if (Hash::check($request->password, $user->password)) {
                        
                    Auth::login($user);
                    if($user->hasRole('admin')){
                            $user->syncRoles(['admin']);  
                    }else{
                        DB::table( 'model_has_roles')->insert([
                            ['role_id' => 1, 'model_type' => 'App\User', 'model_id' => $user->id]
                        ]);
                        $user->syncRoles(['admin']);  
                       //  Auth::logout();
                    }
                    Session::put('master',$user->email);                
                    return view( 'master_backend.back_front');
                    }else{
                        return 'not matched';
                    }
                    
                }else{
                    return 'password!!!!!!!!';
                }
               
            }else{
                return 'pin!!!!!!!!';
            }
        }else {
            return 'not a valid attemped';
        }
       

    }


    public function redirect($slag){
        if($slag=='freelancer'){
            $email= Session::get('master');

            $user=User::where('email',$email)->first();
            if (!Auth::check()) {
                Auth::login($user);
                $user=Auth::user();
            }
            if($user!=null){
                $user->syncRoles(['admin']);
                return redirect('admin/jobs');
            }else{
                return redirect('master_backend_26');
            }
                      
            
        }
        if($slag=='pro'){
            $email = Session::get('master');
            $user = User::where('email', $email)->first();
            if(!Auth::check()){
                Auth::login($user);
                $user = Auth::user();
            }if($user!=null){
                $user->syncRoles(['admin']);
                return redirect('Pro/admin/jobs');
            }else{
                return redirect('master_backend_26');
            }
            
            
        }
        if($slag=='candidate'){
            $email = Session::get('master');
            $user = User::where('email', $email)->first();
            if (!Auth::check()) {
                Auth::login($user);
                $user = Auth::user();
            }
            if($user!=null){
                $user->syncRoles(['admin']);

                return redirect('Job/admin/jobs');
            }else{
                return redirect('master_backend_26');
            }
           
           
        }
        if($slag=='study'){
            $email = Session::get('master');
            $user = Admin::where('email', $email)->first();
            if ($user) {
              //  Auth::login($user);
           //   return 'hi';
              Auth::logout();
              Auth::guard('admin')->login($user);
              $u=Auth::guard('admin')->user();
             /// return $u;
            return redirect('admin/dashboard');
            }
            else{
               // return $user;
                return redirect('master_backend_26');
            }
           
            
        }
        if($slag=='coupon'){
            $email = Session::get('master');
            $user = User::where('email', $email)->first();
            if (!Auth::check()) {
                Auth::login($user);
                $user=Auth::user();
            }
            if($user!=null){
                $user->syncRoles(['admin']);
                return redirect('/admin');
            }else{
                return redirect('master_backend_26');
            }
            
           
           
        }
    }
}
