{{-- <div class="deal-block">
	<div class="ad-img">
		<a href="#" title="Ad"><img src="{{asset('images/ads/ad-02.jpg')}}" class="img-fluid" alt="Ad"></a>
	</div>
	<div class="ad-footer text-center">Advertisement</div>
</div> --}}
@php
	$settings=DB::table('settings')->first();
@endphp
@if(isset($p_store) && count($p_store)>0)
	<div class="page-sidebar-widget popular-store-widget">
		<h6 class="widget-heading">Featured Stores</h6>
		<div id="sidebar-store-slider" class="sidebar-store-slider owl-carousel text-center">
			@foreach($p_store as $key => $item)
				<div class="brand-img-two">
					<a href="{{url('store-dtl/'.$item->slug)}}" title="{{$item->title}}"><img src="{{asset('images/store/'.$item->image)}}" class="img-fluid" alt="Store"></a>
				</div>
			@endforeach
		</div>
	</div>
@endif
@if(isset($r_post) && count($r_post)>0)
	<div class="page-sidebar-widget recent-posts-widget">
		<h6 class="widget-heading">Recent Deals</h6>
		<ul>                                        
			@foreach($r_post as $post)
				<li><a href="{{url('post/'.$post->uni_id.'/'.$post->slug)}}" title="Post">{{$post->title}}</a></li>
			@endforeach
		</ul>
	</div>
@endif
@if(isset($blogs_side) && count($blogs_side)>0)
	<div class="page-sidebar-widget recent-posts-widget">
		<h6 class="widget-heading">Recent Blogs</h6>
		<ul>                                        
			@foreach($blogs_side as $blog)
				<li><a href="{{url('blog-dtl/'.$blog->slug)}}" title="Post">{{$blog->title}}</a></li>
			@endforeach
		</ul>
	</div>
@endif
<div class="page-sidebar-widget sidebar-info-widget">
	<h6 class="widget-heading">{{$settings->w_name}}</h6>
	<p>{{$settings->sidebar_abt}}</p>
</div>
{{-- @if(isset($t_post) && count($t_post)>0)
	<div class="page-sidebar-widget recent-posts-widget">
		<h6 class="widget-heading">Trending Posts</h6>
		<ul>                                        
			@foreach($t_post as $posts)
				<li><a href="{{url('post/'.$posts->uni_id.'/'.$posts->slug)}}" title="Post">{{$posts->title}}</a></li>
			@endforeach
		</ul>
	</div>
@endif --}}