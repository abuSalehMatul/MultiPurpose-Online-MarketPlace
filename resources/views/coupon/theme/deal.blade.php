@extends('coupon.layouts.theme')
@section('main-content')
	<!-- coupons -->
	<section id="forum" class="coupon-page-main-block">
		<div class="container">
			<div class="forum-page-header">
				<div class="forum-page-heading-block">
					<h5 class="forum-page-heading">Deals</h5>
				</div>
			</div>
			<!-- breadcrumb -->
			<div id="breadcrumb" class="breadcrumb-main-block">
				<div class="breadcrumb-block">
					<ol class="breadcrumb">
						<li><a href="{{url('/')}}" title="Home">Home</a></li>
						<li class="active">Deals</li>
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
									<div class="row">
								  	@foreach($coupon_dtl as $key => $item)
											<div class="col-lg-4 col-md-6">
												<div class="coupon-main-block coupon-single">
													<div class="coupon-dtl-block text-center">
														<div class="row">
															<div class="coupon-dtl">
																<div class="coupon-img">
																	<a href="{{url('post/'.$item->uni_id.'/'.$item->slug)}}" title="{{$item->title}}"><img src="{{$item->image != null ? asset('images/coupon/'.$item->image) : asset('images/store/'.$item->store->image)}}" class="img-fluid" alt="{{$item->title}}"></a>
																</div>
																<h6 class="coupon-title"><a href="{{url('post/'.$item->uni_id.'/'.$item->slug)}}" title="{{$item->title}}">{{str_limit($item->title, 60)}}</a></h6>
																<div class="coupon-expiry">
																	@if($item->expiry)
																		Expires on {{date('d F Y', strtotime($item->expiry))}}
																	@endif
																</div>
																{{-- <div class="grab-coupon-block">
																	<div class="grab-coupon-btn coupon-btn-outer">
																		<a href="#" class="btn btn-primary cpn-btn" title="Grab Deal" data-toggle="modal" data-target="#coupon-id-{{$key}}"></a>
																		<a href="#" data-toggle="modal" data-target="#coupon-id-{{$key}}">
																			<div class="cpn-btn-shape"></div>
																			<div class="s1">
																				<div class="t1"></div>
																				<div class="t1">
																					<div class="t2"></div>
																				</div>
																			</div>
																		</a>
																		<span><a href="#" data-toggle="modal" data-target="#coupon-id-{{$key}}">Grab Deal</a></span>
																	</div>
																</div> --}}
																<div class="grab-coupon-btn">
																	<a href="#" class="btn btn-primary" title="Get Deal" data-toggle="modal" data-target="#coupon-id-{{$key}}">Grab Deal</a>
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
																					    <a class="fbtn share pinterest" href="{{$linkedin}}"><i class="fa fa-pinterest"></i></a>
																					    <a class="fbtn share linkedin" href="{{$pinterest}}"><i class="fa fa-linkedin"></i></a>
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
														<div class="coupon-footer-dtl text-center">
															<ul>
																<li class="share-button sharer"><i class="fas fa-share-alt clr-blue"></i><a class="share-btn" title="Share Deal"> Share Deal</a>
																	<div class="social top center networks-5 ">
																    <a class="fbtn share facebook" href="{{$facebook}}"><i class="fa fa-facebook"></i></a> 
																    <a class="fbtn share gplus" href="{{$gplus}}"><i class="fa fa-google-plus"></i></a> 
																    <a class="fbtn share twitter" href="{{$twitter}}"><i class="fa fa-twitter"></i></a> 
																    <a class="fbtn share pinterest" href="{{$linkedin}}"><i class="fa fa-pinterest"></i></a>
																    <a class="fbtn share linkedin" href="{{$pinterest}}"><i class="fa fa-linkedin"></i></a>
																	</div>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										@endforeach
									</div>
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
								<div id="filter-list" data-type="deal">
									@if(isset($store_list) && count($store_list)>0)
										<div class="page-sidebar-widget categories-widget">
											<h6 class="widget-heading">Stores</h6>
											<form class="categories-form">
							      		<div class="form-group">
							      			<input type="text" id="storeInput" class="form-control" placeholder="Search Stores">
							      		</div>
							      		<div class="checkbox-main-group">
								      		<ul id="storeList" class="form-group">
								      			@foreach($store_list as $key => $item)
							      					<li class="custom-control custom-checkbox">
														    <input type="checkbox" name="storeBox" class="custom-control-input" id="{{$item->title}}" data-uid="{{$item->id}}">
														    <label class="custom-control-label" for="{{$item->title}}">{{$item->title}}</label>
														  </li>
														@endforeach
								      		</ul>
								      	</div>
							      	</form>
										</div>
									@endif	
									@if(isset($category_list) && count($category_list)>0)
										<div class="page-sidebar-widget categories-widget">
											<h6 class="widget-heading">Categories</h6>
											<form class="categories-form">
							      		<div class="form-group">
							      			<input type="text" class="form-control" id="catInput" placeholder="Search Categories">
							      		</div>
							      		<div class="checkbox-main-group">
								      		<ul id="catList" class="form-group">
								      			@foreach($category_list as $item)
								      				<li class="custom-control custom-checkbox">
														    <input type="checkbox" name="catBox" class="custom-control-input" id="{{$item->title}}" data-uid="{{$item->id}}">
														    <label class="custom-control-label" for="{{$item->title}}">{{$item->title}}</label>
													  	</li>
														@endforeach
								      		</ul>
								      	</div>
							      	</form>
										</div>
									@endif
								</div>
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
$(document).ready(function(){var e,a,n=null;function o(t,e,a,n){console.log(e),$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},type:"GET",url:"{{ url('allfilter') }}?page="+t,data:{c_array:e,s_array:a,type:n},success:function(t){console.log(t),$("#filterdata").html(t)},error:function(t,e,a){console.log(t)}}).fail(function(){alert("We are facing some issues currenlty. Please try again later.")})}$("#filter-list li").change(function(){e=$("input:checkbox[name=catBox]:checked").map(function(){return $(this).data("uid")}).get(),a=$("input:checkbox[name=storeBox]:checked").map(function(){return $(this).data("uid")}).get(),n=$("#filter-list").data("type");o(1,e,a,n)}),$("body").on("click",".filter-pagination a",function(t){t.preventDefault(),console.log(a),o($(this).attr("href").split("page=")[1],e,a,n)})}); 
</script>
@endsection