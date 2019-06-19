@if(isset($results) && count($results) > 0)
	@foreach($results as $key => $item)
		@if($filter_page == '0')
			<div class="col-lg-3 col-md-4 col-sm-6">
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
		@else
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
								<div class="coupon-short-disc">
									<p>{!! substr(strip_tags($item->detail), 0, 100) !!}..</p>
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
		@endif
	@endforeach
@endif
<script>
  $(".set-rating").rateYo({
    starWidth: "18px",
    spacing: "1px",
    normalFill: "#CCCCCC",
    ratedFill: "#E8511C",
    readOnly: true
  });
</script>