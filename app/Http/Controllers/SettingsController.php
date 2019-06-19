<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;

class SettingsController extends Controller
{
    public function general_show()
    {
      $general_settings = Settings::first();
      return view('coupon.admin.general', compact('general_settings'));
    }

    /**
     * Update General Settings.
     *
     */
    public function general_update(Request $request, $id)
    {
        $general_settings = Settings::findOrFail($id);

        $request->validate([
          'logo' => 'nullable|image|mimes:jpg,jpeg,png',
          'w_email' => 'nullable|email',
          'copyright' => 'required'
        ]);

        $input = $request->all();

        if ($file = $request->file('logo')) {
          $name = $file->getClientOriginalName();
          if($general_settings->logo != null) {
            $image_file = @file_get_contents(public_path().'/coupon/images/'.$general_settings->logo);
            if($image_file){
              unlink(public_path() . '/coupon/images/' . $general_settings->logo);
            }
          }
          $file->move('coupon/images', $name);
          $input['logo'] = $name;
        }

        if ($file = $request->file('navbar_img')) {
          $name = $file->getClientOriginalName();
          if($general_settings->navbar_img != null) {
            $image_file = @file_get_contents(public_path().'/coupon/images/'.$general_settings->navbar_img);
            if($image_file){
              unlink(public_path() . '/coupon/images/' . $general_settings->navbar_img);
            }
          }
          $file->move('coupon/images', $name);
          $input['navbar_img'] = $name;
        }

        if ($file = $request->file('footer_logo')) {
          $name = $file->getClientOriginalName();
          if($general_settings->footer_logo != null) {
            $image_file = @file_get_contents(public_path().'/coupon/images/'.$general_settings->footer_logo);
            if($image_file){
              unlink(public_path() . 'coupon/images/' . $general_settings->footer_logo);
            }
          }
          $file->move('coupon/images', $name);
          $input['footer_logo'] = $name;
        }

         if ($file = $request->file('preloader')) {
          $name = $file->getClientOriginalName();
          if($general_settings->preloader != null) {
            $image_file = @file_get_contents(public_path().'/coupon/images/'.$general_settings->preloader);
            if($image_file){
              unlink(public_path() . 'coupon/images/' . $general_settings->preloader);
            }
          }
          $file->move('coupon/images', $name);
          $input['preloader'] = $name;
        }

        if ($file2 = $request->file('favicon')) {
          $name = $file2->getClientOriginalName();
          if ($general_settings->favicon != null) {
            $image_file = @file_get_contents(public_path().'coupon/images/favicon/'.$general_settings->favicon);
            if($image_file){
              unlink(public_path() . 'coupon/images/favicon/'. $general_settings->favicon);
            }
          }
          $file2->move('coupon/images/favicon', $name);
          $input['favicon'] = $name;
        }

        if (!isset($input['is_recent_deals']))
        {
          $input['is_recent_deals'] = 0;
        }
        if (!isset($input['is_store_slider']))
        {
          $input['is_store_slider'] = 0;
        }
        if (!isset($input['is_mailchimp']))
        {
          $input['is_mailchimp'] = 0;
        }
        if (!isset($input['is_app_icon']))
        {
          $input['is_app_icon'] = 0;
        }
        if (!isset($input['is_playstore']))
        {
          $input['is_playstore'] = 0;
        }
        if (!isset($input['is_category_block']))
        {
          $input['is_category_block'] = 0;
        }
        if (!isset($input['is_feat_slider']))
        {
          $input['is_feat_slider'] = 0;
        }
        if (!isset($input['footer_layout']))
        {
          $input['footer_layout'] = 0;
        } 
        if (!isset($input['is_blog']))
        {
          $input['is_blog'] = 0;
        } 
        if (!isset($input['blog_layout']))
        {
          $input['blog_layout'] = 0;
        } 
        if (!isset($input['blog_left']))
        {
          $input['blog_left'] = 0;
        }
        if (!isset($input['is_gotop']))
        {
          $input['is_gotop'] = 0;
        }
        if (!isset($input['is_preloader']))
        {
          $input['is_preloader'] = 0;
        }
        if (!isset($input['right_click']))
        {
          $input['right_click'] = 0;
        }
        if (!isset($input['inspect']))
        {
          $input['inspect'] = 0;
        }
 
        $general_settings->update($input);

        return back()->with('added','Settings has been saved successfully');
    }
}
