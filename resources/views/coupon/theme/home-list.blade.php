@extends('coupon.layouts.theme')
@section('main-content')
<!-- slider start -->
	<section id="slider" class="slider {{$slider->is_parallax ? 'parallax' : ''}}" style="background-image: url('{{asset('images/'.$slider->image)}}">
		@if($slider->is_overlay)
			<div class="overlay-bg"></div>
		@endif
		<div class="container">
			<div class="slider-block text-center">
				<div class="slider-dtl">
					<h1 class="slider-heading">{{$slider->heading}}</h1>
					<p>{{$slider->subheading}}</p>
				</div>			
				<div class="search-block">
					{!! Form::open(['method' => 'GET', 'action' => 'SearchController@homeSearch', 'class' => 'search-form']) !!}
						{!! Form::text('search', null, ['class' => 'search-input', 'placeholder' => 'Search']) !!}
					  <button type="submit" class="search-button">
					    <svg class="submit-button">
					      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#search"></use>
					    </svg>
					  </button>
				  {!! Form::close() !!}
					<svg xmlns="http://www.w3.org/2000/svg" width="0" height="0" display="none">
					  <symbol id="search" viewBox="0 0 32 32">
					    <path d="M 19.5 3 C 14.26514 3 10 7.2651394 10 12.5 C 10 14.749977 10.810825 16.807458 12.125 18.4375 L 3.28125 27.28125 L 4.71875 28.71875 L 13.5625 19.875 C 15.192542 21.189175 17.250023 22 19.5 22 C 24.73486 22 29 17.73486 29 12.5 C 29 7.2651394 24.73486 3 19.5 3 z M 19.5 5 C 23.65398 5 27 8.3460198 27 12.5 C 27 16.65398 23.65398 20 19.5 20 C 15.34602 20 12 16.65398 12 12.5 C 12 8.3460198 15.34602 5 19.5 5 z" />
					  </symbol>
					</svg>
				</div>
				<div class="slider-btn">
					<div class="row">
						<div class="col-md-6 text-right">
							<a href="{{$settings->btn_link}}" class="btn btn-primary" title="{{$settings->btn_title}}">{{$settings->btn_title}}</a>
						</div>
						<div class="col-md-6 text-left">
							<a href="{{$settings->btn_link2}}" class="btn btn-primary" title="{{$settings->btn_title2}}">{{$settings->btn_title2}}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<!-- end slider -->
<!-- home categories -->
	<section id="home-cat" class="home-cat-main-block">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 d-none d-lg-block">
					<div class="home-filter cat-nav">
						<ul>
							<li id="all" class="cat-link active"><a href="javascript:void(0)" title="All">Recent</a></li>
							<li id="featured" class="cat-link"><a href="javascript:void(0)" title="New Deals">Featured</a></li>
							<li id="trending" class="cat-link"><a href="javascript:void(0)" title="Trending">Trending</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="home-filter cat-nav-two">
						<ul>
							<li>
								<div class="sort-dropdown">
									@if(isset($store_list) && count($store_list) > 0)
									  <select class="form-control" name="store" id="store-list">
											<option value="all">By Merchant</option>
											@foreach($store_list as $item)
												<option value="{{$item->id}}">{{strtok($item->title,' ')}}</option>
											@endforeach
												{{-- <option value="all">All</option> --}}
										</select>
									@endif
								</div>
							</li>
							<li>
								<div class="sort-dropdown">
									@if(isset($category_list) && count($category_list) > 0)
								  	<select class="form-control" name="store" id="cat-list">
											<option value="all">By Category</option>
											@foreach($category_list as $item)
												<option value="{{$item->id}}">{{strtok($item->title,' ')}}</option>
											@endforeach
											{{-- <option value="all">All</option> --}}
										</select>
									@endif
								</div>
							</li>						
						</ul>
					</div>
				</div>
				<div class="col-lg-1">
					<div class="cat-nav-two">
						<ul>
							<li class="layout-icon"><a href="{{url('/')}}" title="Grid"><i class="fas fa-th"></i></a></li>
							<li class="layout-icon"><a href="{{url('home-list')}}" title="List"><i class="fas fa-list"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
<!-- end home categories -->
<!-- deal -->
	<section id="deal" class="deal-main-block deal-list-page">
		<div class="container">
			@if(isset($settings) && $settings->is_recent_deals)
				<h6 class="section-heading">Deals & Coupons</h6>
				<div id="home-filter-section">
					<div class="row">						
						<div class="col-lg-9 col-md-8">
							@if(isset($results) && count($results) > 0)
								<div class="deal-block-outer results">				
									@foreach($results as $key => $item)
										<div class="coupon-main-block deal-list-block">
											<div class="coupon-dtl-block">
												<div class="row">
													<div class="col-lg-3">
														<div class="deal-img">
															<a href="{{url('post/'.$item->uni_id.'/'.$item->slug)}}" title="{{$item->title}}"><img src="{{$item->image != null ? asset('images/coupon/'.$item->image) : asset('images/store/'.$item->store->image)}}" class="img-fluid" alt="Deal"></a>
														</div>
													</div>
													<div class="col-lg-6 border-l">
														<div class="coupon-dtl">
															<h5 class="coupon-title"><a href="{{url('post/'.$item->uni_id.'/'.$item->slug)}}" title="{{$item->title}}">{{str_limit($item->title, 60)}}</a></h5>
															<div class="coupon-short-disc"><p>{!! substr(strip_tags($item->detail), 0, 100) !!}..</p>
															</div>
															<div class="coupon-expiry">
																@if($item->expiry)
																	Ends on {{date('d F Y', strtotime($item->expiry))}}
																@endif
															</div>
														</div>
													</div>
													<div class="col-lg-3 text-center">
														<div class="grab-coupon-block">
															<div class="deal-price">
																@if($item->price)
																	<sup><i class="{{$settings->currency}}" aria-hidden="true"></i></sup> {{$item->price}}
																@endif
															</div>
															<div class="deal-disc">{{$item->discount ? $item->discount."% Off" : ''}}</div>
															<div class="grab-coupon-btn">
																<a href="{{$item->link != Null ? $item->link : $item->store->link}}" title="{{$item->store->title}}" target="_blank" data-id="{{$item->id}}" class="grab-now btn btn-primary">Grab Now</a>
															</div>
															<div class="deal-time"><i class="far fa-clock"></i>{{$item->created_at->diffForHumans()}}</div>
														</div>
													</div>
												</div>
											</div>
											<div class="coupon-footer">
												<div class="coupon-footer-dtl">
													<ul>
														<li><i class="fas fa-user clr-purple"></i><a href="{{url('profile/'.$item->user_id)}}" title="User">{{strtok($item->user->name,' ')}}</a></li>
														<li><i class="fas fa-shopping-cart clr-orange"></i><a href="{{url('store-dtl/'.$item->store->slug)}}" title="{{$item->store->title}}">{{$item->store->title}}</a></li>
														<li><i class="fas fa-comments clr-blue"></i><a href="{{url('post/'.$item->uni_id.'/'.$item->slug)}}" title="Comments">{{$item->comments()->count()}}</a></li>
														<li>
															@if($item->is_featured == 1)
																<i class="fas fa-star clr-green"></i> Featured
															@endif
														</li>
														<li>
															<i class="fa fa-eye"></i>{{$item->views()->count()}}
														</li>
													</ul>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							@else
								<p>No Results</p>
							@endif
							<div id="results"><!-- results appear here --></div>
							@if(count($results) > 35)
								<div class="btn btn-primary load-more-btn">Load More</div>
							@endif
			    		<div class="ajax-loading text-center"><i class="fa fa-spinner fa-spin" style="font-size:40px"></i></div>
						</div>
						<div class="col-lg-3 col-md-4">
							<div class="coupon-sidebar">
    						@include('coupon.includes.side-bar')
    					</div>
    				</div>
					</div>
				</div>
			@endif
		</div>
	</section>
<!-- end deal -->
<!-- categories -->
@if(isset($settings) && $settings->is_category_block)
	<section id="categories" class="categories-main-block">
		<div class="container">			
			@if(isset($category_list) && count($category_list) > 0)
				<div class="section">
					<h4 class="section-heading">Categories</h4>
				</div>
				<div class="cat-block text-center">
					<div class="row">
						@foreach($category_list->take(12) as $key => $item)
							<div class="col-lg-2 col-md-4">
								<div class="category-block">
									<a href="{{url('category-dtl/'.$item->slug)}}" title="Categories">
										<div class="cat">
											<div class="{{$item->icon ? 'cat-icon' : ''}}">
												@if($item->icon)
													<i class="fa {{$item->icon}}"></i>
												@else
													<img src="{{asset('images/category/'.$item->image)}}" class="img-fluid" alt="category">
												@endif
											</div>
											<h5 class="cat-title">{{strtok($item->title,' ')}}</h5>
										</div>
									</a>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			@endif
		</div>
	</section>
@endif
<!-- end categories -->
<!-- blogs -->
@if(isset($blogs))
	<section id="home-blog" class="home-blog-main-block">
		<div class="container">
			<div class="section">
				<h4 class="section-heading">Recent Blogs</h4>
			</div>
			<div class="blog-page-outer blog-page-two">
				<div class="blog-page-main-block">
					<div class="row">
						@foreach($blogs as $blog)
							<div class="col-lg-4 col-md-6">
								<div class="blog-post-main">
									<div class="blog-img">
										<a href="{{url('blog-dtl/'.$blog->uni_id.'/'.$blog->slug)}}" title="Blog Post"><img src="{{asset('images/blog/'.$blog->image)}}" class="img-fluid" alt="Blog Post"></a>
									</div>
									<div class="blog-post-dtl">
										<h6 class="blog-post-heading"><a href="blog-post.html" title="Blog Post">{{$blog->title}}</a></h6>
										<div class="blog-post-tags">
											<ul>
												<li><i class="far fa-clock"></i>{{date('d F Y', strtotime($blog->created_at))}}</li>
												<li><i class="far fa-user"></i><a href="{{url('profile/'.$blog->users->id)}}" title="{{$blog->users->name}}">{{$blog->users->name}}</a></li>
												<li><i class="far fa-comments"></i>{{$blog->comments()->count()}}</li>
											</ul>
										</div>
										<div class="blog-post-text">
											<p>{!! \Illuminate\Support\Str::words($blog->desc,170,'...')!!}</p>
										</div>
										<div class="blog-post-link">
											<a href="{{url('blog-dtl/'.$blog->uni_id.'/'.$blog->slug)}}" title="Read More">Read More</a>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</section>
@endif
<!-- end blogs -->
<!-- featured stores -->
@if(isset($settings) && $settings->is_store_slider)
	<div id="featured-stores" class="featured-stores-main-block">
		<div class="container">
			@if(isset($store) && count($store) > 0)
				<div id="featured-store-slider" class="featured-stores-slider owl-carousel">
					@foreach($store as $key => $item)
						<div class="store-img">
							<a href="{{url('store-dtl/'.$item->slug)}}" title="Store"><img src="{{asset('images/store/'.$item->image)}}" class="img-fluid" alt="Store"></a>
						</div>
					@endforeach
				</div>
			@endif
		</div>
	</div>
@endif
<!-- end featured stores -->
@endsection
@section('custom-scripts')
<script>  
	$(document).ready(function(){$(".cat-nav li").click(function(e){$(this).addClass("active"),$(this).parent().children("li").not(this).removeClass("active")});var e="all",t="all",a="all",l=1;function n(l){$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},type:"GET",url:"{{ url('homefilter') }}?page="+l,data:{filter:t,s_filter:e,c_filter:a,main:"1"},datatype:"html",beforeSend:function(){$(".load-more-btn").hide(),$(".ajax-loading").show()},success:function(e){console.log(e)},error:function(e,t,a){console.log(e)}}).done(function(e){if(!e)return console.log("no"),$(".ajax-loading").hide(),1==l&&$(".results").html("No Results Found!"),0;$(".ajax-loading").hide(),1==l?$(".results").html(e):$(".results").append(e),$(e).find(".coupon-dtl-block").length>35&&$(".load-more-btn").show()}).fail(function(e,t,a){alert("We are facing some issues currenlty. Please try again later.")})}$(".home-filter li").on("change keyup",function(){t=$(".cat-nav li.active").attr("id"),e=$("#store-list").val(),a=$("#cat-list").val(),console.log(a),console.log(t),n(l=1)}),$(".load-more-btn").on("click",function(){n(++l)})});
</script>
@endsection
