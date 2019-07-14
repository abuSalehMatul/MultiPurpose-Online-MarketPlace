<?php

namespace App\Http\Controllers;

use App\Store;
use App\CouponCategory;
use App\ForumCategory;
use App\Coupon;
use App\Discussion;
use App\CouponPages;
use App\FaqCategory;
use App\Faq;
use App\User;
use App\Slider;
use Auth;
use Mail;
use App\Blog;
use App\Tag;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CouponPageController extends Controller
{
	public function index(Request $request)
	{
		$slider = Slider::first();
		$store = Store::where('is_active','1')->where('is_featured','1')->get()->take(10);
		$results = Coupon::where('is_active','1')
										->where('is_verified','1')
										->orderBy('created_at','desc')->paginate(36);	
		$feat_deal = Coupon::where('is_active','1')
										->where('is_verified','1')
										->where('is_featured','1')
										->orderBy('created_at','desc')->get()->take(12);
		$blogs = Blog::where('is_active','1')->orderBy('created_at','desc')->get()->take(3);
		// if($request->ajax()){
		// 	return view('theme.home-filter', compact('results'));
		// }
		
		return view('coupon.theme.home',compact('store','category','results','feat_deal','slider','blogs'));
	}
	public function list_show(Request $request)
	{
		$slider = Slider::first();
		$store = Store::where('is_active','1')->where('is_featured','1')->get()->take(10);
		$results = Coupon::where('is_active','1')
										->where('is_verified','1')
										->orderBy('created_at','desc')->paginate(36);	
		$feat_deal = Coupon::where('is_active','1')
										->where('is_verified','1')
										->where('is_featured','1')
										->orderBy('created_at','desc')->get()->take(12);
		$blogs = Blog::where('is_active','1')->orderBy('created_at','desc')->get()->take(3);
		// if($request->ajax()){
		// 	return view('theme.home-filter', compact('results'));
		// }
		return view('coupon.theme.home-list',compact('store','category','results','feat_deal','slider','blogs'));
	}
	public function profile_show($id)
	{		
		// $t_post = Coupon::orderBy('created_at','desc')->get()->take(4);
		$user = User::findorfail($id);		
		$coupon = $user->coupon->where('type','c')->where('is_active','1')->count();
		$deal = $user->coupon->where('type','d')->where('is_active','1')->count();
		$post = $user->coupon->sortbydesc('created_at')->take(3);
		return view('coupon.theme.profile',compact('user','post','deal','coupon'));
	}
	public function category_show()
	{				
		return view('coupon.theme.category');
	} 
	public function cat_dtl_show($slug)
	{
		$category = CouponCategory::where('slug',$slug)->first();
		$coupon_dtl = Coupon::where('category_id',$category->id)
													->where('is_active','1')
													->where('is_verified','1')->orderBy('created_at','desc')->paginate(36);	
		return view('coupon.theme.category-dtl',compact('coupon_dtl','category'));
	} 
	public function coupon_show()
	{		
		$coupon_dtl = Coupon::where('is_active','1')
										->where('is_verified','1')
										->where('type','c')->orderBy('created_at','desc')->paginate(36);
		 // return $months = Coupon::groupBy(selectRaw("MONTH(created_at) as month"))->get();
		return view('coupon.theme.coupon', compact('coupon_dtl'));
	} 	
	public function coupon_dtl_show($slug)
	{	
		$store = Store::where('slug',$slug)->first();
		$coupon_dtl = Coupon::where('store_id',$store->id)
										->where('is_active','1')
										->where('is_verified','1')
										->where('type','c')->orderBy('created_at','desc')->paginate(36);
		return view('coupon.theme.coupon-dtl', compact('coupon_dtl','store'));
	} 
	public function forum_show()
	{		
		$forum_list = ForumCategory::where('is_active','1')->get();
		return view('coupon.theme.forum',compact('forum_list'));
	} 
	public function forum_dtl_show($slug)
	{
		$forumcategory = ForumCategory::where('slug',$slug)->first();
		$forum_dtl = null;
		if($forumcategory->category == 'g'){
			$forum_dtl = Discussion::where('forum_category_id',$forumcategory->id)
														->where('is_active','1')->orderBy('created_at','desc')->get();
		}
		else{
			$forum_dtl = Coupon::where('forum_category_id',$forumcategory->id)
													->where('is_active','1')->orderBy('created_at','desc')->get();		
		}
		return view('coupon.theme.forum-dtl',compact('forum_dtl','forumcategory'));
	} 
	public function deal_dtl_show($slug)
	{	
		$store = Store::where('slug',$slug)->first();
		$coupon_dtl = Coupon::where('store_id', $store->id)
										->where('is_active','1')
										->where('is_verified','1')	
										->where('type','d')->orderBy('created_at','desc')->paginate(36);
		return view('coupon.theme.deal-dtl', compact('coupon_dtl','store'));
	} 
	public function deal_show()
	{		
		$coupon_dtl = Coupon::where('is_active','1')
										->where('is_verified','1')
										->where('type','d')->orderBy('created_at','desc')->paginate(36);
		return view('coupon.theme.deal', compact('coupon_dtl'));
	} 
	public function store_show()
	{				
		return view('coupon.theme.store');
	} 	
	public function store_dtl_show($slug)
	{		
		$store = Store::where('slug',$slug)->first();
		$coupon_dtl = Coupon::where('store_id',$store->id)
		                    ->where('is_active','1')
										    ->where('is_verified','1')->orderBy('created_at','desc')->paginate(36);
		return view('coupon.theme.store-dtl',compact('coupon_dtl','store'));
	} 	
	public function post_show($uniID, $slug)
	{
		$post = Coupon::where('uni_id',$uniID)->where('slug',$slug)->first();
		if(! isset($post)){
			$post = Discussion::where('uni_id',$uniID)->where('slug',$slug)->first(); 
		} 
		$post->addView();
		$comments = $post->comments()->where('reply_id',null)->where('is_active',1)->orderBy('created_at','desc')->paginate(20);
		return view('coupon.theme.post2', compact('post','comments'));
	} 
	public function faq_show()
	{
		$faq_cat = FaqCategory::where('is_active','1')->get();
		return view('coupon.theme.faq',compact('faq_cat'));
	} 
	public function blog_dtl_show($uniID, $slug)
	{
		$blog= Blog::where('uni_id',$uniID)->where('slug',$slug)->first();	
		$prev = Blog::where('id', '<', $blog->id)->max('id');	
		$prev = Blog::where('id', $prev)->first();
  	$next = Blog::where('id', '>', $blog->id)->min('id');  
		$next = Blog::where('id', $next)->first();
		$comments = $blog->comments()->where('reply_id',null)->where('is_active',1)->orderBy('created_at','desc')->paginate(20);
		return view('coupon.theme.blog-dtl', compact('blog','comments','prev','next','comments'));
	} 
	public function blog_show()
	{
		$blogs = Blog::where('is_active','1')
		        ->orderBy('created_at','desc')->paginate(21);
		$tags = Tag::all();
		return view('coupon.theme.blog', compact('blogs','tags'));
	} 	
	public function tag_show($slug)
	{
		$tag = Tag::whereSlug($slug)->first();
		$blogs = $tag->blogs()->paginate(21);
		return view('coupon.theme.tag',compact('tag','blogs'));
	}
	public function contact_show()
	{
		return view('coupon.theme.contact');
	}
	public function contact_post(Request $request) 
  {
    $request->validate([
      'name' => 'required',
      'email' => 'required',
      'mobile' => 'required',
      'subject' => 'required',
      'message' => 'required',
      'category' => 'required'
    ]);

    $input = $request->all(); 

    Mail::send('coupon.email.contact', ['input' => $input], function($message) {
        $message->to(Input::get('w_email'))->from(Input::get('email'))->subject('Contact us');
    });

    flash('Mail has been sent.')->success()->important();
    return back()->with('updated', 'Mail has been sent');
  }
  public function post_counter(Request $request)
  {
		$coupon = Coupon::findorfail($request->id);
		$coupon->user_count++;
		$coupon->save();
    return 1;
  }
  public function page_show($page)
  {
  	$pages = CouponPages::where('slug',$page)->first();
  	if(!$pages){
  		return view('coupon.errors.404');
  	}
    return view('coupon.theme.pages', compact('pages'));
  }
}
