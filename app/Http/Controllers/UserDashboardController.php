<?php

namespace App\Http\Controllers;

use App\Store;
use App\CouponCategory;
use App\ForumCategory;
use Auth;
use App\Discussion;
use App\Coupon;
use App\User;
use Image;
use App\Like;
use App\Comment;
use App\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserDashboardController extends Controller
{
	public function confirm($confirmation_code)
	{

    if( ! $confirmation_code)
    {
        throw new InvalidConfirmationCodeException;
    }

    $user = User::whereConfirmationCode($confirmation_code)->first();

    if ( ! $user)
    {
      // throw new InvalidConfirmationCodeException;
      flash('Your email is already verified.')->warning();
      return redirect('/');
    }

    $user->confirmed = 1;
    $user->confirmation_code = null;
    $user->save();

    // $url = env('APP_URL').'/login';

    flash('Welcome back! your email has been verified successfully')->success()->important();

    return redirect('/')->with('success', 'Welcome back! your email has been verified successfully');
	}

	public function deal_submit()
	{
		if (!Auth::check()) {
			return back()->with('error_code','5');
		}
		$all_store = Store::where('is_active','1')->pluck('title','id')->all();
		$all_category = CouponCategory::where('is_active','1')->pluck('title','id')->all();
		$all_type = ForumCategory::where('is_active','1')->get();
		$cat_deal = $all_type->where('category','d')->pluck('title','id')->all();
		$cat_coupon = $all_type->where('category','c')->pluck('title','id')->all();
		$cat_discussion = $all_type->where('category','g')->pluck('title','id')->all();
		return view('coupon.user.submit',compact('all_store','all_category','cat_discussion','cat_deal','cat_coupon'));
	} 
	public function coupon_post(Request $request)
	{
		$auth = Auth::user();  

		$request->validate([
			'title' => 'required|min:3',
			'detail' => 'required|min:3',
			'price' => 'nullable|numeric',
			'discount' => 'nullable|numeric',
			'link' => 'nullable|regex:#^https?://#',
			'image' => 'nullable|image|mimes:jpg,png,gif,jpeg',
		]);

		if($request['type'] == 'c'){ 
			$request->validate(['code' => 'required']);
			$tab='coupon';
		}
		else{
			$tab = 'deal';
		}

		$input = $request->all();

		if ($file = $request->file('image')) {			
			$optimizeImage = Image::make($file);
      $optimizePath = public_path().'/coupon/images/coupon/';
      $name = time().$file->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 72);
			$input['image'] = $name;
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

		flash('Coupon/Deal has been Submitted.')->success()->important();
		return back()->withInput(['tab'=>$tab]);
	}

	public function discussion_post(Request $request)
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

		flash('Discussion has been Submitted.')->success()->important();
		return back()->withInput(['tab'=>'discussion']);;
	} 

	public function dashboard_show() 
	{		
		$store = Store::where('is_active','1')->where('is_featured','1')->get()->take(5);
		$r_post = Coupon::orderBy('created_at','desc')->get()->take(4);
		$t_post = Coupon::orderBy('created_at','desc')->get()->take(4);

		$auth = Auth::user();	
		$coupon = $auth->coupon->where('type','c')->where('is_active','1')->count();
		$deal = $auth->coupon->where('type','d')->where('is_active','1')->count();
		$post = $auth->coupon->sortbydesc('created_at')->take(3);
		$followers = $auth->followers;	
		$followings = $auth->followings;
		return view('coupon.user.account',compact('deal','coupon','post','store','r_post','t_post','followings','followers'));
	}

	public function profile_show() 
	{
		$auth = Auth::user();
		return view('coupon.user.profile', compact('auth'));
	}
	public function profile_edit()
	{
		$auth = Auth::user();
		return view('coupon.user.profile-edit', compact('auth'));
	}

	public function profile_update(Request $request)
	{

		$user = Auth::user();

		$request->validate([
		  'name' => 'required',
		  'mobile' => 'numeric',
		  'image' => 'nullable|image|mimes:jpeg,png,jpg',
		]);

		$input = $request->all();

		if ($file = $request->file('image')) {

		  if ($user->image != null && $user->image != 'user.png') {
		
				$image_file = @file_get_contents(public_path().'/coupon/images/user/'.$user->image);

				if($image_file){				  
				  unlink(public_path().'/coupon/images/user/'.$user->image);
				}
		  }

		  $optimizeImage = Image::make($file);
      $optimizePath = public_path().'/coupon/images/user/';
      $name = time().$file->getClientOriginalName();
      $optimizeImage->save($optimizePath.$name, 72);

		  $input['image'] = $name;

		}
		$user->update($input);

    flash('Your profile has been updated')->success()->important();
    return back()->with("updated", "Your profile has been updated");

	}

	public function change_password(Request $request)
  {
    $auth = Auth::user();
  	$validator = Validator::make($request->all(),[
     'old_password' => 'required',
     'new_password' => 'required|confirmed|min:6'
    ]); 
    if ($validator->fails()) {
    	flash('Password Error')->error()->important();
      return back()->withErrors($validator)->withInput();
    }
  	if(Hash::check($request->old_password, $auth->password))
  	{
      $auth->update([
         'password' => bcrypt($request->new_password)
      ]);
    	flash('Password has been updated successfully')->success()->important();
      return back()->with('updated', 'Password has been updated');
    } 
    else 
    {
    flash('Your password doesnt match')->error()->important();
      return back()->with("updated", "Your password doesn't match");
    }
    flash('Your password doesnt match')->error()->important();
    return back()->with("updated", "Your password doesn't match");
  }

	public function follow_user(Request $request)
	{
		$id = $request['userId'];
  	$status = $request['status'];
		$user = User::findorfail($id);
		if($status == 'Follow'){
			$user->followers()->syncWithoutDetaching(auth()->user()->id);
		}
		else{				 
			$user->followers()->detach(auth()->user()->id);
		}
		return back();
	} 
	public function post_like(Request $request)
	{	
		$id = $request['postId'];
  	$type = $request['type'];	
  	$btn_type = $request['btnType'];
  	$btn_value = $request['btnValue'];	
		$post_type = null;
    if($type != 'g'){
			$post_type = Coupon::findorfail($id);
		}
		else{
			$post_type = Discussion::findorfail($id);
		}

		$existing_like = $post_type->likes()->whereLikeableId($id)->whereUserId(Auth::id())->first();

    if($existing_like) {
			if($btn_value == '' || $btn_value == Null){
				$existing_like->value = ($btn_type == 'like' ? 1 : -1);
				$existing_like->save();	
			}
			else{			
				$existing_like->delete();	
			}
		}
		else{	
			if($btn_value == '' || $btn_value == Null){
				$like = new Like();
				$like->value = ($btn_type == 'like' ? 1 : -1);
				$like->user_id = Auth::user()->id;
				$post_type->likes()->save($like);	
			}			 			
		}
		$t_likes = $post_type->likes()->count();
		$p_likes = $post_type->likes()->where('value','1')->count();
		if($p_likes != 0){
			$rating = ($p_likes*5)/$t_likes;
			$post_type->rating = $rating;
			$post_type->save();
		}
		elseif($p_likes == 0 && $t_likes == 0){
			$post_type->rating = 0;
			$post_type->save();
		}
		else{
			$post_type->rating = "-5";
			$post_type->save();
		}
		return $post_type->rating;
	}  
	public function comment_store(Request $request){
		$request->validate([
			'commenttext' => 'required|min:2',
		]);
	  $post_type = null;
		if (!Auth::check()) {
			return back()->with('error_code','5');
		}
		if($request->posttype == 'blog'){
		  $post_type = Blog::findorfail($request->postid);
		}
		elseif($request->posttype != 'g'){
		  $post_type = Coupon::findorfail($request->postid);
		}
		else{
		  $post_type = Discussion::findorfail($request->postid);
		}
		// $user = Auth::user();
  	$auth = Auth::user();
		$comment = new Comment();
		$comment->user_id = $auth->id;
		$comment->body = trim($request->commenttext);
		$comment->reply_id = ($request->replyid == 'main' ? Null : $request->replyid);
		$post_type->comments()->save($comment);

		return back();
	}
}
