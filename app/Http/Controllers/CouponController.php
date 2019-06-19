<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\CouponCategory;
use App\ForumCategory;
use App\Discussion;
use App\Store;
use App\User;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$coupon = Coupon::orderBy('created_at','desc')->get();
		return view('coupon.admin.coupon.index', compact('coupon'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{		
		$all_users = User::where('is_active','1')->pluck('name','id')->all();
		$cat_coupon = ForumCategory::where('is_active','1')->where('category','c')->pluck('title','id')->all();		
		$cat_deal = ForumCategory::where('is_active','1')->where('category','d')->pluck('title','id')->all();	
		$all_category = CouponCategory::where('is_active','1')->pluck('title','id')->all();		
		$all_store = Store::where('is_active','1')->pluck('title','id')->all();
		return view('coupon.admin.coupon.create', compact('all_users','all_category','all_store','cat_coupon','cat_deal'));
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
			'title' => 'required|min:3',
			'detail' => 'required|min:3',
			'price' => 'nullable|numeric',
			'discount' => 'nullable|numeric',
			'link' => 'nullable|regex:#^https?://#',
			'image' => 'nullable|image|mimes:jpg,png,gif,jpeg',
		]);

		$input = $request->all();

		if (isset($input['type']))
    {
      $request->validate([
				'code' => 'required'
			]);
    }

		if (!isset($input['type']))
    {
      $input['type'] = 'd';
    }
    else{
    	$input['type'] = 'c';
    }

		if ($file = $request->file('image')) {
			
			$optimizeImage = Image::make($file);
      $optimizePath = public_path().'/coupon/images/coupon/';
      $name = time().$file->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 72);

			$input['image'] = $name;

		}

		if (!isset($input['is_featured']))
    {
      $input['is_featured'] = 0;
    }
    if (!isset($input['is_exclusive']))
    {
      $input['is_exclusive'] = 0;
    }
    if (!isset($input['is_verified']))
    {
      $input['is_verified'] = 0;
    }
    if (!isset($input['is_active']))
    {
      $input['is_active'] = 0;
    }

		$coupon = Coupon::create($input);

		$coupon->slug = str_slug($input['title'],'-');

		$uni_col = collect();
		$uni_col->push(Coupon::pluck('uni_id'));
		$uni_col->push(Discussion::pluck('uni_id'));
		$uni_col = array($uni_col->flatten());

		do {
		  $random = str_random(5);
		} while (in_array($random, $uni_col));

		$coupon->uni_id = $random;

    $coupon->save();

		return back()->with('added', 'Coupon has been added');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Coupon  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Coupon  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{		
		$coupon = Coupon::findOrFail($id);		
		$all_users = User::where('is_active','1')->pluck('name','id')->all();
		$cat_coupon = ForumCategory::where('is_active','1')->where('category','c')->pluck('title','id')->all();	
		$cat_deal = ForumCategory::where('is_active','1')->where('category','d')->pluck('title','id')->all();	
		$all_category = CouponCategory::where('is_active','1')->pluck('title','id')->all();		
		$all_store = Store::where('is_active','1')->pluck('title','id')->all();
		return view('coupon.admin.coupon.edit', compact('coupon','all_users','all_category','all_store','cat_coupon','cat_deal'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Coupon  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'title' => 'required|min:3',
			'detail' => 'required|min:3',
			'price' => 'nullable|numeric',
			'discount' => 'nullable|numeric',
			'link' => 'nullable|regex:#^https?://#',
			'image' => 'nullable|image|mimes:jpg,png,gif,jpeg',
		]);

		$coupon = Coupon::findOrFail($id);

		$input = $request->all();

		if (isset($input['type']))
    {
      $request->validate([
				'code' => 'required'
			]);
    }

		if (!isset($input['type']))
    {
      $input['type'] = 'd';
    }
    else{
    	$input['type'] = 'c';
    }

    if($coupon->type == 'c' && $input['type'] == 'd')
    {
      $input['code'] = null;
    }

		if ($file = $request->file('image')) {
			
			if ($coupon->image != null) {
				
				$image_file = @file_get_contents(public_path().'/coupon/images/coupon/'.$coupon->image);

				if($image_file){		
					unlink(public_path().'/coupon/images/coupon/'.$coupon->image);
				}

			}

			$optimizeImage = Image::make($file);
      $optimizePath = public_path().'/coupon/images/coupon/';
      $name = time().$file->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 72);

			$input['image'] = $name;

		}
		
		if (!isset($input['is_featured']))
    {
      $input['is_featured'] = '0';
    }
    else{
      $input['is_featured'] = '1';
    }
    if (!isset($input['is_exclusive']))
    {
      $input['is_exclusive'] = '0';
    }
    else{
      $input['is_exclusive'] = '1';
    }
    if (!isset($input['is_verified']))
    {
      $input['is_verified'] = '0';
    }
    else{
      $input['is_verified'] = '1';
    }
    if (!isset($input['is_active']))
    {
      $input['is_active'] = '0';
    }
    else{
      $input['is_active'] = '1';
    }
    
		$coupon->update($input);
		$coupon->slug = str_slug($input['title'],'-');

    $coupon->save();

		return redirect('admin/coupon')->with('updated', 'Coupon has been updated');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Coupon  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$coupon = Coupon::findOrFail($id);

		$coupon->comments()->delete();

    $coupon->likes()->delete();

		if ($coupon->image != null) {

			$image_file = @file_get_contents(public_path().'/coupon/images/coupon/'.$coupon->image);

				if($image_file){		
					unlink(public_path().'/coupon/images/coupon/'.$coupon->image);
				}
		}

		$coupon->delete();

		return back()->with('deleted', 'Coupon has been deleted');
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

		return back()->with('deleted', 'Coupon has been deleted');   
	}

 public function dropdown(Request $request) 
  {
    $state = $request['state'];
    if($state == 'true'){
    	$drop = ForumCategory::where('is_active','1')->where('category','c')->pluck('title','id')->all();
    }
    else{
    	$drop = ForumCategory::where('is_active','1')->where('category','d')->pluck('title','id')->all();
    }
    return response()->json($drop);
  }

}
