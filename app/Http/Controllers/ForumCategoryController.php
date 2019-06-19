<?php

namespace App\Http\Controllers;

use App\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForumCategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{        
		$forumcategory = ForumCategory::all();
		return view('coupon.admin.forumcategory.index', compact('forumcategory'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('coupon.admin.forumcategory.create');
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
			'category' => 'required',
			'title' => 'required|min:3|unique:forum_categories',
			'detail' => 'required|min:3'
		]);


		$input = $request->all();

		if (isset($input['is_active']) && $input['is_active'] == '1')
    {
      $input['is_active'] = 1;
    }
    else{
    	$input['is_active'] = 0;
    }

    $slug = str_slug($input['title'],'-');

		$data = ForumCategory::create($input);

    $data->slug = $slug;

    $data->save();

		return back()->with('added', 'Discussion Category has been added');

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  \App\ForumCategory  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\ForumCategory  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
	   $forumcategory = ForumCategory::findOrFail($id);
		return view('coupon.admin.forumcategory.edit', compact('forumcategory'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\ForumCategory  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'category' => 'required',
			'title' => 'required|min:3!unique:forum_categories,title,'.$id,
			'detail' => 'required|min:3'
		]);

		$forumcategory = ForumCategory::findOrFail($id);

		$input = $request->all();

		if (isset($input['is_active']) && $input['is_active'] == 'on')
    {
      $input['is_active'] = 1;
    }
    else{
    	$input['is_active'] = 0;
    }

		$forumcategory->update($input);

 		$slug = str_slug($input['title'],'-');

    $forumcategory->slug = $slug;

    $forumcategory->save();

		if($forumcategory->is_active == 0){
			foreach($forumcategory->discussion as $discussion){
				$discussion->update([
					'is_active' => 0
				]);
			}
			foreach($forumcategory->coupon as $coupon){
				$coupon->update([
					'is_active' => 0
				]);
			}
		}
		else{
			foreach($forumcategory->discussion as $discussion){
				$discussion->update([
					'is_active' => 1
				]);
			}
			foreach($forumcategory->coupon as $coupon){
				$coupon->update([
					'is_active' => 1
				]);
			}
		}

		return redirect('admin/forumcategory')->with('updated', 'Discussion Category has been updated');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\ForumCategory  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$forumcategory = ForumCategory::findOrFail($id);

		if(isset($forumcategory->coupon)){
			foreach($forumcategory->coupon as $coupon){
				$coupon->comments()->delete();	
				$coupon->likes()->delete();
			}
		}
		if(isset($forumcategory->discussion)){
			foreach($forumcategory->discussion as $discussion){
				$discussion->comments()->delete();	
				$discussion->likes()->delete();
			}
		}

		$forumcategory->delete();

		return back()->with('deleted', 'Discussion Category has been deleted');
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
		
		return back()->with('deleted', 'Discussion Category has been deleted');   
	}
}

