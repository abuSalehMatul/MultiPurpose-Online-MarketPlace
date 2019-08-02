<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Auth;
use App\User;
use Session;
class SuperAdminController extends Controller
{
    public function test(){
        Session::flush();
        Auth::guard('admin')->logout();
        return 'hi';
        $permission = Permission::create(['name' => 'pro_module']);
        $permission = Permission::create(['name' => 'job_module']);
        $permission = Permission::create(['name' => 'freelancer_module']);
        $permission = Permission::create(['name' => 'learn_module']);
        $permission = Permission::create(['name' => 'community_module']);
        $permission = Permission::create(['name' => 'chore_module']);
        $permission = Permission::create(['name' => 'payout_module']);
        $permission = Permission::create(['name' => 'user_management_module']);
        $permission = Permission::create(['name' => 'settings_module']);
        $permission = Permission::create(['name' => 'message_module']);
        $permission = Permission::create(['name' => 'server_module']);
       
    }
    public function see_permission(){
        $permission=DB::table('permissions')->get();
        return view('backend.permission')->with('permission',$permission);
    }
    public function all_permission(){

    }
    public function get_email(Request $request){
        $user=User::where('email',$request->email)->first();
       // return $request;
        if($user){
           
            $arr=$user->getPermissionNames();
           
        }else{
            return 'false';
        }
        return $arr;
    }
    public function set_permission(Request $request){
        $data = DB::table('permissions')->get();
        
        $user=User::where('email',$request->email)->first();
    
       
        foreach($data as $data){
            $name=$data->name;
            if($request->$name=='on'){
                $check=DB::table('model_has_permissions')->where('permission_id',$data->id)->where('model_id',$user->id)->first();
                if(!$check){
                    DB::table('model_has_permissions')->insert(
                        ['model_id' => $user->id, 'model_type' => 'App\User' , 'permission_id'=> $data->id]
                    );
                }
               
            }else {
                $check=DB::table('model_has_permissions')->where('permission_id',$data->id)->where('model_id',$user->id)->first();
                if($check){
                    DB::table('model_has_permissions')->where('permission_id', $data->id)->where('model_id', $user->id)->delete();
                }
            }
           
        }
        return redirect()->back();
    }
}
