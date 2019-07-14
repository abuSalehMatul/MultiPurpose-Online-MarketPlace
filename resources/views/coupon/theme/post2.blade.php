@extends('coupon.layouts.theme')
@section('main-content')
	<!-- post -->
	<section id="forum-post" class="forum-post-main-block">
		<div class="container">
			<div class="forum-page-header">
				<div class="forum-page-heading-block">
					<h5 class="forum-page-heading">{{$post->title}}</h5>
				</div>
			</div>
			<!-- breadcrumb -->
			<div id="breadcrumb" class="breadcrumb-main-block">
				<div class="breadcrumb-block">
					<ol class="breadcrumb">
	          <li><a href="{{url('/')}}" title="Home">Home</a></li>
	          <li><a href="{{url('forum')}}" title="Forums">Forums</a></li>
	          <li><a href="{{url('forum-dtl/'.$post->forumcategory->slug)}}" title="Forums">{{$post->forumcategory->title}}</a></li>
	          <li class="active">{{$post->title}}</li>
					</ol>
				</div>
			</div>
			<!-- breadcrumb end -->
			<div class="post-block">
				<div class="post-body-main">
					<div class="post-body-outer">
						<div class="post-body-block">
							<div class="row">
								<div class="col-md-4">
									<div class="post-body-block-logo">
										@if($post->type == 'c' || $post->type == 'd')
											<img src="{{$post->image != null ? asset('coupon/images/coupon/'.$post->image) : asset('coupon/images/store/'.$post->store->image)}}" class="img-fluid" alt="Deal">
										@else
											<img src="{{asset('coupon/images/discussion/'.$post->image)}}" class="img-fluid" alt="Discussion">
										@endif
									</div>
								</div>
								<div class="col-md-8">
									<div class="post-body post-first">
										@php														
											$facebook = Share::load(url('post/'.$post->uni_id.'/'.$post->slug), 'Sharing')->facebook();
											$twitter = Share::load(url('post/'.$post->uni_id.'/'.$post->slug), 'Sharing')->twitter();
											$gplus = Share::load(url('post/'.$post->uni_id.'/'.$post->slug), 'Sharing')->gplus();
											$linkedin = Share::load(url('post/'.$post->uni_id.'/'.$post->slug), 'Sharing')->linkedin();
											$pinterest = Share::load(url('post/'.$post->uni_id.'/'.$post->slug), 'Sharing')->pinterest();
										@endphp
										<div class="post-body-content">
											<h5 class="page-block-heading">{{$post->title}}</h5>
											<div class="post-dtl">
												<ul>
													<li><i class="far fa-user"></i>{{$post->user->name}}</li>
													<li><i class="far fa-clock"></i>Posted {{$post->created_at->diffforhumans()}}</li>
												</ul>
											</div>
				      				<div class="rating">
		                    <div class="set-rating" data-rateyo-rating="{{$post->rating>0 ? $post->rating : '0'}}"></div>
		                  </div>
											<div class="social-icon">
												<ul>
													<li><a class="facebook-icon" href="{{$facebook}}"><i class="fab fa-facebook-f"></i></a></li>
											    <li><a class="google-icon" href="{{$gplus}}"><i class="fab fa-google-plus"></i></a></li>
											    <li><a class="twitter-icon" href="{{$twitter}}"><i class="fab fa-twitter"></i></a></li>
											    <li><a class="pinterest-icon" href="{{$pinterest}}"><i class="fab fa-pinterest"></i></a></li>
											    <li><a class="linkedin-icon" href="{{$linkedin}}"><i class="fab fa-linkedin"></i></a></li>
												</ul>
											</div>
											<div class="row post-main-footer">
												<div class="col-lg-6">
				                  <div id="like-btn" class="post-like-btn">
				                  	@auth
															<a href="#" class="{{ $post->isLiked == 1 ? 'active' : null }}" data-like="{{ $post->id }}" data-type="{{ $post->type ? $post->type : 'g' }}" title="like"><i class="far fa-thumbs-up clr-green"></i></a>
															<a href="#" class="{{ $post->isLiked == -1 ? 'active' : '' }}" data-like="{{ $post->id }}" data-type="{{ $post->type ? $post->type : 'g' }}" title="unlike"><i class="far fa-thumbs-down clr-orange"></i></a>
														@else	
															<a href="#" data-toggle="modal" data-target="#login" title="like"><i class="far fa-thumbs-up clr-green"></i></a>
															<a href="#" data-toggle="modal" data-target="#login" title="unlike"><i class="far fa-thumbs-down clr-orange"></i></a>
														@endauth
													</div>
												</div>
												@if($post->type == 'd' || $post->type == 'c')
													<div class="col-lg-6">
														<div class="deal-price text-center">
															@if($post->price)
																<sup><i class="{{$settings->currency}}" aria-hidden="true"></i></sup> {{$post->price}}
															@endif
														</div>
														{{-- <div class="deal-disc text-center">{{$post->discount ? $post->discount."% Off" : ''}}</div> --}}
														<div class="grab-coupon-btn">
															@if($post->type == 'd')
																<a href="#" class="btn btn-primary" title="Get Coupon" data-toggle="modal" data-target="#coupon-id-1">Grab Coupon</a>
															@else
																<a href="{{$post->link != Null ? $post->link : $post->store->link}}" title="{{$post->store->title}}" target="_blank" data-id="{{$post->id}}" class="grab-now btn btn-primary">Grab Deal</a>
															@endif
														</div>
													</div>
													<div class="coupon-popup">
														<div class="modal fade login-form-main" id="coupon-id-1" tabindex="-1" role="dialog" aria-labelledby="CouponTitle1" aria-hidden="true">
															<div class="modal-dialog modal-dialog-centered" role="document">
																<div class="modal-content text-center">
																	<div class="login-header">
																		<h5 class="login-title" id="CouponTitle1">Coupon Detail</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true" class="close-btn">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div class="coupon-popup-dtl">
																			<div class="coupon-popup-header">
																				<h6 class="coupon-popup-title">Copy below code and visit store</h6>
																			</div>
																			<div class="coupon-code">
																				<div class="row no-gutters">
																					<div class="col-md-8">
																						<div class="coupon-code-outer">
																							<h4 id="cpn-1" class="coupon-txt">{{$post->code}}</h4>
																						</div>
																					</div>
																					<div class="col-md-4">
																						<div class="coupon-cpy-btn">
																							<button class="btn btn-primary" title="Copy Coupon Code" data-clipboard-target="#cpn-1">Copy Code</button>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="coupon-popup-btn">
												      				<a href="{{$post->link != Null ? $post->link : $post->store->link}}" title="{{$post->store->title}}" target="_blank" data-id="{{$post->id}}" class="grab-now btn btn-primary">Visit Store</a>
																		</div>
																		<div class="coupon-footer">
																			<div class="coupon-footer-dtl">
																				<ul>
																					<li>
																						@if($post->is_verified == 1)
																							<i class="fas fa-check clr-green"></i>Verified Coupon
																						@else
																							Unverified
																						@endif
																					</li>
																					<li><i class="fas fa-shopping-cart clr-orange"></i><a href="{{url('store-dtl/'.$post->store->slug)}}" title="{{$post->store->title}}">{{$post->store->title}}</a></li>
																					<li><i class="fas fa-users clr-purple"></i>{{$post->user_count}} People Used</li>
																					<li class="share-button sharer clr-blue"><i class="fas fa-share-alt clr-blue"></i><a class="share-btn" title="Share Coupon">Share Coupon</a>
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
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="post-block">
				<div class="post-body-main">
					<div class="post-body-outer">
						<div class="post-body-block">
							<div class="row">
								<div class="col-lg-8">
									<div class="post-body">
										<div class="post-body-content">
											<h5 class="page-block-heading">About {{$post->type == 'c' ? 'Coupon' : $post->type == 'd' ? 'Deal' : 'Discussion'}}</h5>
											{!! $post->detail !!}
										</div>
									</div>
								</div>
								@if($post->type == 'c' || $post->type == 'd')
									<div class="col-lg-4 text-center">
										<div class="post-body-block-logo">
											<a href="#" title="{{$post->store->title}}" target="_blank"><img src="{{asset('coupon/images/store/'.$post->store->image)}}" class="img-fluid" alt="Brand"></a>
										</div>                           
										<div class="post-brand-content">
											<h6 class="page-block-heading">{{$post->store->title}}</h6>
											<a href="{{$post->store->link}}" title="{{$post->store->title}}" target="_blank" class="btn btn-primary">Visit Store</a>
										</div>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
			@if(isset($comments) && count($comments) > 0)
				<div class="post-block">
					<div class="post-body-main">
						<div class="post-body-outer">
							<div class="post-body-block">
								<div class="blog-comment coupon-comment">
									<h6 class="comments-heading">Comments</h6>
									@foreach($comments as $comment)
										<div class="media">
											<div class="media-left mr-3">
												<a href="{{url('profile/'.$comment->user_id)}}" title="{{$comment->users->is_admin ? 'Admin' : 'User'}}"><img src="{{asset('coupon/images/user/'.$comment->users->image)}}" class="img-fluid media-object" alt="Admin"></a>
											</div>
											<div class="media-body">
												<h6 class="media-heading"><a href="{{url('profile/'.$comment->user_id)}}" title="{{$comment->users->name}}">{{$comment->users->name}}</a> - <span>{{$comment->created_at->diffForHumans()}}</span></h6>
												<p>{!!$comment->body!!}</p>
												@auth
													<div class="media-reply"><a class="reply-btn" data-value="{{$comment->id}}" href="#" title="Reply"><i class="fa fa-reply"></i> Reply</a></div>
												@else
													<div class="media-reply"><a class="reply-btn1" data-toggle="modal" data-target="#login" href="#" title="Reply"><i class="fa fa-reply"></i> Reply</a></div>
												@endauth
												@if($comment->replies()->count()>0)
													@include('coupon.theme.childcomment', ['comments' => $comment->replies])
												@endif
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif
			<div class="post-block">
				<div class="post-body-main">
					<div class="post-body-outer">
						<h5 class="post-reply-heading">Leave A Comment</h5>
						<div class="row">
							<div class="col-lg-2">
								<div class="post-author-img">
									@auth
										<img src="{{asset('coupon/images/user/'.$auth->image)}}" class="img-fluid" alt="{{$auth->title}}">
									@else
										<img src="{{asset('coupon/images/user/user.png')}}" class="img-fluid" alt="user-img">
									@endauth
								</div>
							</div>
							<div class="col-lg-10">
								<div class="post-body-block">
									<div class="post-body">
										<div class="post-body-content">
											{!! Form::open(['method' => 'POST', 'action' => 'UserDashboardController@comment_store', 'class' => 'post-reply-form']) !!}
												<input type="hidden" value="{{ $post->id }}" name="postid">
												<input type="hidden" value="{{ $post->type ? $post->type : 'g' }}" name="posttype">
												<input type="hidden" value="main" name="replyid">
												<div class="form-group">
													<textarea id="summernote-main" name="commenttext" class="summernote-main form-control"></textarea>
												</div>
                        @auth
													<button type="submit" class="btn btn-primary submitComment">Leave Comment</button>
												@else
													<button type="button" data-toggle="modal" data-target="#login" class="btn btn-primary">Leave Comment</button>
												@endauth
					            {!! Form::close() !!}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="review">
				<div class="post-block post-reply post-reply-form-main">
					<div class="post-body-main">
						<div class="post-body-outer">
							<div class="post-body-block">
								<div class="post-body">
								<button class="close" onclick="document.getElementById('review').style.display='none'"><i class="fa fa-close"></i></button>
									<div class="post-body-content">
										<h6 class="post-reply-heading">Leave A Comment</h6>
										{!! Form::open(['method' => 'POST', 'action' => 'UserDashboardController@comment_store', 'class' => 'post-reply-form']) !!}
											<input type="hidden" value="{{ $post->id }}" name="postid">
											<input type="hidden" value="{{ $post->type ? $post->type : 'g' }}" name="posttype">
											<input type="hidden" value="" name="replyid">
											<div class="form-group">
												<textarea id="summernote" name="commenttext" class="form-control">
												</textarea>
											</div>
											<button type="submit" class="btn btn-primary submit-comment">Leave Comment</button>
				            {!! Form::close() !!}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="forum-footer">
				<div class="row">
					<div class="col-lg-4 col-md-7">
    				{{ $comments->links() }} 
					</div>
					<div class="col-lg-3 ml-lg-auto col-md-5">
						<div class="new-topic-btn">
							<a href="{{url('submit')}}" title="Post New Topic" class="btn btn-primary">Post New Topic</a>
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
var postId=null;
var btnType=null;
var btnValue=null;
var type=null;
var urlLike='{{route('post.like')}}';
$("[data-like]").on("click",function(t){t.preventDefault();var a=$(this),e=a.data("like");btnType=a.attr("title"),btnValue=a.attr("class"),type=a.data("type"),$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},type:"POST",url:urlLike,data:{postId:e,type:type,btnType:btnType,btnValue:btnValue}}).done(function(t){console.log(t),0<t?$(".set-rating").attr("data-rateyo-rating","2"):$(".set-rating").attr("data-rateyo-rating","0"),null==btnValue||""==btnValue?a.toggleClass("active").siblings().removeClass("active"):a.removeClass("active")}).fail(function(){alert("We are facing some issues currenlty. Please try again later.")})});
</script>
<script>
$("body").on("click",".submitComment",function(){$(this).val();if(""==$("#summernote-main").val())alert("Please write a Comment First!");});

$("body").on("click",".submit-comment",function(){$(this).val();if(""==$("#summernote").val())alert("Please write a Comment First!");});
</script>	
@endsection 