@extends('coupon.layouts.theme')
@section('main-content')
<!-- blog -->
	<section id="account" class="coupon-page-main-block account-page-main">
		<div class="container">
			<div class="forum-page-header">
				<div class="forum-page-heading-block">
					<h5 class="forum-page-heading">{{$search_title}} Related Blogs</h5>
				</div>
			</div>
			<!-- breadcrumb -->
			<div id="breadcrumb" class="breadcrumb-main-block">
				<div class="breadcrumb-block">
					<ol class="breadcrumb">
						<li><a href="{{url('/')}}" title="Home">Home</a></li>
						<li class="active">Blogs</li>
					</ol>
				</div>
			</div>
			<!-- breadcrumb end -->
			<div class="account-page">
				<div class="blog-page-outer blog-page-two">
					<div class="blog-page-main-block">
						<div class="row">
							<div class="col-lg-9 col-md-8">
								@if(isset($blogs) && count($blogs)>0)
									<div class="row">							
										@foreach($blogs as $key => $item)
											<div class="col-lg-4 col-md-6">
												<div class="blog-post-main">
													<div class="blog-img">
														<a href="{{url('blog-dtl/'.$item->uni_id.'/'.$item->slug)}}" title="Blog Post"><img src="{{asset('coupon/images/blog/'.$item->image)}}" class="img-fluid" alt="Blog Post"></a>
													</div>
													<div class="blog-post-dtl">
														<h6 class="blog-post-heading"><a href="{{url('blog-dtl/'.$item->uni_id.'/'.$item->slug)}}" title="Blog Post">{{$item->title}}</a></h6>
														<div class="blog-post-tags">
															<ul>
																<li><i class="far fa-clock"></i>{{date('d F Y', strtotime($item->created_at))}}</li>
																<li><i class="far fa-user"></i><a href="{{url('profile/'.$item->users->id)}}" title="{{$item->users->name}}">{{$item->users->name}}</a></li>
																<li><i class="far fa-comments"></i>119</li>
															</ul>
														</div>
														<div class="blog-post-text">
															<p>{!! \Illuminate\Support\Str::words($item->desc,100,'...')!!}</p>
														</div>
														<div class="blog-post-link">
															<a href="{{url('blog-dtl/'.$item->uni_id.'/'.$item->slug)}}" title="Read More">Read More</a>
														</div>
													</div>
												</div>
											</div>
										@endforeach
									</div>
									<nav aria-label="blog-post-pagination">
									  <ul class="pagination">
							        {{ $blogs->links() }}                    
							      </ul>
									</nav>
								@else
									<h6>No Results Found</h6>
								@endif
							</div>
							<div class="col-lg-3 col-md-4">
								<div class="coupon-sidebar">
									<div class="page-sidebar-widget search-widget">
										<div class="forum-search-block text-right">
											{!! Form::open(['method' => 'GET', 'action' => 'SearchController@blogSearch', 'class' => 'forum-search']) !!}
												{!! Form::text('search', null, ['class' => 'forum-search-input form-control', 'placeholder' => 'Search Blog']) !!}
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
									</div>
	      					@include('coupon.includes.side-bar')
									<div class="page-sidebar-widget archive-widget recent-posts-widget">
										<h5 class="widget-heading">Archives</h5>
										<ul>
											<li><a href="#" title="May 2017">May 2017</a></li>
											<li><a href="#" title="July 2017">July 2017</a></li>
											<li><a href="#" title="December 2017">December 2017</a></li>
											<li><a href="#" title="January 2018">January 2018</a></li>
											<li><a href="#" title="March 2018">March 2018</a></li>
										</ul>
									</div>
									@if(isset($blog->tags))
										<div class="page-sidebar-widget tags-widget">
											<h5 class="widget-heading">Tags</h5>
											<ul>
												@foreach($blog->tags as $tag)
													<li><a href="{{url('tag/'.$tag->slug)}}" title="{{$tag->title}}">{{$tag->title}}</a></li>
												@endforeach
											</ul>
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end blog -->
@endsection