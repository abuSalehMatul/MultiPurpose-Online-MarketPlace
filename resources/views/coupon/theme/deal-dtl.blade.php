@extends('coupon.layouts.theme')
@section('main-content')
<!-- coupons -->
	<section id="forum" class="coupon-page-main-block">
		<div class="container">
			<div class="forum-page-header">
				<div class="forum-page-heading-block">
					<h5 class="forum-page-heading">Exclusive Store Deals</h5>
				</div>
			</div>
			<!-- breadcrumb -->
			<div id="breadcrumb" class="breadcrumb-main-block">
				<div class="breadcrumb-block">
					<ol class="breadcrumb">
						<li><a href="{{url('/')}}" title="Home">Home</a></li>
						<li><a href="{{url('deal')}}" title="Coupons">Deals</a></li>
						<li class="active">{{$store->title}}</li>
					</ol>
				</div>
			</div>
			<!-- breadcrumb end -->
			<div class="coupon-page-block">
				<div class="coupon-dtl-outer">
					<div class="row">
						<div class="col-lg-9 col-md-8">
							<div id="filterdata">
								@if(isset($coupon_dtl) && count($coupon_dtl)>0)
								  @foreach($coupon_dtl as $key => $item)
										<div class="coupon-main-block">
											<div class="coupon-dtl-block">
												<div class="row">
													<div class="col-lg-2 col-4">
														<div class="coupon-disc-block text-center v-center">
															<h3 class="coupon-disc">{{$item->discount ? $item->discount : '0'}}%</h3>
															<h3 class="coupon-disc">Off</h3>
														</div>
													</div>
													<div class="col-lg-7 col-8 border-l">
														<div class="coupon-dtl">
															<h5 class="coupon-title"><a href="{{url('post/'.$item->uni_id.'/'.$item->slug)}}" title="{{$item->title}}">{{str_limit($item->title,45)}}</a></h5>
															<div class="coupon-short-disc"><p>{!! substr(strip_tags($item->detail), 0, 100) !!}..</p></div>
															<div class="coupon-expiry">
																@if($item->expiry)
																	Ends on {{date('d F Y', strtotime($item->expiry))}}
																@endif
															</div>
														</div>
													</div>
													<div class="col-lg-3 text-center">
														<div class="grab-coupon-block">
															@if($item->is_exclusive == 1)
																<div class="coupon-badge"><i class="far fa-star"></i>Deal's Exclusive</div>
															@endif
															<div class="grab-coupon-btn">
																<a href="#" class="btn btn-primary" title="Grab Deal" data-toggle="modal" data-target="#coupon-id-{{$key}}">Grab Deal</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="coupon-popup">
												<div class="modal fade login-form-main" id="coupon-id-{{$key}}" tabindex="-1" role="dialog" aria-labelledby="CouponTitle{{$key}}" aria-hidden="true">
												  <div class="modal-dialog modal-dialog-centered" role="document">
												    <div class="modal-content text-center">
												      <div class="login-header">
												        <h5 class="coupon-disc-title" id="CouponTitle{{$key}}">Deal Detail</h5>
												        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
												          <span aria-hidden="true" class="close-btn">&times;</span>
												        </button>
												      </div>
												      <div class="modal-body">
												      	<div class="coupon-popup-dtl">
												      		<div class="coupon-popup-header">
												      			<h6 class="coupon-popup-title">Click here to activate the deal</h6>
												      		</div>
												      		<div class="coupon-popup-btn">
											      				<a href="{{$item->link != Null ? $item->link : $item->store->link}}" title="{{$item->store->title}}" target="_blank" data-id="{{$item->id}}" class="grab-now btn btn-primary">Grab Deal</a>
												      		</div>
												      	</div>
											      		<div class="coupon-footer coupon-modal-footer">
																	<div class="coupon-footer-dtl">
																		<ul>
																  		@php														
																				$facebook = Share::load(url('post/'.$item->uni_id.'/'.$item->slug), 'Sharing')->facebook();
																				$twitter = Share::load(url('post/'.$item->uni_id.'/'.$item->slug), 'Sharing')->twitter();
																				$gplus = Share::load(url('post/'.$item->uni_id.'/'.$item->slug), 'Sharing')->gplus();
																				$linkedin = Share::load(url('post/'.$item->uni_id.'/'.$item->slug), 'Sharing')->linkedin();
																				$pinterest = Share::load(url('post/'.$item->uni_id.'/'.$item->slug), 'Sharing')->pinterest();
																			@endphp
																			<li>
																				@if($item->is_verified == 1)
																					<i class="fas fa-check clr-green"></i>Verified Deal
																				@else
																					Unverified
																				@endif
																			</li>
																			<li><i class="fas fa-shopping-cart clr-orange"></i><a href="{{url('store-dtl/'.$item->store->slug)}}" title="{{$item->store->title}}">{{$item->store->title}}</a></li>
																			<li><i class="fas fa-users clr-purple"></i>{{$item->user_count}} People Used</li>
																			<li class="share-button sharer"><i class="fas fa-share-alt clr-blue"></i><a class="share-btn" title="Share Deal">Share Deal</a>
																				<div class="social top center networks-5 ">
																			    <a class="fbtn share facebook" href="{{$facebook}}"><i class="fa fa-facebook"></i></a> 
																			    <a class="fbtn share gplus" href="{{$gplus}}"><i class="fa fa-google-plus"></i></a> 
																			    <a class="fbtn share twitter" href="{{$twitter}}"><i class="fa fa-twitter"></i></a> 
																			    <a class="fbtn share pinterest" href="{{$pinterest}}"><i class="fa fa-pinterest"></i></a>
																			    <a class="fbtn share linkedin" href="{{$linkedin}}"><i class="fa fa-linkedin"></i></a>
																				</div>
																			</li>
																		</ul>
																	</div>
																</div>
												      </div>
												    </div>
												  </div>
												</div>
											</div>
											<div class="coupon-footer">
												<div class="coupon-footer-dtl">
													<ul>
														<li>
															@if($item->is_verified == 1)
																<i class="fas fa-check clr-green"></i>Verified Deal
															@else
																Unverified
															@endif
														</li>
														<li><i class="fas fa-shopping-cart clr-orange"></i><a href="{{url('store-dtl/'.$item->store->slug)}}" title="{{$item->store->title}}">{{$item->store->title}}</a></li>
														<li><i class="fas fa-users clr-purple"></i>{{$item->user_count}} People Used</li>
														<li class="share-button sharer"><i class="fas fa-share-alt clr-blue"></i><a class="share-btn" title="Share Coupon">Share Deal</a>
															<div class="social top center networks-5 ">
														    <a class="fbtn share facebook" href="{{$facebook}}"><i class="fa fa-facebook"></i></a> 
														    <a class="fbtn share gplus" href="{{$gplus}}"><i class="fa fa-google-plus"></i></a> 
														    <a class="fbtn share twitter" href="{{$twitter}}"><i class="fa fa-twitter"></i></a> 
														    <a class="fbtn share pinterest" href="{{$pinterest}}"><i class="fa fa-pinterest"></i></a>
														    <a class="fbtn share linkedin" href="{{$linkedin}}"><i class="fa fa-linkedin"></i></a>
															</div>
														</li>
													</ul>
												</div>
											</div>
										</div>
									@endforeach
									<div class="forum-footer">
										<div class="row">
											<div class="col-lg-4 col-md-8">
												<nav aria-label="forum-pagination">
												  <ul class="pagination">
										        {{ $coupon_dtl->links() }}                    
										      </ul>
												</nav>
											</div>
											<div class="col-lg-4 ml-lg-auto col-md-4 d-none d-lg-block">
												<div class="new-topic-btn">
													<a href="{{url('submit')}}" title="Post New Topic" class="btn btn-primary">Submit New Coupon</a>
												</div>
											</div>
										</div>
									</div>
								@else
									<h6>No Data Found</h6>
								@endif							
							</div>
						</div>
						<div class="col-lg-3 col-md-4">
							<div class="coupon-sidebar">
								<div class="page-sidebar-widget brand-widget text-center">
									<div class="brand-logo">
										<a href="{{$store->link}}" title="{{$store->title}}" target="_blank"><img src="{{asset('coupon/images/store/'.$store->image)}}" class="img-fluid" alt="store"></a>
									</div>
									<div class="brand-visit-btn">
										<a href="{{$store->link}}" title="{{$store->title}}" target="_blank" class="btn btn-primary">Visit Store</a>
									</div>
								</div>
								@if(isset($category_list) && count($category_list)>0)
									<div class="page-sidebar-widget categories-widget">
										<h6 class="widget-heading">Categories</h6>
										<form class="categories-form">
						      		<div class="form-group">
						      			<input type="text" class="form-control" id="catInput" placeholder="Search Categories">
						      		</div>
						      		<div class="checkbox-main-group">
							      		<ul id="catList" class="form-group" data-store="{{$store->id}}" data-type="categorydeal">
							      			@foreach($category_list as $item)
							      				<li class="custom-control custom-checkbox">
													    <input type="checkbox" name="catBox" class="custom-control-input" id="{{$item->id}}">
													    <label class="custom-control-label" for="{{$item->id}}">{{$item->title}}</label>
												  	</li>
													@endforeach
							      		</ul>
							      	</div>
						      	</form>
									</div>
								@endif
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
@section('custom-scripts')
<script>
$(document).ready(function(){var a,e,n=null;function c(t,a,e,n){$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},type:"GET",url:"{{ url('filtersearch') }}?page="+t,data:{f_array:a,type:n,f_id:e},success:function(t){console.log(t),$("#filterdata").html(t)},error:function(t,a,e){console.log(t)}}).fail(function(){alert("We are facing some issues currenlty. Please try again later.")})}$("#catList li").change(function(){a=$("input:checkbox[name=catBox]:checked").map(function(){return $(this).attr("id")}).get(),e=$("#catList").data("store"),n=$("#catList").data("type");c(1,a,e,n)}),$("body").on("click",".filter-pagination a",function(t){t.preventDefault(),c($(this).attr("href").split("page=")[1],a,e,n)})});
</script>
@endsection