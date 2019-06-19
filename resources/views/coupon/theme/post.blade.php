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
								<div class="col-md-6">
									<div class="post-body-block-logo">
										<img src="images/deals-2/deal-details.jpg" class="img-fluid" alt="Deal">
									</div>
								</div>
								<div class="col-md-6">
									<div class="post-body">
										<!-- <div class="post-time"><i class="far fa-clock"></i>Posted 6 hours ago</div> -->
										<div class="post-body-content">
											<h5 class="page-block-heading">Description</h5>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate voluptates necessitatibus hic provident repellendus, iste inventore, consectetur nam consequatur dolor ea repudiandae accusamus accusantium cum distinctio sed, earum reprehenderit minima!</p>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate voluptates necessitatibus hic provident repellendus, iste inventore.</p>
											<div class="row">
												<div class="col-lg-6">
													<div class="deal-price"><sup>$</sup>100</div>
						      				<div class="rating">
				                    <div class="set-rating" data-rateyo-rating="{{$post->rating>0 ? $post->rating : '0'}}"></div>
				                  </div>
												</div>
												<div class="col-lg-6">
													<div class="grab-coupon-btn">
														<a href="#" class="btn btn-primary" title="Get Coupon" data-toggle="modal" data-target="#coupon-id-2">Grab Deal</a>
													</div>
												</div>
												<div class="coupon-popup">
													<div class="modal fade login-form-main" id="coupon-id-2" tabindex="-1" role="dialog" aria-labelledby="CouponTitle2" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content text-center">
																<div class="login-header">
																	<h5 class="coupon-disc-title" id="CouponTitle2">Deal Detail</h5>
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
																			<a href="#" class="btn btn-primary" title="Grab Deal" target="_blank">Grab Deal</a>
																		</div>
																	</div>
																	<div class="coupon-footer coupon-modal-footer">
																		<div class="coupon-footer-dtl">
																			<ul>
																				<li><i class="fas fa-check clr-green"></i>Verified Coupon</li>
																				<li><i class="fas fa-shopping-cart clr-orange"></i><a href="#" title="Amazon">Amazon</a></li>
																				<li><i class="fas fa-users clr-purple"></i>2565 People Used</li>
																				<li><i class="fas fa-share-alt clr-blue"></i><a href="#" title="Share Coupon">Share Deal</a></li>
																			</ul>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
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
								<div class="col-lg-12">
									<div class="post-body">
										<div class="post-body-content">
											<h5 class="page-block-heading">About Deal</h5>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate voluptates necessitatibus hic provident repellendus, iste inventore, consectetur nam consequatur dolor ea repudiandae accusamus accusantium cum distinctio sed, earum reprehenderit minima!</p>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate voluptates necessitatibus hic provident repellendus, iste inventore, consectetur nam consequatur dolor ea repudiandae accusamus accusantium cum distinctio sed, earum reprehenderit minima! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis quidem excepturi, perferendis, id neque fugit quibusdam ullam ipsam numquam quia nulla similique a dignissimos accusantium obcaecati minus qui, odit culpa.</p>
											<h5 class="page-block-heading">How to use this coupons?</h5>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate voluptates necessitatibus hic provident repellendus, iste inventore, consectetur nam consequatur dolor ea repudiandae accusamus accusantium cum distinctio sed, earum reprehenderit minima!</p>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate voluptates necessitatibus hic provident repellendus, iste inventore, consectetur nam consequatur dolor ea repudiandae accusamus accusantium cum distinctio sed, earum reprehenderit minima! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis quidem excepturi, perferendis, id neque fugit quibusdam ullam ipsam numquam quia nulla similique a dignissimos accusantium obcaecati minus qui, odit culpa.</p>
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
								<div class="col-md-6">
									<div class="post-body-block-logo">
										<img src="images/deals/deal-01.jpg" class="img-fluid" alt="Deal">
									</div>
								</div>
								<div class="col-md-6">
									<div class="post-body">                                       
										<div class="post-body-content">
											<h5 class="page-block-heading">Media City</h5>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate voluptates necessitatibus hic provident repellendus, iste inventore, consectetur nam consequatur dolor ea repudiandae accusamus accusantium cum distinctio sed, earum reprehenderit minima!</p>
											<div class="row">
												<div class="col-md-6">
													<div class="post-rating">
														<ul>
															<li class="active"><i class="fas fa-star"></i></li>
															<li class="active"><i class="fas fa-star"></i></li>
															<li class="active"><i class="fas fa-star"></i></li>
															<li class="active"><i class="fas fa-star"></i></li>
															<li><i class="far fa-star"></i></li>
														</ul>
													</div>
													<br/>
													<div class="post-like-btn">
														<div class="row">
															<div class="col-xs-6">
																<a href="#" title="Like Deal"><i class="far fa-thumbs-up clr-green"></i></a>
															</div>
															<div class="col-xs-6">
																<a href="#" title="Dislike Deal"><i class="far fa-thumbs-down clr-orange"></i></a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>








									<h5 class="forum-post-title">{{$post->title}}</h5>
		      				<div class="rating">
                    <div class="set-rating" data-rateyo-rating="{{$post->rating>0 ? $post->rating : '0'}}"></div>
                  </div>
								</div>
								<div class="col-md-3 d-none d-lg-block text-right">
									<div id="like-btn" class="post-like-btn float-right">
										@auth
											<a href="#" class="{{ $post->isLiked == 1 ? 'active' : null }}" data-like="{{ $post->id }}" data-type="{{ $post->type ? $post->type : 'g' }}" title="like"><i class="far fa-thumbs-up"></i></a>
											<a href="#" class="{{ $post->isLiked == -1 ? 'active' : '' }}" data-like="{{ $post->id }}" data-type="{{ $post->type ? $post->type : 'g' }}" title="unlike"><i class="far fa-thumbs-down"></i></a>
										@else	
											<a href="#" data-toggle="modal" data-target="#login" title="like"><i class="far fa-thumbs-up"></i></a>
											<a href="#" data-toggle="modal" data-target="#login" title="unlike"><i class="far fa-thumbs-down"></i></a>
										@endauth
									</div>
								</div>
							</div>
						</div>
						<div class="post-body-main">
							<div class="post-body-outer">
								<div class="row">
									<div class="col-lg-2 border-r">
										<div class="post-author-main-block">
											<div class="post-author-block">
												<h6 class="post-author"><a href="{{url('profile/'.$post->user_id)}}" title="{{$post->user->name}}">{{$post->user->name}}</a></h6>
											</div>
											<div class="author-badge"><span>{{$post->user->is_admin == '1' ? 'Admin' : 'User'}}</span></div>
											<div class="post-author-img">
												<a href="{{url('profile/'.$post->user_id)}}" title="{{$post->user->name}}"><img src="{{asset('images/user/'.$post->user->image)}}" class="img-fluid" alt="Admin"></a>
											</div>
											<div class="post-author-footer">
												<div class="post-author-dtl">{{count($post->user->coupon)}} Posts</div>
												<div class="post-author-dtl">{{count($post->user->followers)}} Followers</div>
											</div>
										</div>
									</div>
									<div class="col-lg-10">
										<div class="post-body-block">
											<div class="row">
												<div class="{{isset($post->type) ? 'col-lg-9 border-r' : 'col-lg-12'}}">
													<div class="post-body">
														<div class="post-time"><i class="far fa-clock"></i>Posted {{$post->created_at->diffforhumans()}}</div>
														<div class="post-body-content">{{$post->detail}}
														</div>
													</div>
												</div>
												@if(isset($post->type))
													<div class="col-lg-3 text-center">
														<div class="post-deal-dtl">
															<div class="deal-img">
																<img src="{{$post->image != null ? asset('images/coupon/'.$post->image) : asset('images/store/'.$post->store->image)}}" class="img-fluid" alt="Deal">
															</div>
															<div class="post-deal-btn">
																<a href="{{$post->link != Null ? $post->link : $post->store->link}}" title="{{$post->store->title}}" target="_blank" data-id="{{$post->id}}" class="grab-now btn btn-primary">Buy Now</a>
															</div>
															<div class="post-deal-btn">
																@auth
																	<a class="btn btn-primary reply-btn" data-value="main" href="#" title="Reply">Reply</a>
																@else
																	<a class="btn btn-primary reply-btn1" data-toggle="modal" data-target="#login" href="#" title="Reply">Reply</a>
																@endauth
															</div>
															@if($post->expiry)
																<div class="post-time"><i class="far fa-clock"></i>{{\Carbon\Carbon::parse($post->expiry)->diffForHumans()}}</div>
															@endif
														</div>
													</div>
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="post-footer">
								<div class="row">
									<div class="col-lg-10 ml-lg-auto border-l">
										@auth{{-- 
											<div class="post-footer-text"><i class="fas fa-quote-right"></i><a href="#" title="Quote" class="quote-btn">Quote</a></div> --}}
											<div class="post-footer-text"><i class="fa fa-reply"></i><a class="reply-btn" data-value="main" href="#" title="Reply">Reply</a></div>
										@else{{-- 
											<div class="post-footer-text"><i class="fas fa-quote-right"></i><a href="#" data-toggle="modal" data-target="#login" title="Quote">Quote</a></div> --}}
											<div class="post-footer-text"><i class="fa fa-reply"></i><a class="reply-btn1" data-toggle="modal" data-target="#login" href="#" title="Reply">Reply</a></div>
										@endauth
							  		@php														
											$facebook = Share::load(url()->current(), 'Sharing')->facebook();
											$twitter = Share::load(url()->current(), 'Sharing')->twitter();
											$gplus = Share::load(url()->current(), 'Sharing')->gplus();
											$linkedin = Share::load(url()->current(), 'Sharing')->linkedin();
											$pinterest = Share::load(url()->current(), 'Sharing')->pinterest();
										@endphp
										<div class="post-footer-text share-button sharer"><i class="fas fa-share-alt"></i><a class="share-btn" title="Share Post">Share Post</a>
											<div class="social top center networks-5 ">
										    <a class="fbtn share facebook" href="{{$facebook}}"><i class="fa fa-facebook"></i></a> 
										    <a class="fbtn share gplus" href="{{$gplus}}"><i class="fa fa-google-plus"></i></a> 
										    <a class="fbtn share twitter" href="{{$twitter}}"><i class="fa fa-twitter"></i></a> 
										    <a class="fbtn share pinterest" href="{{$linkedin}}"><i class="fa fa-pinterest"></i></a>
										    <a class="fbtn share linkedin" href="{{$pinterest}}"><i class="fa fa-linkedin"></i></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					@if(isset($comments))
						@foreach($comments as $comment)
							<div class="post-block post-reply">
								<div class="post-body-main">
									<div class="post-body-outer">
										<div class="row">
											<div class="col-lg-2 border-r">
												<div class="post-author-main-block">
													<div class="post-author-block">
														<h6 class="post-author"><a href="{{url('profile/'.$comment->user_id)}}" title="{{$comment->users->name}}">{{$comment->users->name}}</a></h6>
													</div>
													<div class="author-badge"><span>{{$comment->users->is_admin == '1' ? 'Admin' : 'User'}}</span></div>
													<div class="post-author-img">
														<a href="{{url('profile/'.$comment->user_id)}}" title="Admin"><img src="{{asset('images/user/'.$comment->users->image)}}" class="img-fluid" alt="Admin"></a>
													</div>
													<div class="post-author-footer">
														<div class="post-author-dtl">{{count($comment->users->coupon)}} Posts</div>
														<div class="post-author-dtl">{{count($comment->users->followers)}} Followers</div>
													</div>
												</div>
											</div>
											<div class="col-lg-10">
												<div class="post-body-block">
													<div class="post-body">
														<div class="post-time"><i class="far fa-clock"></i>Posted {{$comment->created_at->diffforhumans()}}
														</div>
														<div class="post-body-content">	
															@if($comment->reply_id != null)
																<div class="blockquote">
																	<h6 class="post-author">{{$comment->replies->users->name}} <span>Wrote:</span></h6>
																	<p>{!! \Illuminate\Support\Str::words($comment->replies->body,160,'...')!!}</p>
																</div>
															@endif	
															<p>{!!$comment->body!!}</p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="post-footer">
										<div class="row">
											<div class="col-lg-10 ml-lg-auto border-l">
												@auth{{-- 
													<div class="post-footer-text"><i class="fas fa-quote-right"></i><a href="#" title="Quote" class="quote-btn" data-value="{{$comment->id}}" data-body="{{$comment->body}}" data-user="{{$comment->users->name}}">Quote</a></div> --}}
													<div class="post-footer-text"><i class="fa fa-reply"></i><a class="reply-btn" data-value="{{$comment->id}}" href="#" title="Reply">Reply</a></div>
												@else{{-- 
													<div class="post-footer-text"><i class="fas fa-quote-right"></i><a href="#" data-toggle="modal" data-target="#login" title="Quote">Quote</a></div> --}}
													<div class="post-footer-text"><i class="fa fa-reply"></i><a class="reply-btn1" data-toggle="modal" data-target="#login" href="#" title="Reply">Reply</a></div>
												@endauth
											</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					@endif
					<div id="comment_box"></div>
					<div class="post-block post-reply post-reply-form-main">
						<div class="post-body-main">
							<div class="post-body-outer">
								<div class="row">
									<div class="col-lg-2 border-r text-center">
										<div class="post-author-img">
											@auth
												<img src="{{asset('images/user/'.$auth->image)}}" class="img-fluid" alt="{{$auth->title}}">
											@else
												<img src="{{asset('images/user/user.png')}}" class="img-fluid" alt="user-img">
											@endauth
										</div>
									</div>
									<div class="col-lg-10">
										<div class="post-body-block">
											<div class="post-body">
												<div class="post-body-content">
													<h6 class="post-reply-heading">Reply to this post</h6>
													<form method="post" id="post-reply-form" name="post-reply-form" class="post-reply-form">
														<input type="hidden" value="{{ $post->id }}" name="postid">
														<input type="hidden" value="{{ $post->type ? $post->type : 'g' }}" name="posttype">
														<input type="hidden" value="main" name="replyid">
														<div class="form-group">
															<textarea id="summernote-main" name="commenttext" class="summernote-main form-control"></textarea>
														</div>
	                          @auth
															<button type="button" class="btn btn-primary submitComment" value="{{ $post->id }}">Submit Reply</button>
														@else
															<button type="button" data-toggle="modal" data-target="#login" class="btn btn-primary">Submit Reply</button>
														@endauth
							            </form>
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
												<h6 class="post-reply-heading">Write your post</h6>
												<form method="post" id="review-form" name="review-form" class="post-reply-form">
													<input type="hidden" value="{{ $post->id }}" name="postid">
													<input type="hidden" value="{{ $post->type ? $post->type : 'g' }}" name="posttype">
													<input type="hidden" value="" name="replyid">
													<div class="form-group">
														<textarea id="summernote" name="commenttext" class="form-control">
														</textarea>
													</div>
													<button type="button" class="btn btn-primary reviewComment" value="{{ $post->id }}">Submit Reply</button>
						            </form>
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
				<div class="col-lg-3 col-md-4">
					<div class="coupon-sidebar">
						@if(isset($post->type))
							<div class="page-sidebar-widget brand-widget text-center">
								<div class="brand-logo">
									<a href="#" title="{{$post->store->title}}" target="_blank"><img src="{{asset('images/store/'.$post->store->image)}}" class="img-fluid" alt="Brand"></a>
								</div>
								<div class="brand-visit-btn">
									<a href="{{$post->store->link}}" title="{{$post->store->title}}" target="_blank" class="btn btn-primary">Visit Store</a>
								</div>
							</div>
						@endif
      			@include('coupon.includes.side-bar')
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
var url1='{{route('post.write')}}';
$("body").on("click",".submitComment",function(){$(this).val();if(""==$("#summernote-main").val())alert("Please write a Comment First!");else{var e=$("#post-reply-form").serialize();$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},type:"POST",url:url1,data:e,success:function(e){console.log(e),$("#comment_box").html(e),$("#post-reply-form")[0].reset(),$("#summernote-main").summernote('reset');},error:function(e,t,o){console.log(e)}}).fail(function(){alert("We are facing some issues currenlty. Please try again later.")})}});

$("body").on("click",".reviewComment",function(){$(this).val();if($("#review").css("display","none"),""==$("#summernote").val())alert("Please write a Comment First!");else{var e=$("#review-form").serialize();$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},type:"POST",url:url1,data:e,success:function(e){console.log(e),$("#comment_box").html(e),$("#review-form")[0].reset(),$("#summernote").summernote('reset');},error:function(e,r,t){console.log(e)}}).fail(function(){alert("We are facing some issues currenlty. Please try again later.")})}});

// $('body').on('click','.quote-btn', function(){
// 	event.preventDefault();
//   var rep_id=$(this).data("value");
//   var rep_body=$(this).data("body");
//   var rep_user=$(this).data("user");
//   $("#review").toggle().css("display","block");
//   $('#review [name=replyid]').val(rep_id);
//   $('textarea[name=commenttext1]').html('hi')
// });
</script>	
@endsection 