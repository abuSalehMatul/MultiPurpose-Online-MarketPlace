<?php

namespace App\Http\Controllers;

use App\Discussion;
use App\User;
use App\ForumCategory;
use App\Coupon;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscussionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$discussion = Discussion::all();
		return view('coupon.admin.discussion.index', compact('discussion'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{       
		$all_users = User::where('is_active','1')->pluck('name','id')->all(); 
		$cat_discussion = ForumCategory::where('is_active','1')->where('category','g')->pluck('title','id')->all(); 
		return view('coupon.admin.discussion.create', compact('all_users','cat_discussion'));
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
			'image' => 'nullable|image|mimes:jpg,png,gif,jpeg',
		]);

		$input = $request->all();

		if ($file = $request->file('image')) {
			
			$optimizeImage = Image::make($file);
      $optimizePath = public_path().'/coupon/images/discussion/';
      $name = time().$file->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 72);

			$input['image'] = $name;

		}

		if (isset($input['is_featured']) && $input['is_featured'] == '1')
    {
      $input['is_featured'] = 1;
    }
    else{
    	$input['is_featured'] = 0;
    }
    if (isset($input['is_active']) && $input['is_active'] == '1')
    {
      $input['is_active'] = 1;
    }
    else{
    	$input['is_active'] = 0;
    }

		$discussion = Discussion::create($input);

		$discussion->slug = str_slug($input['title'],'-');

		$uni_col = collect();
		$uni_col->push(Coupon::pluck('uni_id'));
		$uni_col->push(Discussion::pluck('uni_id'));
		$uni_col = array($uni_col->flatten());

		do {
		  $random = str_random(5);
		} while (in_array($random, $uni_col));

		$discussion->uni_id = $random;

    $discussion->save();

		return back()->with('added', 'Discussion has been added');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Discussion  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Discussion  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{        
		$discussion = Discussion::findOrFail($id);
		$all_users = User::where('is_active','1')->pluck('name','id')->all();
		$cat_discussion = ForumCategory::where('is_active','1')->where('category','g')->pluck('title','id')->all();   
		return view('coupon.admin.discussion.edit', compact('discussion','all_users','cat_discussion'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Discussion  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'title' => 'required|min:3',
			'detail' => 'required|min:3',
			'image' => 'nullable|image|mimes:jpg,png,gif,jpeg',
		]);

		$discussion = Discussion::findOrFail($id);

		$input = $request->all();

		if (isset($input['is_featured']) && $input['is_featured'] == 'on')
    {
      $input['is_featured'] = 1;
    }
    else{
    	$input['is_featured'] = 0;
    }
    if (isset($input['is_active']) && $input['is_active'] == 'on')
    {
      $input['is_active'] = 1;
    }
    else{
    	$input['is_active'] = 0;
    }

		if ($file = $request->file('image')) {

			if ($discussion->image != null && $discussion->image != 'default.png') {
				
				$image_file = @file_get_contents(public_path().'/coupon/images/discussion/'.$discussion->image);

				if($image_file){        
					unlink(public_path().'/coupon/images/discussion/'.$discussion->image);
				}

			}

			$optimizeImage = Image::make($file);
      $optimizePath = public_path().'/coupon/images/discussion/';
      $name = time().$file->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 72);

			$input['image'] = $name;

		}

		$discussion->update($input);

		$discussion->slug = str_slug($input['title'],'-');

    $discussion->save();

		return redirect('admin/discussion')->with('updated', 'Discussion has been updated');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Discussion  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$discussion = Discussion::findOrFail($id);

		$discussion->comments()->delete();

    $discussion->likes()->delete();

		if ($discussion->image != null && $discussion->image != 'default.png') {
				
			$image_file = @file_get_contents(public_path().'/coupon/images/discussion/'.$discussion->image);

			if($image_file){        
				unlink(public_path().'/coupon/images/discussion/'.$discussion->image);
			}

		}

		$discussion->delete();

		return back()->with('deleted', 'Discussion has been deleted');
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

		return back()->with('deleted', 'Discussion has been deleted');   
	}

	// public function createSlug($title,$id)
 //  {
 //    $slug = str_slug($title,'-');
 //    $data = Discussion::where('slug',$slug)->first();
 //    $data1 = Coupon::select('slug')->where('slug', 'like', $slug.'%')
 //        				->where('id', '<>', $id)->get();
 //    if (! $data && ! $data1->contains('slug', $slug)){
 //      return $slug;
 //    }
 //    else{
 //    	return $slug.'-'.$id;
 //    }
 //  }

	// public function createSlug($title, $id = 0)
 //  {
 //    $slug = str_slug($title);
 //    $allSlugs = $this->getRelatedSlugs($slug, $id);
 //    if (! $allSlugs->contains('slug', $slug)){
 //      return $slug;
 //    }
 //    for ($i = 1; $i <= 10; $i++) {
 //      $newSlug = $slug.'-'.$i;
 //      if (! $allSlugs->contains('slug', $newSlug)) {
 //          return $newSlug;
 //      }

 //    }
 //    throw new \Exception('Can not create a unique slug');
 //  }
 //  public function getRelatedSlugs($slug, $id = 0)
 //  {
 //    return Discussion::select('slug')->where('slug', 'like', $slug.'%')
 //        				->where('id', '<>', $id)->get();
 //  }
}

