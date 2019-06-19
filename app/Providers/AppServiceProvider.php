<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Auth;

use App\Model\Category;
use App\Model\Mining;
use App\Model\Post;
use App\Model\Testimonial;
use View;
use App\Model\Menu;
use App\Model\LearnSocial;
use App\Model\Advertisment;
use App\Model\Service;
use App\Model\GeneralSettings;


use App\Social;
use App\Settings;
use App\Store;
use App\ForumCategory;
use App\CouponCategory;
use App\Coupon;
use App\Discussion;
use App\CouponPages;
use App\Blog;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('*', function ($view) {
            $p_store = Store::where('is_active', '1')->where('is_featured', '1')->get()->take(5);
            $blogs = Blog::where('is_active', '1')->orderBy('created_at', 'desc')->get()->take(5);
            $r_post = collect();
            $r_post->push(Coupon::where('is_active', '1')->orderBy('created_at', 'desc')->get()->take(5));
            $r_post->push(Discussion::where('is_active', '1')->orderBy('created_at', 'desc')->get()->take(5));
            $r_post = $r_post->flatten()->sortbydesc('created_at')->take(5);
            $forumcategory = ForumCategory::all();
            $coupon = Coupon::where('type', 'c')
                ->where('is_active', '1')
                ->where('is_verified', '1')
                ->where('is_featured', '1')->orderBy('created_at', 'desc')->get();
            $category = CouponCategory::where('is_active', '1')->get();
            $store = Store::where('is_active', '1')->get();
            $social = Social::all();
            $settings = Settings::first();
            $auth = Auth::user();
            $footer = CouponPages::all();
            $view->with(['auth' => $auth, 'social' => $social, 'settings' => $settings, 'category_list' => $category, 'forumcategory_list' => $forumcategory, 'store_list' => $store, 'f_coupon' => $coupon, 'p_store' => $p_store, 'r_post' => $r_post, 'f_menu' => $footer, 'blogs_side' => $blogs]);
        });

        $data['basic'] = GeneralSettings::first();
        $data['gnl'] = GeneralSettings::first();
        $data['menus'] =  Menu::all();
        $data['social'] =  LearnSocial::all();
        $data['testimonials'] =  Testimonial::all();
        $data['goals'] =  Service::all();

        $data['blogs'] = Post::whereStatus(1)->latest()->take(6)->get();
        $data['blogCategory'] = Category::whereStatus(1)->get();


        /*in Project*/
        $data['articleCategory'] = Mining::whereStatus(1)->where('short_name', '!=', null)->get();
        $data['postCategoryNull'] = Mining::whereStatus(1)->where('short_name', '=', null)->get();
        $data['postCategoryNotNull'] = Mining::whereStatus(1)->where('short_name', '!=', null)->get();



        view::share($data);
        // Implicitly grant "Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(
            function ($user, $ability) {
                return $user->hasRole('admin') ? true : null;
            }
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
