@extends('coupon.layouts.theme')
@section('main-content')
<!-- Profile -->
	<section id="account" class="coupon-page-main-block account-page-main">
		<div class="container">
			<div class="forum-page-header">
				<div class="forum-page-heading-block">
					<h5 class="forum-page-heading">Profile</h5>
				</div>
			</div>
			<!-- breadcrumb -->
			<div id="breadcrumb" class="breadcrumb-main-block">
				<div class="breadcrumb-block">
					<ol class="breadcrumb">
						<li><a href="{{url('/')}}" title="Home">Home</a></li>
						<li class="active">Profile</li>
					</ol>
				</div>
			</div>
			<!-- breadcrumb end -->
			<div class="account-page">
				<div class="coupon-dtl-outer">
					<div class="row">
						<div class="col-md-9">
							<div id= "follow" class="account-main-block account-box">
								<div class="row">
									<div class="col-lg-3">
										<div class="ac-profile-block">
											<div class="ac-profile-img">
												<img src="{{asset('images/user/'.$user->image)}}" alt="User">
											</div>
											<h6 class="ac-username">{{$user->name}}</h6>
											<div class="ac-post">{{$user->is_admin == '1' ? 'Administrator' : 'User'}}</div>
										</div>
									</div>
									<div class="col-lg-9">
										<div class="ac-profile-dtl">
											<h6 class="ac-holder-name">{{$user->name}}</h6>
											<div class="join-date">Joined Coupon on {{$user->created_at->format('jS F, Y')}}</div>
											<div class="ac-holder-info">
												<p>{{$user->brief}}</p>
											</div>
										</div>
										@if(!isset($auth) || $auth->id != $user->id)
											<div class="row">
												<div class="col-md-4">
													<div class="ac-btn">
														@auth
															<button type="button" id="follow-btn" class="btn-primary" data-follow="{{ $user->id }}">{{ $user->followers()->where('follower_id', $auth->id)->first() ? 'Unfollow' : 'Follow' }}</button>
														@else
															<button type="button" class="btn-primary" data-toggle="modal" data-target="#login" >Follow</button>
														@endauth
													</div>
												</div>
											</div>
										@endif
									</div>
								</div>
							</div>
							<div class="ac-facts account-box text-center">
								<div class="row">
									<div class="col-lg-3 col-md-6">
										<div class="facts-block">
											<h1 class="fact-heading">{{$deal}}</h1>
											<h6 class="fact-name">Deals Posted</h6>
										</div>
									</div>
									<div class="col-lg-3 col-md-6">
										<div class="facts-block">
											<h1 class="fact-heading">{{$coupon}}</h1>
											<h6 class="fact-name">Coupons Posted</h6>
										</div>
									</div>
									<div class="col-lg-3 col-md-6">
										<div class="facts-block">
											<h1 id="count" class="fact-heading">{{$user->followers->count()}}</h1>
											<h6 class="fact-name">Followers</h6>
										</div>
									</div>
									<div class="col-lg-3 col-md-6">
										<div class="facts-block">
											<h1 class="fact-heading">{{count($user->followings)}}</h1>
											<h6 class="fact-name">Followings</h6>
										</div>
									</div>
								</div>
							</div>							
							@if(isset($post) && count($post) > 0)
								<div class="ac-post-block account-box">
									<h6 class="ac-page-heading">Recent Posts</h6>
									<div class="row">									
										@foreach($post as $key => $item)
											<div class="col-lg-4 col-md-6">
												<div class="deal-block recent-deals">
													<div class="deal-img">
														<a href="{{url('post/'.$item->uni_id.'/'.$item->slug)}}" title="{{$item->title}}"><img src="{{$item->image != null ? asset('images/coupon/'.$item->image) : asset('images/store/'.$item->store->image)}}" class="img-fluid" alt="Deal"></a>
													</div>
													<div class="deal-dtl">
														@if($item->is_featured == 1)
															<div class="deal-badge red-badge">Featured</div>
														@elseif($item->is_exclusive == 1)
															<div class="deal-badge green-badge">Exclusive</div>
														@endif
														<div class="deal-merchant">{{$item->store->title}}
														</div>
														<h6 class="deal-title"><a href="{{url('post/'.$item->uni_id.'/'.$item->slug)}}" title="{{$item->title}}">{{str_limit($item->title, 60)}}</a></h6>
														<div class="deal-price-block">
															<div class="row">
																<div class="col-6">
																	<div class="deal-price">
																		@if($item->price)
																			<sup><i class="{{$settings->currency}}" aria-hidden="true"></i></sup> {{$item->price}}
																			@else
																				{{$item->discount ? $item->discount."% Off" : ''}}
																			@endif
																	</div>
																	{{-- <div class="deal-disc">{{$item->discount ? $item->discount."% Off" : ''}}</div> --}}
																</div>
																<div class="col-6 text-right">
																		<div class="rating">
									                    <div class="set-rating" data-rateyo-rating="{{$item->rating>0 ? $item->rating : '0'}}"></div>
									                  </div>
																</div>
															</div>
														</div>
													</div>
													<div class="deal-footer">
														<div class="row">
															<div class="col-5">
																<div class="comments-icon">
																	<i class="far fa-comments"></i><a href="{{url('post/'.$item->uni_id.'/'.$item->slug)}}" title="Comments">{{$item->comments()->count()}}</a>
																</div>
																<div class="comments-icon">
																	<i class="fa fa-eye"></i>{{$item->views()->count()}}
																</div>
															</div>
															<div class="col-7">
																<div class="deal-user">
																	<div class="row">
																		<div class="col-4">
																			<div class="user-img">
																				<a href="{{url('profile/'.$item->user_id)}}" title="User"><img src="{{asset('images/user/'.$item->user->image)}}" class="img-fluid" alt="User"></a>
																			</div>
																		</div>
																		<div class="col-sm-8">
																			<div class="user-name">
																				<a href="{{url('profile/'.$item->user_id)}}" title="User">{{strtok($item->user->name,' ')}}</a>
																			</div>
																			<div class="deal-time">{{$item->created_at->diffForHumans()}}</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										@endforeach
									</div>
								</div>
							@endif
						</div>
						<div class="col-md-3">
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
@section('custom-scripts')
<script>
var urlLike = '{{ route('user.follow') }}';
var userId=null;var status=null;$("[data-follow]").on("click",function(t){var l=$(this),o=l.data("follow");status=l.text().trim(),console.log(status),$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},type:"POST",url:urlLike,data:{userId:o,status:status}}).done(function(t){"Follow"==$("#follow-btn").html()?$("#follow-btn").html("Unfollow"):$("#follow-btn").html("Follow")}).fail(function(){alert("We are facing some issues currenlty. Please try again later.")})});
</script>
@endsection 