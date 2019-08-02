<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Verification;
use Mail;
use App\Mail\RESETPIN;
use Illuminate\Support\Str;
use Session;

class CustomVerificationController extends Controller
{
   public function pin(Request $request){
       if( $request->guest=='guest' || !Auth::check()){
           Auth::logout();
            if ($request->type == 'freelancer') {
                return redirect('freelancer-dashboard');
            }
            if ($request->type == 'pro') {
                return redirect('pro');
            }
            if ($request->type == 'job') {
                return redirect('job');
            }
            if ($request->type == 'community') {
                return redirect('coupon-dashboard');
            }
            if ($request->type == 'learn') {
                return redirect('learn-and-grow');
            }
            if ($request->type == 'chore') {
                return redirect('chores/view');
            }
            if ($request->type == 'scolarship') {
                return redirect();
            }
       }
        $user = Auth::user();
        $check = Verification::where('user_id', $user->id)->where('pin', '!=', Null)->latest()->first();
        if($check){
            $this->validate($request,[
                'pin' => 'required',
            ]);
            if($check->pin== $request->pin){
                if($request->type == 'freelancer'){
                    return redirect('freelancer-dashboard');
                }
                if($request->type == 'pro'){
                    return redirect('pro');
                }
                if($request->type == 'job'){
                    return redirect('job');
                }
                if($request->type == 'community'){
                    return redirect('coupon-dashboard');
                }
                if($request->type == 'learn'){
                    return redirect('learn-and-grow');
                }
                if($request->type == 'chore'){
                    return redirect('chores/view');
                }
                if($request->type == 'scolarship'){
                    return redirect();
                }
            }else{
                $request->session()->flash('message', 'Invalid');
                return redirct()->back();
            }
        }else{
            $request->session()->flash('message', 'Invalid');
            return redirect()->back();
        }
       
   }
   public function pin_check(Request $request){
       
        if(Auth::user()){
            $user=Auth::user();
            $check=Verification::where('user_id',$user->id)->where('pin','!=',Null)->latest()->first();
            if(!$check){
                return 'false';
            }else{
                return 'true';
            }
        }else{
            return 'false';
        }
   }
   public function reset(){
        $data = Str::random(60);
        Session::put('str', $data);
        if(Auth::check()){
            $user=Auth::user();
            Mail::to($user->email)->send(new RESETPIN( $user, $data));
            return 'we have sent you an email';
        }else{
            return 'login first';
        }

       
   }
   public function reset_conf($str){
        $data=Session::get('str');
        Session::forget('str');
        if($data==$str){
            return redirect('reset_form');
        }else{
            return 'something went wrong. Please tyr from the begining';
        }
   }
   public function reset_form_conf(Request $request){
       $user = Auth::user();
       $this->validate($request,[
        'pin'=>'required'
       ]);
       $valid= new Verification;
       $valid->user_id=$user->id;
       $valid->pin=$request->pin;
       $valid->save();
       return redirect('/'); 
   }
}
