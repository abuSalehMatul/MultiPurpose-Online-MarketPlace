<?php

namespace App\Http\Controllers;

use App\Store;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{        
		$store = Store::all();
		return view('coupon.admin.store.index', compact('store'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('coupon.admin.store.create');
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
			'title' => 'required|min:3|unique:stores',
			'link' => 'required',
			'image' => 'required|image|mimes:jpg,png,gif,jpeg',
			'link' => 'regex:#^https?://#'
		]);

		$input = $request->all();

		if (isset($input['is_active']) && $input['is_active'] == '1')
    {
      $input['is_active'] = 1;
    }
    else{
    	$input['is_active'] = 0;
    }
    if (isset($input['is_featured']) && $input['is_featured'] == '1')
    {
      $input['is_featured'] = 1;
    }
    else{
    	$input['is_featured'] = 0;
    }
	
		$slug = str_slug($input['title'],'-');

		if ($file = $request->file('image')) {
			
			$optimizeImage = Image::make($file);
      $optimizePath = public_path().'coupon/images/store/';
      $name = time().$file->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 72);

			$input['image'] = $name;

		}

		$data = Store::create($input);

		$data->slug = $slug;

    $data->save();

		return back()->with('added', 'Store has been added');

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Store  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Store  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
	   $store = Store::findOrFail($id);
		return view('coupon.admin.store.edit', compact('store'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Store  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'title' => 'required|min:3|unique:stores,title,'.$id,
			'link' => 'required',
			'image' => 'nullable|image|mimes:jpg,png,gif,jpeg',
			'link' => 'regex:#^https?://#'
		]);

		$store = Store::findOrFail($id);

		$input = $request->all();

		if (isset($input['is_active']) && $input['is_active'] == 'on')
    {
      $input['is_active'] = 1;
    }
    else{
    	$input['is_active'] = 0;
    }
    if (isset($input['is_featured']) && $input['is_featured'] == 'on')
    {
      $input['is_featured'] = 1;
    }
    else{
    	$input['is_featured'] = 0;
    }

		if ($file = $request->file('image')) {

			if ($store->image != null) {
				
				$image_file = @file_get_contents(public_path().'coupon/images/store/'.$store->image);

				if($image_file){
					unlink(public_path().'coupon/images/store/'.$store->image);
				}

			}

			$optimizeImage = Image::make($file);
      $optimizePath = public_path().'coupon/images/store/';
      $name = time().$file->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 72);

			$input['image'] = $name;

		}

		$store->update($input);

		$slug = str_slug($input['title'],'-');

    $store->slug = $slug;

    $store->save();
		
		if($store->is_active == 0){
			foreach($store->coupon as $coupon){
				$coupon->update([
					'is_active' => 0
				]);
			}
		}
		else{
			foreach($store->coupon as $coupon){
				$coupon->update([
					'is_active' => 1
				]);
			}
		}

		return redirect('admin/store')->with('updated', 'Store has been updated');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Store  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$store = Store::findOrFail($id);

		if(isset($store->coupon)){
			foreach($store->coupon as $coupon){
				$coupon->comments()->delete();	
				$coupon->likes()->delete();
			}
		}
		if(isset($store->discussion)){
			foreach($store->discussion as $discussion){
				$discussion->comments()->delete();	
				$discussion->likes()->delete();
			}
		}

		if ($store->image != null) {
				
			$image_file = @file_get_contents(public_path().'coupon/images/store/'.$store->image);

			if($image_file){        
				$image_file = @file_get_contents(public_path().'coupon/images/store/'.$store->image);
				if($image_file){
					unlink(public_path().'coupon/images/store/'.$store->image);
				}
			}

		}

		$store->delete();

		return back()->with('deleted', 'Store has been deleted');
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

		return back()->with('deleted', 'Store has been deleted');   
	}
}

