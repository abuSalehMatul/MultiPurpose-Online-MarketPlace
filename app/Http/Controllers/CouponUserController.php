<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CouponUserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// $auth = Auth::user();
		// $user = User::where('id', '!=', $auth->id)->get();
		$user = User::all();
		return view('coupon.admin.user.index', compact('user'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		// $countries = Country::pluck('name', 'id')->all();
		return view('coupon.admin.user.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
		  'name' => 'required',
		  'image' => 'nullable|image|mimes:jpeg,png,jpg',
		  'email' => 'required|email|unique:users',
		  'password' => 'required'
		]);

		$input = $request->all();

		$input['password'] = bcrypt($request->password);

		if ($file = $request->file('image')) {
		  $optimizeImage = Image::make($file)->resize(100, null);
      $optimizePath = public_path().'/coupon/images/user/';
      $name = time().$file->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 72);
		  $input['image'] = $name;
		}

		$user = User::create($input);

		flash('User has been added')->success();

		return back();

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$user = User::findOrFail($id);        
		return view('coupon.admin.user.edit', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
		  'name' => 'required',
		  'mobile' => 'numeric',
		  'email' => 'required|email|unique:users,email,'.$id,
		  'image' => 'nullable|image|mimes:jpeg,png,jpg',
		]);
			
		$user = User::findOrFail($id);

		$input = $request->all();

		if ($request->password !== '' || $request->password != null)
		{
		  $input['password'] = bcrypt($request->password);
		}

		if ($file = $request->file('image')) {

		  if ($user->image != null && $user->image != 'user.png') {
		
				$image_file = @file_get_contents(public_path().'/coupon/images/user/'.$user->image);

				if($image_file){
				  
				  unlink(public_path().'/coupon/images/user/'.$user->image);
				}
		  }

		  $optimizeImage = Image::make($file)->resize(100, null);
      $optimizePath = public_path().'/coupon/images/user/';
      $name = time().$file->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 72);

		  $input['image'] = $name;

		}

		$user->update($input);

		flash('User has been updated')->info();

		return redirect('admin/user');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$user = User::findOrFail($id);

		if(isset($user->coupon)){
			foreach($user->coupon as $coupon){
				$coupon->comments()->delete();	
				$coupon->likes()->delete();
			}
		}
		if(isset($user->discussion)){
			foreach($user->discussion as $discussion){
				$discussion->comments()->delete();	
				$discussion->likes()->delete();
			}
		}

		if ($user->image != null && $user->image != 'user.png') {
		
		  $image_file = @file_get_contents(public_path().'/coupon/images/user/'.$user->image);

		  if($image_file){
			
			unlink(public_path().'/coupon/images/user/'.$user->image);
		  }
		}

		$user->delete();
		flash('User has been deleted')->error();
		return back();
	}


	public function confirm($confirmation_code)
	{

		if( ! $confirmation_code)
		{
			throw new InvalidConfirmationCodeException;
		}

		$user = User::whereConfirmationCode($confirmation_code)->first();

		if ( ! $user)
		{
			throw new InvalidConfirmationCodeException;
		}

		$user->confirmed = 1;
		$user->confirmation_code = null;
		$user->save();

		flash('Welcome back! your email has been verified successfully')->success();

		return redirect('login');
	}

	public function bulk_delete(Request $request)
	{
	  $validator = Validator::make($request->all(), [
		'checked' => 'required',
	  ]);

	  if ($validator->fails()) {

		return back()->with('deleted', 'Please select one of them to delete');
	  }

	  foreach ($request->checked as $checked) {

		$this->destroy($checked);
		
	  }

	  return back()->with('deleted', 'User has been deleted');   
	}
}
