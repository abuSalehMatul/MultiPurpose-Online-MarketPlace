<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use App\CouponCategory;
use App\Store;
use App\User;
use App\Discussion;
use App\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminDashboardController extends Controller
{
    public function update_profile(Request $request)
    {
        $auth = Auth::user();

        $request->validate([
           'current_password' => 'required'
        ]);

        if (Hash::check($request->current_password, $auth->password))
        {

          if ($request->new_email != null)
          {
              $request->validate([
                 'new_email' => 'required|email'
              ]);
              $auth->update([
                  'email' => $request->new_email
              ]);
              return back()->with('updated', 'Email has been updated');
          }
          if ($request->new_password != null)
          {
            $request->validate([
                'new_password' => 'required|min:6'
            ]);
            $auth->update([
               'password' => bcrypt($request->new_password)
            ]);
            return back()->with('updated', 'Password has been updated');
          }

        } else {
          return back()->with("deleted", "Your password doesn't match");
        }
        return back();
    }

    public function dashboard_show()
    {
      $users_count = User::count();
      $category_count = CouponCategory::count();
      $store_count = Store::count();
      $discussion_count = Discussion::count(); 
      $coupon_count = Coupon::where('type','c')->count(); 
      $deal_count = Coupon::where('type','d')->count();

      // $coupon_count = Offers::where('valid_date','>',Carbon::now()->toDateString())->count();
      // $booking_count = Booking::where('status','b')->count();      
      // // $book_sale_count = Booking::where('status','b')->SUM('total_amt');
      // $wallet_count = DB::table('wallets')                
      //           ->where('is_active','1')
      //           ->SUM('total_points');
      // $bonus_count = Bonus::sum('b_points');        
      // $sale_count = DB::table('member_plans')
      //           ->where('status','s')
      //           ->SUM('paid_amount');

      // $book_sale_count = DB::table('bookings')
      //           ->where('status','b')
      //           ->SUM('total_amt');
      return view('coupon.admin.dashboard', compact('deal_count','users_count', 'coupon_count', 'discussion_count', 'category_count','store_count'));
    }

     public function slider_show()
    {
      $slider = Slider::first();
      return view('coupon.admin.slider', compact('slider'));
    }

    public function slider_update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        if($request->is_image == 1){
          $request->validate([
            'heading' => 'required',
            'subheading' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
          ]);
        }
        // else{
        //   $request->validate([
        //     'link' => 'required'
        //   ]);
        // }

        $input = $request->all();  

        if ($file = $request->file('image')) {
          $name = time() . $file->getClientOriginalName();
          if($slider->image != '' && $slider->image != null) {
            unlink(public_path() . 'coupon/images/' . $slider->image);
          }
          $file->move('coupon/images', $name);
          $input['image'] = $name;
        }

        if (!isset($input['is_parallax']))
        {
          $input['is_parallax'] = 0;
        }
        if (!isset($input['is_overlay']))
        {
          $input['is_overlay'] = 0;
        }
        // if (!isset($input['is_active']))
        // {
        //   $input['is_active'] = 0;
        // }

        $slider->update($input);

        return back()->with('added','Slider has been saved successfully');
    }
}
