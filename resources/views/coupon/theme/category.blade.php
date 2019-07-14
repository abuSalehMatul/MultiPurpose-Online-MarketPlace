@extends('coupon.layouts.theme')
@section('main-content')
<!-- category -->
	<section id="forum" class="coupon-page-main-block">
		<div class="container">
			<div class="forum-page-header">
				<div class="forum-page-heading-block">
					<h5 class="forum-page-heading">Categories</h5>
				</div>
			</div>
			<!-- breadcrumb -->
			<div id="breadcrumb" class="breadcrumb-main-block">
				<div class="breadcrumb-block">
					<ol class="breadcrumb">
						<li><a href="{{url('/')}}" title="Home">Home</a></li>
						<li class="active">Categories</li>
					</ol>
				</div>
			</div>
			<!-- breadcrumb end -->
			<div class="coupon-page-block categories-page">
				<div class="coupon-dtl-outer">
					<div class="row">
						<div class="col-lg-9 col-md-8">
							@if(isset($category_list) && count($category_list) > 0)
								<div class="categories-main-block">
									<div class="cat-block text-center">
										<div class="row">
											@foreach($category_list as $key => $item)
												<div class="col-lg-4 col-md-6">
													<div class="category-block">
														<a href="{{url('category-dtl/'.$item->slug)}}" title="Categories">
															<div class="cat">
																<div class="{{$item->icon ? 'cat-icon' : 'cat-image'}}">
																	@if($item->icon)
																		<i class="fa {{$item->icon}}"></i>
																	@else
																		<img src="{{asset('coupon/images/category/'.$item->image)}}" class="img-fluid" alt="category">
																	@endif
																</div>
																<h5 class="cat-title">{{strtok($item->title, ' ')}}</h5>
															</div>
														</a>
													</div>
												</div>
											@endforeach
										</div>
									</div>
								</div>
							@endif
						</div>
						<div class="col-lg-3 col-md-4">
							<div class="coupon-sidebar">
      					@include('coupon.includes.side-bar')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<!-- end forum -->
@endsection