<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\LiveClass;
use App\Model\Post;
use App\Model\PricingPlan;
use App\Model\Subscriber;
use App\Model\Unit;
use Illuminate\Http\Request;
use Auth;
use App\Model\Menu;
use App\Model\Faq;
use App\Model\Advertisment;
use App\Model\Mining;
use App\Model\GeneralSettings;

class FrontendController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        
        $data['page_title'] = "Home";
        return view('learn.front.index', $data);
    }

    public function menu($slug)
    {
        $menu = $data['menu'] = Menu::whereSlug($slug)->first();
        $data['page_title'] = "$menu->name";
        return view('learn.layouts.menu', $data);
    }

    public function about()
    {
        $data['page_title'] = "About Us";
        return view('learn.layouts.about', $data);
    }

    public function faqs()
    {
        $data['faqs'] = Faq::all();
        $data['page_title'] = "Faqs";
        return view('learn.layouts.faqs', $data);
    }


    public function contactUs()
    {
        $data['page_title'] = "Contact Us";
        return view('learn.layouts.contact', $data);
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);
        $subject = "Contact Us";
        send_email($request->email, $request->name, $subject, $request->message);
        return back()->with('success', ' Mail Send');
    }

    public function clickadd($id)
    {

        $add = Advertisment::findOrFail($id);
        $data = array();
        $data['views'] = $add->views + 1;
        Advertisment::whereId($id)->update($data);
        $go = $add->link;
        return redirect($go);
    }


    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);
        $macCount = Subscriber::where('email', $request->email)->count();
        if ($macCount > 0) {
            return back()->with('alert', 'This Email Already Subscribed !!');
        } else {
            Subscriber::create($request->all());
            return back()->with('success', ' Subscribe Successfully!');
        }
    }

    public function categories($id)
    {
        $cat =  Mining::find($id);
       $data['subjects'] =  Unit::where('category_id',$id)->whereStatus(1)->get();
        if($cat->short_name != null){
            $data['page_title'] = " $cat->short_name  ". " Preparation"  ;
        }else{
            $data['page_title'] = " $cat->name ". " Preparation"  ;
        }
        return view('learn.front.categories', $data);
    }

    public function topics($id)
    {
        $getdata = Unit::where('id',$id)->select('category_id')->first();
         $data['topics'] = PricingPlan::where('subcategory_id',$id)->whereStatus(1)->get();
        $data['cat_id'] = $getdata->category_id;
        $data['page_title'] = "Playlist";
        return view('learn.front.article', $data);
    }
    public function liveClass()
    {

         $data['topics'] = LiveClass::latest()->whereStatus(1)->get();
        $data['page_title'] = "Live Class";
        return view('learn.front.live-class', $data);
    }

    public function detailsBlog($id)
    {
        $data['post'] = Post::whereId($id)->whereStatus(1)->first();
         $data['page_title'] = $data['post']->title;
        return view('learn.front.blog-details', $data);
    }
    public function blogCategory($id)
    {
        $cat= Category::whereId($id)->first();
        $data['posts'] = Post::where('cat_id',$id)->whereStatus(1)->paginate(4);
         $data['page_title'] = $cat->name;
        return view('learn.front.blog-category', $data);
    }


}
