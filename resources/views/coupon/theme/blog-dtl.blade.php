@extends('coupon.layouts.theme')
@section('main-content')
	<!-- blog -->
	<section id="blog-post" class="coupon-page-main-block blog-post-page">
		<div class="container">
			<div class="forum-page-header">
				<div class="forum-page-heading-block">
					<h5 class="forum-page-heading">{{$blog->title}}</h5>
				</div>
			</div>
			<!-- breadcrumb -->
			<div id="breadcrumb" class="breadcrumb-main-block">
				<div class="breadcrumb-block">
					<ol class="breadcrumb">
						<li><a href="{{url('/')}}" title="Home">Home</a></li>
						<li><a href="{{url('blog')}}" title="Blog">Blog</a></li>
						<li class="active">{{$blog->title}}</li>
					</ol>
				</div>
			</div>
			<!-- breadcrumb end -->
			<div class="account-page blog-single">
				<div class="blog-page-outer">
					<div class="row">
						<div class="col-lg-9 col-md-8">
							<div class="blog-page-main-block">
								<div class="blog-post-main">
									<div class="blog-img">
										<img src="{{asset('images/blog/'.$blog->image)}}" class="img-fluid" alt="Blog Post">
									</div>
									<div class="blog-post-dtl">
										<div class="blog-post-tags">
											<ul>
												<li><i class="far fa-clock"></i>{{date('d F Y', strtotime($blog->created_at))}}</li>
												<li><i class="far fa-user"></i><a href="{{url('profile/'.$blog->users->id)}}" title="{{$blog->users->name}}">{{$blog->users->name}}</a></li>
												<li><i class="far fa-comments"></i>{{$blog->comments()->count()}}</li>
											</ul>
										</div>
										<div class="blog-post-text">
											{!!$blog->desc!!}
										</div>
										<div class="blog-post-footer">
											<div class="row">
												<div class="col-lg-6">
										  		@php														
														$facebook = Share::load(url()->current(), 'Sharing')->facebook();
														$twitter = Share::load(url()->current(), 'Sharing')->twitter();
														$gplus = Share::load(url()->current(), 'Sharing')->gplus();
														$linkedin = Share::load(url()->current(), 'Sharing')->linkedin();
														$pinterest = Share::load(url()->current(), 'Sharing')->pinterest();
													@endphp
													<div class="social-icon blog-page">
														<ul>
															<li><a class="facebook-icon" href="{{$facebook}}"><i class="fab fa-facebook-f"></i></a></li>
													    <li><a class="google-icon" href="{{$gplus}}"><i class="fab fa-google-plus"></i></a></li>
													    <li><a class="twitter-icon" href="{{$twitter}}"><i class="fab fa-twitter"></i></a></li>
													    <li><a class="pinterest-icon" href="{{$pinterest}}"><i class="fab fa-pinterest"></i></a></li>
													    <li><a class="linkedin-icon" href="{{$linkedin}}"><i class="fab fa-linkedin"></i></a></li>
														</ul>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="blog-single-post-tags">
														<ul>
															<li><a href="{{url('deal')}}" class="btn btn-primary" title="Deals">Deals</a></li>
															<li><a href="{{url('coupon')}}" class="btn btn-primary" title="Coupons">Coupons</a></li>
															<li><a href="{{'discussion'}}" class="btn btn-primary" title="discussion">Discussion</a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="blog-post-author">
								<div class="row">
									<div class="col-lg-2">
										<div class="blog-post-author-img">
											<img src="{{asset('images/user/'.$blog->users->image)}}" class="img-fluid" alt="Author">
										</div>
									</div>
									<div class="col-lg-10">
										<h6 class="author-name">{{$blog->users->name}}</h6>
										<div class="author-dtl">{{str_limit($blog->users->brief, 280)}}</div>
									</div>
								</div>
							</div>
							@if(isset($prev) || isset($next))
								<div class="blog-next-pre">
									<div class="row">
										<div class="col-6">
											@if ($prev != Null)
												<div class="next-pre-link"><a href="{{url('blog/'.$prev->uni_id.'/'.$prev->slug)}}" title="Amazing Deals Sale"><i class="fas fa-long-arrow-alt-left"></i>{{str_limit($prev->title,50)}}</a></div>
												</div>
											@endif
										</div>
										<div class="col-6">
											@if ($next != Null)	
												<div class="next-link text-right">
													<div class="next-pre-link"><a href="{{url('blog/'.$next->uni_id.'/'.$nect->slug)}}" title="Black Friday Sale">{{str_limit($next->title,50)}} <i class="fas fa-long-arrow-alt-right"></i></a></div>
												</div>
											@endif
										</div>
									</div>
								</div>
							@endif
							@if(isset($comments) && count($comments)>0)
								<div class="blog-comment">
									<h6 class="comments-heading">Comments</h6>
									@foreach($comments as $comment)
										<div class="media">
											<div class="media-left mr-3">
												<a href="{{url('profile/'.$comment->user_id)}}" title="{{$comment->users->is_admin ? 'Admin' : 'User'}}"><img src="{{asset('images/user/'.$comment->users->image)}}" class="img-fluid media-object" alt="Admin"></a>
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
													@include('theme.childcomment', ['comments' => $comment->replies])
												@endif
											</div>
										</div>
									@endforeach
								</div>
							@endif
							<div class="blog-comment-send">
								<h6 class="comments-heading">Leave A Comment</h6>
								<div class="row">
									<div class="col-lg-2">
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
													{!! Form::open(['method' => 'POST', 'action' => 'UserDashboardController@comment_store', 'class' => 'post-reply-form']) !!}
														<input type="hidden" value="{{ $blog->id }}" name="postid">
														<input type="hidden" value="blog" name="posttype">
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
															<input type="hidden" value="{{ $blog->id }}" name="postid">
															<input type="hidden" value="blog" name="posttype">
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
							{{ $comments->links() }}
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
	</section>
	<!-- end blog -->
@endsection
@section('custom-scripts')
<script>
$("body").on("click",".submitComment",function(){$(this).val();if(""==$("#summernote-main").val())alert("Please write a Comment First!");});
$("body").on("click",".submit-comment",function(){$(this).val();if(""==$("#summernote").val())alert("Please write a Comment First!");});
</script>	
@endsection 