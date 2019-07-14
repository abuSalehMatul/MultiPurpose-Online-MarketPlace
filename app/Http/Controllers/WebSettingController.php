<?php

namespace App\Http\Controllers;

use App\Model\GeneralSettings;
use App\Model\LearnFaq;
use App\Model\Menu;
use App\Model\LearnSlider;
use App\Model\LearnSocial;
use App\Model\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use File;
use Image;
class WebSettingController extends Controller
{

    public function manageLogo()
    {
        $data['page_title'] = "Manage Logo & Favicon";
        return view('learn.webControl.logo', $data);
    }
    public function updateLogo(Request $request)
    {
        $this->validate($request, [
            'logo' => 'mimes:png',
            'favicon' => 'mimes:png',
            'freeloader' => 'mimes:gif'
        ]);
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $filename = 'logo.png';
            $location = 'learn/assets/images/logo/' . $filename;
            Image::make($image)->save($location);
        }
        if ($request->hasFile('favicon')) {
            $image = $request->file('favicon');
            $filename = 'favicon.png';
            $location = 'learn/assets/images/logo/' . $filename;
            Image::make($image)->save($location);
        }
        $notification = array('message' => 'Update Successfully', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function getContact()
    {
        $data['basic'] = GeneralSettings::first();
        $data['page_title'] = "Contact Settings";
        return view('learn.webControl.contact-setting',$data);
    }

    public function putContactSetting(Request $request)
    {
        $basic = GeneralSettings::first();
        $request->validate([
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);
        $in = Input::except('_method','_token');
        $basic->fill($in)->save();

        $notification =  array('message' => 'Contact  Updated Successfully', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function manageFooter()
    {
        $data['page_title'] = "Manage Footer";
        return view('learn.webControl.footer', $data);
    }
    public function updateFooter(Request $request)
    {
        $basic = GeneralSettings::first();
        $this->validate($request,[
            'copyright' => 'required'
        ]);
        $in = Input::except('_method','_token');
        $basic->fill($in)->save();
        $notification = array('message' => ' Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function manageSocial()
    {
        $data['page_title'] = "Manage Social";
        $data['social'] = LearnSocial::all();
        return view('learn.webControl.social', $data);
    }
    public function storeSocial(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'code' => 'required',
            'link' => 'required',
        ]);
        $product = LearnSocial::create($request->input());
        return response()->json($product);
    }
    public function editSocial($product_id)
    {
        $product = LearnSocial::find($product_id);
        return response()->json($product);
    }
    public function updateSocial(Request $request,$product_id)
    {
        $product = LearnSocial::find($product_id);
        $product->name = $request->name;
        $product->code = $request->code;
        $product->link = $request->link;
        $product->save();
        return response()->json($product);
    }
    public function destroySocial(Request $request)
    {
        $product = LearnSocial::destroy($request->delete_id);
        $notification = array('message' => 'Deleted Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function manageMenu()
    {
        $data['page_title'] = "Control Menu";
        $data['menus'] = Menu::paginate(2);
        return view('learn.webControl.menu-show',$data);
    }
    public function createMenu()
    {
        $data['page_title'] = "Create Menu";
        return view('learn.webControl.menu-create',$data);
    }
    public function storeMenu(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:menus,name',
            'description' => 'required'
        ]);
        $in = Input::except('_method','_token');
        $in['slug'] = str_slug($request->name);
        Menu::create($in);
        $notification = array('message' => 'Menu Created Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }
    public function editMenu($id)
    {
        $data['page_title'] = "Edit Menu";
        $data['menu'] = Menu::findOrFail($id);
        return view('learn.webControl.menu-edit',$data);
    }
    public function updateMenu(Request $request,$id)
    {
        $menu = Menu::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|unique:menus,name,'.$menu->id,
            'description' => 'required'
        ]);
        $in = Input::except('_method','_token');
        $in['slug'] = str_slug($request->name);
        $menu->fill($in)->save();
        $notification = array('message' => 'Menu Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }
    public function deleteMenu(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);
        Menu::destroy($request->id);
        $notification = array('message' => 'Menu Deleted Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }



    public function mangeBreadcrumb()
    {
        $data['page_title'] = "Manage Breadcrumb";
        return view('learn.webControl.breadcrumb',$data);
    }
    public function updateBreadcrumb(Request $request)
    {
        $this->validate($request,[
            'testimonial' => 'image|mimes:jpg,jpeg',
        ]);
        if($request->hasFile('testimonial')){
            $image = $request->file('testimonial');
            $filename = 'testimonial.jpg';
            $location = 'learn/assets/images/logo/' . $filename;
            Image::make($image)->save($location);
        }


        $notification = array('message' => 'Breadcrumb Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function manageScript()
    {
        $data['page_title'] = " Comment Script";
        return view('learn.webControl.fb-comment',$data);
    }
    public function updateScript(Request $request)
    {
        $basic = GeneralSettings::first();
        $this->validate($request,[
            'fb_comment' => 'required'
        ]);
        $basic->fb_comment = $request->fb_comment;
        $basic->save();
        $notification = array('message' => 'Script Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }
    public function manageAbout()
    {
        $data['page_title'] = "Manage About";
        return view('learn.webControl.about',$data);
    }
    public function updateAbout(Request $request)
    {
        $basic = GeneralSettings::first();
        $this->validate($request,[
            'about' => 'required'
        ]);
        $basic->about = $request->about;
        $basic->save();
        $notification = array('message' => 'About Page Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function managePrivacy()
    {
        $data['page_title'] = "Manage Privacy & Policy";
        return view('learn.webControl.privacy',$data);
    }
    public function updatePrivacy(Request $request)
    {
        $basic = GeneralSettings::first();
        $this->validate($request,[
            'privacy' => 'required'
        ]);
        $basic->privacy = $request->privacy;
        $basic->save();
        $notification = array('message' => 'Privacy & Policy Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function manageTerms()
    {
        $data['page_title'] = "Manage Terms & Conditions";
        return view('learn.webControl.terms',$data);
    }
    public function updateTerms(Request $request)
    {
        $basic = GeneralSettings::first();
        $this->validate($request,[
            'terms' => 'required'
        ]);
        $basic->terms = $request->terms;
        $basic->save();
        $notification = array('message' => 'Terms & Conditions Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }



    public function createFaqs()
    {
        $data['page_title'] = "Create New Faq";
        return view('learn.webControl.faqs-create',$data);
    }

    public function storeFaqs(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $in = Input::except('_method','_token');
        LearnFaq::create($in);
        $notification = array('message' => 'FAQS Created Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function allFaqs()
    {
        $data['page_title'] = "All Question";
        $data['faqs'] = LearnFaq::orderBy('id','desc')->paginate(10);
        return view('learn.webControl.faqs-all',$data);
    }

    public function editFaqs($id)
    {
        $data['page_title'] = "Edit Faqs";
        $data['faqs'] = LearnFaq::findOrFail($id);
        return view('learn.webControl.faqs-edit',$data);
    }

    public function updateFaqs(Request $request, $id)
    {
        $faqs = LearnFaq::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $in = Input::except('_method','_token');
        $faqs->fill($in)->save();

        $notification = array('message' => 'FAQS Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);

    }

    public function deleteFaqs(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        LearnFaq::destroy($request->id);
        $notification = array('message' => 'FAQS Deleted Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }


    public function manageSlider()
    {
        $data['page_title'] = "Manage Slider";
        $data['slider'] = LearnSlider::all();
        return view('learn.webControl.slider', $data);
    }
    public function storeSlider(Request $request)
    {
        $this->validate($request,[
            'image' => 'required|mimes:png,jpeg,jpg'
        ]);
        $in = Input::except('_method','_token');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = 'slider_'.time().'.jpg';
            $location = 'learn/assets/images/slider/' . $filename;
            Image::make($image)->resize(2100,1410)->save($location);
            $in['image'] = $filename;
        }
        LearnSlider::create($in);
        $notification = array('message' => 'Slider Created Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }
    public function deleteSlider(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);
        $slider = LearnSlider::findOrFail($request->id);
        File::delete('learn/assets/images/slider/'.$slider->image);
        $slider->delete();

        $notification = array('message' => 'Slider Deleted Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }


    public function manageService()
    {
        $data['page_title'] = "Our Goals";
        $data['service'] = Service::all();
        return view('learn.webControl.service-show',$data);
    }
    public function editService($id)
    {
        $data['page_title'] = " Edit Our Goals";
        $data['service'] = Service::findOrFail($id);
        return view('learn.webControl.service-edit',$data);
    }
    public function updateService(Request $request,$id)
    {
        $menu = Service::findOrFail($id);
        $this->validate($request,[
            'details' => 'required|max:150'
        ]);

        $in = Input::except('_method','_token');

        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = 'how_it_works_'.time().'.'.$image->getClientOriginalExtension();
            $location = 'learn/assets/images/' . $filename;
            Image::make($image)->resize(100,100)->save($location);
            $in['image'] = $filename;

            $path = 'learn/assets/images/'.$menu->image;
            @unlink($path);


        }

        $menu->fill($in)->save();
        $notification = array('message' => ' Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }


}
