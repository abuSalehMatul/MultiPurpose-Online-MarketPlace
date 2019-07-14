@extends('coupon.layouts.theme')
@section('main-content')
<!-- blog -->
	<section id="account" class="coupon-page-main-block account-page-main">
		<div class="container">
			<div class="forum-page-header">
				<div class="forum-page-heading-block">
					<h5 class="forum-page-heading">{{$tag->title}} Blogs</h5>
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
							@if(isset($blogs) && count($blogs)>0)
								@foreach($blogs as $blog)
									<div class="col-lg-4 col-md-6">
										<div class="blog-post-main">
											<div class="blog-img">
												<a href="{{url('blog-dtl/'.$blog->uni_id.'/'.$blog->slug)}}" title="Blog Post"><img src="{{asset('coupon/images/blog/'.$blog->image)}}" class="img-fluid" alt="Blog Post"></a>
											</div>
											<div class="blog-post-dtl">
												<h6 class="blog-post-heading"><a href="{{url('blog-dtl/'.$blog->uni_id.'/'.$blog->slug)}}" title="Blog Post">{{$blog->title}}</a></h6>
												<div class="blog-post-tags">
													<ul>
														<li><i class="far fa-clock"></i>{{date('d F Y', strtotime($blog->created_at))}}</li>
														<li><i class="far fa-user"></i><a href="{{url('profile/'.$blog->users->id)}}" title="{{$blog->users->name}}">{{$blog->users->name}}</a></li>
														<li><i class="far fa-comments"></i>119</li>
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
							@endif
						</div>
						<nav aria-label="blog-post-pagination">
						  <ul class="pagination">
				        {{ $blogs->links() }}                    
				      </ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end blog -->
@endsection