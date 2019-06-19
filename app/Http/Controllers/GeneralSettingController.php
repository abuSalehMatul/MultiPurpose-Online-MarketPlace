<?php

namespace App\Http\Controllers;

use App\Model\Trx;
use App\Model\Wallet;
use App\Model\WithdrawLog;
use Illuminate\Http\Request;
use Auth;
use App\Model\GeneralSettings;
use App\User;
use App\Admin;
use App\Model\UserLogin;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use File;
use Image;
use App\Model\Deposit;


class GeneralSettingController extends Controller
{

	public function __construct(){
		$Gset = GeneralSettings::first();
		$this->sitename = $Gset->sitename;
	}
	public function index(){
		$data['page_title'] = "Basic Settings";
		return view('admin.loginform', $data);
	}
	public function GenSetting(){
		$data['page_title'] = 'General Settings';
			$data['general'] = GeneralSettings::first();
		return view('admin.webcontrol.general', $data);
	}

	public function UpdateGenSetting(Request $request)
    {
        $request->validate([
            'sitename' => 'required',
        ]);
//        return $request->all();

        $gs = GeneralSettings::first();
        $in = Input::except('_token');
        $in['color'] = ltrim($request->color,'#');
        $in['color2'] = ltrim($request->color2,'#');
        $in['hover'] = ltrim($request->hover,'#');
//        $in['captcha'] = $request->captcha == 'on' ? '1' : '0';
        $in['email_notification'] = $request->email_notification == 'on' ? '1' : '0';
        $res = $gs->fill($in)->save();

			if ($res) {
				return back()->with('success', 'Updated Successfully!');
			}else{
				return back()->with('alert', 'Problem With Updating');
			}
	}
	
	
    public function changePassword()
    {
        $data['page_title'] = "Change Password";
        return view('admin.webcontrol.change_password',$data);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'password_confirmation' => 'required|same:new_password',
        ]);

        $user = Auth::guard('admin')->user();

        $oldPassword = $request->old_password;
        $password = $request->new_password;
        $passwordConf = $request->password_confirmation;

        if (!Hash::check($oldPassword, $user->password) || $password != $passwordConf) {
            $notification =  array('message' => 'Password Do not match !!', 'alert-type' => 'error');
            return back()->with($notification);
        }elseif (Hash::check($oldPassword, $user->password) && $password == $passwordConf)
        {
            $user->password = bcrypt($password);
            $user->save();
            $notification =  array('message' => 'Password Changed Successfully !!', 'alert-type' => 'success');
            return back()->with($notification);
        }
    }


    public function profile()
    {
        $data['admin'] = Auth::user();
        $data['page_title'] = "Profile Settings";
        return view('admin.webcontrol.profile',$data);
    }

    public function updateProfile(Request $request)
    {
        $data = Admin::find($request->id);
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|max:50|unique:admins,email,'.$data->id,
            'mobile' => 'required|regex:/(01)[0-9]{9}/',
        ]);

        $in = Input::except('_method','_token');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = 'admin_'.time().'.jpg';
            $location = 'assets/admin/img/' . $filename;
            Image::make($image)->resize(300,300)->save($location);
            $path = './assets/admin/img/';
            File::delete($path.$data->image);
            $in['image'] = $filename;
        }
        $data->fill($in)->save();

        $notification =  array('message' => 'Profile Update Successfully', 'alert-type' => 'success');
        return back()->with($notification);
    }



}
