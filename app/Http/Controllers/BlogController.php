<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Tag;
use App\User;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{        
		$blog = Blog::orderBy('created_at','desc')->get();
		return view('coupon.admin.blog.index', compact('blog'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{        
		$tags = Tag::pluck('title','id')->all();
		$all_user = User::where('is_active','1')->pluck('name','id')->all();
		return view('coupon.admin.blog.create',compact('tags','all_user'));
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
			'title' => 'required',
			'desc' => 'required|min:3',
			'tag' => 'required',
			'image' => 'required|image|mimes:jpg,png,gif,jpeg',
		]);

		$input = $request->all();

    if (isset($input['is_active']) && $input['is_active'] == '1')
    {
      $input['is_active'] = 1;
    }
    else{
    	$input['is_active'] = 0;
    }

		if($image = $request->file('image')){
			$optimizeImage = Image::make($image);
      $optimizePath = public_path().'/coupon/images/blog/';
      $name = time().$image->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 70);
			
			$input['image'] = $name;
		}

		$blog = Blog::create($input);

		$blog->slug = str_slug($input['title'],'-');

		$uni_col = array(Blog::pluck('uni_id'));

		do {
		  $random = str_random(5);
		} while (in_array($random, $uni_col));

		$blog->uni_id = $random;

		$tag_list = Tag::all();

		foreach($request->tag as $tag){
			if (substr($tag, 0, 4) == 'new:'){
				$tit = substr($tag, 4);
				$exist_tag = $tag_list->where('title',$tit)->first();
				if($exist_tag != null){
					$tags[] = $exist_tag->id;
				}
				else{                   
					$tag_id = Tag::create(['title'=> $tit,'slug'=>str_slug($tit,'-')]);
					$tags[] = $tag_id->id;
				}
			}
			else{				
				$tags[] = (int)$tag;
			}			
		}

		$blog->tags()->syncWithoutDetaching($tags);
			
		$blog->save();
	  
		return back()->with('added', 'Blog Image has been added');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Blog  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Blog  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$blog = Blog::findOrFail($id); 
		$tags = Tag::pluck('title','id')->all();
		$ta = $blog->tags()->pluck('tag_id')->all();
		$all_user = User::where('is_active','1')->pluck('name','id')->all();
		return view('coupon.admin.blog.edit', compact('blog','tags','ta','all_user'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Blog  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'title' => 'required',
			'desc' => 'required|min:3',
			'tag' => 'required',
			'image' => 'nullable|image|mimes:jpg,png,gif,jpeg',
		]);

		$blog = Blog::findOrFail($id);
		
		$input = $request->all(); 

		if (isset($input['is_active']) && $input['is_active'] == '1')
    {
      $input['is_active'] = 1;
    }
    else{
    	$input['is_active'] = 0;
    }

		if($image = $request->file('image')){
			$optimizeImage = Image::make($image);
      $optimizePath = public_path().'/coupon/images/blog/';
      $name = time().$image->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 70);
			
			$input['image'] = $name;
		}

		$tag_list = Tag::all();

		foreach($request->tag as $tag){
			if (substr($tag, 0, 4) == 'new:'){
				$tit = substr($tag, 4);
				$exist_tag = $tag_list->where('title',$tit)->first();
				if($exist_tag != null){
					$tags[] = $exist_tag->id;
				}
				else{                   
					$tag_id = Tag::create(['title'=> $tit, 'slug' => str_slug($tit,'-')]);
					$tags[] = $tag_id->id;
				}
			}
			else{				
				$tags[] = (int)$tag;
			}			
		}

		$blog->update($input);
		$blog->slug = str_slug($input['title'],'-');
		$blog->save();
		$blog->tags()->detach();
		$blog->tags()->syncWithoutDetaching($tags);

		return redirect('admin/blog')->with('updated', 'Blog Image has been updated');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Blog  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$blog = Blog::findOrFail($id);

		$blog->comments()->delete();

		if ($blog->image != null) {				
			$image_file = @file_get_contents(public_path().'/coupon/images/blog/'.$blog->image);
			if($image_file){				
				unlink(public_path().'/coupon/images/blog/'.$blog->image);
			}
		}
		$blog->delete();

		return back()->with('deleted', 'Blog Image has been deleted');
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

		return back()->with('deleted', 'Blog Image has been deleted');   
	}

}
