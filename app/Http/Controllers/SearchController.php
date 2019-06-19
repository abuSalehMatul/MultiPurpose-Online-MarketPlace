<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\CouponCategory;
use App\Coupon;
use DB;
use View;
use App\Blog;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
	public function homeSearch(Request $searchKey)
	{
			$results = collect();
			$search_title = trim($searchKey->search);
			$store = Store::where('title','LIKE',"%$search_title%")->where('is_active','1')->get();
			$category = CouponCategory::where('title','LIKE',"%$search_title%")->where('is_active','1')->get();
			if((isset($store) && count($store)>0) || (isset($category) && count($category)>0)){
			  if (isset($store)) {
					foreach($store as $item){
					  $results->push($item->coupon->where('is_active','1'));
					}
				}	
				if (isset($category)) {
					foreach($category as $item){
						$results->push($item->coupon->where('is_active','1'));	
					}
				}
			}
			else{
			  $coupon = Coupon::where('title','LIKE',"%$search_title%")->where('is_active','1')->get();
			  $results->push($coupon);
			}
			$results1 = $results->flatten()->sortbydesc('created_at');
			$results = $this->paginate($results1);
			return view('coupon.theme.search',compact('results','search_title'));
	}
	public function filterSearch(Request $request)
	{
		$coupon_dtl = collect();
		$f_array = $request->f_array;
		$f_id = $request->f_id;

		if(isset($f_array) && count($f_array)>0){
			if($request->type == 'store'){
				foreach($f_array as $id){
				  $coupon_dtl->push(Coupon::where('category_id',$f_id)
				  							->where('store_id',$id)
		  									->where('is_active','1')
												->where('is_verified','1')->get());
				}
			}
			elseif($request->type == 'categorycoupon'){
				foreach($f_array as $id){
				  $coupon_dtl->push(Coupon::where('store_id',$f_id)
				  							->where('category_id',$id)
				  							->where('type','c')
		  									->where('is_active','1')
												->where('is_verified','1')->get());
				}
			}
			elseif($request->type == 'categorydeal'){
				foreach($f_array as $id){
				  $coupon_dtl->push(Coupon::where('store_id',$f_id)
				  							->where('category_id',$id)
				  							->where('type','d')
		  									->where('is_active','1')
												->where('is_verified','1')->get());
				}
			}
			elseif($request->type == 'category'){
				foreach($f_array as $id){
				  $coupon_dtl->push(Coupon::where('store_id',$f_id)
				  							->where('category_id',$id)
		  									->where('is_active','1')
										    ->where('is_verified','1')->get());
				}
			}
		}
		else{ 
			if($request->type == 'store'){
			  $coupon_dtl->push(Coupon::where('category_id',$f_id)
	  									->where('is_active','1')->where('is_verified','1')->get());
			}
			elseif($request->type == 'categorycoupon'){
				$coupon_dtl->push(Coupon::where('store_id',$f_id)
										->where('type','c')
		  							->where('is_active','1')->where('is_verified','1')->get());
			}
			elseif($request->type == 'categorydeal'){
				$coupon_dtl->push(Coupon::where('store_id',$f_id)
										->where('type','d')
		  							->where('is_active','1')->where('is_verified','1')->get());
			}
			elseif($request->type == 'category'){
				$coupon_dtl->push(Coupon::where('store_id',$f_id)
		  							->where('is_active','1')->where('is_verified','1')->get());
			}
		}
		$coupon_dtl = $coupon_dtl->flatten()->sortbydesc('created_at');
		$coupon_dtl = $this->paginate($coupon_dtl);
		if($coupon_dtl != null && count($coupon_dtl)>0){
			return view('coupon.theme.filter-coupon', compact('coupon_dtl'));
		}
		else{
			return "No Search Results Found.";
		}
	}
	// public  function searchLike($query, $field, $value){
	//     return $query->where($field, 'LIKE', "%$value%");
	// }

	// User::like('name', 'Tomas')->get(); 
		   // ->orWhere('nickname', 'like', "$member%")->get();


	public function filter(Request $request)
	{
		$results = collect();
		$filter = $request->filter;
		$s_filter = $request->s_filter;
		$c_filter = $request->c_filter;
		$filter_page = $request->main;

		if(isset($filter) && isset($s_filter) && isset($c_filter)){
		// if(isset($filter)){
			// if($filter == 'featured'){
			//   $coupon = Coupon::where('is_active','1')
			// 						->where('is_verified','1')
			// 						// ->where('is_front','1')
			// 						->orderBy('created_at','desc')->get();
			// 	$results->push($coupon);
			// }
			// elseif($filter == 'trending'){
			//   $coupon = Coupon::OrderByViewsCount()
			//   								->where('is_active','1')
			// 									->where('is_verified','1')->get();
			// 	$results->push($coupon);

			// }
			if($filter == 'all' && $s_filter == 'all' && $c_filter == 'all'){
			  $results->push(Coupon::where('is_active','1')
									->where('is_verified','1')
									->orderBy('created_at','desc')->get());
			}
			elseif($filter == 'featured' && $s_filter == 'all' && $c_filter == 'all'){
			  $results->push(Coupon::where('is_active','1')
									->where('is_verified','1')
									->where('is_featured','1')
									->orderBy('created_at','desc')->get());
			}
			elseif($filter == 'trending' && $s_filter == 'all' && $c_filter == 'all'){
			  $results->push(Coupon::OrderByViewsCount()
			  					->where('is_active','1')
									->where('is_verified','1')->get());
			}
			elseif($s_filter != 'all' && $c_filter == 'all'){
				if($filter == 'all'){
				  $results->push(Coupon::where('store_id',$s_filter)
				  					->where('is_active','1')
										->where('is_verified','1')
										->orderBy('created_at','desc')->get());
				}
				if($filter == 'featured'){
				  $results->push(Coupon::where('store_id',$s_filter)
				  					->where('is_active','1')
										->where('is_verified','1')
										->where('is_featured','1')
										->orderBy('created_at','desc')->get());
				}
				if($filter == 'trending'){
				  $results->push(Coupon::OrderByViewsCount()
				  	        ->where('store_id',$s_filter)
				  					->where('is_active','1')
										->where('is_verified','1')->get());
				}
			}
			elseif($s_filter == 'all' && $c_filter != 'all'){
			   if($filter == 'all'){
				  $results->push(Coupon::where('category_id',$c_filter)
				  					->where('is_active','1')
										->where('is_verified','1')
										->orderBy('created_at','desc')->get());
				}
				if($filter == 'featured'){
				  $results->push(Coupon::where('category_id',$c_filter)
				  					->where('is_active','1')
										->where('is_verified','1')
										->where('is_featured','1')
										->orderBy('created_at','desc')->get());
				}
				if($filter == 'trending'){
				  $results->push(Coupon::OrderByViewsCount()
				  					->where('category_id',$c_filter)
				  					->where('is_active','1')
										->where('is_verified','1')->get());
				}
			}
			elseif($s_filter != 'all' && $c_filter != 'all'){
				if($filter == 'all'){
				  $results->push(Coupon::where('store_id',$s_filter)
				  					->where('category_id',$c_filter)
				  					->where('is_active','1')
										->where('is_verified','1')
										->orderBy('created_at','desc')->get());
				}
				elseif($filter == 'featured'){
				  $results->push(Coupon::where('store_id',$s_filter)
				  					->where('category_id',$c_filter)
				  					->where('is_active','1')
										->where('is_verified','1')
										->where('is_featured','1')
										->orderBy('created_at','desc')->get());
				}
				elseif($filter == 'trending'){
				  $results->push(Coupon::OrderByViewsCount()
				  					->where('store_id',$s_filter)
				  					->where('category_id',$c_filter)
				  					->where('is_active','1')
										->where('is_verified','1')->get());
				}
			}
		}
		$results = $results->flatten();
		$results = $this->paginate($results);
		if($results != null && count($results)>0){
			return view('coupon.theme.home-filter', compact('results','filter_page'));
		}
	}
	public function allfilter(Request $request)
	{
		// return $request->all;
		$results = collect();
		$c_array = $request->c_array;
		$s_array = $request->s_array;

		if($request->type == 'deal'){
			if(isset($s_array) && count($s_array)>0 && isset($c_array) && count($c_array)>0){
				foreach($s_array as $s_id){
					foreach($c_array as $c_id){
				  	$results->push(Coupon::where('store_id',$s_id)
				  							->where('category_id',$c_id)
				  							->where('type','d')
		  									->where('is_active','1')
												->where('is_verified','1')->get());
					}
				}
			}
			elseif(isset($s_array) && count($s_array)>0){
				foreach($s_array as $id){
				  $results->push(Coupon::where('store_id',$id)
				  							->where('type','d')
		  									->where('is_active','1')
												->where('is_verified','1')->get());
				}
			}
			elseif(isset($c_array) && count($c_array)>0){
				foreach($c_array as $id){
				  $results->push(Coupon::where('store_id',$id)
				  							->where('type','d')
		  									->where('is_active','1')
												->where('is_verified','1')->get());
				}
			}
			else{
				 $results->push(Coupon::where('type','d')
								->where('is_active','1')
								->where('is_verified','1')->get());
			}
		}
		elseif($request->type == 'coupon'){
			if(isset($s_array) && count($s_array)>0 && isset($c_array) && count($c_array)>0){
				foreach($s_array as $s_id){
					foreach($c_array as $c_id){
				  	$results->push(Coupon::where('store_id',$s_id)
				  							->where('category_id',$c_id)
				  							->where('type','c')
		  									->where('is_active','1')
												->where('is_verified','1')->get());
					}
				}
			}
			elseif(isset($s_array) && count($s_array)>0){
				foreach($s_array as $id){
				  $results->push(Coupon::where('store_id',$id)
				  							->where('type','c')
		  									->where('is_active','1')
												->where('is_verified','1')->get());
				}
			}
			elseif(isset($c_array) && count($c_array)>0){
				foreach($c_array as $id){
				  $results->push(Coupon::where('store_id',$id)
				  							->where('type','c')
		  									->where('is_active','1')
												->where('is_verified','1')->get());
				}
			}
			else{
				 $results->push(Coupon::where('type','c')
								->where('is_active','1')
								->where('is_verified','1')->get());
			}
		}
		$results = $results->flatten()->sortbydesc('created_at');
		$results = $this->paginate($results);
		if($results != null && count($results)>0){
			return view('coupon.theme.allfilter', compact('results'));
		}
		else{
			return "No Results Found.";
		}
	}
	public function blogSearch(Request $searchKey)
	{
		$results = collect();
		$search_title = trim($searchKey->search);
		$blogs = Blog::where('title','LIKE',"%$search_title%")
		              ->orWhere('slug',$search_title)
		              ->where('is_active','1')
		              ->orderBy('created_at','desc')->paginate(21);
		return view('coupon.theme.search-blog',compact('blogs','search_title'));
	}

	public function paginate($items, $perPage = 36, $page = null, $options = [])
	{
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $options = ['path' => Paginator::resolveCurrentPath()];
    $items = $items instanceof Collection ? $items : Collection::make($items);
    return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
	}
}
