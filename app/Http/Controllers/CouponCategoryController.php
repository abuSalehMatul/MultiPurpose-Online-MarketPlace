<?php

namespace App\Http\Controllers;

use App\CouponCategory;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponCategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{        
		$category = CouponCategory::all();
		return view('coupon.admin.category.index', compact('category'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('coupon.admin.category.create');
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
			'title' => 'required|min:3|unique:categories',
			'image' => 'nullable|image|mimes:jpg,png,gif,jpeg'
		]);

		if($request->icon == null && !$request->hasFile('image')){
			return back()->with('deleted', 'Please add category icon or image');
		}

		$input = $request->all();
		
		if (isset($input['is_active']) && $input['is_active'] == '1')
    {
      $input['is_active'] = 1;
    }
    else{
    	$input['is_active'] = 0;
    }

		if ($input['icon']){

			$input['image'] = null;

		}
		elseif ($file = $request->file('image')) {
			
			$optimizeImage = Image::make($file);
      $optimizePath = public_path().'/coupon/images/category/';
      $name = time().$file->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 72);

			$input['image'] = $name;

		}

		$slug = str_slug($input['title'],'-');

		$data = CouponCategory::create($input);

		$data->slug = $slug;

    $data->save();

		return back()->with('added', 'Category has been added');

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Category  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Category  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
	   $category = CouponCategory::findOrFail($id);
		return view('coupon.admin.category.edit', compact('category'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Category  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'title' => 'required|min:3|unique:categories,title,'.$id,
			'image' => 'nullable|image|mimes:jpg,png,gif,jpeg'
		]);
		
		if($request->icon == null && !$request->hasFile('image')){
			return back()->with('deleted', 'Please add category icon or image');
		}
		
		$category = CouponCategory::findOrFail($id);

		$input = $request->all();

		if (isset($input['is_active']) && $input['is_active'] == 'on')
    {
      $input['is_active'] = 1;
    }
    else{
    	$input['is_active'] = 0;
    }

		if($input['icon']){

			if ($category->image != null) {

				$image_file = @file_get_contents(public_path().'/coupon/images/category/'.$category->image);

				if($image_file){
					unlink(public_path().'/coupon/images/category/'.$category->image);
				}
			}

			$input['image'] = Null;

		}
		elseif($file = $request->file('image')) {
			
			if ($category->image != null) {

				$image_file = @file_get_contents(public_path().'/coupon/images/category/'.$category->image);

				if($image_file){

					unlink(public_path().'/coupon/images/category/'.$category->image);
				}

			}

			$optimizeImage = Image::make($file);
      $optimizePath = public_path().'/coupon/images/category/';
      $name = time().$file->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 72);

			$input['image'] = $name;

		}

		$category->update($input);

		$slug = str_slug($input['title'],'-');

    $category->slug = $slug;

    $category->save();

		if($category->is_active == 0){
			foreach($category->coupon as $coupon){
				$coupon->update([
					'is_active' => 0
				]);
			}
		}
		else{
			foreach($category->coupon as $coupon){
				$coupon->update([
					'is_active' => 1
				]);
			}
		}
		return redirect('admin/category')->with('updated', 'Category has been updated');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Category  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$category = CouponCategory::findOrFail($id);

		if(isset($category->coupon)){
			foreach($category->coupon as $coupon){
				$coupon->comments()->delete();	
				$coupon->likes()->delete();
			}
		}
		if(isset($category->discussion)){
			foreach($category->discussion as $discussion){
				$discussion->comments()->delete();	
				$discussion->likes()->delete();
			}
		}

		if ($category->image != null) {
				
			$image_file = @file_get_contents(public_path().'/coupon/images/category/'.$category->image);

				if($image_file){
					
					unlink(public_path().'/coupon/images/category/'.$category->image);
				}

		}

		$category->delete();

		return back()->with('deleted', 'Category has been deleted');
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

		return back()->with('deleted', 'Category has been deleted');   
	}
}

